<?php 
  $root_url = 'http://' . $_SERVER['HTTP_HOST'] . '/aau/portfolio/';
?>

<header>
  <nav class="navbar nav-pills topnav navbar-expand-sm navbar-light bg-light" id="myTopnav"  style="width: 100% z-index: 50000">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?=$root_url . 'index.php';?>"><img id="nav-logo" src="<?=$root_url . 'images/logo.png';?>"></a>
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content: center;">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?=$root_url . 'index.php';?>">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Projects
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="<?=$root_url . 'views/cedarlive.php';?>">CedarLive</a></li>
              <li><a class="dropdown-item" href="<?=$root_url . 'views/gramcity.php';?>">GramCity</a></li>
              <li><a class="dropdown-item" href="<?=$root_url . 'views/airhome.php';?>">AirHome</a></li>
              <li><a class="dropdown-item" href="<?=$root_url . 'views/insitu.php';?>">In Situ</a></li>
              <li><a class="dropdown-item" href="<?=$root_url . 'views/stellantis.php';?>">Gaia</a></li>
              <li><a class="dropdown-item" href="http://www.janelleweiwei.org/aau/wnm601/m15/">Filoli Website</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?=$root_url . 'views/about.php';?>">About me</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="https://static1.squarespace.com/static/6015365d05ed324961a1547d/t/605b9c0e35f69f69305d4cf9/1616616462166/New+Resume.pdf">Resume</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>
</header>
			