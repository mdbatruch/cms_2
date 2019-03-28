<?php 

     require_once('../../../private/initialize.php');

     require_login();

 if(is_post_request()){

    $pages = [];
    $pages['subject_id'] = $_POST['subject_id'] ?? '';
    $pages['menu_name'] = $_POST['menu_name'] ?? '';
    $pages['content'] = $_POST['content'] ?? '';
    $pages['position'] = $_POST['position'] ?? '';
    $pages['visible'] = $_POST['visible'] ?? '';
    
    $result = insert_pages($pages);
     
     $new_id = mysqli_insert_id($db);
     redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
    
} else {
     redirect_to(url_for('/staff/pages/new.php'));
 }

?>