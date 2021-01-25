<?php if (!defined('CMS_SYSTEM')) die(); ?>
<?php function temp_document_cat_index($catid, $titlecat, $idnewind, $titlenewind, $hometextind, $document_pic_index, $othersnewindex, $url_document_detail, $url_document_cat) { 
	OpenTab($titlecat,$url_document_cat); ?>

	<table border="0" width="100%" cellpadding="0" style="border-collapse: collapse">
	<tr>
	<td>
	<div style="margin-bottom: 3px" class="content">
		<?php if ($document_pic_index!=""){?>
		<img src="<?php echo $document_pic_index ?>" title="<?php echo $titlenewind?>" alt="<?php echo $titlenewind?>"/>
		<?php } ?>
		<a href="$url_document_detail" class="titlecat"><h3><?php echo $titlenewind ?></h3></a></div>
	<div align="justify" class="content"><?php echo $hometextind ?></div>
	<div class="viewmore" style="margin-top: 6px"><a  class="ui-state-default ui-corner-all" id="dialog_link" href="<?php echo $url_document_detail ?>"><span class="ui-icon ui-icon-newwin"></span><?php echo _READMORE ?></a></div>
	</td>
	</tr>
<?php	if($othersnewindex) {?>
		<tr><td style="padding-left: 8px; padding-top: 10px;"><?php echo $othersnewindex ?></td></tr>
<?php 	}?>
</table>
	
<?php CloseTab(); }?>
<?php
function temp_document_other_index($idother,$url_document_other,$titleother)
{
	$str="";
	 $str=" <div style=\"margin-bottom: 2px\"><span style=\"padding-right: 8px\"><img border=\"0\" src=\"images/bullet.gif\"  alt=\"bullet\"/></span><a href=\"$url_document_other\">$titleother</a></div>";
	 return $str;
}

?>

