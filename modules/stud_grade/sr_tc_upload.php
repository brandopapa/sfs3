<?php

if (!$_POST['sid']) {
    exit;
}

session_id($_POST['sid']);
//session_start();


require_once 'Crypt/DiffieHellman.php';
require_once('Crypt/CBC.php');
include "security.php";
require ("config.php");

// �{���ˬd
sfs_check();

$UP_YEAR = ($IS_JHORES == 0) ? 6 : $UP_YEAR = 9; //�P�_�ꤤ�p
if ($_POST['getkey'] == 'true') {

    $alice = new Crypt_DiffieHellman($_POST['serverp'], $_POST['serverg']);

    $alice_pubKey = $alice->generateKeys()->getPublicKey(Crypt_DiffieHellman::BINARY);

    $_SESSION['alicepk'] = $alice_pubKey;

    $alice_computeKey = $alice->computeSecretKey(base64_decode($_POST['serverpk']), Crypt_DiffieHellman::BINARY)->getSharedSecretKey(Crypt_DiffieHellman::BINARY);

    $_SESSION['alicesk'] = $alice_computeKey;


    echo base64_encode($_SESSION['alicepk']);
} else {

    header('Content-Type: application/json; charset=utf-8');
    $key = $_SESSION['alicesk'];
    $aeskey = hash('md5', base64_encode($_SESSION['alicesk']));

    $class_name = class_base();
    $curr_year = curr_year();
    //$str ="���~�Ǧ~��,�~��,�Z�ŦW��,���y,�����Ҧr��,�ǥͩm�W,�ʧO,�X�ͦ~,�X�ͤ�,�X�ͤ�,�J�Ǧ~,���~�r��,���@�H,�p���q��,���y�a�},�ɤJ�ꤤ,���O����\r\n";
    //��������~�͸�ƪ�
    $sql = "SELECT a.*,b.curr_class_num,b.stud_country,b.stud_person_id,b.stud_name,b.stud_sex,b.stud_birthday,b.stud_study_year,b.stud_addr_1,b.stud_tel_1,b.stud_addr_2,c.guardian_name FROM grad_stud a INNER JOIN stud_base b ON a.student_sn=b.student_sn INNER JOIN stud_domicile c ON a.student_sn=c.student_sn WHERE stud_grad_year='$curr_year' GROUP BY student_sn ORDER BY grad_num";
    $rs = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql", 256);


    if (!$curr_seme) {
        $sel_year = curr_year(); //��ܾǦ~
        $sel_seme = curr_seme(); //��ܾǴ�
        $curr_seme = curr_year() . curr_seme(); //�{�b�Ǧ~�Ǵ�
    } else {
        $sel_year = substr($curr_seme, 0, 3);
        $sel_seme = substr($curr_seme, 3, 1);
        $curr_seme = $sel_year . $sel_seme;
    }

    while (!$rs->EOF) {
        $results[] = array(
            'curr_seme' => $curr_seme,
            'graduate_year' => trim($curr_year),
            'grade' => trim($rs->fields['class_year']),
            'cname' => iconv('BIG5', 'UTF-8//IGNORE', $class_name[substr(trim($rs->fields[curr_class_num]), 0, -2)]),
            'country' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['stud_country'])),
            'stud_pid' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['stud_person_id'])),
            'stud_name' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['stud_name'])),
            'stud_sex' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['stud_sex'] == '1' ? '�k' : '�k')),
            'birth_day' => trim($rs->fields['stud_birthday']),
            'study_year' => trim($rs->fields['stud_study_year']),
            'grad_wordnum' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['grad_word']) . '��' . trim($rs->fields['grad_num']) . '��'),
            'guardian_name' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['guardian_name'])),
            'stud_tel' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['stud_tel_2'] ? $rs->fields['stud_tel_2'] : $rs->fields['stud_tel_1'])),
            'stud_addr' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['stud_addr_1'])),
            'new_school' => iconv('BIG5', 'UTF-8//IGNORE', trim($rs->fields['new_school']))
        );
        $rs->MoveNext();
    }

    $json = json_encode($results);

    echo Security::encrypt($json, $aeskey);
    exit;
}
?>
