<?php
    require_once('../../../private/initialize.php');

    // require_login();

    $page_title = 'Admin New';

    if (is_post_request()){
        $admin = [];
        $admin['first_name'] = $_POST['first_name'];
        $admin['last_name'] = $_POST['last_name'];
        $admin['username'] = $_POST['username'];
        $admin['email'] = $_POST['email'];
        $admin['password'] = $_POST['password'];
        $admin['password_confirm'] = $_POST['password_confirm'];
    
        $result = create_admin($admin);

        if ($result === true) {

            $new_id = mysqli_insert_id($db);

            $_SESSION['status'] = 'You have created a new admin';

            redirect_to(url_for('/staff/admin/show.php?id=' . $new_id));

        } else {

           $errors = $result;
        }

        
    }

    include(SHARED_PATH . '/staff-header.php');
?>

        <div id="content">
            <div id="main-menu">
                <h2>Create a New Admin</h2>
                   <form action="<?php echo url_for('staff/admin/new.php'); ?>" method="post">
                        <div class="input-container">
                            <label>First Name</label>
                            <input type="text" name="first_name"/>
                            <?php 
                                if (isset($errors['first_name'])) {
                                    echo $errors['first_name'];
                                }
                            ?>
                        </div>
                        <div class="input-container">
                            <label>Last Name</label>
                            <input type="text" name="last_name"/>
                            <?php 
                                if (isset($errors['last_name'])) {
                                    echo $errors['last_name'];
                                }
                            ?>
                        </div>
                        <div class="input-container">
                            <label>Username</label>
                            <input type="text" name="username"/>
                            <?php 
                                if (isset($errors['username'])) {
                                    echo $errors['username'];
                                }
                            ?>
                        </div>
                        <div class="password-container" style="padding:20px;">
                            <div class="input-container">
                                <label>Email</label>
                                <input type="text" name="email"/>
                                <?php 
                                    if (isset($errors['email'])) {
                                        echo $errors['email'];
                                    }
                                ?>
                            </div>
                            <div class="input-container">
                                <label>Password</label>
                                <input type="password" name="password"/>
                                <?php 
                                    if (isset($errors['password'])) {
                                        echo $errors['password'];
                                    }
                                ?>
                            </div>
                            <div class="input-container">
                                <label>Password Confirm</label>
                                <input type="password" name="password_confirm"/>
                                <?php 
                                    if (isset($errors['password_confirm'])) {
                                        echo $errors['password_confirm'];
                                    }
                                ?>
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