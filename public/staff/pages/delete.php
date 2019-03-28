<?php
    require_once('../../../private/initialize.php');

    require_login();

    if(!isset($_GET['id'])) {
      redirect_to(url_for('/staff/pages/index.php'));
    }

    $id = $_GET['id'];

    $pages = find_all_pages_by_id($id);

    if (is_post_request()) {
        $result = delete_page($id);

        $_SESSION['status'] = 'You have deleted a page';

        redirect_to(url_for('/staff/subjects/show.php?id=' . $pages['subject_id']));
    }
    
    $page_title = 'Delete Page';
    
    include(SHARED_PATH . '/staff-header.php');
?>

<div id="content">

<div class="link-container">
    <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?id=' . chars($pages['subject_id'])); ?>">
        Back to List
    </a>
</div>

  <div class="subject delete">
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this page?</p>
    <p class="item"><?php echo $pages['menu_name']; ?></p>

    <form action="<?php echo url_for('staff/pages/delete.php?id=' . $pages['id']); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>