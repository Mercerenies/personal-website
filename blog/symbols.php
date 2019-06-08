<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Blog [Javascript did Something Clever]</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet"
          href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/dark.min.css" />
    <link rel="stylesheet" type="text/css" href="post.css" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/languages/lisp.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div class="post-title">Javascript did Something Clever</div>
      <i>Posted June 4, 2018</i>
      <p>
        I just want to take a minute to acknowledge something that I
        think is quite clever in ECMAScript 6, and that's the way that
        the new <code>Symbol</code> type is used. But first, let's get
        the pedantry out of the way. If you're not feeling pedantic,
        feel free to skip this next paragraph.
      </p>
      <p>
        Yes, I know that the title is technically not fully correct.
        For the purposes of this post, I'm talking about the 6th
        edition of the ECMAScript standard, published in 2015. So it's
        not entirely, pedantically correct to say "Javascript" did
        anything, as it was the people behind the ECMAScript standard
        who came up with and implemented the idea for the things I'll
        be talking about here. I understand all of that, and I
        willfully choose to ignore it all, because the current title
        is just easier to say than "ECMAScript did something clever".
        Got it? Great! Moving on.
      </p>
      <p>
        So what I want to talk about is symbols. Prior to ES6, keys on
        an object were always strings. Even if you <em>thought</em>
        you were using a number to index a field in some object,
        internally it was being stringified. Don't believe me? If you
        have Node.js installed, try the following interactions.
      </p>
      <pre><code class="lang-javascript">
> foo = {}
{}
> foo[1] = "Numerical slot"
'Numerical slot'
> foo[1]
'Numerical slot'
> foo["1"]
'Numerical slot'
> foo
{ '1': 'Numerical slot' }
      </code></pre>
      <p>
        So internally, the number is being converted to a string. I
        belabor this point to make it clear that strings used to
        be <em>the only</em> things that could be used as field keys.
      </p>
      <p>
        But this is not so in ES6 and beyond. A new type has been
        defined, called <code>Symbol</code>. In addition to strings,
        symbols can now be used as field keys. The simplest way to
        make a symbol is to use the interning
        form: <code>Symbol.for(...)</code>
      </p>
      <pre><code class="lang-javascript">
> foo = {}
{}
> foo[1] = "Numerical slot"
'Numerical slot'
> foo[Symbol.for('1')] = "Symbolic slot"
'Symbolic slot'
> foo
{ '1': 'Numerical slot' }
> foo[Symbol.for('1')]
'Symbolic slot'
      </code></pre>
      <p>
        So now we have something that's actually
        different. <code>Symbol.for('1')</code> is a new symbol that's
        distinct from the ordinary string <code>"1"</code>. Also note
        that the symbolic field was not listed in the default
        stringification for the object.
      </p>
      <p>
        In addition to providing interned symbols, we can also make
        new ones, simply by calling <code>Symbol</code> directly.
      </p>
      <pre><code class="lang-javascript">
> sym = Symbol()
Symbol()
> sym == sym
true
> Symbol() == Symbol()
false
      </code></pre>
      <p>
        As expected on that last line, the two new symbols are
        distinct from one another. We can use these new "made-up"
        symbols as keys on objects if we want, too.
      </p>
      <pre><code class="lang-javascript">
> sym = Symbol()
Symbol()
> foo = {}
{}
> foo[sym] = 10
10
> foo[sym]
10
      </code></pre>
      <p>
        While this particular feature may not be immediately intuitive
        or familiar to a lot of programmers, it's not new to the
        field. Common Lisp has had a similar construct for awhile,
        under the name <code>gensym</code>, a function which produces
        a brand new symbol.
      </p>
      <pre><code class="lang-lisp">
[1]> (gensym)
#:G7193
[2]> (eq (gensym) (gensym))
NIL
[3]> (let ((foo (gensym))) (eq foo foo))
T
      </code></pre>
      <p>
        Okay, admittedly, that may look a bit terrifying to
        non-Lispers, but we basically did the same thing here that we
        just did in Javascript. <code>gensym</code> makes a new
        symbol. Two distinct <code>gensym</code>'d symbols compare
        unequal, but the same symbol always compares equal to
        itself.<sup>1</sup>
      </p>
      <p>
        So we have symbols, and we have a way of making new, made-up
        symbols. Like I said, Lisp did all that 40 years ago. No, the
        truly clever thing is how Javascript uses these symbols.
      </p>
      <p>
        To frame the problem, let's say we want to make some objects
        iterable. In a lot of languages, this is done by, say,
        implementing some <code>Iterable</code> interface and writing
        an <code>iterator()</code> method. Well, Javascript doesn't
        have interfaces, so we'll cut out the middle man and just
        have <code>iterator()</code>.
      </p>
      <p>
        The problem with this in Javascript is that people frequently
        do funny things with objects. Since objects are basically
        glorified dictionaries, people are often inclined to use
        them <em>as</em> dictionaries. Maybe I'm using an object to
        store all of the players in my new revolutionary MMO, and I
        use the player's last name as the key.
      </p>
      <pre><code class="lang-javascript">
> foo
{ smith: ..., banks: ..., 'ward-sachs': ... }
      </code></pre>
      <p>
        This is all fine and good, but what happens when my good
        friend Johnny Iterator shows up to try out my game?
      </p>
      <pre><code class="lang-javascript">
> foo
{ smith: ..., banks: ..., 'ward-sachs': ..., iterator: ... }
      </code></pre>
      <p>
        Uh-oh! Now my fancy database is iterable, and my poor friend
        Johnny has been resigned to iterating over it. If we ever try
        to use <code>for ... of</code> on my object, it'll behave very
        strangely. This goes double if I already had a method
        named <code>iterator</code> which actually produced an
        iterator, and then Johnny came along and overwrote it with his
        last name.
      </p>
      <p>
        So we can't use strings. If only we had some way of making up
        new symbols that nobody else was using... Well, that's exactly
        what ES6 does. There are several "special" symbols (the formal
        term is "well-known symbols", but I'm still having trouble
        taking that term seriously as an official notion), one of
        which is actually <code>Symbol.iterator</code>, the symbol
        used for iterators.
      </p>
      <p>
        Now, rather than arbitrarily looking for
        an <code>iterator</code> field when we need to iterate, we can
        look specifically for <code>Symbol.iterator</code>, a made-up
        symbol. And Johnny's last name can't possibly be this symbol,
        since the Javascript runtime just now made up that symbol, and
        I'm pretty sure Johnny's last name was decided <em>before</em>
        the most recent execution of the Javascript runtime.
      </p>
      <p>
        I don't really have a ton more to say. There are several
        well-known symbols defined in ES6. A full list can be found
        on <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol#Well-known_symbols"
        target="new">MDN</a>. I think it's a really clever solution to
        the problem of namespace pollution, and I'm considering
        implementing a similar technique for certain handlers in my
        own prototype-oriented programming language.
      </p>
      <hr>
      <dl>
          <dt><sup>1</sup></dt>
          <dd>
            <code>T</code> and <code>NIL</code> are Common Lisp's way
            of saying, respectively, true and false. These values
            actually mean several things in Common Lisp and have some
            interesting philosophical implications, but that's a topic
            for another post.
          </dd>
      </dl>
      <a href="../blog.php">[back to blog index]</a>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
