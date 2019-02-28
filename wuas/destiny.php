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
        In Round 8 of WUAS, a wish regarding a Destiny Star space was
        made. Due to the magnitude and complexity of the wish, it is
        listed here on its own page.
      </p>
      <p>
        The original wish (direct quote):
        <blockquote>
          I wish for a Destiny Star to always be somewhere on the map
          (even "out of bounds"). If someone ends their turn on this
          star it will be consumed and a new one will fall from the
          heavens next turn. When you consume the Destiny Star you may
          pick one of several classes which give you an active ability
          and additional stats, you can't pick the same class more
          than once. All percentages are rounded down. If multiple
          players end their turn on a Destiny Star it is destroyed and
          a new one appears elsewhere. All percentages are rounded
          down but always equal at least 1.
        </blockquote>
      </p>
      <p>
        As long as the effects of the wish remain in play, exactly one
        Destiny Star space will be in play. A player who ends their
        turn on the Destiny Star can choose a class. Players can have
        multiple classes but can only have one instance of each class.
        A player who has multiple classes can only use one of their
        abilities on a given turn. If multiple players end their turn
        on the Star, neither player is promoted and the Star silently
        moves elsewhere.
      </p>
      <p>
        By convention, all percentages in the class effect listing
        below are rounded down and will always be at least 1. The
        available classes are as follows.
      </p>
      <div>
        <dl>
          <dt>Warrior</dt>
          <dd>Instead of moving regularly, you may charge in a
          direction. If you charge, you will move either twice your
          MOV or until stopped. You will stop if you would run off the
          board or if you hit another player. In the latter case, you
          deal damage equal to your ATK (mitigated by DEF) and stop on
          the space before that player. (+2 HP, +2 ATK, +1 DEF)</dd>
          <dt>Rogue</dt>
          <dd>On your turn, you may choose to enter stealth mode. When
          you do so, you may only move at 50% of your usual MOV but
          you may perform all actions (aside from the initial entry
          into stealth mode) privately by messaging the GM. (+3 ATK,
          +2 MOV)</dd>
          <dt>Hunter</dt>
          <dd>You have an animal companion whose stats are 50% of your
          own. Your pet can interact with other players and board
          tiles as though it is a player, but it cannot use the Altar.
          The animal companion has two bags, with which it can store
          and use two items. You directly control your companion's
          actions as long as you are a Hunter. (+1 HP, +1 ATK, +1 DEF,
          +2 MOV)</dd>
          <dt>Priest</dt>
          <dd>On your turn, you may heal yourself for 10% of your
          maximum HP, rounded down. Alternatively, you may heal
          another player within 5 tiles of you for 20% of your maximum
          health. When you reach the Altar, you gain a benefit from
          the GM proportional to how much you healed other players.
          (+2 HP, +3 MOV)</dd>
          <dt>Shaman</dt>
          <dd>You may lay down a totem which projects an aura in a
          diameter of 50% of your MOV. You may only have one totem out
          at a time. The aura can do one of the following (+1 HP, +1
          ATK, +1 DEF, +1 MOV, +1 stat based on totem)
          <ul>
            <li>Fire - Increases the ATK of nearby players by 20%. May
            change nearby tiles into fire or lava themed tiles.</li>
            <li>Water - Heals players standing near it for 10% of
            their maximum HP every turn. May change nearby tiles into
            water themed tiles.</li>
            <li>Earth - Slows MOV of nearby players by 33%. May change
            nearby tiles into grass or earth related tiles.</li>
            <li>Wind - Doubles the DEF of nearby players. Additionally
            purges tainted and other unnatural effects nearby,
            converting any unnatural spaces into either their original
            space or a wind themed space.</li>
          </ul></dd>
          <dt>Warlock</dt>
          <dd>You may place a curse on an adjacent player. The cursed
          player takes 25% of your ATK in damage each turn for 3
          turns. If you curse a player who is already cursed by you,
          you reset the counter and update the damage, as necessary,
          but the curses do not stack. (+2 HP, +3 ATK)</dd>
          <dt>Mage</dt>
          <dd>You may blink (teleport) for 20% of your MOV in a
          cardinal direction of your choice. (+2 ATK, +1 DEF, +2 MOV)</dd>
          <dt>Druid</dt>
          <dd>You may evoke the power of a tile you are on or an
          adjacent tile, using that power on yourself or any other
          player. (+2 HP, +1 ATK, +1 DEF, +1 MOV)</dd>
          <dt>Paladin</dt>
          <dd>You may choose not to engage in combat when landing on
          the same space as another player. Additionally, you deal 50%
          more damage to any player who has purposely killed another
          player. (+3 HP, +2 DEF)</dd>
        </dl>
      </div>
      <p>
        Additionally, Nefarian has the ability to declare a unique
        penalty for each class. These penalties are as follows.
      </p>
      <div>
        <dl>
          <dt>Warrior</dt>
          <dd><em>Your strength becomes your weakness!</em> You must
            charge in a random direction. If you hit Nefarian, you
            take damage equal to the damage you inflict to him.</dd>
          <dt>Rogue</dt>
          <dd><em>Stop hiding and face me!</em> You cannot use stealth
            this turn. You are teleported to a space underneath
            Nefarian. All non-Rogues can use stealth this turn.</dd>
          <dt>Hunter</dt>
          <dd><em>The Hunters become the hunted!</em> Your pet will
            move toward you and attempt to attack you. Your pet deals
            half damage this turn.</dd>
          <dt>Priest</dt>
          <dd><em>The light serves me now!</em> You are required to
            use your healing ability on Nefarian this turn. This does
            not benefit you.</dd>
          <dt>Shaman</dt>
          <dd><em>Show me what your totems can do!</em> You are forced
            to lay a totem down near Nefarian. These totems only benefit
            Nefarian and do not provide anyone else with benefits. Any
            negative effects to Nefarian are negated.</dd>
          <dt>Warlock</dt>
          <dd><em>See what happens when you play with magic you do not understand!</em> You
            must summon an Infernal nearby. Infernals last 2 turns and
            deal 4 fire damage to players on the same space, or 1 fire
            damage on adjacent spaces.</dd>
          <dt>Mage</dt>
          <dd><em>You should be more careful when you play with magic!</em> You
            will automatically use your blink ability at the end of
            your turn in a random direction.</dd>
          <dt>Druid</dt>
          <dd><em>The wild is mine to control!</em> You must channel
            the effect of a nearby space. If the space has positive
            effect, it is used on Nefarian. If it has negative effect,
            it is used on you.</dd>
          <dt>Paladin</dt>
          <dd><em>I've heard you have many lives. Show me!</em> You
            must engage in combat this turn. Nefarian takes no damage
            this turn. Any Paladin who fails to inflict damage will be
            dealt 1 to 3 damage by Nefarian's shadowflames.</dd>
          <dt>Mortal (no class)</dt>
          <dd><em>Just what can you do, exactly?</em> You will
            randomly suffer one of the above penalties.</dd>
        </dl>
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
