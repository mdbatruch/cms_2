<?php 

    require_once('../../../private/initialize.php');

    require_login();
    
    // if (isset($_GET['id'])) {
    //     $id = $_GET['id'];
    // } else {
    //     $id = 1;
    // }

    if(!$id = $_GET['id']) {
        redirect_to(url_for('/staff/subjects/index.php'));
    }

    $subject = find_subject_by_id($id);

    $pages_list = find_pages_by_subject_id($id);

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
        <h1>Subject: <?php echo chars($subject['menu_name']); ?></h1>
        <!-- <h1><php echo $_SESSION['status']; ?></h1> -->
        <div class="attributes">
            <dl>
                <dt>Menu Name</dt>
                <dd><?php echo chars($subject['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd><?php echo chars($subject['position']); ?></dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><?php echo $subject['visible'] == '1' ? 'true' : 'false'; ?></dd>
            </dl>
        </div>
        <p><?php echo display_session_message(); ?></p>

        <hr/>

        <div class="pages-show">
            <p class="pages listing">
            <h2>Pages</h2>
            <p><?php echo display_session_message(); ?></p>
            <a href="<?php echo url_for('/staff/pages/new.php?subject_id=' . $subject['id']); ?>">Create a New Page</a>
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
            <?php while($pages = mysqli_fetch_assoc($pages_list)) { ?>
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
                        <a href="<?php echo url_for('staff/pages/show.php?id=' . $pages['id'] . '&subject_id=' . $pages['subject_id']); ?>">View</a>
                    </td>
                    <td>
                        <a href="<?php echo url_for('/staff/pages/edit.php?id='. $pages['id']); ?>">Edit</a>
                    </td>
                    <td>
                        <a href="<?php echo url_for('/staff/pages/delete.php?id='. $pages['id']); ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </table>
            <?php mysqli_free_result($pages_list); ?>
            </div>
        </div>
    </div>
</div>