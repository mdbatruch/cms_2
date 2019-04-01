<?php
    if(!isset($page_title)) {
        $page_title = 'Staff Area';
    }

//        ini_set('display_errors', 1);
//        error_reporting(E_ALL);

//    $page = $_GET['page'];

    if(isset($_SESSION['last_login'])) {
        $readable_time = date('D-M-d-Y g:i A', $_SESSION['last_login']);
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
                Last Login: <?php echo $readable_time; ?> <br/>
            </li>
            <li> <a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
            <li> <a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
<!--                <li> <a href=""></a> Contact</li>-->
        </ul>    
    </nav>
<?php endif; ?>