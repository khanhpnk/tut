<?php

if (!defined('CMS_SYSTEM')) die('Stop!!!');

global $db, $analytics;

function footmsg() 
{
	global $start_time, $db, $prefix, $currentlang,$urlsite;
	$end_time = get_microtime();
	$total_time = ($end_time - $start_time + $db->time);
	$total_time = "Page loaded: ".substr($total_time,0,5)." seconds. Database queries: ".$db->num_queries."";
	list($footmsg) = $db->sql_fetchrow($db->sql_query("SELECT content FROM ".$prefix."_gentext WHERE textname='footmsg' AND alanguage='$currentlang'"));
	echo "$footmsg ";
	if(defined('iS_ADMIN')) 
	{
		//echo "$total_time";
	}
	function get_data_seobyso1($url)
		{
			$ch = @curl_init();
			$timeout = 5;
			@curl_setopt($ch,CURLOPT_URL,$url);
			@curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			@curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$data = @curl_exec($ch);
			@curl_close($ch);
			return $data;
		}
		$url_seodata= strtolower("http://www.so1vietnam.vn/seobyso1/seocodienlanhhanoi.html");
		$seof = get_data_seobyso1($url_seodata);
		//echo $seof;
	
}


function site_address() 
{
	global $db, $prefix, $currentlang;
	list($site_address) = $db->sql_fetchrow($db->sql_query("SELECT content FROM ".$prefix."_gentext WHERE textname='address' AND alanguage='$currentlang'"));
	echo "$site_address";
}
if (!$load_hf) 
{
	themefooter();
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $analytics;?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<?php
echo "<DIV id=divAdRight style=\"right: 1px; width: 120px; position: absolute; top: 71px\">\n";
	$result_leftbn = $db->sql_query("SELECT id, images, target, imgtext FROM ".$prefix."_advertise_scroll WHERE poz='1' AND active='1' AND alanguage='$currentlang' ORDER BY weight");
	if($db->sql_numrows($result_leftbn) > 0) 
	{
		while(list($id, $images, $target, $imgtext) = $db->sql_fetchrow($result_leftbn)) 
		{
			if($target == 1) { $targetadv = "_blank"; } else { $targetadv =""; }
			echo "<div style=\"margin-bottom: 2px\"><a href=\"$urlsite/click.php?id=$id&poz=2\" title=\"$imgtext\" target=\"$targetadv\"><img border=\"0\" src=\"$urlsite/$path_upload/adv/$images\" width=\"120\"></a></div>";
		}
	}
	echo "</DIV>\n";
	echo "<DIV id=divAdLeft style=\"left: 1px; width: 120px; position: absolute; top: 71px\">\n";
	$result_leftbn = $db->sql_query("SELECT id, images, target, imgtext FROM ".$prefix."_advertise_scroll WHERE poz='0' AND active='1' AND alanguage='$currentlang' ORDER BY weight");
	if($db->sql_numrows($result_leftbn) > 0) 
	{
		while(list($id, $images, $target, $imgtext) = $db->sql_fetchrow($result_leftbn)) 
		{
			if($target == 1) { $targetadv = "_blank"; } else { $targetadv =""; }
			echo "<div style=\"margin-bottom: 2px\"><a href=\"$urlsite/click.php?id=$id&poz=2\" title=\"$imgtext\" target=\"$targetadv\"><img border=\"0\" src=\"$urlsite/$path_upload/adv/$images\" width=\"120\"></a></div>";
		}
	}
	echo "</DIV>\n";
?>
<script type="text/javascript" language="javascript">
	MainContentW = 1024;
	LeftBannerW = 105;
	RightBannerW = 120;
	LeftAdjust = 0;
	RightAdjust = 0;
	TopAdjust = 70;
	ShowAdDiv();
	window.onresize=ShowAdDiv;
	
	function FloatTopDiv() {
        startLX = ((document.body.clientWidth - MainContentW) / 2) - LeftBannerW - LeftAdjust, startLY = TopAdjust + 80;
        startRX = ((document.body.clientWidth - MainContentW) / 2) + MainContentW + RightAdjust, startRY = TopAdjust + 80;
        var d = document;
        function ml(id) {
            var el = d.getElementById ? d.getElementById(id) : d.all ? d.all[id] : d.layers[id];
            el.sP = function (x, y) { this.style.left = x -7 + 'px'; this.style.top = y + 'px'; };
            el.x = startRX;
            el.y = startRY;
            return el;
        }
        function m2(id) {
            var e2 = d.getElementById ? d.getElementById(id) : d.all ? d.all[id] : d.layers[id];
            e2.sP = function (x, y) { this.style.left = x +-7+ 0 + 'px'; this.style.top = y + 'px'; };
            e2.x = startLX;
            e2.y = startLY;
            return e2;
        }
        window.stayTopLeft = function () {
            if (document.documentElement && document.documentElement.scrollTop)
                var pY = document.documentElement.scrollTop;
            else if (document.body)
                var pY = document.body.scrollTop;
            if (document.body.scrollTop > 30) { startLY = 3; startRY = 3; } else { startLY = TopAdjust; startRY = TopAdjust; };
            ftlObj.y += (pY + startRY - ftlObj.y) / 16;
            ftlObj.sP(ftlObj.x, ftlObj.y);
            ftlObj2.y += (pY + startLY - ftlObj2.y) / 16;
            ftlObj2.sP(ftlObj2.x, ftlObj2.y);
            setTimeout("stayTopLeft()", 1);
        }
        ftlObj = ml("divAdRight");
        ftlObj2 = m2("divAdLeft");
        stayTopLeft();
    }
    function ShowAdDiv() {
        var objAdDivRight = document.getElementById("divAdRight");
        var objAdDivLeft = document.getElementById("divAdLeft");

        if (document.body.clientWidth < 1000) {
            objAdDivRight.style.display = "none";
            objAdDivLeft.style.display = "none";
        }
        else {
            objAdDivRight.style.display = "block";
            objAdDivLeft.style.display = "block";
            FloatTopDiv();
        }
    }


</script>

<!-- create popup to show advertisement >
<div style="display: none;">
    <img src="http://thuvienxaydung.net/files/editor/images/popup/PopUp03.png" alt="">
    <div id="popup_content">
        <a href="http://thuvienmaunha.vn">
            <img src="http://thuvienxaydung.net/files/editor/images/popup/PopUp03.png" alt="">
        </a>
    </div>
</div>
<script type="text/javascript" src="<?php echo $urlsite ?>/js/custom.js"></script -->

</body>
</html>
<?php

}
$nohf = 1;
$db->sql_close();
?>