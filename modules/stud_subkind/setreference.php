<?php
// $Id: setreference.php 8561 2015-10-14 02:36:14Z infodaes $
include_once "config.php";
sfs_check();
//�q�X����
head("���ѷӳ]�w");

//�ؼШ���t_id
$type_id=($_REQUEST[type_id]);
if($type_id=='') $type_id='1';

//��V������
$linkstr="type_id=$type_id";
echo print_menu($MENU_P,$linkstr);

//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_num = $row["class_num"];

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];

if( checkid($SCRIPT_FILENAME,1) OR $class_num) {


$can_edit=true;
if($class_num and !checkid($SCRIPT_FILENAME,1) ) { $m_arr = get_sfs_module_set("stud_subkind"); if($m_arr['set_ref']<>'Y') $can_edit=false; }

if($can_edit){
$clan_title=$_POST[clan_title];
$area_title=$_POST[area_title];
$memo_title=$_POST[memo_title];
$note_title=$_POST[note_title];
$ext1_title=$_POST[ext1_title];
$ext2_title=$_POST[ext2_title];
$clan=$_POST[clan];
$area=$_POST[area];
$memo=$_POST[memo];
$note=$_POST[note];
$ext1=$_POST[ext1];
$ext2=$_POST[ext2];



if($clan)
{
   //������Ӫ����
   $replace_Sql="REPLACE stud_subkind_ref(type_id,clan_title,area_title,memo_title,note_title,ext1_title,ext2_title,clan,area,memo,note,ext1,ext2) VALUES ('$type_id','$clan_title','$area_title','$memo_title','$note_title','$ext1_title','$ext2_title','$clan','$area','$memo','$note','$ext1','$ext2')";
   $recordSetYear=$CONN->Execute($replace_Sql) or user_error("�g�J���ѡI<br>$replace_Sql",256);
   $updatetime=date('m-d h:m:s');
   echo "\n<script language=\"Javascript\"> alert (\"$updatetime �w�g�N�ѷӳ]�w��s !!'\")</script>";
}


//���o�ǥͨ����C��
$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";

$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
while (list($d_id,$t_name)=$recordSet->FetchRow()) {
        if ($type_id==$d_id)
                $typedata.="<option value='$d_id' selected>($d_id)$t_name</option>";
        else
                $typedata.="<option value='$d_id'>($d_id)$t_name</option>";
}


//���o�ѷӸ��
$type_select="SELECT * FROM stud_subkind_ref WHERE type_id='$type_id'";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$data=$recordSet->FetchRow();
$listdata.="<table width='100%' cellspacing='1' cellpadding='3' bgcolor='#FFCCCC'>
<form name=\"sel_stud_kind\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
<tr>
<td><img border='0' src='images/pin.gif'>�ǥͨ����G<select name='type_id' onchange='this.form.submit()'>$typedata</select>�@
</td></tr>
</form></table>
             <table border=1 cellspacing='1' cellpadding='3' bordercolor='#CCCCFF'>
             <form name=\"clan\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
             <tr bgcolor='#CCCCFF'>
             <td><input type='text' name='clan_title' value='$data[clan_title]'></td>
             <td><input type='text' name='area_title' value='$data[area_title]'></td>
             <td><input type='text' name='memo_title' value='$data[memo_title]'></td>
             <td><input type='text' name='note_title' value='$data[note_title]'></td>
			 <td><input type='text' name='ext1_title' value='$data[ext1_title]'></td>
			 <td><input type='text' name='ext2_title' value='$data[ext2_title]'></td>
             </tr>";
$listdata.="<tr>
         <td><textarea rows=15 name='clan' cols='20'>$data[clan]</textarea></td>
         <td><textarea rows=15 name='area' cols='20'>$data[area]</textarea></td>
         <td><textarea rows=15 name='memo' cols='20'>$data[memo]</textarea></td>
         <td><textarea rows=15 name='note' cols='20'>$data[note]</textarea></td>
		 <td><textarea rows=15 name='ext1' cols='20'>$data[ext1]</textarea></td>
		 <td><textarea rows=15 name='ext2' cols='20'>$data[ext2]</textarea></td>
         </tr>";
$listdata.="<tr><td colspan=6><center><input type='hidden' name='type_id' value='$type_id'>
<input type='submit' value='���g�J' name='replace'>
<input type='reset' value='�^�_���' name='recover'>
�@�@�@<center></td></tr>
</form></table>";
echo $listdata;

} else { echo "<center><BR><BR><h2><a href='setsubkind.php?type_id=$type_id'>�t�κ޲z��<BR><BR>�å��}��Z�žɮv�i�H�]�w�ѷӿ��!</a></h2></center>"; }

} else { echo "<h2><center><BR><BR><font color=#FF0000>�z�å��Q���v�ϥΦ��Ҳ�(�D�ɮv�μҲպ޲z��)</font></center></h2>"; } 
foot();
?>