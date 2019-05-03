<?php
    require_once('../../../private/initialize.php');

    require_login();

    $page_title = 'Admin Show';
    
    include(SHARED_PATH . '/staff-header.php');

    // $id = $_GET['id'] ?? '1';

    $username = $_GET['username'];

    // $admin_by_id = find_admin_by_username($username);

    // echo '<pre>';
    // print_r($admin_by_id);

    $admin_by_username = find_admin_by_username($username);
    //  echo '<pre>';
    // print_r($admin_by_username);

    // $img = "../../upload/" . $admin_by_username['image'];
    $img = $admin_by_username['image'];
?>

        <div id="content">
            <div id="main-menu">
                <h2>Admin Main Menu</h2>
                <!-- <p><php echo display_session_message(); ?></p> -->
                <div id="form--message"><?php if (isset($_GET['status']) && $_GET['status'] == 'edited' ) {echo '<div class="alert alert-success">You have succesfully edited this Admin<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';}
        else if (isset($_GET['status']) && $_GET['status'] == 'created' ){ echo '<div class="alert alert-success">You have succesfully created a new Admin<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';}
        ?></div>
                <div class="container">
                    <p>
                        <img src="<?php echo '../../uploads/' . $img; ?>" alt="" width="40" height="50">
                    </p>
                    <p><?php echo $admin_by_username['username']; ?></p>
                    <p><?php echo $admin_by_username['first_name']; ?> <?php echo $admin_by_username['last_name']; ?></p>
                    <p><?php echo $admin_by_username['email']; ?></p>
                    <!-- <php echo $admin_by_username['email']; ?></p> -->
                </div>
                <a class="back-link" href="<?php echo url_for('/staff/admin/index.php'); ?>">&laquo; Back to List</a>
            </div>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>