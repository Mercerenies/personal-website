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
      Wishing in the game is fairly open. That being said, there are a few basic restrictions that
      must be followed.
      <div>
        <ol>
          <li>
            <div>
              <b>
                Wishes can only affect the game board. Player inventories, stats, and basic rules
                cannot be directly affected by wishes. Additionally, the game's rules cannot be
                modified by space effects, items, or any other effects.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: All players lose 5 HP. <i>(Wishes can't directly influence player stats)</i>
                </li>
                <li>
                  Invalid: The game no longer takes place on a game board. It is now a role-playing
                  adventure. <i>(Wishes cannot manipulate the game's rules)</i>
                </li>
                <li>
                  Invalid: There is an item that makes it so that players who die cannot
                  come back. <i>(Items and other effects cannot change the rules either)</i>
                </li>
                <li>
                  Valid: There is a space below Start that causes players who land on it
                  to lose 5 HP. <i>(Spaces can influence player stats)</i>
                </li>
                <li>
                  Valid: There is an item that allows a player who dies to retain their
                  inventory. <i>(The rules are not being changed by this item; the item
                    is simply giving the player items at a convenient time)</i>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div>
              <b>
                Gold coins can be neither created nor destroyed. Existing gold coins on the map cannot
                be moved, and the spaces they occupy cannot be changed.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: There is a new gold coin immediately to the right of Start.
                  <i>(Gold coins cannot be created or destroyed)</i>
                </li>
                <li>
                  Invalid: Every space containing a gold coin is transformed into a fiery
                  death space. <i>(The spaces containing gold coins cannot be altered)</i>
                </li>
                <li>
                  Valid: Every gold coin is surrounded by fiery death spaces. <i>(The spaces
                    near the gold coins are still fair game)</i>
                </li>
                <li>
                  Valid: There is a space that warps a player to a space adjacent to a gold coin.
                  <i>(The gold coin space itself is not being modified or abnormally moved onto)</i>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div>
              <b>
                New Altars and Start Squares cannot be created, and the current ones cannot be
                destroyed or have their effects altered. However, they can be moved about.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: The Start square does not exist. <i>(Wishes cannot destroy Start or
                    the Altar)</i>
                </li>
                <li>
                  Invalid: The Altar now kills anyone who touches it. <i>(Wish effects cannot
                    change the nature of Start or the Altar)</i>
                </li>
                <li>
                  Valid: Start is moved to the square one right of the Altar. <i>(Start and the
                    Altar can be moved, as long as there is still exactly one of each)</i>
                </li>
                <li>
                  Valid: There is a space which, upon being landed on, switches places with the
                  Altar. <i>(Start and the Altar can be moved, not just by wishes but by other
                    effects too)</i>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div>
              <b>
                There must always be a path by which a new player with no items could feasibly
                get from Start to the Altar.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: The Altar is surrounded by evil demon spaces that take 50 HP from
                  every player that passes them. <i>(New players start with 10 HP, meaning it
                    would be impossible for a new player to get to the Altar)</i>
                </li>
                <li>
                  Valid: The Altar is surrounded by evil demon spaces that take 50 HP from
                  every player that passes them but that ignore players with less than 20 HP.
                  <i>(Since the effect would safely ignore a new player with default stats,
                    it is permissible)</i>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div>
              <b>
                Spaces, items, wishes, and effects cannot discriminate by user name, user identity,
                or any real-world statistics outside of the Wish Upon A Star universe.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: There is an item that increases ATK by 500, but it only works
                  if Mercerenies is holding it. <i>(Items cannot discriminate by user name)</i>
                </li>
                <li>
                  Invalid: Below the Altar, there is a space that kills anyone who passes it
                  unless that player has at least 1,000 likes on the GMC. <i>(The number of
                    likes on the GMC that a player has is not a statistic that falls within
                    the Wish Upon A Star universe)</i>
                </li>
                <li>
                  Valid: Below the Altar, there is a space that kills anyone who passes it
                  if they have any items in their inventory. <i>(The number of items in
                    a player's inventory falls within the Wish Upon A Star universe)</i>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div>
              <b>
                The Start Square and Altar cannot contain any items or traps. Tokens cannot be
                placed onto either of these spaces but can move onto them.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: A new super shiny sword appears on the Start Square. <i>(Start and
                    the Altar cannot contain items)</i>
                </li>
                <li>
                  Invalid: An angry snowman appears on the Altar. <i>(Traps and tokens cannot
                    be wished into existence on Start or the Altar)</i>
                </li>
                <li>
                  Valid: An angry snowman appears near the Altar and immediately pursues
                  the Altar. <i>(Tokens can move onto the Altar through natural means)</i>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div>
              <b>
                A wish that takes more than 48 hours for a reasonable human to evaluate is
                considered null and void.
              </b>
            </div>
            <div>
              Examples:
              <ul>
                <li>
                  Invalid: All of the spaces below Start immediately begin to simulate a Turing
                  machine that computes the mathematical constant pi. <i>(Computing pi would
                    take more than two days and thus is invalid)</i>
                </li>
                <li>
                  Invalid: Every wish ever made in previous Wish Upon A Star games is evaluated
                  now on the current board. <i>(Evaluating that many wishes would take far more
                    than two days)</i>
                </li>
              </ul>
            </div>
          </li>
        </ol>
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
