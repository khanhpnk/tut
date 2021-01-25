<?php

if(!defined('CMS_ADMIN')) die("Illegal File Access");

include_once("page_header.php");
$id = intval(isset($_GET['id']) ? $_GET['id'] : 0);
$text = $menhgia = $serial = $err_serial = $err_cat = $code = $err_code= $error ="";
$active = 1;
$err=0;
?>

<script language="javascript" type="text/javascript">
	function check_uncheck(){
		var f= document.frm;
		if(f.checkall.checked){
			CheckAllCheckbox(f,'id[]');
		}else{
			UnCheckAllCheckbox(f,'id[]');
		}			
	}
		function checkQuick(f) {
			if(f.f.value =='') {
				f.f.focus();
				return false;
			}
			f.submit.disabled = true; 
			return true;		
		}	
		function checkQuickId(f) {
			if(f.id.value =='') {
				f.id.focus();
				return false;
			}
			f.submit.disabled = true; 
			return true;		
		}	
	$(function() {
		$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "dd-mm-yy",
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
				
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "dd-mm-yy",
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	</script>
<div class="toolbar"><div>
<form action="" name="frmtool" method="get">
	<input type="hidden" name="f" value="thecao" />
	<input type="hidden" name="do" value="history" />
	<label for="action">Người mua</label>
	<input type="text" id="s_name" value="" name="s_name"  style="width: 100px"/>
	<label for="action">Mã code</label>
	<input type="text" id="s_code" value="" name="s_code"  style="width: 100px" />
	<label for="action">Mã serial</label>
	<input type="text" id="s_serial" value="" name="s_serial"  style="width: 100px" />
	<label for="cat"></label>
	<?php
	$resultcat = $db->sql_query("SELECT catid, title FROM {$prefix}_thecao_cat WHERE active=1 ORDER BY catid");
if($db->sql_numrows($resultcat) > 0) 
{
	echo '<select id="cat" name="s_cat">'."\n";
	echo '<option value="">Chọn loại thẻ</option>';
	$listcat ="";
	while(list($cat_id, $titlecat) = $db->sql_fetchrow($resultcat)) 
	{

		$listcat .= "<option value=\"$cat_id\">$titlecat</option>";
	}
	echo $listcat;
	echo "</select>";
}

	?>
	<label for="action"></label>
	<?php
	$resultcat = $db->sql_query("SELECT id, menhgia,giaban FROM {$prefix}_thecao_menhgia WHERE active=1 ORDER BY id");
if($db->sql_numrows($resultcat) > 0) 
{
	echo '<select id="menhgia" name="s_menhgia">'."\n";
	echo '<option value="">Chọn mệnh giá</option>';
	$listcat ="";
	while(list($id, $menhgia,$giaban) = $db->sql_fetchrow($resultcat)) 
	{

		$listcat .= "<option value=\"$id\"> $menhgia </option>";
	}
	echo $listcat;
	echo "</select>";
}

	?>
	
	<label for="from">From</label>
	<input type="text" id="from" name="from"  style="width: 80px"/>
	<label for="to">to</label>
	<input type="text" id="to" name="to"  style="width: 80px"/>
	
	<select id="s_time" name="s_time">
	<option value="0">Mới nhất</option>
	<option value="1">Cũ nhất</option>
	</select>
	<label for="action">Số lượng</label>
	<input type="text" id="s_quantity" value="20" style="width: 40px" name="s_quantity" />
	<input type="submit" class="button2" value="Tìm kiếm"  name="subs" />
	
</form>
</div></div><!-- End demo -->
<?php
echo "<div id=\"pagecontent\">";
$s_name = isset($_GET["s_name"]) ? $_GET["s_name"] : '';
$s_code = isset($_GET["s_code"]) ? $_GET["s_code"] : '';
$s_cat = isset($_GET["s_cat"]) ? $_GET["s_cat"] : "";
$s_quantity=isset($_GET["s_quantity"]) ? $_GET["s_quantity"] : 20;
$s_time=isset($_GET["s_time"]) ? $_GET["s_time"] : '';
$s_serial = isset($_GET["s_serial"]) ? $_GET["s_serial"] : '';
$s_menhgia = isset($_GET["s_menhgia"]) ? $_GET["s_menhgia"] : '';

$where="WHERE id > 0 ";
$vlink="";
if(!empty($s_name))
{
	$s_name=trim($s_name);
	$where.="AND userid IN (SELECT id FROM {$prefix}_user WHERE fullname='$s_name')";
	$vlink.="&name=$s_name";
}
if(!empty($s_code))
{
	$s_code=trim($s_code);
	$where.="AND code LIKE '%$s_code%'";
	$vlink.="&code=$s_code";
}
if(!empty($s_cat))
{
	$where.="AND code IN (SELECT code FROM {$prefix}_thecao WHERE catid=$s_cat)";
	$vlink.="&cat=$s_cat";
}
if(!empty($s_serial))
{
	$s_serial=trim($s_serial);
	$where.="AND serial LIKE '%$s_serial%'";
	$vlink.="&serial=$s_serial";
}
if(!empty($s_menhgia))
{
	$s_menhgia=trim($s_menhgia);
	$where.="AND code IN (SELECT code FROM {$prefix}_thecao WHERE menhgia=$s_menhgia)";
	$vlink.="&s_menhgia=$s_menhgia";
}
if(!empty($from))
{
	if(preg_match("/^([0-9]{1,2})\-([0-9]{1,2})\-([0-9]{4})$/",$from,$match)){
		$from=mktime(0,0,0,$match[2],$match[1],$match[3]);
	}
	$where.="AND time >= $from ";
	$vlink.="&from=$from";
}
if(!empty($to))
{
	if(preg_match("/^([0-9]{1,2})\-([0-9]{1,2})\-([0-9]{4})$/",$to,$match)){
		$to=mktime(0,0,0,$match[2],$match[1],$match[3]);
	}
	$where.="AND time < $to ";
	$vlink.="&to=$to";
}
if($s_time==0)
{
	$where.=" ORDER BY time DESC";
	$vlink.="&$s_time=$s_time";
}
elseif($s_time==1)
{	
	$where.=" ORDER BY time ASC";
	$vlink.="&$s_time=$s_time";
}

//$countf = $db->sql_fetchrow($db->sql_query("SELECT COUNT(*) FROM {$prefix}_thecao $where"));
//$total = ($countf[0]) ? $countf[0] : 1;
$result = $db->sql_query("SELECT id, code, serial, time, price, userid FROM {$prefix}_thecao_buy $where LIMIT $s_quantity");
//die("SELECT id, code, serial, time, price, userid FROM {$prefix}_thecao_buy $where LIMIT $s_quantity");
//$offset,$perpage
if($db->sql_numrows($result) > 0) {
	echo "<script language=\"javascript\" type=\"text/javascript\">\n";
	echo "function check_uncheck(){\n";
	echo "	var f=document.frm;\n";
	echo "	if(f.checkall.checked){\n";
	echo "		CheckAllCheckbox(f,'id[]');\n";
	echo "	}else{\n";
	echo "		UnCheckAllCheckbox(f,'id[]');\n";
	echo "	}			\n";
	echo "}\n";
	echo "	function checkQuick(f) {\n";
	echo "		if(f.fc.value =='') {\n";
	echo "			f.fc.focus();\n";
	echo "			return false;\n";
	echo "		}\n";
	echo "		f.submit.disabled = true; \n";
	echo "		return true;		\n";
	echo "	}	\n";
	echo "	function checkQuickId(f) {\n";
	echo "		if(f.id.value =='') {\n";
	echo "			f.id.focus();\n";
	echo "			return false;\n";
	echo "		}\n";
	echo "		f.submit.disabled = true; \n";
	echo "		return true;		\n";
	echo "	}	\n";
	echo "</script>\n";
	ajaxload_content();

	echo "<div id=\"".$adm_modname."_main\"><form action=\"modules.php?f=$adm_modname&do=$do\" name=\"frm\" method=\"POST\" onsubmit=\"return checkQuick(this);\">";
	echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" class=\"tableborder\">\n";
	echo "<tr><td colspan=\"10\" class=\"header\">Lịch sử giao dịch thẻ</td></tr>";
	echo "<tr>\n";
	echo "<td class=\"row1sd\" width=\"20\" align=\"center\">".sortBy("modules.php?f=$adm_modname",1)."</td>\n";
	echo "<td class=\"row1sd\" width=\"80\">Người mua</td>\n";
	echo "<td class=\"row1sd\">Mã code</td>\n";
	echo "<td class=\"row1sd\">Mã serial</td>\n";
	echo "<td class=\"row1sd\">Loại thẻ</td>\n";
	echo "<td class=\"row1sd\"  align=\"center\" width=\"180\">Mệnh giá</td>\n";
	echo "<td class=\"row1sd\"  align=\"center\" width=\"80\">Giá bán</td>\n";
	echo "<td class=\"row1sd\" align=\"center\" width=\"100px\">"._TIMEUP."</td>\n";
	echo "</tr>\n";
	$i =0;
	$a = 1;
	//if($page > 1) { $a = $perpage*$page - $perpage + 1;}
	$total_menhgia=0;
	$total_giaban=0;
	while(list($id, $code, $serial, $time, $price, $userid) = $db->sql_fetchrow($result)) {
		$resultthecao= $db->sql_query("SELECT catid,menhgia FROM ".$prefix."_thecao WHERE code='$code'");
		if($db->sql_numrows($resultthecao) > 0 ) {
			list($catid, $menhgia) = $db->sql_fetchrow($resultthecao); 
				
		}
		else{
			$catid=0;
			$menhgia=0;
		}
		if($i <7) {
			$css = "row1";
		}	else {
			$css ="row3";
		}
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"$css\">$a</td>";
		echo "<td class=\"$css\">".show_user($userid)."</td>";
		echo "<td class=\"$css\"><b>$code</b></td>\n";
		echo "<td class=\"$css\"><b>$serial</b></td>\n";
		echo "<td class=\"$css\"><b>".catname($catid)."</b></td>\n";
		echo "<td class=\"$css\" align=\"right\"><b>".show_menhgia($menhgia)."</b></td>\n";
		echo "<td class=\"$css\" align=\"right\"><b>".bsVndDot($price)."</b></td>\n";
		echo "<td align=\"center\" class=\"$css\">".ext_time($time, 2)."</td>\n";
		echo "</tr>\n";
		$total_menhgia=$total_menhgia+show_menhgia($menhgia);
		$total_giaban=$total_giaban+$price;
		//
		$i ++;
		$a ++;
	}
	echo "<tr>\n";
		echo "<td align=\"center\" class=\"$css\"></td>";
		echo "<td class=\"$css\"></td>";
		echo "<td class=\"$css\"></td>\n";
		echo "<td class=\"$css\"></td>\n";
		echo "<td class=\"$css\"></td>\n";
		echo "<td class=\"$css\" align=\"right\"></td>\n";
		echo "<td class=\"$css\" align=\"right\"><b>Tổng: ".bsVndDot($total_giaban)."</b></td>\n";
		echo "<td align=\"center\" class=\"$css\"></td>\n";
		echo "</tr>\n";
	//if($total > $perpage) {
	//	echo "<tr><td colspan=\"9\">";
	//	$pageurl = "modules.php?f=".$adm_modname."&sort=$sort";
	//	echo paging($total,$pageurl,$perpage,$page);
	//	echo "</td></tr>";
	//}
	//echo "<input type=\"hidden\" name=\"do\" value=\"quick_do\">";
	//echo "<tr><td colspan=\"10\" class=\"row3\"><select name=\"fc\">";
	//echo "<option value=\"\">&raquo; "._QUICKDO."</option>";
	//echo "<option value=\"1\">&raquo; "._QUICKDO_1."</option>";
	//echo "<option value=\"2\">&raquo; "._QUICKDO_2."</option>";
	//echo "<option value=\"3\">&raquo; "._QUICKDO_3."</option>";	
	//echo "</select> <input type=\"submit\" class=\"button2\" name=\"submit\" value=\""._DOACTION."\"></form></td></tr>";
	echo "</table></div></div>";

		

}else{
	
}

include_once("page_footer.php");
?>