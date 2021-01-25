<?php

if(!defined('CMS_ADMIN')) {
	die("Illegal File Access");
}

$adm_pagetitle2 = "Thêm nhóm quản trị";

$adacc = $adname = $err_mail = $email = $permission = $err_pass = $password= $password2 = $acc = $css= $error= "";
$ds_acc = $ds_adname = $ds_email = $ds_pass= $ds_pass2 = "none";

$stopnick = _ERROR1;

include("page_header.php");

if(isset($_POST['subup']) && $_POST['subup'] == 1) {
	$title = trim(stripslashes(resString($_POST['title'])));
	$active = intval($_POST['active']);
	if(!defined('iS_SADMIN'))
	{
		$auth_menus = $_POST['auth_menus'];
	}
	if ($db->sql_numrows($db->sql_query("SELECT title FROM ".$prefix."_admingroup WHERE title='$title'")) > 0) {
		$error = "<font color=\"red\">Tên nhóm đã được sử dụng</font><br/>";
		$err = 1;
	}
	if(empty($title)) {
		$title = "";
		$error = "<font color=\"red\">Mời bạn nhập tên nhóm</font><br/>";
		$err = 1;
	}
	//$menulist = @implode("|",$auth_menus);
	$menulist = "";
	if(!$err) {
		$db->sql_query("INSERT INTO ".$prefix."_admingroup (title,permission,active) VALUES ('$title','$menulist',$active)");
		updateadmlog($admin_ar[0], $adm_modname, _MODTITLE, "Thêm nhóm quản trị");
		header("Location: modules.php?f=".$adm_modname."&do=group");
	}
}
ajaxload_content();
echo "<div id=\"pagecontent\">";
echo "<form action=\"modules.php?f=$adm_modname&do=$do\" method=\"POST\"><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"tableborder\">\n";
echo "<tr><td colspan=\"2\" class=\"header\">Thêm nhóm quản trị mới</td></tr>";
echo "<tr>\n";
echo "<td width=\"150\" align=\"right\" class=\"row1\"><b>Tên nhóm</b></td>\n";
echo "<td class=\"row3\">".$error."<input type=\"text\" name=\"title\" value=\"\" size=\"30\"></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align=\"right\" class=\"row1\"><b>Trạng thái</b></td>\n";
echo "<td class=\"row2\"><input type=\"radio\" name=\"active\" value=\"1\" checked>"._YES." &nbsp;&nbsp;";
echo "<input type=\"radio\" name=\"active\" value=\"0\">"._NO."</td>\n";
echo "</tr>\n";
echo "<tr><td colspan=\"2\" align=\"center\" class=\"row4\"><input type=\"hidden\" name=\"acc\" value=\"$acc\"><input type=\"hidden\" name=\"subup\" value=\"1\"><input class=\"button2\" type=\"submit\" name=\"submit\" value=\""._ADD."\"> <input class=\"button2\" type=\"button\" value=\""._CANCEL."\" onclick=\"window.location='modules.php?f=$adm_modname'\"></td></tr>";
echo "</table></form></div>\n";

include_once("page_footer.php");
?>