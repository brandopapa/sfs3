<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

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

if ($_POST['mode']=="") {
//�q�X����
head("���ά��� - �C�L�Z�ŦW��");
//�C�X���
$tool_bar=&make_menu($school_menu_p);
echo $tool_bar;

}

//����O�_���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�Y��ɮv����, �����N�Z�Ÿ�Ʊa�J �p:101_1_07_02
if ($class_num and $_POST['c_curr_class']=="") $_POST['c_curr_class']=sprintf("%03d_%1d_%02d_%02d",$curr_year,$curr_seme,substr($class_num,0,1),substr($class_num,1,2));
?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" target="">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_sn" value="">

<?php
//�Y���޲z�v, �i�ˬd�C�@�ӯZ
if ($module_manager==1 and $_POST['mode']=="") {
?>
<table border="0" width="800">
	<tr>
	  <!--���C����, �Ǵ����ΦC�� -->
	  <td width="160" valign="top" style="color:#FF00FF;font-size:10pt">
	  	<?php
    $s_y = substr($c_curr_seme,0,3);
    $s_s = substr($c_curr_seme,-1);
    
    //���X�~�ŻP�Z�ſ��
     $tmp=&get_class_select($s_y,$s_s,"","c_curr_class","document.myform.target=\"\";this.form.mode.value=\"\";this.form.submit",$c_curr_class); 
	//$year_seme=sprintf('%03d%d',$s_y,$s_s);
	//$class_array=class_base($c_curr_seme);
	//print_r($class_array);
	 
	 echo $tmp;
	 
	  	?>
	  </td>
	</tr>
</table>
<?php
}

	  //��ܬY�Z�ŦW�� ================================================================
	  
	  if ($_POST['c_curr_class']!="") {
	  	
		 print_class_student($c_curr_seme,$_POST['c_curr_class'],$SETUP['show_score'],$SETUP['show_feedback']);
	  	
	  }
	  

if ($class_num==0 and $module_manager!=1) {
	
echo "��p, �z����ɮv����!";
exit();
	 
}// end if class_num
		?>
</form>
	  
