<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Blog [Woes of Argument Order]</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet"
          href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/dark.min.css" />
    <link rel="stylesheet" type="text/css" href="post.css" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/languages/haskell.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/languages/scala.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div class="post-title">Woes of Argument Order</div>
      <i>Posted December 22, 2016</i>
      <p>
        Here's a qualm I've had for a little while with argument order: in a lot of cases, it's
        fairly arbitrary. For example, consider the following small chunk of code.
      </p>
      <pre><code class="lang-java">
Block block = world.getBlockAt(10, 0, 7);
JOptionPane.showConfirmDialog(null,
                              "Obliterate the " + block + "?",
                              "Message",
                              JOptionPane.INFORMATION_MESSAGE,
                              JOptionPane.YES_NO_OPTION);
      </code></pre>
      <p>
        In the first line, we get a block from some world. The argument order here actually makes quite a bit
        of sense. We can intuitively assume that the 10 is the x-coordinate, the 0 is the y-coordinate, and
        the 7 is the z-coordinate, since pretty much any sane programmer will write coordinates as (X, Y, Z).
        The second is a bit fuzzier. The first argument is a <code>null</code>, which carries a whole different
        set of problems which I'm sure I'll discuss in the future. The second and third are parts of the message.
        It makes a certain amount of sense to have the message text come first, as it's arguably more important
        than the message title. Then the final two arguments are the option type and the message type. Now,
        when I run this code (with a dummy block value, of course), I see the following message pop up.
      </p>
      <img src="argorder_0.png" />
      <p>
        Hm... that's quite odd. Clearly, I told it to show me an information message with a "Yes" and a "No"
        option, but this looks like an error message with a "Yes", "No", and "Cancel" option. The keen Java
        coder might have already noticed my mistake. I transposed the final two arguments; the option type
        is supposed to come before the message type. And this illustrates the issue that I'm bringing up.
        The argument order is arbitrary here (there's no theoretical or practical reason that one should
        come before the other), and I slipped up and put the arguments in the wrong order. The type system
        didn't catch it, the compiler didn't catch it, the runtime didn't catch it, and more than likely
        most of the people reading this page didn't catch it.
      </p>
      <p>
        Now, a solution to this problem has existed for quite a while now. It's called
        <a href="https://en.wikipedia.org/wiki/Named_parameter" target="new">named parameters</a>,
        a concept that originated a long time ago in the land of Lisp and has since propogated to
        several more modern languages including Python, Ruby (since 2.0), C# (since 2010), and Scala.
        So let's break down how good the support is in these languages for named arguments. Specifically,
        we'll be looking at how early errors are caught.
      </p>
      <p>
        We'll start with the dynamic languages. Ruby has fairly recent (since 2013, I believe) support for
        named arguments. Arguments that are intended to be referenced by name must be declared so, creating
        a distinction between "positional" and "named" arguments.
      </p>
      <pre><code class="lang-ruby">
def speak(speaker, sound:, volume: 10.0)
  ...
end
      </code></pre>
      <p>
        This defines a method <code>speak</code> which takes a positional argument, followed by two named
        arguments. The first is required and the second has a default value. It could be called as follows.
      </p>
      <pre><code class="lang-ruby">
speak(cow, sound: "Moo")
speak(loudCow, sound: "Moo", volume: 100.0)
speak(backwardCow, volume: 3.0, sound: "Moo")
speak(confusedCow, volume: 1.0) # This line will cause a runtime error
      </code></pre>
      <p>
        A couple of things of interest here. The first example shows that the <code>volume:</code> argument
        is not required. The second and third examples show that the argument order becomes irrelevant with
        named arguments. That is, since the arguments are associated with their name rather than their position,
        the order you pass them in no longer matters. Finally, the fourth argument shows that named arguments
        can still be made to be required by leaving a trailing colon in the definition. Pretty much any possible
        confusion about arguments will be caught and made into a runtime error, rather than slipping through
        like that <code>JOptionPane</code> error earlier.
      </p>
      <p>
        Python's named argument support is fairly similar to Ruby's, with a bit of a different syntax.
      </p>
      <pre><code class="lang-python">
