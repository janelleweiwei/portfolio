<?php
  function getSectionsHTML($json_path) {
    $root_url = 'http://' . $_SERVER['HTTP_HOST'] . '/aau/portfolio/';
    $json_string = file_get_contents($root_url . $json_path);
    // $json_string = file_get_contents($root_url . "model/debug.json");

    $sections = json_decode($json_string)->sections;

    $sections_html = "";
    foreach($sections as $key => $value) {
      $sections_html = $sections_html . getSectionHTML($value->section);
    }
    return $sections_html;
  }

  function getSectionHTML($root_container) {
$container_html = getContainerHTML($root_container);
return <<<HTML

<section style="{$root_container->style}" class="{$root_container->theme_class}">
  <div class="container">
    <div class="spacer-block"></div>
    $container_html
    <div class="spacer-block"></div>
  </div>
</section>

HTML;
  }

  function getContainerHTML($root_container, $depth=0) {
    // Grid HTML
    $child_htmls = array();
    if (isset($root_container->children)) {
      foreach($root_container->children as $key => $child_container) {
        $child_html = getContainerHTML($child_container->container, $depth + 1);
        array_push($child_htmls, $child_html);
      }
    }
    $column_direction = $root_container->direction != 'row';
    $center_align_children = $root_container->align_child_items == 'center';
    $grid_html = maybeCreateGridHTML($child_htmls, $column_direction=$column_direction, $center_align_children=$center_align_children);

    // Block HTML
    $image_html = createImageHTML($root_container->image, $root_container->image_style);
    $slide_show_html = createSlideShowHTML($root_container->images, $root_container->carousel_style);
    $video_html = createVideoHTML($root_container->video);
    $title_html = createTitleHTML($root_container->title);
    $subtitle_html = createSubtitleHTML($root_container->subtitle);
    $byline_html = createBylineHTML($root_container->byline);
    $messages_html = createMessagesHTML($root_container->messages);

    // Try to add horizontal paddings to root elements.
    if ($depth == 0) {
      $horizontal_padding = 30;
      $image_html = maybeWrapWithHorizontalPadding($image_html, $horizontal_padding);
      $subtitle_html = maybeWrapWithHorizontalPadding($subtitle_html, $horizontal_padding);
      $slide_show_html = maybeWrapWithHorizontalPadding($slide_show_html, $horizontal_padding);
      $video_html = maybeWrapWithHorizontalPadding($video_html, $horizontal_padding);
      $messages_html = maybeWrapWithHorizontalPadding($messages_html, $horizontal_padding);
      if (count($child_htmls) == 1) {
        $grid_html = maybeWrapWithHorizontalPadding($grid_html, $horizontal_padding);
      }
    }

    $self_center_align_items = $root_container->align_items == 'center';

    $blockHtml = createBlockHTML($image_html, $slide_show_html, $video_html, $title_html, $subtitle_html, $messages_html, $grid_html, $self_center_align_items);
    if (!isset($root_container->style)) {
      return  $blockHtml;
    }
    return "<div style='height:100%; {$root_container->style}'>" . $blockHtml . "</div>";
  }

  function maybeCreateGridHTML($child_htmls, $column_direction=true, $center_align_children=false) {
    if (empty($child_htmls)) {
      return "";
    }

    $num_cols_per_child = '12';
    $num_children = count($child_htmls);
    if (!$column_direction) {
      $num_cols_per_child = strval(intval(ceil(12.0 / $num_children)));
    }

    // If there is only one child, do not wrap it with gird.
    if ($num_children < 2) {
      $div_html = "<div>";
      foreach ($child_htmls as $child_html) {
        $div_html = $div_html . $child_html;
      }
      $div_html = $div_html . "</div>";
      return $div_html;
    }

    $extra_class = $center_align_children ? "flex-center" : "";

    $grid_html = "<div class='grid gap'>";
    foreach ($child_htmls as $child_html) {
      $grid_html = $grid_html . "<div class='col-xs-12 col-s-12 col-md-{$num_cols_per_child} col-xl-{$num_cols_per_child} {$extra_class}'>" . $child_html . "</div>";
    }
    $grid_html = $grid_html . "</div>";
    return $grid_html;
  }

  function createBlockHTML($image_html="", 
    $slide_show_html="",
    $video_html="",
    $title_html="", 
    $subtitle_html="", 
    $messages_html="",
    $children_html="",
    $center_align_items=false) {
if (empty($image_html) && empty($slide_show_html) && empty($video_html) && empty($title_html) && empty($subtitle_html) && empty($messages_html)
    && empty($children_html)) {
  return "";
}

$extra_class = $center_align_items ? "flex-center" : "";

return <<<HTML

<div class="block">
  <div class="block-content {$extra_class}">
    $image_html $slide_show_html $video_html $title_html $subtitle_html $messages_html $children_html
  </div>
</div>

HTML;
  }


  function createTitleHTML($title) {
if (!isset($title)) {
  return "";
}

return <<<HTML
<h2>
  <strong>$title</strong>
</h2>
HTML;
  }

  function createSubtitleHTML($subtitle) {
if (!isset($subtitle)) {
  return "";
}

return <<<HTML
<h3>$subtitle</h3>
HTML;
  }

    function createBylineHTML($byline) {
if (!isset($byline)) {
  return "";
}

return <<<HTML
<p>
  <em>$byline</em>
</p>
HTML;
  }


  function createImageHTML($image_url, $image_style) {
if (!isset($image_url)) {
  return "";
}

$style = isset($image_style) ? $image_style : "width:100%; height:auto;";

return <<<HTML

<div class='card soft'>
  <img style='{$style}' src='$image_url' alt='Avatar'>
</div>

HTML;
  }

  function createSlideShowHTML($image_url_array, $carousel_style="") {
if (empty($image_url_array)) {
  return "";
}

$extra_class = "";
if ($carousel_style == "full_width") {
  $extra_class = "-full-width";
}

$extra_img_style = "max-width: 600px";
if ($carousel_style == "full_width") {
  $extra_img_style = "max-width: 100%";
}

$img_htmls = "";
foreach($image_url_array as $image_url) {
  $img_htmls = $img_htmls . "<div class='gallery-cell{$extra_class}'><img src='{$image_url}' style='{$extra_img_style}'></div>";
}

return <<<HTML

<div class="gallery{$extra_class} js-flickity" data-flickity-options='{ "wrapAround": true, "setGallerySize": false, "percentPosition": false, "imagesLoaded": true, "cellAlign": "right", "contain": true }'>
  $img_htmls
</div>
<div class="spacer-block"></div>
HTML;
  }

  function createVideoHTML($video_url) {
if (!isset($video_url) || empty($video_url)) {
  return "";
}

return <<<HTML

<div style="position:relative; box-sizing: border-box; padding: 30%; width:100%;">
  <iframe src="{$video_url}" frameborder="0" style="position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:auto" allow="autoplay; encrypted-media" allowfullscreen="">
  </iframe>
</div>

HTML;

  }


  function createMessagesHTML($messages) {
    if (!isset($messages)) {
      return "";
    }
    $html = "";
    foreach($messages as $message) {
      $html = $html . "<p>" . $message . "</p>";
    }
    return $html;
  }

  function maybeWrapWithHorizontalPadding($html, $horizontal_padding=0) {
    if (!isset($html) || empty($html)) {
      return $html;
    }
    $style = "padding-left: {$horizontal_padding}px; padding-right: {$horizontal_padding}px;";
    return "<div style='{$style}'>" . $html . "</div>";
  }


?>