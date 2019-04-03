<?php
    require_once('../../../private/initialize.php');

    // require_login();

    $page_title = 'Admin New';

    // if (is_post_request()){
    //     $admin = [];
    //     $admin['first_name'] = $_POST['first_name'];
    //     $admin['last_name'] = $_POST['last_name'];
    //     $admin['username'] = $_POST['username'];
    //     $admin['email'] = $_POST['email'];
    //     $admin['password'] = $_POST['password'];
    //     $admin['password_confirm'] = $_POST['password_confirm'];
    
    //     $result = create_admin($admin);

    //     if ($result === true) {

    //         $new_id = mysqli_insert_id($db);

    //         $_SESSION['status'] = 'You have created a new admin';

    //         redirect_to(url_for('/staff/admin/show.php?id=' . $new_id));

    //     } else {

    //        $errors = $result;
    //     }

        
    // }

    include(SHARED_PATH . '/staff-header.php');
?>

        <div id="content">
            <div id="main-menu">
                <h2>Create a New Admin</h2>
                   <!-- <form id="new-admin" action="<php echo url_for('staff/admin/new.php'); ?>" method="post"> -->
                   <div id="form-message"></div>
                   <form id="new-admin" method="post">
                        <div class="input-container">
                            <label>First Name</label>
                            <input type="text" id="firstname" name="first_name"/>
                            <div id="name-warning"></div>
                        </div>
                        <div class="input-container">
                            <label>Last Name</label>
                            <input type="text" id="lastname" name="last_name"/>
                            <div id="last-name-warning"></div>
                        </div>
                        <div class="input-container">
                            <label>Username</label>
                            <input type="text" id="username" name="username"/>
                            <div id="username-warning"></div>
                        </div>
                        <div class="password-container" style="padding:20px;">
                            <div class="input-container">
                                <label>Email</label>
                                <input type="text" id="email" name="email"/>
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
                        <input type="submit"/>
                   </form> 
            </div>
            <a class="back-link" href="<?php echo url_for('/staff/admin/index.php'); ?>">&laquo; Back to List</a>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>