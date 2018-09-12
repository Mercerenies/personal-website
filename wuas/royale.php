<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - WUAS</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div>
        <img src="banner.png" alt="Wish Upon A Star" />
      </div>
      <p>
        Battle Royale mode is a variant on WUAS that focuses more on the
        player-vs-player mechanic rather than the gold coin collection.
      </p>
      <p>
        Rather than collecting coins, the goal of WUAS: Battle Royale
        is to be the last player standing. Every player starts with a
        certain number of lives, depending on the number of players in
        the game, and when you run out of lives, you're out. Game
        over. Additionally, once the first person dies, signups are
        closed.
      </p>
      <p>
        Wishing is also a bit different. Everybody starts with a set
        number of gold coins (again, depending on the number of
        players). Making wishes costs coins. A wish costs one coin, by
        default. Every time someone makes a wish, the cost of the next
        wish goes up by one. If a full turn passes with no wishes, the
        cost resets back down to one. The <a href="wishes.php">wishing
        restrictions</a> are otherwise the same.
      </p>
      <p>
        If you are responsible for killing someone, you get to steal
        one item or gold coin off their person before they despawn.
      </p>
      <p>
        Finally, if you are finally eliminated from the game, you get
        access to the ghost chat, where all of the dead players can
        chat freely. Additionaly, you can choose to haunt a particular
        space, which secretly corrupts its effect. Once someone lands
        on the haunted space, they trip its effect, and you can move
        to a new space. Obviously, you can't haunt protected spaces,
        like Start or the Altar. Once you're dead, you can't win the
        game, but you can get revenge on the player who did you in.
      </p>
      <div>
        <a href="index.php">
          Back to WUAS Main
        </a>
      </div>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
