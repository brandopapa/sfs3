<?php
// $Id: setsubkind.php 8561 2015-10-14 02:36:14Z infodaes $

include_once "config.php";
//include_once "../../include/sfs_case_dataarray.php";
sfs_check();
//�q�X����
head("���O�ݩʳ]�w");

//�ؼШ���t_id
$type_id=($_REQUEST[type_id]);
if($type_id=='') $type_id='1';

//��V������
$linkstr="type_id=$type_id";
echo print_menu($MENU_P,$linkstr);

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];


//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_num = $row["class_num"];

if( checkid($SCRIPT_FILENAME,1) OR $class_num) {


//�]�w��k
$setmethod=($_POST[setbycombo]);

if($setmethod) $setmethod='checked';

//post�W�ӭn��s�����
$clandata=$_POST[clandata];
$areadata=$_POST[areadata];
$memodata=$_POST[memodata];
$notedata=$_POST[notedata];
$ext1data=$_POST[ext1data];
$ext2data=$_POST[ext2data];

if($clandata)
{
   //������Ӫ����
   foreach($clandata as $key=>$value) {
           if($value) { $data.="($key,'$value','$areadata[$key]','$memodata[$key]','$notedata[$key]','$ext1data[$key]','$ext2data[$key]','$type_id'),"; }
           }
   $data=str_replace(chr(13),'',substr($data,0,-1));
   //echo $data;
   $replace_Sql="REPLACE stud_subkind(student_sn,clan,area,memo,note,ext1,ext2,type_id) VALUES $data";
   $recordSetYear=$CONN->Execute($replace_Sql) or user_error("�g�J���ѡI<br>$replace_Sql",256);
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

//�Ǵ��O
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());


//���o�ǥͤl�������O�M����
$type_select="SELECT * FROM stud_subkind_ref WHERE type_id='$type_id'";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$sunkind_data=$recordSet->FetchRow();

$clan_title=$sunkind_data[clan_title];
$area_title=$sunkind_data[area_title];
$memo_title=$sunkind_data[memo_title];
$note_title=$sunkind_data[note_title];
$ext1_title=$sunkind_data[ext1_title];
$ext2_title=$sunkind_data[ext2_title];

$clan_list=explode("\r\n",$sunkind_data[clan]);
$area_list=explode("\r\n",$sunkind_data[area]);
$memo_list=explode("\r\n",$sunkind_data[memo]);
$note_list=explode("\r\n",$sunkind_data[note]);
$ext1_list=explode("\r\n",$sunkind_data[ext1]);
$ext2_list=explode("\r\n",$sunkind_data[ext2]);


// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);

//���o���O �ǥ͸��
/*
$type_select="SELECT a.student_sn,left(a.curr_class_num,length(a.curr_class_num)-2) as class_id,a.stud_id,a.stud_name,b.clan,b.area,b.memo,b.note FROM stud_base a left join stud_subkind b on a.student_sn=b.student_sn WHERE a.stud_study_cond=0";
$type_select.=($class_num<>'')?" and a.curr_class_num like '$class_num%'":"";
$type_select.=" and a.stud_kind like '%,$type_id,%' AND (b.type_id = '$type_id' OR isnull(b.type_id)) order by a.curr_class_num";

echo $type_select;
*/
//�令���ⶥ�q�^�����

//�Ĥ@���q----���Xstud_base�X�G���ǥ�
$type_select="SELECT student_sn,left(curr_class_num,length(curr_class_num)-2) as class_id,stud_id,stud_name FROM stud_base WHERE stud_study_cond=0 AND stud_kind like '%,$type_id,%'";
$type_select.=(!checkid($SCRIPT_FILENAME,1) AND $class_num<>'')?" AND curr_class_num like '$class_num%'":"";
$type_select.=" ORDER BY curr_class_num";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);

$row_count=$recordSet->RecordCount();

if($row_count<>0)
{
//�Nstudent_sn�ন�}�C�r��
$select_sn='';
while ($data=$recordSet->FetchRow()) {
          $select_sn.=$data['student_sn'].",";
          $stud_data[$data['student_sn']]['class_id']=$data['class_id'];
          $stud_data[$data['student_sn']]['stud_id']=$data['stud_id'];
          $stud_data[$data['student_sn']]['stud_name']=$data['stud_name'];
          }
$select_sn=substr($select_sn,0,-1);

//�ĤG���q----���Xstud_subkind����
$type_select="SELECT * FROM stud_subkind WHERE type_id='$type_id' AND student_sn IN ($select_sn)";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);

//�N��ƥ[�J$stud_data�}�C��
while ($data=$recordSet->FetchRow()) {
          $stud_data[$data['student_sn']]['clan']=$data['clan'];
          $stud_data[$data['student_sn']]['area']=$data['area'];
          $stud_data[$data['student_sn']]['memo']=$data['memo'];
          $stud_data[$data['student_sn']]['note']=$data['note'];
		  $stud_data[$data['student_sn']]['ext1']=$data['ext1'];
		  $stud_data[$data['student_sn']]['ext2']=$data['ext2'];
          }
}
//�O�_�}��ɮv�i�H�ۥѿ�J�ݩ�
$m_arr = get_sfs_module_set("stud_subkind");
if($class_num) {  if($m_arr['free_input']='Y') $free_input=''; else $free_input='disabled'; }

