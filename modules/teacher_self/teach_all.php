<?php
$birth_p = array( "01 �x�_��","02 ������","03 �y����","04 �򶩥�","05 �x�_��","06 ��鿤","07 �s�˿�","08 �s�˥�","09 �]�߿�","10 �x����","11 �x����","12 �n�뿤","13 ���ƿ�","14 ���L��","15 �Ÿq��","16 �Ÿq��","17 �x�n��","18 �x�n��","19 ������","20 �̪F��","21 �x�F��","22 �Ὤ��","23 ���","24 ������","25 �s����");

$official_level_p = array ("1 ²��","2 �˥�","3 �e��");
$remove_p = array ("1 �եX","2 �h��","3 �N�Ҵ���","4 �껺","5 �R���O��");

/**
 *	�����汱�� *
 *	@param $sql_select - SQL�ԭz
 *	@return string ��椺�e
 */

function teacher_list($sql_select)
{
	global $conID,$curr_name,$curr_teach_id,$curr_teach_condition,$teach_next;
	$result = mysql_query ($sql_select,$conID)or die($sql_select);
	$tol_num = mysql_num_rows($result);
	if ($tol_num > 0){
		$temp_menu ="<table><form name=\"mform\" method=\"post\"><tr><td align=right><font size=2>�`�H��:$tol_num �H</font></td></tr><tr><td><select name=curr_teach_id  size=18 onchange=\"document.mform.submit()\">";
		$tempi = 0;
		while ($row = mysql_fetch_array($result)) {
			$teach_id = $row["teach_id"];
			$name = $row["name"];
			if ($flag==1) {
				$teach_next = $teach_id;
				$flag=0;
			} //�O���U�@��
			if ($teach_id == $curr_teach_id or ($curr_teach_id =="" and $tempi ==0 )){
				$temp_menu .="<option value=\"$teach_id\" selected >$teach_id--$name</option>\n";
				$curr_name =$name;
				$flag = 1;
				$curr_teach_id = $teach_id;
			}
			else
				$temp_menu .="<option value=\"$teach_id\">$teach_id--$name</option>\n";
			$tempi++;
		}
		$temp_menu .="</td></tr>";
	}
	else
		$temp_menu .= "<table><tr><td>�L���</td></tr>";
	$temp_menu .= "<tr><td align=right><font size=2>";
	if ($curr_teach_condition == 0)
		$temp_menu .= "<a href=\"$PHP_SELF?curr_teach_id=$curr_teach_id&curr_teach_condition=1\">�����¾���</a>";
	else
		$temp_menu .= "<a href=\"$PHP_SELF?curr_teach_id=$curr_teach_id&curr_teach_condition=0\">��ܦb¾���</a>";
	$temp_menu .= "</font></td></tr></form></table>";
	
	return $temp_menu; 
}


/**
 *	�W���� *
 *	@param $key_prob - ���ID
 */
function teach_prob($key_prob)
{
	global $curr_name,$curr_teach_id,$curr_teach_condition;
	$prob = array ("teach_list.php"=>"�򥻸��","teach_post.php"=>"��¾���","teach_class.php"=>"�ҰȦw��");
	echo "<table align=center  bgcolor=#D0DCE0 ><tr>";
	$i =1;
	while ( list( $key, $val ) = each( $prob ) ){
		if ($key_prob == $i++)
			echo "<td bgcolor=yellow ><a href=\"$key?curr_teach_id=$curr_teach_id&curr_teach_condition=$curr_teach_condition\">$val</a></td>";
		else
			echo "<td><a href=\"$key?curr_teach_id=$curr_teach_id&curr_teach_condition=$curr_teach_condition\">$val</a></td>";
	}
	echo "<td nowrap> -- <b><font color=blue>$curr_name</font></b></td>
	</tr></table>";
}
?>