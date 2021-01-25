<?php
if(!defined('CMS_ADMIN')) die("Illegal File Access");

$err_mail = $title = $err_text = $ntypetext  = $err_html = $ntypehtml = $err_title =$messageHTML="";
if(isset($_POST['subup']) && $_POST['subup'] == 1) {
	$title = nospatags($_POST['title']);
	$ntypetext = nospatags($_POST['ntypetext']);
	$ntypehtml = trim($_POST['ntypehtml']);
	$to =  nospatags($_POST['to']);
	$from =  $_POST['from'];
	
	$err = 0;

	if (empty($title)) {
		$err_title = "<font color=\"red\">"._ERROR3."</font><br/>";
		$err = 1;
	}

	if (empty($ntypetext)) {
		$err_text = "<font color=\"red\">"._ERROR4."</font><br/>";
		$err = 1;
	}

	if(empty($ntypehtml)) {
		$err_html = "<font color=\"red\">"._ERROR5."</font><br/>";
		$err = 1;
	}

	if(!$err) {
		//Gửi cho thành viên và người đăng ký nhận email
		if($from==0){
			//$result_text = $db->sql_query("SELECT email FROM ".$prefix."_newsletter WHERE status=2 AND activateCode IS NULL LIMIT $bcc_per_mail");	
		}
		elseif($from==1){
			//Gửi người đăng ký nhận email
			$result_text = $db->sql_query("SELECT email FROM ".$prefix."_newsletter WHERE status=2 AND activateCode IS NULL LIMIT $bcc_per_mail");	
		}
		elseif($from==2){
			//Gửi cho thành viên
			$result_text = $db->sql_query("SELECT email FROM ".$prefix."_user");	
		}
		elseif($from==3){
			//Gửi cho thành viên đã kích hoạt
			$result_text = $db->sql_query("SELECT email FROM ".$prefix."_user WHERE  activationCode iS NULL");
		}
		elseif($from==4){
			//Gửi cho thành viên chưa kích hoạt
			$result_text = $db->sql_query("SELECT email FROM ".$prefix."_user WHERE  activationCode is NOT NULL");
			//die("SELECT email FROM ".$prefix."_user WHERE activationCode is NOT NULL");
		}
		else{
			//Gửi cho thành viên hơn 1 tháng chưa đăng nhập
			//$result_text = $db->sql_query("SELECT email FROM ".$prefix."_user WHERE actives=0");
		}
		$insertQuery = $db->sql_query("INSERT INTO ".$prefix."_newsletter_send (subject, text, html, send) VALUES ('$title', '$ntypetext', '$ntypehtml', '".TIMENOW."')");
		$result_id_send = $db->sql_query("SELECT LAST_INSERT_ID()");
		list($idsend) = $db->sql_fetchrow($result_id_send);
		$rowsCount = $db->sql_numrows($result_text);
		if (($rowsCount > 0) && ($db->sql_affectedrows($insertQuery) > 0)) {
			$mailhead = "X-Mailer: PHP\n"; // mailer
			$mailhead .= "X-Priority: 6\n"; // Urgent message!
			$subject = $title;
			if ($smtp_mail == 1) $m = new Mail($to, $to, $subject, $messageHTML, "SMTP", $smtp_host, $smtp_username, $smtp_password, $smtp_port);
			else $m = new Mail($to, $to, $subject, $messageHTML);
			$mailIdList = array();
			$countemail=0;
			while (list($email) = $db->sql_fetchrow($result_text)) {
				//$unregLink = Common::constructURL($_POST['url'], "?f=newsletter&do=unreg&key=$checkkey&email=$email");
				//$unregLink = str_replace("admin/modules.php",url_sid("index.php?f=newsletter&do=unreg&key=$checkkey&email=$email"));
				$messagePlain = $ntypetext;
				//$messagePlain .= "\n\n"._NEW_UNREG.":\n$unregLink\n--------------------------------------------\n$sitename";
				$messageHTML = $ntypehtml;
				//$messageHTML .= "<br/><br/><a href=\"$unregLink\">"._NEW_UNREG1."</a><hr size=\"1\">$sitename\n";
				//$m->addBCC($email);
				//$mailIdList[] = $id;
				sendmail($subject, $email, $to, $messageHTML);
				$countemail++;
				sleep(10);
				//echo 'Gửi cho '.$email.' thành công!';
			}
				sendmail($subject, 'vinhquangvip@gmail.com', $to, $messageHTML);
			//$m->setPlainBody($messagePlain);
			//$m->send();
			// cap nhat mail da gui
			$db->sql_query("UPDATE {$prefix}_newsletter_send SET count=$countemail WHERE id='$idsend'");
			$query = "UPDATE {$prefix}_newsletter SET newsletterid=CONCAT(newsletterid,',$idsend') WHERE ";
			foreach ($mailIdList as $id) $query .= "id=$id OR ";
			$query = substr($query, 0, strlen($query) - 4);
			$db->sql_query($query);
			if ($rowsCount >= $bcc_per_mail) {
				$handle = @fopen(RPATH."$path_upload/data/lastNewsletterTime_$idsend", "w");
				@fwrite($handle, "{$_POST['url']}\n");
				@fwrite($handle, strval(time()));
				@fclose($handle);
			}
		}
		header("Location: modules.php?f=$adm_modname&do=sent&$countemail");
	}
}

