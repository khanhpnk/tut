<?php
$rid=intval($_GET["id"]);
$catid=intval($_GET["catid"]);
global $db,$prefix,$currentlang,$module_name ;
if($rid>0)
{
	$result_list = $db->sql_query("SELECT id, menhgia, giaban FROM ".$prefix."_thecao_menhgia WHERE catid='$rid' ORDER BY id");
	echo "<select name=\"menhgia\"  style=\"width:250px\">";
	echo "<option name=\"menhgia\" value=\"0\">Chọn mệnh giá</option>";
	$select1 = "";
	while(list($id, $menhgia, $giaban) = $db->sql_fetchrow($result_list)) {
		if($rid == $id){$select1 = "selected";}
		else{$select1 = "";}
		echo "<option value=\"$id\" $select1>".$menhgia."</option>";
	}
	echo "</select>\n";
}
else
{
	echo "<select name=\"menhgia\">";
	echo "<option name=\"menhgia\" value=\"0\">Chọn mệnh giá</option>";
	echo "</select>\n";
}
?>