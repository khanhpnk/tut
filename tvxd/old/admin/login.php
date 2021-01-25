<?php
define('CMS_ADMIN', true);
require_once("../config.php");
require_once("language/$currentlang/main.php");
$url_redirect= isset($_GET['url_redirect']) ? $_GET['url_redirect'] : "";
$url_redirect= urlencode($url_redirect);
if ($url_redirect!="")
{
	$url_redirect=$url_redirect;	
}
else
{
	$url_redirect="body.php";
}
if(defined('iS_ADMIN')) {	
	header("Location: $url_redirect");
	exit;
}

$result='';

if (isset($_POST['task']))
{
	//die('fđfd');
    try
    {
        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
        NoCSRF::check( 'csrf_token', $_POST, true, 60*10, false );
        // form parsing, DB inserts, etc.
        // ...
        //$messlog = 'CSRF check passed. Form parsed.';
		$adname = $escape_mysql_string(trim($_POST['username']));
		$adpwd = $escape_mysql_string(trim($_POST['passwd']));

		$url_redirect= isset($_POST['url_redirect']) ? $_POST['url_redirect'] : "";
		$url_redirect=urldecode($url_redirect);
		$adname = substr($adname, 0,25);
		$adpwd = substr($adpwd, 0,40);
		
		if($adname =="" || $adpwd =="" || (preg_match("![^a-zA-Z0-9_-]!",trim($adname)))) {
			$_SESSION['adm_log']++;
			header("Location: index.php?error=2");
		}

		//if(!empty($adname) && $_SESSION['adName']==$adname) {
			$adpwd = md5($adpwd);
			list($fbipwd,$active) = $db->sql_fetchrow($db->sql_query("SELECT pwd, active FROM ".$prefix."_admin WHERE adacc='$adname'"));
			if($active==0)
			{
				$messlog="tài khoản đã bị khóa";
			}
			else
			{
				if (($fbipwd == $adpwd)) {
					mt_srand ((double)microtime ()*10000000);
					$maxran = 10000000;
					$checknum = mt_rand (0, $maxran);
					$checknum = md5 ($checknum);
					$agent = substr (trim ($_SERVER['HTTP_USER_AGENT']), 0, 80);
					$addr_ip = substr (trim ($client_ip), 0, 15);
					$db->sql_query("UPDATE {$prefix}_admin SET checknum = '$checknum', last_login = '".time()."', last_ip = '$addr_ip', agent = '$agent' WHERE adacc='$adname'");
					$_SESSION[ADMIN_SES] = base64_encode($adname."#:#".$adpwd."#:#".$checknum."#:#".$agent."#:#".$addr_ip);
					$_SESSION['timeout'] = time();
					$_SESSION['islogin'] = true;
					unset($_SESSION['adm_log']);
					session_write_close();
					updateadmlog($adname,'login','Đăng nhập','Đăng nhập tài khoản quản trị');
					if (isset($_GET['special'])) header("Location: $url_redirect");
					else header("Location: $url_redirect");
				}else{
					$_SESSION['adm_log']++;
					header("Location: index.php?error=1");
				}
			//}
		}

		if($_SESSION['adm_log'] >= $blockadm) {
			$substyle = " disabled";
			$messlog = _BEGONELOGIN." {$_SESSION['adm_log']} "._BEGONELOGIN1;
			$origAcc = isset($_GET['acc']) ? $_GET['acc'] : $_POST['acc'];
			$acc = $escape_mysql_string(trim($origAcc));
			$db->sql_query("UPDATE ".$prefix."_admin SET active=0 WHERE adacc='$acc'");
			
		}
    }
    catch ( Exception $e )
    {
        // CSRF attack detected
        $messlog = $e->getMessage() . ' Form ignored.';
    }
}
else
{
    //$result = 'No post data yet.';
}
// Generate CSRF token to use in form hidden field
$token = NoCSRF::generate( 'csrf_token' );
$checklogin = 0;
$substyle ="";
$messlog ="";
//session_register("adm_log");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="generator" content="OneCMS! - One Content Management System" />
  <title>OneCMS! - One Content Management System - Administration</title>
  <link href="../media/image/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <link rel="stylesheet" href="templates/acud/css/chosen.css" type="text/css" />
  <link rel="stylesheet" href="templates/acud/css/template.css" type="text/css" />
  <style type="text/css">
