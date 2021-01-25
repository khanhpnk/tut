
<?php
$ck_user = $_SESSION[USER_SESS];
if (!defined('CMS_SYSTEM')) die();
if (!defined('iS_USER') || !isset($userInfo) || !isset($ck_user)) {
    header("Location: " . url_sid("index.php?f=user&do=login") . "");
    exit();
}
$page_title = "Nạp EP bằng thẻ viễn thông";
include_once("header.php");
if (@$_POST['nlpayment']) {
    include_once('confignganluong.php');
    include_once('NL_Checkoutv3.php');
    $nlcheckout = new NL_CheckOutV3(MERCHANT_ID, MERCHANT_PASS, RECEIVER, URL_API);
    $total_amount = $_POST['total_amount'];
    $array_items = array();
    $payment_method = $_POST['option_payment'];
    $bank_code = @$_POST['bankcode'];
    $order_code = "macode_" . time();

    $payment_type = '';
    $discount_amount = 0;
    $order_description = '';
    $tax_amount = 0;
    $fee_shipping = 0;
    $return_url = 'http://thuvienxaydung.net/napthethanhcong.php';
    $cancel_url = urlencode('http://thuvienxaydung.net/?f=napthe&do=create&orderid=' . $order_code);
    $buyer_fullname = $_POST['buyer_fullname'];
    $buyer_email = $_POST['buyer_email'];
    $buyer_mobile = $_POST['buyer_mobile'];
    $buyer_address = $_POST['buyer_address'];
    if (!isset($nl_result))
        $nl_result = new stdClass();


    $nl_result->error_code = false;
    if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
        if ($payment_method == "VISA") {

            $nl_result = $nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount,
                $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                $buyer_address, $array_items, $bank_code);

        } elseif ($payment_method == "NL") {
            $nl_result = $nlcheckout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount,
                $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                $buyer_address, $array_items);

        } elseif ($payment_method == "ATM_ONLINE" && $bank_code != '') {
            $nl_result = $nlcheckout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount,
                $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                $buyer_address, $array_items);
        } elseif ($payment_method == "NH_OFFLINE") {
            $nl_result = $nlcheckout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
        } elseif ($payment_method == "ATM_OFFLINE") {
            $nl_result = $nlcheckout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

        } elseif ($payment_method == "IB_ONLINE") {
            $nl_result = $nlcheckout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
        } elseif ($payment_method == "CREDIT_CARD_PREPAID") {

            $nl_result = $nlcheckout->PrepaidVisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
        }elseif ($payment_method == "QRCODE") {

            $nl_result = $nlcheckout->BankCheckoutQR($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

        }
        //var_dump($nl_result); die;
        if ($nl_result->error_code == '00') {

            //Cập nhât order với token  $nl_result->token để sử dụng check hoàn thành sau này
            ?>
            <script type="text/javascript">
                <!--
                window.location = "<?php echo(string)$nl_result->checkout_url; // .'&lang=en' chuyển mặc định tiếng anh  ?>"
                //-->
            </script>
            <?PHP
        } else {
            echo $nl_result->error_message;
        }

    } else {
        echo "<h3> Bạn chưa nhập đủ thông tin khách hàng </h3>";
    }
}

?>



