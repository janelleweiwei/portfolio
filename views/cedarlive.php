<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CedarLive</title>
    <?php 
    include "meta.php";
    require_once('templates.php');
    ?>
  </head>

  <body>
    <?php include "navigation.php"; ?>

    <section class="hero-section">
      <div class="hero-image-wrapper">
        <img src="../images/cedarlive_hero2.png" alt="" class="hero-image" style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
      </div>
    </section>

    <?php 
      echo getSectionsHTML("model/cedarlive.json");
    ?>
    
    <?php include "footer.php";?>
  </body>

</html>