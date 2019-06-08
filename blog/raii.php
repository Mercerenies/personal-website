<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Blog [RAII is Just Continuations]</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet"
          href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/dark.min.css" />
    <link rel="stylesheet" type="text/css" href="post.css" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/languages/haskell.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div class="post-title">RAII is Just Continuations</div>
      <i>Posted June 8, 2019</i>
      <p>
        This post is going to be a bit heavier on the theory. If
        you're not familiar with monads in Haskell, I recommend
        <a href="http://learnyouahaskell.com/" target="new">Learn You a Haskell</a>.
        If you haven't used the continuation monad, I recommend
        <a href="http://blog.sigfpe.com/2008/12/mother-of-all-monads.html">this article</a> from
        A Neighborhood of Infinity. That's about all you should need
        for this post. We'll mention LLVM a bit for the sake of
        example, but no in-depth knowledge is involved there.
      </p>
      <p>
        Today, I found myself writing this chunk of Haskell code for a bit of
        <a href="https://hackage.haskell.org/package/llvm-hs-8.0.0/" target="new"><code>
        llvm-hs</code></a> interaction.
      </p>
      <pre><code class="lang-haskell">
handleAndOutput :: FilePath -> FilePath -> IO ()
handleAndOutput inp outp =
    handleFile inp >>= \case
      Nothing -> pure ()
      Just res -> withContext $ \ctx -> do
        withHostTargetMachine $ \tm -> do
          withModuleFromAST ctx res $ \res' -> do
            writeObjectToFile tm (File outp) res'
      </code></pre>
      <p>
        The important part for our discussion is the bottom four
        lines. I'm taking a complicated data structure from <code>llvm-hs-pure</code> and
        compiling it down to an object file. In the process, I need to
        borrow several "non-pure" data structures, in the sense that
        these are data structures controlled by a C++ library and therefore are <i>not</i> managed
        by the Haskell runtime. We see this sort of pattern a lot in
        Haskell when interacting with foreign code. The relevant type
        signatures are
      </p>
      <pre><code class="lang-haskell">
withContext :: (Context -> IO a) -> IO a
withHostTargetMachine :: (TargetMachine -> IO a) -> IO a
withModuleFromAST :: Context -> Module -> (Module -> IO a) -> IO a
      </code></pre>
      <p>
        So, once we've applied the first couple of arguments to <code>withModuleFromAST</code>
        the pattern seems to be
      </p>
      <pre><code class="lang-haskell">
withSomething :: (thing -> IO a) -> IO a
      </code></pre>
      <p>
        Each of these has the same behavior. They open or allocate
        some resource, run the function argument, then close the
        resource. Like I said, we see this pattern a lot when
        interfacing with things outside the Haskell runtime. <code>System.IO</code> provides
        <a href="https://hackage.haskell.org/package/base-4.12.0.0/docs/System-IO.html#v:withFile"
        target="new"><code>withFile</code></a>, which opens a file,
        runs some code, and closes the file at the end. <code>Foreign.C.String</code> provides
        <a href="https://hackage.haskell.org/package/base-4.12.0.0/docs/Foreign-C-String.html#v:withCString"
        target="new"><code>withCString</code></a>, which marshalls a
        Haskell string into a C string and frees the memory at the
        end.
      </p>
      <p>
        This pattern isn't even unique to Haskell. Python's <code>with</code> statements
        follow the same pattern: run some entry code, do some stuff,
        then run some exit code. But both of these constructs suffer
        from a similar problem, which my first code snippet exhibits.
        If I need to borrow several resources in succession (a task
        not uncommon when interacting with foreign code), then I'm
        going to naturally end up nested several layers deep.
      </p>
      <p>
        Now, C++ and Rust actually have a solution to this nesting
        problem. In C++ and Rust, we can simply make local variables
        which allocate resources and trust that deallocation will
        happen on time as soon as the local goes out of scope. This
        pattern is called
        <a href="https://en.wikipedia.org/wiki/Resource_acquisition_is_initialization" target="new">Resource
        Acquisition is Initialization</a>, or RAII for short. The C++
        code equivalent to my Haskell code from before might look
        something like this.
      </p>
      <pre><code class="lang-c++">
