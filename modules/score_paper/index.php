<?php
// $Id: index.php 7700 2013-10-23 08:09:06Z smallduh $

include "config.php";
sfs_check();
$OS=PHP_OS;
//�D���]�w
$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

//�w�]�ȳ]�w
$col_default=array("enable"=>"1;2");


$act=$_REQUEST[act];

//����ʧ@�P�_
if($act=="insert"){
        $msg=score_paper_add($_POST[data]);
        header("location: $_SERVER[PHP_SELF]?act=listAll&msg=$msg");
}elseif($act=="update"){
        score_paper_update($_POST[data],$_POST[sp_sn]);
        header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="del"){
        score_paper_del($_GET[sp_sn]);
        header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="modify"){
        $main=&score_paper_mainForm($_GET[sp_sn],"modify");
        $main.="<p>".score_paper_listAll($_GET[msg]);
}else{
        $main=&score_paper_mainForm($_POST[sp_sn]);
        $main.="<p>".score_paper_listAll($_GET[msg]);
}


//�q�X����
head("�ۭq���Z��");

echo $main;
foot();

//�D�n��J�e��
function &score_paper_mainForm($sp_sn="",$mode){
        global $school_menu_p,$col_default;

        if($mode=="modify" and !empty($sp_sn)){
                $dbData=get_score_paper_data($sp_sn);
        }

        if(is_array($dbData) and sizeof($dbData)>0){
                foreach($dbData as $a=>$b){
                        $DBV[$a]=(!is_null($b))?$b:$col_default[$a];
                }
        }else{
                $DBV=$col_default;
        }

        $submit=($mode=="modify")?"update":"insert";

        //����
        $readme=readme();

        //�����\���
        $tool_bar=&make_menu($school_menu_p);

        $main="
        $tool_bar

        <table cellspacing='1' cellpadding='4' bgcolor='#C0C0C0' class='small'>
        <form action='$_SERVER[PHP_SELF]' method='post' ENCTYPE='multipart/form-data'>

        <input type='hidden' name='data[sp_sn]' value='$DBV[sp_sn]'>

        <tr bgcolor='#FFFFFF'>
        <td>�ɦW�G<input type='file' name='userfile' value='$DBV[file_name]' size='20'>
        <br>�W�١G<input type='text' name='data[sp_name]' value='$DBV[sp_name]' size='20' maxlength='255'><br>�ҥΡG<input type='radio' name='data[enable]' value='1' checked>�ϥ�<input type='radio' name='data[enable]' value='2' >����
        </td><td rowspan=3 valign=top>$readme</td></tr>

        <tr bgcolor='#D6DFFF'><td>��²��y�z�����Z��</td></tr>
        <tr bgcolor='#00659C'><td align='center'>
        <textarea name='data[descriptive]' cols='40' rows='5' style='width:100%'>$DBV[descriptive]</textarea>
        <br>
        <input type='hidden' name='sp_sn' value='$sp_sn'>
        <input type='hidden' name='act' value='$submit'>
        <input type='submit' value='�W��' class='b1'></td>
        </tr>

        </table>
        </form>
        ";
        return $main;
}

//readme
function readme(){
        $main="<ol style='line-height:2'>
        <li>�Y���ۻs���Z��A�Шϥ� OpenOffice.org �� Writer �ӫإ߷s�ɮסA���]�s�ɬ� test.sxw�C
        <li>�аѦ�<a href='mark.php'>�i�μ���</a>�A�ñN�ݭn������J test.sxw ���A�Ҧp {�ǥͩm�W} ��ɭԤU���ɴN�|�۰��ܦ��ǥͪ��m�W�A�z�i�H�Ѧҳo�ӽd�ҡG<a href='demo.sxw'>���Z��d��(�U����бN���ɦW�אּ.sxw)</a>�C
        <li>���n��A�N�i�H�쥪��W�ǡA�t�η|�N�z�����Z��˪��x�s�_�ӡC
        <li>�̫�A�N�i�H��<a href='make.php'>���Z��s�@</a>�h�U�����Z��C
        <li>��Բӻ����Ь�<a href='faq.php'>���Z��s�@���D��</a>�C
        </ol>
        ";
        return $main;
}

//�s�W
function score_paper_add($data){
        global $CONN;

        $sql_insert = "insert into score_paper (sp_sn,file_name,sp_name,descriptive,enable) values ('$data[sp_sn]','".$_FILES['userfile']['name']."','$data[sp_name]','$data[descriptive]','$data[enable]')";
        $CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
        $sp_sn=mysql_insert_id();
        $msg=unzip($sp_sn);
        return $msg;
}

