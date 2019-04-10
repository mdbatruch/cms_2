<?php
    require_once('../../../private/initialize.php');

    require_login();

    // if(!isset($_GET['id'])) {
    //   redirect_to(url_for('/staff/pages/index.php'));
    // }

    // $id = $_GET['id'];

    if(!isset($_GET['page'])) {
      redirect_to(url_for('/staff/pages/index.php'));
    }

    $name = $_GET['page'];

    $subject = $_GET['subject'];

    $subject_info = find_subject_by_name($subject);

    $name_info = find_all_pages_by_name($name);

    // $pages = find_all_pages_by_id($id);

    // $subject_name = find_pages_by_subject_name($subject);

    // $subject_name_array = mysqli_fetch_array($subject_name);

    // echo '<pre>';
    // print_r($subject_info);

    // $subjects = find_subject_by_id($pages['subject_id']);

    // $subject_name = $subjects['menu_name'];

    if (is_post_request()) {
        $result = delete_page($name_info['id']);

        $_SESSION['status'] = 'You have deleted a page';

        redirect_to(url_for('/staff/subjects/show.php?subject=' . chars(u($subject_info['menu_name']))));
    }
    
    $page_title = 'Delete Page';
    
    include(SHARED_PATH . '/staff-header.php');
?>

<div id="content">

<div class="link-container">
    <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?subject=' . chars(u($subject_info['menu_name']))); ?>">
        Back to List
    </a>
</div>

  <div class="subject delete">
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this page?</p>
    <p class="item"><?php echo $name_info['menu_name']; ?></p>

    <form action="<?php echo url_for('staff/pages/delete.php?subject=' . chars(u($subject_info['menu_name'])) . '&page=' . chars(u($name_info['menu_name']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>