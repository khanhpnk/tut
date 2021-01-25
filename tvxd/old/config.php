<?php
if (!defined('FCKEditor')) {
	define('CMS_CONFIG', true);
	$datafold = "data";
	define("DATAFOLD","data");
	define("BLOCKFOLD","blocks");
	define("TIMENOW",time());
	define("JOB_SESS","anMw_231jhH");
	define("CART_SESS","mawSRio_99s");
	define("USER_SESS","nvu_fCQ82");
	define("CAPTCHA_SESS","asMhWs8");

	$sitekey = "2do82:o;-1wr.uo8l&a00;";
	$numshex_std = 1009002134;
}
//session_register('islogin');
define("DEBUG", 1);
$dbhost = "localhost";		// server name
$dbuname = "uname";			// username database
$dbpass = "pass";			// password database
$dbname = "db";		// database name
$prefix = "adoosite";		// prefix table in database
$super_admin = array('1','2');
define("ADMIN_SES","nva_fCQ82");
if (!defined('FCKEditor')) {
	@require_once("includes/functions.php");
}

?>
