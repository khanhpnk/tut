<?php
define('CMS_ADMIN', true);
require_once("../config.php");
require_once("language/$currentlang/main.php");
$url_redirect= isset($_GET['url_redirect']) ? $_GET['url_redirect'] : "";
if ($url_redirect!="")
{
	$url_redirect=$url_redirect;	
}
else
{
	$url_redirect="body.php";
}
if (defined('iS_ADMIN')) {
	header("Location: $url_redirect");
} else {
	header("Location: login.php?url_redirect=$url_redirect");
}		

?>