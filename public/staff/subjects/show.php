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


    $subject_array = find_subject_by_name($subject);

    $subject_id = $subject_array['id'];

    // $subject_pages = find_pages_by_subject_id($subject_id);

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

    if (isset($_GET['page'])) {
        $page_number = $_GET['page'];
    } else {
        $page_number = 1;
    }

    $pages_per_page = 4;
    $offset = ($page_number-1) * $pages_per_page;

    $page_count = page_count($subject_id);

    // echo '<pre>';
    // print_r($subject_id);

    $total_pages = ceil($page_count / $pages_per_page);

    $sql_pages = count_all_pages($offset, $pages_per_page, $subject_id);

    if (isset($_GET['page']) && $_GET['page'] > $total_pages) {
        redirect_to(url_for('staff/subjects/show.php?subject=' . $subject));
    }

    // $page_path =  dirname(dirname($_SERVER['HTTP_REFERER'])) . '/pages/show.php?id=' .  . '&subject_id=' . '<br/>';
    // echo dirname($_SERVER['HTTP_REFERER']) . '/show.php?id=' . '&subject_id=' . '<br/>';
    // echo 'http://localhost:8888/cms_2/public/staff/pages/show.php?id=29&subject_id=1';

    $page_url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?subject=' . chars(u($subject));
    include(SHARED_PATH . '/staff-header.php'); 
?>

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
            <?php while($pages = mysqli_fetch_assoc($sql_pages)) { ?>
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

            <ul class="pagination">
                <!-- <li class="page-item"><a class="page-link" href="?page=1">First</a></li> -->
                <li class="page-item">
                    <?php if (!($page_number <= 1)) { ?>
                        <a class="page-link" href="<?php echo 'http://' . $page_url . '&page=' . ($page_number - 1);  ?>">&laquo; Prev</a>
                        <!-- <a class="page-link" href="<php if($page_number <= 1){ echo '#'; } else { echo "?page=".($page_number - 1); } ?>">&laquo; Prev</a> -->
                    <?php } ?>
                </li>
                    <?php
                        for ($i=1; $i <= $total_pages; $i++) {
                        echo "<li class=\"page-item\" style=\"list-style:none;\">";
                            if (!($page_number < 1)) {
                            echo '<a class="page-link" href="'; 
                            echo 'http://' . $page_url . "&page=" . $i . '">';
                            echo $i . '</a>';
                            }
                        echo "</li>";
                        }
                    ?>
                <li class="page-item">
                    <?php if (!($page_number >= $total_pages)) { ?>
                        <a class="page-link" href="<?php echo 'http://' . $page_url . '&page=' . ($page_number + 1);  ?>">Next &raquo;</a>
                    <?php } ?>
                </li>
                <!-- <li class="page-item"><a class="page-link" href="?page=<php echo $total_pages; ?>">Last</a></li> -->
            </ul>

            <?php mysqli_free_result($sql_pages); ?>
            </div>
        </div>
    </div>
</div>

<?php
            include(SHARED_PATH . '/staff-footer.php');
?>