<?php
if (!defined('CMS_SYSTEM')) die();

$id = intval($_GET['id']);
$result = $db->sql_query("SELECT images FROM {$prefix}_news WHERE id=$id AND alanguage='$currentlang'");
if(empty($id) || $db->sql_numrows($result) != 1) die();

require("templates/$Default_Temp/index.php");

$err_mail1 = $err_mail2 = "";
$sdemail = $rsemail = $sdname = "";

if( isset($_POST['subup']) && $_POST['subup'] == 1) {
	while (list($key, $val) = each($_REQUEST)) {
		$$key = stripslashes(resString(trim($val)));
	}

	if(!is_email($sdemail)) {
		$err_mail1 ="<font color=\"red\">"._ERROR1."</font><br>";
		$err = 1;
	}

	if(!is_email($rsemail)) {
		$err_mail2 ="<font color=\"red\">"._ERROR2."</font><br>";
		$err = 1;
	}

	if(!$err) {
		$mess  = "";
		$mess .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
		$mess .= "<head>";
		$mess .= "<meta http-equiv=\"Content-Language\" content=\"en-us\">";
		$mess .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset="._CHARSET."\">";
		$mess .= "<title>$sitename</title>";
		$mess .= "<link rel=\"StyleSheet\" href=\"$siteurl/css/".$Default_Temp.".css\" type=\"text/css\">";
		$mess .= "</head>";
		$mess .= "<table border=\"0\" width=\"100%\" cellpadding=\"5\" style=\"border-collapse: collapse\">";
		$mess .= "	<tr>";
		$mess .= "		<td>"._HELLO.",<br>";
		if($sdname !="") {
			$mess .="<b>$sdname</b> "._SENDFR.":";
		}else{
			$mess .=""._SENDFR1.":";
		}
		$mess .="<br>"._SENDFR2."";
		$mess .="<br><a href=\"$siteurl/".url_sid("".$module_name.".php?do=detail&id=$id")."\"><font color=\"red\">$siteurl/".url_sid("".$module_name.".php?do=detail&id=$id")."</font></a>";
		$mess .="<br>"._SENDFR3."";
		$mess .= "</td>";
		$mess .= "	</tr>";
		$mess .= "</table>";
		$mess .= "<body>";
		$mess .= "</body></html>";

		$subject = ""._INTERESTING." $sitename";

		sendmail($subject, $rsemail, $sdemail, $mess);

		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
		echo "<head>";
		echo "<meta http-equiv=\"Content-Language\" content=\"en-us\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset="._CHARSET."\">";
		echo "<title>$sitename - "._SENDFRIEND."</title>";
		echo "<link rel=\"StyleSheet\" href=\"css/".$Default_Temp.".css\" type=\"text/css\">";
		echo "</head>";
		echo "<body>";
		echo "<table align=\"center\" border=\"0\" cellpadding=\"0\" style=\"border-collapse: collapse\">";
		echo "	<tr>";
		echo "		<td align=\"center\"><br><br><b>"._SENT."</b><br><br><input class=\"input1\" type=\"button\" onclick=\"window.close()\" value=\""._CLOSEWIN."\"></td></tr></table></body></html>";
		exit;
	}

}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en-us"/>
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo _CHARSET?>""/>
<title><?php echo $title." - "._SENDFRIEND?></title>
<meta name="keywords" content="<?php echo $title?>" />
<meta name="description" content="<?php echo $hometext?>" />
<meta name="robots" content="noindex, nofollow" />
<?php
echo "<script Language=\"javascript\">";
echo "	function check(f) {";
echo "		if(!isEmail(f.sdemail.value)) {";
echo "			alert('"._ERROR1."');";
echo "			f.sdemail.focus();";
echo "			return false;";
echo "		}	";
echo "		";
echo "		if(!isEmail(f.rsemail.value)) {";
echo "			alert('"._ERROR2."');";
echo "			f.rsemail.focus();";
echo "			return false;";
echo "		}	";
echo "		";
echo "		f.submit.disabled = true;";
echo "		return true;";
echo "	}	";
echo "</script>	";
?>
</head>
<?php
echo "";
echo "<body>";
OpenBox("<b>$sitename - "._SENDNEWSTOFR."</b>");
echo "<form action=\"".url_sid("index.php?f=$module_name&do=$do&id=$id")."\" method=\"POST\" onsubmit=\"return check(this)\"><table border=\"0\" width=\"100%\" cellpadding=\"3\" style=\"border-collapse: collapse\">";
echo "	<tr>";
echo "		<td align=\"right\">"._YOURNAME.":</td>";
echo "		<td><input type=\"text\" name=\"sdname\" size=\"30\" value=\"$sdname\"></td>";
echo "	</tr>";
echo "	<tr>";
echo "		<td align=\"right\">"._YOUREMAIL.":</td>";
echo "		<td>$err_mail1<input type=\"text\" name=\"sdemail\" size=\"30\" value=\"$sdemail\"></td>";
echo "	</tr>";
echo "	<tr>";
echo "		<td align=\"right\">"._RSEMAIL.":</td>";
echo "		<td>$err_mail2<input type=\"text\" name=\"rsemail\" size=\"30\" value=\"$rsemail\"></td>";
echo "	</tr>";
echo "	<tr>";
echo "		<td>&nbsp;</td>";
echo "<input type=\"hidden\" name=\"subup\" value=\"1\">";
echo "		<td><input type=\"submit\" name=\"submit\" value=\""._SEND."\"> <input  type=\"button\" onclick=\"window.close()\" value=\""._CLOSEWIN."\"></form></td>";
echo "	</tr>";
echo "</table>";
CloseBox();
echo "</body></html>";
?>