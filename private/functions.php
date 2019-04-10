<?php

    function url_for($script_path) {
        
        if($script_path[0] != '/') {
            $script_path = "/" . $script_path;
        }
        
        return WWW_ROOT . $script_path;
    }

    function u($string=""){
        return urlencode($string);
    }

    function raw_u($string=""){
        return rawurlencode($string);
    }

    function chars($string="") {
        return htmlspecialchars($string);
    }

    function error_404() {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        exit();
    }

    function error_500() {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        exit();
    }

    function redirect_to($location) {
        header("Location: " . $location);
        exit();
    }

    function is_post_request() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    function is_get_request() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    function display_errors($errors=array()) {
      $output = '';
      if(!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach($errors as $error) {
          $output .= "<li>" . $error . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
      }
      return $output;
    }

function get_and_clear_session_message() {
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        $msg = $_SESSION['status'];
        unset($_SESSION['status']);
        return $msg;
    }
}

function display_session_message() {
    $msg = get_and_clear_session_message();
    if(!is_blank($msg)) {
        return '<div class="alert alert-success">' . chars($msg) . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
}

?>