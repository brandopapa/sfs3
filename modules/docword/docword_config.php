<?php

// $Id: docword_config.php 5310 2009-01-10 07:57:56Z hami $

/* ���J�ǰȨt�γ]�w */
require_once "../../include/config.php";
//���J�禡�w
require_once "../../include/sfs_case_PLlib.php";

//�]�������ܼƪ��A
require_once "../../include/sfs_core_globals.php";
//���o�Ҳճ]
$m_arr = get_sfs_module_set("docword");
extract($m_arr, EXTR_OVERWRITE);

/* �{������ */
$prob = array("doc1_list.php"=>"�����","doc_out_list.php"=>"�o���","doc_unit.php"=>"*���޲z","doc_list_print.php"=>"*�P���M�U�C�L");

/* ���媬�A */
$doc_stat_array = array("1" =>"���k�ɤ���","2" =>"�w�k�ɤ���","9"=>"�w�P������");

/* �l�{������--���� */
$prob_doc1 = array("doc_in.php"=>"�s�W����","doc_print.php"=>"�C�Lñ����");

/* �l�{������--�o�� */
$prob_doc2 = array("doc_out.php"=>"�s�W�o��","doc_print.php"=>"�έp");

/*�ˬd�X �ŧ�*/
$ischecked = false;

/*! @function doc1_unit()
    @abstract �B�ǳ��W��
    @result �^�ǰ}�C
*/
function doc_unit(){
	$temp = array();
	$query = "select * from sch_doc1_unit order by doc1_unit_num1 ";
	$result = mysql_query ($query);
	while ($row = mysql_fetch_array ($result))
		$temp["$row[doc1_unit_num1]"] = $row[doc1_unit_name];
	return $temp;
}

/*! @function doc_kind()
    @abstract �B�ǳ��W��
    @result �^�ǰ}�C
*/
function doc_kind(){
	return array("1"=>"��","2"=>"�Ѩ�","3"=>"�O","4"=>"���i","5"=>"�}�|�q����","6"=>"ñ","7"=>"���ץ�q����","8"=>"��ĳ�ץ�q����","9"=>"�ʿ�ץ�q����","10"=>"�����");
}
/*! @function doc_kind()
    @abstract �O�s�~��
    @result �^�ǰ}�C
*/
function doc_life(){
	return array("1"=>"1","3"=>"3","5"=>"5","10"=>"10","15"=>"15","30"=>"30","99"=>"�ä[");
}


//�{���D��
function prog($key_prob){
	global $stud_id ,$prob,$ischecked;	
	
	echo "<table cellSpacing=0 cellPadding=0  align=center bgColor=#000000 border=0>
  <tbody>
    <tr>
      <td>
        <table cellSpacing=1 cellPadding=3 width=100% border=0>
          <tbody>
          <tr>";
          
	$i =1;
	while ( list( $key, $val ) = each( $prob ) ){
		if (substr($val,0,1) != "*" or ($ischecked)){
			if ($key_prob == $i++)
				echo "<td bgcolor=yellow ><a href=\"$key\">$val</a></td>"; 
			else
				echo "<td bgcolor=#CCCCCC><a href=\"$key\">$val</a></td>";   
		}
	}	
	if ($ischecked) //�q�L�{��
		echo "<td bgcolor=#CCCCCC><a href=\"log.php?sel=out\">�n�X�t��</a></td>";
	else
		echo "<td bgcolor=#CCCCCC><a href=\"log.php?sel=in\">�n�J�t��</a></td>";
	
	echo "</tr></tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>";
}

//����l��
function prog_doc1($key_prob){
	global $stud_id ,$prob_doc1;	
	echo "<table align=center  bgcolor=#D0DCE0  ><tr><td><img src=\"images/tree_end.gif\"></td>";
	$i =1;
	while ( list( $key, $val ) = each( $prob_doc1 ) ){
		if ($key_prob == $i++)
			echo "<td bgcolor=yellow ><a href=\"$key\">$val</a></td>"; 
		else
			echo "<td><a href=\"$key\">$val</a></td>";   
	}
	echo "</tr></table>";
}

//�o��l��
function prog_doc2($key_prob){
	global $stud_id ,$prob_doc2;	
	echo "<table align=center  bgcolor=#D0DCE0 ><tr><td><img src=\"images/tree_end.gif\"></td>";
	$i =1;
	while ( list( $key, $val ) = each( $prob_doc2 ) ){
		if ($key_prob == $i++)
			echo "<td bgcolor=yellow ><a href=\"$key\">$val</a></td>"; 
		else
			echo "<td><a href=\"$key\">$val</a></td>";   
	}
	echo "</tr></table>";
}

?>
