<?php
// $Id: batchinsert.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//���o�e�@����T
$curr_year_seme=($_POST[curr_year_seme]);
$dollar=($_POST[dollar]);
$sel_stud=($_POST[sel_stud]);


//�Ǵ��O
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

//�q�X����
head("���U�Ǫ�");
echo $menu;

//���o�}�C����
$count = count($sel_stud);

if($count<1) { echo "<center><BR><BR><BR><BR><H1><a href='batchadd.php'><img border='0' src='images/back.gif'> �z�å��Ŀ����ǥ����O��!!</a></center>"; }
else {
        //�N������O���ǥ͸�ƨ��X�üg�Jgrant_aid��Ʈw
        for($i=0; $i<$count; $i++)
        {
                $sql_select="select curr_class_num,student_sn from stud_base where (stud_kind like '%,$sel_stud[$i],%') and (stud_study_cond=0) order by curr_class_num";
                $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
                $reccount=$recordSet->recordcount();
                if($reccount>0)
                {
                $values="";

                while(list($curr_class_num,$student_sn)=$recordSet->FetchRow()) {
                        $values.="('".$type."','".$curr_year_seme."',".$student_sn.",".$curr_class_num.",".$dollar.")";
                        if($recordSet->CurrentRow()<$reccount) $values.=","; else $values.=";";
                $total=$total+1;
                }
                //�s����Ʈw�e�Xsql
                $values="insert into grant_aid(type,year_seme,student_sn,class_num,dollar) values ".$values;
                $recordSet=$CONN->Execute($values) or user_error("Ū�����ѡI<br>$values",256);
                }
        }
        //�e�X�g�J�X�����T���M�s���^��C����
        if($total>0) echo "<center><BR><BR><BR><BR><H1><a href='index.php?type=$type'><img border='0' src='images/back.gif'> �w�s�W[$count]���ǥ�,�@[$total]�����U����!<BR>�Ы����^�C�ܭ����ˬd</a></center>";
        else echo "<center><BR><BR><BR><BR><H1><a href='batchadd.php?type=$type'><img border='0' src='images/back.gif'> �z��w�����O�A�å��t�����󪺾ǥͬ���!<BR>�Ы����^���O�������</a></center>";
}

foot();

?>