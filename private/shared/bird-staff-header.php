<?php
  if(!isset($page_title)) { $page_title = 'Bird Staff Area'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>WNC Birds - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>" />
  </head>

  <body>
    <header>
      <h1>Bird Staff Area</h1>
    </header>

    <navigation>
      <ul>
        <?php if($session->is_logged_in()) { ?>
        <li>User: <?php echo $session->username ?></li>
        <li>User Level: <?php if($session->user_level == 'a'){echo 'Admin';}else{echo 'Member';} ?></li>
        <li><a href="<?php echo url_for('/bird-staff/index.php'); ?>">Menu</a></li>
        <li><a href="<?php echo url_for('/bird-staff/logout.php'); ?>">Logout</a></li>
        <?php } ?>
      </ul>
    </navigation>

    <?php echo display_session_message(); ?>