def speak(speaker, *, sound, volume = 10.0):
    ...
      </code></pre>
      <p>
        The asterisk in the middle separates the named arguments from the positional arguments. Other than
        that, the semantic support is fairly similar, with the one added benefit that Python, unlike Ruby,
        will allow you to refer to even the positional arguments by name. So we could feasibly call
        <code>speak</code> as follows.
      </p>
      <pre><code class="lang-python">
speak(speaker = namedCow, sound = "Moo")
      </code></pre>
      <p>
        The equivalent line of Ruby code would fail.
      </p>
      <p>
        Now, with dynamic languages like Ruby and Python, the best we can really hope for is a runtime error.
        So let's move on to the static languages. C# and Scala both have fairly basic support for named
        arguments. That is, the caller of a method can choose to call it with named arguments, but there is
        no way to force the caller to do so.
      </p>
      <pre><code class="lang-scala">
def speak(speaker: Animal, sound: String, volume: Double = 10.0): Unit = {
  ...
}
speak(speaker = scalaFlavoredCow, sound = "Moo") // This works
speak(scalaFlavoredCow, "Moo") // But so does this
      </code></pre>
      <p>
        This is a nice improvement over only allowing positional arguments, but it's still not optimal. It would
        be nice if library writers could declare certain arguments as named so that they cannot be called
        positionally. Sure, in our speaking cow example, it's fairly obvious what each argument does, and since
        each argument has a distinct type the type system should catch any glaring problems with argument order.
        So let's make a more difficult function.
      </p>
      <pre><code class="lang-scala">
def drawHealth(width: Double, height: Double, healthPerLine: Double): Unit = {
  ...
}
      </code></pre>
      <p>
        There, that's a bit trickier. We have some healthbar object in a computer game, and it's draw
        method take width and height arguments, as well as an argument specifying how much health to
        draw per line. Now, a careful Scala coder might go ahead and call this with named arguments
        to ensure that everything goes smoothly, but if some other coder comes along later and is in
        a hurry, he or she might use the positional form. Since it's obvious that the argument order
        here could be easily confused, we would like a way to force the user to think about the argument
        order to avoid little mistakes like that.
      </p>
      <p>
        To this end, I'm going to leap over to Haskell now. We'll go back to Scala and adapt the same ideas
        there in a minute, but the fact is that the solution I'm going to present is actually almost trivial
        in Haskell. Now, Haskell has zero support for named arguments at all, but it does have something really
        nice: newtypes. No, I didn't forget a space there; the keyword to create one is <code>newtype</code>.
      </p>
      <pre><code class="lang-haskell">