include_once("page_header.php");
ajaxload_content();
echo "<script language=\"javascript\">\n";
echo "	function check(f) {\n";
echo "		if(f.title.value =='') {\n";
echo "			alert('"._ERROR3."');\n";
echo "			f.title.focus();\n";
echo "			return false;\n";
echo "		}\n";
echo "		if(f.ntypetext.value =='') {\n";
echo "			alert('"._ERROR4."');\n";
echo "			f.ntypetext.focus();\n";
echo "			return false;\n";
echo "		}\n";
echo "		fetch_object('ajaxload_container').style.display ='block';\n";
echo "		f.submit.disabled = true;\n";
echo "		return true;	\n";
echo "	}	\n";
echo "</script>	\n";


echo "<form action=\"modules.php?f=$adm_modname&do=$do\" method=\"POST\" onsubmit=\"return check(this)\"><table align=\"center\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"tableborder\">\n";
echo "<tr><td class=\"header\" colspan=\"2\">"._MODTITLE." &raquo; "._CREATEMAIL."</td></tr>";
echo "<tr>\n";
echo "<td width=\"100\" align=\"right\" class=\"row1\"><b>"._TITLE."</b></td>\n";
echo "<td class=\"row2\">$err_title<input type=\"text\" size=\"60\" name=\"title\" value=\"$title\"></td></tr>\n";
echo "<tr>\n";
echo "<tr>\n";
echo "<td width=\"100\" align=\"right\" class=\"row1\"><b>Người gửi</b></td>\n";
echo "<td class=\"row2\"><input type=\"text\" size=\"60\" name=\"to\" value=\"no-reply@thuvienxaydung.net\"></td></tr>\n";
echo "<tr>\n";
echo '<tr><td width="100" align="right" class="row1"><strong>Người nhận</strong></td><td><select id="from" name="from">
	<option value="0">Chọn người nhận email</option>
	<option value="1">Gửi người đăng ký nhận email</option>
	<option value="2">Gửi cho thành viên</option>
	<option value="3">Gửi cho thành viên đã kích hoạt</option>
	<option value="4">Gửi cho thành viên chưa kích hoạt</option>
	</select></td></tr>';
echo "<td align=\"right\" class=\"row1\" valign=\"top\"><b>"._NTYPETEXT."</b></td>\n";
echo "<td class=\"row2\">$err_text<textarea name=\"ntypetext\"  style=\"width:99%\" rows=\"8\">$ntypetext</textarea></td></tr>\n";
echo "<tr>\n";
echo "<td align=\"right\" class=\"row1\" valign=\"top\"><b>"._NTYPEHTML."</b></td>\n";
echo "<td class=\"row2\">$err_html\n";
editor("ntypehtml",$ntypehtml);
echo "</td></tr>\n";
echo "<script>var currentURL=encodeURI(location.href);";
echo "document.write('<input type=\"hidden\" name=\"url\" value=\"' + currentURL + '\">')</script>\n";
echo "<tr><td class=\"row3\">&nbsp;</td><td class=\"row3\"><input type=\"hidden\" name=\"subup\" value=\"1\"><input type=\"submit\" name=\"submit\" value=\""._SENDNLT."\" class=\"button2\"></td></tr>";
echo "</table></form>";

include_once("page_footer.php");
?>