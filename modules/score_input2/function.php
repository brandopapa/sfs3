<?php

// $Id: function.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�ǰȨt�γ]�w�� */
include "../../include2/config.php";

sfs_check();
$p_number=34;   //score_input and score_stu�̵L�ǥ͸�Ʈ�,�w�]�ǥͤH��
$exist="";              //�I��Z�Ŭ�ئ��Z��,�Y��Ʈw�̦����(��ܤw�s�W���Ҹո��),$exist='true',�Ϥ�$exist=""
$number=array(); //�ǥͮy���Ȧs�}�C
$name=array();    //�ǥͩm�W�Ȧs�}�C
$score=array();   //�ǥͦ��Z�Ȧs�}�C
$mod=0;              //modify bit��1,�N�����Z�w�e�ܱаȳB,����ק�
$class_score_sn=array();        //���Z���O

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//$global_var�}�C�����`�Ϊ��~���ܼ�
//$sel_year                 =       �ثe�Ǧ~
//$sel_seme                =      �ثe�Ǵ�
//$curr_class_year      =      �Z��
//$curr_class_name    =      �~��
//$curr_subject         =         ���
//$curr_form            =          ���Φ�
//$send_to              =          �e�ܱаȳB���
//$score_kind         =          ��ܳ�@���Z�ο�ܥ������Z
$global_var=array(
        $sel_year,$sel_seme,$curr_class_year,$curr_class_name,$curr_subject,$curr_form,$send_to,$score_kind);

//$score_mem�D�n�ΨӬ��������������Z��,ex:���J��@�b��,�o�{��J�Ҹ����O���~,�ݭn�ഫ���O��
//�w��J�����Z�ٷ|�X�{�b�s�����Z���O
$score_mem=array();
for($i=1;$i<=$p_number;$i++)
	$score_mem[$i]=${"score_".$i};


//�H�U�O�禡
//�q�X�W�h���C��
function &list_class($global_var){
	global $CONN,$class_year,$class_name,$p_number,$score_mem;

	while(list($tkey,$tvalue)= each ($class_year)){
		$selected=($global_var[2]==$tkey)?"selected":"";
		$year_temp .= "<option value='$tkey' $selected>$tvalue</option>";
	}
	while(list($tkey,$tvalue)= each ($class_name)){
		$selected=($global_var[3]==$tkey)?"selected":"";
		$class_temp .= "<option value='$tkey' $selected>$tvalue</option>";
	}

	$str_select="select subject_id,subject_name from teacher_subject where subject_year=0 order by subject_id";
	$recordSet=$CONN->Execute($str_select);
	while (!$recordSet->EOF) {
		$subid = $recordSet->fields["subject_id"];
		$subname = $recordSet->fields["subject_name"];
		$selected=($subid==$global_var[4])?"selected":"";
		$sub_temp .= "<option value='$subid' $selected>$subname</option>\n";
  		$recordSet->MoveNext();
	}

	$forma_selected=($global_var[5]==1)?"selected":"";
	$formb_selected=($global_var[5]==2)?"selected":"";

	//
	$sel_kind=&show_exam_select($global_var);

	//�����\���
	//$tool_bar=tool_bar($sel_year,$sel_seme);

	$main="
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform' onsubmit='return check_score(".$p_number.")'>
 	<select name='curr_class_year' onChange='jumpMenu()'>
	<option value=''>�~��</option>
	$year_temp
	</select>
	<select name='curr_class_name' onChange='jumpMenu()'>
	<option value='0'>�Z��</option>
	$class_temp
	</select>�Z
	<select name='curr_subject' onChange='jumpMenu()'>
	<option value='0'>���</option>
	$sub_temp
	</select>���
	$sel_kind
	<select name='curr_form' onChange='submit()'>
	<option value='0'>�Φ�</option>
	<option value='1' $forma_selected>�</option>
	<option value='2' $formb_selected>����</option>
	</select>�Φ�<hr>
	<input type='text' name='practice_exam' size='10'>
	<input type='submit' name='add_practice' value='�s�W�p��'>
	<input type='radio' name='send_to' value='1'>�e�ܱаȳB
	<br>PS:�S������|�N���Z�Ȧs,�i�ѭק�!�Y������Z�|�e��аȳB,����ק�! <hr>
	";
	return  $main;
}

