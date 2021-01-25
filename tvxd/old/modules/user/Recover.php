<?php

if (!defined('CMS_SYSTEM')) die();

$page_title = _USER_RECOVER_PASSWORD;

include_once("header.php");
require_once("WebUser.class.php");
global $urlsite;
OpenTab(_USER_RECOVER_PASSWORD);
echo "<div class=\"content\">";
if(isset($_POST['subup'])&& $_POST['subup'] == 1) {
	$password = $escape_mysql_string(trim($_POST['password']));
	$repassword = $escape_mysql_string(trim($_POST['repassword']));
	
	if(empty($password) || empty($repassword)) {
		echo  "<font color=\"red\">Mời bạn nhập mật khẩu.</font><br/>";
		$err = 1;
	}
	if($password != $repassword) {
		echo  "<font color=\"red\">Bạn phải nhập mật khẩu giống nhau.</font><br/>";
		$err = 1;
	}
	if(!$err) {
		$user = new WebUser(0, $_GET['email']);
		$ret = $user->recover($_GET['code'],$password);
		if ($ret) {
			echo '<div align="center">Tài khoản cập nhật mật khẩu mới thành công!</div>';
		/*echo '<div align="center">'._USER_YOUR_NEW_PASSWORD_IS.": $ret</div>";*/
		} else {
			echo '<div align="center"><font color="red"><b>'._USER_ERROR_RECOVER."</b></font></div>";
		}
	}
} else {
	$err_title = "";
}

echo "<div>
<p><h2>
Để lấy lại mật khẩu mời bạn soạn tin nhắn:<br/><br/>
<strong>ON    MKXD1</strong>  gửi 8085 ( Lấy lại mật khẩu cấp 1)<br/><br/>

(Phí tin nhắn 500đ/1 tin)<br/><br/>
</p></div>";
//<!--<strong>ON    MKX2</strong>   gửi 8085 ( Lấy lại mật khẩu cấp 2)<br/>-->
//if (isset($_GET['email']) && isset($_GET['code'])) {
	//$user = new WebUser(0, $_GET['email']);
	//$ret = $user->recover($_GET['code']);
	//if ($ret) {
	//	echo '<div align="center">'._USER_YOUR_NEW_PASSWORD_IS.": $ret</div>";
	//} else {
	//	echo '<div align="center"><font color="red"><b>'._USER_ERROR_RECOVER."</b></font></div>";
	//}
//	if (!$ret) {
//	echo "<div align=\"left\">";
//		echo "<form action=\"$urlsite/index.php?f=$module_name&do=$do&email=".$_GET['email']."&code=".$_GET['code']."\" method=\"POST\">";
//		echo "<table><tr><td>Mật khẩu: </td><td><input type=\"password\" name=\"password\" class=\"text\">&nbsp;<br/></td></tr>";
//		echo "<tr><td>Nhập lại mật khẩu: </td><td><input type=\"password\" name=\"repassword\" class=\"text\">&nbsp;<br/></td></tr>";
//		echo "<tr><td></td><td><input type=\"hidden\" name=\"subup\" value=\"1\">";
//		echo "<input type=\"submit\" name=\"submit\" value=\""._SEND."\" class=\"sb_but1\"></td></tr></table>";
//		echo "</form>";
//		echo "</div>";
//		}
//} else {
//	if (isset($_POST["submit"])) {
//		$user = new WebUser(0, $_POST['email']);
//		$ret = $user->newRecover($_POST['url']);
//		if ($ret) echo '<div align="center">'._USER_CHECK_MAIL_TO_RECOVER."</div>";
//		else echo '<div align="center">'._USER_NEW_RECOVER_FAILED."</div>";
//	} else {
//		echo '<div>'._USER_RECOVER_INSTRUCTIONS."</div><p></p>";
//		echo "<div align=\"center\">";
//		echo "<form action=\"".url_sid("index.php?f=$module_name&do=$do")."\" method=\"POST\">";
//		echo _USER_EMAIL.": <input type=\"text\" name=\"email\" class=\"text\">&nbsp;";
//		echo "<input type=\"hidden\" name=\"url\" value=\"$urlsite/index.php?f=$module_name&do=$do\">";
//		echo "<input type=\"submit\" name=\"submit\" value=\""._SEND."\" class=\"sb_but1\">";
//		echo "</form>";
//		echo "</div>";
//	}
//}
//echo "</div>";
CloseTab();
include_once("footer.php");
?>