<?php
// $Id: set_clan.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

$clandata=$_POST[clandata];
$clanarea=$_POST[clanarea];

if($clandata)
{
   //������Ӫ����
   foreach($clandata as $key=>$value) {
           if($value) { $data.="($key,'$value','".$clanarea[$key]."',$type_id),"; }
           }
   $data=substr($data,0,-1);
   //echo $data;
   $replace_Sql="REPLACE stud_subkind(student_sn,clan,area,type_id) VALUES $data";
   $recordSetYear=$CONN->Execute($replace_Sql) or user_error("�g�J���ѡI<br>$replace_Sql",256);

   //header("Location: index.php?type=$type'");
}

//�q�X����
head("�]�w[$keyword]���O");
echo $menu;

// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);

//���o���O �ǥ͸��
$type_select="SELECT a.student_sn,left(a.curr_class_num,length(a.curr_class_num)-2) as class_id,a.stud_id,a.stud_name,b.clan,b.area FROM stud_base a left join stud_subkind b on a.student_sn=b.student_sn WHERE a.stud_study_cond=0 and a.stud_kind like '%,$type_id,%' order by a.curr_class_num";

$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$listdata.="<table border=1 cellspacing='1' cellpadding='3' bordercolor=$hint_color>
             <form name=\"clan\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
             <tr bgcolor=$hint_color>
             <td>�y����</td>
             <td>�NŪ�Z��</td>
             <td>�Ǹ�</td>
             <td>�m�W</td>
             <td>$clan_list_title</td>
             <td>$clan_area_title</td>
             </tr>";
while ($data=$recordSet->FetchRow()) {
         $clandata="<select name='clandata[$data[student_sn]]'>";
         $clanarea="<select name='clanarea[$data[student_sn]]'>";;
         for($i=0;$i<=count($clan_list);$i++){
                 if ($data[clan]==$clan_list[$i])
                     $clandata.="<option value='$clan_list[$i]' selected>$clan_list[$i]</option>";
                 else $clandata.="<option value='$clan_list[$i]'>$clan_list[$i]</option>";
                 }
         for($i=0;$i<=count($clan_area);$i++){
                 if ($data[area]==$clan_area[$i])
                     $clanarea.="<option value='$clan_area[$i]' selected>$clan_area[$i]</option>";
                 else $clanarea.="<option value='$clan_area[$i]'>$clan_area[$i]</option>";
                 }
         $clandata.="</select>";
         $clanarea.="</select>";

         $class_name=$class_base[$data[class_id]];

         $listdata.="<tr>
         <td>$data[student_sn]</td>
         <td>$class_name</td>
         <td>$data[stud_id]</td>
         <td>$data[stud_name]</td>
         <td>$clandata</td>
         <td>$clanarea</td>
         </tr>";

}
$listdata.="<tr><td colspan=6><center><BR><input type='hidden' name='type' value='$type'>
<input type='submit' value='���g�J' name='replace'>
<input type='reset' value='�^�_���' name='recover'>
�@�@�@<a href='index.php?type=$type'><img border='0' src='images/back.gif'> �^�W�@��</a><center></td></tr>
</form></table>";
echo $listdata;

foot();
?>