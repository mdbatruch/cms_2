<!doctype html>

<html lang="en">
  <head>
    <title>Test CMS <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?> <?php if (isset($preview) && $preview ){ echo '[PREVIEW]'; } ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/public.css'); ?>" />
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/bootstrap.css'); ?>"/>
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/font-awesome.css'); ?>"/>
  </head>

  <body>

  <!-- <div class="container"> -->

    <header>
      <h1>
        <a href="<?php echo url_for('/index.php'); ?>">
          <!-- <img src="<php echo url_for('/images/gbi_logo.png'); ?>" width="298" height="71" alt="" /> -->
        </a>
      </h1>
    </header>
  <!-- </div> -->