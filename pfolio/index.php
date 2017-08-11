<!DOCTYPE html>

<html>
  <head>
    <title>Mercerenies - Home</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
      .imgbox {
          display: inline-block;
          width: 310px;
          padding: 10px;
          vertical-align: text-top;
      }
      .imgbox1 {
          display: table-cell;
          width: 300px;
          height: 300px;
          vertical-align: middle;
          border-width: 1px;
          border-style: dashed;
          border-color: black;
      }
      .imgbox b {
          font-size: 0.75em;
      }
    </style>
  </head>
  <body>
    <?php include('private/header.php'); ?>
    <div class="page content">
      My name is Silvio Mayolo. I am a programmer and mathematician
      attending Tennessee Technological University. I am interested in
      summer internships and research opportunities. I also am happy to
      help or consult concerning programming questions or problems.
      <br/><br/>
      I am familiar with most modern programming languages, and my personal interests
      lie in the study of programming languages, specifically of functional programming
      and in unique or unusual languages.
      <br/><br/>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="asm_img.png">
            <img src="asm_img.png" width="300" />
          </a>
        </div>
        <b>Emacs mode I wrote to work specifically with MASM</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="present.png">
            <img src="present.png" width="300" />
          </a>
        </div>
        <b>Presentation I delivered a short while back on type theory</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="ss_game.png">
            <img src="ss_game.png" width="300" />
          </a>
        </div>
        <b>A game project that I designed with a good friend</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="four.png">
            <img src="four.png" width="300" />
          </a>
        </div>
        <b>The major four parts of the pipeline in my Net Game project,
           each written in a different language</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="proofs.png">
            <img src="proofs.png" width="300" />
          </a>
        </div>
        <b>A WIP abstract algebra proof engine, shown here proving that
           the identity is its own inverse</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="dem.png">
            <img src="dem.png" width="300" />
          </a>
        </div>
        <b>One of my oldest games, a text-based adventure called Demensitis</b>
      </div>
      <br/><br/>
      <a href="../index.php">[back to homepage]</a>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