<div id="wrapper">
    <!-- nav -->
    <div class="nav">
        <div class="nav_title">Phương thức thanh toán</div>
    </div>
    <!--/ end nav -->

    <!-- payment -->
    <div class="payment_list">
        <div id="select_payment">
            <form name="NLpayBank" action="#" method="post">

                <div class="row-fluid customer_info ">
                    <div class="info">
                        <span class="title">Thanh toán trực tuyến bằng thẻ ATM; Visa, Master Card;... qua NgânLượng.vn</span>
                        <dl class="dl-horizontal">
                            <div class="form-group">
                                <dt>Họ và tên:</dt>
                                <dd>
                                    <input type="text" id="fullname" name="buyer_fullname" class="field-chec " value="">
                                </dd>
                            </div>
                            <div class="form-group">
                                <dt>Email:</dt>
                                <dd>
                                    <input type="text" id="fullname" name="buyer_email" class="field-check " value="">
                                </dd>
                            </div>
                            <div class="form-group">
                                <dt>Số điện thoại:</dt>
                                <dd>
                                    <input type="text" id="fullname" name="buyer_mobile" class="field-check " value="">
                                </dd>
                            </div>
                            <div class="form-group">
                                <dt>Địa chỉ:</dt>
                                <dd>
                                    <input type="text" id="fullname" name="buyer_address" class="field-check " value="">
                                </dd>
                            </div>
                            <div class="form-group">
                                <dt>Số tiền thanh toán:</dt>
                                <dd>
                                    <input type="text" id="total_amount" name="total_amount" class="field-check " value="">
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <ul class="list-content">

                    <li class="active">
                        <label>
                            <input type="radio" value="ATM_ONLINE" name="option_payment" checked>Thanh toán online bằng thẻ ngân hàng nội địa</label>

                        <div class="boxContent">
                            <p><i> <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.</i></p>

                            <ul class="cardList clearfix">
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                        <input type="radio" value="BIDV" name="bankcode" checked>

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                        <input type="radio" value="VCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="vnbc_ck_on">
                                        <i class="DAB" title="Ngân hàng Đông Á"></i>
                                        <input type="radio" value="DAB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                        <input type="radio" value="TCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_mb_ck_on">
                                        <i class="MB" title="Ngân hàng Quân Đội"></i>
                                        <input type="radio" value="MB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vib_ck_on">
                                        <i class="VIB" title="Ngân hàng Quốc tế"></i>
                                        <input type="radio" value="VIB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vtb_ck_on">
                                        <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                        <input type="radio" value="ICB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_exb_ck_on">
                                        <i class="EXB" title="Ngân hàng Xuất Nhập Khẩu"></i>
                                        <input type="radio" value="EXB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_acb_ck_on">
                                        <i class="ACB" title="Ngân hàng Á Châu"></i>
                                        <input type="radio" value="ACB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_hdb_ck_on">
                                        <i class="HDB" title="Ngân hàng Phát triển Nhà TPHCM"></i>
                                        <input type="radio" value="HDB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                        <input type="radio" value="MSB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_nvb_ck_on">
                                        <i class="NVB" title="Ngân hàng Nam Việt"></i>
                                        <input type="radio" value="NVB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vab_ck_on">
                                        <i class="VAB" title="Ngân hàng Việt Á"></i>
                                        <input type="radio" value="VAB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vpb_ck_on">
                                        <i class="VPB" title="Ngân Hàng Việt Nam Thịnh Vượng"></i>
                                        <input type="radio" value="VPB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_scb_ck_on">
                                        <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                        <input type="radio" value="SCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_pgb_ck_on">
                                        <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                        <input type="radio" value="PGB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_gpb_ck_on">
                                        <i class="GPB" title="Ngân hàng TMCP Dầu khí Toàn Cầu"></i>
                                        <input type="radio" value="GPB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_agb_ck_on">
                                        <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                        <input type="radio" value="AGB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_sgb_ck_on">
                                        <i class="SGB" title="Ngân hàng Sài Gòn Công Thương"></i>
                                        <input type="radio" value="SGB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on">
                                        <i class="BAB" title="Ngân hàng Bắc Á"></i>
                                        <input type="radio" value="BAB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on">
                                        <i class="TPB" title="Tền phong bank"></i>
                                        <input type="radio" value="TPB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on">
                                        <i class="NAB" title="Ngân hàng Nam Á"></i>
                                        <input type="radio" value="NAB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on">
                                        <i class="SHB" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"></i>
                                        <input type="radio" value="SHB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on">
                                        <i class="OJB" title="Ngân hàng TMCP Đại Dương (OceanBank)"></i>
                                        <input type="radio" value="OJB" name="bankcode">

                                    </label>
                                </li>

                            </ul>

                        </div>
                    </li>
                    <li>
                        <label>
                            <input type="radio" value="IB_ONLINE" name="option_payment">Thanh toán bằng Internet-Banking
                        </label>

                        <div class="boxContent">
                            <p><i>
                                    <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:
                                    Bạn cần
                                    đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi
                                    thực
                                    hiện.</i></p>

                            <ul class="cardList clearfix">
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                        <input type="radio" value="BIDV" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                        <input type="radio" value="VCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="vnbc_ck_on">
                                        <i class="DAB" title="Ngân hàng Đông Á"></i>
                                        <input type="radio" value="DAB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                        <input type="radio" value="TCB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="ICB" title="Ngân hàng TMCP Công Thương (VietinBank)"></i>
                                        <input type="radio" value="ICB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="EXB" title="Ngân hàng TMCP Xuất Nhập Khẩu (Eximbank)"></i>
                                        <input type="radio" value="EXB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="ACB" title="Ngân hàng TMCP Á Châu (ACB)"></i>
                                        <input type="radio" value="ACB" name="bankcode">
                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="SCB" title="Ngân hàng TMCP Sài Gòn Thương Tín (Sacombank)"></i>
                                        <input type="radio" value="STB" name="bankcode">
                                    </label>
                                </li>

                            </ul>

                        </div>
                    </li>
                    <li>
                        <label>
                            <input type="radio" value="ATM_OFFLINE" name="option_payment">Thanh toán ATM OFFLINE
                        </label>

                        <div class="boxContent">

                            <ul class="cardList clearfix">
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                        <input type="radio" value="BIDV" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                        <input type="radio" value="VCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="vnbc_ck_on">
                                        <i class="DAB" title="Ngân hàng Đông Á"></i>
                                        <input type="radio" value="DAB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                        <input type="radio" value="TCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_mb_ck_on">
                                        <i class="MB" title="Ngân hàng Quân Đội"></i>
                                        <input type="radio" value="MB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vtb_ck_on">
                                        <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                        <input type="radio" value="ICB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_acb_ck_on">
                                        <i class="ACB" title="Ngân hàng Á Châu"></i>
                                        <input type="radio" value="ACB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                        <input type="radio" value="MSB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_scb_ck_on">
                                        <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                        <input type="radio" value="SCB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_pgb_ck_on">
                                        <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                        <input type="radio" value="PGB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_agb_ck_on">
                                        <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                        <input type="radio" value="AGB" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on">
                                        <i class="SHB" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"></i>
                                        <input type="radio" value="SHB" name="bankcode">

                                    </label>
                                </li>

                            </ul>

                        </div>
                    </li>
                    <li>
                        <label>
                            <input type="radio" value="NH_OFFLINE" name="option_payment">Thanh toán tại văn phòng ngân hàng</label>

                        <div class="boxContent">

                            <ul class="cardList clearfix">
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                        <input type="radio" value="BIDV" name="bankcode">

                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                        <input type="radio" value="VCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="vnbc_ck_on">
                                        <i class="DAB" title="Ngân hàng Đông Á"></i>
                                        <input type="radio" value="DAB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="tcb_ck_on">
                                        <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                        <input type="radio" value="TCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_mb_ck_on">
                                        <i class="MB" title="Ngân hàng Quân Đội"></i>
                                        <input type="radio" value="MB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vib_ck_on">
                                        <i class="VIB" title="Ngân hàng Quốc tế"></i>
                                        <input type="radio" value="VIB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vtb_ck_on">
                                        <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                        <input type="radio" value="ICB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_acb_ck_on">
                                        <i class="ACB" title="Ngân hàng Á Châu"></i>
                                        <input type="radio" value="ACB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                        <input type="radio" value="MSB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_scb_ck_on">
                                        <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                        <input type="radio" value="SCB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_pgb_ck_on">
                                        <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                        <input type="radio" value="PGB" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="bnt_atm_agb_ck_on">
                                        <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                        <input type="radio" value="AGB" name="bankcode">
                                    </label>
                                </li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_bab_ck_on"> <i class="TPB" title="Tền phong bank"></i>
                                        <input type="radio" value="TPB" name="bankcode">
                                    </label>
                                </li>

                            </ul>

                        </div>
                    </li>
                    <li>
                        <label>
                            <input type="radio" value="VISA" name="option_payment" selected="true">Thanh toán bằng thẻ Visa hoặc MasterCard</label>

                        <div class="boxContent">
                            <p><span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:Visa hoặc MasterCard.</p>
                            <ul class="cardList clearfix">
                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        Visa:
                                        <input type="radio" value="VISA" name="bankcode">

                                    </label>
                                </li>

                                <li class="bank-online-methods ">
                                    <label for="vnbc_ck_on">
                                        Master:
                                        <input type="radio" value="MASTER" name="bankcode">
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li style="display: none">
                        <label>
                            <input type="radio" value="CREDIT_CARD_PREPAID" name="option_payment" selected="true">Thanh toán bằng thẻ Visa hoặc MasterCard trả trước</label>
                    </li>
                    <li>
                        <label><input type="radio" value="QRCODE" name="option_payment"> Thanh toán bằng việc quét mã QRCODE</label>

                        <div class="boxContent">

                            <ul class="cardList clearfix">

                                <li class="bank-online-methods ">
                                    <label for="vcb_ck_on">
                                        <i class="VCB"
                                           title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                        <input type="radio" value="VCB" name="bankcode" >

                                    </label>
                                </li>


                                <li class="bank-online-methods ">
                                    <label for="sml_atm_mb_ck_on">
                                        <i class="MB" title="Ngân hàng Quân Đội"></i>
                                        <input type="radio" value="MB" name="bankcode">

                                    </label></li>


                                <li class="bank-online-methods ">
                                    <label for="sml_atm_vtb_ck_on">
                                        <i class="ICB"
                                           title="Ngân hàng Công Thương Việt Nam"></i>
                                        <input type="radio" value="ICB" name="bankcode">

                                    </label></li>


                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                        <input type="radio" value="MSB" name="bankcode">

                                    </label></li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_scb_ck_on">
                                        <i class="NVB" title="Ngân hàng TMCP Quốcdân (NaviBank)"></i>
                                        <input type="radio" value="NVB" name="bankcode">

                                    </label></li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="VPB" title="Ngân hàng TMCP ViệtNam ThịnhVượng (VPBank)"></i>
                                        <input type="radio" value="VPB" name="bankcode">

                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="AGB" title="Ngân hàng Nông nghiệp vàPhát triển Nôngthôn (Agribank)"></i>
                                        <input type="radio" value="AGB" name="bankcode">
                                    </label></li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="SHB" title="Ngân hàngTMCP Sài Gòn- Hà Nội (SHB)"></i>
                                        <input type="radio" value="SHB" name="bankcode">
                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="TPB" title="Ngân hàngTMCP TiênPhong(TienPhongBank)"></i>
                                        <input type="radio" value="TPB" name="bankcode">
                                    </label></li>

                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="ABB" title="Ngân hàng TMCP An Bình">Ngân hàng TMCP An Bình</i><br>
                                        <input type="radio" value="ABB" name="bankcode">
                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="SGCB" title="Ngân hàngThương Mại CổPhần Sài Gòn -SaigonCommercialBank">Saigon <br>Commercial Bank</i><br>
                                        <input type="radio" value="SGCB" name="bankcode">
                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="IVB" title="Ngân hàng trách nhiệm hữu hạn Indovina">Ngân hàng trách nhiệm hữu hạn Indovina</i><br>
                                        <input type="radio" value="IVB" name="bankcode">
                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="WCP" title="WeChat Pay">WeChat Pay</i><br>
                                        <input type="radio" value="WCP" name="bankcode">
                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="GDB" title="Ngân hàng TMCP Bản Việt">Ngân hàng TMCP Bản Việt</i><br>
                                        <input type="radio" value="GDB" name="bankcode">
                                    </label></li>
                                <li class="bank-online-methods ">
                                    <label for="sml_atm_msb_ck_on">
                                        <i class="OCB" title="Ngân hàng TMCP Phương Đông">Ngân hàng TMCP Phương Đông</i><br>
                                        <input type="radio" value="OCB" name="bankcode">
                                    </label></li>
                            </ul>

                        </div>
                    </li>
                </ul>

                <input type="submit" class="btn btn-success" name="nlpayment" value="Thanh toán" />

            </form>

        </div>

    </div>
    <!--/ end payment -->
