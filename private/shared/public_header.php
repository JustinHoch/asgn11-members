<!doctype html>

<html lang="en">
  <head>
    <!--
      XSS -- Cross-site Scripting Prevention
      Notice the h() function in the PHP echo statment. This function wraps the PHP function 
      htmlspecialchars() around the $page_title. This prevents XSS (Cross-site Scripting).
      This function is in the functions.php file
    -->
    <title>WNC Birds <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/public.css'); ?>" />
  </head>

  <body>

    <header>
      <h1>
        <!-- 
          the url_for function is a utility function that Mr. Skoglund built.
          It is in the functions.php file. 
        -->
        <a href="<?php echo url_for('bird.php'); ?>">
          <img class="bike-icon" src="<?php echo url_for('/images/tufted-titmouse.jpg') ?>" /><br />
          WNC Birds
        </a>
      </h1>
      <ul style="padding-left: 0; text-align: center;">
        <li style="display: inline-block;"><a href="<?php echo url_for('/bird-staff/login.php'); ?>">Login</a></li>
        <li style="display: inline-block; margin-left: 1rem;"><a href="<?php echo url_for('/signup.php'); ?>">Sign Up</a></li>
      </ul>
    </header>
