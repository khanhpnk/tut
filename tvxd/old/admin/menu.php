<?php
//define('CMS_ADMIN', true);
require_once("../config.php");
require_once("language/".$currentlang."/menu.php");
if(@in_array($listmenus,$file_menu)) {
		$seld =" checked";
	}
	
function show_menu()
{
	global $db, $currentlang, $prefix, $home, $admin_ar;
	$result_menu = $db->sql_query("SELECT mid, title, url FROM {$prefix}_adminmenus WHERE menu_type='admin_menu' AND  parentid='0' AND active='1' Order by weight asc");
	if($db->sql_numrows($result_menu) > 0) 
	{
		$i=1;
		while (list($mid, $title_menu, $url_menu) = $db->sql_fetchrow($result_menu))
		{
			$result_sub = $db->sql_query("SELECT mid, title, url FROM {$prefix}_adminmenus WHERE menu_type='admin_menu' AND parentid=$mid and active=1  order by weight asc");
		if($db->sql_numrows($result_sub) > 0) 
		{
		echo "<li class=\"dropdown\"><a href=\"".url_sid($url_menu)."\" class=\"dropdown-toggle\"  data-toggle=\"dropdown\" title=\"$title_menu\">$title_menu <span class=\"caret\"></span></a>\n";
			echo "<ul class=\"dropdown-menu \">\n";
			while (list($mid_sub, $title_sub, $url_sub) = $db->sql_fetchrow($result_sub)) 
			{
				
				$result_sub2 = $db->sql_query("SELECT mid, title, url FROM {$prefix}_adminmenus WHERE menu_type='admin_menu' AND parentid=$mid_sub and active=1  order by weight asc");
				if($db->sql_numrows($result_sub2) > 0) 
				{
					if($title_sub=="divider")
					{
						echo "<li class=\"divider\"><span></span>\n";	
					}
					else
					{
						echo "<li class=\"dropdown-submenu\"><a title=\"$title_sub\" href=\"".url_sid($url_sub)."\">$title_sub</a>\n";	
					}
					echo "<ul class=\"dropdown-menu menu-component\">\n";
					while (list($mid_sub2, $title_sub2, $url_sub2) = $db->sql_fetchrow($result_sub2)) 
					{
						if($title_sub2=="divider")
						{
							echo "<li class=\"divider\"><span></span>\n";	
						}
						else
						{
							echo "<li><a title=\"$title_sub2\" href=\"".url_sid($url_sub2)."\">$title_sub2</a></li>\n";
						}
						
					}
					echo "</ul>\n";
				}
				else
				{
					if($title_sub=="divider")
					{
						echo "<li class=\"divider\"><span></span>\n";	
					}
					else
					{
						echo "<li><a title=\"$title_sub\" href=\"".url_sid($url_sub)."\">$title_sub</a>\n";	
					}
				}
				echo "</li>\n";
			}
			echo "</ul>\n";
		}
		else
		{
				echo "<li class=\"dropdown\"><a href=\"".url_sid($url_menu)."\" class=\"dropdown-toggle\"  data-toggle=\"dropdown\" title=\"$title_menu\">$title_menu</a>\n";
		}
		$i++;
		echo "</li>\n";
		}
	}
	//echo "</ul>\n";
}

