<?php
/*
 *
 * File Name:       errorLog.php
 * Description:     Capture all PHP errors and record them in .error_log
 * Author:          Anudeep Potlapally
 * Created:         10/19/2012
 * Last Updated:
 *
 */

// Define the log file.  This can be set to an absolute or relative path.
define('USER_ERROR_HANDLER_LOG_FILE', '.error_log');
define('USER_ERROR_HANDLER_ERROR_TYPES', E_ALL);

// http://us2.php.net/manual/en/errorfunc.configuration.php#ini.error-reporting
error_reporting(0);

// http://us2.php.net/manual/en/function.set-error-handler.php
set_error_handler("UserErrorHandler", USER_ERROR_HANDLER_ERROR_TYPES);

/*
 * Function:    UserErrorHandler
 * Note:        Function will be called from set_error_handler
 */
function UserErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
	$time = date("d M Y H:i:s");
	// Get the error type from the error number
	// http://www.php.net/manual/en/errorfunc.constants.php
	$errortype = array (
		1     => "Error",
		2     => "Warning",
		4     => "Parsing Error",
		8     => "Notice",
		16    => "Core Error",
		32    => "Core Warning",
		64    => "Compile Error",
		128   => "Compile Warning",
		256   => "User Error",
		512   => "User Warning",
		1024  => "User Notice",
		2048  => "Strict",
		4096  => "Recoverable Error",
		8192  => "Deprecated",
		16384 => "User Deprecated",
	);
	$errlevel = $errortype[$errno];

	//  Write error data to log file
	$errfile = fopen(USER_ERROR_HANDLER_LOG_FILE, "a+");
	fputs($errfile, "\"$time\",\"$filename: $linenum\",\"($errlevel) $errmsg\"\r\n");
	fclose($errfile);

	if($errno != 2 && $errno != 8)
	{
		//  Terminate script if fatal error occured
		die("<h3>We aplogize for inconvenience, an unexpected error occured. <hr/>The details of this error have automatically been notified to the webmaster. We should have this issue resolved shortly</h3>");
	}
}
?>
