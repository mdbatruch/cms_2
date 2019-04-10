<?php

require_once('../../../private/initialize.php');

require_login();

// if(!isset($_GET['id'])) {
//   redirect_to(url_for('/staff/subjects/index.php'));
// }

// $id = $_GET['id'];

if(!$subject = $_GET['subject']) {
  redirect_to(url_for('/staff/subjects/index.php'));
}

$subject_array = find_subject_by_name($subject);

// echo '<pre>';
// print_r($subject_array);

$subject_name = $subject_array['menu_name'];


if(is_post_request()) {
    $result = delete_subject($subject_array['id']);
    $_SESSION['status'] = 'you have deleted a subject';
    redirect_to(url_for('/staff/subjects/index.php'));
} 

// else {
//     $subject = find_subject_by_id($id);
//     // $subject_array = find_subject_by_name($subject);
// }
 $page_title = 'Delete Subject';

 include(SHARED_PATH . '/staff-header.php');

 ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this subject?</p>
    <p class="item"><?php echo chars($subject_array['menu_name']); ?></p>

    <form action="<?php echo url_for('/staff/subjects/delete.php?subject=' . chars(u($subject_name))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
