<?php
    require_once('../../../private/initialize.php');

    require_login();
    
    $page_title = 'Admin Delete';

    if(!isset($_GET['id'])) {
        redirect_to(url_for('/staff/admin/index.php'));
      }

    $id = $_GET['id'];

    // $admin_by_id = find_admin_by_id($id);

    // $admin_by_id_array = mysql_fetch_assoc($admin_by_id);

    if (is_post_request()) {
        $delete = delete_admin($id);

        $_SESSION['status'] = 'You have deleted an admin';
        
        // $_SESSION['status'] = 'You have deleted a page';

        redirect_to(url_for('/staff/admin/index.php'));
    } else {
        $admin_by_id = find_admin_by_id($id);
    }

    // echo '<pre>';
    // print_r($admin_by_id_array['id']);
    // print_r(mysqli_fetch_assoc($admin_by_id));

    include(SHARED_PATH . '/staff-header.php');
?>

        <div id="content">
            <div id="main-menu">
                <h1>Delete admin</h1>
                <p>Are you sure you want to Delete this admin?</p>
                <!-- <php while($admin = mysqli_fetch_assoc($admin_by_id)) { ?> -->
                    <p><?php echo $admin_by_id['username']; ?></p>
                    <p><?php echo $admin_by_id['first_name']; ?></p>
                    <p><?php echo $admin_by_id['last_name']; ?></p>
                    <p><?php echo $admin_by_id['email']; ?></p>
                <!-- php } ?> -->
                <form action="<?php echo url_for('staff/admin/delete.php?id=' . $admin_by_id['id']); ?>" method="post">
                    <div id="delete-admin">
                        <input type="submit" name="delete-admin" value="Delete admin" />
                    </div>
                </form><br/>
                <a class="back-link" href="<?php echo url_for('/staff/admin/index.php'); ?>">&laquo; Back to List</a>
            </div>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>