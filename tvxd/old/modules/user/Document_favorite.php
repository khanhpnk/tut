<?php
global $module_name, $userInfo;
if (!defined('CMS_SYSTEM')) die();

if (!defined('iS_USER') || !isset($userInfo)) header("Location: ".url_sid("index.php?f=user&do=login")."");
$fcatid= isset($_GET['id']) ? intval($_GET['id']) : 0;
$page_title = "Danh sách tài liệu yêu thích";

$path_upload_attach = "$path_upload/document";//path upload file attach
include_once('header.php');

$title = $err_title = "";
if(isset($_POST['subup'])&& $_POST['subup'] == 1) {
	$err = 0;
	$title = $escape_mysql_string(trim($_POST['title']));
	$userid = $userInfo['id'];

	if(empty($title)) {
		$err_title = "<font color=\"red\">Mời bạn nhập tiêu đề.</font><br/>";
		$err = 1;
	}
	if(!$err) {
		$db->sql_query("INSERT INTO ".$prefix."_document_favorites_cat (catid, title, user_id) VALUES (NULL, '$title', '$userid')");
		header("Location: index.php?f=user&do=document_favorite");
	}
} else {
	$err_title = "";
	$title = "";
}

echo '<div class="fl" style="width:207px; margin-right:10px">';
OpenTab("Danh mục tài liệu yêu thích");
$resultcat = $db->sql_query("SELECT catid, title FROM {$prefix}_document_favorites_cat WHERE user_id=".$userInfo['id']." ORDER BY catid");
if($db->sql_numrows($resultcat) > 0) 
{
	echo '<div style="border-bottom:1px solid #ebebeb; padding:5px"><a href="'.$urlsite.'/index.php?f=user&do=document_favorite">Xem tất cả</a></div>';
	while(list($cat_id, $titlecat) = $db->sql_fetchrow($resultcat)) 
	{
		echo '<div style="border-bottom:1px solid #ebebeb; padding:5px"><a href="'.$urlsite.'/index.php?f=user&do=document_favorite&id='.$cat_id.'">'.$titlecat.'</a></div>';
	}
}

CloseTab();
echo '</div><div class="fl" style="width:78%">';

OpenTab("Thêm danh mục tài liệu yêu thích");
echo "<form action=\"index.php?f=user&do=document_favorite\" method=\"POST\" onsubmit=\"return check(this);\">";
echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" class=\"tableborder\">\n";
echo "<tr>\n";
echo "<td width=\"30%\" align=\"right\" class=\"row1\"><b>"._TITLE."</b></td>\n";
echo "<td class=\"row2\">$err_title<input type=\"text\" id=\"title\" name=\"title\" value=\"$title\" size=\"50\"> <input type=\"hidden\" name=\"subup\" value=\"1\"> <input type=\"submit\" class=\"sb_but1\" id=\"submit\" name=\"submit\" value=\""._ADD."\"></td></tr>";
echo "</table></form>";
CloseTab();

OpenTab("Danh sách tài liệu yêu thích");
$sort = intval(isset($_GET['sort']) ? $_GET['sort'] : (isset($_POST['sort']) ? $_POST['sort']:0));
switch($sort) {
	case 1: $sortby ="ORDER BY id ASC"; break;
	case 2: $sortby ="ORDER BY id DESC"; break;
	case 3: $sortby ="ORDER BY userid ASC"; break;
	case 4: $sortby ="ORDER BY userid DESC"; break;
	case 5: $sortby ="ORDER BY documentid ASC"; break;
	case 6: $sortby ="ORDER BY documentid DESC"; break;
	default: $sortby ="ORDER BY id DESC"; break;
}
$perpage = 15;
$page = intval(isset($_GET['page']) ? $_GET['page'] : (isset($_POST['page']) ? $_POST['page']:1));
$offset = ($page-1) * $perpage;
$catArr = array();
$cats = $db->sql_query("SELECT catid, title FROM {$prefix}_document_cat");
while (list($cid, $ctitle) = $db->sql_fetchrow()) $catArr[$cid] = $ctitle;

