<?php

// $Id: home_count.php 7711 2013-10-23 13:07:37Z smallduh $

include "config.php";
//���o��ܾǦ~�פξǴ��A�p:0921
$select_year_seme=$_POST["select_year_seme"];

$year=get_curr_year($select_year_seme);//���o��ܤ��Ǧ~�A�p92
$semester=get_curr_seme($select_year_seme);//���o��ܤ��Ǵ��A�p1

if(empty($year))$year=curr_year();//�w�]�����~��
if(empty($semester))$semester=curr_seme();//�w�]�����Ǵ�

//echo "ys=".$select_year_seme."<br>"."y=".$year."<br>"."s=".$semester;

if (!empty($_POST["look"])) save_csv($year,$semester);//��y�e�X���

head("�a�x���p�έp");

//�C�X�έp

$main=list_class_stu($year,$semester);
echo $main  ;

foot();
//�C�X�Ҧ��Z�Ū����
function list_class_stu($year,$semester){
	global $menu_p,$CONN ,$school_kind_name ,$class_year;
	$toolbar=&make_menu($menu_p);

        //���U�ϥ�select_yearseme_form ��ܾǦ~�׾Ǵ��U�Կ��
        $select_yearseme_form="<form method='post' action='".basename($_SERVER["PHP_SELF"])."'>";
        $class_seme_p = get_class_seme(); //�Ǧ~��
        $upstr = "<select name='select_year_seme' onchange='this.form.submit()'>";
        while (list($tid,$tname)=each($class_seme_p)){
        	if ((strlen($year.$semester)==3 and $tid=="0".$year.$semester) or (strlen($year.$semester)==4 and $tid==$year.$semester))
              		$upstr .= "<option value='".$tid."' selected>".$tname."</option>";//$tid�p"0921"
              	else
              		$upstr .= "<option value='".$tid."'>".$tname."</option>";
        }
        $upstr .= "</select><br>";
        $select_yearseme_form.= $upstr;
        //select_yearseme_form ����

        //�U����ƫ��s
        $download_data.="<form method='post' action='".basename($_SERVER["PHP_SELF"])."'>";
        $download_data.="<input type='submit' name='look' value='�U���ԲӸ��(xls)'></form>";

        if (strlen($year)==2)//�N��ܦ~���ন0921�榡
        $select_year_seme="0".$year.$semester;
          else
           $select_year_seme=$year.$semester;

        //��X�a�x����
        $record_home=SFS_TEXT("�a�x����");

        $title1.="<table border=1 cellspacing=0><tr bgcolor=yellow><td>�~��</td><td>�ʧO</td>";
        //��X�~�Ųέp
        reset($record_home);
        //�}�l�q�X���(�a�x����)
        while ($array_home = each($record_home)) {
              $title1.="<td width='60' align='center'>".$array_home[value]."</td>";
        }
        $title1.="</tr>";

	$sql_select = "select DISTINCT c_year from school_class where year='$year' and semester='$semester' order by c_year,c_sort";
	$record_year_class=$CONN->Execute($sql_select) or die($sql_select);
        while ($array_class = $record_year_class->FetchRow()) {
              reset($record_home);
              $title1.="<tr align='center'><td>".$class_year[$array_class[c_year]]."</td><td>�k</td>";
              while ($array_home = each($record_home)) {
                      //�q�Z�Ū���X��~�רk�ʾǥͮy��
                      $sql_select="select b.stud_id from stud_base a, stud_seme b where a.student_sn=b.student_sn and a.stud_sex='1'and a.stud_study_cond=0 and b.seme_year_seme='$select_year_seme' and substring(b.seme_class,1,1)='$array_class[c_year]'";
                      $record_class_st=$CONN->Execute($sql_select) or die($sql_select);
                      $count_st=0;
                      //�}�l���òέp�H��
                      while ($array_student = $record_class_st->FetchRow()) {
                            $sql_select="select * from stud_seme_eduh where seme_year_seme='$select_year_seme' and stud_id='$array_student[stud_id]' and sse_family_kind='$array_home[key]'";
                            $record_select=$CONN->Execute($sql_select) or die($sql_select);
                            if ($record_select->RecordCount()!=0) $count_st++;
                      }
                      $all_boy[$array_home[key]]+=$count_st;//�k�ͤp�p
                      $title1.="<td>".$count_st."</td>";
              }
              $title1.="</tr>";
              $title1.="<tr align='center'><td>".$class_year[$array_class[c_year]]."</td><td>�k</td>";
              reset($record_home);
              while ($array_home = each($record_home)) {
                      //�q�Z�Ū���X��~�פk�ʾǥͮy��
                      $sql_select="select b.stud_id from stud_base a, stud_seme b where a.student_sn=b.student_sn and a.stud_sex='2' and a.stud_study_cond=0 and b.seme_year_seme='$select_year_seme' and substring(b.seme_class,1,1)='$array_class[c_year]'";
                      $record_class_st=$CONN->Execute($sql_select) or die($sql_select);
                      $count_st=0;
                      //�}�l���òέp�H��
                      while ($array_student = $record_class_st->FetchRow()) {
                            $sql_select="select * from stud_seme_eduh where seme_year_seme='$select_year_seme' and stud_id='$array_student[stud_id]' and sse_family_kind='$array_home[key]'";
                            $record_select=$CONN->Execute($sql_select) or die($sql_select);
                            if ($record_select->RecordCount()!=0) $count_st++;
                      }
                      $all_girl[$array_home[key]]+=$count_st;//�k�ͤp�p
                      $title1.="<td>".$count_st."</td>";
              }
        }
        //�C�X���ըk�k�Ͳέp���G(���a�x�`��)
        $title1.="</tr><tr align='center'><td rowspan='2'>����</td><td>�k</td>";
        reset($all_boy);
        while(list($id,$val)=each($all_boy)){
             $title1.="<td>$val</td>";
             $all[$id]+=$val;
        }
        $title1.="</tr><tr align='center'><td>�k</td>";
        reset($all_girl);
        while(list($id,$val)=each($all_girl)){
             $title1.="<td>$val</td>";
             $all[$id]+=$val;
        }
        reset($all);
        $title1.="</tr><tr align='center' bgcolor='#bb8833'><td colspan='2'>�X�p</td>";
        while(list($id,$val)=each($all)){
             $title1.="<td>$val</td>";
        }

        $title1.="</tr></table>";
	$main="$toolbar";

	$help_text="
	���{���D�n�̾ھǥͤ�[�Ǵ�����]��[�a�x����]��쬰�����έp���̾ڡC||���U���ԲӸ�ơA�i���o��h��T�C||�U���ɮפ�[�a�x���p]���ȡA�Y�̾ھǥ�[���ɳX��]��Ƥ��A�M��[�p���ƶ�]���H[�q��]�G�r�}�Y���ӵ��X�ͬ������e�ҦC�C�Y�Ӿǥ�[�X�ͬ���]�å���������ơA�h�����ȯd�šC";
	$help=&help($help_text);
	$main.=$help;

	$main.="<table><tr><td width='40%'>$select_yearseme_form</td><td>$download_data</td></tr></table>";
        $main.=$title1;
        
	return $main;
}


