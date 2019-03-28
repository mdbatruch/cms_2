<?php 

    require_once('../../../private/initialize.php');

    require_login();

if(is_post_request()){

    $pages = [];
    $pages['menu_name'] = $_POST['menu_name'] ?? '';
    $pages['subject_id'] = $_POST['subject_id'] ?? '';
    $pages['position'] = $_POST['position'] ?? '';
    $pages['visible'] = $_POST['visible'] ?? '';
    $pages['content'] = $_POST['content'] ?? '';

    $result = insert_pages($pages);
        
    if ($result === true ) {
        $new_id = mysqli_insert_id($db);
        
        $new_message = 'You have a created a new Page';
    
        $_SESSION['status'] = $new_message;
        
        redirect_to(url_for('staff/pages/show.php?id=' . $new_id));
        
    } else {
        
        $errors = $result;
//        var_dump($errors);
    }

} else {

    $pages = [];
    $pages['menu_name'] = '';
    $pages['subject_id'] = $_GET['subject_id'] ?? '1';
    $pages['position'] = '';
    $pages['visible'] = '';
    $pages['content'] = '';

}
    $id = $_GET['subject_id'];

    // $pages_set = find_all_pages();
    // $pages_count = mysqli_num_rows($pages_set) + 1;
    // mysqli_free_result($pages_set);

    $pages_count = count_pages_by_subject_id($pages['subject_id']) + 1;

    // echo $pages_count;

    $subject = [];
    $subject['position'] = $pages_count;

?>


<?php $page_title = "Create A New Page" ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>


<div id="content">
    <div class="link-container">
        <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?id=' . $id); ?>">
            Back to List
        </a>
    </div>
    
    <div class="subject new">
        <?php 
            
            if ($errors) {
                echo display_errors($errors);
            }
            ?>
        <h1>Create a New Page</h1>
        <form action="<?php echo url_for('/staff/pages/new.php?subject_id=' . $id); ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type="text" name="menu_name" value="" />
                    <?php
                        // if ($errors) {
                        //     echo '<br/>';
                        //     echo 'You entered "' . $_POST['menu_name'] . '" which is not valid!';
                        // }
                    ?>
                </dd>
                <input type="hidden" name="subject_id" value="<?php echo $id; ?>" />
            </dl>
            <!-- <dl>
                <dt>Subject ID</dt>
                <dd>
                    <input type="hidden" name="subject_id" value="<php echo $id; ?>" />
                </dd>
            </dl> -->
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position" id="">
                            <?php 
                                for ($i=1; $i<=$pages_count; $i++){
                                    echo "<option value=\"{$i}\"";
                                if ($subject['position'] == $i) { 
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
                    <input type="checkbox" name="visible" value="1"/>
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content" id="page-content" cols="30" rows="10" value=""></textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Page">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>