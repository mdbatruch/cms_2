<?php

    require_once('../../../private/initialize.php');

    require_login();

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/pages/index.php'));
    }
    
    $id = $_GET['id'];

    if(is_post_request()){
        
    // Handle form values sent by new.php
        
    $pages = [];
    $pages['id'] = $id;
    $pages['menu_name'] = $_POST['menu_name'] ?? '';
    $pages['position'] = $_POST['position'] ?? '';
    $pages['visible'] = $_POST['visible'] ?? '';
    $pages['content'] = $_POST['content'] ?? '';
    $pages['subject_id'] = $_POST['subject_id'] ?? '';
        
    $pages_list = update_page($pages);
        
    if ($pages_list === true ) {

        $_SESSION['status'] = 'you have edited a page';

        redirect_to(url_for('staff/pages/show.php?id=' . $id));
    } else {
        $errors = $pages_list;
        
//        var_dump($errors);
    }
        
    } else {
        $pages = find_all_pages_by_id($id);
        
        // $pages_set = find_all_pages();
        // $pages_count = mysqli_num_rows($pages_set);
        // mysqli_free_result($pages_set);

        $pages_count = count_pages_by_subject_id($pages['subject_id']);
    }
    

?>


<?php $page_title = "Edit Page" ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>


<div id="content">

<div class="link-container">
    <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?id=' . chars($pages['subject_id'])); ?>">
        Back to List
    </a>
</div>
    
    <div class="subject new">
        <h1>Edit Page</h1>
        <?php
            echo display_errors($errors);
        ?>
        <form action="<?php echo url_for('/staff/pages/edit.php?id=' . $id); ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type="text" name="menu_name" value="<?php echo $pages['menu_name'] ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position" id="">
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
                    <input type="text" name="subject_id" value="<?php echo $pages['subject_id'] ?>" />
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
<!--                    <input type="text" name="content" value="<php echo $pages['content'] >" />-->
                    <textarea name="content" id="" cols="30" rows="10"><?php echo $pages['content'] ?></textarea>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0" />
                    <input type="checkbox" name="visible" value="1" <?php if($pages['visible'] =="1") {echo " checked"; } ?>/>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Page">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>