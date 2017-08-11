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
      My name is Silvio Mayolo, known online as Mercerenies. I am a 20-year-old
      programmer and mathematician attending Tennessee Technological University.
      This is a website for me to showcase various projects and things
      that I write, as well as neat stuff I find online. Click the buttons
      in the top bar to navigate the site.
      <br/><br/>
      If you're an employer or researcher, please take a look at my
      <a href="pfolio/">professional portfolio</a> to see the work I've done.
      <br/><br/>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="pfolio/asm_img.png">
            <img src="pfolio/asm_img.png" width="300" />
          </a>
        </div>
        <b>Emacs mode I wrote to work specifically with MASM</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="pfolio/present.png">
            <img src="pfolio/present.png" width="300" />
          </a>
        </div>
        <b>Presentation I delivered a short while back on type theory</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="pfolio/ss_game.png">
            <img src="pfolio/ss_game.png" width="300" />
          </a>
        </div>
        <b>A game project that I designed with a good friend</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="pfolio/four.png">
            <img src="pfolio/four.png" width="300" />
          </a>
        </div>
        <b>The major four parts of the pipeline in my Net Game project,
           each written in a different language</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="pfolio/proofs.png">
            <img src="pfolio/proofs.png" width="300" />
          </a>
        </div>
        <b>A WIP abstract algebra proof engine, shown here proving that
           the identity is its own inverse</b>
      </div>
      <div class="imgbox">
        <div class="imgbox1">
          <a href="pfolio/dem.png">
            <img src="pfolio/dem.png" width="300" />
          </a>
        </div>
        <b>One of my oldest games, a text-based adventure called Demensitis</b>
      </div>
    </div>
    <?php include('private/footer.php'); ?>
  </body>
</html>
