<!DOCTYPE html>

<?php $GLOBALS["file"] = isset($_GET["file"]) ? $_GET["file"] : 3; ?>
<?php $GLOBALS["turn"] = isset($_GET["turn"]) ? $_GET["turn"] : -1; ?>
<?php $GLOBALS["z"] = isset($_GET["z"]) ? $_GET["z"] : 0; ?>
<?php $GLOBALS["zoom"] = isset($_GET["zoom"]) ? $_GET["zoom"] : 1; ?>

<html>
  <head>
    <title>Mercerenies - WUAS</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
    </script>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js">
    </script>
    <script src="../js/spaces.js">
    </script>
    <script src="../js/interactive.js">
    </script>
    <script>
      var file = <?php echo $GLOBALS["file"] ?>;
      var turn = <?php echo $GLOBALS["turn"] ?>;
      var zaxis = <?php echo $GLOBALS["z"] ?>;
      var zoom = <?php echo $GLOBALS["zoom"] ?>;
      window.setActiveTurn(file, turn, zaxis, zoom);
      jQuery(function() { window.loadData(file); });
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div>
        <img src="banner.png" alt="Wish Upon A Star" />
      </div>
      <br/>
      <div>
        <em>
          Note: Use the links below to access different board images.
        </em>
      </div>
      <div id="file-header">
      </div>
      <br/>
      <div id="zoom-menu"></div>
      <div id="file-menu"></div>
      <div id="turn-menu"></div>
      <div id="axis-menu"></div>
      <br/>
      <div id="interactive-content">
        Please wait... loading page...
      </div>
      <div>
        <a href="index.php">
          Back to WUAS Main
        </a>
      </div>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
