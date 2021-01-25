<?php
if(!defined('CMS_ADMIN')) die("Illegal File Access");

$adm_pagetitle2 = _EDITADMIN;

$origAcc = isset($_GET['acc']) ? $_GET['acc'] : $_POST['acc'];
$acc = $escape_mysql_string(trim($origAcc));

$result = $db->sql_query("SELECT adname, email, pwd, permission, mods, menus FROM ".$prefix."_admin WHERE adacc='{$admin_ar[0]}'");
if(empty($admin_ar[0]) || $db->sql_numrows($result) != 1) {
	//header("Location: modules.php?f=$adm_modname"); exit;
}

$ds_acc = $ds_adname = $ds_email = $ds_pass = $ds_pass2 = "none";

$stopnick = _ERROR1;

list($adname, $email, $pwdold, $permission, $mods, $menus) = $db->sql_fetchrow($result);
$adacc = $admin_ar[0];
$adname_old = $adname;
$auth_modules = @explode("|",$mods);
$auth_menus = @explode("|",$menus);
include("popup_header.php");

$err_mail = $err_pass = $password = $password2 = "";
//$permission ="";
if(isset($_POST['subup']) && $_POST['subup'] == 1) {
	$password = $_POST['password'];
	$passwordnew = $_POST['passwordnew'];
	$passwordrenew= $_POST['passwordrenew'];

	if($password =="" && (strlen($password) < 3 || strlen($password) > 10 || strrpos($password,' ') > 0)) {
		$err_pass ="<font color=\"red\">"._ERROR4."</font><br/>";
		$err = 1;
	}
	if(md5($password)!=$pwdold) {
		$err_pass ="<font color=\"red\">Mật khẩu cũ không đúng</font><br/>";
		$err = 1;
	}
	//if($password2 !="" && (strlen($password2) < 3 || strlen($password2) > 10 || strrpos($password2,' ') > 0)) {
	//	$err_pass2 ="<font color=\"red\">"._ERROR4."</font><br/>";
	//	$err = 1;
	//}
	if(!$err) {
		if($passwordnew !="") {
			$passwordnew = md5($passwordnew);
		}else {
			$passwordnew = $pwdold;
		}
		$db->sql_query("UPDATE ".$prefix."_admin SET pwd='$passwordnew' WHERE adacc='{$admin_ar[0]}'");
		if(defined('iS_ADMIN')) {
			unset ($admin);
			unset ($_SESSION[ADMIN_SES]);
			$_SESSION['islogin']= false;
			header("Location: login.php");
		}	
		//die("UPDATE ".$prefix."_admin SET pwd='$password' WHERE adacc='{$admin_ar[0]}'");
		updateadmlog($admin_ar[0], $adm_modname, "Thay đổi mật khẩu	", _EDIT);
		//header("Location: modules.php?f=$adm_modname"); exit;
	}

}

if($adname_old == "Root") {$css =" disabled"; }else{ $css =""; }
ajaxload_content();
echo "<div id=\"pagecontent\">";
echo "<form action=\"modules.php?f=$adm_modname&do=$do\" method=\"POST\" onSubmit=\"return checkEditAuthor(this);\"><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" class=\"tableborder\">\n";
echo "<tr><td colspan=\"2\" class=\"header\">Thay đổi mật khẩu</td></tr>";
echo "<tr>\n";
echo "<td align=\"right\" class=\"row1\"><b>"._PASSWORD_OLD."</b></td>\n";
echo "<td class=\"row3\">$err_pass<input type=\"password\" name=\"password\" value=\"\" size=\"30\"></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align=\"right\" class=\"row1\"><b>"._PASSWORD_NEW."</b></td>\n";
echo "<td class=\"row3\">$err_passnew<input type=\"password\" name=\"passwordnew\" value=\"\" size=\"30\"></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align=\"right\" class=\"row1\"><b>"._PASSWORD_RENEW."</b></td>\n";
echo "<td class=\"row3\">$err_passrenew<input type=\"password\" name=\"passwordrenew\" value=\"\" size=\"30\"></td>\n";
echo "</tr>\n";
echo "<tr><td class=\"row3\">&nbsp;</td><td class=\"row3\"><input type=\"hidden\" name=\"acc\" value=\"$acc\"><input type=\"hidden\" name=\"subup\" value=\"1\"><input type=\"submit\" class=\"button2\" name=\"submit\" value=\""._SAVECHANGES."\"></td></tr>";
echo "</table></form></div>\n";

include_once("popup_footer.php");
?>