//�Nlist_class_table�令list_sub_table
//�s�W$curr_subject���,�N���ܬ��
//����ƥu�q�X�ק令�Z�����j������
function &list_stu_table($global_var){
	global $CONN,$act,$p_number,$exist,$mod;
	$main=&list_class($global_var);

	$main.="<table border='0' cellspacing='1' cellpadding='4' bgcolor='#9EBCDD'>";
	get_stu_score($global_var);

	if($global_var[5]==1)//��ܾ
	        $main.=form_kind_h($global_var);
	else if($global_var[5]==2)//��ܪ���
	        $main.=form_kind_v($global_var);

	$main.="</table>";

	//�e�X��Ʈ�($act=='true'��ܤw�s�W�@�Z�Y�쪺�Ҹզ��Z),'�e�X���Z' ���s�ܦ�'�ק令�Z'
	//�Φb��Ʈw�̤]�����($exist=='true'),��ܤ��e�w�s�W,�q�X���Z�C��,���ɫ��s��'�ק令�Z' �i�ק令�Z
	if($act=='true' or $exist=='true')	$value="�ק令�Z";
	else $value="�e�X���Z";

	//modify��쬰0��,�q�X�e�X���Z�����s,��1�ɤ���ק���
	//�Ҹ����O���'�����Ҹ�' �ɤ]����ק���
	if($mod==0 and $global_var[7]!='all')
		$main.="<table border='0' cellspacing='1' cellpadding='4' bgcolor='#9EBCDD'>"
		."<tr bgcolor='#E1ECFF'><td><input type='hidden' name='act'>"
		."<input type='submit' name='send_score' value='$value' onfocus='keyEnter(".$p_number.")'>"
		."</td></tr>\n</table>";

	return  $main;
}

function get_stu_score($global_var){
	global $CONN,$number,$name,$score,$p_number,$exist,$class_score_sn,$mod;

	$c=1;                           //�p��@�Z�`�Ҹզ���
	$p_number_tmp=1;     //�p��Z�H��
	$sn_pointer=0;  //�p�⦳�X���Ҹզ��Z

	if($global_var[7]!='all'){
		$sort=($global_var[7]<=3)?$global_var[7]:($global_var[7]-3);
		$type=($global_var[7]<=3)?"performance":"practice";

		//�Y��Ʈw�̦����,�x�s��$number,$name,$score�}�C
		$str_sel="select b.number,b.name,b.score,a.modify from score_input a,score_stu b"
			." where a.year='$global_var[0]' and a.semester='$global_var[1]' and a.c_year='$global_var[2]'"
			." and a.c_num='$global_var[3]' and a.c_type='$global_var[4]' and a.score_kind='$type'"
			." and a.score_sort='$sort' and b.class_sn=a.class_sn";

		$recordSet=$CONN->Execute($str_sel);
		if(!$recordSet->EOF){
			$mod = $recordSet->fields["modify"];

			while (!$recordSet->EOF) {
				$number[$c] = $recordSet->fields["number"];
				$name[$c] = $recordSet->fields["name"];
				$score[$c] = $recordSet->fields["score"];
				$c++;
				$recordSet->MoveNext();
			}
			$p_number=$c-1;
			$exist='true';
		}
	}

	else{      //��ܥ���
		$str_sel="select b.class_sn,b.number,b.name,b.score,a.score_kind,a.score_sort from score_input a,score_stu b"
			." where a.year='$global_var[0]' and a.semester='$global_var[1]' and a.c_year='$global_var[2]'"
			." and a.c_num='$global_var[3]' and a.c_type='$global_var[4]' and b.class_sn=a.class_sn"
			." order by b.class_sn,b.serial";

		$recordSet=$CONN->Execute($str_sel);
		$exam_time=count_exam_time($global_var);
		if(!$recordSet->EOF){
			while (!$recordSet->EOF) {
				$kind=$recordSet->fields["score_kind"];
				$sort=$recordSet->fields["score_sort"];

				if($class_score_sn[$sn_pointer]!=($recordSet->fields["class_sn"])){
					$e_k=($kind=='practice')?1:0;
					$e_n=$sort+$e_k*3;
					$sn_pointer++;
					$class_score_sn[$sn_pointer]=$e_n;
				}

				if($kind=="performance" and $sort==1){
					$number[$p_number_tmp] = $recordSet->fields["number"];
					$name[$p_number_tmp] = $recordSet->fields["name"];
					$score[$c] = $recordSet->fields["score"];
					$p_number_tmp++;$c++;
				}

				else{
					$score[$c] = $recordSet->fields["score"];
					$c++;
				}
				$recordSet->MoveNext();
			}
			$p_number=$p_number_tmp-1;
			$exist='true';
		}
	}
}

