<?php
// ���J�]�w��
require "stud_reg_config.php";
include_once "../../include/sfs_case_dataarray.php";



// �{���ˬd
sfs_check();


$session_id = session_id();
$useragent = $_SERVER['HTTP_USER_AGENT'];
$curr_seme = $_GET['curr_seme'];
$target_page = $SFS_PATH_HTML . 'modules/stud_reg/stud_base_upload.php';
if (function_exists('curl_ini')) {
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => "https://oidc.tc.edu.tw/api/real-ip",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => "api:oidcuser"
    );
    curl_setopt_array($ch, $options);
    $real_ip = curl_exec($ch);
    curl_close($ch);
} else {
    if (!$real_ip) {
        $real_ip = file_get_contents('http://phihag.de/ip/');
    }
}


if (!$curr_seme) {
    $sel_year = curr_year(); //��ܾǦ~
    $sel_seme = curr_seme(); //��ܾǴ�
    $curr_seme = curr_year() . curr_seme(); //�{�b�Ǧ~�Ǵ�
} else {
    $sel_year = substr($curr_seme, 0, 3);
    $sel_seme = substr($curr_seme, 3, 1);
    $curr_seme = $sel_year . $sel_seme;
}

$para = array(
    'curr_seme' => $curr_seme,
    'session_id' => $session_id,
    'useragent' => $useragent,
    'target_page' => $target_page,
    //'submit_ip'     => $_SERVER['REMOTE_ADDR'],
    //'submit_ip'     => file_get_contents('http://phihag.de/ip/'),
    'submit_ip' => $real_ip,
    'upload_id' => trim($_SESSION['session_log_id']),
    'upload_name' => trim(iconv("BIG5", "UTF-8", $_SESSION['session_tea_name'])),
    'edu_id' => trim($SCHOOL_BASE['sch_id'])
);

//echo json_encode($para);
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    echo "<script type=\"text/javascript\" src=\"https://java.com/js/dtjava.js\"></script>";
} else {
    echo "<script type=\"text/javascript\" src=\"http://java.com/js/dtjava.js\"></script>";
}

//�P�_�O�_�O�x�����Ǯ�
$isTaichung = substr($SCHOOL_BASE['sch_id'], 0, 2);
head();
print_menu($menu_p);
?>

<script>
    function javafxEmbed() {
        dtjava.embed(
                {
                    url: 'XCALogin.jnlp',
                    placeholder: 'javafx-app-placeholder',
                    width: 400,
                    height: 100,
                    params: {
                        webparams: '<?php echo json_encode($para) ?>'
                    }
                },
        {
            javafx: '8.0+',
            jvmargs: '-Xms512m '
        },
        {}
        );
    }
<!-- Embed FX application into web page once page is loaded -->
    dtjava.addOnloadCallback(javafxEmbed);
</script>
<fieldset>
    <legend>���Ǧ~�צb�y�͸�Ʀ۰ʤW��(�O�����N�Ǻޱ��t��)</legend>
    <?php
    if ($isTaichung == '06' || $isTaichung == '19') {
        echo '<div id="javafx-app-placeholder"></div>';
    } else {
        echo '<h3>�ܩ�ۡA���\��ȨѻO�������ݾǮըϥ�</h3>';
    }
    ?>

</fieldset>