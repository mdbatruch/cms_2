<?php

    require('../private/db_credentials.php');
    require('../private/database.php');
    require('../private/query_functions.php');

    $db = db_connect();

    $data = [];
    $errors = [];

    $id = $_POST['id'];

switch($id){

    case 'login':

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
      
        if (empty($username)) {
      
          $errors['username'] = 'Username cannot be blank';
      
        } else {
      
          $sql = "SELECT * FROM admins ";
          $sql .= "WHERE username='" . $username . "'";
      
          $result = mysqli_query($db, $sql);
          confirm_result_set($result);

          $result_password = mysqli_fetch_assoc($result);
      
          if (mysqli_num_rows($result) === 0) {
            $errors['username'] = 'This username does not exist';
          } else {
            if (empty($password)) {
      
              $errors['password'] = 'Password cannot be blank';
      
            } else {
      
                // $sql_password = "SELECT * FROM admins ";
                // $sql_password .= "WHERE username='" . $username . "' ";
                // $sql_password .= "AND hashed_password='" . $password . "'";
      
                // $result_password = mysqli_query($db, $sql_password);
                // confirm_result_set($result_password);
      
                // if (mysqli_num_rows($result_password) == 0) {
                //   $errors['password'] = 'Incorrect Password';
                // }

                if (!password_verify($password, $result_password['hashed_password'])) {
                    $errors['password'] = 'Incorrect Password';
                }
            }
          }
        }

      
        if (!empty($errors)) {
      
            $data['message'] = 'There was an error with your form. Please try again.';
            $data['success'] = false;
            $data['errors'] = $errors;
      
        } else {
      
          $data['redirect'] = 'http://localhost:8888/cms_2/public/staff/index.php';
          $data['message'] = 'Logging you in now.';
          $data['success'] = true;
      
          session_start();
          session_regenerate_id();

          $_SESSION['username'] = $username;
          $_SESSION['last_login'] = time();
      
        }
      
      echo json_encode($data);

    break;

    case 'new-subject':

        if(empty($_POST['subject_name'])) {
                $errors['subject_name'] = "Subject can't be blank";
            }
    
            $sql_check = "SELECT * FROM subjects ";
            $sql_check .= "WHERE menu_name='" . $_POST['subject_name'] . "' ";
    
            $duplicate_check = mysqli_query($db, $sql_check);
            confirm_result_set($duplicate_check);
    
            if (mysqli_num_rows($duplicate_check) > 0 ) {
                $errors['subject_name'] = "This subject is already taken, please choose another one.";
            }
    
            if(!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
                $data['message'] = 'There was an error with your submission';
            } else {
    
            shift_subject_positions(0, $_POST['position']);
            
            $sql = "INSERT INTO subjects ";
            $sql .= "(menu_name, position, visible) ";
            $sql .= "VALUES (";    
            $sql .= "'" . db_escape($db, $_POST['subject_name']) . "',";
            $sql .= "'" . db_escape($db, $_POST['position']) . "',";
            $sql .= "'" . db_escape($db, $_POST['visible']) . "'";
            $sql .= ")";
    
            $result = mysqli_query($db, $sql);
    
            $sql_id = "SELECT id FROM subjects ";
            $sql_id .= "WHERE menu_name='" . $_POST['subject_name'] . "' ";
            $sql_id .= "LIMIT 1";
    
            $result_check = mysqli_query($db, $sql_id);
            confirm_result_set($result_check);
    
            $id_check = mysqli_fetch_assoc($result_check);

            $data['success'] = true;
            $data['status'] = "new";

            $redirect = dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . $id_check['id'] . '&status=' . $data['status'];
    
            $data['message'] = 'You have created a Subject!';
            $data['redirect'] = $redirect;
    
            }
    
        echo json_encode($data);

    break;

    case 'edit-subject':

        $subject = [];
        $subject['id'] = $_POST['subject_id'];
        $subject['subject_name'] = $_POST['subject_name'] ?? '';
        $subject['position'] = $_POST['position'] ?? '';
        $subject['visible'] = $_POST['visible'] ?? '';

        if (empty($_POST['subject_name'])) {
            $errors['subject_name'] = "Name can't be blank";
        }


        if (!empty($errors)) {
            
            $data['success'] = false;
            $data['message'] = 'There were errors. Please try again';
            $data['errors'] = $errors;

        } else {

            $sql = "UPDATE subjects SET ";
            $sql .= "menu_name='" . db_escape($db, $subject['subject_name']) . "', ";
            $sql .= "position='" . db_escape($db, $subject['position']) . "', ";
            $sql .= "visible='" . db_escape($db, $subject['visible']) . "' ";
            $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
            $sql .= "LIMIT 1";

            $sql_subject_edit = mysqli_query($db, $sql);
            confirm_result_set($sql_subject_edit);

            $sql_subject_pull = find_subject_by_id($subject['id']);

            $data['success'] = true;
            $data['status'] = "edited";

            $redirect = dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . $sql_subject_pull['id'] . '&status=' . $data['status'];
            // $_SESSION['status'] = "You Have edited a subject";
            $data['message'] = 'You have successfully edited the subject';
            $data['redirect'] = $redirect;

        }

        echo json_encode($data);
        
    break;

    case 'new-page':

        // $pageid = $_POST['page_id'];

        // $pages_count = find_pages_by_subject_id($_POST['subject_id']);

        // $pages_count_array = mysqli_fetch_all($pages_count);

        // // echo '<pre>';
        // // print_r($pages_count_array);

        // foreach ($pages_count_array as $key => $value) {
        //     $page_id = $value['0'] + 1;
        // }
    
        // echo $page_id;

        if(empty($_POST['name'])) {
            $errors['name'] = "Page name can't be blank";
        }

        $sql_page_check = "SELECT * from pages ";
        $sql_page_check .= "WHERE menu_name='" . $_POST['name'] . "' ";
        $sql_page_check .= "AND subject_id='" . $_POST['subject_id'] . "'";

        $name_check = mysqli_query($db, $sql_page_check);
        confirm_result_set($name_check);

        if (mysqli_num_rows($name_check) > 0){
            $errors['name'] = "This topic already exists in this subject, please choose another one";
        }

        if(!empty($errors)) {

            $data['message'] = 'There was an error with your form, please try again';
            $data['success'] = false;
            $data['errors'] = $errors;

        }   else {

            $sql_page = "SELECT * from pages";

            $page_check = mysqli_query($db, $sql_page);
            confirm_result_set($page_check);

            $id_count = mysqli_num_rows($page_check) + 1;

            // $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' . $pageid . '&subject_id=' . $_POST['subject_id'];
            // $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?subject_id=' . $_POST['subject_id'] . '&id=' . $page_id;

    
            shift_page_positions(0, $_POST['position'], $_POST['subject_id']);
            
            $sql = "INSERT INTO pages ";
            $sql .= "(subject_id, menu_name, position, visible,"; 
            $sql .= " content) ";
            $sql .= "VALUES (";
            $sql .= "'" . db_escape($db, $_POST['subject_id']) . "',";
            $sql .= "'" . db_escape($db, $_POST['name']) . "',";
            $sql .= "'" . db_escape($db, $_POST['position']) . "',";
            $sql .= "'" . db_escape($db, $_POST['visible']) . "',";
            $sql .= "'" . db_escape($db, $_POST['content']) . "')";
            
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);

            $id_find = "SELECT * FROM pages ";
            $id_find .= "WHERE menu_name='" . $_POST['name'] . "'";

            $id_query = mysqli_query($db, $id_find);

            $id_query_result = mysqli_fetch_assoc($id_query);
            
            if ($result) {

                $new_id = mysqli_insert_id($db);

                $data['success'] = true;
                $data['status'] = 'created';

                $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?subject_id=' . $_POST['subject_id'] . '&id=' . $id_query_result['id'] . '&status=' . $data['status'];

                $data['message'] = 'Success! Your Page has been submitted!';

                $data['redirect'] = $page_path;
                
            } else {
                
                $data['message'] = 'We could not submit your page at this time';
            }
        
        }

        echo json_encode($data);

    break;

    case 'edit-page':
    
        $pages = [];
        $pages['id'] = $id;
        $pages['page_id'] = $_POST['page_id'];
        $pages['page_name'] = $_POST['name'] ?? '';
        $pages['position'] = $_POST['position'] ?? '';
        $pages['visible'] = $_POST['visible'] ?? '';
        $pages['content'] = $_POST['content'] ?? '';
        $pages['subject_id'] = $_POST['subject_id'] ?? '';

        $pages_list = find_all_pages();

        $page_check = mysqli_fetch_all($pages_list);

        if (empty($_POST['name'])) {
            $errors['name'] = 'Page name can\'t be blank';
        } else {
            foreach ($page_check as $key => $value) {
                // echo $_POST['name'] . '<-- you<br/>';
                // echo $value['2'] . '<br/>';
                // echo $_POST['page_id']. '<-- you<br/>';
                // echo $value['0'] . '<br/>';
                if ($_POST['name'] == $value['2'] && $_POST['page_id'] != $value['0']) {
                    // echo $value['4'] . '<br>';
                    $errors['name'] = 'This name is already taken. Please select another one';
                }
            }
        }

        // $sql_page_check = "SELECT * from pages ";
        // $sql_page_check .= "WHERE menu_name='" . $_POST['name'] . "' ";
        // $sql_page_check .= "AND subject_id='" . $_POST['subject_id'] . "'";

        // $name_check = mysqli_query($db, $sql_page_check);
        // confirm_result_set($name_check);

        // if (mysqli_num_rows($name_check) > 0){
        //     $errors['name'] = "This name already exists, please choose another one";
        // }

        if(!empty($errors)) {
            $data['success'] = false;
            $data['message'] = 'There were errors with your form';
            $data['errors'] = $errors;
        } else {

            // $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' . $pages['page_id'] . '&subject_id=' . $_POST['subject_id'] . '&status=' . $data['status'];

            $sql = "UPDATE pages SET ";
            $sql .= "menu_name='" . db_escape($db, $pages['page_name']) . "',";
            $sql .= "subject_id='" . db_escape($db, $pages['subject_id']) . "',";
            $sql .= "position='" . db_escape($db, $pages['position']) . "',";
            $sql .= "visible='" . db_escape($db, $pages['visible']) . "',";
            $sql .= "content='" . db_escape($db, $pages['content']) . "' ";
            $sql .= "WHERE id='" . db_escape($db, $_POST['page_id']) . "'";
            $sql .= "LIMIT 1";

            $result = mysqli_query($db, $sql);
            // confirm_result_set($result);

            if (!$result) {
                echo mysqli_error($db);
                db_disconnect($db);
                exit;
            }

            // find_page_by_id($pages['id']);

            $data['success'] = true;
            $data['status'] = 'edited';
            $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' . $pages['page_id'] . '&subject_id=' . $_POST['subject_id'] . '&status=' . $data['status'];

            $data['message'] = 'This page has been successfully edited';
            $data['redirect'] = $page_path;
        }
        
        echo json_encode($data);

    break;

    case 'new-admin';

            if (empty($_POST['first_name'])) {
                $errors['name'] = "Name cannot be blank";
            }

            if (empty($_POST['last_name'])) {
                $errors['last_name'] = "Last Name cannot be blank";
            }

            if (empty($_POST['username'])) {
                $errors['username'] = "Username cannot be blank";
            } else {
                $sql = "SELECT * FROM admins ";
                $sql .= "WHERE username='" . $_POST['username'] . "'";
            
                $result = mysqli_query($db, $sql);
                confirm_result_set($result);
            
                if (mysqli_num_rows($result) > 0) {
                    $errors['username'] = 'This username is already taken. Please select another one';
                }
            }

            if (empty($_POST['email'])) {
                $errors['email'] = "Email cannot be blank";
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Must be in valid email format";
            } else {
                $sql = "SELECT * FROM admins ";
                $sql .= "WHERE email='" . $_POST['email'] . "'";
            
                $result = mysqli_query($db, $sql);
                confirm_result_set($result);
            
                if (mysqli_num_rows($result) > 0) {
                    $errors['email'] = 'This email is already taken. Please select another one';
                }
            }

            if (empty($_POST['password'])) {
                $errors['password'] = "Password cannot be blank";
            }

            if (empty($_POST['password_confirm'])) {
                $errors['password_confirm'] = "You need to confirm your password";
            } else if ($_POST['password'] != $_POST['password_confirm']) {
                $errors['password_confirm'] = "This does not match";
            }

            if (!empty($errors)) {
                
                $data['success'] = false;
                $data['message'] = 'There were errors with your submission, please try again';
                $data['errors'] = $errors;
            } else {

                // $sql_count = "SELECT MAX( id ) as max from admins";
                // $sql_count_query = mysqli_query($db, $sql_count);
            
                // $row = mysqli_fetch_assoc( $sql_count_query );
                // $largestNumber = $row['max'] + 1;

                $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $sql = "INSERT INTO admins ";
                $sql .= "(first_name, last_name, email, username, hashed_password) VALUES (";
                $sql .= "'" . db_escape($db, $_POST['first_name']) . "',";
                $sql .= "'" . db_escape($db, $_POST['last_name']) . "',";
                $sql .= "'" . db_escape($db, $_POST['email']) . "',";
                $sql .= "'" . db_escape($db, $_POST['username']) . "',";
                $sql .= "'" . db_escape($db, $hashed_password) . "')";

                $admin_sql = mysqli_query($db, $sql);

                if (!$admin_sql) {
                    echo mysqli_error($db);
                    db_disconnect($db);
                    exit;
                }

                $sql_id = "SELECT * FROM admins ";
                $sql_id .= "WHERE email='" . $_POST['email'] . "'";

                $sql_id_query = mysqli_query($db, $sql_id);

                $id_array = mysqli_fetch_assoc($sql_id_query);
                $current_id = $id_array['id'];

                $data['success'] = true;
                $data['status'] = 'created';
                $admin_path = dirname(dirname($_SERVER['HTTP_REFERER'])) . '/admin/show.php?id=' . $current_id  . '&status=' . $data['status'];

                $data['message'] = 'You have created a new admin';
                $data['redirect'] = $admin_path;
            }


            echo json_encode($data);

    break;

    case 'edit-admin';

            // $sql_id = "SELECT * FROM admins ";
            // $sql_id .= "WHERE email='" . $_POST['email'] . "'";

            // $sql_id_query = mysqli_query($db, $sql_id);

            // $id_array = mysqli_fetch_assoc($sql_id_query);
            // $current_id = $id_array['id'];

            //check entire database

            $admins_list = find_all_admins();

            $admin_check = mysqli_fetch_all($admins_list);

            if (empty($_POST['first_name'])) {
                $errors['name'] = "Name cannot be blank";
            }

            if (empty($_POST['last_name'])) {
                $errors['last_name'] = "Last Name cannot be blank";
            }

            if (empty($_POST['username'])) {
                $errors['username'] = "Username cannot be blank";
            } else {

                foreach ($admin_check as $key => $value) {
                    // echo $value['3'];
                    if ($_POST['username'] == $value['4'] && $_POST['current_id'] != $value['0']) {
                        // echo $value['4'] . '<br>';
                        $errors['username'] = 'This username is already taken. Please select another one';
                    }
                }
    
                // $sql = "SELECT * FROM admins ";
                // $sql .= "WHERE username='" . $_POST['username'] . "' ";
                // $sql .= "AND NOT id='" . $current_id . "'";
            
                // $username_result = mysqli_query($db, $sql);
                // confirm_result_set($username_result);
            
                // if (mysqli_num_rows($username_result) > 0) {
                    // $errors['username'] = 'This username is already taken. Please select another one';
                // }

                // mysqli_free_result($username_result);
            }

            if (empty($_POST['email'])) {
                $errors['email'] = "Email cannot be blank";
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Must be in valid email format";
            } else {

                foreach ($admin_check as $key => $value) {
                    if ($_POST['email'] == $value['3'] && $_POST['current_id'] != $value['0']) {
                        $errors['email'] = 'This email is already taken. Please select another one';
                    }
                }
            }
            
            // else {
            //     $email_sql = "SELECT * FROM admins ";
            //     $email_sql .= "WHERE email='" . $_POST['email'] . "' ";
            //     $email_sql .= "AND NOT id='" . $current_id . "'";
            
            //     $email_result = mysqli_query($db, $email_sql);
            //     confirm_result_set($email_result);
            
            //     if (mysqli_num_rows($email_result) > 0) {
            //         $errors['email'] = 'This email is already taken. Please select another one';
            //     }
            // }

            if (empty($_POST['password'])) {
                $errors['password'] = "Password cannot be blank";
            }

            if (empty($_POST['password_confirm'])) {
                $errors['password_confirm'] = "You need to confirm your password";
            } else if ($_POST['password'] != $_POST['password_confirm']) {
                $errors['password_confirm'] = "This does not match";
            }

            if (!empty($errors)) {
                
                $data['success'] = false;
                $data['message'] = 'There were errors with your submission, please try again';
                $data['errors'] = $errors;
            } else {

                // $sql_count = "SELECT MAX( id ) as max from admins";
                // $sql_count_query = mysqli_query($db, $sql_count);
            
                // $row = mysqli_fetch_assoc( $sql_count_query );
                // $largestNumber = $row['max'] + 1;


                // $sql_id = "SELECT * FROM admins ";
                // $sql_id .= "WHERE email='" . $_POST['email'] . "'";

                // $sql_id_query = mysqli_query($db, $sql_id);

                // $id_array = mysqli_fetch_assoc($sql_id_query);
                // $current_id = $id_array['id'];

                $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $sql = "UPDATE admins SET ";
                $sql .= "first_name='" . db_escape($db, $_POST['first_name']) . "', ";
                $sql .= "last_name='" . db_escape($db, $_POST['last_name']) . "', ";
                $sql .= "email='" . db_escape($db, $_POST['email']) . "', ";
                $sql .= "username='" . db_escape($db, $_POST['username']) . "', ";
                $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "' ";
                $sql .= "WHERE id='" . $_POST['current_id'] . "' ";
                $sql .= "LIMIT 1";

                $admin_sql = mysqli_query($db, $sql);
                // confirm_result_set($admin_sql);

                if (!$admin_sql) {
                        echo mysqli_error($db);
                        db_disconnect($db);
                        exit;
                    }
                    
                $data['status'] = 'edited';
                $data['success'] = true;
                $admin_path = dirname(dirname($_SERVER['HTTP_REFERER'])) . '/admin/show.php?id=' . $_POST['current_id'] . '&status=' . $data['status'];

                $data['message'] = 'You have updated an admin';
                $data['redirect'] = $admin_path;
            }


            echo json_encode($data);

    break;

}

?>