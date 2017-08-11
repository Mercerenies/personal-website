<!DOCTYPE html>

<?php $GLOBALS["struct"] = isset($_GET["struct"]) ? $_GET["struct"] : ""; ?>

<html>
  <head>
    <title>Mercerenies - Algebra</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
    </script>
    <script src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
    </script>
    <script>
      window.structureCommand = "<?php echo $GLOBALS["struct"] ?>";
    </script>
    <script src="../js/algebra.js">
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <div id="map-contents">
        Please wait... loading data...
      </div>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
