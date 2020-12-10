<?php require_once('../../private/initialize.php'); ?>

<?php require_login(); ?>

<?php $page_title = 'Bird Staff Menu'; ?>
<?php include(SHARED_PATH . '/bird-staff-header.php'); ?>

<div id="content">
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li><a href="<?php echo url_for('/bird-staff/views/index.php'); ?>">Birds</a></li>
      <li><a href="<?php echo url_for('/bird-staff/admins/index.php'); ?>">Admins</a></li>
    </ul>
  </div>

</div>

<?php include(SHARED_PATH . '/bird-staff-footer.php'); ?>
