<?php
// $Id: modify.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//�w�]�ȳ]�w

//���U���O
$type=($_REQUEST[type]);

$act=$_REQUEST[act];

//����ʧ@�P�_
if($act=="update"){
        grant_update($_POST[data],$_POST[sn]);
        header("location: index.php?type=$type");
}elseif($act=="del"){
        grant_del($_GET[sn]);
        header("location: index.php?type=$type");
}elseif($act=="modify"){
        $main=&grant_mainForm($_GET[sn],"modify");
}else{
        header("location: index.php?type=$type");
}


//�q�X����
head("���U�Ǫ�");
echo $menu;
echo $main;
foot();

//�D�n��J�e��
function &grant_mainForm($sn="",$mode){
        global $school_menu_p,$col_default;

        if($mode=="modify" and !empty($sn)){
                $dbData=get_grant_data($sn);
        }

        if(is_array($dbData) and sizeof($dbData)>0){
                foreach($dbData as $a=>$b){
                        $DBV[$a]=(!is_null($b))?$b:$col_default[$a];
                }
        }else{
                $DBV=$col_default;
        }

        $submit=($mode=="modify")?"update":"insert";

        //�����\���
        $tool_bar=&make_menu($school_menu_p);

        $main="
        <table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0'>
        <form action='$_SERVER[PHP_SELF]' method='post'>

        <tr bgcolor='#FFFFFF'>
        <td>�Ǵ��O</td>
        <td><input type='text' name='data[year_seme]' value='$DBV[year_seme]' size='6' maxlength='6'></td>
        </tr>

        <tr bgcolor='#FFFFFF'>
        <td>���y�y����</td>
        <td><input type='text' name='data[student_sn]' value='$DBV[student_sn]' size='10' maxlength='10'></td>
        </tr>

        <tr bgcolor='#FFFFFF'>
        <td>�Z�Ůy��</td>
        <td><input type='text' name='data[class_num]' value='$DBV[class_num]' size='6' maxlength='10'></td>
        </tr>

        <tr bgcolor='#FFFFFF'>
        <td>���B</td>
        <td><input type='text' name='data[dollar]' value='$DBV[dollar]' size='10' maxlength='10'></td>
        </tr>


        </table>
        <input type='hidden' name='sn' value='$sn'>
        <input type='hidden' name='work_year_seme' value='$DBV[year_seme]'>
        <input type='hidden' name='act' value='$submit'>
        <input type='submit' value='�e�X'>
        </form>

        <a href='index.php?work_year_seme=$DBV[year_seme]'>�^��~�׬����C��</a>
        ";
        return $main;
}

//��s
function grant_update($data,$sn){
        global $CONN;

        $sql_update = "update grant_aid set year_seme='$data[year_seme]',student_sn='$data[student_sn]',dollar='$data[dollar]' where sn='$sn'";
        $CONN->Execute($sql_update) or user_error("��s���ѡI<br>$sql_update",256);
        return $sn;
}

//�R��
function grant_del($sn=""){
        global $CONN;
        $sql_delete = "delete from grant_aid where sn=$sn";
        $CONN->Execute($sql_delete) or user_error("�R�����ѡI<br>$sql_delete",256);
        return true;
}

//���o�Y�@�����
function get_grant_data($sn){
        global $CONN;
        $sql_select="select year_seme,student_sn,class_num,dollar,sn from grant_aid where sn='$sn'";
        $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
        $theData=$recordSet->FetchRow();
        return $theData;
}


?>