<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Contact me</title>
    <?php 
    include "meta.php";
    require_once('templates.php');
    ?>
  </head>

  <body>
    <?php include "navigation.php"; ?>

    <div id="form" style="padding-top: 150px; padding-right: 30px; padding-left: 30px;">

    <div class="fish" id="fish"></div>

    <form id="waterform" method="post">

    <div class="formgroup" id="name-form">
        <label for="name">Your name*</label>
        <br>
        <input type="text" id="name" name="name" />
        <br>
    </div>

    <div class="formgroup" id="email-form">
        <label for="email">Your e-mail*</label>
        <br>
        <input type="email" id="email" name="email" />
        <br>
    </div>

    <div class="formgroup" id="message-form">
        <label for="message">Your message</label>
        <br>
        <textarea id="message" name="message"></textarea>
        <br>
    </div>

      <input type="submit" value="Send your message!" />
    </form>
    </div>
    
    <?php include "footer.php";?>
  </body>

</html>