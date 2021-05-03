<?php
session_start();
require_once('model/model.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Janelle Li Portfolio</title>
    <?php include "views/meta.php"; ?>
    <link rel="stylesheet" href="css/animation.css">
</head>

<body class="full-width">
  <?php include "views/navigation.php"; ?>

  <section class="hero-section full-height">
    <div class="hero-image-wrapper">
      <div style="opacity: 0.3;" class="hero-image-overlay"></div>
      <img src="images/landing3.png" sizes="100vw" alt="" class="hero-image full-height" style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
    </div>
  </section>

  <section>

  </section>

  <? 
    foreach($thumbnails_array as $thumbnail) {            
      echo "
        <section class='container'>
          <div class='grid gap'>
            <div class='col-xs-12 col-md-6 col-xl-6'>
              <div class='card soft'>
                <div class='image-title-wrapper'>
                  <div class='image-title' style='font-size: 30.9%;'>
                    <p class='' style='white-space:pre-wrap;'>{$thumbnail->title}</p>
                  </div>
                </div>
                <div class='image-subtitle-wrapper'>
                  <div class='image-subtitle' style='font-size: 30.9%;'>
                    <h2 style='white-space:pre-wrap;'>{$thumbnail->subtitle}</h2>
                    <p class='' style='white-space:pre-wrap;'>{$thumbnail->description}</p>
                  </div>
                </div>
                <div class='image-button-wrapper'>
                  <div class='image-button' style='font-size: 30.9%;'>
                    <div class='image-button-inner'>
                      <a href='{$thumbnail->link}'>View this project</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class='col-xs-12 col-md-6 col-xl-6'>
              <div class='card soft'>
                <img style='width:100%; height:auto;' src='{$thumbnail->thumbnail_url}' alt='Avatar'>
              </div>
            </div>
          </div>
        </section>
      ";
    }
  ?> 


  <?include "views/footer.php";?>

</body>
</html>