//�q�X����Z��
function &form_kind_h($global_var){
        global $p_number,$score_mem,$number,$name,$score,$class_score_sn;

        $line_stu=10;	//�w�]�C��C�X�Q��ǥ�
        $td_width=intval(700/$line_stu);	//���e��
        $exam_time=count_exam_time($global_var);           //�`�Ҹզ���

        if(($p_number%$line_stu)!=0)	$add=1;//�H�ƫD���,��ƭn�[�@

        $line=intval($p_number/$line_stu+$add);//���X��

        for ($i=0;$i<$line;$i++){
	$line_number=($i==intval($p_number/$line_stu))?($p_number%$line_stu):$line_stu;//�C��C�X�X�Ӿǥ�

	//�y�����
	$main.="<tr><td>"
	."<table border='0' width='100%' cellspacing='1' bgcolor='#9EBCDD'><tr bgcolor='#E1ECFF'>"
	."<td align='center' width='$td_width' class='css1'>�y��</td>";
	for($j=1;$j<=$line_stu;$j++){
		$num=($i*$line_stu)+$j;//�y��
		if($j>$line_number)
			$main.="<td width='$td_width'></td>";
		elseif($number[$num]!="")
			$main.="<td align='center' width='$td_width'>".$number[$num]."</td>";
		else
			$main.="<td align='center' width='$td_width'>$num</td>";
	}
	$main.="</tr>\n";

	//�m�W���
	$main.="<tr bgcolor='#E1ECFF'><td align='center' width='$td_width' class='css1'>�m�W</td>";
	for($j=1;$j<=$line_stu;$j++){
		$n_num=($i*$line_stu)+$j;//�y��
		if($j>$line_number)
			$main.="<td width='$td_width'></td>";
		elseif($name[$n_num]!="")
			$main.="<td align='center' width='$td_width' class='name'>".$name[$n_num]."</td>";
		else
			$main.="<td align='center' width='$td_width' class='name'>name_".$n_num."</td>";
	}
	$main.="</tr>\n";

	//���Z���
	if($global_var[7]!='all'){
	$main.="<tr bgcolor='#E1ECFF'><td align='center' width='$td_width' class='css1'>���Z</td>";
	for($j=1;$j<=$line_stu;$j++){
		$num=($i*$line_stu)+$j;//���Z�s��
		if($j>$line_number)
			$main.="<td width='$td_width'></td>";
		elseif($score[$num]!=""){
			if($score[$num] < 60)      $score_color="ls";
			else if($score[$num]>100)       $score_color="ies";
			else    $score_color="hs";

			$main.="<td align='center' width='$td_width'>"
			."<input type='text' name='score_".$num."' maxlength='3' size='3' value='".$score[$num]."' class='$score_color'></td>";
		}
		else{
			$main.="<td align='center' width='$td_width'>"
			."<input type='text' name='score_".$num."' maxlength='3' size='3' ";
			//�p�G���Z��즳��J���,�b���ܧΦ��ɷ|������J�����Z
			if($score_mem[$num]!="")
				$main.="value=".$score_mem[$num];
			$main.="></td>";
		}
	}
	$main.="</tr></table><hr>\n";
	}
	else{
	$arr_count=0;
		for($score_line=0;$score_line<$exam_time;$score_line++){
			$sco=($score_line<3)?($score_line+1):($score_line-2);
			$sco_name=($score_line<3)?"�w��":"����";

			$p=0;
			$main.="<tr bgcolor='#E1ECFF'><td align='center' width='$td_width' class='css1'>"
			."<font size='1'>��".$sco."��".$sco_name."���Z</font></td>";
			for($j=1;$j<=$line_stu;$j++){
			        $this_score=$score[($i*$line_stu)+$j+$arr_count*$p_number];
			        if($this_score < 60)      $score_color="ls";
			        else if($this_score >100)       $score_color="es";
			        else    $score_color="hs";

			        $p=($p==1)?1:0;
			        if($j>$line_number or $class_score_sn[$arr_count+1]!=($score_line+1))
			                $main.="<td width='$td_width'></td>";
			        else{
			                $main.="<td align='center' width='$td_width' class='$score_color'>"
			                .$this_score."</td>";
			                $p=1;
			        }
			}
			if($p==1) $arr_count++;
				$main.="</tr>\n";
		}
		$main.="</table><hr>\n";
	}
        }
        $main.="</td></tr>";
        return $main;
}

