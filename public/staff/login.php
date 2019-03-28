<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (is_blank($username)) {
      $errors[] = 'Username cannot be a blank';
  }

  if (is_blank($password)) {
    $errors[] = 'Password cannot be a blank';
  }

  if (empty($errors)) {

    $admin = find_admin_by_username($username);
    $login_failure_msg = 'Login was unsuccessful';

    if ($admin) {

      if(password_verify($password, $admin['hashed_password'])) {
        
        //password matches
        log_in_admin($admin);
        redirect_to(url_for('/staff/index.php'));

      } else {

        //username found but no password match
        // $errors[] = $login_failure_msg;
        $errors[] = 'bad password';
      }

    } else {

      //no username found
      // $errors[] = $login_failure_msg;
      $errors[] = 'no username found';
    }
  }
}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/staff-header.php'); ?>

<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo chars($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

<?php include(SHARED_PATH . '/staff-footer.php'); ?>
