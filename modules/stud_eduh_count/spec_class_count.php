<?php
// $Id: spec_class_count.php 8683 2015-12-25 03:01:02Z qfon $

include "config.php";

//���o��ܱ���
$select_year_seme=$_POST["select_year_seme"];//�Ǧ~��
$year=get_curr_year($select_year_seme);//���o��ܤ��Ǧ~�A�p92
$semester=get_curr_seme($select_year_seme);//���o��ܤ��Ǵ��A�p1
if(empty($year))$year=curr_year();//�w�]�����~��
if(empty($semester))$semester=curr_seme();//�w�]�����Ǵ�

$stud_spe_kind=$_POST["stud_spe_kind"];//���o�S��Z���O
if(empty($stud_spe_kind)){
  $stud_spe_kind=0;
  $show_word="���O�G����";
}
  else{
  $spe_kind=stud_spe_kind();
  $show_word="���O�G".$spe_kind[$stud_spe_kind];
  }
$stud_spe_class_kind=$_POST["stud_spe_class_kind"];//���o�S��Z�Z�O
if(empty($stud_spe_class_kind)){
  $stud_spe_class_kind=0;
  $show_word.="�@�@�Z�O�G����";
}
else{
  $spe_class_kind=stud_spe_class_kind();
  $show_word.="�@�@�Z�O�G".$spe_class_kind[$stud_spe_class_kind];
}


//�̱���]�w�M��������r

$find_spe="";
if ($stud_spe_kind>0)
   $find_spe.=" and stud_spe_kind='".intval($stud_spe_kind)."'";
if ($stud_spe_class_kind>0)
   $find_spe.=" and stud_spe_class_kind='".intval($stud_spe_class_kind)."'";
/*
if ($stud_spe_class_kind==0)//�M�w�O�_�n�M��S��Z�Z�O
   $find_spe="a.stud_spe_kind='$stud_spe_kind'";//��
  else
   $find_spe="a.stud_spe_kind='$stud_spe_kind' and a.stud_spe_class_kind='$stud_spe_class_kind'";//�n
*/

$find_year_seme=sprintf("%03d%d",$year,$semester);//�榡�ƾǴ���4��ơA�p0911

if (!empty($_POST["download"])) save_csv($find_year_seme,$find_spe,$show_word);//��y�e�X���

head("�S��Z�ǥͬd��");

echo make_menu($menu_p);

