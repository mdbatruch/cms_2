<?php
    require_once('../../../private/initialize.php');

    require_login();

    $page_title = 'Admin Menu';

    include(SHARED_PATH . '/staff-header.php');
  
    $admins_list = find_all_admins();


    // $test = mysqli_fetch_all($admins_list);

    // echo '<pre>';
    // // print_r($test);

    // foreach ($test as $key => $value) {
    //     echo $value['3'];
    //    }
    
?>

        <div id="content">
            <div id="main-menu">
                <h2>Admin Main Menu</h2>

                <p><?php echo display_session_message(); ?></p>
                <div id="new-admin-link">
                    <a href="<?php echo url_for('/staff/admin/new.php'); ?>">Create New</a>
                </div>

                <div class="container">
                <?php while ($admin = mysqli_fetch_assoc($admins_list)) {  ?>
                    <p><?php echo $admin['first_name']; ?> <?php echo $admin['last_name']; ?></p>
                    <p><?php echo $admin['email']; ?></p>
                    <p><?php echo $admin['username']; ?></p>
                    <p>
                    <a href="<?php echo url_for('staff/admin/show.php?username=' . $admin['username']); ?>"> View</a>
                    </p>
                    <p>
                    <a href="<?php echo url_for('staff/admin/edit.php?username=' . $admin['username']); ?>"> Edit</a>
                    </p>
                    <p>
                    <a href="<?php echo url_for('/staff/admin/delete.php?id='. $admin['id']); ?>">Delete</a>
                    </p>
                <?php  } ?>
                </div>
            </div>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>