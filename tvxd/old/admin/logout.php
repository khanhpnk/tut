<?php
define('CMS_ADMIN', true);
require_once("../config.php");
$url_redirect= isset($_GET['url_redirect']) ? $_GET['url_redirect'] : "";
if ($url_redirect!="")
{
	$url_redirect=$url_redirect;	
}
else
{
	$url_redirect="body.php";
}
if(defined('iS_ADMIN')) {
	unset ($admin);
	unset ($_SESSION[ADMIN_SES]);
	$_SESSION['islogin']= false;
	header("Location:index.php?url_redirect=$url_redirect");
}else{
	header("Location: login.php?url_redirect=".urlencode($url_redirect)."");
}		

?>