</div>
<script language="javascript">
    $('input[name="option_payment"]').bind('click', function () {
        $('.list-content li').removeClass('active');
        $(this).parent().parent('li').addClass('active');
    });
</script>

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
    .form-group{
        width: 100%;
        float: left;
    }
    .btn-success{
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
    dt{
        float: left;
        width: 200px;
        margin-bottom: 20px;
    }
    ul.bankList {
        clear: both;
        height: 202px;
        width: 636px;
    }
    ul{
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

<?php
OpenTab("Danh sách thanh toán");
echo "<div class=\"content\">";
$perpage = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : (isset($_POST['page']) ? intval($_POST['page']) : 1);
$from = isset($_GET["from"]) ? $_GET["from"] : "";
$to = isset($_GET["to"]) ? $_GET["to"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "";
$offset = ($page - 1) * $perpage;

$total = $db->sql_numrows($db->sql_query("SELECT * FROM " . $prefix . "_napthe WHERE userid=" . $userInfo['id'] . " "));
$result = $db->sql_query("SELECT  id,userid,time,order_code,error_code,total_amount  FROM " . $prefix . "_napthe WHERE userid=" . $userInfo['id'] . " ORDER BY time DESC LIMIT $offset, $perpage");
?>

<?php
if ($db->sql_numrows($result) > 0) {

    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"4\" class=\"tableborder\">\n";
    echo "<tr style=\"background:#f9f9f9\">\n";
    echo "<td class=\"row1sd\" width=\"60\">Thời gian giao dịch</td>\n";
    echo "<td class=\"row1sd\" width=\"30\">Mã giao dịch</td>\n";
    echo "<td class=\"row1sd\" width=\"30\">Số tiền</td>\n";
    echo "<td class=\"row1sd\" align=\"left\" width=\"30\">Trạng thái</td>\n";
    echo "</tr>\n";
    $cur_ar = array(_VND, _USD);
    $i = 0;
    while (list($id, $userid, $time,$order_code,$error_code,$total_amount) = $db->sql_fetchrow($result)) {
        if ($i % 2 == 1) {
            $css = "row1";
            $style_css = "style=\"background:#f9f9f9;\"";
        } else {
            $css = "row3";
            $style_css = "style=\"background:#ffffff;\"";
        }
        if ($error_code == 00) {
            $status = "Thành công";
        } elseif ($status == 06) {
            $status = "Mã merchant không tồn tại hoặc chưa được kích hoạt";
        } elseif ($status == 06) {
            $status = "Mã merchant không tồn tại hoặc chưa được kích hoạt";
        } elseif ($status == 03) {
            $status = "Sai tham số gửi tới NganLuong.vn (có tham số sai tên hoặc kiểu dữ liệu), sai checksum ";
        } elseif ($status == 01) {
            $status = "Sai phương thức, không đúng phương thức POST";
        }elseif ($status == 29) {
            $status = "Token không tồn tại ";
        }elseif ($status == 81) {
            $status = " Đơn hàng chưa được thanh toán ";
        }elseif ($status == 99) {
            $status = "  Lỗi không xác định ";
        }elseif ($status == 13) {
            $status = " Đơn hàng không đúng của Merchant";
        }
        echo "<tr $style_css>\n";
        echo "<td class=\"$css\">" . ext_time($time, 2) . "</td>\n";
        echo "<td class=\"$css\">" .$order_code . "</td>\n";
        echo "<td class=\"$css\">" .$total_amount . "</td>\n";
        echo "<td class=\"$css\"  align=\"left\">$status</td>\n";
        echo "</tr>\n";
        $i++;
    }


    echo "<tr><td class=\"row4\" colspan=\"9\">";
    if ($total > $perpage) {
        echo "<div class=\"fr\">";
        $pageurl = "index.php?f=napthe&do=create";
        echo paging($total, $pageurl, $perpage, $page);
        echo "</div>";
    }
    echo "</td></tr>";
    echo "</table></form>";
} else {
    echo "<center>Chưa phát sinh giao dịch.</center>";
}
echo "</div>";

CloseTab();
include_once("footer.php");
?>
