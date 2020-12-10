<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/bird-staff/views/index.php'));
}
$id = $_GET['id'];
$bird = Bird::find_by_id($id);
if($bird == false) {
  redirect_to(url_for('/bird-staff/views/index.php'));
}

if(is_post_request()) {

  // Delete bicycle
  $result = $bird->delete();
  $session->message('The bird was deleted successfully.');
  redirect_to(url_for('/bird-staff/views/index.php'));

} else {
  // Display form
}

?>

<?php $page_title = 'Delete Bird'; ?>
<?php include(SHARED_PATH . '/bird-staff-header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/bird-staff/views/index.php'); ?>">&laquo; Back to List</a>

  <div class="bicycle delete">
    <h1>Delete Bird</h1>
    <p>Are you sure you want to delete this bird?</p>
    <p class="item"><?php echo h($bird->common_name); ?></p>

    <form action="<?php echo url_for('/bird-staff/views/delete.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Bird" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/bird-staff-footer.php'); ?>
