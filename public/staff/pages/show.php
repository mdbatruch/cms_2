<?php 
    include('../../../private/initialize.php');

    require_login();

    $id = $_GET['id'] ?? '1';

    $pages = find_all_pages_by_id($id);
    // $pages = find_all_pages();

//    echo '<pre>';
//    print_r($pages);
//    echo '</pre>';

    $page_title = 'Pages Show';
    
    include(SHARED_PATH . '/staff-header.php');
    
?>

 
<div id="content">

<div class="link-container">
    <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?id=' . chars($pages['subject_id'])); ?>">
        Back to List
    </a>
</div>
<!-- <h1><php echo $_SESSION['status']; ?></h1> -->
    <p>Page ID: <?php echo $pages['id']; ?></p>
    <p>Subject: <?php echo $pages['subject_id']; ?></p>
    <p>Name: <?php echo $pages['menu_name']; ?></p>
    <p>Position: <?php echo $pages['position']; ?></p>
    <p>Content: <?php echo $pages['content']; ?></p>
    
    <?php echo display_session_message(); ?>
<!--    <p class="alert alert-success"><php echo $_SESSION['new_message'] ?? 'Not working!'; ?></p>-->
<!--
        <a href="show.php?name=php echo u('Mike B'); ?>">Link</a><br />
        <a href="show.php?company=php echo u('Mike&B'); ?>">Link</a><br />
        <a href="show.php?query=php echo u('^$&#^'); ?>">Link</a>
        
-->
    <p>
        <a href="<?php echo url_for('index.php?id=' . $pages['id'] . '&preview=true'); ?>" target="_blank">Preview Page</a>
    </p>
    <p>
        <a href="<?php echo url_for('/staff/index.php'); ?>">Back to Staff Page</a>
    </p>
</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>