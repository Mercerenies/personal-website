<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Projects</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="../lib/jquery.min.js">
    </script>
    <script src="js/projects.js">
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <?php include('private/new_site_notice.php'); ?>
      These are the projects that I'm currently working on or thinking
      about. Click any of them for details. Note that, for unfinished
      projects, the names listed here are arbitrary code names that I
      give them; I very seldom name my projects until I'm almost
      finished with them.<br/><br/>

      Finally, note that I do not list completed <em>video game
      projects</em> here, as they have <a href="games.php">their own
      page</a>.

      <p><b>Active projects:</b></p>

      <div class="project-header" onclick="window.doShow('proto-project')">
        Latitude (Released!)
      </div>
      <div id="proto-project" class="project-contents">
        <img class="thumbnail" src="img/proto.png" />
        <div class="project-text">
          Latitude is a language that I have been working on more
          recently in an attempt to fill what I see as a hole in the
          programming community. Namely, that all prototype-oriented
          languages either feel incomplete (Io) or have their
          prototyping features shunned by many (Javascript). Latitude
          can currently be found on
          <a href="https://github.com/Mercerenies/proto-lang"
          target="new">GitHub</a>. <br/><br/>

          In addition to prototypes, Latitude supports many other
          powerful facilities, such as first-class continuations and
          scope objects which allow for unique metaprogramming
          opportunities. Latitude is officially released as of Aug 11,
          2018 and is available for general use.
        </div>
      </div>

      <p><b>Inactive Projects:</b></p>

      <div class="project-header" onclick="window.doShow('net-project')">
        Net Game
      </div>
      <div id="net-project" class="project-contents">
        <img class="thumbnail" src="img/net.png" />
        <div class="project-text">
          A slightly more esoteric idea that's been bouncing around in
          my head. This game doubles as an AI as it creates a
          text-based world based on real-world data gathered from the
          Internet. As the player completes quests, the game gathers
          more real-world information and creates new quests and a
          bigger world to explore. <br/><br/>

          The goal of this project is actually two-fold. The first
          goal is to create an autonomous game that can create and
          facilitate its own text-based adventure game without any
          developer intervention. The second is more personal: I am
          trying to develop this project in several different
          programming languages to learn how they communicate with one
          another. While this isn't overly useful in practice, it is
          an interesting academic endeavor to see how these languages
          interact. Currently, the game uses Python to browse the web,
          Perl to parse the results, Ruby to generate the world,
          Common Lisp to manage the gameplay, Lua as a backend server
          to delegate tasks, and Bash as the glue between languages.
          <br/><br/>

          While the source code for this project is currently
          <a target="new"
          href="https://github.com/Mercerenies/net-game">available</a>,
          I would caution visitors that the dependency list (available
          in the readme and the provided check script) is formidable.
          If you want to run this game, (especially on a Windows
          machine) be prepared to install several interpreters and
          code libraries. In the long run, I would like to make an
          option to allow the game to be run in "server" mode, which
          will allow clients to connect and play with merely a web
          browser, but for now you can install the game and run it
          locally with all of the dependencies intact.
        </div>
      </div>

      <div class="project-header" onclick="window.doShow('dem2-project')">
        Demensitis 2
      </div>
      <div id="dem2-project" class="project-contents">
        <img class="thumbnail" src="img/dem2.png" />
        <div class="project-text">
          A sequel to my text-based adventure game Demensitis.
          Demensitis 2 will feature more branching paths, a more
          interesting combat system, and the ability to move freely
          about the game world. <br/><br/>

          This is a project I've had in the back of my head for about
          a year and half now, and the story has been slowly evolving
          in my head. The story will begin in the distant future, the
          desert world visited in Part IX of the original game.
          <br/><br/>

          This is still more or less an idea in the back of my mind.
          I've made several small prototypes but haven't been thrilled
          with any of them, so I'm letting this project simmer for
          awhile longer.
        </div>
      </div>

      <div class="project-header" onclick="window.doShow('stairway-project')">
        Stairway
      </div>
      <div id="stairway-project" class="project-contents">
        <img class="thumbnail" src="img/stairway.png" />
        <div class="project-text">
          A more casual game that serves as a deconstruction of RPGs.
          Taking out the overworld and the plot and only considering
          the leveling system and the combat system, the result is a
          one-directional near-infinite track consisting of enemies,
          ways of making money, and hazards to avoid. <br/><br/>

          This is intended more as a casual project for me to work on
          when I'm tired of more complex work. Written in GameMaker,
          it will be released as either a mobile or HTML game,
          consisting of a couple of different game modes (the main
          being a no-lifelines survival playthrough) and online
          highscore tables to motivate a competitive spirit.
          <br/><br/>

          I'm currently reworking this idea in the back of my mind.
          The prototype implementation was fairly unforgiving in terms
          of losing the game, so I will probably restart this project
          once I have a better idea of how I want it to work.
        </div>
      </div>

      <div class="project-header" onclick="window.doShow('lum2-project')">
        Luminescence 2
      </div>
      <div id="lum2-project" class="project-contents">
        <img class="thumbnail" src="img/lum.jpg" />
        <div class="project-text">
          (Screenshot is from Luminescence 1) Luminescence 2 is a
          sequel to my
          game <a href="https://gamejolt.com/games/luminescence/183027"
          target="new">Luminescence</a>, which was originally written
          for a game design contest. Luminescence 2 takes the unique
          artistic style of Luminescence and explores it a bit
          further, adding some neat mechanics and level features not
          available in the original game.

          Luminescence 2 is roughly halfway done, and I plan to finish
          it when I have some spare time. For the time being, the
          project is unreleased, but you can try out the original at
          the Gamejolt link above.
        </div>
      </div>

      <p><b>Discarded Projects:</b></p>

      <div class="project-header" onclick="window.doShow('lang-project')">
        MLSP Lang
      </div>
      <div id="lang-project" class="project-contents">
        <img class="thumbnail" src="img/mlsp.png" />
        <div class="project-text">
          A programming language project I've been working on for a little while
          now. The language combines a powerful Haskell-ish type system (with
          type inference) with the syntactic freedom and sugar of Ruby. In the
          end, the language will compile to the JVM. This (very unfinished)
          project is currently available on
          <a href="https://github.com/Mercerenies/mlsp-lang"
          target="new">GitHub</a>. <br/><br/>

          One of the main selling points of this language is that it
          maintains the functional purity of Haskell in a simple way.
          Individual arguments to a function can be marked
          &quot;mutable&quot; by succeeding them with an exclamation
          mark. Any non-mutable arguments are read-only and this
          status is enforced absolutely by the language. <br/><br/>

          This project has been more or less canceled. I realized
          (after learning Scala) that a lot of the features I had
          planned for this language had already been done in a more
          refined manner with Scala. If you liked this project, I
          strongly urge you to check out
          <a href="http://www.scala-lang.org/" target="new">the Scala language</a>.
        </div>
      </div>

    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