$help_text="
���{���D�n�̾ھǥͤ�[�򥻸��]��[�S��Z�Z�O]�B[�S��Z���O]��쬰�������̾ڡC";
$help=&help($help_text);
echo $help;

//���

echo "<form method='post' action='".basename($_SERVER["PHP_SELF"])."'>";
echo "<table><tr><td align='center'><font size='2'>�Ǧ~��</font><br>";
        //���U�ϥ�select_year_seme ��ܾǦ~�׾Ǵ��U�Կ��
        $class_seme_p = get_class_seme(); //�Ǧ~��
        echo "<select name='select_year_seme' onchange='this.form.submit()'>";
        while (list($tid,$tname)=each($class_seme_p)){
        	if ($tid=="0".$year.$semester)
              		echo "<option value='".$tid."' selected>".$tname."</option>";//$tid�p"0921"
              	else
              		echo "<option value='".$tid."'>".$tname."</option>";
        }
        echo "</select></td>";
	//�S��Z���O
        echo "<td width='220' align='center'><font size='2'>�S��Z���O(�ťեN����)</font><br>";
	$sel1 = new drop_select(); //������O
	$sel1->s_name = "stud_spe_kind"; //���W��
	$sel1->id = intval($stud_spe_kind);
	$sel1->arr = stud_spe_kind(); //���e�}�C
	$sel1->has_empty =true;
	$sel1->is_submit = true;
	$sel1->do_select();
        echo "</td>";
	//�S��Z�Z�O
        echo "<td align='center'><font size='2'>�S��Z�Z�O(�ťեN����)</font><br>";
	$sel1 = new drop_select(); //������O
	$sel1->s_name = "stud_spe_class_kind"; //���W��
	$sel1->id = intval($stud_spe_class_kind);
	$sel1->arr = stud_spe_class_kind(); //���e�}�C
	$sel1->has_empty =true;
	$sel1->is_submit = true;
	$sel1->do_select();
        echo "</td><tr><td>";
        //�U����ƫ��s
        echo "<input type='submit' name='download' value='�U���ԲӸ��(xls)'></td>";

        echo "</tr></table></form>";

//�}�l�M��
$sql_select = "select a.stud_study_cond ,a.stud_id,a.student_sn ,a.stud_name, a.stud_sex, a.stud_person_id, a.stud_birthday, a.stud_addr_1, a.stud_tel_1, a.stud_tel_2, b.seme_num, b.seme_class from stud_base a, stud_seme b where a.student_sn=b.student_sn $find_spe and b.seme_year_seme='$find_year_seme' order by b.seme_class,b.seme_num";
$record=$CONN->Execute($sql_select) or die($sql_select);
if ($record->RecordCount()<1){
   echo "�䤣���ơA�Э��s�]�w�M�����I";
   exit;
}

$move_kind_arr=study_cond();//����s�W by misser 93.10.20

echo "<font color='blue'>�`�p�ŦX�H�ơG".$record->RecordCount()."�H</font>";
echo "<table border='1' cellpadding='2' cellspacing='0'  bordercolorlight='#333354' bordercolordark='#FFFFFF' width='100%'>";
echo "<tr class='main_body'>";
echo "<td><font size='2'>�Z��</font></td>";
echo "<td><font size='2'>�y��</font></td>";
echo "<td><font size='2'>�m�W</font></td>";
echo "<td><font size='2'>�ʧO</font></td>";
echo "<td><font size='2'>�Ǹ�</font></td>";
echo "<td><font size='2'>�����Ҧr��</font></td>";
echo "<td><font size='2'>����</font></td>";
echo "<td><font size='2'>����</font></td>";
echo "<td><font size='2'>�ͤ�</font></td>";
echo "<td><font size='2'>�a�}</font></td>";
echo "<td><font size='2'>�q��1</font></td>";
echo "<td><font size='2'>�q��2</font></td>";
echo "<td><font size='2'>���p</font></td>";
echo "</tr>";
//�C�X���
while ($array_stud = $record->FetchRow()) {
      $array_stud[seme_class]=(substr($array_stud[seme_class],0,1)>6)?$array_stud[seme_class]=$array_stud[seme_class]-600:$array_stud[seme_class];
      $array_stud[stud_sex]=($array_stud[stud_sex]=='1')?"�k":"�k";
      $parents=find_parents($array_stud[student_sn]);//��X����
      $temp_bgcolor=($temp_bgcolor=="#EFE0ED")?"#ffffff":"#EFE0ED";//���j�ܴ��I���C��
      echo "<tr bgcolor='$temp_bgcolor'>";
      if ($array_stud[stud_study_cond]==0) $temp_color="";
         else $temp_color="color='red'";
      echo "<td><font size='2' ".$temp_color.">$array_stud[seme_class]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[seme_num]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_name]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_sex]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_id]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_person_id]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$parents[0]</font></td>";//����
      echo "<td><font size='2' ".$temp_color.">$parents[1]</font></td>";//����
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_birthday]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_addr_1]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_tel_1]</font></td>";
      echo "<td><font size='2' ".$temp_color.">$array_stud[stud_tel_2]</font></td>";
      echo "<td><font size='2' ".$temp_color.">".$move_kind_arr[$array_stud[stud_study_cond]]."</font></td>";
      echo "</tr>";
}
echo "</tr></table>";

