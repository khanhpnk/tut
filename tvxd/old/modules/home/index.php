<?php
if (!defined('CMS_SYSTEM')) die();
global $Default_Temp, $time,$urlsite, $userInfo;
include_once("header.php");
//include("includes/resize-class.php");
//OpenTab(_HOMEPAGE);

//hien thi tin noi bat
?>

<?php
/////////////////////////////////////////////////////////////

$result_catindex = $db->sql_query("SELECT catid, title, guid, homelinks FROM {$prefix}_document_cat WHERE active=1 AND onhome=1 AND alanguage='$currentlang' ORDER BY weight");
if($db->sql_numrows($result_catindex) > 0) {
	$k=0;
	$i=2;
	while(list($catid, $titlecat, $catguid, $homelinks) = $db->sql_fetchrow($result_catindex)){
		if($k==0)
			echo advertising(15);
		elseif($k==2)
			echo advertising(16);
		elseif($k==4)
			echo advertising(17);
		elseif($k==6)
			echo advertising(18);
	$k++;
?>
<div class="folder">
	<div class="folder-box of fl">
		<div class="folder-box-title">
			<div class="fl"><a  class="folder-link" href="<?php echo url_sid($catguid)?>"><?php echo $titlecat?></a></div>
			<div class="folder-sub fl">
			<?php
			$result = $db->sql_query("SELECT catid, title, guid, homelinks FROM {$prefix}_document_cat WHERE active=1 AND parent=$catid AND alanguage='$currentlang' ORDER BY weight");
			if($db->sql_numrows($result) > 0) 
			{
				$j=1;
				while(list($catid_sub, $titlecat_sub, $catguid_sub, $homelinks_sub) = $db->sql_fetchrow($result))
				{
					if($j!=1){echo " | ";}
					?>	
						<a class="link-subfolder" href="<?php echo url_sid($catguid_sub)?>"><?php echo $titlecat_sub?></a>
			<?php
					$j++;
				}
			}
			?>
			</div>

			<div class="document-nav fr"><a href="#" id="prev<?php echo $i?>"><span>Prev</span></a> <a href="#" id="next<?php echo $i?>"><span>Next</span></a></div>
			<div class="cl"></div>
		</div>	
		<?php

$result_lastnew = $db->sql_query("SELECT n.id, n.title, n.guid, n.images, n.time, n.price, u.fullname, u.folder FROM ".$prefix."_document AS n,".$prefix."_user AS u WHERE n.alanguage='$currentlang' AND n.active=1  AND n.user_id=u.id AND (n.catid=$catid ".query_muticat("catid","parent",$catid,"".$prefix."_document_cat").") ORDER BY n.time DESC LIMIT 15");

$numrows = $db->sql_numrows($result_lastnew);
if($numrows > 0) {
	$a=1;
	?>
	<div class="document-folder" id="document-folder<?php echo $i;?>">
		<div class="document-group">
	<?php
			while(list($idlast, $titlelast, $guidlast, $imageslast, $time, $price, $fullname, $folder) = $db->sql_fetchrow($result_lastnew)) {
			/*$hometext = preg_replace("/<.*?>/", "", $hometext);*/
		
			$path_upload_img = "$path_upload/document/$folder";
			$path_upload_noimg = "$path_upload/document";
			if($imageslast !="" && file_exists("$path_upload_img/$imageslast")) 
			{
				$imageslast = resize_image($titlelast,$imageslast,$path_upload_img,$path_upload_img,122,177);
			}
			else
			{
				$imageslast = resize_image($titlelast,'no_image.gif','images',$path_upload_noimg,122,177);
			}
		?>
		
			<div class="document-item fl">
				<div><a href="<?php echo str_replace("http://","https://",url_sid($guidlast)); ?>" class="document-link"><?php echo $imageslast?></a></div>
				<!--<div  class="document-title"><p><a href="<?php echo url_sid($guidlast)?>"><strong><?php echo CutString($titlelast,45) ;?></strong></a></p></div>-->
				<div class="money-view"><span><?php echo check_docdown($idlast);?></span></div>
			</div>
		
		
		<?php
		if($a==5){echo "</div><div class=\"document-group\">";}
		$a++;
		//<br><?php echo show_money($price) </a>
		}
	?>
		</div>
	</div>
	<div class="cl"></div>
	<?php
			}
	?>
</div>
	<div class="cl"></div>
	</div>
<?php
			$i++;
		}
	}
?>

<?php
//CloseTab();

include_once("footer.php");
?>

