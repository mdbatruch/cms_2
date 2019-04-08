<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    function find_all_admins() {
        global $db;

        $sql = "SELECT * FROM admins 
                ORDER BY id ASC";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_admin_by_id($id) {
        global $db;

        $sql = "SELECT * FROM admins ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "'";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admins = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admins;
    }

    function find_admin_by_username($username) {
        global $db;

        $sql = "SELECT * FROM admins ";
        $sql .= "WHERE username='" . db_escape($db, $username) . "'";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admins = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admins;
    }

    function delete_admin($id) {
        global $db;

        $sql = "DELETE FROM admins ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "'";
        $sql .= "LIMIT 1";
        

        $result = mysqli_query($db, $sql);

        if($result) {
        //    redirect_to(url_for('/staff/admin/index.php'));
            return true;
        } else {
            //if failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function create_admin($admin) {
        global $db;

        $errors = validate_new_admin($admin);

        if(!empty($errors)) {
            return $errors;
        }

        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO admins ";
        $sql .= "(first_name, last_name, email, username, hashed_password) VALUES (";
        $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
        $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
        $sql .= "'" . db_escape($db, $admin['email']) . "',";
        $sql .= "'" . db_escape($db, $admin['username']) . "',";
        $sql .= "'" . db_escape($db, $hashed_password) . "')";

        $result = mysqli_query($db, $sql);

        if ($result) {
            // redirect_to(url_for('/staff/admin/index.php'));
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_admin($admin) {
        global $db;

        $password_sent = !is_blank($admin['password']);

        $errors = validate_admin($admin, ['password_required' => $password_sent]);

        if(!empty($errors)) {
            return $errors;
        }

        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);
        
        $sql = "UPDATE admins SET ";
        $sql .= "username='" . db_escape($db, $admin['username']) . "', ";
        $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
        $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
        $sql .= "email='" . db_escape($db, $admin['email']) . "' ";
        // if ($password_sent) {
        //     $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "' ";
        // }
        $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
        $sql .= "LIMIT 1";
        
        $result = mysqli_query($db, $sql);

        if ($result) {

            return true;
            // redirect_to(url_for('/staff/admin/index.php'));
            
        } else {
            
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
        return $result;
    }

    function validate_admin($admin, $options=[]) {

        $password_required = $options['password_required'] ?? true;

        $check_admin = find_all_admins();

        $fetch_admin = mysqli_fetch_assoc($check_admin);

        $errors = [];

        if (is_blank($_POST['first_name'])) {
            $errors['first_name'] = 'You must enter a First Name!';
        }

        if (is_blank($_POST['last_name'])) {
            $errors['last_name'] = 'You must enter a Last Name!';
        }
        
        if (is_blank($_POST['username'])) {
            $errors['username'] = 'You must enter a Username!';
        } else if ($_POST['username'] === $fetch_admin['username']) {
            $errors['username'] = 'That username already exists, please choose another username!';
        }

        if (is_blank($_POST['email'])) {
            $errors['email'] = 'You must enter an email!';
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Please enter a valid email!';
        } else if ($_POST['email'] === $fetch_admin['email']) {
            $errors['email'] = 'This email already exists. Please choose another email.';
        }

        if ($password_required) {
            if (strlen($_POST['password']) <= 5) {
                $errors['password'] = 'Please enter a password with 5 or more characters!';
            } else if (!preg_match('/[A-Z]/', $_POST['password'])) {
                $errors['password'] = 'You must include an uppercase letter!';
            }  else if (!preg_match('/[a-z]/', $_POST['password'])) {
                $errors['password'] = 'You must include an lowercase letter!';
            } else if (!preg_match('/[0-9]/', $_POST['password'])) {
                $errors['password'] = 'You must include a number!';
            } else if (!preg_match('/[^A-Za-z0-9\s]/', $_POST['password'])) {
                $errors['password'] = 'You must include a symbol!';
            }



            if ($_POST['password'] !== $_POST['password_confirm'] ) {
                $errors['password_confirm'] = 'The passwords do not match';
            } else if (is_blank($_POST['password_confirm'])) {
                $errors['password_confirm'] = 'Please retype your password';
            }
        }

        return $errors;
    }

    function validate_new_admin($admin) {

        $check_admin = find_all_admins();

        $fetch_admin = mysqli_fetch_assoc($check_admin);

        $errors = [];

        if (is_blank($_POST['first_name'])) {
            $errors['first_name'] = 'You must enter a First Name!';
        }

        if (is_blank($_POST['last_name'])) {
            $errors['last_name'] = 'You must enter a Last Name!';
        }
        
        if (is_blank($_POST['username'])) {
            $errors['username'] = 'You must enter a Username!';
        } else if ($_POST['username'] === $fetch_admin['username']) {
            $errors['username'] = 'That username already exists, please choose another username!';
        }

        if (is_blank($_POST['email'])) {
            $errors['email'] = 'You must enter an email!';
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Please enter a valid email!';
        } else if ($_POST['email'] === $fetch_admin['email']) {
            $errors['email'] = 'This email already exists. Please choose another email.';
        }

        if (strlen($_POST['password']) <= 5) {
            $errors['password'] = 'Please enter a password with 5 or more characters!';
        } else if (!preg_match('/[A-Z]/', $_POST['password'])) {
            $errors['password'] = 'You must include an uppercase letter!';
        }  else if (!preg_match('/[a-z]/', $_POST['password'])) {
            $errors['password'] = 'You must include an lowercase letter!';
        } else if (!preg_match('/[0-9]/', $_POST['password'])) {
            $errors['password'] = 'You must include a number!';
        } else if (!preg_match('/[^A-Za-z0-9\s]/', $_POST['password'])) {
            $errors['password'] = 'You must include a symbol!';
        } 
        
        // else if (!preg_match('/^[[:alnum:][:punct:]]+$/', $_POST['password'])) {
        //     $errors['password'] = 'You must include an uppercase and lowercase letter, along with a number and symbol!';
        // }

        if ($_POST['password'] !== $_POST['password_confirm'] ) {
            $errors['password_confirm'] = 'The passwords do not match';
        } else if (is_blank($_POST['password_confirm'])) {
            $errors['password_confirm'] = 'Please retype your password';
        }

        return $errors;
    }

    function find_all_subjects($options=[]) {
        
        global $db;
        
        $visible = $options['visible'] ?? false;
        
        $sql = "SELECT * FROM subjects ";
        if ($visible) {
            $sql .= "WHERE visible = true ";
        }
        $sql .= "ORDER BY id ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_subject_by_id($id, $options=[]) {
        
        global $db;
        
        $visible = $options['visible'] ?? false;
        
        $sql = "SELECT * FROM subjects ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        if($visible) {
            $sql .= "AND visible = true ";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $subject;
    }

    function find_subject_by_name($name, $options=[]) {
        
        global $db;
        
        $visible = $options['visible'] ?? false;
        
        $sql = "SELECT * FROM subjects ";
        $sql .= "WHERE menu_name='" . db_escape($db, $name) . "' ";
        if($visible) {
            $sql .= "AND visible = true ";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $subject;
    }

    function update_subject($subject) {
        
        global $db;
        
        $errors = validate_subject($subject);
        
        if(!empty($errors)) {
            return $errors;
        }

        $old_subject = find_subject_by_id($subject['id']);
        $old_position = $old_subject['position'];
        shift_subject_positions($old_position, $subject['position'], $subject['id']);
        
        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name = '" . db_escape($db, $subject['menu_name']) . "', ";
        $sql .= "position = '" . db_escape($db, $subject['position']) . "', ";
        $sql .= "visible= '" . db_escape($db, $subject['visible']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
        $sql .= "LIMIT 1";
        
        $result = mysqli_query($db, $sql);
        
        if ($result) {
            return true;
            
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    }

    function insert_subject($subject) {

        global $db;
        
        // $errors = validate_subject($subject);
        
        // if(!empty($errors)) {
        //     return $errors;
        // }

        shift_subject_positions(0, $subject['position']);
        
        $sql = "INSERT INTO subjects ";
        $sql .= "(menu_name, position, visible) ";
        $sql .= "VALUES (";    
        $sql .= "'" . db_escape($db, $subject['menu_name']) . "',";
        $sql .= "'" . db_escape($db, $subject['position']) . "',";
        $sql .= "'" . db_escape($db, $subject['visible']) . "'";
        $sql .= ")";

        $result = mysqli_query($db, $sql);

        if($result) {
            //if passed
//            $new_id = mysqli_insert_id($db);
//            redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));
//            redirect_to(url_for('/staff/subjects/index.php'));
            return true;
        } else {
            //if failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    
    }

    function delete_subject($id) {
    
    global $db;
        
    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    
    //for delete statments, result is true or false

    $old_subject = find_subject_by_id($subject['id']);
    $old_position = $old_subject['position'];
    shift_subject_positions($old_position, 0, $id);
    
    if($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
        }
    }

    function validate_subject($subject) {

        $errors = [];
        $data = [];
        
        if(is_blank($subject['subject_name'])) {
//            $errors[] = "Name can't be blank";
            $errors['subject_name'] = "Name can't be blank";
        } elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors['subject_name'] = "Name must be between 2 and 255 characters";
        }
        
        // $position_int = (int) $subject['position'];
        
        // if($position_int <= 0) {
        //     $errors[] = "Position must be greater than zero";
        // }
        
        // if($position_int > 999) {
        //     $errors = "Position must be less than 999";
        // }
        
        // $visible_str = (string) $subject['visible'];
        // if(!has_inclusion_of($visible_str, ["0","1"])) {
        //     $errors[] = "Visible must be true or false";
        // }

        if(!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
            $data['message'] = 'There was an error with your submission';
        }

        return $errors;

        // echo json_encode($data);
    }

//     function insert_pages($pages) {
        
//         global $db;
        
//         // $errors = validate_page($pages);
        
        
//         // if (count($errors)>0) {
//         //     return $errors;
//         // }

//         shift_page_positions(0, $pages['position'], $pages['subject_id']);
        
//         $sql = "INSERT INTO pages ";
//         $sql .= "(subject_id, menu_name, position, visible,"; 
//         $sql .= " content) ";
//         $sql .= "VALUES (";
//         $sql .= "'" . $pages['subject_id'] . "',";
//         $sql .= "'" . $pages['page_name'] . "',";
//         $sql .= "'" . $pages['position'] . "',";
//         $sql .= "'" . $pages['visible'] . "',";
//         $sql .= "'" . $pages['content'] . "')";
        
//         $result = mysqli_query($db, $sql);
     
//         if($result) {
//             return true;

//         } else {
//             echo mysqli_error($db);
//             db_disconnect($db);
//             exit;
//         }
        
// //        return $result;
//     }

    function find_all_pages() {
        global $db;

        $sql = "SELECT * FROM pages ";
        $sql .= "ORDER BY id ASC, position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_all_pages_by_id($id, $options=[]){

    global $db;
        
        $visible = $options['visible'] ?? false;
        
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        if($visible) {
            $sql .= "AND visible = true";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $pages = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $pages;
    }

    function find_all_pages_by_name($menu_name, $options=[]){

        global $db;
            
            $visible = $options['visible'] ?? false;
            
            $sql = "SELECT * FROM pages ";
            $sql .= "WHERE menu_name='" . db_escape($db, $menu_name) . "' ";
            if($visible) {
                $sql .= "AND visible = true";
            }
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);
            $pages = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            return $pages;
        }

    function update_page($pages){
        
        global $db;
        
        $errors = validate_page($pages);
        
        if (!empty($errors)){
            return $errors;
        }

        $old_page = find_all_pages_by_id($subject['id']);
        $old_position = $old_page['position'];

        shift_page_positions($old_position, $pages['position'], $pages['subject_id'], $page['id']);
        
        $sql = "UPDATE pages SET ";
        $sql .= "menu_name='" . db_escape($db, $pages['menu_name']) . "',";
        $sql .= "subject_id='" . db_escape($db, $pages['subject_id']) . "',";
        $sql .= "position='" . db_escape($db, $pages['position']) . "',";
        $sql .= "visible='" . db_escape($db, $pages['visible']) . "',";
        $sql .= "content='" . db_escape($db, $pages['content']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $pages['id']) . "'";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);

        if($result){
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
        
        return $result;
    }

    function delete_page($id){
        
        global $db;

        $old_page = find_all_pages_by_id($subject['id']);
        $old_position = $old_page['position'];

        shift_page_positions($old_position, 0, $old_page['subject_id'], $id);
        
        $sql = "DELETE FROM pages ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        
        $result = mysqli_query($db, $sql);
        
        if ($result) {
        //redirect
//            redirect_to(url_for('/staff/pages/index.php'));
            return true;
        } else {
            
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
        
        return $result;
    }

    function validate_page($pages) {

    $errors = [];
        
        $current_id = $page['id'] ?? '0';
        
//        if (!has_unique_page_menu_name($pages['menu_name'], $current_id)) {
//            $errors[] = 'Choose a name that is not already taken';
//        }
        
       if (empty($pages['menu_name'])) {
           $errors[] = 'You must include a menu name.';
       } elseif (!has_length($pages['menu_name'], ['min' => 7, 'max' => 255]) ){
           $errors[] = 'You must have more than 1 character';
       }
    
        if (empty($pages['subject_id'])) {
            $errors[] = 'Please add a subject Id';
        }
        
        $visible = (int)$pages['visible'];
        
//        if ($visible === 0) {
//            $errors[] = 'Please check the visible box.';
//        }
        
        if (is_blank($pages['content'])) {
            $errors[] = 'Please add some content';
        }
    
        return $errors;
        
    }

    function has_unique_page_menu_name($menu_name, $current_id="0") {
        
        global $db;
        
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE menu_name='" . db_escape($db, $menu_name) . "' ";
        $sql .= "AND id != '" . db_escape($db, $current_id) . "'";
        
        $pages_set = mysqli_query($db, $sql);
        $page_count = mysqli_num_rows($pages_set);
        mysqli_free_result($pages_set);
        
        return $page_count === 0;
        
    }

    function find_pages_by_subject_id($subject_id, $options=[]){

    global $db;
        
        $visible = $options['visible'] ?? false;
        
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "'";
        if($visible) {
            $sql .= "AND visible = true ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        
    return $result;
        
    }

    function count_pages_by_subject_id($subject_id, $options=[]){

        global $db;
            
            $visible = $options['visible'] ?? false;
            
            $sql = "SELECT COUNT(id) FROM pages ";
            $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "'";
            if($visible) {
                $sql .= "AND visible = true ";
            }
            $sql .= "ORDER BY position ASC";
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);

            $row = mysqli_fetch_row($result);

            mysqli_free_result($result);

            $count = $row[0];

            
        return $count;
            
        }

    function shift_page_positions($start_pos, $end_pos, $subject_id, $current_id=0) {
        global $db;
    
        if($start_pos == $end_pos) { return; }
    
        $sql = "UPDATE pages ";
        if($start_pos == 0) {
            // new item, +1 to items greater than $end_pos
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        } elseif($end_pos == 0) {
            // delete item, -1 from items greater than $start_pos
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        } elseif($start_pos < $end_pos) {
            // move later, -1 from items between (including $end_pos)
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
            $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
        } elseif($start_pos > $end_pos) {
            // move earlier, +1 to items between (including $end_pos)
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
            $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
        }
        // Exclude the current_id in the SQL WHERE clause
        $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
        $sql .= "AND subject_id='" . $subject_id . "'";
    
        $result = mysqli_query($db, $sql);
        // For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function shift_subject_positions($start_pos, $end_pos, $current_id=0) {
        global $db;
    
        if($start_pos == $end_pos) { return; }
    
        $sql = "UPDATE subjects ";
        if($start_pos == 0) {
            // new item, +1 to items greater than $end_pos
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        } elseif($end_pos == 0) {
            // delete item, -1 from items greater than $start_pos
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        } elseif($start_pos < $end_pos) {
            // move later, -1 from items between (including $end_pos)
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
            $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
        } elseif($start_pos > $end_pos) {
            // move earlier, +1 to items between (including $end_pos)
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
            $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
        }
        // Exclude the current_id in the SQL WHERE clause
        $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
    
        $result = mysqli_query($db, $sql);
        // For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    // function shift_subject_positions($start_pos, $end_pos, $current_id=0) {

    //     global $db;

    //     $sql = "UPDATE subjects ";

    //     if ($start_pos == 0) {
    //         // new item
    //        $sql .= "SET position = position + 1";
    //        $sql .= "WHERE position >= " . $subject['position'];

    //     } elseif ($end_pos == 0) {
    //          // delete item
    //        $sql .= "SET position = position - 1";
    //        $sql .= "WHERE position > " . $subject['position'];

    //     } elseif($start_pos < $end_pos) {
    //         // move later
    //     } elseif ($start_pos > $end_pos) {
    //         // move earlier
    //     }

    //     $sql .= "AND id != '" . $current_id) . "' ";

    //     $result = mysqli_query($db, $sql);

    //     if ($result) {
    //         return true;
    //     } else {

    //         echo mysqli_error($db);
    //         db_disconnect($db);
    //         exit;
    //     }
    // }

    // UPDATE subjects
    // SET position = position - 1
    // WHERE position > 2
    // AND position <= 6
    // AND if != 8;


?>