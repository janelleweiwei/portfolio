<?php
session_start();
require_once('model/model.php');
require_once('views/templates.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Janelle Li Portfolio</title>
    <?php include "views/meta.php"; ?>
</head>

<body class="full-width">
  <?php include "views/navigation.php"; ?>

  <section class="hero-section">
    <img src="images/home-background.png" sizes="100vw" alt="" class="hero-image full-height" style="position: fixed; opacity: 0.5; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
    <div style="z-index: 2000; padding-top: 100px;">
      <div class='container grid gap' style="min-height: 600px;">
        <div class='col-xs-12 col-md-6 col-xl-6' style="display: flex; flex-direction: column; justify-content: center;">
          <div style='display:flex; justify-content:center'>
            <img style='width: min(400px, 100%); height: 400px;  object-fit: contain;' src='images/meticulous.png' alt='Avatar'>
          </div>
        </div>
        <div class='col-xs-12 col-md-6 col-xl-6' style="display: flex; flex-direction: column; justify-content: center;">
          <div class='image-title-wrapper'>
            <div class='image-title' style='font-size: 30.9%;'>
              <h1 style="text-align: left;">Hi, I'm Zhuwei (Janelle) Li</h1>
              <h2>Product Designer@San Francisco</h2>
            </div>
          </div>
          <div class='image-subtitle-wrapper'>
            <div class='image-subtitle' style='font-size: 30.9%;'>
              <p>I am a UX designer, a sales professional, and a digital artist who has a massive passion for:</p>
              <p>👋 &nbsp; The combination of design and technology.</p>
              <p>😀 &nbsp; Bridging gap between user needs and business strategy.</p>
            </div>
          </div>
         <div style="margin-top: 24px;">
            <a class="social-icon" href="https://www.instagram.com/weiweijanelle/">
              <img src="images/instagram.svg" width="30" height="30"/>
            </a>
            <a class="social-icon" href="https://www.linkedin.com/in/zhuwei-li-128b61148/">
              <img src="images/linkedin.svg" width="30" height="30" />
            </a>
            <a class="social-icon" href="https://dribbble.com/Janelleweiwei">
              <img src="images/dribbble-logo.svg"  width="90" height="30" />
            </a>
            <a class="social-icon" href="mailto:janelleweiwei@gmail.com">
              <img src="images/envelope.svg"  width="30" height="30" />
            </a>
          </div>
          <div class='image-button-wrapper'>
            <div class='image-button' style='font-size: 30.9%;'>
              <div class='image-button-inner'>
                <a href='views/about.php'>About me</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <? 
    echo getSectionsHTML("model/home.json");
  ?>

  <? 
    foreach($thumbnails_array as $thumbnail) {            
      echo "
        <section class='container'>
          <div class='grid gap'>
            <div class='col-xs-12 col-md-6 col-xl-6'>
              <div class='card soft' style='display:flex; justify-content:center'>
                <img style='max-width:min(400px, 100%); height:auto;' src='{$thumbnail->thumbnail_url}' alt='Avatar'>
              </div>
            </div>
            <div class='col-xs-12 col-md-6 col-xl-6 flex-center'>
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
          </div>
          <div class='spacer-block'></div>
        </section>
      ";
    }
  ?> 


  <?include "views/footer.php";?>

</body>
</html>