$titleup = isset($_GET["title"]) ? $_GET["title"] : "";
$cat = isset($_GET["cat"]) ? $_GET["cat"] : "";
$from = isset($_GET["from"]) ? $_GET["from"] : "";
$to = isset($_GET["to"]) ? $_GET["to"] : "";

$where="WHERE f.documentid=d.id AND f.catid=c.catid ";
$vlink="";
if(!empty($titleup))
{
	$titleup2=url_optimization(trim($titleup));
	$where.="AND d.title LIKE '%$titleup%' ";
	$vlink.="&title=$titleup";
}
if($fcatid!=0)
{
	$where.="AND c.catid=$fcatid";
	$vlink.="&id=$fcatid";
}

$total = $db->sql_numrows($db->sql_query("SELECT f.id, f.catid, f.userid, f.documentid, d.title, c.title FROM {$prefix}_document_favorites AS f, {$prefix}_document AS d, {$prefix}_document_favorites_cat AS c $where"));
$result = $db->sql_query("SELECT f.id, f.catid, f.userid, f.documentid, d.title, c.title FROM {$prefix}_document_favorites AS f, {$prefix}_document AS d, {$prefix}_document_favorites_cat AS c $where AND d.user_id='".$userInfo['id']."' $sortby LIMIT $offset, $perpage");

if($db->sql_numrows($result) > 0) {

	?>
<div class="toolbar"><div style="text-align:right; padding-right:30px">
<form action="" name="frmtool" method="get">
	<input type="hidden" name="f" value="user" />
    	<input type="hidden" name="do" value="document_favorite" />
	<input type="text" id="title" value="" name="title" />
	<input type="submit" class="sb_but1" value="Tìm kiếm"  name="subs" />
	
</form>

</div></div><!-- End demo -->

<?php ajaxload_content();
echo "<div id=\"pagecontent\">";
	echo "<div id=\"document_main\"><form action=\"modules.php?f=user&sort=$sort&page=$page\" name=\"frm\" method=\"POST\" onsubmit=\"return checkQuick(this);\">";
	echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" style=\"border:1px solid #E4E8F0\" >\n";
	echo "<tr  style=\"border:1px solid #CCC\">\n";
	echo "<td class=\"row1sd\" align=\"left\">Tài liệu</td>\n";
	echo "<td class=\"row1sd\">Chuyên mục</td>\n";
	echo "</tr>\n";
	$i = 0;
	if($page > 1) { $a = $perpage * $page - $perpage + 1;}
	while(list($id, $catid, $userid, $documentid, $dtitle, $ctitle) = $db->sql_fetchrow($result)) {
		//if (($i % 8) == 1) $css = "row1";
		//else $css ="row3";
		$css ="row1";
		echo "<tr >\n";
		echo "<td align=\"left\" class=\"row1\"><a target=\"_blank\" href=".url_sid("index.php?f=document&do=detail&id=$documentid").">$dtitle</a></td>\n";
		echo "<td class=\"row1\"><b><a href=\"$urlsite/index.php?f=user&do=document_favorite&id=$catid\">$ctitle</a></td>\n";
		echo "</tr>\n";
		$i++;
	}
	echo "<tr><td colspan=\"10\"><div class=\"fr\">";
	if($total > $perpage) {
		$pageurl = "index.php?f=user&do=document_list&sort=$sort";
		echo paging($total,$pageurl,$perpage,$page);
	}
		echo "</div>";
	echo "</td></tr>";
	echo "</table></form></div></div>";
} else {
	
	?>
<div class="toolbar"><div style="text-align:right; padding-right:30px">
<form action="" name="frmtool" method="get">
	<input type="hidden" name="f" value="user" />
    	<input type="hidden" name="do" value="document_favorite" />
	<input type="text" id="title" value="" name="title" />
	<input type="submit" class="sb_but1" value="Tìm kiếm"  name="subs" />
	
</form>

</div></div><!-- End demo -->
<?php
	echo "<div  class=\"content\" align=\"center\">";
	echo "<center>"._DOCUMENT_NO_POST."</center>";
	//echo "<META HTTP-EQUIV=\"refresh\" content=\"5;URL=index.php?f=user&do=document_list\">";
	echo "</div>";
}
CloseTab();
echo '</div><div class="cl"></div>';
include_once('footer.php');
?>