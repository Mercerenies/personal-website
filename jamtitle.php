<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Fun</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="../lib/jquery.min.js">
    </script>
    <script src="js/jamtitle.js">
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">

      <p>
        This system uses the latest in <del>Javascript code I just wrote</del> state-of-the-art
        machine learning to predict the value of a GMC Jam game based
        on its proposed title. Enter the title of your proposed Jam
        game below and I'll compare it to previous entries with
        similar names.
      </p>
      <input type="text" id="title-box"></input>
      <input type="button" id="rank-my-title" value="Rank my Title"></input>

      <p id="progress"></p>

    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
