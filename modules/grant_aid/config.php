<?php
//$Id: config.php 5310 2009-01-10 07:57:56Z hami $
//�w�]���ޤJ�ɡA���i�����C
include_once "./module-cfg.php";
include_once "../../include/config.php";
include_once "../../include/sfs_case_dataarray.php";

// 0.�W��  1.��ܩ���  2.�L��M�U�B�z�{��  3.�ӽЪ�B�z�{��  4.csv�榡��X  5.����r  6.�w�]���B ��7.�w�]type_id
$menudata = array (
  array("�����ǥζO","#FFCCCC","html_export.php","ask_export.php","csv_export.php","����",400,9)
 ,array("�������Ǫ�","#CCFFCC","html_export2.php","ask_export2.php","csv_export.php","����",2000,9)
 ,array("�ǲ��U�Ǫ�","#FFFFAA","html_export3.php","ask_export3.php","csv_export.php","�C���J",2000,3)
 ,array("�M�H���Ǫ�","#CCCCFF","html_export4.php","ask_export4.php","csv_export.php","�C���J",800,3)
 );

//���o�����l�O�w�q
//$type_menu=stud_clan();

//���U���O
$type=($_REQUEST[type]);
if($type=="") $type=$menudata[0][0];

for($i=0; $i<=count($menudata)-1;$i++)
{
        if($type==$menudata[$i][0]) {
                $menu_id=$i;
                $hint_color=$menudata[$i][1];
                $keyword=$menudata[$i][5];
                $dollars=$menudata[$i][6];
                $type_id=$menudata[$i][7];


                //���o�ǥͤl�������O�M����
                $type_select="SELECT * FROM stud_subkind_ref WHERE type_id='$type_id'";
                $recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
                $sunkind_data=$recordSet->FetchRow();

                $clan_title=$sunkind_data[clan_title];
                $area_title=$sunkind_data[area_title];
                $memo_title=$sunkind_data[memo_title];
                $note_title=$sunkind_data[note_title];

                $clan_list=explode("\n",$sunkind_data[clan]);
                $area_list=explode("\n",$sunkind_data[area]);
                $memo_list=explode("\n",$sunkind_data[memo]);
                $note_list=explode("\n",$sunkind_data[note]);

                $clan_list=$type_menu[$type_id][$clan_list_title];
                $area_lis=$type_menu[$type_id][$clan_area_title];
                }

        $menu.="<td bgcolor=".$menudata[$i][1]."><font face='�з���'><a href='./index.php?type=".$menudata[$i][0]."'>".$menudata[$i][0]."</a></td>";
        }
$menu="<table border=0 cellspacing=0 cellpadding=5><tr>".$menu."</tr></table>";

?>