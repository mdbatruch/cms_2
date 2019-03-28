<?php

        // $subject = [];
        // $subject['subject_name'] = $_POST['menu_name'] ?? '';
        // $subject['position'] = $_POST['position'] ?? '';
        // $subject['visible'] = $_POST['visible'] ?? '';

        require('../../../private/db_credentials.php');
        require('../../../private/database.php');
        require('../../../private/query_functions.php');

        $db = db_connect();

        $errors = [];
        $data = [];

        
        if(empty($_POST['subject_name'])) {
        // if(empty($subject['subject_name'])) {
            $errors['subject_name'] = "Subject can't be blank";
        }
        
        // elseif(!has_length($subject['subject_name'], ['min' => 2, 'max' => 255])) {
        //     $errors['subject_name'] = "Name must be between 2 and 255 characters";
        // }


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

        // // echo '<pre>';
        // // print_r($id_check);

        $redirect = dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . $id_check['id'];

        $data['success'] = true;
        $data['message'] = 'You have created a Subject!';
        $data['redirect'] = $redirect;

        // if($result) {
        //     return true;
        // } else {
        //     //if failed
        //     echo mysqli_error($db);
        //     db_disconnect($db);
        //     exit;
        //     }
        }

        // return $errors;

        echo json_encode($data);
?>