<?php
if(!defined('CMS_ADMIN')) {
    die("Illegal File Access");
}

$result = $db->sql_query("SELECT email, fullname FROM ".$prefix."_user");
$num = 0;
$users = array();
if ($db->sql_numrows() > 0) {
    while (list($email, $fullname) = $db->sql_fetchrow($result)) {
        $users[$num]['email'] = $email;
        $users[$num]['firstname'] = $fullname;
        $users[$num]['lastname'] = '';
        $num++;
        /*
        if ($num > 5) {
            break;
        }
        */
    }
}

$output = fopen("php://output",'w') or die("Can't open php://output");
header("Content-Type:application/csv"); 
header("Content-Disposition:attachment;filename=thuvienxaydung-email-" . date('Y-m-d'). ".csv");
fputcsv($output, array('email', 'firstname', ''));
foreach($users as $user) {
    fputcsv($output, $user);
}
fclose($output) or die("Can't close php://output");
?>