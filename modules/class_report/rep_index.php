<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�ثe�Ǵ�
$c_curr_seme=sprintf("%03d%d",curr_year(),curr_seme());
//�ثe��w�Ǵ�
$the_seme=($_POST['the_seme']=="")?$c_curr_seme:$_POST['the_seme'];

switch ($_SESSION['session_who']) {
	//�p�G�O�Ѯv, ���o�Ҧ��Ǵ�
	case '�Юv':
		$select_seme = get_class_seme(); //�Ǧ~��
		//���o�ثe�Ǵ����Ҧ��iŪ�������Z��
		$select_report=get_report("list",$the_seme);
	break;

	//�p�G�O�ǥ�, ���o�N�ǾǴ�
	case '�ǥ�':
	  //�����ǥ͸ӾǴ��NŪ�Z��
		$sql="select seme_class from stud_seme where seme_year_seme='$the_seme' and student_sn='{$_SESSION['session_tea_sn']}'";
		$res=$CONN->execute($sql);
		$class_num=$res->fields['seme_class'];
		//�ӯZ�Ťw�b�Ǫ��`�Ǵ���
		$select_seme=get_class_seme_select($class_num);
		//���o�ӾǴ����Ҧ��iŪ�������Z��
		$select_report=get_report("list",$the_seme,$class_num);

	break;
} // end switch


//�q�X SFS3 ���D
head("�[�ݦ��Z��");

//�C�X���
echo $tool_bar;

?>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
	<input type="hidden" name="act" value="">
	<select size="1" name="the_seme" onchange="document.myform.submit()">
		<?php
		foreach ($select_seme as $k=>$v) {
		?>
			<option value="<?php echo $k;?>"<?php if ($the_seme==$k) echo " selected";?>><?php echo $v;?></option>
		<?php
		}
		?>
	</select>
	
	<select size="1" name="the_report" onchange="document.myform.submit()">
		<option value="">--�п�ܦ��Z��--</option>
		<?php
		foreach ($select_report as $k=>$v) {
		?>
			<option value="<?php echo $v['sn'];?>"<?php if ($_POST['the_report']==$v['sn']) echo " selected";?>><?php echo "[".$v['seme_class_cname']."]".$v['title'];?></option>
		<?php
		}
		?>
	</select>	
  <?php
  if ($_POST['the_report']) {
  	$REP_SETUP=get_report_setup($_POST['the_report']);
   	if (($REP_SETUP['open_read'] and $REP_SETUP['rep_classmates']) or $_SESSION['session_who']=='�Юv') { 
   			list_class_score($REP_SETUP,0,$REP_SETUP['rep_sum'],$REP_SETUP['rep_avg'],$REP_SETUP['rep_rank']); //�C�X���Z
    }
   	if ($REP_SETUP['open_read'] and $REP_SETUP['rep_classmates']==0 and $_SESSION['session_who']=='�ǥ�') { 
   			list_class_score_personal($REP_SETUP,0,$REP_SETUP['rep_sum'],$REP_SETUP['rep_avg'],$REP_SETUP['rep_rank']); //�C�X�ӤH
    }
  
  }
  ?>	
   	
   	<font color=red size=2>���`�N! ��@���Z���[�v�ȷU���A�Ӧ��Z�Ҧ��`������ҷU���C</font>



</form>



