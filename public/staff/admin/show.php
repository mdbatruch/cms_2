<?php
    require_once('../../../private/initialize.php');

    require_login();

    $page_title = 'Admin Show';
    
    include(SHARED_PATH . '/staff-header.php');

    $id = $_GET['id'] ?? '1';

    $admin_by_id = find_admin_by_id($id);
?>

        <div id="content">
            <div id="main-menu">
                <h2>Admin Main Menu</h2>
                <p><?php echo display_session_message(); ?></p>
                <div class="container">
                    <p><?php echo $admin_by_id['username']; ?></p>
                    <p><?php echo $admin_by_id['first_name']; ?></p>
                    <p><?php echo $admin_by_id['last_name']; ?></p>
                    <p><?php echo $admin_by_id['email']; ?></p>
                </div>
                <a class="back-link" href="<?php echo url_for('/staff/admin/index.php'); ?>">&laquo; Back to List</a>
            </div>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>