<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - �C�L�|����g�ۧڬ٫䪺�W��");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

if ($_SESSION['session_who'] != "�Юv") {
	echo "�ܩ�p�I���\��Ҳլ��Юv�M�ΡI";
	exit();
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//���o�Ǵ����γ]�w
$SETUP=get_club_setup($c_curr_seme);

//�ثe��w�~�šA100�������w
$c_curr_class=$_POST['c_curr_class'];

//���o���ЯZ�ťN��
$class_num = get_teach_class();

//����O�_���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}

//�Y���޲z�v, �i�ˬd�C�@�ӯZ
?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_class" value="">
<table border="0" width="800">
	<tr>
	  <!--���C����, �Ǵ����ΦC�� -->
	  <td width="100%" valign="top" style="color:#FF00FF;font-size:10pt">
	  	<select name='c_curr_class' onchange="document.myform.submit()">
	  		<option value="" style="color:#FF00FF">�п��..</option>
	  	<?php
			    $class_year_array=get_class_year_array(sprintf('%d',substr($c_curr_seme,0,3)),sprintf('%d',substr($c_curr_seme,-1)));
                foreach ($class_year_array as $K=>$class_year_name) {
                	?>
                	<option value="<?php echo $K;?>" style="color:#FF00FF;font-size:10pt" <?php if ($c_curr_class==$K) echo "selected";?>><?php echo $school_kind_name[$K];?>��(<?php echo get_club_num($c_curr_seme,$K);?>)</option>
                	<?php
                }	
			?>
		</select>���~�ŦU�Z����g�ۧڬ٫䪺�W��
	  </td>
	</tr>
</table>
</form>
<?php

	  //��ܬY�Z�ŦW�� ================================================================
	  
	  if ($_POST['c_curr_class']!="") {
	  	$CLASS_name=$school_kind_name[$c_curr_class];
	  	//�����X���Ǵ��Ҧ��ǥ�, �v������
     $query="select student_sn,seme_class,seme_num from stud_seme where seme_year_seme='$c_curr_seme' and seme_class like '".$c_curr_class."%%' order by seme_class,seme_num";
     $result=mysql_query($query);
			while ($row=mysql_fetch_row($result)) {
			  list($student_sn,$seme_class,$seme_num)=$row;
			  //�ˬd���S���g�ۧڬ٫�
			   $query_fb="select stud_feedback from association where seme_year_seme='$c_curr_seme' and student_sn='$student_sn' and club_sn!=''"; 
			   $res=mysql_query($query_fb);
			   if (mysql_num_rows($res)==0) {
			    $student_not_arrange[$seme_class][$seme_num]=$student_sn; //���s�Z�W��
			    $student_not_feedback[$seme_class][$seme_num]=$student_sn; //���g�٫�W��
			   } else {
			    list($fb)=mysql_fetch_row($res);
			    if ($fb=='') {	
			     $student_not_feedback[$seme_class][$seme_num]=$student_sn; //���g�٫�W��
			    }
			   }
	   }
 		  foreach ($student_not_feedback as $class=>$STUDENT) {
		 	  echo "<br><font color='#0000FF'>��".$CLASS_name.sprintf('%d',substr($class,1,2))."�Z ���g���Φۧڬ٫�W��G<br>";
		 	  ?>
		 	  <table border="0" width="800">
		 	  	<?php
		 	  	$i=0;
		 	  	 foreach ($STUDENT as $num=>$student_sn) {
							$i++;
							if ($i%10==1) echo "<tr>";
							 echo "<td style='font-size:10pt'>".$num.".".get_stud_name($student_sn)."</td>";
							if ($i%10==0) echo "</tr>";
		 	  	 }
		 	  	?>
		 	  </table>
		 	  <?php
		 	  if (count($student_not_arrange[$class])>0) {
		 	   echo "<font color=red>�`�N! ���Z���ѥ[���ά��ʦW��G";
		 	   foreach ($student_not_arrange[$class] as $student_sn) {
		 	   	 echo " ".get_stud_name($student_sn);
		 	   
		 	   }
		 	  }
		  }

	   
	   
	  } // end if ($_POST['c_curr_class']!="")
	  


		?>
	  
