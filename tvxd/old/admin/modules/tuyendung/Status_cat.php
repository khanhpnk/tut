<?php

if(!defined('CMS_ADMIN')) {
	die("Illegal File Access");
}

$catid = intval($_GET['id']);
$stat = intval($_GET['stat']);

$result = $db->sql_query("SELECT alanguage FROM ".$prefix."_{$adm_modname}_cat WHERE catid='$catid'");
if(empty($catid) || $db->sql_numrows($result) != 1) {
	header("Location: ".$adm_modname.".php");
	die();
}	

$db->sql_query("UPDATE ".$prefix."_{$adm_modname}_cat SET active='$stat' WHERE catid='$catid'");
//onfile_cat();
header("Location: modules.php?f=".$adm_modname."&do=categories");
?>