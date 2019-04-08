<?php 

  require_once('../../../private/initialize.php');

  require_login();

  $subject_set = find_all_subjects();

//  $subjects = [
//    ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'About'],
//    ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Consumer'],
//    ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Small Business'],
//    ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Commercial'],
//  ];

  $page_title = 'Subjects ';
  
  include(SHARED_PATH . '/staff-header.php'); ?>

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

      <?php while($subject = mysqli_fetch_assoc($subject_set)) { ?>
      <?php $page_count = count_pages_by_subject_id($subject['id']); ?> 
        <tr>
          <td>ID: <?php echo $subject['id']; ?></td>
          <td>Position: <?php echo $subject['position']; ?></td>
          <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo $subject['menu_name']; ?></td>
    	    <td><?php echo $page_count; ?></td>
<!--          <td><a class="action" href="php echo url_for('/staff/subjects/show.php?id=' . $subject['id']); ">View</a></td>-->
          <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?subject=' . chars(u($subject['menu_name'])) . '&position=' . chars(u($subject['position']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/subjects/edit.php?subject=' . chars(u($subject['menu_name']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/subjects/delete.php?id=' . chars(u($subject['id'])) . '&subject=' . chars(u($subject['menu_name']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      
        mysqli_free_result($subject_set);
      ?>
      
  </div>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
