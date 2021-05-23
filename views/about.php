<!DOCTYPE html>
<html lang="en">
  <head>
    <title>About me</title>
    <?php 
    include "meta.php";
    require_once('templates.php');
    ?>
  </head>

  <body>
    <?php include "navigation.php"; ?>

    <? 
      echo getSectionsHTML('model/about.json');
    ?>
    
    <?php include "footer.php";?>
  </body>

</html>