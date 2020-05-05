<!DOCTYPE html>

<?php $GLOBALS["file"] = isset($_GET["file"]) ? $_GET["file"] : 4; ?>

<html>
  <head>
    <title>Mercerenies - WUAS</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="../lib/jquery.min.js">
    </script>
    <script src="../js/spaces.js">
    </script>
    <script src="../js/projects.js">
    </script>
    <script>
      var filename_n = <?php echo $GLOBALS["file"] ?>;
      jQuery(function() { window.loadData(filename_n); });
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div>
        <img src="banner.png" alt="Wish Upon A Star" />
      </div>
      <p>
        Wish Upon A Star is an online game I run. It was once run on
        the Game Maker Community forum but has since migrated to a
        Discord server. I'll be using these pages as reference
        material for space and item effects.
      </p>
      <section>
        Resources
        <ul>
          <li>
            <a href="interactive.php">
              Interactive Game Board
            </a>
          </li>
          <li>
            <a href="wishes.php">
              Wishing Guide
            </a>
          </li>
          <li>
            <a href="royale.php">
              Battle Royale
            </a>
          </li>
          <li>
            <a href="history.php">
              History
            </a>
          </li>
          <li>
            <a href="destiny.php">
              Destiny Star
            </a>
          </li>
        </ul>
      </section>
      <section>
        External Resources
        <ul>
          <li>
            <a target="new"
               href="https://forum.yoyogames.com/index.php?threads/wish-upon-a-star-turn-2-4-%E2%88%9E.879/">
              2017 Game Topic
            </a>
          </li>
          <li>
            <a target="new" href="http://gmc.yoyogames.com/index.php?showtopic=603991&page=1">
              2016 Game Topic
            </a>
          </li>
        </ul>
      <section id="wuas-footer-tagline">
        <!-- Will be filled in by script -->
      </section>
      <br/>
      <div class="project-header" onclick="window.doShow('wuas-spaces')">
        Spaces
      </div>
      <div id="wuas-spaces" class="project-contents">
        <div id="wuas-space-map">
        </div>
        <div id="space-effect-text" style="padding:4px">
          Click a space to see its effect.
        </div>
      </div>
      <div class="project-header" onclick="window.doShow('wuas-items')">
        Items
      </div>
      <div id="wuas-items" class="project-contents">
        Loading...
      </div>
      <div class="project-header" onclick="window.doShow('wuas-effects')">
        Status Effects
      </div>
      <div id="wuas-effects" class="project-contents">
        Loading...
      </div>
      <div class="project-header" onclick="window.doShow('wuas-tokens')">
        Tokens
      </div>
      <div id="wuas-tokens" class="project-contents">
        Loading...
      </div>
      <div class="project-header" onclick="window.doShow('wuas-rulings')">
        Miscellaneous Rulings
      </div>
      <div id="wuas-rulings" class="project-contents">
        Loading...
      </div>
      <div class="project-header" onclick="window.doShow('wuas-search')">
        Search
      </div>
      <div id="wuas-search" class="project-contents">
        Enter Search Text:
        <input type="text" id="search-field" value="" />
        <div id="wuas-search-results"></div>
      </div>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
