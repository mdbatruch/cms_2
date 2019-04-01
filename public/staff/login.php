<?php
  
  require_once('../../private/initialize.php');
  $page_title = 'Log in';
  include(SHARED_PATH . '/staff-header.php');

?>
<div id="content">
  <h1>Log in</h1>
  <div id="form-message"></div>
  <form id="login" method="post">
    Username:<br />
    <input type="text" id="username" name="username" />
    <div id="username-error"></div>
    <br />
    Password:<br />
    <input type="password" id="password" name="password" value="" />
    <div id="password-error"></div><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>
  <?php if (isset($_SESSION['logout_message'])) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['logout_message'];
          unset($_SESSION['logout_message']);
          session_destroy(); ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>
</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
