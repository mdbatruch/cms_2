<?php 

    require_once('../../../private/initialize.php');

    require_login();
    
    // if (isset($_GET['id'])) {
    //     $id = $_GET['id'];
    // } else {
    //     $id = 1;
    // }

    if (isset($_GET['subject'])) {
        $subject = $_GET['subject'];
    } else {
        // $subject = 1;
        redirect_to(url_for('/staff/subjects/index.php'));
    }

    // if(!$id = $_GET['id']) {
    //     redirect_to(url_for('/staff/subjects/index.php'));
    // }

    // if(!$subject = $_GET['subject']) {
    //     redirect_to(url_for('/staff/subjects/index.php'));
    // }

    // $id = 1;

    // $subject = find_subject_by_id($id);

    // $pages_list = find_pages_by_subject_id($id);

    // echo '<pre>';
    
    // print_r($subject);


    $subject_array = find_subject_by_name($subject);

    // echo '<pre>';
    // print_r($subject_array);

    $subject_id = $subject_array['id'];

    $subject_pages = find_pages_by_subject_id($subject_id);

    // echo '<pre>';

    // print_r($pages_list);

    // echo $_SESSION['last_login'];

    // $test = find_pages_by_subject_id(2);

    // $tester = mysqli_fetch_all($test);

    // // echo '<pre>';
    // // print_r($tester);

    // foreach ($tester as $key => $value) {
    //     // echo $value['0'] . '<br>';
    //     $mike = $value['0'] + 1;
    //     // return $mike;
    // }

    // echo $mike;

    // $sql = "SELECT * FROM pages ";
    // $sql .= "WHERE menu_name='" . 'Ajax 1' . "'";

    // $test = mysqli_query($db, $sql);

    // $tester = mysqli_fetch_assoc($test);

    // echo '<pre>';
    // print_r($tester);

//        $sql = "SELECT * FROM subjects ";
//        $sql .= "WHERE id='" . $id . "'";
//        $result = mysqli_query($db, $sql);
//        confirm_result_set($result);
//        $subject = mysqli_fetch_assoc($result);
//        mysqli_free_result($result);
//        return $result;
//
//    $position = $_GET['position'];
//
//    echo 'ID: ' . chars($id);
//    echo '<br />';
//    echo 'Position: ' . chars($position);

// $pages_list = find_all_pages();

// $page_check = mysqli_fetch_all($pages_list);

// echo '<pre>';
// print_r($page_check);

include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">
<!--
    <a href="show.php?name=<php echo u('John Doe'); ?>">Link</a><br />

    <a href="show.php?company=<php echo u('Widgets&More'); ?>">Link</a><br />

    <a href="show.php?query=<php echo u('!#*?'); ?>">Link</a><br />
-->
    <p>
        <a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Back to List</a>
    </p>
    
    <div class="subject show">
        <!-- <h1>Subject ID: <php echo chars($id); ?></h1> -->
        <h1>Subject: <?php echo chars($subject_array['menu_name']); ?></h1>
        <div id="form--message"><?php if (isset($_GET['status']) && $_GET['status'] == 'edited' ) {echo '<div class="alert alert-success">You have succesfully edited this subject<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';}
        else if (isset($_GET['status']) && $_GET['status'] == 'new' ){ echo '<div class="alert alert-success">You have succesfully created a new subject<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';}
        ?></div>
        <div class="attributes">
            <dl>
                <dt>Menu Name</dt>
                <dd><?php echo chars($subject_array['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd><?php echo chars($subject_array['position']); ?></dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><?php echo $subject_array['visible'] == '1' ? 'true' : 'false'; ?></dd>
            </dl>
        </div>
        <p><?php echo display_session_message(); ?></p>

        <hr/>

        <div class="pages-show">
            <p class="pages listing">
            <h2>Pages</h2>
            <p><?php echo display_session_message(); ?></p>
            <a href="<?php echo url_for('/staff/pages/new.php?subject=' . chars(u($subject_array['menu_name']))); ?>">Create a New Page</a>
        </p>
            <div class="actions">
            <table class="list">
            <tr class="headers">
                <td>Id</td>
                <td>Page Name</td>
                <td>Is this Visible?</td>
                <td>Content</td>
                <td colspan="3"></td>
            </tr>
            <?php while($pages = mysqli_fetch_assoc($subject_pages)) { ?>
                <tr>
                    <td><?php echo $pages['id']; ?></td>
                    <td>
                        <span><?php echo $pages['menu_name']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $pages['visible']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $pages['content']; ?></span>
                    </td>
                    <td>
                        <a href="<?php echo url_for('staff/pages/show.php?subject=' . chars(u($subject_array['menu_name'])) . '&page=' . chars(u($pages['menu_name']))); ?>">View</a>
                    </td>
                    <td>
                        <a href="<?php echo url_for('/staff/pages/edit.php?subject=' . chars(u($subject_array['menu_name'])) . '&page=' . chars(u($pages['menu_name']))); ?>">Edit</a>
                    </td>
                    <td>
                        <a href="<?php echo url_for('/staff/pages/delete.php?subject=' . chars(u($subject_array['menu_name'])) . '&page=' . chars(u($pages['menu_name']))); ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </table>
            <?php mysqli_free_result($subject_pages); ?>
            </div>
        </div>
    </div>
</div>

<?php
            include(SHARED_PATH . '/staff-footer.php');
?>