foot();
function find_parents($student_sn,$kind){
	global $CONN ;
        $sql_select = "select fath_name, moth_name from stud_domicile where student_sn='$student_sn'";
        $recordSet=$CONN->Execute($sql_select) or die($sql_select);
        return $recordSet->FetchRow();
}
function save_csv($find_year_seme,$find_spe,$show_word){
       	global $CONN;

        //$select_year_seme=(strlen($year.$semester)==4) ? $year.$semester : "0".$year.$semester;//�]�w���j�M���Ǧ~�פξǴ�
        //��X
   	$filename="spec_".$find_year_seme.".xls";
    	header("Content-disposition: filename=$filename");
    	//header("Content-type: application/octetstream ; Charset=Big5");
    	header("Content-type: application/octetstream");
    	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
    	header("Expires: 0");

        //�}�l�M��
        $sql_select = "select a.stud_study_cond ,a.stud_id,a.student_sn ,a.stud_name, a.stud_sex, a.stud_person_id, a.stud_birthday, a.stud_addr_1, a.stud_tel_1, a.stud_tel_2, b.seme_num, b.seme_class from stud_base a, stud_seme b where a.student_sn=b.student_sn $find_spe and b.seme_year_seme='$find_year_seme' order by b.seme_class,b.seme_num";
        $record=$CONN->Execute($sql_select) or die($sql_select);
        if ($record->RecordCount()<1){
           echo "�䤣���ơA�Э��s�]�w�M�����I";
           exit;
        }

        $move_kind_arr=study_cond();//����s�W by misser 93.10.20

        //�q�X�U�Z�ŦX���
        echo "<table border='1' cellpadding='2' cellspacing='0'  bordercolorlight='#333354' bordercolordark='#FFFFFF' width='100%'>";
        echo "<tr class='main_body'>";
        echo "<td colspan='13'><font color='blue'>".$find_year_seme."�ǥ͸�Ƭd�ߡG</font>";
        echo $show_word;
        echo "</td>";
        echo "</tr>";
        echo "<tr class='main_body'>";
        echo "<td colspan='13'><font color='green'>�`�p�ŦX�H�ơG".$record->RecordCount()."�H</font></td>";
        echo "</tr>";
        echo "<td><font size='2'>�Z��</font></td>";
        echo "<td><font size='2'>�y��</font></td>";
        echo "<td><font size='2'>�m�W</font></td>";
        echo "<td><font size='2'>�ʧO</font></td>";
        echo "<td><font size='2'>�Ǹ�</font></td>";
        echo "<td><font size='2'>�����Ҧr��</font></td>";
        echo "<td><font size='2'>����</font></td>";
        echo "<td><font size='2'>����</font></td>";
        echo "<td><font size='2'>�ͤ�</font></td>";
        echo "<td><font size='2'>�a�}</font></td>";
        echo "<td><font size='2'>�q��1</font></td>";
        echo "<td><font size='2'>�q��2</font></td>";
        echo "<td><font size='2'>���p</font></td>";
        echo "</tr>";
        //�C�X���
        while ($array_stud = $record->FetchRow()) {
              $array_stud[seme_class]=(substr($array_stud[seme_class],0,1)>6)?$array_stud[seme_class]=$array_stud[seme_class]-600:$array_stud[seme_class];
              $array_stud[stud_sex]=($array_stud[stud_sex]=='1')?"�k":"�k";
              $parents=find_parents($array_stud[student_sn]);//��X����
              $temp_bgcolor=($temp_bgcolor=="#EFE0ED")?"#ffffff":"#EFE0ED";//���j�ܴ��I���C��
              echo "<tr bgcolor='$temp_bgcolor'>";
              if ($array_stud[stud_study_cond]==0) $temp_color="";
                 else $temp_color="color='red'";
              echo "<td><font size='2' ".$temp_color.">$array_stud[seme_class]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[seme_num]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_name]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_sex]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_id]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_person_id]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$parents[0]</font></td>";//����
              echo "<td><font size='2' ".$temp_color.">$parents[1]</font></td>";//����
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_birthday]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_addr_1]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_tel_1]</font></td>";
              echo "<td><font size='2' ".$temp_color.">$array_stud[stud_tel_2]</font></td>";
              echo "<td><font size='2' ".$temp_color.">".$move_kind_arr[$array_stud[stud_study_cond]]."</font></td>";
              echo "</tr>";
        }
        echo "</tr></table>";
        exit;
}

?>
