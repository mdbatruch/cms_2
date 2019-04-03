<?php

    require_once('../../../private/initialize.php');

    require_login();

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/pages/index.php'));
    }
    
    $id = $_GET['id'];

    $pages = find_all_pages_by_id($id);

    // $pages_set = find_all_pages();
    // $pages_count = mysqli_num_rows($pages_set);
    // mysqli_free_result($pages_set);

    $pages_count = count_pages_by_subject_id($pages['subject_id']);

    $page_title = "Edit Page";
    
    include(SHARED_PATH . '/staff-header.php'); 
?>


<div id="content">

<div class="link-container">
    <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?id=' . chars($pages['subject_id'])); ?>">
        Back to List
    </a>
</div>
    
    <div class="subject new">
        <h1>Edit Page</h1>
        <div id="form-message"></div>
        <!-- <form action="<php echo url_for('/staff/pages/edit.php?id=' . $id); ?>" method="post"> -->
        <form id="edit-page" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type="text" id="page-name" name="page_name" value="<?php echo $pages['menu_name'] ?>" />
                    <div id="name-warning"></div>
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position" id="page-position">
                       <?php 
                        for ($i=1; $i<=$pages_count; $i++){
                        echo "<option value='{$i}'";
                            if($pages['position'] == $i) {
                                echo " selected"; 
                            }
                        echo ">{$i}</option>";
                        }
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Subject ID</dt>
                <dd>
                    <input type="text" id="subject-id" name="subject_id" value="<?php echo $pages['subject_id'] ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content" id="page-content" cols="30" rows="10"><?php echo $pages['content'] ?></textarea>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="checkbox" id="page-visible" name="visible" value="1" <?php if($pages['visible'] =="1") {echo " checked"; } ?>/>
                </dd>
            </dl>
            <div id="operations">
                <input type="hidden" id="value" value="<?php echo $id; ?>" name="value_id">
                <input type="submit" value="Edit Page">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>