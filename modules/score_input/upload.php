<?php
// $Id: upload.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//include "stick/stick-cfg.php";
//include_once "stick/dl_pdf.php";

sfs_check();

//�D���]�w
//$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;
//�L�X���Y
head();

//�Ҳտ��
print_menu($menu_p,$linkstr);

//�w�]�ȳ]�w
$act=$_REQUEST[act];

$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year]; //�ثe�Ǧ~
$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme]; //�ثe�Ǵ�
$curr_seme = $sel_year.$sel_seme; //�{�b�Ǧ~�Ǵ�
//echo $_SESSION['session_log_id'];
//echo $sel_year;
//echo $sel_seme;
//���o���ЯZ�ťN��
$class_num = get_teach_class();
//echo $class_num;
if ($class_num == '') {
        head("�v�����~");
        stud_class_err();
        foot();
        exit;
}
//$curr_seme = curr_year().curr_seme(); //�{�b�Ǧ~�Ǵ�
//$class_num=get_teach_class();
//$class_all=class_num_2_all($class_num);
//$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);


if (!ini_get('register_globals')) {
        ini_set("magic_quotes_runtime", 0);
        extract( $_POST );
        extract( $_GET );
        extract( $_SERVER );
}

//echo $act;
//����ʧ@�P�_
if($act=="insert"){
	$save_result = savefile($curr_seme,$class_num);
	if (isset($save_result)){
	        global $CONN;
        	$sql = "insert into score_paper_upload (spu_sn,curr_seme,class_num,file_name,log_id,time) values ('','$curr_seme','$class_num','$save_result','".$_SESSION['session_log_id']."',NOW())";
	        $CONN->Execute($sql) or user_error("�s�W���ѡI<br>$sql",256);
	}else{
		echo "�ɮ׶ǰe�L�{�o�Ϳ��~�A�ЦA�դ@���A�Y���~���M�o�ͽЬ��޲z�H��";
		exit;
	}
}elseif($act=="modify"){
        $save_result = savefile($curr_seme,$class_num);
        if (isset($save_result)){
		global $CONN;
	        $sql = "UPDATE score_paper_upload SET curr_seme = '$curr_seme', class_num = '$class_num', file_name = '$save_result', log_id = '".$_SESSION['session_log_id']."',time = NOW() WHERE spu_sn = '".$_POST[spu_sn]."'";
        	$CONN->Execute($sql) or user_error("�ק異�ѡI<br>$sql",256);
		header("location: $_SERVER[PHP_SELF]");
	}else{
		echo "�ɮ׶ǰe�L�{�o�Ϳ��~�A�ЦA�դ@���A�Y���~���M�o�ͽЬ��޲z�H��";
                exit;
	}
}else{
//        $main=&score_paper_upload_mainForm($curr_seme,$class_num);
}
$main=&score_paper_upload_mainForm($curr_seme,$class_num);

//�q�X����
head("�ۭq���Z��");
echo $main;
foot();


//�D�n��J�e��
function &score_paper_upload_mainForm($curr_seme,$class_num){
//        global $school_menu_p;
	$dbData=get_score_paper_upload_data($curr_seme,$class_num);
//        if($mode=="modify" and !empty($spu_sn)){
//                $dbData=get_score_paper_upload_data($curr_seme,$class_num);
//        }

        if(is_array($dbData) and sizeof($dbData)>0){
                foreach($dbData as $a=>$b){
                        $DBV[$a]=(!is_null($b))?$b:"";
                }
		$submit="modify";
                $tran_warn="<p><font color=red>�z�w��".$DBV[time]."�����W�Ǧ��Z�檺�ʧ@�A�Y�����ʡA�п�ܥ��T�ɮ׫�A���U�u�W�ǡv���s�мg���e�Ҷǰe���ɮ�</font></p>";
        }else{
                $submit="insert";
        }

//        $submit=($mode=="modify")?"update":"insert";

        //����
//        $readme=readme();

        //�����\���
//        $tool_bar=&make_menu($school_menu_p);

        $main="
        <form action='$_SERVER[PHP_SELF]' method='post' ENCTYPE='multipart/form-data'>
        $tran_warn
        <table cellspacing='1' cellpadding='4' bgcolor='#C0C0C0' class='small'>
        <input type='hidden' name='spu_sn' value='$DBV[spu_sn]'>
        <tr bgcolor='#FFFFFF'>
        <td>�ɦW�G<input type='file' name='userfile' size='50'>
        <br>
        </td></tr>
        <tr bgcolor='#00659C'><td align='center'>
		<input type='hidden' name='act' value='$submit'>
                 <input type='submit' value='�W��' class='b1'></td>
        </tr>
        </table>
        </form>
        ";
        if ($DBV[printed] == 1){
		$main="<p><font color=red>�z��".$DBV[time]."�Ҷǰe�����Z��w�Q�аȳB�k�ɡA�Y�ݭ��ǽлP���U���pô</font></p>";
	}
        return $main;
}

//���o�Y�@�����
function get_score_paper_upload_data($curr_seme,$class_num){
        global $CONN;
        $sql_select="select spu_sn,file_name,time,printed from score_paper_upload where curr_seme ='$curr_seme' and class_num ='$class_num'";
        $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
        $theData=$recordSet->FetchRow();
        return $theData;
}


function savefile($curr_seme,$class_num){
        global $SFS_PATH,$UPLOAD_PATH;
        $ext = strtolower(strrchr(str_replace("'","",stripslashes($_FILES['userfile']['name'])),'.'));
        if (!(($ext == ".pdf") || ($ext == ".sxw") || ($ext == ".doc"))){
        	die("�W�Ǧ��Z��u����sxw,doc,pdf�榡");
		return;
        }else{
		$filename=$curr_seme."_".$class_num.$ext;
	}
        if($_FILES['userfile']['type'] == "application/vnd.sun.xml.writer"){
                $filename=$curr_seme."_".$class_num.".sxw";
        }
        if (!is_dir($UPLOAD_PATH)) {
                die("�W�ǥؿ� $UPLOAD_PATH ���s�b�I");
        }

        //�Τ@�W�ǥؿ�
        $upath=$UPLOAD_PATH."score_paper_upload";
        if (!is_dir($upath)) {
                mkdir($upath) or die($upath."�إߥ��ѡI");
        }

        //�W�ǥت��a
        $todir=$upath."/";
        if (!is_dir($todir)) {
                mkdir($todir) or die($todir."�ت��ؿ��إߥ��ѡI");
        }

        $the_file=$todir.$filename;

        copy($_FILES['userfile']['tmp_name'],$the_file);
        unlink($_FILES['userfile']['tmp_name']);

	if(file_exists($the_file)) {
		return $filename;
        }else{
                die("�W�Ǧ��Z�楢�ѡA�Ь��޲z�H��");
		return;
        }
}

?>