function save_csv($year,$semester){
       	global $CONN;
        $select_year_seme=(strlen($year.$semester)==4) ? $year.$semester : "0".$year.$semester;//�]�w���j�M���Ǧ~�פξǴ�

        //��X��ܦ~�׾Ǵ����Z��
	$sql_select = "select c_year,class_id,c_name,c_sort from school_class where year='$year' and semester='$semester' order by c_year,c_sort";
	$record_year_class=$CONN->Execute($sql_select) or die($sql_select);
        $num_class=$record_year_class->RecordCount();//�Z�Ťp�p
        if ($num_class<1){
           echo "���~�A�䤣��Z�ų]�w�I";
           exit;
        }
        //��X
   	$filename="home_".$select_year_seme.".xls";
    	header("Content-disposition: filename=$filename");
    	header("Content-type: application/octetstream");
    	//header("Content-type: application/octetstream");
    	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
    	header("Expires: 0");


        //�q�X�U�Z�ŦX���
        echo "<table border='1'><tr><td colspan='15'>";
        echo $year."�~�� ��".$semester."�Ǵ� �ǥͮa�x�������Y��Ƥ@��</td></tr>";
        echo "<tr>";
        echo "<td>�~</td><td>�Z</td><td>�Z��</td><td>�Ǹ�</td><td>�y��</td><td>�m�W</td><td>�ʧO</td><td>�������Y</td><td>�a�x����</td><td>�a�x��^</td><td>���ޱФ覡</td><td>���ޱФ覡</td><td>�~����</td><td>�g�٪��p</td><td>��L�ʺ|</td><td>�a�x���p</td></tr>";
        while ($array_class = $record_year_class->FetchRow()) {
              //�D�X�ŦX���
              if (strlen($year)==2)//�N��ܦ~���ন0921�榡
                 $select_year_seme="0".$year.$semester;
                else
                 $select_year_seme=$year.$semester;
              if (strlen($array_class[c_sort])==1)//�N�Z���ন701�榡
                 $select_class=$array_class[c_year]."0".$array_class[c_sort];
                else
                 $select_class=$array_class[c_year].$array_class[c_sort];
              //�q�Z�Ū���X��~�׸ӯZ�ǥ͸��
              $sql_select="select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_num from stud_base a, stud_seme b where a.student_sn=b.student_sn and a.stud_study_cond=0 and b.seme_year_seme='$select_year_seme' and b.seme_class='$select_class'";
              $record_class_st=$CONN->Execute($sql_select) or die($sql_select);
              //�}�l���a�x���p����
              while ($array_student = $record_class_st->FetchRow()) {
                    //�e�X���
                    $array_class[c_year]=($array_class[c_year]>6)?$array_class[c_year]-6:$array_class[c_year];
                    echo "<tr>";
                    echo "<td>$array_class[c_year]</td><td>$array_class[c_name]</td><td>$array_class[c_year]".substr(strrchr($array_class[class_id],"_"),1)."</td>";
                    echo "<td>$array_student[stud_id]</td><td>$array_student[seme_num]</td><td>$array_student[stud_name]</td>";
                    if ($array_student[stud_sex]==1) echo "<td>�k</td>";
                      else echo "<td>�k</td>";
                    $sql_select="select * from stud_seme_eduh where seme_year_seme='$select_year_seme' and stud_id='$array_student[stud_id]'";
                    $record_select=$CONN->Execute($sql_select) or die($sql_select);
                    //���ǥͮa�x����
                    $f_flag=0;//�M��аO
                    while ($array_stud=$record_select->FetchRow()){
                          echo "<td>".get_sfs_text("�������Y",$array_stud[sse_relation])."</td>";
                          echo "<td>".get_sfs_text("�a�x����",$array_stud[sse_family_kind])."</td>";
                          echo "<td>".get_sfs_text("�a�x��^",$array_stud[sse_family_air])."</td>";
                          echo "<td>".get_sfs_text("�ޱФ覡",$array_stud[sse_farther])."</td>";
                          echo "<td>".get_sfs_text("�ޱФ覡",$array_stud[sse_mother])."</td>";
                          echo "<td>".get_sfs_text("�~����",$array_stud[sse_live_state])."</td>";
                          echo "<td>".get_sfs_text("�g�٪��p",$array_stud[sse_rich_state])."</td>";
                          $nothing="";
                          if ($array_stud[sse_s1]=="") $nothing.="*�̳߷R���";
                          if ($array_stud[sse_s2]=="") $nothing.="*�̧x�����";
                          if ($array_stud[sse_s3]=="") $nothing.="*�S��~��";
                          if ($array_stud[sse_s4]=="") $nothing.="*����";
                          if ($array_stud[sse_s5]=="") $nothing.="*�ͬ��ߺD";
                          if ($array_stud[sse_s6]=="") $nothing.="*�H�����Y";
                          if ($array_stud[sse_s7]=="") $nothing.="*�~�V�欰";
                          if ($array_stud[sse_s8]=="") $nothing.="*���V�欰";
                          if ($array_stud[sse_s9]=="") $nothing.="*�ǲߦ欰";
                          if ($array_stud[sse_s10]=="") $nothing.="*���}�ߺD";
                          if ($array_stud[sse_s11]=="") $nothing.="*�J�{�欰";
                          echo "<td>".$nothing."</td>";
                          $f_flag=1;
                    }
                   if ($f_flag==0) echo "<td></td><td></td><td></td><td></td><td></td><td><td></td></td><td></td>";
                   
                   $sql_select="select sst_memo from stud_seme_talk where seme_year_seme + 90 ".">"." '$select_year_seme' and stud_id='$array_student[stud_id]' and sst_main like '�q��%'";
                   $record_talk=$CONN->Execute($sql_select) or die($sql_select);
                   //�q�X�ͬ��������ǥͮa�x���p
                   $f_flag=0;//�M��аO
                   while ($array_talk=$record_talk->FetchRow()){
                         echo "<td>$array_talk[sst_memo]</td>";
                         $f_flag=1;
                   }
                   if ($f_flag==0) echo "<td></td>";
                   echo "</tr>";
              }
        }     echo "</table>";
	exit;
}


?>