html { display:none }
  </style>
  <script src="../media/js/mootools-core.js" type="text/javascript"></script>
  <script src="../media/js/jquery.min.js" type="text/javascript"></script>
  <script src="../media/js/jquery-noconflict.js" type="text/javascript"></script>
  <script src="../media/js/jquery-migrate.min.js" type="text/javascript"></script>
  <script src="../media/js/core.js" type="text/javascript"></script>
  <script src="../media/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../media/js/chosen.jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
jQuery(function () {if (top == self) {document.documentElement.style.display = 'block'; } else {top.location = self.location; }});
window.setInterval(function(){var r;try{r=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP")}catch(e){}if(r){r.open("GET","./",true);r.send(null)}},840000);
jQuery(document).ready(function(){
	jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});
});
				jQuery(document).ready(function (){
					jQuery('.advancedSelect').chosen({"disable_search_threshold":10,"allow_single_deselect":true,"placeholder_text_multiple":"Select some options","placeholder_text_single":"Select an option","no_results_text":"No results match"});
				});
			
  </script>

	<script type="text/javascript">
		window.addEvent('domready', function ()
		{
			document.getElementById('form-login').username.select();
			document.getElementById('form-login').username.focus();
		});
	</script>
	<style type="text/css">
		/* Responsive Styles */
		@media (max-width: 480px) {
			.view-login .container {
				margin-top: -170px;
			}
			.btn {
				font-size: 13px;
				padding: 4px 10px 4px;
			}
		}
					</style>
	<!--[if lt IE 9]>
		<script src="../media/js/html5.js"></script>
	<![endif]-->
</head>

<body class="site com_login view-login layout-default task- itemid- ">
	<?php echo $result; ?>
	<!-- Container -->
	<div class="container">
		<div id="content">
			<!-- Begin Content -->
			<div id="element-box" class="login well">
				<img src="templates/acud/images/logo.png" alt="<?php echo _ONECMS;?>" />
				<hr />
<div id="system-message-container">
	<?php echo $messlog?>
</div>
<form action="login.php" method="post" id="form-login" class="form-inline">
	<fieldset class="loginform">
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					<span class="add-on">
						<i class="fa fa-user hasTooltip" title="User Name"></i>
						<label for="mod-login-username" class="element-invisible"><?php echo _USER_NAME;?></label>
					</span>
					<input name="username" tabindex="1" id="mod-login-username" type="text" class="input-medium" placeholder="User Name" size="15"/>
					<a href="index.php?f=user&do=remind" class="btn width-auto hasTooltip" title="<?php echo _FORGOT_YOUR_USERNAME;?>">
						<i class="fa fa-question-circle"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					<span class="add-on">
						<i class="fa fa-lock hasTooltip" title="Password"></i>
						<label for="mod-login-password" class="element-invisible"><?php echo _PASSWORD;?></label>
					</span>
					<input name="passwd" tabindex="2" id="mod-login-password" type="password" class="input-medium" placeholder="Password" size="15"/>
					<a href="index.php?f=user&do=reset" class="btn width-auto hasTooltip" title="<?php echo _FORGOT_YOUR_PASSWORD;?>">
						<i class="fa fa-question-circle"></i>
					</a>
				</div>
			</div>
		</div>
						<div class="control-group">
			<div class="controls">
				<div class="btn-group pull-left" style="margin-bottom: 20px">
					<button tabindex="3" class="btn btn-primary btn-large">
						<i class="fa fa-lock fa-white"></i> <?php echo _LOGIN?></button>
				</div>
			</div>
		</div>
		<input type="hidden" name="option" value="com_login"/>
		<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
		<input type="hidden" name="url_redirect" value="<?php echo $url_redirect?>">
		<input type="hidden" name="task" value="login"/></fieldset>
</form>

			</div>
			<noscript>
				Warning! JavaScript must be enabled for proper operation of the Administrator backend.	</noscript>
			<!-- End Content -->
		</div>
	</div>
	<div class="navbar navbar-fixed-bottom hidden-phone">
		<p class="pull-right "><?php echo _TITLE_FOOTER?></p>
		<a class="login-acud hasTooltip" href="<?php echo $urlsite?>" target="_blank" title="<?php echo _ABOUT_SITE;?>"><?php echo _ONECMS;?></a>
		<a href="<?php echo $urlsite?>"  target="_blank" class="pull-left hasTooltip"><i class="fa fa-share fa-white"></i><?php echo _BACK_HOMEPAGE;?></a>
	</div>
	
</body>
</html>