<?php
    require_once('../../../private/initialize.php');

    require_login();

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/pages/index.php'));
    }
    
    $id = $_GET['id'];

    $page_title = 'Admin Edit';

    $admin = find_admin_by_id($id);

    include(SHARED_PATH . '/staff-header.php');
?>

        <div id="content">
            <div id="main-menu">
                <h2>Update Admin <?php echo $id; ?></h2>
                <p>Edit</p>
                <div id="form-message"></div>
            <form id="edit-admin" method="post">
                <div class="input-container">
                    <label>Firstname</label>
                    <input type="text" id="firstname" name="first_name" value="<?php echo $admin['first_name'] ?>"/>
                    <div id="name-warning"></div>
                    <label>Lastname</label>
                    <input type="text" id="lastname" name="last_name" value="<?php echo $admin['last_name'] ?>"/>
                    <div id="last-name-warning"></div>
                </div>
                <div class="input-container">
                    <label>Admin Profile Name</label>
                    <input type="text" id="username" name="username" value="<?php echo $admin['username'] ?>"/>
                    <div id="username-warning"></div>
                </div>
                <div class="password-container" style="padding:20px;">
                            <div class="input-container">
                                <label>Admin Profile Email</label>
                                <input type="text" id="email" name="email" value="<?php echo $admin['email'] ?>"/>
                                <div id="email-warning"></div>
                            </div>
                            <div class="input-container">
                                <label>Password</label>
                                <input type="password" id="password" name="password"/>
                                <div id="password-warning"></div>
                            </div>
                            <div class="input-container">
                                <label>Password Confirm</label>
                                <input type="password" id="password-confirm" name="password_confirm"/>
                                <div id="password-confirm-warning"></div>
                            </div>
                        </div>
                <div id="admin-edit">
                    <input type="hidden" id="current_id" name="current_id" value="<?php echo $id; ?>">
                    <input type="submit" value="Edit Admin">
                </div>
            </form>
                
            </div>
            <a class="back-link" href="<?php echo url_for('/staff/admin/index.php'); ?>">&laquo; Back to List</a>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>