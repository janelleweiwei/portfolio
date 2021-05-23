<?php

  function getSectionsHTML($json_path) {
    $root_url = 'https://'.$_SERVER['HTTP_HOST'].'/aau/portfolio/';
    $json_url = $root_url.$json_path;
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $json_url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($crl, CURLOPT_TIMEOUT, 10);
    $json_string = curl_exec($crl);

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
  <div class="container" style="display: flex; flex-direction: column; justify-content: center;">
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

    if (isset($root_container->videos)) {
      $slide_show_html = createSlideShowHTML($root_container->videos, $root_container->carousel_style,
        $root_container->carousel_height, true);
    } else {
      $slide_show_html = createSlideShowHTML($root_container->images, $root_container->carousel_style,
        $root_container->carousel_height);
    }
    $allow_autoplay = false;
    if ($root_container->video_allow_autoplay == 'true') {
      $allow_autoplay = false;
    }
    $video_html = createVideoHTML($root_container->video, $root_container->video_style, $allow_autoplay);
    $subtitle_html = createSubtitleHTML($root_container->subtitle);
    $messages_html = createMessagesHTML($root_container->messages);
    if (isset($root_container->ordered_list)) {
      $list_html = createListHTML($root_container->ordered_list, true);
    } else {
      $list_html = createListHTML($root_container->list);
    }
    
    $button_html = createButtonHTML($root_container->button_text, $root_container->button_url,
      $root_container->button_background, $root_container->button_color);
    $title_html = createTitleHTML(
      $root_container->title, 
      ($depth == 0),
      (!empty($child_htmls) || !empty($subtitle_html) || !empty($messages_html) || !empty($button_html)
       || !empty($slide_show_html) || !empty($list_html) || !empty($video_html) || !empty($image_html)));

    // Try to add horizontal paddings to root elements.
    if ($depth == 0) {
      $horizontal_padding = 30;
      $image_html = maybeWrapWithHorizontalPadding($image_html, $horizontal_padding);
      $subtitle_html = maybeWrapWithHorizontalPadding($subtitle_html, $horizontal_padding);
      $slide_show_html = maybeWrapWithHorizontalPadding($slide_show_html, $horizontal_padding);
      $video_html = maybeWrapWithHorizontalPadding($video_html, $horizontal_padding);
      $messages_html = maybeWrapWithHorizontalPadding($messages_html, $horizontal_padding);
      $list_html = maybeWrapWithHorizontalPadding($list_html, $horizontal_padding);
      $button_html = maybeWrapWithHorizontalPadding($button_html, $horizontal_padding);
      if (count($child_htmls) == 1) {
        $grid_html = maybeWrapWithHorizontalPadding($grid_html, $horizontal_padding);
      }
    }

    $self_center_align_items = $root_container->align_items == 'center';

    $blockHtml = createBlockHTML($image_html, $slide_show_html, $video_html, $title_html, $subtitle_html, $messages_html,
      $list_html, $button_html, $grid_html, $self_center_align_items);
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
    $list_html="",
    $button_html="",
    $children_html="",
    $center_align_items=false) {
if (empty($image_html) && empty($slide_show_html) && empty($video_html) && empty($title_html) 
    && empty($subtitle_html) && empty($messages_html) && empty($list_html) && empty($button_html)
    && empty($children_html)) {
  return "";
}

$extra_class = $center_align_items ? "flex-center" : "";

return <<<HTML

<div class="block">
  <div class="block-content {$extra_class}">
    $image_html $slide_show_html $video_html $title_html $subtitle_html $messages_html $list_html $button_html $children_html
  </div>
</div>

HTML;
  }


  function createTitleHTML($title, $is_section_root_title=false, $has_other_elements=false) {
if (!isset($title)) {
  return "";
}

$style = "";
if ($is_section_root_title && !$has_other_elements) {
  $style = "margin-bottom: 0px; !important;";
}

return <<<HTML
<h2 style="{$style}">
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


  function createSlideShowHTML($url_array, $carousel_style="", $carousel_height="", $is_video=false) {
if (empty($url_array)) {
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

$style_override = "";
if (isset($carousel_height)) {
  $style_override = "height: " . $carousel_height . " !important";
}

$img_htmls = "";
foreach($url_array as $url) {
  if (!$is_video) {
    $child_element = "<img src='{$url}' style='{$extra_img_style}'>";
  } else {
    $child_element = "<iframe src='{$url}' frameborder='0' style='width:100%;height:100%;'></iframe>";
  }
  $img_htmls = $img_htmls . "<div class='gallery-cell{$extra_class}'>" . $child_element . "</div>";
}

return <<<HTML

<div class="gallery{$extra_class} js-flickity" style="{$style_override}" data-flickity-options='{ "wrapAround": true, "setGallerySize": false, "percentPosition": false, "imagesLoaded": true, "cellAlign": "right", "contain": true }'>
  $img_htmls
</div>
<div class="spacer-block"></div>
HTML;
  }


  function createVideoHTML($video_url, $video_style="", $video_allow_autoplay=false) {
if (!isset($video_url) || empty($video_url)) {
  return "";
}

$style = "position:relative; box-sizing: border-box; width:100%;" . $video_style;
$autoplay = "";
if ($video_allow_autoplay) {
  $autoplay = "autoplay;";
}

return <<<HTML

<div style="{$style}">
  <iframe src="{$video_url}" frameborder="0" style="position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:auto" allow="{$autoplay} encrypted-media" allowfullscreen="">
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

  
  function createListHTML($list_items, $ordered=false) {
    if (!isset($list_items) || empty($list_items)) {
      return "";
    }
    $html = $ordered ? "<ol>" : "<ul>";
    foreach($list_items as $list_item) {
      $html = $html . "<li>" . $list_item . "</li>";
    }
    $html = $html . ($ordered ? "</ol>" : "</ul>");
    return $html;
  }


  function createButtonHTML($title, 
    $link, 
    $background_color="",
    $text_color="") {
if (!isset($title)) {
  return "";
}

return <<<HTML

<div class='image-button' style='margin-top: 12px !important; margin-bottom: 12px; min-width: 0px !important;'>
  <div class='image-button-inner'>
    <a href='{$link}' style='background: {$background_color}; color: {$text_color}'>$title</a>
  </div>
</div>

HTML;

  }


  function maybeWrapWithHorizontalPadding($html, $horizontal_padding=0) {
    if (!isset($html) || empty($html)) {
      return $html;
    }
    $style = "padding-left: {$horizontal_padding}px; padding-right: {$horizontal_padding}px;";
    return "<div style='{$style}'>" . $html . "</div>";
  }


?>