// This is example code; this is NOT compatible with the LLVM C++ library
void handle_and_output(string in, string out) {
  auto res = handle_file(in);
  Context ctx {};
  TargetMachine tm { get_host_target_machine() };
  Module m = module_from_ast(ctx, res);
  write_object_to_file(tm, out, m);
}
      </code></pre>
      <p>
        Compare that to what we started with in Haskell.
      </p>
      <pre><code class="lang-haskell">
handleAndOutput :: FilePath -> FilePath -> IO ()
handleAndOutput inp outp =
    handleFile inp >>= \case
      Nothing -> pure ()
      Just res -> withContext $ \ctx -> do
        withHostTargetMachine $ \tm -> do
          withModuleFromAST ctx res $ \res' -> do
            writeObjectToFile tm (File outp) res'
      </code></pre>
      <p>
        Note how, in the C++ example, I simply allocate the resources
        and trust that they'll go out of scope at the end. There's no
        increase in nesting, and we're not creeping over to the right
        side of the screen. It sure would be nice if we could do this
        in Haskell.
      </p>
      <pre><code class="lang-haskell">
-- Not going to compile yet, obviously.
handleAndOutputCont :: FilePath -> FilePath -> ContT r IO ()
handleAndOutputCont inp outp =
    handleFile inp >>= \case
      Nothing -> pure ()
      Just res -> block $ do
        ctx <- withContext
        tm <- withHostTargetMachine
        res' <- withModuleFromAST ctx res
        liftIO $ writeObjectToFile tm (File outp) res'
      </code></pre>
      <p>
        In our totally hypothetical example here, <code>block</code> is
        a function that "protects" the outer scope and frees any
        resources allocated within it. We protect the <code>writeObjectToFile</code> with
        a <code>liftIO</code> because, more than likely, we'll be
        writing our own home-baked monad to do all this.
      </p>
      <p>
        But... will we? Is there a monad that already does what we
        want to do? If you've read the title of this post, you already
        know the answer, but let's pretend you didn't and take another
        look at that type signature.
      </p>
      <pre><code class="lang-haskell">
withSomething :: (thing -> IO a) -> IO a
      </code></pre>
      <p>
        Aha! That looks like <a href="https://hackage.haskell.org/package/mtl-2.0.1.0/docs/Control-Monad-Cont.html#t:ContT" target="new">the
        continuation monad</a>.
      </p>
      <pre><code class="lang-haskell">
data ContT r m a = ContT { runContT :: (a -> m r) -> m r }
      </code></pre>
      <p>
        In fact, writing such a wrapper is almost laughably simple.
      </p>
      <pre><code class="lang-haskell">
withSomething :: (thing -> IO a) -> IO a
withSomething = -- ... Some black magic

withSomethingCont :: ContT a IO thing
withSomethingCont = ContT withSomething
      </pre></code>
      <p>
        Now, we need that <code>block</code> function from before.
        That, too, is surprisingly simple. When we want to free all of
        our resources, we just... run the continuation and unpack that
        layer of the monad stack.
      </p>
      <pre><code class="lang-haskell">
block :: Monad m => ContT r m r -> m r
block f = runContT f pure
      </code></pre>
      <p>
        Of course, you could just use <code>runContT</code> directly,
        but if you're already returning the thing you want to be
        returning, then it's simpler and arguably more readable to get
        rid of the <code>runContT</code> and replace it with a shorter
        name (in our case, since we're returning <code>()</code> the
        point is moot anyway).
      </p>
      <p>
        And that's... about all there is to it. Now the code I showed
        above where we borrow all of the resources in a monad and
        release them at the end of the block works as intended. As
        long as we're inside a <code>block</code>, we can be assured
        that the resource will be freed at the end. You can also nest <code>block</code>'s
        (though you'll end up with multiple continuations on your
        monad stack, which may be annoying if for some reason you have
        to write an explicit type signature for something inside the
        block), and since each <code>block</code> is it's own
        continuation mode, continuation tricks like <code>callCC</code> won't
        be allowed to escape the block, so you can't bypass the
        deallocation.
      </p>
      <p>
        So all of those <code>withSomething</code> functions you see
        in Haskell are really just values in the continuation monad.
        If you ever need to use several in rapid succession, consider
        operating inside the <code>ContT</code> monad and running the
        continuation at the end to free all the resources.
      </p>
      <a href="../blog.php">[back to blog index]</a>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
