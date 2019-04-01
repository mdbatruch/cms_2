<?php

    require_once('../../../private/initialize.php');

    require_login();

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/subjects/index.php'));
    }
    
//     if(is_post_request()){

//     // Handle form values sent by new.php
        
//     $subject = [];
//     $subject['id'] = $id;
//     $subject['menu_name'] = $_POST['menu_name'] ?? '';
//     $subject['position'] = $_POST['position'] ?? '';
//     $subject['visible'] = $_POST['visible'] ?? '';
        
//     $result = update_subject($subject);
//     if($result === true ) {
//     $_SESSION['status'] = 'you have edited a subject';
//     redirect_to(url_for('/staff/subjects/show.php?id=' . $id));
//     } else {
//         $errors = $result;
// //        var_dump($errors);
//     }

//     } else {
        
        $subject = find_subject_by_id($id);
//     }

    $subject_set = find_all_subjects();
    $subject_count = mysqli_num_rows($subject_set);
    mysqli_free_result($subject_set);

    $id = $_GET['id'];

    $page_title = "Edit Subject";
    include(SHARED_PATH . '/staff-header.php'); 
    
?>

<div id="content">
    <a class="back-link" href="<?php echo url_for('staff/subjects/index.php'); ?>">
        Back to List
    </a>
    
    <div class="subject edit">
        <h1>Edit Subject</h1>
        <!-- <form id="edit-subject" action="<php echo url_for('staff/subjects/edit.php?id=' . $id); ?>" method="post"> -->
        <div id="form-message"></div>
        <form id="edit-subject" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type="text" id="subject_name" name="subject_name" value="<?php echo chars($subject['menu_name']); ?>" />
                    <div id="name-warning"></div>
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                  <dd>
                    <select id="subject_position" name="position">
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
                    <!-- <input type="hidden" name="visible" value="0" /> -->
                    <input type="checkbox" id="subject_hidden" name="visible" value="1" <?php if( $subject['visible'] == "1") {echo " checked"; } ?>/>
                    <!-- <input type="checkbox" id="page-visible" name="page_visible" value="1"/> -->
                </dd>
            </dl>
            <div id="operations">
            <input type="hidden" id="value" value="<?php echo $id; ?>" name="value_id">
                <input type="submit" value="Edit Subject">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>