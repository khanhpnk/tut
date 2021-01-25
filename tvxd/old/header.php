<?php
if (!defined('CMS_SYSTEM')) die('Stop!!!');
ob_start();
$urlsite="https://thuvienxaydung.net";
global $keywords_site, $description_site, $webmastertools, $header_page_keyword, $home, $Default_Temp, $page_title, $page_title2, $module_title, $sitename, $siteurl, $pagetitle, $module_name, $load_hf, $url_site, $siteimage, $sitepage;
$page_title = strip_tags($page_title,"");
if($home == 1) $module_title = ""._HOMEPAGE."";
include_once(RPATH."templates/$Default_Temp/index.php");
if (isset($keywords_site)) {
	$key_words = strip_tags($keywords_site);
}
if (isset($description_site))
	$description = strip_tags($description_site);
else
	$description = strip_tags($description_site);
if (isset($header_page_keyword)) {
	$keywords = strip_tags($header_page_keyword);
	$keywords = trim(ereg_replace('("|\?|!|:|\.|\(|\)|;|\\\\)+', ' ', $keywords));
	$keywords = ereg_replace('( |'.CHR(10).'|'.CHR(13).')+', ',', $keywords);
	$keywords = substr($keywords, 0, 1600);
	$keywords = array_unique(explode(",", $keywords));
	for($i=0; $i < count($keywords)-1; $i++) {
		if(isset($keywords[$i]) && strlen($keywords[$i]) > 3) { $key_words_arr[] = $keywords[$i]; }
	}
	//$key_words .= ", ".@implode(", ",$key_words_arr);
} else {
	//$keywords="";
}
if ($page_title == "") {
	$description= $description;
}
else {
	$description = $description;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi-vn" lang="vi-vn" >
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo _CHARSET ?>"/>
<title><?php if($page_title!="") {echo  trim(CutString($page_title,70));}else {echo trim(CutString($sitename,70));} ?></title>
<meta name="description" content="<?php echo trim(CutString($description,255))?>" />
<meta name="keywords" content="<?php echo trim($key_words) ?>" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta http-equiv="content-language" content="vi" />
<meta http-equiv="REFRESH" content="1800" />
<meta http-equiv="EXPIRES" content="0" />
<meta name="AUTHOR" content="thuvienxaydung.net" />
<meta name="COPYRIGHT" content="Copyright (c) by thuvienxaydung.net" />
<meta name="Googlebot" content="index,follow,archive">
<meta name="RATING" content="GENERAL" />
<meta name="GENERATOR" content="thuvienxaydung.net" />
<meta property="og:title" content="<?php if($page_title!="") {echo  trim(CutString($page_title,70));}else {echo trim(CutString($sitename,70));} ?>">
<meta property="og:image" content="<?php echo $siteimage ?>">
<meta property="og:site_name" content="<?php echo $sitename ?>">
<meta property="og:description" content="<?php echo trim(CutString($description,255))?>">
<meta property="og:type" content="thuvienxaydungnet:website"/>
<meta property="og:url" content="<?php echo $sitepage?>"/>
<meta property="twitter:card" content="summary"/>
<meta property="twitter:description" content="<?php echo trim(CutString($description,255))?>"/>
<meta property="twitter:image" content="<?php echo $siteimage ?>"/>
<meta property="twitter:title" content="<?php if($page_title!="") {echo  trim(CutString($page_title,70));}else {echo trim(CutString($sitename,70));} ?>"/>
<meta property="og:title" content="<?php if($page_title!="") {echo  trim(CutString($page_title,70));}else {echo trim(CutString($sitename,70));} ?>"/>
<meta name="application-name" content="<?php if($page_title!="") {echo  trim(CutString($page_title,70));}else {echo trim(CutString($sitename,70));} ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="<?php echo $webmastertools ?>" />
<meta name="alexaVerifyID" content="dNq4q3Br7tKb1FbMQ7PEaPzPbjU"/>
<meta name="generator" content="<?php echo $sitename ?>" />
<link rel="shortcut icon" href="<?php echo $urlsite?>/favicon.ico" type="image/x-icon" />
<link rel="image_src" href="<?php echo $siteimage ?>" />
<?php
$genhour = gmdate("H");
$urlsite="https://thuvienxaydung.net";
if (intval($genhour) != "" && intval($genhour) != 0) $genhour = $genhour - 1;
@header("Last-Modified: ".gmdate("D, d M Y ".intval($genhour).":i:s")." GMT");
@header("Content-Type: text/html; charset="._CHARSET."");
?>
<link rel="StyleSheet" type="text/css" href="<?php echo $urlsite ?>/templates/<?php echo $Default_Temp?>/css/styles.css"/>
<link rel="StyleSheet" type="text/css" href="<?php echo $urlsite ?>/templates/<?php echo $Default_Temp?>/css/tabs_style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $urlsite ?>/templates/<?php echo $Default_Temp?>/css/cupertino/jqueryui1816custom.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo $urlsite ?>/js/fancybox/jquery.fancybox-1.3.4.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo $urlsite ?>/templates/<?php echo $Default_Temp?>/css/superfish.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $urlsite ?>/templates/<?php echo $Default_Temp?>/css/superfish-vertical.css" />

<script type="text/javascript" src="<?php echo $urlsite ?>/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/jqueryui1816custommin.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<!--<script type="text/javascript" src="<?php /*echo $urlsite */?>/js/hoverIntent.js"></script>-->
<!--<script type="text/javascript" src="<?php /*echo $urlsite */?>/js/superfish.js"></script>-->
<script type="text/javascript" src="<?php echo $urlsite ?>/js/supersubs.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/jquery.carouFredSel.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/library.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/tabcontent.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/advertise.js"></script>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/js.cookie-2.2.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $urlsite ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $urlsite ?>/js/colorbox/colorbox.css" />


<?php if(file_exists($urlsite."/js/".$module_name.".js")) {?>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/".$module_name.".js"></script>
<?php } ?>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?4BF5dfJ1WwatfzJks5NzYOxQ9Og7uV9M";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
</head>
<?php
if (!$load_hf) themeheader();
$nohf = 1;
ob_end_flush();
?>