<?php 

  require_once('../../../private/initialize.php');

  require_login();

  $subject_set = find_all_subjects();

  $page_title = 'Subjects ';
  
  include(SHARED_PATH . '/staff-header.php');

  // $subject_id = 1;
  
  // $sql = "SELECT * from pages ";
  // $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "'";

  // $result = mysqli_query($db, $sql);
  // confirm_result_set($result);

  // //$test = mysqli_fetch_array($result);

  // while ($test = mysqli_fetch_assoc($result)) {
  //   echo '<pre>';
  //   print_r($test);

  //   // $sql = "DELETE from pages ";
  //   // $sql .= "WHERE id='" . db_escape($db, $test['id']) . "'";

  //   // $result = mysqli_query($db, $sql);
  //   // confirm_result_set($result);

  // }

  // echo '<pre>';
  // print_r($test);


  if (isset($_GET['page'])) {
      $page_number = $_GET['page'];
  } else {
      $page_number = 1;
  }

  $subjects_per_page = 7;
  $offset = ($page_number-1) * $subjects_per_page; 

  // $sql = "SELECT COUNT(*) FROM subjects";
  // $result = mysqli_query($db, $sql);
  // $result_rows = mysqli_fetch_array($result)[0];

  $subject_count = subject_count();


  $total_pages = ceil($subject_count / $subjects_per_page);


  // $sql_subjects = "SELECT * FROM subjects LIMIT $offset, $subjects_per_page";
  $sql_subjects = count_all_subjects($offset, $subjects_per_page);

  if (isset($_GET['page']) && $_GET['page'] > $total_pages) {
    redirect_to(url_for('staff/subjects/index.php'));
  }
  
  ?>

<div id="content">
  <div class="subjects listing">
    <h1>Subjects</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/subjects/new.php'); ?>">Create New Subject</a>
      <!-- <p><php echo $_SESSION['status']; ?></p> -->
      <p><?php echo display_session_message(); ?></p>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
  	    <th>Name</th>
  	    <th>Pages</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($subject = mysqli_fetch_assoc($sql_subjects)) { ?>
      <?php $page_count = count_pages_by_subject_id($subject['id']); ?> 
        <tr>
          <td>ID: <?php echo $subject['id']; ?></td>
          <td>Position: <?php echo $subject['position']; ?></td>
          <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo $subject['menu_name']; ?></td>
    	    <td><?php echo $page_count; ?></td>
<!--          <td><a class="action" href="php echo url_for('/staff/subjects/show.php?id=' . $subject['id']); ">View</a></td>-->
          <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?subject=' . chars(u($subject['menu_name']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/subjects/edit.php?subject=' . chars(u($subject['menu_name']))); ?>">Edit</a></td>
          <!-- <td><a class="action" href="<php echo url_for('/staff/subjects/delete.php?id=' . chars(u($subject['id'])) . '&subject=' . chars(u($subject['menu_name']))); ?>">Delete</a></td> -->
          <td><a class="action" href="<?php echo url_for('/staff/subjects/delete.php?subject=' . chars(u($subject['menu_name']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <ul class="pagination">
      <!-- <li class="page-item"><a class="page-link" href="?page=1">First</a></li> -->
      <li class="page-item">
          <?php if (!($page_number <= 1)) { ?>
            <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?page=".($page_number - 1); } ?>">&laquo; Prev</a>
          <?php } ?>
      </li>
        <?php
            for ($i=1; $i <= $total_pages; $i++) {
              echo "<li class=\"page-item\" style=\"list-style:none;\">";
                if (!($page_number < 1)) {
                  echo '<a class="page-link" href="'; 
                  echo "?page=" . $i . '">';
                  echo $i . '</a>';
                }
              echo "</li>";
            }
        ?>
      <li class="page-item">
          <?php if (!($page_number >= $total_pages)) { ?>
              <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else { echo "?page=".($page_number + 1); } ?>">Next &raquo;</a>
          <?php } ?>
      </li>
      <!-- <li class="page-item"><a class="page-link" href="?page=<php echo $total_pages; ?>">Last</a></li> -->
    </ul>


    <?php
      
        mysqli_free_result($subject_set);
      ?>
      
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