<?php
function temp_document_loop_cat_index($catid, $titlecat, $idnewind, $titlenewind, $hometextind, $document_pic_index, $othersnewindex, $url_document_detail, $url_document_cat) 
{ OpenTab($titlecat,$url_document_cat); ?>

	<div class="content">
		<?php if ($document_pic_index!=""){?>
		<img src="<?php echo $document_pic_index ?>" title="<?php echo $titlenewind?>" alt="<?php echo $titlenewind?>"/>
		<?php } ?>
		<a href="<?php echo $url_document_detail ?>" class="titlecat">
			<h2><?php echo $titlenewind ?></h2>
		</a>
		<?php echo $hometextind ?>
	</div>
	<div class="cl"></div>
	<div class="viewmore">
		<a  class="ui-state-default ui-corner-all" href="<?php echo $url_document_detail ?>">
			<span class="ui-icon ui-icon-newwin"></span><?php _READMORE ?>
		</a>
	</div>
	<?php if($othersnewindex) {
		echo $othersnewindex;
	} ?>
	
<?php CloseTab();}?>
<?php
function temp_document_detail($id, $code, $title, $time, $hometext, $bodytext, $fattach, $othershow, $document_img, $imgtext, $new_others, $new_others2, $source, $document_tid, $title_seo, $description_seo, $keyword_seo, $tags_seo, $hits, $comment, $comment_content, $fattach_intro, $hits_download, $folder, $fullname, $fattach, $link_extend, $price) {
	global $module_name, $adm_mods_ar, $admin_fold, $url ,$urlsite,$path_upload;
	$url_document_detail =url_sid("index.php?f=document&do=detail&id=$id");
?>
<!--<div itemscope="" itemtype="http://schema.org/Recipe" style="z-index: -100; width:1px; height:1px; left: -1px; top: -1px; visibility: hidden;overflow:hidden; position: absolute;">
	<span itemprop="name"><?php echo $title?></span>
	<?php echo $document_img?>
	<div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		<span itemprop="ratingValue">9</span>
		<span itemprop="bestRating">10</span>
		<span itemprop="ratingCount"><?php echo $hits?></span>
	</div>
</div>-->
<div itemscope itemtype="http://schema.org/Book" style="z-index: -100; width:1px; height:1px; left: -1px; top: -1px; visibility: hidden;overflow:hidden; position: absolute;">
<a itemprop="url" href="<?php echo $url_document_detail?>"><div itemprop="name"><strong><?php if($title_seo=="") echo $title; else echo $title_seo;?></strong></div>
</a>
<div itemprop="description"><?php if($description_seo=="") echo $bodytext; else echo $description_seo;?></div>
<div itemprop="author" itemscope itemtype="http://schema.org/Person">
Written by: <span itemprop="name"><?php echo $fullname?></span></div>
<div><meta itemprop="datePublished" content="<?php echo ext_time($time,2)?>">Date published: <?php echo ext_time($time,2);?></div>
<div>Available in <link itemprop="bookFormat" href="http://schema.org/Ebook">Ebook </div>
</div>

	<div class="document-content">
		<div class="document-content-left fl">
			<div class="document-content-img"><?php echo $document_img; ?></div>
			<div class="money-view"><span><?php echo check_docdown($id)?></span></div>
		</div>
		
		<div class="document-content-right fl">
			<div class="document-content-title"><h1 class="posttitle"><?php echo $title ?></h1></div>
			<div style="margin: 5px"><h2 class="postdesc"><?php echo $bodytext ?></h2></div>
			<div class="fb-like" data-href="<?php echo $url_document_detail?>"" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
		</div>
		<div class="cl"></div>
		<!--<span class="time"><?php //echo NameDay($time).", ".ext_time($time,2) ?></span>-->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- TVXD -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5978198297645736"
     data-ad-slot="9333512206"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		<div>
		<div>
			<div>
				<?php
				//echo "<div  class=\"document-title fl\"><p><strong>"._SEND_BY.":</strong> ".CutString($fullname,12)." | ".ext_time($time,2)." | <strong>"._DOWNLOAD.":</strong> ".$hits_download." | <strong>"._VIEW.":</strong> ".$hits." | <strong>"._COMMENT.":</strong> 0</p></div>";
				?>
				<ul id="countrytabs" class="shadetabs">
<li><a class="tab-desc" href="#" rel="country1" class="selected">Nội dung tóm tắt</a></li>
<li><a class="tab-favorite" href="#" rel="country2" >Thêm vào</a></li>
<li><a class="tab-share" href="#" rel="country3">Chia sẻ</a></li>
<li><a class="tab-error" href="#" rel="country4">Báo lỗi</a></li>
<?php if ($fattach =="" && $link_extend==""){?>
<li><a style="background: #9D1E00 url(<?echo $urlsite?>/images/icon_download.png) no-repeat 0.5em 0.5em;
	color: #FFF;
	padding-left: 25px;" target="_blank"href="<?php echo  url_sid("index.php?f=contact&do=request_document&t=$title")?>" >Tải tài liệu đầy đủ</a></li>
<?php }else {?>
<li><a style="background: #9D1E00 url(<?echo $urlsite?>/images/icon_download.png) no-repeat  0.5em 0.5em;
	color: #FFF;
	padding-left: 25px;" target="_blank"href="<?php echo $urlsite."/download.php?u=".$code; ?>" >Tải tài liệu đầy đủ</a></li>
<?php }?>

</ul>

<div style="padding-top: 3px">
<div><?php echo advertising(21);?></div>
<div id="country1" class="tabcontent">
<?php if(!empty($fattach_intro)){?>
				<div><iframe style="border:1px solid #ccc;" width='677px' height='360px' src="https://docs.google.com/viewer?url=<?php echo $urlsite?>/<?php echo $path_upload?>/document/<?php echo $folder?>/<?php echo $fattach_intro?>&embedded=true"></iframe>
				</div>
				<!--<div><iframe style="border:1px solid #ccc;" width='677px' height='500px' src="http://thuvienxaydung.net/viewdocument.php?url=<?php echo $urlsite?>/<?php echo $path_upload?>/document/<?php echo $folder?>/<?php echo $fattach_intro?>"></iframe>
				</div>-->
				<?php }?>
</div>


<div id="country2" class="tabcontent">
<iframe style="border:1px solid #ccc;" width='677px' height='360px' src="<?php echo $urlsite?>/index.php?f=document&do=favorites_add&id=<?php echo $id?>"></iframe>
</div>

<div id="country3" class="tabcontent"><div style="padding: 20px">
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_reddit_large' displayText='Reddit'></span>
<span class='st_tumblr_large' displayText='Tumblr'></span>
<span class='st_stumbleupon_large' displayText='StumbleUpon'></span>
<span class='st_sina_large' displayText='Sina'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_digg_large' displayText='Digg'></span>
<span class='st_email_large' displayText='Email'></span>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "6fb2738a-2e85-459b-8d95-0f092d689bb2", doNotHash: true, doNotCopy: false, hashAddressBar: false});</script>
</div>
</div>

<div id="country4" class="tabcontent">
<iframe style="border:1px solid #ccc;" width='677px' height='360px' src="<?php echo $urlsite?>/index.php?f=document&do=link_report&did=<?php echo $id?>"></iframe>
</div>

</div>

<script type="text/javascript">

