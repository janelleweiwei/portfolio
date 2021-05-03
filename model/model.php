<?php

  function print_b($d) {
    echo "<pre>",print_r($d),"</pre>";
  }

  $root_url = 'http://' . $_SERVER['HTTP_HOST'] . '/aau/portfolio/';
  $project_thumbnails_json_string = file_get_contents($root_url . "model/project_thumbnails.json");
  $project_thumbnails = json_decode($project_thumbnails_json_string, true);

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