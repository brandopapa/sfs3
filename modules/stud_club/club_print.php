<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - �C�L���ΦW��");

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

//�ثe��w�~�šA100�������w
//$c_curr_class=($_POST['c_curr_class']!="")?$_POST['c_curr_class']:"100";
 $c_curr_class=$_POST['c_curr_class'];

?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_sn" value="">
<table border="0" width="800">
	<tr>
	  <!--���C����, �Ǵ����ΦC�� -->
	  <td width="160" valign="top" style="color:#FF00FF;font-size:10pt">
	  	<select name='c_curr_class' onchange="document.myform.submit()">
	  		<option value="" style="color:#FF00FF">�п�ܪ��Φ~�ŧO</option>
	  	<?php
			    $class_year_array=get_class_year_array(sprintf('%d',substr($c_curr_seme,0,3)),sprintf('%d',substr($c_curr_seme,-1)));
                foreach ($class_year_array as $K=>$class_year_name) {
                	?>
                	<option value="<?php echo $K;?>" style="color:#0000FF;font-size:10pt" <?php if ($c_curr_class==$K) echo "selected";?>><?php echo $school_kind_name[$K];?>��(<?php echo get_club_num($c_curr_seme,$K);?>)</option>
                	<?php
                }	
			?>
									<option value="100" style="color:#0000FF;font-size:10pt" <?php if ($c_curr_class=='100') echo "selected";?>>��~��(<?php echo get_club_num($c_curr_seme,100);?>)</option>
		</select>
			<?php
			if ($c_curr_class) {
	  	//�ǤJ�Ѽ� 1001 , 1002 ��, �~�׾Ǵ�
	  	list_club_select($c_curr_seme,$c_curr_class);
	  	}
	  	?>
	  </td>
	  <!--���C�������� -->
	  <!--�k�C����, �D�e�� -->
		<td width="640" valign="top">			
		<?php
	  //��ܬY���ΦW�� ================================================================
	  if ($_POST['mode']=="list" and $_POST['club_sn']) {
	   echo "<input type='button' value='�͵��C�L' onclick='print_name()'><br>";	
		 print_name_list($c_curr_seme,$_POST['club_sn']);
	  	
	  }
		?>
	  </td>
	  <!--�k�C�������� -->
	</tr>
</table>
</form>
