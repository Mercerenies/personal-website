<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Fun</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <?php include('private/new_site_notice.php'); ?>
      <div>
        These are a few of my personal favorite puzzles and riddles, in no particular order.
      </div>

      <div>
        <b>The Guru and the Islanders</b><br/>
        <a href="http://wiki.xkcd.com/irc/Puzzles#Blue_Eyes_Puzzle" target="new">[Source]</a>
        <p>
          A collection of perfect logicians live on an island. Each of
          the logicians has an eye color. They can each see the eye
          colors of everyone else on the island but do not have any
          information about their own colors. The islanders are not
          allowed to speak to one another or communicate in any way.
        </p>
        <p>
          Every night at midnight, a ferry stops on the island. Any
          islanders who have conclusively determined the color of
          their own eyes is free to leave the island at this time. The
          islanders all know of this rule. As it happens, on this
          island, there are 100 blue-eyed people, 100 brown-eyed
          people, and one green-eyed person, although the islanders,
          of course, do not know this. The green-eyed person is called
          the Guru. One day, the Guru stands on a tall pedestal and
          makes a statement that all of the islanders can hear: "I can
          see someone who has blue eyes." This is the only time any of
          the islanders communicate in any way.
        </p>
        <p>
          Which of the islanders will be allowed on the ferry, and on which night?
        </p>
      </div>

      <div>
        <b>Pirate Negotiation</b><br/>
        <a href="http://wiki.xkcd.com/irc/Puzzles#Pirates" target="new">[Source]</a>
        <p>
          One hundred pirates have come upon a treasure chest
          consisting of fifty gold coins. The gold coins are each of
          equal worth to one another and are indivisible. The pirates
          have a total ordering which they use to determine who is in
          charge, so Pirate 1 in the leader, Pirate 2 is second in
          command, and so on. The pirates are also perfect logicians
          and will always make perfectly logical decisions.
        </p>
        <p>
          The pirates have a well-defined procedure for determining
          how to distribute the gold. First, the highest-ranking
          pirate who is still alive (initially, this will be the
          leader) proposes a way to distribute the treasure among the
          surviving pirates. Then, all of the currently living pirates
          (including the one who proposed this idea) vote on the
          proposal. If at least half of the voters approve of the
          proposal, then it is accepted and the gold is distributed
          that way. Otherwise, the pirate who made the proposal is
          killed and the process is repeated with the next in
          command. A pirate's priorities are, in order: survival,
          wealth, and bloodthirst. That is, a pirate will always favor
          a decision which results in his survival over one which
          results in his death. Between two scenarios which both
          result in his survival, a pirate will always choose the one
          which results in him getting more money. Finally, if two
          scenarios both result in survival with the same amount of
          gold, the pirate will choose the situation that involves the
          most <em>other</em> pirates dying.
        </p>
        <p>
          Assuming the pirates make perfectly logical decisions that
          are in line with their priorities, how will the gold be
          distributed?
        </p>
      </div>

      <div>
        <b>The Sam and Polly Problem</b><br/>
        <a href="http://wiki.xkcd.com/irc/Puzzles#The_Sam_and_Polly_Problem" target="new">[Source]</a>
        <p>
          Sam and Polly are perfect logicians. One day, a student
          walks in and says "I'm thinking of two numbers \(x\) and
          \(y\) with \(3 \le x \le y \le 97\). I'm going to tell their
          sum to Sam and their product to Polly. The student does so
          and then leaves. The following conversation takes places.
          <div style="margin: 10px">
            Sam: "Polly, you don't know what the two numbers are."<br/>
            Polly: "True. But now I do."<br/>
            Sam: "And now I do as well."
          </div>
          Assuming both logicians were only making truthful statements
          of which they were certain, determine \(x\) and \(y\).
        </p>
        <p style="font-style: italic">
          (A personal favorite of mine. It's an interesting exercise
          to write a computer program to solve this. However, I have
          yet to determine a solution which doesn't require the
          assistance of a computer.)
        </p>
      </div>

      <div>
        <b>The Poisoned Wells Problem</b><br/>
        <a href="http://wiki.xkcd.com/irc/Puzzles#The_Six_Poisoned_Wells" target="new">[Source]</a>
        <p>
          A dragon and a knight live on a small island. On this
          island, there is a freshwater lake that contains ordinary
          drinking water. There are also six wells, numbered 1 to
          6. Each well contains a liquid that is indistinguishable
          from water in appearance but that is actually a deadly
          poison. This poison shows no symptoms but will instantly
          kill the drinker an hour after having been consumed. The
          poisons, however, are somewhat unique. If someone drinks
          poison from the same well multiple times, it has the same
          effect as drinking it only once. However, if someone has
          already been poisoned and drinks the poison of a
          higher-numbered well, all poisons from lower wells are cured
          instantly. This only works of the higher-numbered well is
          drunk <em>after</em> the lower well(s). As such, Well 6 can
          cure any of the other wells' poisons but, if a healthy
          individual were to drink it, would incurably poison them.
        </p>
        <p>
          Both the knight and the dragon understand the rules of these
          wells. They also each want the other dead, so they arrange a
          special contest. Each participant secretly fills a vial with
          a liquid, either from the lake or from one of the numbered
          wells. They will then meet, exchange vials, and drink the
          liquid prepared by their opponent. Each player is free to
          drink whatever they wish before and after exchanging vials,
          in preparation for the contest. Further, while the
          freshwater lake and the first five wells are accessible to
          both players, Well 6 is located on a steep mountaintop that
          the knight cannot access.
        </p>
        <p>
          Is there a strategy that will ensure the survival of either player?
        </p>
      </div>

      <div>
        <b>The Prisoner's Chessboard</b><br/>
        <a href="http://wiki.xkcd.com/irc/Puzzles#Prisoner.27s_Chess" target="new">[Source]</a>
        <p>
          There are two prisoners and a warden. The warden decides to
          play a game with the prisoners. If the prisoners win, they
          are free to go, but if they lose then they remain imprisoned
          forever. The warden has a standard, 8x8 chessboard in his
          office. He proposes the following challenge to the
          prisoners. He will position a single quarter on each square
          of the chessboard. The quarters will be flipped arbitrarily,
          so that each coin could be either heads or tails. He will
          then call the first prisoner into his office. The warden
          will point to a single square on the chessboard, which he
          calls the magic square. The first prisoner is then required
          to flip exactly one coin on the chessboard over to its other
          side. He then leaves, without communicating to the second
          prisoner. The second prisoner will then be called in, having
          never seen the board before the first prisoner's change. He
          is allowed to guess at the location of the magic square. If
          he chooses correctly, the prisoners win.
        </p>
        <p>
          The prisoners are not allowed to communicate after the game
          starts. However, before the game begins they are free to
          discuss a strategy among themselves. There exists a strategy
          that will allow the two prisoners to escape with absolute
          certainty, assuming that they are both perfect
          logicians. What is this strategy?
        </p>
      </div>

    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