$listdata.="<table width='100%' cellspacing='1' cellpadding='3' bgcolor='#FFCCCC'>
             <form name=\"sel_stud_kind\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
             <tr>
             <td><img border='0' src='images/pin.gif'>�ǥͨ����G<select name='type_id' onchange='this.form.submit()'>$typedata</select>�@<input type='checkbox' name='setbycombo' $setmethod onclick='this.form.submit()'>��榡�]�w
             �@</td></tr>
             </form></table>
             <table border=1 cellspacing='1' cellpadding='3' bordercolor='#CCCCFF'>
             <form name=\"clan\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
             <tr bgcolor='#CCCCFF'>
             <td>NO.</td>
             <td>�NŪ�Z��</td>
             <td>�Ǹ�</td>
             <td>�m�W</td>
             <td>$clan_title</td>
             <td>$area_title</td>
             <td>$memo_title</td>
             <td>$note_title</td>
			 <td>$ext1_title</td>
			 <td>$ext2_title</td>
             </tr>";
$sn_data=explode(',',$select_sn);
for($k=0;$k<$row_count;$k++)
{
if($setmethod){
         $clandata="<select name='clandata[$sn_data[$k]]'>";
         $areadata="<select name='areadata[$sn_data[$k]]'>";
         $memodata="<select name='memodata[$sn_data[$k]]'>";
         $notedata="<select name='notedata[$sn_data[$k]]'>";
		 $ext1data="<select name='ext1data[$sn_data[$k]]'>";
		 $ext2data="<select name='ext2data[$sn_data[$k]]'>";
         for($i=0;$i<=count($clan_list);$i++){
                 if ($stud_data[($sn_data[$k])][clan]==$clan_list[$i])
                     $clandata.="<option value='$clan_list[$i]' selected>$clan_list[$i]</option>";
                 else $clandata.="<option value='$clan_list[$i]'>$clan_list[$i]</option>";
                 }
         for($i=0;$i<=count($area_list);$i++){
                 if ($stud_data[($sn_data[$k])][area]==$area_list[$i])
                     $areadata.="<option value='$area_list[$i]' selected>$area_list[$i]</option>";
                 else $areadata.="<option value='$area_list[$i]'>$area_list[$i]</option>";
                 }
         for($i=0;$i<=count($memo_list);$i++){
                 if ($stud_data[($sn_data[$k])][memo]==$memo_list[$i])
                     $memodata.="<option value='$memo_list[$i]' selected>$memo_list[$i]</option>";
                 else $memodata.="<option value='$memo_list[$i]'>$memo_list[$i]</option>";
                 }
         for($i=0;$i<=count($note_list);$i++){
                 if ($stud_data[($sn_data[$k])][note]==$note_list[$i])
                     $notedata.="<option value='$note_list[$i]' selected>$note_list[$i]</option>";
                 else $notedata.="<option value='$note_list[$i]'>$note_list[$i]</option>";
                 }
		  for($i=0;$i<=count($ext1_list);$i++){
                 if ($stud_data[($sn_data[$k])][ext1]==$ext1_list[$i])
                     $ext1data.="<option value='$ext1_list[$i]' selected>$ext1_list[$i]</option>";
                 else $ext1data.="<option value='$ext1_list[$i]'>$ext1_list[$i]</option>";
                 }
		for($i=0;$i<=count($ext2_list);$i++){
                 if ($stud_data[($sn_data[$k])][ext2]==$ext2_list[$i])
                     $ext2data.="<option value='$ext2_list[$i]' selected>$ext2_list[$i]</option>";
                 else $ext2data.="<option value='$ext2_list[$i]'>$ext2_list[$i]</option>";
                 }
         $clandata.="</select>";
         $areadata.="</select>";
         $memodata.="</select>";
         $notedata.="</select>";
		 $ext1data.="</select>";
		 $ext2data.="</select>";
} else {
         $clandata="<input type='text' name='clandata[$sn_data[$k]]' size='15' value='".$stud_data[($sn_data[$k])][clan]."'>";
         $areadata="<input type='text' name='areadata[$sn_data[$k]]' size='15' value='".$stud_data[($sn_data[$k])][area]."'>";
         $memodata="<input type='text' name='memodata[$sn_data[$k]]' size='15' value='".$stud_data[($sn_data[$k])][memo]."'>";
         $notedata="<input type='text' name='notedata[$sn_data[$k]]' size='15' value='".$stud_data[($sn_data[$k])][note]."'>";
		 $ext1data="<input type='text' name='ext1data[$sn_data[$k]]' size='15' value='".$stud_data[($sn_data[$k])][ext1]."'>";
		 $ext2data="<input type='text' name='ext2data[$sn_data[$k]]' size='15' value='".$stud_data[($sn_data[$k])][ext2]."'>";
}
         $class_id=$stud_data[($sn_data[$k])]['class_id'];
         $class_name=$class_base[$class_id];

         $listdata.="<tr>
         <td>".($k+1)."</td>
         <td>$class_name</td>
         <td>".$stud_data[$sn_data[$k]][stud_id]."</td>
         <td>".$stud_data[$sn_data[$k]][stud_name]."</td>
         <td>$clandata</td>
         <td>$areadata</td>
         <td>$memodata</td>
         <td>$notedata</td>
		 <td>$ext1data</td>
		 <td>$ext2data</td>
         </tr>";

}
$listdata.="<tr><td colspan=8><center><BR><center><BR><input type='hidden' name='type_id' value='$type_id'>
<input type='submit' value='���g�J' name='replace'>
<input type='reset' value='�^�_���' name='recover'>
�@�@�@</center></td></tr>
</form></table>";
echo $listdata;

} else { echo "<h2><center><BR><BR><font color=#FF0000>�z�å��Q���v�ϥΦ��Ҳ�(�D�ɮv�μҲպ޲z��)</font></center></h2>"; } 

foot();
?>