function show_menu_for_user()
{
	global $db, $currentlang, $prefix, $home, $admin_ar;
	//lay tat ca permission cua nguoi dung dang nhap
	$resultchauthor= $db->sql_query("SELECT permission FROM ".$prefix."_admin where adacc='$admin_ar[0]'");
	list($permissionchgroup) = $db->sql_fetchrow($resultchauthor);
	//mang danh sach menu duoc cap quyen truy cap
	//$auth_menusch = @explode("|",$permissionchgroup);
	//lay menu co parentid=0
	$a =0;
	for($l=0;$l <= sizeof($auth_menusch);$l++)
	{
		if (isset($auth_menusch[$l]))
		{
			$resultmenuf= $db->sql_query("SELECT parentid  FROM ".$prefix."_adminmenus where mid=$auth_menusch[$l]");
			list($mparentid) = $db->sql_fetchrow($resultmenuf); 
			//{
				//echo $mparentid."+";
				if(!@in_array($mparentid,$auth_menuf))
					//mang danh sach menu cha
					$auth_menuf[]=$mparentid;
			//}
		}
	}
	//echo "<br>$permissionchgroup";
	//echo count($auth_menuf);
	//
	//
	//show mang menu theo quyen nguoi dung
	//
	$i=0;
	//for($l=0;$l <= sizeof($auth_menuf);$l++) 
	//{
	//	if (isset($auth_menuf[$l]))
	//	{
	$result_menu = $db->sql_query("SELECT m.mid, m.title, m.url FROM {$prefix}_adminmenus AS m,{$prefix}_adminmenus_permission AS p WHERE m.mid=p.menu AND p.admingroup=$permissionchgroup AND m.parentid='0' AND m.active='1' Order by m.weight asc");
	if($db->sql_numrows($result_menu) > 0) 
	{
		$i=1;
		//echo "<ul class=\"sf-menu sf-navbar sf-js-enabled sf-shadow\">\n";
		while (list($mid, $title_menu, $url_menu) = $db->sql_fetchrow($result_menu)){
			$result_sub = $db->sql_query("SELECT m.mid, m.title, m.url FROM {$prefix}_adminmenus AS m,{$prefix}_adminmenus_permission AS p WHERE m.mid=p.menu AND p.admingroup=$permissionchgroup AND m.parentid='$mid' AND m.active='1' Order by m.weight asc");
		if($db->sql_numrows($result_sub) > 0){
				echo "<li class=\"dropdown\"><a href=\"".url_sid($url_menu)."\" class=\"dropdown-toggle\"  data-toggle=\"dropdown\" title=\"$title_menu\">$title_menu <span class=\"caret\"></span></a>\n";
				echo "<ul class=\"dropdown-menu\">\n";
				while (list($mid_sub, $title_sub, $url_sub) = $db->sql_fetchrow($result_sub)){
				$result_sub2 = $db->sql_query("SELECT m.mid, m.title, m.url FROM {$prefix}_adminmenus AS m,{$prefix}_adminmenus_permission AS p WHERE m.mid=p.menu AND p.admingroup=$permissionchgroup AND m.parentid='$mid_sub' AND m.active='1' Order by m.weight asc");
				if($db->sql_numrows($result_sub2) > 0){
						//die($mid_sub);
						if($title_sub=="divider")
						{
							echo "<li class=\"divider\"><span></span>\n";	
						}
						else
						{
							echo "<li class=\"dropdown-submenu\"><a title=\"$title_sub\" href=\"".url_sid($url_sub)."\">$title_sub</a>\n";	
						}
						echo "<ul class=\"dropdown-menu menu-component\">\n";
						while (list($mid_sub2, $title_sub2, $url_sub2) = $db->sql_fetchrow($result_sub2)) 
						{
					
							if($title_sub2=="divider")
							{
								echo "<li class=\"divider\"><span></span>\n";	
							}
							else
							{
								echo "<li><a title=\"$title_sub2\" href=\"".url_sid($url_sub2)."\">$title_sub2</a></li>\n";
							}	
					
							
							
						}
						echo "</ul>\n";
				}
				else
				{
					if($title_sub=="divider")
					{
						echo "<li class=\"divider\"><span></span>\n";	
					}
					else
					{
						echo "<li><a title=\"$title_sub\" href=\"".url_sid($url_sub)."\">$title_sub</a>\n";	
					}
				}
				echo "</li>\n";
			
			}
			echo "</ul>\n";
			
		}
		else
		{
				echo "<li class=\"dropdown\"><a href=\"".url_sid($url_menu)."\" class=\"dropdown-toggle\"  data-toggle=\"dropdown\" title=\"$title_menu\">$title_menu</a>\n";
		}
		$i++;
		echo "</li>\n";
		}
	}
	//}
	//}
	//echo "</ul>\n";
}

