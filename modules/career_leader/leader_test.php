<?php
include_once('config.php');


//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�ثe�Ǵ�
$c_curr_seme=sprintf("%03d%d",curr_year(),curr_seme());

//���o���ЯZ��
$class_num=get_teach_class();
$class_id=sprintf("%03d_%d_%02d_%02d",curr_year(),curr_seme(),substr($class_num,-3,strlen($class_num)-2),substr($class_num,-2));

//�ӥ��ЯZ�Ťw�b�Ǫ��`�Ǵ���
$select_seme=get_class_seme_select($class_num);

$select_seme_key=get_class_seme_key_select($select_seme,$class_num);

//���Z�žǥͦW��
$query="select a.student_sn,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$c_curr_seme' and a.seme_class='$class_num' and a.student_sn=b.student_sn";
$res_stud_list=$CONN->Execute($query);


//�q�X SFS3 ���D
head();

if ($class_num==0 and $module_manager==0) echo "��p, �z����ɮv����!";


//�C�X���
echo $tool_bar;
$stud_seme_arr=get_student_seme(8849);

//Ū���F����� 
$query="select * from career_self_ponder where student_sn=8849 and id='3-2'";
 $res=$CONN->Execute($query);
 $ponder_array=unserialize($res->fields['content']);
 echo "start!<br>";
  echo "<pre>";
  print_r($stud_seme_arr);
  print_r($ponder_array);
  print_r($class_num);
  print_r($select_seme);
  print_r($select_seme_key);
  echo "</pre>";
  
  while ($row=$res_stud_list->FetchRow()) {
    echo $row['student_sn'].",".$row['seme_num'].",".$row['stud_name']."<br>";
  }
  
 ?>
 <table>
 <?php
 
 foreach($stud_seme_arr as $seme_key=>$year_seme){ 
 $assistant_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
 <td align='left'>1. {$ponder_array[$seme_key][1][1]}<br>2.
 {$ponder_array[$seme_key][1][2]}</td>
 <td align='left'>1. {$ponder_array[$seme_key][2][1]}<br>2.
 {$ponder_array[$seme_key][2][2]}</td>";
 $assistant_list.="<td align='left'>{$ponder_array[$seme_key][data]}</td></tr>";
 }
 echo $assistant_list;
?>
</table>

