<?php
    require_once('../../private/initialize.php');

    // require('../../private/db_credentials.php');
        // require('../../private/database.php');
        // require('../../private/query_functions.php');

    // $db = db_connect();

    require_login();

    check_session();
    
    $page_title = 'Staff Menu';

    include(SHARED_PATH . '/staff-header.php');

    // global $db;

    // $_POST['subject_name'] = "Subject 4";

    //      $sql_id = "SELECT id FROM subjects ";
    //     $sql_id .= "WHERE menu_name='" . $_POST['subject_name'] . "' ";
    //     $sql_id .= "LIMIT 1";

    //     $result_check = mysqli_query($db, $sql_id);
    //     confirm_result_set($result_check);

    //     $id_check = mysqli_fetch_assoc($result_check);

    //     echo '<pre>';
    //     print_r($id_check);

    // echo 'http://localhost:8888/cms_2/public/staff/index.php' . '<br/>';
    // echo $_SERVER[PHP_SELF];
?>

        <div id="content">
            <div id="main-menu">
                <h2>Main Menu</h2>
                    <ul>
                        <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
                        <!-- <li><a href="<php echo url_for('/staff/pages/index.php'); ?>">Pages</a></li> -->
                        <li><a href="<?php echo url_for('/staff/admin/index.php'); ?>">Admins</a></li>
                    </ul>
            </div>
        </div>
<?php
            include(SHARED_PATH . '/staff-footer.php');
?>