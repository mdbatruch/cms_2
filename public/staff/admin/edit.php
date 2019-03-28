<?php
    require_once('../../../private/initialize.php');

    require_login();

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/pages/index.php'));
    }
    
    $id = $_GET['id'];

    $page_title = 'Admin Edit';

    $admin = find_admin_by_id($id);

    if(is_post_request()){

        $admin = [];
        $admin['id'] = $id;
        $admin['username'] = $_POST['username'];
        $admin['first_name'] = $_POST['first_name'];
        $admin['last_name'] = $_POST['last_name'];
        $admin['email'] = $_POST['email'];
        $admin['password'] = $_POST['password'];
        $admin['password_confirm'] = $_POST['password_confirm'];

        $admins_list = update_admin($admin);

        if ($admins_list === true) {

            $_SESSION['status'] = 'you have edited an admin';

            redirect_to(url_for('staff/admin/show.php?id=' . $id));
        } else {
            $errors = $admins_list;
        }

    }

    include(SHARED_PATH . '/staff-header.php');
?>

        <div id="content">
            <div id="main-menu">
                <h2>Update Admin <?php echo $id; ?></h2>
                <p>Edit</p>
                <!-- <php 
                    echo display_errors($errors);
                > -->
            <form action="<?php echo url_for('/staff/admin/edit.php?id=' . $id); ?>" method="post">
                <div class="input-container">
                    <label>Firstname</label>
                    <input type="text" name="first_name" value="<?php echo $admin['first_name'] ?>"/>
                    <?php 
                        if (isset($errors['first_name'])) {
                            echo $errors['first_name'];
                        }
                    ?>
                    <label>Lastname</label>
                    <input type="text" name="last_name" value="<?php echo $admin['last_name'] ?>"/>
                    <?php 
                        if (isset($errors['last_name'])) {
                            echo $errors['last_name'];
                        }
                    ?>
                </div>
                <div class="input-container">
                    <label>Admin Profile Name</label>
                    <input type="text" name="username" value="<?php echo $admin['username'] ?>"/>
                    <?php 
                        if (isset($errors['username'])) {
                            echo $errors['username'];
                        }
                    ?>
                </div>
                <div class="password-container" style="padding:20px;">
                            <div class="input-container">
                                <label>Admin Profile Email</label>
                                <input type="text" name="email" value="<?php echo $admin['email'] ?>"/>
                                <?php 
                                    if (isset($errors['email'])) {
                                        echo $errors['email'];
                                    }
                                ?>
                            </div>
                            <!-- <div class="input-container">
                                <label>Password</label>
                                <input type="password" name="password"/>
                                <php 
                                    if (isset($errors['password'])) {
                                        echo $errors['password'];
                                    }
                                ?>
                            </div>
                            <div class="input-container">
                                <label>Password Confirm</label>
                                <input type="password" name="password_confirm"/>
                                <php 
                                    if (isset($errors['password_confirm'])) {
                                        echo $errors['password_confirm'];
                                    }
                                ?>
                            </div> -->
                        </div>
                <div id="admin-edit">
                    <input type="submit" value="Edit Admin">
                </div>
            </form>
                
            </div>
            <a class="back-link" href="<?php echo url_for('/staff/admin/index.php'); ?>">&laquo; Back to List</a>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>