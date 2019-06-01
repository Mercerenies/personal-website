<!DOCTYPE html>

<?php $GLOBALS["struct"] = isset($_GET["struct"]) ? $_GET["struct"] : ""; ?>

<html>
  <head>
    <title>Mercerenies - Algebra</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="../lib/jquery.min.js">
    </script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
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
