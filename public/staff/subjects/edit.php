<?php

    require_once('../../../private/initialize.php');

    require_login();

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/subjects/index.php'));
    }
    
    if(is_post_request()){

    // Handle form values sent by new.php
        
    $subject = [];
    $subject['id'] = $id;
    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';
        
    $result = update_subject($subject);
    if($result === true ) {
    $_SESSION['status'] = 'you have edited a subject';
    redirect_to(url_for('/staff/subjects/show.php?id=' . $id));
    } else {
        $errors = $result;
//        var_dump($errors);
    }

    } else {
        
        $subject = find_subject_by_id($id);
    }

    $subject_set = find_all_subjects();
    $subject_count = mysqli_num_rows($subject_set);
    mysqli_free_result($subject_set);

?>


<?php $page_title = "Edit Subject" ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">
    <a class="back-link" href="<?php echo url_for('staff/subjects/index.php'); ?>">
        Back to List
    </a>
    
    <div class="subject edit">
        <h1>Edit Subject</h1>
        
        <?php 
            echo display_errors($errors);
        ?>
        <form action="<?php echo url_for('staff/subjects/edit.php?id=' . $id); ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type="text" name="menu_name" value="<?php echo chars($subject['menu_name']); ?>" />
<!--
                        if ($errors) {
                            echo '<p>' . $errors['menu_name'] . '</p>';
                        }
-->
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                  <dd>
                    <select name="position">
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
                    <input type="hidden" name="visible" value="0" />
                    <input type="checkbox" name="visible" value="1" <?php if( $subject['visible'] == "1") {echo " checked"; } ?>/>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Subject">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>