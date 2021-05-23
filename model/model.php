<?php

  function print_b($d) {
    echo "<pre>",print_r($d),"</pre>";
  }

  function get_json_str($url) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($crl, CURLOPT_TIMEOUT, 10);
    $json = curl_exec($crl);
    return $json;
  }

  $root_url = 'https://' . $_SERVER['HTTP_HOST'] . '/aau/portfolio/';
  
  $project_thumbnails_json_str = get_json_str("https://janelleweiwei.org/aau/portfolio/model/project_thumbnails.json");  
  $project_thumbnails = json_decode($project_thumbnails_json_str, true);

  $thumbnails_array = array();
  foreach ($project_thumbnails as $key => $value) {
    array_push($thumbnails_array, new ProjectThumbnail(
      $value["thumbnail_url"],
      $value["title"], 
      $value["subtitle"], 
      $value["description"],
      $value["link"]));
  }

  class ProjectThumbnail {

    public $thumbnail_url,
      $title,
      $subtitle,
      $description,
      $link;

    public function __construct(string $thumbnail_url, string $title, string $subtitle, string $description, string $link) {
      $this->thumbnail_url = $thumbnail_url;
      $this->title = $title;
      $this->subtitle = $subtitle;
      $this->link = $link;
      $this->description = $description;
    }
  }

  class Coontainer {

    public $image,
      $title,
      $subtitle,
      $paragraphs, 
      $direction,
      $children;
  }

?>