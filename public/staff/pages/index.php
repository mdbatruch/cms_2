<?php 

    require_once('../../../private/initialize.php');

    require_login();

    $pages_list = find_all_pages();

//    $pages = [
//        ['id' => '1', 'page' => '1'],
//        ['id' => '2', 'page' => '2'],
//        ['id' => '3', 'page' => '3'],
//        ['id' => '4', 'page' => '4'],
//    ];

//$sql .= "SELECT * FROM pages";
//$sql .= "WHERE id='" . $id . "'";
//$result = mysqli_query($db, $sql);
//confirm_set_result($result);
//$pages = mysql_fetch_assoc($result);
//return $result;
    
    $page_title = 'Pages';
    
    include(SHARED_PATH . '/staff-header.php');

    // echo '<pre>';
    // print_r($pages_list);

    redirect_to(url_for('staff/index.php'));
?>

<!-- <div id="content">
    <p class="pages listing">
       <h1>Pages</h1>
       <p><php echo display_session_message(); ?></p>
        <a href="<php echo url_for('/staff/pages/new.php'); ?>">Create a New Page</a>
    </p>
     <div class="actions">
      <table class="list">
      <tr class="headers">
          <td>Subject Id</td>
          <td>Is this Visible?</td>
          <td>Content</td>
          <td colspan="4"></td>
      </tr>
      <php while($pages = mysqli_fetch_assoc($pages_list)) { ?>
            <tr>
                <td><php echo $pages['subject_id']; ?></td>
                <td>
                    <span><php echo $pages['visible']; ?></span>
                </td>
                <td>
                    <span><php echo $pages['menu_name']; ?></span>
                </td>
                <td>
                    <span><php echo $pages['content']; ?></span>
                </td>
                <td>
                    <a href="<php echo url_for('staff/pages/show.php?id=' . $pages['id'] . '&subject_id=' . $pages['subject_id']); ?>">View</a>
                </td>
                <td>
                    <a href="<php echo url_for('/staff/pages/edit.php?id='. $pages['id']); ?>">Edit</a>
                </td>
                <td>
                    <a href="<php echo url_for('/staff/pages/delete.php?id='. $pages['id']); ?>">Delete</a>
                </td>
            </tr>
        <php } ?>
       </table>
       
       <php
      
        mysqli_free_result($pages_list);
      ?>
      
    </div>
</div> -->
 
<?php include(SHARED_PATH . '/staff-footer.php'); ?>
