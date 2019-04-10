<?php 

    require_once('../../../private/initialize.php');

    require_login();

    $subject_set = find_all_subjects();
    $subject_count = mysqli_num_rows($subject_set) + 1;
    mysqli_free_result($subject_set);
    
    $subject = [];
    $subject['position'] = $subject_count;

    $page_title = "Create Subject";
    
    include(SHARED_PATH . '/staff-header.php');

?>


<div id="content">
    <a class="back-link" href="<?php echo url_for('staff/subjects/index.php'); ?>">
        Back to List
    </a>
    
    <div class="subject new">
        <h1>Create Subject</h1>
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