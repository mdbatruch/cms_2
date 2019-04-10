<?php
    if(!isset($page_title)) {
        $page_title = 'Staff Area';
    }

    if(isset($_SESSION['last_login'])) {
        $readable_time = date('D-M-d-Y g:i A', $_SESSION['last_login']);
    }

    check_session();

    if( is_logged_in() ) {

    $time = get_last_login($_SESSION['username']);

    // $test = mysqli_fetch_array($time);

    // echo '<pre>';
    // print_r($time);

    $time_info = mysqli_fetch_assoc($time);

    $latest_login = $time_info['date'];

    }
?>

<!doctype html>
<html lang="en">
    <head>
        <title><?php echo chars($page_title); ?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>"/>
        <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/bootstrap.css'); ?>"/>
        <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/font-awesome.css'); ?>"/>
    </head>
    <body>
        <header>
            <h1>Staff Area</h1>
        </header>
        
<?php if( is_logged_in() ) : ?>
    <nav>
        <ul>
            <li>
                Welcome back, <?php echo $_SESSION['username'] ?? ''; ?> <br/>
                You Logged in at: <?php echo $latest_login; ?> <br/>
            </li>
            <li> <a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
            <li> <a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
<!--                <li> <a href=""></a> Contact</li>-->
        </ul>    
    </nav>
<?php endif; ?>