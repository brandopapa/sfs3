<?php
// $Id: config.php 5310 2009-01-10 07:57:56Z hami $
require_once "./module-cfg.php";
require "../../include/config.php";

head('���A���@���Ҳ�');
echo "<div style='font-size:20px;margin:20px ;'>���Ҳդw���A���@!! <br />���~�ͧ@�~�����\��,�Ч��<a href='../stud_grade/'>���~�ͤɾǸ��</a> �ާ@</div>";
foot();
exit;

require "../../include/sfs_case_studclass.php";
require "../../include/sfs_case_subjectscore.php";
require "../../include/sfs_case_PLlib.php";
require "../../include/sfs_oo_zip2.php";
require "my_fun.php";

//�Ǧ^���~��ƪ��Ǧ~�}�C
function get_grad_year() {
	global $CONN;	
	$query = "select  stud_grad_year from grad_stud order by stud_grad_year ";
	$result = $CONN->Execute($query) or trigger_error("SQL�y�k���~�G $query", E_USER_ERROR);
	$i=0;
	while(!$result->EOF){ 
		$index[$i] = $result->fields[0];
		$i++;
		$result->MoveNext();
	}
	//�h�����ƭ�
	$rr=deldup($index);
	//$rr[$index_temp] = $result->fields[0]."�Ǧ~�ī�";
	// return $rr;	
	return (!$rr) ? array() : $rr; 

	// �P�_ $rr �O�_�s�b? �Y���s�b�h�Ǧ^���Ű}�C	
}

//�@�Ӥ����Ӱ}�C�A�M��h�����ƪ��Ȫ����
function  deldup($a){

        $i=count($a);
        for  ($j=0;$j<=$i;$j++){
                      for  ($k=0;$k<$j;$k++){
                                    if($a[$k]==$a[$j]){
                                            $a[$j]="";
                                    }
                      }
        }
        $q=0;
        for($r=0;$r<=$i;$r++){
                      if($a[$r]!=""){
                                      $d[$q]=$a[$r];
                                      $q++;
                      }
          }

return  $d;
}

//��X�o�ӭȬO�}�C���ĴX�j���Aa�O�@�ӼơAb�O�@�Ӱ}�C
function  how_big($a,$b){
    $sort=1;
    for($i=0;$i<count($b);$i++){
        if($a<$b[$i]) $sort++;
    }
    return  $sort;
}
?>