//��s
function score_paper_update($data,$sp_sn){
        global $CONN;
        $file=(!empty($_FILES['userfile']['name']))?"file_name='".$_FILES['userfile']['name']."',":"";

        $sql_update = "update score_paper set $file sp_name='$data[sp_name]',descriptive='$data[descriptive]',enable='$data[enable]'  where sp_sn='$sp_sn'";
        $CONN->Execute($sql_update) or user_error("��s���ѡI<br>$sql_update",256);
        return $sp_sn;
}

//�R��
function score_paper_del($sp_sn=""){
        global $CONN,$UPLOAD_PATH;

        //Openofiice�����|
        $dir=$UPLOAD_PATH."score_paper/".$sp_sn;

        //�R���ؿ��Ҧ��ɮ�
        deldir($dir);
        $sql_delete = "delete from score_paper where sp_sn='$sp_sn'";
        $CONN->Execute($sql_delete) or user_error("�R�����ѡI<br>$sql_delete",256);

        return true;
}



//�C�X�Ҧ�
function &score_paper_listAll($msg=""){
        global $CONN,$SFS_PATH_HTML,$UPLOAD_URL;

        $sql_select="select sp_sn,file_name,sp_name,descriptive,enable from score_paper";
        $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
        while (list($sp_sn,$file_name,$sp_name,$descriptive,$enable)=$recordSet->FetchRow()) {
                //Openofiice�����|
                $df=$UPLOAD_URL."score_paper/".$sp_sn."/".$sp_sn.".sxw";

                $data.="<tr bgcolor='#FFFFFF'><td>$sp_sn</td><td><a href='$df'>$file_name</a></td><td>$sp_name</td><td>$descriptive</td><td>$enable</td><td nowrap><a href='$_SERVER[PHP_SELF]?act=modify&sp_sn=$sp_sn'>�ק�</a> | <a href='$_SERVER[PHP_SELF]?act=del&sp_sn=$sp_sn'>�R��</a></td></tr>";
        }
        $main="
        <table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
        <tr bgcolor='#E6E9F9'><td>�y����</td><td>�ɦW</td><td>�W��</td><td>�y�z</td><td>�ҥ�</td><td>�\��</td></tr>
        $data
        </table>
        $msg";
        return $main;
}



//���o�Y�@�����
function get_score_paper_data($sp_sn){
        global $CONN;
        $sql_select="select sp_sn,file_name,sp_name,descriptive,enable from score_paper where sp_sn='$sp_sn'";
        $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
        $theData=$recordSet->FetchRow();
        return $theData;
}


function unzip($sp_sn=0){
        global $SFS_PATH,$UPLOAD_PATH,$OS;
        if(empty($sp_sn))return;

        $is_win=ereg('win', strtolower($_SERVER['SERVER_SOFTWARE']))?true:false;
        $zipfile=($is_win)?"UNZIP32.EXE":"/usr/bin/unzip";
        
        $zipfile=($OS=="FreeBSD")?"/usr/local/bin/unzip":$zipfile;


        $arg1=($is_win)?"START /min cmd /c ":"";
        $arg2=($is_win)?"-d":"-d";

        if($_FILES['userfile']['type'] == "application/vnd.sun.xml.writer"){
                $filename=$sp_sn.".sxw";
        }elseif(strtolower(substr($_FILES['userfile']['name'],-3))=="sxw"){
                $filename=$sp_sn.".sxw";
        }else{
                die("�榡�����T");
        }

        if (!is_dir($UPLOAD_PATH)) {
                die("�W�ǥؿ� $UPLOAD_PATH ���s�b�I");
        }


        //�Τ@�W�ǥؿ�
        $upath=$UPLOAD_PATH."score_paper";
        if (!is_dir($upath)) {
                mkdir($upath) or die($upath."�إߥ��ѡI");
        }

        //�W�ǥت��a
        $todir=$upath."/".$sp_sn."/";
        if (!is_dir($todir)) {
                mkdir($todir) or die($todir."�ت��ؿ��إߥ��ѡI");
        }

        $the_file=$todir.$filename;

        copy($_FILES['userfile']['tmp_name'],$the_file);
        unlink($_FILES['userfile']['tmp_name']);

        if (!file_exists($zipfile)) {
       	       echo $_SERVER['PHP_OS'];
                die($zipfile."���s�b�I");
        }elseif(!file_exists($the_file)) {
                die($the_file."���s�b�I");
        }

        $cmd=$arg1." ".$zipfile." ".$the_file." ".$arg2." ".$todir;
        if(exec($cmd,$output,$rv)){
                //unlink($the_file);
                return;
        }else{
                $msg=$cmd."�w����C<br>";
                foreach($output as $v){
                        $msg.=$v."<br>";
                }
                return $msg;
        }
}
?>