function count_exam_time($global_var){
	global $CONN;
	$str_sel="select class_sn from score_input"
		." where year='$global_var[0]' and semester='$global_var[1]' and c_year='$global_var[2]'"
		." and c_num='$global_var[3]' and c_type='$global_var[4]' order by class_sn";
	$recordSet=$CONN->Execute($str_sel);
	return $exam_time=$recordSet->RecordCount();
}

function &form_kind_v($global_var){
	global $CONN,$p_number,$score_mem,$number,$name,$score;

	$main.="<tr><td align='center' class='css1'>�y��</td><td align='center' class='css1'>�m�W</td><td align='center' class='css1'>���Z</td></tr>\n";
	for($i=1;$i<=$p_number;$i++){
		if($number[$i]!=null){
			$main.="<tr bgcolor='#E1ECFF'><td align='center'>".$number[$i]."</td>"
			."<td align='center'>".$name[$i]."</td>"
			."<td align='center'>"
			."<input type='text' name='score_".$i."' maxlength='3' size='3' value='".$score[$i]."'>"
			."</td></tr>\n";
		}
		else{
			$main.="<tr bgcolor='#E1ECFF'><td align='center'>$i</td>"
			."<td align='center'>name_".$i."</td>"
			."<td align='center'>"
			."<input type='text' name='score_".$i."' maxlength='3' size='3' ";
				if($score_mem[$i]!="")
						$main.="value=".$score_mem[$i];
			$main.="></td></tr>\n";
		}
	}
	return $main;

}

//�s�W,�ק���
function insert_sql($global_var,$ins_or_up){
	global $CONN,$p_number,$score_mem;
	$up_input=update_score_input($global_var);

	if($up_input){
		$class_id=select_class_sn($global_var);

		if($class_id!=0){
		        if($ins_or_up=='ins'){
			for($i=1;$i<=$p_number;$i++){
				$name="name_".$i;
				$score=${"score_".$i};
				$sco_stu="insert into score_stu values('0','$class_id','$i','$name','$score_mem[$i]')";
				$rs_update=$CONN->Execute($sco_stu);
				if(!$rs_update)		print $rs_update->ErrorMsg();
			}
			echo "insert success";
		        }
		        else if($ins_or_up=='up'){
			for($i=1;$i<=$p_number;$i++){
			        $sco_stu="update score_stu set score='$score_mem[$i]' where class_sn='$class_id' and number='$i'";
			        $rs_update=$CONN->Execute($sco_stu);
			        if(!$rs_update)		print $rs_update->ErrorMsg();
			}
			echo "update success";
		        }
		}
		else echo "�L��score_input->class_sn!";
	}
	else echo "score_input �ק異��!";
}

function select_class_sn($global_var){
	global $CONN;

	$kind_type=(($global_var[7])<=3)?"performance":"practice";
	$kind_sort=($kind_type=="performance")?$global_var[7]:($global_var[7]-3);

              $tmp_str="select class_sn from score_input where year='$global_var[0]' and semester='$global_var[1]' and "
		." c_year='$global_var[2]' and c_num='$global_var[3]' and c_type='$global_var[4]'"
		." and score_kind='$kind_type' and score_sort='$kind_sort'";
	$rs_select_class_sn=$CONN->Execute($tmp_str);
	if($rs_select_class_sn){
		$id=$rs_select_class_sn->fields[0];
		return $id;
	}
	else{
		print $rs_select_class_sn->ErrorMsg();
		return false;
	}
}

function update_score_input($global_var){
	global $CONN;
	$class_id=select_class_sn($global_var);
	if($class_id){
		$str="update score_input set modify='$global_var[6]' where class_sn='$class_id'";
		$rs_update_input = $CONN->Execute($str);
		if(!$rs_update_input)	print $rs_update_input->ErrorMsg();
		else return true;
	}
	else return false;
}

