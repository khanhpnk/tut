<?php
if(!defined('CMS_ADMIN')) die("Illegal File Access");
global $url_site;
//luu dia chi truy cap
if(empty($_SESSION['linkpage']))
	$_SESSION['linkpage']="".$_SERVER['QUERY_STRING']."";
include_once("page_header.php");
$sort = intval(isset($_GET['sort']) ? $_GET['sort'] : (isset($_POST['sort']) ? $_POST['sort']:0));
switch($sort) {
	case 1: $sortby ="ORDER BY id ASC"; break;
	case 2: $sortby ="ORDER BY id DESC"; break;
	case 3: $sortby ="ORDER BY time ASC"; break;
	case 4: $sortby ="ORDER BY time DESC"; break;
	case 5: $sortby ="ORDER BY docid ASC"; break;
	case 6: $sortby ="ORDER BY docid DESC"; break;
	default: $sortby ="ORDER BY id DESC"; break;
}

$titleup = isset($_GET["title"]) ? $_GET["title"] : "";
$from = isset($_GET["from"]) ? $_GET["from"] : "";
$to = isset($_GET["to"]) ? $_GET["to"] : "";
$s_quantity=isset($_GET["s_quantity"]) ? $_GET["s_quantity"] : 20;
$status=isset($_GET["status"]) ? $_GET["status"] : 0;
$where="WHERE id>0 ";
$vlink="";
$perpage = 15;
$page = intval(isset($_GET['page']) ? $_GET['page'] : (isset($_POST['page']) ? $_POST['page']:1));
$offset = ($page-1) * $s_quantity;
if(!empty($titleup))
{
	$titleup2=url_optimization(trim($titleup));
	$where.="AND title LIKE '%$titleup%'";
	$vlink.="&title=$titleup";
}
//if(!empty($cat))
//{
//	$where.="AND catid=$cat ";
//	$vlink.="&cat=$cat";
//}
//if(!empty($user))
//{
//	$user=trim($user);
//	$where.="AND user_id IN (SELECT id FROM {$prefix}_user WHERE fullname='$user')";
//	$vlink.="&user=$user";
//}
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

