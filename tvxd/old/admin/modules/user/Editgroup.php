<?php

if(!defined('CMS_ADMIN')) {
	die("Illegal File Access");
}

$adm_pagetitle2 = "Chính sửa nhóm thành viên";
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = $db->sql_query("SELECT * FROM ".$prefix."_usergroup WHERE id='$id'");
if(empty($id) || $db->sql_numrows($result) != 1) {
	exit;
}
list($idgroup, $titlegroup, $salegroup, $sale_cardgroup, $permissiongroup, $activegroup) = $db->sql_fetchrow($result);
$auth_menus = @explode("|",$permissiongroup);

$adacc = $adname = $err_mail = $email = $permission = $err_pass = $password= $password2 = $acc = $css= $error= $error2=$error3="";
$ds_acc = $ds_adname = $ds_email = $ds_pass= $ds_pass2 = "none";

include("popup_header.php");

if(isset($_POST['subup']) && $_POST['subup'] == 1) {
	$title = trim(stripslashes(resString($_POST['title'])));
	//$sale = intval(isset($_POST['sale'])? $_POST['sale'] : 0);
	//$sale_card = intval(isset($_POST['sale_card'])? $_POST['sale_card'] : 0);
	$active = intval($_POST['active']);
	$auth_menus = $_POST['auth_menus'];
	if(empty($title)) {
		$title = "";
		$error = "<font color=\"red\">Mời bạn nhập tên nhóm</font><br/>";
		$err = 1;
	}
	if(empty($sale)) {
		$sale = "";
		$error2 = "<font color=\"red\">Mời bạn nhập phần trăm (%)</font><br/>";
		$err = 1;
	}
	$menulist = "";//@implode("|",$auth_menus);
	echo $menulist;
	if(!$err) {
		//$db->sql_query("UPDATE ".$prefix."_admin SET adacc='$adacc', pwd='$password2',pwd2='$password', email='$email' WHERE adacc='$acc'");
		//die("UPDATE ".$prefix."_admingroup title='$title',permission='$menulist',active=$active WHERE id=$idgroup");
		$db->sql_query("UPDATE ".$prefix."_usergroup SET title='$title', permission='$menulist',active=$active WHERE id=$id");
		updateadmlog($admin_ar[0], $adm_modname, _MODTITLE, "Chỉnh sửa nhóm thành viên");
		//header("Location: modules.php?f=".$adm_modname."&do=group");
		echo "Cập nhật thành công.";
	}
}
ajaxload_content();
echo "<div id=\"pagecontent\">";
echo "<form action=\"modules.php?f=$adm_modname&do=$do&id=$idgroup\" method=\"POST\"><table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"tableborder\">\n";
echo "<tr><td colspan=\"2\" class=\"header\">Chính sửa nhóm thành viên</td></tr>";
echo "<tr>\n";
echo "<td width=\"150\" align=\"right\" class=\"row1\"><b>Tên nhóm</b></td>\n";
echo "<td class=\"row3\">".$error."<input type=\"text\" name=\"title\" value=\"$titlegroup\" size=\"30\"></td>\n";
echo "</tr>\n";
echo "<tr>\n";
if($activegroup==1)
{
	echo "<td align=\"right\" class=\"row1\"><b>Trạng thái</b></td>\n";
	echo "<td class=\"row2\"><input type=\"radio\" name=\"active\" value=\"1\" checked>"._YES." &nbsp;&nbsp;";
	echo "<input type=\"radio\" name=\"active\" value=\"0\">"._NO."</td>\n";
}
else
{
	echo "<td align=\"right\" class=\"row1\"><b>Trạng thái</b></td>\n";
	echo "<td class=\"row2\"><input type=\"radio\" name=\"active\" value=\"1\" >"._YES." &nbsp;&nbsp;";
	echo "<input type=\"radio\" name=\"active\" value=\"0\" checked>"._NO."</td>\n";
}
echo "</tr>\n";

echo "<tr>\n";
echo "<tr><td></td><td class=\"row4\"><input type=\"hidden\" name=\"acc\" value=\"$acc\"><input type=\"submit\" name=\"submit\" value=\""._SAVECHANGES."\"></td></tr>";
echo "</table></form>\n";
echo "</div>";
include("popup_footer.php");
?>