<?php

include "config.php";

//�ثe�����\��|������
$stud_eduh_self_debug = "0";

//�ˬd���O�d���

$validate_form = '<script language="javascript" type="text/javascript">
        function setForm(cardid,pname,pid,dob,sex,issue){
                document.myform.cardid.value=cardid;
                document.myform.pname.value=pname;
                document.myform.pid.value=pid;
                document.myform.dob.value=dob;
                document.myform.sex.value=sex;
                document.myform.issue.value=issue;
                document.myform.submit();
        }

        function doAlert(msg){
                alert(msg);
        }
</script>
<p/>
	<table width="340" height="170" cellspacing="0" cellpadding="4" align="center" background="' . $SFS_PATH_HTML . 'themes/new/images/login_bg_ha.png">	
        	<tr>
			<td>
				<form name="myform" id="myform" method="post" action="" target="_self">
                
        	                <applet code="getHA.class" archive="getHA.jar" width="320" height="80" MAYSCRIPT>
                	        </applet>
                        	<input type="hidden" name="cardid" id="cardid" />
	                        <input type="hidden" name="pname" id="pname" />
        	                <input type="hidden" name="pid" id="pid" />
                	        <input type="hidden" name="dob" id="dob" />
                        	<input type="hidden" name="sex" id="sex" />
	                        <input type="hidden" name="issue" id="issue" />
						
				</form>				
				<span class="small">
					<p> &nbsp; &nbsp;���t�κ޲z�̭n�D�z�ϥΰ��O�d�i��G���������ҡI</p>
				</span>
			</td>
		</tr>
    </table>

<p/>
<div style="width:360px;margin-left:auto;margin-right:auto;">';

$query = "select stud_sex,stud_birthday,stud_person_id from stud_base where student_sn=" . $_SESSION['session_tea_sn'];
$res = $CONN->Execute($query);

$equal_pid = false;
$equal_sex = false;
$equal_birthday = false;
$msg = '<fieldset><legend>��ƬO�_�۵�</legend>';


if ($_POST['pname'] == $_SESSION['session_tea_name']) {
    $msg .= '�m�W�۵�' . '<br/>';
    $equal_name = true;
}

if ($_POST['pid'] == $res->fields['stud_person_id']) {
    $msg .= 'ID�۵�' . '<br/>';
    $equal_pid = true;
}

if ($_POST['sex'] == "M") {
    $sex = 1;
} else {
    $sex = 2;
}

if ($sex == $res->fields['stud_sex']) {
    $msg .= '�ʧO�۵�' . '<br/>';
    $equal_sex = true;
}

$birthdayary = explode("-", $res->fields['stud_birthday']);
$year = $birthdayary[0] - 1911;
if ($year < 100) {
    $year = '0' . $year;
}
$birthday = $year . $birthdayary[1] . $birthdayary[2];

if ($birthday == $_POST['dob']) {
    $msg .= '�ͤ�۵�' . '<br/>';
    $equal_birthday = true;
}


$msg .= '</fieldset>';

if ($stud_eduh_self_debug == "1") {
    $validate_form .= '<fieldset><legend>���O�d��Ƥ��e</legend><pre>';
    $validate_form .= $_POST;
    $validate_form .= '</pre></fieldset>
                        	<fieldset><legend>Session</legend><pre>';
    $validate_form .= $_SESSION;
    $validate_form .= '</pre></fieldset>
                        	<fieldset><legend>Database</legend><pre>';
    $validate_form .= $res->fields;
    $validate_form .= '</pre></fieldset>';
    $validate_form .= $msg;
}

//�u�ˬd�����Ҧr���Υͤ�
if ($equal_pid && $equal_birthday) {
    $_SESSION['stud_hacard_serial'] = $_POST['cardid'];
    header("Location: index.php");
}


$validate_form.='</div>';

if (!$_SESSION['stud_hacard_serial']) {

    head("�ǥͰ��O�d�{���ˬd");
    echo $validate_form;
    foot();
}
?>

