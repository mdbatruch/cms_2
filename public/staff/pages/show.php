<?php 
    include('../../../private/initialize.php');

    require_login();

    $id = $_GET['id'] ?? '1';

    // $pages = find_all_pages_by_id($id);

    $menu_name = chars($_GET['page_name']);

    $names = find_all_pages_by_name($menu_name);

    $parent = find_subject_by_id($names['subject_id']);

    $subject_parent = $parent['menu_name'];

    // $pages = find_all_pages();

//    echo '<pre>';
//    print_r($subject_parent);
//    print_r($names);
//    echo '</pre>';

    $page_title = 'Pages Show';


    // $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' .  . '&subject_id=' . '<br/>';
    // echo dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . '&subject_id=' . '<br/>';
    // echo 'http://localhost:8888/cms_2/public/staff/pages/show.php?id=29&subject_id=1';
    
    include(SHARED_PATH . '/staff-header.php');
    
?>

 
<div id="content">

<div class="link-container">
    <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?subject=' . chars(u($subject_parent))); ?>">
        Back to List
    </a>
</div>
<!-- <script>alert('fuck');</script> -->
<!-- <php echo $menu_name; ?> -->
<!-- <h1><php echo $_SESSION['status']; ?></h1> -->
    <p>Page ID: <?php echo $names['id']; ?></p>
    <p>Subject: <?php echo $names['subject_id']; ?></p>
    <p>Name: <?php echo $names['menu_name']; ?></p>
    <p>Position: <?php echo $names['position']; ?></p>
    <p>Content: <?php echo $names['content']; ?></p>

    <div id="form--message"><?php if (isset($_GET['status']) && $_GET['status'] == 'edited' ) {echo '<div class="alert alert-success">You have succesfully edited this page<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';}
        else if (isset($_GET['status']) && $_GET['status'] == 'created' ){ echo '<div class="alert alert-success">You have succesfully created a new page<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';}
        ?></div>
    
    <!-- <php echo display_session_message(); ?> -->
<!--    <p class="alert alert-success"><php echo $_SESSION['new_message'] ?? 'Not working!'; ?></p>-->
<!--
        <a href="show.php?name=php echo u('Mike B'); ?>">Link</a><br />
        <a href="show.php?company=php echo u('Mike&B'); ?>">Link</a><br />
        <a href="show.php?query=php echo u('^$&#^'); ?>">Link</a>
        
-->
    <p>
        <a href="<?php echo url_for('index.php?menu_name=' . chars(u($names['menu_name'])) . '&preview=true'); ?>" target="_blank">Preview Page</a>
    </p>
    <p>
        <a href="<?php echo url_for('/staff/index.php'); ?>">Back to Staff Page</a>
    </p>
</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>