<?php

include "config.php";
include "chc_func_class.php";

//�ޤJ��������(�ǰȨt�ΥΪk)
include_once "../../include/sfs_oo_dropmenu.php";
include_once "../../include/sfs_case_menu.php";

//�i�ͲP���ɯZ�ŷF���޲z�j�Ҳը禡
include_once "../career_leader/my_functions.php";
//�{��
sfs_check();

//��ܤ��e
if(isset($_POST) and count($_POST)>0){
	if($_POST['form_act']=='add'){
		$aa=get_stu($_POST["year_seme"],$_POST["year_name"]);
		$INFO=save_record($aa, $_POST["year_seme"],$_POST["year_name"]);
	}
}

//�q�X�����������Y
head("�ץX���");
print_menu($menu_p);


echo make_menu($school_menu_p);

display();

if($INFO!=''){
	echo '<br><br>'.$INFO.'<br><br>';
}

function save_record($stu, $year_seme,$year_name) {
	global $CONN;

	$mycount=0;
	foreach ($stu as $student_sn=>$val) {
		$seme_num=$val['seme_num'];
		$stud_name=$val['stud_name'];
		$class_num=$val['seme_class'];
		$c_curr_seme=$val['seme_year_seme'];
		$select_seme=get_class_seme_select($class_num);  													//array [1001]="100�Ǧ~��1�Ǵ�"

		$select_seme_key=get_class_seme_key_select($select_seme,$class_num);			//array �p: [1001]="7-1"; [1012]="8-2";
		$seme_key=$select_seme_key[$c_curr_seme];

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
			$ponder_array[$seme_key][1][1]=$val['title'][0];
			$ponder_array[$seme_key][1][2]=$val['title'][1];
			//�p�Ѯv
			//$ponder_array[$seme_key][2][1]=$data_arr[4];
			//$ponder_array[$seme_key][2][2]=$data_arr[5];
			//�Ƶ�
			$ponder_array[$seme_key]['memo']=$val['memo'];
			$content=serialize($ponder_array);
			$query="update career_self_ponder set id='3-2',content='$content' where sn=$sn";
		}else{
			//�F��
			$ponder_array[$seme_key][1][1]=$val['title'][0];
			$ponder_array[$seme_key][1][2]=$val['title'][1];
			//�p�Ѯv
			$ponder_array[$seme_key][2][1]='';//�������ثe�L�u�p�Ѯv1�v���
			$ponder_array[$seme_key][2][2]='';//�������ثe�L�u�p�Ѯv1�v���
			//�Ƶ�
			$ponder_array[$seme_key]['memo']=$val['memo'];
			$ponder_array[$seme_key][data]="";
			$content=serialize($ponder_array);
			$query="insert into career_self_ponder set student_sn=$student_sn,id='3-2',content='$content'";
		} // end if else
		$res=$CONN->Execute($query) or die("SQL���~:$query");
		$mycount++;
	} // end foreach
	//$INFO="�v��".date("Y-m-d H:i:s")."�x�s $mycount ����Ʀ��\!";
	$INFO="�x�s $mycount ����Ʀ��\!";

	return $INFO;
}




/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
function get_stu($year_seme, $year_name){
	global $CONN;

	$CID=split("_",$year_seme);//093_1
	$year=$CID[0];
	$seme=$CID[1];
	$grade=$year_name;//�~��

	$CID_1=$year.$seme;

	$SQL="select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_year_seme,b.seme_class,b.seme_num,a.stud_study_cond  from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$CID_1' and b.seme_class LIKE '".$grade."__' order by b.seme_class, b.seme_num ";

	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$obj_stu=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$obj_stu[$ro->student_sn] = get_object_vars($ro);
	}

	$SQL="select id,student_sn,seme,kind,org_name,title,memo from chc_leader 
	where kind='0'  and seme='$CID_1' and org_name LIKE '".$grade."__' order by id,  org_name ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	$All=$rs->GetArray();
	foreach ($All as $ary){
		$Sn=$ary['student_sn'];
		$obj_stu[$Sn]['title'][]=$ary['title'];
		if($ary['memo']!=''){
			$obj_stu[$Sn]['memo'][].=' '.$ary['memo'];
		}
	}
	return $obj_stu;
}


//���
function display(){

	$menu='';
	$year_seme=$_REQUEST['year_seme'];
	$year_name=$_REQUEST['year_name'];
	$stage=$_REQUEST['stage'];
	$score_sort=$_REQUEST['score_sort'];
	$sel=$_POST['sel'];
	$sel_class=$_POST['sel_class'];
	$print_special=$_POST['print_special'];

	//�]�w�D������ܰϪ��I���C��
	$menu="<table border=0 cellspacing=0 cellpadding=2 width=100% bgcolor=#cccccc><tr><td>";

	if (empty($year_seme)) {
		$sel_year = curr_year(); //�ثe�Ǧ~
		$sel_seme = curr_seme(); //�ثe�Ǵ�
		$year_seme=$sel_year."_".$sel_seme;
	} else {
		$ys=explode("_",$year_seme);
		$sel_year=$ys[0];
		$sel_seme=$ys[1];
	}
	$year_seme_menu=year_seme_menu($sel_year,$sel_seme);
	$class_year_menu =class_year_menu($sel_year,$sel_seme,$year_name);
	$menu.="<form name=\"myform\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
		<table>
		<tr>
		<td>$year_seme_menu</td><td>$class_year_menu</td><td></td>
		</tr>
		</table></form>";

	$menu.="</tr></table>";

	$check_js='onclick="if( window.confirm(\'�T�w��s�H�|�N��~�Ū��u����F���v����л\�I\')){this.form.form_act.value=\'add\';this.form.submit();}" ';

	echo '<table  width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#9EBCDD" style="table-layout: fixed;word-wrap:break-word;font-size:10pt">
<tr style="font-size:11pt" bgcolor="#9EBCDD"><td>
�����G<br>
1.�t�X���ƿ��u12�~��Ф��M�K�դJ�ǡv�@�~�A���{���i�N�u�Z�ŷF���v�������s��i<a href="/test_sfs3/modules/career_leader/leader_input.php" target="_blank">�ͲP���ɯZ�ŷF���޲z</a>�j�C<br>
2.�ϥΥ��{���@���B�z�@��Ӧ~�Ū���ơA�|�N�i<a href="/test_sfs3/modules/career_leader/leader_input.php" target="_blank">�ͲP���ɯZ�ŷF���޲z</a>�j�����u����F���v����л\�A�ϥΫe�ФT��C<br>
<br>
</td></tr></table>';
echo '<table  width="100%"  border="1" align="center" cellpadding="1" cellspacing="1" style="table-layout: fixed;word-wrap:break-word;font-size:10pt">
<tr style="font-size:11pt">

<td></td></tr>';
	echo '<tr style="font-size:11pt">

<td>';
	echo '<form name="form1" method="post" action="">'.$menu.'
 <br> �u�Z�ŷF���v����ɡ@
 <INPUT TYPE="hidden" NAME="form_act" Value="">
<input type="submit" name="leader_save" value="��s��i�ͲP���ɯZ�ŷF���޲z�j�Ҳ�" '.$check_js.'>
</form>';
	echo '</td></tr>';
	echo '</table>';

}


