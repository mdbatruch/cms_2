<?php
    if(!isset($page_title)) {
        $page_title = 'Admin Area';
    }

//        ini_set('display_errors', 1);
//        error_reporting(E_ALL);

//    $page = $_GET['page'];
?>

<!doctype html>
<html lang="en">
    <head>
        <title><?php echo chars($page_title); ?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>"/>
    </head>
    <body>
        <header>
            <h1>Admin Area</h1>
        </header>
        
        <nav>
            <ul>
               <li>
                   User: <?php echo $_SESSION['username'] ?? ''; ?>
               </li>
                <li> <a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
                <li> <a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
<!--                <li> <a href=""></a> Contact</li>-->
            </ul>    
        </nav>
        