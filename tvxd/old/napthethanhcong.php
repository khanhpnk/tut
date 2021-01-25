<?php
if (!file_exists("config.php")) die();
define('CMS_SYSTEM', true);
@require_once("config.php");
include("header.php");


$result_user = $db->sql_query("SELECT id, fullname, money FROM adoosite_user WHERE id =" . $userInfo['id'] . "");
if ($db->sql_numrows($resultpromotion) > 0) {
    list($userid, $userfullname, $usermoney) = $db->sql_fetchrow($result_user);
} else {
    header("Location: " . url_sid("index.php?f=user&do=login") . "");
    exit();
}

include('confignganluong.php');
include('NL_Checkoutv3.php');
$nlcheckout = new NL_CheckOutV3(MERCHANT_ID, MERCHANT_PASS, RECEIVER, URL_API);
$nl_result = $nlcheckout->GetTransactionDetail($_GET['token']);
if ($nl_result) {
    $nl_errorcode = (string)$nl_result->error_code;
    $nl_transaction_status = (string)$nl_result->transaction_status;
    if ($nl_errorcode == '00') {
        if ($nl_transaction_status == '00') {
            $moneynew = (int)$usermoney + (int)$nl_result->total_amount / 1000;
            $db->sql_query("UPDATE adoosite_user SET money=$moneynew WHERE id='" . $userInfo['id'] . "'");
            //cap nhat vao bảng adoosite_napthe
            $query = "INSERT INTO adoosite_napthe (id, userid, error_code,token,order_code,total_amount,payment_method,bank_code,payment_type,transaction_id,time)
                            VALUES (NULL, " . $userInfo['id'] . ", '$nl_result->error_code', '$nl_result->token', '$nl_result->order_code', '$nl_result->total_amount', '$nl_result->payment_method', '$nl_result->bank_code', '$nl_result->payment_type', '$nl_result->transaction_id', " . time() . ")";
            $db->sql_query($query);
        }
    } else {
        echo ' <div class="payment_list">
            <div id="select_payment">
                <form name="NLpayBank" action="#" method="post">
                    <div class="row-fluid customer_info ">
                        <div class="info">
                            <span class="title">'.$nlcheckout->GetErrorMessage($nl_errorcode).'</span>

                        </div>
                    </div>
                </form>
            </div>
        </div>';
        header("Location: index.php?f=napthe&do=create");

    }
}

header("Location: success.php?token=$nl_result->token");

?>

<style>
    .info {
        border: 1px solid #a4d6ed;
        color: #126992;
        font-weight: bold;
        background: #e9f3f8;
        width: 98%;
        margin: 0 auto 10px auto;
        padding: 10px;
        border-radius: 3px 3px 3px 3px;
        float: left;
    }

    .form-group {
        width: 100%;
        float: left;
    }

    .btn-success {
        border-left: 0px;
        border-right: 1px solid #E8EAEB;
        border-bottom: 0px;
        border-top: 0px solid #ffffff;
        border-radius: 0px;
        background: #ce3000;
        padding: 4px 8px 4px 8px;
        cursor: pointer;
        color: #fff;
        margin-bottom: 20px;
    }

    dt {
        float: left;
        width: 200px;
        margin-bottom: 20px;
    }

    ul.bankList {
        clear: both;
        height: 202px;
        width: 636px;
    }

    ul {
        padding: 0px;
        margin: 0px;
    }

    ul.bankList li {
        list-style-position: outside;
        list-style-type: none;
        cursor: pointer;
        float: left;
        margin-right: 0;
        padding: 5px 2px;
        text-align: center;
        width: 90px;
    }

    .list-content li {
        list-style: none outside none;
        margin: 0 0 20px;
    }

    .list-content li .boxContent {
        display: none;
        width: 98%;
        border: 1px solid #cccccc;
        padding: 10px;
    }

    .list-content li.active .boxContent {
        display: block;
    }

    i.VISA, i.MASTE, i.AMREX, i.JCB, i.VCB, i.TCB, i.MB, i.VIB, i.ICB, i.EXB, i.ACB, i.HDB, i.MSB, i.NVB, i.DAB, i.SHB, i.OJB, i.SEA, i.TPB, i.PGB, i.BIDV, i.AGB, i.SCB, i.VPB, i.VAB, i.GPB, i.SGB, i.NAB, i.BAB {
        width: 80px;
        height: 30px;
        display: block;
        background: url(https://www.nganluong.vn/webskins/skins/nganluong/checkout/version3/images/bank_logo.png) no-repeat;
    }

    i.MASTE {
        background-position: 0px -31px
    }

    i.AMREX {
        background-position: 0px -62px
    }

    i.JCB {
        background-position: 0px -93px;
    }

    i.VCB {
        background-position: 0px -124px;
    }

    i.TCB {
        background-position: 0px -155px;
    }

    i.MB {
        background-position: 0px -186px;
    }

    i.VIB {
        background-position: 0px -217px;
    }

    i.ICB {
        background-position: 0px -248px;
    }

    i.EXB {
        background-position: 0px -279px;
    }

    i.ACB {
        background-position: 0px -310px;
    }

    i.HDB {
        background-position: 0px -341px;
    }

    i.MSB {
        background-position: 0px -372px;
    }

    i.NVB {
        background-position: 0px -403px;
    }

    i.DAB {
        background-position: 0px -434px;
    }

    i.SHB {
        background-position: 0px -465px;
    }

    i.OJB {
        background-position: 0px -496px;
    }

    i.SEA {
        background-position: 0px -527px;
    }

    i.TPB {
        background-position: 0px -558px;
    }

    i.PGB {
        background-position: 0px -589px;
    }

    i.BIDV {
        background-position: 0px -620px;
    }

    i.AGB {
        background-position: 0px -651px;
    }

    i.SCB {
        background-position: 0px -682px;
    }

    i.VPB {
        background-position: 0px -713px;
    }

    i.VAB {
        background-position: 0px -744px;
    }

    i.GPB {
        background-position: 0px -775px;
    }

    i.SGB {
        background-position: 0px -806px;
    }

    i.NAB {
        background-position: 0px -837px;
    }

    i.BAB {
        background-position: 0px -868px;
    }

    ul.cardList li {
        cursor: pointer;
        float: left;
        margin-right: 0;
        padding: 5px 4px;
        text-align: center;
        width: 90px;
    }
</style>
