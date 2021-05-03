<?php 
  $root_url = 'http://' . $_SERVER['HTTP_HOST'] . '/aau/portfolio/';
?>

<header class="navbar">
  <nav class="nav-pills topnav" id="myTopnav">
    <ul>
      <li>
        <img id="nav-logo" src="<?=$root_url . 'images/logo.png';?>">
      </li>
      <li><a href="<?=$root_url . 'index.php';?>">Home</a></li>
      <li><a href="<?=$root_url . 'views/about.php';?>">About me</a></li>
      <li><a href="<?=$root_url . 'views/contact.php';?>">Contact</a></li>
    </ul>
  </nav>
</header>
			