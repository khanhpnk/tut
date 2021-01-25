<?php
include("class/Crawler.php");
echo '<'.'?'.'xml version="1.0" encoding="UTF-8"'.'?'.'>';
$q = isset($_POST["q"]) ? $_POST["q"] : "";
$htmlpage='';
$rowpdf=20;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
    <title>Download free document in issuu</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="download free" />
    <meta name="author" content="vinhquangvip" />
    <meta name="keywords" content="issuu" />
</head>

<body>
<div class="pagemain">
    đang tải dữ liệu...<br>
    <?

    $html_begin	=	'#(.*)<div id="panResult" style="width:100%;">#is';
    $html_end	= 	'#</div>(.*)#is';
    $begin	=	'#(.*)<span id="txtTenPT" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
    $end	= 	'#</span></TD>(.*)#is';
    $beginpage	=	'#(.*)<span id="ctl02__lblDaiLy">#is';
    $endpage	= 	'#</span>(.*)#is';
    $beginWidth		=	'#(.*)<div class="col-md-16 col-sm-24 col-xs-24 content-infomation">#is';
    $endWidth		= 	'#<div class="col-md-8 col-sm-24 col-xs-24 related_products">(.*)#is';
    $beginHeight	=	'#(.*)<span itemprop="price" content="(.*)" class="price">#is';
    $endHeight		= 	'#</span>(.*)#is';
    $newscrawler = new Crawler("../files/news","jpg,bmp,jpeg,png",99999999999);
    $txtKhaNangChinh_Begin = '#(.*)<span id="txtKhaNangChinh" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
    $txtKhaNangChinh_End = '#</span>(.*)#is';
    $lblSoDKHC_Begin = '#(.*)<span id="txtSoDKHC" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
    $lblSoDKHC_End = '#</span>(.*)#is';
    $txtSoDK_Begin = '#(.*)<span id="txtSoDK" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
    $txtSoDK_End = '#</span>(.*)#is';
    //if($_GET['sub']==1){
    //   $madk= $_GET['matau'];
    // $mavung = $_GET['mavung'];
    //if($madk==""){die('chọn mã đăng kiểm');}
    //if($mavung==""){die('chọn mã vùng');}
    echo "<table style='border: 1px solid chocolate;' border='1' cellpadding='1' cellspacing='1'>";
    echo "<tr><td>id</td><td>Tên phương tiện</td><td>trọng tải</td><td>Số ĐKHC</td><td>số đăng kiểm</td><td>chủ phương tiện</td><td>địa chỉ</td>";

    for ($i=1;$i<7000;++$i)
    {
        if(strlen($i)<5){
            $num=5-strlen($i);
            $a="";
            for ($j=0;$j<$num;++$j){
                $a.= "0";
            }
            $i=$a.$i;
        }
        $html =	$newscrawler->runBrowser("http://www.vr.org.vn/tracuuts/TTinGCN.aspx?so_dk=".$_GET['mv']."-".$i);
        $html = preg_replace($html_begin,'',$html);// remove doan tren
        $html = preg_replace($html_end,'',$html);// Remove doan duoi

        $txtKhaNangChinh = $html;
        $txtKhaNangChinh = preg_replace($txtKhaNangChinh_Begin,'',$txtKhaNangChinh);// remove doan tren
        $txtKhaNangChinh = preg_replace($txtKhaNangChinh_End,'',$txtKhaNangChinh);// Remove doan duoi
        $txtKhaNangChinh = trim($txtKhaNangChinh);
        $txtCongDung = $html;
        $txtCongDung_Begin = '#(.*)<span id="txtCongDung" style="font-family:tahoma;font-size:Smaller;font-weight:bold;">#is';
        $txtCongDung_End = '#</span>(.*)#is';
        $txtCongDung = preg_replace($txtCongDung_Begin,'',$txtCongDung);// remove doan tren
        $txtCongDung = preg_replace($txtCongDung_End,'',$txtCongDung);// Remove doan duoi
        $txtCongDung = trim($txtCongDung);
        if($txtCongDung!="Chở hàng khô")
        {
            //echo "";
        }
        else
        {
            //echo $i."<br>";\

            echo "<tr>";
            echo "<td>$i</td>";
            $html0 = $html;
            $html0 = preg_replace($begin,'',$html0);// remove doan tren
            $html0 = preg_replace($end,'',$html0);// Remove doan duoi
            echo "<td>".$html0."</td>";
            $txtKhaNangChinh = $html;
            $txtKhaNangChinh = preg_replace($txtKhaNangChinh_Begin,'',$txtKhaNangChinh);// remove doan tren
            $txtKhaNangChinh = preg_replace($txtKhaNangChinh_End,'',$txtKhaNangChinh);// Remove doan duoi
            echo "<td>".$txtKhaNangChinh."</td>";
            $lblSoDKHC = $html;
            $lblSoDKHC = preg_replace($lblSoDKHC_Begin,'',$lblSoDKHC);// remove doan tren
            $lblSoDKHC = preg_replace($lblSoDKHC_End,'',$lblSoDKHC);// Remove doan duoi
            echo "<td>".$lblSoDKHC."</td>";
            $txtSoDK = $html;
            $txtSoDK = preg_replace($txtSoDK_Begin,'',$txtSoDK);// remove doan tren
            $txtSoDK = preg_replace($lblSoDKHC_End,'',$txtSoDK);// Remove doan duoi
            echo "<td>".$txtSoDK."</td>";
            $txtChuPT = $html;
            $txtChuPT_Begin = '#(.*)<span id="txtChuPT" style="font-family:tahoma;font-size:Smaller;font-weight:bold;">#is';
            $txtSoDK_End = '#</span>(.*)#is';
            $txtChuPT = preg_replace($txtChuPT_Begin,'',$txtChuPT);// remove doan tren
            $txtChuPT = preg_replace($txtSoDK_End,'',$txtChuPT);// Remove doan duoi
            echo "<td>".$txtChuPT."</td>";
            $txtDiaChi = $html;
            $txtDiaChi_Begin = '#(.*)<span id="txtDiaChi" style="font-family:tahoma;font-size:Smaller;font-weight:bold;">#is';
            $txtSoDK_End = '#</span>(.*)#is';
            $txtDiaChi = preg_replace($txtDiaChi_Begin,'',$txtDiaChi);// remove doan tren
            $txtDiaChi = preg_replace($txtSoDK_End,'',$txtDiaChi);// Remove doan duoi
            echo "<td>".$txtDiaChi."</td>";
            $txtNam_NoiDongHoanCai = $html;
            $txtNam_NoiDongHoanCai_Begin = '#(.*)<span id="txtNam_NoiDongHoanCai" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
            $txtSoDK_End = '#</span>(.*)#is';
            $txtNam_NoiDongHoanCai = preg_replace($txtNam_NoiDongHoanCai_Begin,'',$txtNam_NoiDongHoanCai);// remove doan tren
            $txtNam_NoiDongHoanCai = preg_replace($txtSoDK_End,'',$txtNam_NoiDongHoanCai);// Remove doan duoi
            echo "<td>".$txtNam_NoiDongHoanCai."</td>";
            $txtVungHoatDong = $html;
            $txtVungHoatDong_Begin = '#(.*)<span id="txtVungHoatDong" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
            $txtSoDK_End = '#</span>(.*)#is';
            $txtVungHoatDong = preg_replace($txtVungHoatDong_Begin,'',$txtVungHoatDong);// remove doan tren
            $txtVungHoatDong = preg_replace($txtSoDK_End,'',$txtVungHoatDong);// Remove doan duoi
            echo "<td>".$txtVungHoatDong."</td>";
            $txtKhaNangPhu = $html;
            $txtKhaNangPhu_Begin = '#(.*)<span id="txtKhaNangPhu" style="font-family:tahoma;font-size:Smaller;font-weight:bold;Z-INDEX: 0">#is';
            $txtSoDK_End = '#</span>(.*)#is';
            $txtKhaNangPhu = preg_replace($txtKhaNangPhu_Begin,'',$txtKhaNangPhu);// remove doan tren
            $txtKhaNangPhu = preg_replace($txtSoDK_End,'',$txtKhaNangPhu);// Remove doan duoi
            echo "<td>".$txtKhaNangPhu."</td>";
            $txtCongDung = $html;
            $txtCongDung_Begin = '#(.*)<span id="txtCongDung" style="font-family:tahoma;font-size:Smaller;font-weight:bold;">#is';
            $txtCongDung_End = '#</span>(.*)#is';
            $txtCongDung = preg_replace($txtCongDung_Begin,'',$txtCongDung);// remove doan tren
            $txtCongDung = preg_replace($txtCongDung_End,'',$txtCongDung);// Remove doan duoi
            echo "<td>".$txtCongDung."</td>";
            // current time
            //$htmlk = $html;
            //$htmlk = preg_replace($beginpage,'',$htmlk);// remove doan tren
            //$htmlk = preg_replace($endpage,'',$htmlk);// Remove doan duoi
            //echo "<td>đại lý:".$htmlk."</td>";
            echo "</tr>";
            flush();            //flush buffer data to browser
            ob_flush();         //flush buffer data to browser
            sleep(1);
        }

    }
    echo "</table>";
    //$html =	$newscrawler->runBrowser($q);
    //$html = preg_replace($begin,'',$html);// remove doan tren
    //$html = preg_replace($end,'',$html);// Remove doan duoi

    //$htmlHeight = $newscrawler->runBrowser($q);
    //$htmlHeight = preg_replace($beginHeight,'',$htmlHeight);// remove doan tren
    //$htmlHeight = preg_replace($endHeight,'',$htmlHeight);// Remove doan duoi
    ////echo "Giá:".$htmlHeight."<br>";
    //$htmlpage =	$newscrawler->runBrowser($q);
    //$htmlpage = preg_replace($beginpage,'',$htmlpage);// remove doan tren
    //$htmlpage = preg_replace($endpage,'',$htmlpage);// Remove doan duoi
    ////echo "ảnh:".$htmlpage."<br><img src=\"".$htmlpage."\">";
    //$htmlWidth = $newscrawler->runBrowser($q);
    //$htmlWidth = preg_replace($beginWidth,'',$htmlWidth);// remove doan tren
    //$htmlWidth = preg_replace($endWidth,'',$htmlWidth);// Remove doan duoi
    //echo $htmlWidth."<br>";
    ////echo $html."<br>";
    //$htmlHeight = $newscrawler->runBrowser($q);
    //$htmlHeight = preg_replace($beginHeight,'',$htmlHeight);// remove doan tren
    //$htmlHeight = preg_replace($endHeight,'',$htmlHeight);// Remove doan duoi
    //if($htmlpage!=''){
    //echo "gfgfgffdfdfdfdgf";
    // }

    ?>

</div>
<div>
    <br>
    <div class="" style="text-align: center; padding: 40px">Copyright 2015 Vinhquangvip</div>
</div>
</body>
</html>