$total = $db->sql_numrows($db->sql_query("SELECT id FROM {$prefix}_link_report $where"));
$result = $db->sql_query("SELECT id, docid, time, name, email, url, url_replace, title, content, status FROM {$prefix}_link_report $where $sortby LIMIT $offset, $s_quantity");
if($db->sql_numrows($result) > 0) {
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
	<input type="hidden" name="f" value="document" />
	<input type="hidden" name="do" value="link_report"/>
	<label for="action">Tiêu đề</label>
	<input type="text" id="title" value="" name="title" />
	<label for="action">Người đăng</label>
	<input type="text" id="user" value="" name="user" />
	<label for="from">From</label>
	<input type="text" id="from" name="from"/>
	<label for="to">to</label>
	<input type="text" id="to" name="to"/>
	<label for="action">Số lượng</label>
	<input type="text" id="s_quantity" value="20" style="width: 40px" name="s_quantity" />
	<input type="submit" class="button2" value="Tìm kiếm"  name="subs" />
	
</form>
</div></div><!-- End demo -->

<?php ajaxload_content();
echo "<div id=\"pagecontent\">";
	echo "<div id=\"{$adm_modname}_main\"><form action=\"modules.php?f=$adm_modname&sort=$sort&page=$page\" name=\"frm\" method=\"POST\" onsubmit=\"return checkQuick(this);\">";
	echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" class=\"tableborder\">\n";
	echo "<tr><td colspan=\"15\" class=\"header\">Danh sách tài liệu báo lỗi</td></tr>";
	echo "<tr>\n";
	echo "<td class=\"row1sd\" align=\"center\">ID</td>\n";
	echo "<td class=\"row1sd\" width=\"250\">"._TITLE."</td>\n";
	echo "<td class=\"row1sd\">Nội dung</td>\n";
	echo "<td class=\"row1sd\">Người gửi</td>\n";
	echo "<td class=\"row1sd\">URL</td>\n";
	echo "<td class=\"row1sd\" align=\"center\" width=\"60\">Link thay thế</td>\n";
	echo "<td class=\"row1sd\" align=\"center\" width=\"100\">"._TIMEUP." <a href=\"?f=".$adm_modname."&sort=3\" info=\""._SORTUP."\"><img border=\"0\" src=\"images/sup.gif\" align=\"absmiddle\"></a> <a href=\"?f=".$adm_modname."&sort=4\" info=\""._SORTDOWN."\"><img border=\"0\" src=\"images/sdown.gif\" align=\"absmiddle\"></a></td>\n";
	
	echo "<td class=\"row1sd\" align=\"center\" width=\"60\">"._STATUS."</td>\n";
	echo "<td class=\"row3sd\" align=\"center\" width=\"30\">"._DELETE."</td>\n";
	echo "</tr>\n";
	$i = 0;
	if($page > 1) { $a = $s_quantity * $page - $s_quantity + 1;}
	while(list($id, $docid, $time, $name, $email, $url, $url_replace, $title, $content, $status) = $db->sql_fetchrow($result)) {
		$css ="row1";
			switch($status) {
				case 0: $status = "<a href=\"?f=".$adm_modname."&do=views_link&id=$id\" info=\"chưa xử lý\"><img border=\"0\" src=\"images/view0.png\"></a>"; break;
				case 1: $status = "<a href=\"?f=".$adm_modname."&do=views_link&id=$id\" info=\"đang xử lý\"><img border=\"0\" src=\"images/view.png\"></a>"; break;
				case 2: $status = "<a href=\"?f=".$adm_modname."&do=views_link&id=$id\" info=\"đã xử lý\"><img border=\"0\" src=\"images/view.png\"></a>"; break;
			}
		
		echo "<tr>\n";
		?>
<div id="url_replace<?php echo $id?>" style="width:450px;display: none;">
	<iframe width="100%" src="modules.php?f=document&do=url_replace&id=<?php echo $id?>"></iframe>
</div>
<?php
		echo "<td align=\"center\" class=\"$css\">$id</td>\n";
		echo "<td class=\"$css\"><b>$title</b></td>\n";
		echo "<td class=\"$css\"><b>$content</b></td>\n";
		echo "<td class=\"$css\"><b>$name ($email)</b></td>\n";
		echo "<td class=\"$css\"><b><a target=\"_blank\" href=\"$url\">$url</a></b></td>\n";
		echo "<td class=\"$css\">$url_replace</td>";
		echo "<td align=\"center\" class=\"$css\">".ext_time($time, 2)."</td>\n";
		
		echo "<td align=\"center\" class=\"$css\">$status</td>\n";
		echo "<td align=\"center\" width=\"30\" class=\"row3\"><a href=\"?f=".$adm_modname."&do=delete_link&id=$id\" info=\""._DELETE."\" onclick=\"return confirm('"._DELETEASK1."');\"><img border=\"0\" src=\"images/delete.png\"></td>\n";
		echo "</tr>\n";
		$i++;
		$checkfile="";
	}
	echo "<tr><td colspan=\"15\" class=\"row4\">";
	echo "<div class=\"fr\">";
	if($total > $s_quantity) {
		$pageurl = "modules.php?f=".$adm_modname."&sort=$sort&title=$titleup&cat=$cat&user=$user&from=$from&to=$to&active=$s_active&s_quantity=$s_quantity&subs=Tìm+kiếm";
		echo paging($total,$pageurl,$s_quantity,$page);
	}
		echo "</div>";
	echo "</td></tr>";
	echo "</table></form></div></div>";
} else {
	//OpenDiv();
	echo "<div class=\"info\">"._NONEWSPOST."</div>";
	//echo "<META HTTP-EQUIV=\"refresh\" content=\"5;URL=modules.php?f=".$adm_modname."&do=create\">";
	//CLoseDiv();
}

include_once("page_footer.php");
?>
