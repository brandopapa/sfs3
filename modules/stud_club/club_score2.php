<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - ���Z�ɵn");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();
//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);

//�ثe��w�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe��w�~�šA100�������w
$c_curr_class=($_POST['c_curr_class']!="")?$_POST['c_curr_class']:"100";

//���o�Ǵ����γ]�w
$SETUP=get_club_setup($c_curr_seme);


//�w�]�����Ǵ�����
if ($CLUB['year_seme']=="") $CLUB['year_seme']=$c_curr_seme;

//���U�x�s�s�� , �Q�� $_SESSION['club_sn'] ���x�s�ؼ�
    if ($_POST['mode']=="save") {
			foreach ($_POST['score'] as $student_sn=>$score) {	  		
	  		$query="update association set score='$score',description='".$_POST['description'][$student_sn]."',stud_post='".$_POST['stud_post'][$student_sn]."',update_sn='".$_SESSION['session_tea_sn']."' where student_sn='$student_sn' and club_sn='".$_SESSION['club_sn']."'";
	  		if (!mysql_query($query)) {
	   		 echo "Error! Query=$query";
	   		 exit();
	  	  }		
		}
  	$INFO="�w��".date('Y-m-d H:i:s')."�x�s���Z���";
  	$_POST['mode']="list";	
  	$_POST['club_sn']=$_SESSION['club_sn'];
		}

//�ˬd�O�_����w����
if ($_POST['club_sn']!="") $c_curr_class=get_club_class($_POST['club_sn']);

?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<!-- mode �Ѽ� insert , update ,�b submit�e�i�� mode.value �ȭק� -->
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_sn" value="">
<table border="0" width="1000">
	<tr>
		<!--�D�\���C(��󥪥k�����), ���� select �����Ǵ��Ψ�L�\�� -->
		<td colspan="2" style="font-size:10pt;color:#FF0000">
		<select name="c_curr_seme" onchange="this.form.submit()">
			<?php
			while (list($tid,$tname)=each($class_seme_p)){
    	?>
    		<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   		<?php
    	} // end while
    	?>
    </select>
		

		<!--�Ĥ@�C����, �\����ᴣ�̫ܳ�ʧ@�T�� $INFO -->
		</td>
	</tr>
	  <!--���C����, �Ǵ����ΦC�� -->
	  <td width="160" valign="top" style="color:#FF00FF;font-size:10pt">
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
									<option value="100" style="color:#FF00FF;font-size:10pt" <?php if ($c_curr_class=='100') echo "selected";?>>��~��(<?php echo get_club_num($c_curr_seme,100);?>)</option>
		</select>���ΦC��
			<?php
	  	//�ǤJ�Ѽ� 1001 , 1002 ��, �~�׾Ǵ�
	  	list_club_select($c_curr_seme,$c_curr_class);
	  	?>
	  </td>
	  <!--���C�������� -->
	  <!--�k�C����, �D�e�� -->
		<td width="840" valign="top">
	  <?php
		
	  //��ܬY���� ================================================================
	  if ($_POST['mode']=="list") {
	  	if ($_POST['club_sn']!="") $club_base=get_club_base($_POST['club_sn']);
      $_SESSION['club_sn']=$_POST['club_sn']; //�s�J SESSION 
			echo "<font color='#800000'>���ɦѮv�G".get_teacher_name($club_base['club_teacher'])."<br>";
			echo "���ΦW�١G".$club_base['club_name']."</font><br>";
			 ?>
<table border="1" style="border-collapse:collapse" bordercolor="#800000" width="100%">
 <tr bgcolor='#CCFFCC' style="font-size:10pt">
  <td align="center" style="color:#000000;font-size:10pt" width="40">�Ǹ�</td>
 	<td align="center" style="color:#0000FF" width="70">�Z��</td>
 	<td align="center" style="color:#0000FF" width="50">�y��</td>
 	<td align="center" style="color:#0000FF" width="80">�m�W</td>
 	<td align="center" style="color:#0000FF" width="50">���Z</td>
 	<td align="center" style="color:#0000FF" width="80">���¾��</td>
 	<td align="center" style="color:#0000FF" width="280">�ǲߴy�z</td>
 
  <td align="center" style="color:#0000FF">�ǥͦۧڬ٫�</td>
 	
 </tr>
 <?php
//���o�ǥͦ��Z
$query="select a.*,b.seme_class,b.seme_num,c.stud_name from association a,stud_seme b,stud_base c where a.seme_year_seme='$c_curr_seme' and a.club_sn='".$club_base['club_sn']."' and b.seme_year_seme='$c_curr_seme' and a.student_sn=b.student_sn and a.student_sn=c.student_sn and (c.stud_study_cond=0 or c.stud_study_cond=5) order by seme_class,seme_num";
$res=mysql_query($query);

 $i=0;
  while ($row=mysql_fetch_array($res)) {
  	$i++;
  	$CLASS_name=$school_kind_name[substr($row['seme_class'],0,1)];
  	if ($row['score']=="0")  $row['score']='';
  ?>
  <tr style="font-size:10pt">
    <td align="center" style="color:#000000;font-size:10pt" width="50"><?php echo $i;?></td>
  	<td align="center"><?php echo $CLASS_name.sprintf('%d',substr($row['seme_class'],1,2))."�Z";?></td> 
  	<td align="center"><?php echo $row['seme_num'];?></td> 
  	<td align="center"><?php echo $row['stud_name'];?></td> 
  	<td align="center"><input type="text" name="score[<?php echo $row['student_sn'];?>]" value="<?php echo $row['score'];?>" size="3"></td> 
  	<td align="center"><input type="text" name="stud_post[<?php echo $row['student_sn'];?>]" value="<?php echo $row['stud_post'];?>" size="8"></td> 
  	<td ><textarea cols="36" rows="3" name="description[<?php echo $row['student_sn'];?>]"><?php echo $row['description'];?></textarea></td> 
   	<td style="font-size:8pt" width="150"><?php echo $row['stud_feedback']; ?></td>
 </tr>  
  <?php 
  } // end while
 ?>
</table>
<input type="button" value="�x�s" onclick="document.myform.mode.value='save';document.myform.submit()">����: �ǥͭY�����¾�ȡA����i�d�ťաC
<table width="100%" border="0">
	<tr><td style="color:#FF0000;font-size:10pt"><?php echo $INFO;?></td></tr>
</table>
<?php       
       
	  }

		?>
	  </td>
	  <!--�k�C�������� -->
	</tr>
</table>
</form>

