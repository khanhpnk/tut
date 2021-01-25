<?php
if (!defined('CMS_SYSTEM')) header("Location: index.php");
if(file_exists("data/config_document.php")) require("data/config_document.php");
global $path_upload, $mod_name, $id, $Default_Temp, $urlsite, $home;

$bl_arr = array();
$bl_arr[] = $bl_l;
$bl_arr[] = $bl_r;
$basename = pathinfo(__FILE__, PATHINFO_BASENAME);
$correctArr = array();
for ($i = 0; $i < count($bl_arr); $i++) {
	for ($h = 0; $h < count($bl_arr[$i]); $h++) {
		$temp = explode("@", $bl_arr[$i][$h]);
		if (($temp[5] == $currentlang) && ($temp[6] == $basename)) {
			$correctArr = $temp;
			break;
		}
	}
}
$margin="";
$content ="";
if($home==1)
	{
?><div class="adv-hotnew">
	<div class="style5" id="style5"><ul>
		<?php
		$result_lastnew = $db->sql_query("SELECT id, title, images, time, hometext FROM ".$prefix."_news WHERE special=1 AND active='1' AND  alanguage='$currentlang' ORDER BY time DESC LIMIT 5");
		$numrows = $db->sql_numrows($result_lastnew);
		if($numrows > 0) {
			?>
			<?php
			while(list($idlast, $titlelast, $imageslast, $time, $hometext) = $db->sql_fetchrow($result_lastnew)) 
			{
				$a=$idlast;
				$get_path = get_path($time);
				$path_upload_img = "$path_upload/news/$get_path";
				$path_upload_img2 = "$path_upload/news";
				if($imageslast !="" && file_exists("$path_upload_img/$imageslast")) 
				{
					$imageslast= resize_image($titlelast, $imageslast, $path_upload_img, $path_upload_img2, 300,180);
				}
				else
				{
					$imageslast= resize_image($titlelast, 'no_image.gif', 'images', $path_upload_img2, 300,180);
				}
				?>
					<li>
						<a href="<?php echo url_sid("index.php?f=news&do=detail&id=$idlast")?>"><?php echo $imageslast?></a>
						<h2><a href="<?php echo url_sid("index.php?f=news&do=detail&id=$idlast")?>"><?php echo $titlelast?></a></h2>
					</li>
					
		<?php
			}
		}
		?>
		</ul></div>
	<div class="block-event">
<div class="style4" id="style4"><ul>
<?php
$result_lastnew = $db->sql_query("SELECT id, title, images, time, hometext FROM ".$prefix."_news WHERE special=1 AND active='1' AND alanguage='$currentlang' AND ( catid=22 or catid in(SELECT catid FROM {$prefix}_news_cat WHERE parent=22)) ORDER BY time DESC LIMIT 5");
$numrows = $db->sql_numrows($result_lastnew);
if($numrows > 0) {
	$a=0;
	?>
	<?php
	while(list($idlast, $titlelast, $imageslast, $time, $hometext) = $db->sql_fetchrow($result_lastnew)) 
	{
		$hometext = preg_replace("/<.*?>/", "", $hometext);
		$a=$idlast;
		$get_path = get_path($time);
		$path_upload_img = "$path_upload/news/$get_path";
		$path_upload_img2 = "$path_upload/news";
		if($imageslast !="" && file_exists("$path_upload_img/$imageslast")) 
		{
			$imageslast= resize_image($titlelast, $imageslast, $path_upload_img, $path_upload_img2, 300,173);
		}
		else
		{
			$imageslast= resize_image($titlelast, 'no_image.gif', 'images', $path_upload_img2, 300,173);
		}
		?>
			<li>
				<span><a href="<?php echo url_sid("index.php?f=news&do=categories&id=22");?>"><?php echo _EVENTS;?></a></span>
				
				<h4># <?php echo ext_time($time,1)?><br><a href="<?php echo url_sid("index.php?f=news&do=detail&id=$idlast")?>"><strong><?php echo $titlelast?><p></strong><?php echo CutString($hometext,220)?></p></a></h4>
			</li>
			
<?php
	}
}
?>
</ul></div></div>
	</div>
<?php
}
$result_lastnew = $db->sql_query("SELECT n.id, n.title, n.images, n.time, n.hometext, n.hits, n.hits_download, u.folder, u.fullname FROM ".$prefix."_document AS n, ".$prefix."_user AS u WHERE  n.active=1 AND n.alanguage='$currentlang'  AND n.user_id=u.id ORDER BY n.time DESC LIMIT 18");
$numrows = $db->sql_numrows($result_lastnew);

	$a=0;
	$content .= "<div class=\"div-block\">";
	$content .= "<div class=\"div-tblock\"><div class=\"fl\">{$correctArr[1]}</div><div class=\"pagination fr\" id=\"foo222_pag\"></div><div class=\"cl\"></div></div>";
	$content .= "<div class=\"div-cblock\">";
if($db->sql_numrows($result_lastnew) > 0)  {
	$content .= "<div class=\"document-block\" >";
	$content .= "<div id=\"foo222\">";
	$content .= "<div class=\"document-group\">";
	while(list($idlast, $titlelast, $imageslast, $time, $hometext, $hits, $hits_download, $folder, $fullname) = $db->sql_fetchrow($result_lastnew)) 
	{
		$rwtitlelast = utf8_to_ascii(url_optimization($titlelast));
		$url_news_detail =url_sid("index.php?f=document&do=detail&id=$idlast");
		$path_upload_img = "$path_upload/document/$folder";
		$path_upload_noimg = "$path_upload/document";
		$a++;
		if(file_exists("$path_upload_img/$imageslast") && $imageslast !="") {
			$imageslast = resize_image($titlelast,$imageslast,$path_upload_img,$path_upload_img,60,80);
		}
		else
		{
			$imageslast = resize_image($titlelast,'no_image.gif','images',$path_upload_noimg,60,80);
		}
		$content .= "<div class=\"document-item fl\" style=\"$margin\"><div class=\"document-img fl\"><a href=\"$url_news_detail\">$imageslast</a></div>";
			$content .= "<div  class=\"document-title fl\"><a href=\"$url_news_detail\" title=\"$titlelast\">".CutString($titlelast,50)."</a>
			</div><div class=\"cl\"></div></div>";
			//<p>".show_money($price)."</p>
		if($a==6 || $a==12){$content .= "</div><div class=\"document-group\">";}
		
	}
	$content .= "</div>";
	$content .= "</div>";
	$content .= "</div>";
	 $content .= "<div class=\"cl\"></div>";
}
else
{
$content .= "Đang cập nhật";	
}
	$content .= "</div></div>";



///////////=== san pham khac cung loai

?>