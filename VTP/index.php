<?php
/**
 *
 * File Name:           index.php
 * Description:         Base file for the project.
 * Author:              Anudeep Potlapally
 * Created:             09/27/2012
 * Last Modified:       Anudeep 10/09/12
 * Copyright:           Echostar Systems @ http://www.echostar.com/
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Video Tag Portal</title>
                            <!--    Style Sheets   -->
        <link href="css/main.css" rel="stylesheet" type="text/css"></link>
        <link href="css/jquery-ui-1.9.0.custom.min.css" rel="stylesheet" type="text/css"></link>
                            <!--    Javascript files   -->
        <script src="includes/jquery.min.js" type="text/javascript"></script>
        <script src="includes/functions.js" type="text/javascript"></script>
    </head>
    <body>
		<?php 
            include("includes/functions.php");
            include("dashboard.php");
        ?>
	</body>
</html>