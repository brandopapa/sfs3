<?php
// $Id: input.php 7028 2012-12-04 05:44:50Z chiming $

include "config.php";
sfs_check();

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($_REQUEST[year_seme])){
	$ys=explode("-",$_REQUEST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}else{
	$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year]; //�ثe�Ǧ~
	$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme]; //�ثe�Ǵ�
}

/*
//���o���ЯZ�ťN��
$class_num=get_teach_class();
$class_all=class_num_2_all($class_num);
if(empty($class_num)){
	$act="error";
	$error_title="�L�Z�Žs��";
	$error_main="�䤣��z���Z�Žs���A�G�z�L�k�ϥΦ��\��C<ol>
	<li>�нT�{�z�����ЯZ�šC
	<li>�нT�{�аȳB�w�g�N�z�����и�ƿ�J�t�Τ��C
	</ol>";
}
*/

//�D���]�w
$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

$act=$_REQUEST[act];


if($_REQUEST[chknext]){
	$ss_temp = "&chknext=$_REQUEST[chknext]&nav_next=$_REQUEST[nav_next]";
}

$stud_id=$_REQUEST[stud_id];


//����ʧ@�P�_

if($act=="save"){
	save_score_nor($sel_year,$sel_seme,$_REQUEST[student_sn],$_REQUEST[nor_score],$_REQUEST[nor_score_memo]);
	save_score_oth($sel_year,$sel_seme,$stud_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&class_id=$_REQUEST[class_id]&stud_id=$stud_id".$ss_temp);
}elseif($_REQUEST[error]==1){
	user_error("�ӯZ�ŵL�ǥ͸�ơA�L�k�~��C<ol>
	<li>�нT�{�z�����ЯZ�šC
	<li>�нT�{�аȳB�w�g�N�z���ǥ͸�ƿ�J�t�Τ��C
	<li>�פJ�ǥ͸�ơG�y�ǰȨt�έ���>�а�>���U��>�פJ��ơz(<a href='".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php'>".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php</a>)</ol>",256);
	}else{
	if($_REQUEST[chknext]){$stud_id=$_REQUEST[nav_next];}
	$main=&main_form($sel_year,$sel_seme,$_REQUEST[class_id],$stud_id);
}


//�q�X����
head("���Z��s�@");
?>


<script language="JavaScript">
<!-- Begin
function jumpMenu_seme(){
	location="<?php echo $_SERVER['PHP_SELF']?>?act=<?php echo $act;?>&year_seme=" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value + "&class_id=<?php echo $_REQUEST[class_id]?>";
}

function jumpMenu_seme_1(){
	location="<?php echo $_SERVER['PHP_SELF']?>?act=<?php echo $act;?>&year_seme=<?php echo $_REQUEST[year_seme]?>&class_id=" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
}
//  End -->
</script>

<?php
echo $main;
foot();

function &main_form($sel_year,$sel_seme,$class_id,$stud_id){
	global $CONN,$performance_option,$school_menu_p,$performance,$SFS_PATH_HTML;
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");
	//�~�ŻP�Z�ſ��
	$class_select=&get_class_select($sel_year,$sel_seme,"","class_id","jumpMenu_seme_1",$_REQUEST['class_id']);
	
	//���o�ǥͿ��	
	if(empty($class_select) or empty($date_select))	header("location:{$_SERVER['PHP_SELF']}?error=1");
	
	if(!empty($class_id)){
		//�ഫ�Z�ťN�X
		$class=class_id_2_old($class_id);
		//���p�S�����w�ǥ͡A���o�Ĥ@��ǥ�
		if(empty($stud_id))$stud_id=get_no1($class_id);
		//�Y���O�S�� $stud_id �A�h�q�X���~�T��
		if(empty($stud_id))header("location:{$_SERVER['PHP_SELF']}?error=1");
		
		
		$gridBgcolor="#DDDDDC";
		//�w�s�@����C��
		$over_color = "#223322";
		//�����k������C��
		$non_color = "blue";
		
		$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);  //�إ߿��	   	
		$grid1->key_item = "stud_id";  // ������W 
		$grid1->formname = "myform";
		$grid1->display_item = array("sit_num","stud_name");  // �����W   
		$grid1->bgcolor = $gridBgcolor;
		$grid1->display_color = array("1"=>"blue","2"=>"red");
		$grid1->color_index_item ="stud_sex" ; //�C��P�_��
		$grid1->class_ccs = " class=leftmenu";  // �C�����
		$grid1->sql_str = "select stud_id,stud_name,stud_sex,substring(curr_class_num,4,2)as sit_num  from stud_base where curr_class_num like '$class[2]%' and stud_study_cond=0 order by curr_class_num";   //SQL �R�O
		$grid1->do_query(); //����R�O 
	
		$stud_select = $grid1->get_grid_str($stud_id); // ��ܵe��
		
		
		if(!empty($stud_id)){
			
			if ($_REQUEST[chknext] && $_REQUEST[nav_next]<>'')	$stud_id = $_REQUEST[nav_next];
		
			//�D�o�ǥ�ID	
			$student_sn=stud_id2student_sn($stud_id);
			
			//���o���w�ǥ͸��
			//$stu=get_stud_base("",$stud_id);
			$stu=get_stud_baseB($student_sn,$stud_id);
			
			//�y��
			$stu_class_num=curr_class_num2_data($stu['curr_class_num']);
			
			
			//���o�Ӿǥͤ�`�ͬ���{���q��
			$oth_data=&get_oth_value($stud_id,$sel_year,$sel_seme);
			$oth_array=array();
			foreach($performance as $id=>$sk){
				$oth_array[$id]=$oth_data['�ͬ���{���q'][$id];	
			}
			
			$form="<table>";			
			$i=1;
			foreach($performance as $pf){
				//�s�@�ﶵ
				$form_option="<option value=''></option>";
				foreach($performance_option as $po){			
					$selected=($oth_array[$i]==$po)?"selected":"";
					$form_option.="<option value='$po' $selected>$po</option>";
				}
				$form.="<tr><td>$pf</td><td><select name='a_$i'>$form_option</select></td></tr>";
				$i++;
			}
			$form.="</table>";
			
			
			//���o�ǥ;Ǵ����y�Τ���
			$nor_value=get_nor_value($student_sn,$sel_year,$sel_seme,$class_id);
			
			//�����ﶵ
			$nor_array=&score2str_arr($class);
			$nor_score="<select name='nor_score'><option value=''></option>";
			foreach($nor_array as $nc=>$ns){				
				$selected=($nor_value['���Ƶ���']==$nc)?"selected":"";
				$nor_score.="<option value='$nc' $selected>$ns</option>";
			}
			$nor_score.="</select>";
			
			$checked=($_REQUEST[chknext])?"checked":"";
			
			$stud_all="�п�J<b>".$stu[stud_name]."�]".$stu_class_num[num]."���^</b>�����Z�������ơG<a href='".$SFS_PATH_HTML."modules/score_paper/make.php?stud_id=$stud_id&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id'>�s�@".$stu[stud_name]."�����Z��</a>
			<form action='{$_SERVER['PHP_SELF']}' method='post' name='col1' id='col1'>
			<table width=300 cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'><tr bgcolor='#FFFFE7'><td valign=top>
			
			���ġG $nor_score 
			<p>
			�ɮv���y�Ϋ�ĳ <br>
			<img src='$SFS_PATH_HTML/images/comment.png' width=16 height=16 border=0 align='left' onClick=\"return OpenWindow('nor_score_memo')\">
			<textarea name='nor_score_memo' id='nor_score_memo' cols=30 rows=5>".$nor_value['�ɮv���y�Ϋ�ĳ']."</textarea>
			
			$form
			<br>
			<input type='hidden' name='act' value='save'>
			<input type='hidden' name='stud_id' value='$stud_id'>
			<input type='hidden' name='student_sn' value='$student_sn'>
			<input type='hidden' name='class_id' value='$class_id'>
			<input type='hidden' name='nav_next' >
			<p align='center'><input type='checkbox' name='chknext' value='1' $checked>�۰ʸ��U�@��<br>
			<input type='submit' value='��J' onClick='return checkok();'></p>
			</form>
			</td></tr></table>";
			//<img src='../score_input/images/comment1.png'  border='0' onclick=openwindow(\"../score_input/quick_input_memo.php?class_id=".$class[2]."&teacher_course=3899&ss_id=125&seme_year_seme=".$seme_year_seme."\")>
			
		}else{
			$stud_all="�|����ܾǥ�</td></tr><table>";
		}
		
	}
    $tool_bar=&make_menu($school_menu_p);
    
    //���o���w�ǥ͸��
	//$stu=get_stud_base("",$stud_id);
	$stu=get_stud_baseB($student_sn,$stud_id);

	
	
	$main="
	$tool_bar
	<script language=\"JavaScript\">
	var remote=null;
	function OpenWindow(p,x){
		strFeatures =\"top=300,left=20,width=500,height=150,toolbar=0,resizable=yes,scrollbars=yes,status=0\";
		remote = window.open(\"comment.php?cq=\"+p,\"MyNew\", strFeatures);
		if (remote != null) {
		if (remote.opener == null)
			remote.opener = self;
		}
		if (x == 1) { return remote; }
	}
	function checkok() {
		document.col1.nav_next.value = document.myform.nav_next.value;	
		return true;	
	}
	
	function openwindow(url_str){
	window.open (url_str,\"���y��J\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420\");
	}
	</script>
	<table bgcolor='#9EBCDD' cellspacing=0 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td bgcolor='#BDD3FF' valign=top>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td valign=top align=center>
  		$date_select<br>
  		$class_select<br>
  		$stud_select
  		
  		</td></tr>
		</form>
		</table>
	</td><td valign=top>$stud_all</td></tr>
	</table>
	";
	return $main;
}



//�ɮv���y�Ϋ�ĳ�ε���
function save_score_nor($sel_year,$sel_seme,$student_sn,$nor_score,$nor_score_memo){
	global $CONN;
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	$query = "replace into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo) values('$seme_year_seme','$student_sn',0,'$nor_score','$nor_score_memo')";
	$CONN->Execute($query) or trigger_error("sql ���~ $query",E_USER_ERROR);
}
	
//��`�ͬ���{�s��
function save_score_oth($sel_year,$sel_seme,$stud_id){
	global $CONN;
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	for ($i=1;$i<=4;$i++){
		$query = "replace into stud_seme_score_oth (seme_year_seme,stud_id,ss_kind,ss_id,ss_val) values('$seme_year_seme','$stud_id','�ͬ���{���q','$i','".$_REQUEST["a_$i"]."')";
		$CONN->Execute($query) or trigger_error("sql ���~ $query",E_USER_ERROR);		
	}
}
?>