function &show_exam_select($global_var){
        global $CONN;

        if($global_var[0] and $global_var[1] and $global_var[2] and $global_var[3] and $global_var[4] ){

	$kind_select="select score_kind,score_sort from score_input where year='$global_var[0]' and semester='$global_var[1]' and "
		." c_year='$global_var[2]' and c_num='$global_var[3]' and c_type='$global_var[4]' order by class_sn";
	$recordkind=$CONN->Execute($kind_select);

	if(!$recordkind->EOF){
		while (!$recordkind->EOF) {
			$kind_type = $recordkind->fields["score_kind"];
			$kind_sort = $recordkind->fields["score_sort"];
			if($kind_type=='performance'){
				$tmp=0;
				$exam_name='�w����';
			}else{
				$tmp=1;
				$exam_name='���ɦ�';
			}
			$n=$tmp*3+$kind_sort;
			$selected=($n==$global_var[7])?"selected":"";
			$kind_tmp .= "<option value='$n' $selected>��".$kind_sort."��$exam_name</option>\n";
			$recordkind->MoveNext();
		}
		if($global_var[7]=='all')       $selected_all='selected';
		$kind_tmp .= "<option value='all' $selected_all>��ܥ����Ҹ�</option>\n";

		return "<select name='score_kind' onChange='jumpMenu()'>
			<option value='0'>���O</option>
			$kind_tmp
			</select>�Ҹ����O";
	}
	else{
		for($a=1;$a<=2;$a++){
			if($a==1) $type='performance';  else $type='practice';
			for($i=1;$i<=3;$i++){
				$kind_select="insert into score_input values ('0','$global_var[0]','$global_var[1]','$global_var[2]'
				,'$global_var[3]','','$global_var[4]','���q�Z','$type','$i','$global_var[6]')";
				$recordinsert=$CONN->Execute($kind_select);
			}
			if($recordinsert)       echo "insert success";
		}
		$show_kind=&show_exam_select($global_var);
		return $show_kind;
	}
        }

        else{
	$str="<select name='score_kind' onChange='jumpMenu()'>
	<option value='0'>���O</option>\n";
	for($i=1;$i<=6;$i++){
		$n=($i<=3)?$i:($i-3);
		$selected=($i==$global_var[7])?"selected":"";
		$exam=($i<=3)?"�w�ɦ�":"���ɦ�";
		$str.="<option value='$i' $selected>��".$n."��$exam</option>\n";
	}
	$str.="<option value='all'>��ܥ����Ҹ�</option></select>�Ҹ����O\n";
	return $str;
        }

}

function add_practice($global_var,$practice_exam){
	global $CONN;
	$select_practice="select score_sort from score_input where year='$global_var[0]' and"
	." semester='$global_var[1]' and c_year='$global_var[2]' and c_num='$global_var[3]'"
	." and c_type='$global_var[4]' and c_kind='���q�Z' and score_kind='practice' and score_sort='$practice_exam'";
	$recordsel=$CONN->Execute($select_practice);
	if(!$recordsel->EOF)
	        echo "�����ɦҤw�s�b!";
	else{
		$insert_practice="insert into score_input values ('0','$global_var[0]','$global_var[1]','$global_var[2]'
		,'$global_var[3]','','$global_var[4]','���q�Z','practice','$practice_exam','$global_var[6]')";
		$recordinsert=$CONN->Execute($insert_practice);
		if(!$recordinsert)       echo "insert fail";
	}
}

function instruction(){
	echo "<table border='0' bgcolor='#ffff87' width='90%' align='center'>
                        <tr bgcolor='#e1ecff'><td><font size='2'>
		�i�ϥλ����j<br>
		1.�̧ǿ�ܦ~�šB�Z�šB��ءB�Φ���A�p�G����ؤw�n�����Z�A�|�q�X���e�ܱаȳB�����Z<br>
		2.���Z��J��k:<br>&nbsp;&nbsp;&nbsp;&nbsp;
		(1) ���i����r<br> &nbsp;&nbsp;&nbsp;&nbsp;
                            (2) +��*�N��100��<br>&nbsp;&nbsp;&nbsp;&nbsp;
                            (3) ?�N��S���ӦҸ�  <br>&nbsp;&nbsp;&nbsp;&nbsp;
                            (4) �bie���ҤU�A��Enter�i�۰ʸ��ܤU�@���A�Die���ҤU�A
                            ex:Netscape �� Mozilla �i�ϥ�Tab��<br>&nbsp;&nbsp;&nbsp;&nbsp;
                            (5) �e�ܱаȳB���N���Z�w�T�w���|�b���F!<br>
		3.�������Φ��ɡA�w��J�����Z���|����
                        </font></td></tr></table>";
}
?>