if(defined('iS_ADMIN')) 
{

	echo '<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">';
	///echo "<div class=\"div-banner\"><span class=\"version\">"._VERSION_ONECMS." | "._HELLO.": <b><a href=\"modules.php?f=authors&do=change&acc=$admin_ar[0]\" target=\"_top\" class=\"catmenu1\">$admin_ar[0]</a></b> - <a href=\"logout.php\" target=\"_top\" title=\""._LOGOUT."\" onclick=\"return confirm('"._LOGOUTASK."');\" class=\"catmenu1\">"._LOGOUT."</a></span></div>";
	//echo "<div id=\"ddtopmenubar\" class=\"mattblackmenu\">\n";
	//echo "<ul>\n";
	//$resultchuser= $db->sql_query("SELECT * FROM ".$prefix."_adminmenus");
	
	//tra ve mang menu duoc cap quyen truy cap
	echo "<a class=\"admin-logo fl\" href=\"index.php\"><span class=\"icon-acud\">&nbsp;</span></a>";
	echo "<div class=\"nav-collapse\">";
	echo "<ul  id=\"menu\" class=\"nav\">\n";
		//echo "<li class=\"menupop\"><a class=\"menu-item\" href=\"index.php\"><span class=\"menu-logo\">&nbsp;</span></a></li>";
	if(defined('iS_RADMIN')) 
	{
		
		show_menu();
	}
	else
	{
		show_menu_for_user();
	}	
	
	echo "</ul>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "<div class=\"cl\"></div>";
	echo "</nav>";
		echo "<div class=\"div-footer\">";
		echo "<div class=\"cl\"></div>";
	echo "<div class=\"menu-footer fr\">";
	echo "<ul>";
list ($permission) = $db->sql_fetchrow($db->sql_query("SELECT permission FROM ".$prefix."_admin WHERE adacc='$admin_ar[0]'"));
if($permission==2){
	$numsalert = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_link_report WHERE status='0' or status='1'"));
	$numsdoc = $db->sql_numrows($db->sql_query("SELECT id FROM ".$prefix."_document WHERE active='0'"));
	$numscontact = $db->sql_numrows($db->sql_query("SELECT id FROM ".$prefix."_contact WHERE status='0' or status='1'"));
	$numscomdoc = $db->sql_numrows($db->sql_query("SELECT id FROM ".$prefix."_document_comments WHERE status='0'"));
	$numscomnews = $db->sql_numrows($db->sql_query("SELECT id FROM ".$prefix."_comments WHERE status='0'"));
	$totalarlet=$numsalert+$numsdoc+$numscontact+$numscomdoc+$numscomnews;
	echo "<li class=\"dropdown dropup menu-alert fr\"><a href=\"#\" class=\"dropdown-toggle dropup\"  data-toggle=\"dropdown\"><i class=\"fa fa-globe fa-lg\"></i>&nbsp;<span class=\"badge\">".$totalarlet."</span></a>";
	echo "<ul class=\"dropdown-menu\">\n";
	echo "<li><a title=\"Báo lỗi chờ xử lý\" href=\"modules.php?f=document&do=comments\"><span class=\"badge\">".$numscomdoc."</span> Bình luận tài liệu đang chờ duyệt</a></li>\n";
	echo "<li><a title=\"Báo lỗi chờ xử lý\" href=\"modules.php?f=news&do=comments\"><span class=\"badge\">".$numscomnews."</span> Bình luận tin tức đang chờ duyệt</a></li>\n";
	echo "<li><a title=\"Báo lỗi chờ xử lý\" href=\"modules.php?f=document&do=link_report\"><span class=\"badge\">".$numsalert."</span> Báo lỗi chờ xử lý</a></li>\n";
	echo "<li><a title=\"Tài liệu đang chờ duyệt\" href=\"modules.php?f=document\"><span class=\"badge\">".$numsdoc."</span> Tài liệu đang chờ duyệt</a></li>\n";
	echo "<li><a title=\"Liên hệ đang chờ phản hồi\" href=\"modules.php?f=contact\"><span class=\"badge\">".$numscontact."</span> Liên hệ đang chờ phản hồi</a></li>\n";
	echo "</ul>";
	echo "</li>";//
}
	echo "<li class=\"menu-help fl\"><a class=\"fancybox fancybox.iframe\" href=\"help/index.html\" title=\""._HELP."\"><i class=\"fa fa-question-circle fa-lg\"></i>&nbsp;"._HELP."</a></li>";
	echo "<li class=\"menu-viewsite fl\"><a href=\"".url_sid("index.php",1)."\" target=\"_blank\"><i class=\"fa fa-desktop\"></i>&nbsp;"._VIEW_WEBSITE."</a></li>";
	echo "<li class=\"menu-admin fl\"><a class=\"fancybox fancybox.iframe\" href=\"modules.php?f=authors&do=change\" target=\"_top\"><i class=\"fa fa-user\"></i>&nbsp;$admin_ar[0]</a></li>";
		//echo '<li class="menu-logout fl"><a class="dropdown-toggle" href="logout.php" data-toggle="dropdown"><i class="fa fa-power-off"></i>&nbsp;Thoát</a></li>';
		echo "<li class=\"menu-logout fr\"><a target=\"_top\" href=\"logout.php\" onclick=\"return confirm('"._LOGOUTASK."');\"><i class=\"fa fa-power-off\"></i>&nbsp;"._LOGOUT."</a></li>";
	echo "</ul>";
	echo "</div>";
	echo "<div class=\"titlefooter fl\">"._TITLE_FOOTER."</div>";
	echo "<div class=\"cl\"></div>";
	echo "</div>";
	echo "<div class=\"div-content\">\n";
}else{
	//header("Location: login.php");
}
?>

	<script>
		(function($)
		{
			// fix sub nav on scroll
			var $win = $(window)
				, $nav    = $('.subhead')
				, navTop  = $('.subhead').length && $('.subhead').offset().top - 40	, isFixed = 0

			processScroll()

			// hack sad times - holdover until rewrite for 2.1
			$nav.on('click', function()
			{
				if (!isFixed) {
					setTimeout(function()
					{
						$win.scrollTop($win.scrollTop() - 47)
					}, 10)
				}
			})

			$win.on('scroll', processScroll)

			function processScroll()
			{
				var i, scrollTop = $win.scrollTop()
				if (scrollTop >= navTop && !isFixed) {
					isFixed = 1
					$nav.addClass('subhead-fixed')
				} else if (scrollTop <= navTop && isFixed) {
					isFixed = 0
					$nav.removeClass('subhead-fixed')
				}
			}
		})(jQuery);
	</script>


<?php
?>

<div id="abouts" style="width:450px;display: none;">
	<div class="fl"><img border="0" src="images/login/lion.png" align="baseline"></div>
    <div class="fl" style="width:300px">
		<h3><?php echo _TITLE_ABOUT_ONECMS?></h3>
        <p><?php echo _VERSION_ONECMS?><br /><?php echo _CONTENT_ABOUT_ONECMS?></p>
        </div>
        <div class="cl"></div>
	</div>
<?php
//<span class=\"version\">"._VERSION_ONECMS." | 
?>
