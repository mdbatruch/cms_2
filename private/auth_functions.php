<?php

  // Performs all actions necessary to log in an admin
  function log_in_admin($admin) {
  // Renerating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['username'] = $admin['username'];
    $_SESSION['last_login'] = time();
    return true;
  }

  function check_session() {

    $timeout_duration = 1800;

    if (isset($_SESSION['last_login']) && 
                ($_SERVER['REQUEST_TIME'] - $_SESSION['last_login']) > $timeout_duration) {

                  $_SESSION['username'] = null;
                  $_SESSION['last_login'] = null;

                  unset( $_SESSION['username'] );
                  unset( $_SESSION['last_login'] );

                  // session_unset();

                  $_SESSION['logout_message'] = 'We\'re sorry, but you have timed out. Please login again.';

                  redirect_to(url_for('/staff/login.php'));

      } else  {
        $_SESSION["last_login"] = time(); // update last activity time stamp
    }
  }

  function is_logged_in() {

    // return isset($_SESSION['admin_id']);
    return isset($_SESSION['username']);
  }

  function require_login() {
    if(!is_logged_in()) {
      redirect_to(url_for('/staff/login.php'));
    }
  }

  function logout_admin() {

    unset($_SESSION['admin_id']);
    unset($_SESSION['username']);
    unset($_SESSION['last_login']);

    // session_destroy();

    return true;
  }

?>
