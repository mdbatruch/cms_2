<?php 

    require_once('../../../private/initialize.php');

    require_login();

    $subject = $_GET['subject'];

    $subject_array = find_subject_by_name($subject);

    // echo '<pre>';
    // print_r($subject_array);

    $pages_set = find_all_pages();
    $pages_count = mysqli_num_rows($pages_set) + 1;
    // mysqli_free_result($pages_set);

    // $pages = [];
    // $pages['menu_name'] = $_POST['menu_name'] ?? '';
    // $pages['subject_id'] = $_POST['subject_id'] ?? '';
    // $pages['position'] = $_POST['position'] ?? '';
    // $pages['visible'] = $_POST['visible'] ?? '';
    // $pages['content'] = $_POST['content'] ?? '';

    // $pages_count = count_pages_by_subject_id($id) + 1;

    $subject = [];
    $subject['position'] = $pages_count;

    $page_title = "Create A New Page";
    include(SHARED_PATH . '/staff-header.php'); 

?>


<div id="content">
    <div class="link-container">
        <a class="back-link" href="<?php echo url_for('staff/subjects/show.php?subject=' . chars(u($subject_array['menu_name']))); ?>">
            Back to List
        </a>
    </div>
    
    <div class="page new">
        <div id="form-message"></div>
        <h1>Create a New Page</h1>
        <!-- <form action="<php echo url_for('/staff/pages/new.php?subject_id=' . $id); ?>" method="post"> -->
        <form id="new-page" method="post">
            <dl>
                <dt>Page Name</dt>
                <dd>
                    <!-- <input type="text" name="menu_name" value="" /> -->
                    <input type="text" id="page-name" name="page_name" value="" />
                    <div id="name-warning"></div>
                </dd>
                <input type="hidden" id="subject-name" name="subject_name" value="<?php echo $subject_array['menu_name']; ?>" />
                <input type="hidden" id="subject-id" name="subject_id" value="<?php echo $subject_array['id']; ?>" />
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="page_position" id="page-position">
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
                    <!-- <input type="hidden" name="visible" value="0" /> -->
                    <input type="checkbox" id="page-visible" name="page_visible" value="1"/>
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="page_content" id="page-content" cols="30" rows="10" value=""></textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="hidden" id="page_id" name="page_id" value="<?php echo $pages_count; ?>">
                <input type="submit" value="Create Page">
            </div>
        </form>
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff-footer.php'); ?>