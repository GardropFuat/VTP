<?php
/**
 *
 * File Name:       index.php
 * Description:     Base file for the project.
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Anudeep 10/09/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

session_start();
 
//  set default time zone
date_default_timezone_set("America/Denver");

//  display/hide PHP errors 0->hide , 1-> show(default)
ini_set('display_errors', 1);

include("includes/errorLog.php");
include("libraries/DbConnector.php");
include("includes/functions.php");

// Create new database instance
$Db = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Video Tag Portal</title>
                            <!--    Style Sheets   -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <link href="css/jquery.dropdown.css" rel="stylesheet" type="text/css"></link>
        <link href="css/main.css" rel="stylesheet" type="text/css"></link>
                            <!--    Javascript files   -->
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="http://popcornjs.org/code/dist/popcorn-complete.js"></script>
        <script src="libraries/jquery.dropdown.js" type="text/javascript"></script>
        <script src="includes/functions.js" type="text/javascript"></script>
        <?php
            include 'includes/headJS.php';        
        ?>
    </head>
    <body>
		<?php
            include("header.php");
            include("dashboard.php");
            // tailJS.php should be st the end of the page
            include("includes/bodyJS.php");
        ?>
	</body>
</html>