<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�ثe�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf("%03d%d",curr_year(),curr_seme());

//���o�Ҧ��Z��
 $select_class=class_base(curr_year().curr_seme());  //���o�ثe���Z�Ű}�C  [701]�@�~�@�Z , [702]�@�~�G�Z

//���o���ЯZ��
$class_num=get_teach_class();
$class_id=sprintf("%03d_%d_%02d_%02d",curr_year(),curr_seme(),substr($class_num,-3,strlen($class_num)-2),substr($class_num,-2));

//�ӥ��ЯZ�Ťw�b�Ǫ��`�Ǵ���
$select_seme=get_class_seme_select($class_num);  													//array [1001]="100�Ǧ~��1�Ǵ�"
$select_seme_key=get_class_seme_key_select($select_seme,$class_num);			//array �p: [1001]="7-1"; [1012]="8-2";

//���Z�žǥͦW��
$query="select a.student_sn,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='".curr_year().curr_seme()."' and a.seme_class='$class_num' and a.student_sn=b.student_sn order by a.seme_num";
$res_stud_list=$CONN->Execute($query);

//POST �᪺�ʧ@
if ($_POST['act']=="save") {
	$data_array=explode("\n",$_POST['data_array']);
 	$save_ok=0;
 	$seme_key=$select_seme_key[$c_curr_seme]; 
 foreach ($data_array as $a) {
 	$data_arr=explode("\t",$a);
  $seme_num=$data_arr[0];
  $stud_name=$data_arr[1];
  //���o�ǥͪ� student_sn
  $sql="select a.student_sn from stud_seme a,stud_base b where a.seme_year_seme='".curr_year().curr_seme()."' and a.seme_class='$class_num' and a.seme_num='$seme_num' and b.stud_name='$stud_name' and a.student_sn=b.student_sn";
  $res=$CONN->Execute($sql);
  $student_sn=$res->fields['student_sn'];
  if ($student_sn) {
  //���X���, �øm���ؼоǴ����}�C���, �A�^�s
   	/***
 		�}�C��ƻ���:
 		  $ponder_array[�Ǵ�7-1,7-2,8-,8-2,9-1,9-2��][1�F��][1,2] ����
 		  $ponder_array[�Ǵ�7-1,7-2,8-,8-2,9-1,9-2��][2�p�Ѯv][1,2] ����
 		*/
 		//�ˬd�O�_�w���¬���
		$query="select * from career_self_ponder where student_sn=$student_sn and id='3-2'";
		$res=$CONN->Execute($query) or die("SQL���~:$query");
		$sn=$res->fields['sn'];
		if($sn) {
			$ponder_array=unserialize($res->fields['content']); //�Ѷ}���G���}�C
			//�F��
			$ponder_array[$seme_key][1][1]=$data_arr[2];
			$ponder_array[$seme_key][1][2]=$data_arr[3];
			//�p�Ѯv
			$ponder_array[$seme_key][2][1]=$data_arr[4];
			$ponder_array[$seme_key][2][2]=$data_arr[5];
			//�Ƶ�
			$ponder_array[$seme_key]['memo']=$data_arr[6];
			
			$content=serialize($ponder_array);	
			
			$query="update career_self_ponder set id='3-2',content='$content' where sn=$sn";
		}else{
			//�F��
			$ponder_array[$seme_key][1][1]=$data_arr[2];
			$ponder_array[$seme_key][1][2]=$data_arr[3];
			//�p�Ѯv
			$ponder_array[$seme_key][2][1]=$data_arr[4];
			$ponder_array[$seme_key][2][2]=$data_arr[5];
			//�Ƶ�
			$ponder_array[$seme_key]['memo']=$data_arr[6];
			
			$ponder_array[$seme_key][data]="";
			$content=serialize($ponder_array);
			
			$query="insert into career_self_ponder set student_sn=$student_sn,id='3-2',content='$content'";
		
		} // end if else
		
		$res=$CONN->Execute($query) or die("SQL���~:$query");
	} // end if student_sn
 } // end foreach	
 
 $INFO="�v��".date("Y-m-d H:i:s")."�i���x�s�ʧ@!";
}




//�q�X SFS3 ���D
head();

if ($class_num==0) echo "��p, �z����ɮv����! �ֶK�\��ȴ��Ѿɮv�ֳt�K�W���Z���!";


//�C�X���
echo $tool_bar;
?>
<form name="myform" method="post" act="<?php echo $_SEVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<?php
	echo $select_class[$class_num]; 
	?>
	<select size="1" name="c_curr_seme" onchange="document.myform.submit()">
		<?php
		foreach ($select_seme as $k=>$v) {
			?>
			<option value="<?php echo $k;?>"<?php if ($k==$c_curr_seme) echo " selected";?>><?php echo $v;?></option>
			<?php
		}
		?>
	</select>
	<table border="0" width="100%">
	 <tr>
	 	<td style="color:#0000FF"><b>�~��-�Ǵ��G<?php echo $select_seme_key[$c_curr_seme];?></b>
	 	 <font size="2" color="red"><?php echo $INFO;?></font>
	 	</td>
	 </tr>
	 <tr>
	 	<td>
	 			<textarea name="data_array" cols="80" rows="10"></textarea>
	 	</td>
	 </tr>
	 <tr>
	 	 	<td>
	 	 		<input type="button" value="�K�W���" onclick="document.myform.act.value='save';document.myform.submit();">
	 	 		<input type="button" value="�ֶK����" onclick="readme();">
	 	 	</td>
	 </tr>
	</table>
	<table id="readme_show" style="display:none">
	 <tr>
	    <td style="font-size:10pt;color:#0000dd">
   			�����G�ФU��Excel��g�d�ҡ�<a href="demo.xls" style="color:#FF0000">�d��</a>���A�̹ϥܶȿ�ܤ��e�ƻs/�K�W�Y�i(��Ƥ��e���]�A���D�C)�C
      </td>
	 </tr>
	 <tr>
		 <td><img src="images/paste_demo.png" border="0"></td>
		</tr>
	</table>
	<font color="#800000">��<?php echo $class_num;?>�Z�ǥͦW��A�Ъ`�N�K�W����Ƥ��A�y���P�m�W�Ω��ӡA�ȥ��������T�C</font>
	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
	<?php
	$i=0;
	while ($row=$res_stud_list->FetchRow()) {
  	$i++;
  	$student_sn=$row['student_sn'];
  	$seme_num=$row['seme_num'];
  	$stud_name=$row['stud_name'];
	 if ($i%10==1) {
			echo "<tr>";
		}
	?>
			<td align="center"><?php echo $seme_num." ".$stud_name;?></td>
	<?php
	 if ($i%10==0) {
			echo "</tr>";
		}
	?>	 
  	<?php
  } // end while	
	?>
	</table>
</form>
<Script Language="JavaScript">
function readme() {
	var dis=readme_show.style.display;	
	if (dis=='none') {
		readme_show.style.display="block";
	} else {
		readme_show.style.display="none";
	}
}
</Script>