<?php
if (!file_exists("config.php")) exit();
define('CMS_SYSTEM', true);
@require_once("config.php");
require_once(RPATH.DATAFOLD."/config_newsletter.php");
require_once(RPATH."language/$currentlang/newsletter.php");
$load_hf = 0;
$newsletterFileArr = array();
$dir = RPATH."$path_upload/data";
$dh = opendir($dir);
while (($file = readdir($dh)) !== false) {
	if (preg_match('!^lastNewsletterTime_\d+$!D', $file)) {
		$t = file("$dir/$file");
		if ((time() - intval($t[1])) >= $delay_between_send) {
			$newsletterId = explode('_', $file);
			$newsletterId = $newsletterId[1];
			$db->sql_query("SELECT subject, text, html FROM {$prefix}_newsletter_send WHERE id=$newsletterId");
			if ($db->sql_numrows() > 0) list($subject, $ntext, $nhtml) = $db->sql_fetchrow();
			else break;
			$db->sql_query("SELECT id, email, html, checkkey FROM {$prefix}_newsletter WHERE status=2 AND activateCode IS NULL AND newsletterid NOT LIKE '%,$newsletterId' AND newsletterid NOT LIKE '%,$newsletterId,%' LIMIT $bcc_per_mail");
			$rowsCount = $db->sql_numrows();
			if ($rowsCount > 0) {
				$mailhead = "X-Mailer: PHP"; // mailer
				$mailhead .= "X-Priority: 6"; // Urgent message!
				if ($smtp_mail == 1) $m = new Mail($adminmail, $adminmail, $subject, $messageHTML, "SMTP", $smtp_host, $smtp_username, $smtp_password, $smtp_port);
				else $m = new Mail($adminmail, $adminmail, $subject, $messageHTML);
				$mailIdList = array();
				while (list($id, $email, $html, $checkkey) = $db->sql_fetchrow()) {
					$unregLink = Common::constructURL($t[0], "?f=newsletter&do=unreg&checkkey=$checkkey&email=$email");
					$unregLink = str_replace("admin/modules.php",url_sid("index.php?f=newsletter&do=unreg&key=$checkkey&email=$email"));
					$messagePlain = $ntext;
					$messagePlain .= ""._NEW_UNREG.":$unregLink--------------------------------------------$sitename";
					$messageHTML = $nhtml;
					$messageHTML .= "<br/><br/><a href=\"$unregLink\">"._NEW_UNREG1."</a><hr size=\"1\">$sitename";
					$m->addBCC($email);
					$mailIdList[] = $id;
				}
				$m->setPlainBody($messagePlain);
				$m->send();
				$query = "UPDATE {$prefix}_newsletter SET newsletterid=CONCAT(newsletterid,',$newsletterId') WHERE ";
				foreach ($mailIdList as $id) $query .= "id=$id OR ";
				$query = substr($query, 0, strlen($query) - 4);
				$db->sql_query($query);
			}
			if ($rowsCount < $bcc_per_mail) {
				@unlink("$dir/$file");
			} else {
				$handle = @fopen("$dir/$file", "w");
				@fwrite($handle, $t[0]);
				@fwrite($handle, strval(time()));
				@fclose($handle);
			}
		}
	}
}
closedir($dh);
$db->sql_query("SELECT id, catid, title, alanguage, hometext, bodytext, images, imgtext, source, active, imgshow, image_highlight, hits, nstart, timed FROM {$prefix}_news_temp WHERE timed <= NOW()");
if ($db->sql_numrows() > 0) {
	while (list($delayedId, $delayedCatId, $delayedTitle, $delayedALanguage, $delayedHomeText, $delayedBodyText, $delayedImages, $delayedImgText, $delayedSource, $delayedActive, $delayedImgShow, $delayedImageHighlight, $delayedHits, $delayedNStart, $delayedTimed) = $db->sql_fetchrow()) {
		$db->sql_query("INSERT INTO {$prefix}_news (catid, title, alanguage, time, hometext, bodytext, images, imgtext, source, active, imgshow, image_highlight, hits, nstart) VALUES ($delayedCatId, '$delayedTitle', '$delayedALanguage', UNIX_TIMESTAMP('$delayedTimed'), '$delayedHomeText', '$delayedBodyText', '$delayedImages', '$delayedImgText', '$delayedSource', $delayedActive, $delayedImgShow, $delayedImageHighlight, $delayedHits, $delayedNStart)");
		$db->sql_query("DELETE FROM {$prefix}_news_temp WHERE id=$delayedId");
		if ($db->sql_affectedrows() > 0) {
			fixcount_cat();
			if ($delayedNStart == 1) {
				$db->sql_query("SELECT LAST_INSERT_ID()");
				list($lastInsertId) = $db->sql_fetchrow();
				$db->sql_query("UPDATE {$prefix}_news SET nstart=0 WHERE id!=$lastInsertId AND catid=$delayedCatId");
				$db->sql_query("UPDATE {$prefix}_news_cat SET startid=$lastInsertId WHERE catid=$delayedCatId");
			}
		}
	}
}
if(isset($_GET['f']) || isset($_POST['f'])) {
	$home = 0;
	$f = trim(isset($_POST['f']) ? $_POST['f'] : $_GET['f']);
	if(isset($_GET['do']) || isset($_POST['do'])) {
		$do = trim(isset($_POST['do']) ? $_POST['do'] : $_GET['do']);
		$do = ucfirst($do);
	} else {
		$do = "index";
	}
	if (preg_match("![^a-zA-Z0-9_]!", $do)) { info_exit(_FILENOTFOUND." $f/$do"); }

	if(isset($_GET['op']) || isset($_POST['op'])) {
		$op = trim(isset($_POST['op']) ? $_POST['op'] : $_GET['op']);
	} else {
		$op = "";
	}
	if (preg_match("![^a-zA-Z0-9_]!", $op)) { info_exit(_FUNCTIONNOTFOUND); }
} else {
	$f = $Home_Module;
	$home = 1;
	$do = "index";
	$op = "";
}
if (preg_match("![^a-zA-Z0-9_]!", $f)) { info_exit(_FUNCTIONNOTFOUND); }
$resultloadmod = $db->sql_query("SELECT * FROM ".$prefix."_modules WHERE title='".addslashes($f)."' AND alanguage='$currentlang'");
$rowloadmod = $db->sql_fetchrow($resultloadmod);
if(!$rowloadmod) { info_exit(_PROBLEMMOD); }
$page_title = $rowloadmod['custom_title'];
if ($home == 1) { $page_title = ""; }
$module_active = intval($rowloadmod['active']);
$module_view = intval($rowloadmod['view']);
$module_title = $rowloadmod['title'];
$index = intval($rowloadmod['mindex']);
//if($_GET["update"]=="true"){checkok();}
//if (($module_active != 1) AND !defined('iS_ADMIN')) { info_exit(_MODULENOTACTIVE); }
$module_path = "modules/$f/$do.php";
if(file_exists($module_path)) {
	getlangmod($f);
	if (defined('_MODTITLE') && $home == 0) {
		$page_title = "";
	}
	$module_name = $f;
	if(file_exists(DATAFOLD."/config_".$module_name.".php")) {
		require_once(DATAFOLD."/config_".$module_name.".php");
	}
	if(file_exists("templates/".$Default_Temp."/module_".$module_name.".php")) {
		include("templates/".$Default_Temp."/module_".$module_name.".php");
	}
	if(file_exists("modules/".$module_name."/Functions.php")) {
		include("modules/".$module_name."/Functions.php");
	}
	if ($module_view == 0) { include($module_path); }
	elseif ($module_view == 1 && defined('iS_ADMIN')) { include($module_path); }
	elseif ($module_view == 2 && (defined('iS_ADMIN') || defined('iS_CUS'))) { include($module_path); }
	else { info_exit(_MODULENOTACTIVE); }
} else {
	info_exit(_FILENOTFOUND);
}
$_SESSION["firstname"] = "Peterh";
$_SESSION["USER_SESS"] = 'ss';
?>
