<?php require_once('../private/initialize.php'); ?>

<?php

    $preview = false;
    
    if (isset($_GET['preview'])) {
        $preview = $_GET['preview'] == 'true' && is_logged_in() ? true : false;
    }
        
//    if ($_GET['preview']=='false') {
//        redirect_to(url_for('/index.php'));
//    }

// $page_id = 18;

//         $page = find_all_pages_by_id($page_id);

//         echo '<pre>';
//         var_dump($page);

    $visible = !$preview;


    if (isset($_GET['menu_name'])) {
        $page_name = $_GET['menu_name'];
        $page = find_all_pages_by_name($page_name, ['visible' => $visible]);
        // $page = find_all_pages_by_id($page_id);

        
        if(!$page) {
            redirect_to(url_for('/index.php'));
        }
        
        // $subject_id = $page['subject_id'];
        

        // $subject = find_subject_by_id($subject_id, ['visible' => $visible]);
        
        // if(!$subject) {
        //     redirect_to(url_for('/index.php'));
        // }
        
    } elseif (isset($_GET['subject_id'])) {
        $subject_id = $_GET['subject_id'];
        
        $subject = find_subject_by_id($subject_id, ['visible' => $visible]);
        
        if(!$subject) {
            redirect_to(url_for('/index.php'));
        }

        $page_set = find_pages_by_subject_id($subject_id, ['visible' => $visible]);
        
        $page = mysqli_fetch_assoc($page_set);
        mysqli_free_result($page_set);
        
        if(!$page) {
            redirect_to(url_for('/index.php'));
        }
        $page_id = $page['id'];
    }
?>

<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">
   
   <?php include(SHARED_PATH . '/public_navigation.php'); ?>
   
    <div id="page">

    <?php if (isset($page)) {
            //           SHOW PAGE FROM DATABASE
 
            $allowed_tags = '<div><img><h1><h2><p><br><strong><em><ul><li>';
            echo strip_tags($page['content'], $allowed_tags);

        } else {
            //       Show the homepage     
            include(SHARED_PATH . '/static_homepage.php');
        }
    ?>
    </div>
</div>



<?php include(SHARED_PATH . '/public_footer.php'); ?>