newtype Index = Index Int
      </code></pre>
      <p>
        This defines a new type called <code>Index</code> which contains an integer and nothing else. Values
        within this type can be created using the named <code>Index</code> and extracted using
        pattern matching (we could have used a longer form syntax which defines an accessor function for
        extraction, but there are many cases where that's overkill). Fairly boring so far, but the neat
        thing here is that when a type is declared with <code>newtype</code> (as opposed to the more
        powerful <code>data</code> keyword), it will be completely stripped away at compile time. That means
        that while the type checker will treat <code>Index</code> as a distinct type, the compiler will strip
        away that extra layer, removing any runtime overhead associated with packing and unpacking this type.
        So we have a way to define new types which carry no runtime overhead. How can we use that to solve our
        argument order problem?
      </p>
      <pre><code class="lang-haskell">
drawHealth :: Double -> Double -> Double -> IO ()
drawHealth width height healthPerLine = ...

-- To call:
drawHealth 200 200 100
      </code></pre>
      <p>
        This is our <code>drawHealth</code> method from Scala, translated into a Haskell function. Now let's
        try using a newtype to eliminate some of these argument ambiguities.
      </p>
      <pre><code class="lang-haskell">
newtype PerLine = PerLine Double

drawHealth :: Double -> Double -> PerLine -> IO ()
drawHealth width height (PerLine healthPerLine) = ...

-- To call:
drawHealth 200 200 (PerLine 100)
      </code></pre>
      <p>
        A couple of things to note here. First off, when calling the function, we actually had to acknowledge
        that we knew the third argument was the "health per line" argument. Had we messed up and tried to
        pass it in as the first argument, a type error would have been triggered, since <code>PerLine</code>
        and <code>Double</code> are in fact distinct types. Second, the pattern matching in the
        <code>drawHealth</code> implementation immediately extracts the actual <code>Double</code> value
        out of the newtype so we don't have to worry about accessing it.
      </p>
      <p>
        What we've gained here is some security at the type level against user mistakes when passing in
        arguments. And all it cost us was one additional line of code at the top; there's no runtime overhead
        and access into the newtype is trivial. Now, let's look back at Scala. In Scala, we can get very close
        to the benefits of newtypes, including the lack of runtime overhead. So let's start by defining a new
        class in Scala, similar to the newtype we defined in Haskell.
      </p>
      <pre><code class="lang-scala">
class PerLine(val value: Double)

def drawHealth(width: Double, height: Double, healthPerLine: PerLine): Unit = {
  ...
}

// To call:
drawHealth(200, 200, new PerLine(100))
      </code></pre>
      <p>
        Ehhh... that's not too pretty. It's quite clear we're constructing an object here, and <code>PerLine</code>
        makes very little sense as an object in a traditional OOP sense. Fortunately, Scala has a way of hiding
        this fact. In Scala, you can declare a class to be a "case class", which changes a few of the rules so
        that the class behaves more like a functional data type.
      </p>
      <pre><code class="lang-scala">
case class PerLine(value: Double)

def drawHealth(width: Double, height: Double, healthPerLine: PerLine): Unit = {
  ...
}

// To call:
drawHealth(200, 200, PerLine(100))
      </code></pre>
      <p>
        Okay... better. We don't have that "new" declaration reminding us that we're using an object allocation
        to do this. But internally, this is still basically the same thing. However, the Scala developers clearly
        knew their Haskell, because Scala 2.10 introduced the idea of value classes, which are very close to
        newtypes. A value class has a single immutable datatype within it and can be compiled away (except in
        certain special circumstances) into the underlying type so that the JVM doesn't have to allocate an
        object.
      </p>
      <pre><code class="lang-scala">
case class PerLine(value: Double) extends AnyVal

def drawHealth(width: Double, height: Double, healthPerLine: PerLine): Unit = {
  ...
}

// To call:
drawHealth(200, 200, PerLine(100))
      </code></pre>
      <p>
        There. Now we have no runtime overhead when we construct that <code>PerLine</code> instance. The only
        downside is that we'll still have to refer to our underlying <code>Double</code> as
        <code>healthPerLine.value</code>. There's no easy way around this. We could try to cleverly place an
        implicit conversion somewhere inside the method so that we can pretend it's a <code>Double</code>, but
        the easiest solution is also the simplest one.
      </p>
      <pre><code class="lang-scala">
case class PerLine(value: Double) extends AnyVal

def drawHealth(width: Double, height: Double, _healthPerLine: PerLine): Unit = {
  val PerLine(healthPerLine) = _healthPerLine
  ...
}
      </code></pre>
      <p>
        One extra line, and now we don't have to worry about the wrapper class inside the method.
      </p>
      <p>
        Now, you can get a similar effect in C++ with little to no runtime overhead using a minimal struct.
        In Java and C#, you're going to have a harder time since everything tends to be thrown onto the heap.
        My point is this, though. Type systems are powerful things. You can convince your type system to
        check your argument order and a lot of other things. Too many programmers who come from C or C# or
        Java underestimate the power of a proper type system like that of Haskell or Scala (C++ also has a
        very powerful type system in this sense, but it's also unwieldy at times). So use your types to
        document your values, and you'll be amazed at how self-documenting they can be.
      </p>
      <a href="../blog.php">[back to blog index]</a>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
