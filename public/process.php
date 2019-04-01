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
      
          $errors['username'] = 'Username cannot be a blank';
      
        } else {
      
          $sql = "SELECT * FROM admins ";
          $sql .= "WHERE username='" . $username . "'";
      
          $result = mysqli_query($db, $sql);
          confirm_result_set($result);
      
          if (mysqli_num_rows($result) === 0) {
            $errors['username'] = 'This username does not exist';
          } else {
            if (empty($password)) {
      
              $errors['password'] = 'Password cannot be a blank';
      
            } else {
      
                $sql_password = "SELECT * FROM admins ";
                $sql_password .= "WHERE username='" . $username . "' ";
                $sql_password .= "AND hashed_password='" . $password . "'";
      
                $result_password = mysqli_query($db, $sql_password);
                confirm_result_set($result_password);
      
                if (mysqli_num_rows($result_password) == 0) {
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

            $redirect = dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . $id_check['id'];
    
            $data['success'] = true;
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

            $redirect = dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . $sql_subject_pull['id'];

            $data['success'] = true;
            $data['message'] = 'You have successfully edited the subject';
            $data['redirect'] = $redirect;

        }

        echo json_encode($data);
        
    break;

    case 'new-page':

        $pageid = $_POST['page_id'];

        if(empty($_POST['name'])) {
            $errors['name'] = "Page name can't be blank";
        }

        $sql_page_check = "SELECT * from pages ";
        $sql_page_check .= "WHERE menu_name='" . $_POST['name'] . "' ";
        $sql_page_check .= "AND subject_id='" . $_POST['subject_id'] . "'";

        $name_check = mysqli_query($db, $sql_page_check);
        confirm_result_set($name_check);

        if (mysqli_num_rows($name_check) > 0){
            $errors['name'] = "This name already exists, please choose another one";
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

            $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' . $pageid . '&subject_id=' . $_POST['subject_id'];

    
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
            
            if ($result) {

                $new_id = mysqli_insert_id($db);

                $data['success'] = true;
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
        $pages['page_name'] = $_POST['page_name'] ?? '';
        $pages['position'] = $_POST['position'] ?? '';
        $pages['visible'] = $_POST['visible'] ?? '';
        $pages['content'] = $_POST['content'] ?? '';
        $pages['subject_id'] = $_POST['subject_id'] ?? '';

        if (empty($_POST['name'])) {
            $errors['name'] = 'Page name can\'t be blank';
        }

        $sql_page_check = "SELECT * from pages ";
        $sql_page_check .= "WHERE menu_name='" . $_POST['name'] . "' ";
        $sql_page_check .= "AND subject_id='" . $_POST['subject_id'] . "'";

        $name_check = mysqli_query($db, $sql_page_check);
        confirm_result_set($name_check);

        if (mysqli_num_rows($name_check) > 0){
            $errors['name'] = "This name already exists, please choose another one";
        }

        if(!empty($errors)) {
            $data['success'] = false;
            $data['message'] = 'There were errors with your form';
            $data['errors'] = $errors;
        } else {

            $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' . $pages['page_id'] . '&subject_id=' . $_POST['subject_id'];

            $sql = "UPDATE pages SET ";
            $sql .= "menu_name='" . db_escape($db, $pages['page_name']) . "',";
            $sql .= "subject_id='" . db_escape($db, $pages['subject_id']) . "',";
            $sql .= "position='" . db_escape($db, $pages['position']) . "',";
            $sql .= "visible='" . db_escape($db, $pages['visible']) . "',";
            $sql .= "content='" . db_escape($db, $pages['content']) . "' ";
            $sql .= "WHERE id='" . db_escape($db, $pages['id']) . "'";
            $sql .= "LIMIT 1";

            $result = mysqli_query($db, $sql);
            confirm_result_set($result);

            // find_page_by_id($pages['id']);

            $data['success'] = true;
            $data['message'] = 'This page has been successfully edited';
            $data['redirect'] = $page_path;
        }
        
        echo json_encode($data);

    break;

}

?>