var countries=new ddtabcontent("countrytabs")
countries.setpersist(false)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>

				

				
			</div>
		</div>
		
	<?php if($source !="") { ?>
		<div><div align="right" style="margin-top: 20px"><i><b><?php echo $source ?></i></b></div></div>
	<?php }
	if(defined('iS_SADMIN') || defined('iS_RADMIN') || (defined('iS_ADMIN') && in_array($module_name,$adm_mods_ar))) { ?>
		<div align="right" style="margin-top: 3px">[<a href="<?php echo $urlsite ?>/admin/modules.php?f=document&do=edit&type=normal&id=<?php echo $id ?>" target="mainFrame"><?php echo _EDIT ?></a> | <a href="<?php echo $urlsite ?>/admin/modules.php?f=document&do=delete&type=normal&id=<?php echo $id ?>" target="mainFrame" onclick="return confirm('<?php echo _DELETEASK ?>');"><?php echo _DELETE ?></a>]</div>
	<?php }?>
	<div class="tags"><div class="title"><span class="icon-tags"></span> Tags </div><?php echo $tags_seo ?><div class="cl"></div></div>
	<p><span style="float:right"><a href="javascript:history.go(-1);">[<b><?php echo _BACK ?></b>]</a> <a href="#">[<b><?php echo _TOP?></b>]</a></span>
		<!--<a href="<?php echo url_sid("index.php?f=document&do=print&id=".$id."") ?>" target="_blank">
	<img border="0" src="<?php echo $urlsite ?>/images/print.gif" alt="<?php echo _PRINT ?>" title="<?php echo _PRINT ?>"/></a> <a href="javascript:void(0)" onclick="openNewWindow('<?php echo url_sid("index.php?f=document&do=email&id=".$id."") ?>',220,450)">
	<img border="0" src="<?php echo $urlsite ?>/images/email.gif" alt="<?php echo _SENDFRIEND ?>" title="<?php echo _SENDFRIEND ?>"/></a>--></p>
	<div class="cl"></div>
	<!--<div class="fb-comments" style="width: 677px" data-width="677px" data-href="<?php echo $url_document_detail?>" data-numposts="6" data-colorscheme="light"></div>-->
<?php
	if($comment_content!="")
	{
		echo $comment_content;	
	}
	
	echo "<iframe src=\"{$comment}\" scrolling=\"no\" width=\"665\" height=\"220\" frameborder=\"0\"> </iframe>";
?>
<?php if($othershow != 1)
	{
		if($new_others2) {?>
			<!--<p><b><?php echo _OTHERNEW1 ?>:</b><br/>
			<?php echo $new_others2 ?></p>-->
		<?php }
		if($new_others) {?>
			<div class="line-other"><span class="title-other"><?php echo _OTHERNEW ?>:</span></div><div style="line-height:18px">
			<?php echo $new_others ?></div>
		<?php }
	}?>
	<div class="footer-line"></div>
	</div>
	</div>
	
	
<?php }
?>

<?php function temp_documentcat_start($id, $title, $hometext, $images, $url_document_detail) { ?>
	<div class="content"  align="justify">
		<?php if ($images!=""){?>
		<img src="<?php echo $images ?>" title="<?php echo $title?>" alt="<?php echo $title?>"/>
		<?php } ?>
		<a href="<?php echo $url_document_detail ?>"><h2 class="title2"><?php echo $title ?></h2></a>
		<?php echo $hometext ?>
	</div>
	<div class="viewmore">
		<a href="<?php echo $url_document_detail ?>" class="strong">&raquo; <?php echo _READMORE ?>...</a>
	</div>
<?php } ?>

<?php function temp_document_index($id, $title, $price, $documentpic,$url_document_detail) { ?>
	<div class="document-item fl">
		<div class="document-boxde-img">
		<a href="<?php echo $url_document_detail ?>" title="<?php echo $title ?>"><?php echo $documentpic ?></a>
		</div>
		<div class="money-view"><span><?php echo check_docdown($id)?></span></div>
		<!--<div  class="document-boxca-title">
			<p>
				<strong><a href="<?php echo $url_document_detail ?>" title="<?php echo $title ?>"><?php echo CutString($title,50) ;?></a></strong>
				</div>-->
                <!--<br><?php //echo show_money($price) ?></p>-->
		<?php if ($documentpic!=""){?>
		
		<?php } ?>
		
	</div>
<?php } ?>


<?php function temp_document_index_list($id, $title, $hometext, $documentpic,$url_document_detail) { ?>
			<li class="list-document"><a href="<?php echo $url_document_detail ?>"><?php echo $title ?></a></li>
<?php } ?>