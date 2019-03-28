<?php 

    require_once('../../../private/initialize.php');

    require_login();

//   if(is_post_request()){

    // Handle form values sent by new.php

        // $subject = [];
        // $subject['subject_name'] = $_POST['menu_name'] ?? '';
        // $subject['position'] = $_POST['position'] ?? '';
        // $subject['visible'] = $_POST['visible'] ?? '';

        // $errors = [];
        // $data = [];
        
        // if(is_blank($subject['subject_name'])) {
        //     $errors['subject_name'] = "Name can't be blank";
        // } elseif(!has_length($subject['subject_name'], ['min' => 2, 'max' => 255])) {
        //     $errors['subject_name'] = "Name must be between 2 and 255 characters";
        // }

        // if(!empty($errors)) {
        //     $data['success'] = false;
        //     $data['errors'] = $errors;
        //     $data['message'] = 'There was an error with your submission';
        // } else {

        // shift_subject_positions(0, $subject['position']);
        
        // $sql = "INSERT INTO subjects ";
        // $sql .= "(menu_name, position, visible) ";
        // $sql .= "VALUES (";    
        // $sql .= "'" . db_escape($db, $subject['subject_name']) . "',";
        // $sql .= "'" . db_escape($db, $subject['position']) . "',";
        // $sql .= "'" . db_escape($db, $subject['visible']) . "'";
        // $sql .= ")";

        // $result = mysqli_query($db, $sql);

        // if($result) {
        //     return true;
        // } else {
        //     //if failed
        //     echo mysqli_error($db);
        //     db_disconnect($db);
        //     exit;
        //     }
        // }

        // // return $errors;

        // echo json_encode($data);



//         if ($result === true) {
//             $new_id = mysqli_insert_id($db);
//             $_SESSION['status'] = 'you have created a new subject';
//             redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));
//         } else {
//             $errors = $result;
// //            var_dump($errors);
//         }
    // }

        $subject_set = find_all_subjects();
        $subject_count = mysqli_num_rows($subject_set) + 1;
        mysqli_free_result($subject_set);
        
        $subject = [];
        $subject['position'] = $subject_count;

        $page_title = "Create Subject";
        
        include(SHARED_PATH . '/staff-header.php'); ?>


<div id="content">
    <a class="back-link" href="<?php echo url_for('staff/subjects/index.php'); ?>">
        Back to List
    </a>
    
    <div class="subject new">
        <h1>Create Subject</h1>
        <!-- <php 
            // echo display_errors($errors);
        ?> -->
        <div id="form-message"></div>
        <!-- <form id="new-subject" action="<php echo url_for('/staff/subjects/new.php'); ?>" method="post"> -->
        <form id="new-subject" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type="text" name="subject_name" id="subject_name" value="" />
                    <div id="name-warning"></div>
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position" id="subject_position">
                        <?php
                          for($i=1; $i <= $subject_count; $i++) {
                            echo "<option value=\"{$i}\"";
                            if($subject["position"] == $i) {
                              echo " selected";
                            }
                            echo ">{$i}</option>";
                          }
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <!-- <input type="hidden" name="visible" id="subject_hidden" value="0" /> -->
                    <input type="checkbox" name="visible" id="subject_hidden" />
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Subject">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>