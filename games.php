<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Games</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="../lib/jquery.min.js">
    </script>
    <script src="js/games.js">
    </script>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      <?php include('private/new_site_notice.php'); ?>
      Here, you'll find a list of game projects that I either wrote or
      contributed to. Note that some of my earliest games from long ago are not
      listed here. Most of those are available
      <a href="oldgames.php">
        on a separate page
      </a>.
      <br/><br/>
      What sort of game would you like to see? <br/>
      <div style="margin:auto;">
        <a href="javascript:void(0)" onclick="window.showAll();">All</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/Adventure/);">
          Adventure Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/Puzzle/);">
          Puzzle Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/Casual/);">
          Casual Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/Platformer/);">
          Platformers</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/RPG/);">
          Role-playing Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/Strategy/);">
          Strategy Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showGenre(/3D/);">
          3D Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showOccasion('GMC Jam');">
          GMC Jam Entries</a>
        |
        <a href="javascript:void(0)" onclick="window.showOccasion('Challenge');">
          Other Contests</a>
        |
        <a href="javascript:void(0)" onclick="window.showOccasion('Joke');">
          Joke Games</a>
        |
        <a href="javascript:void(0)" onclick="window.showOccasion('Project');">
          Personal Projects</a>
      </div>
      <br/>
      In which order?
      <div style="margin:auto;">
        <a href="javascript:void(0)" onclick="window.sortByName();">
          By Name</a>
        <a href="javascript:void(0)" onclick="window.sortByDate();">
          By Date</a>
      </div>
      <br/>
      <table id="games-table">
        <tr>
          <td>Loading...</td>
        </tr>
      </table>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
