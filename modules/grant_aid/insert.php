<?php
// $Id: insert.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//���o�e�@����T
$curr_year_seme=($_POST[curr_year_seme]);
$dollar=($_POST[dollar]);
$sel_stud=($_POST[sel_stud])?$_POST[sel_stud]:$_GET[sel_stud];
$type=($_POST[type])?$_POST[type]:$_GET[type];


//�Ǵ��O
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

//�q�X����
head("���U�Ǫ�");
echo $menu;

//���o�}�C����
$count = count($sel_stud);

if($count<1) { echo "<center><BR><BR><BR><BR><H1><a href='add.php?type=$type'><img border='0' src='images/back.gif'> �z�å��Ŀ����ǥͳ�!!</a></center>"; }
else {
        //�N�n�g�J���ȦX�֦��@�r��
        for($i=0; $i<$count; $i++)
        {
                $values.="('".$type."','".$curr_year_seme."',".$sel_stud[$i].",".$dollar.")";
                if($i<$count-1) $values.=","; else $values.=";";
        }

        //�s����Ʈw�e�Xsql
        $values="insert into grant_aid(type,year_seme,student_sn,class_num,dollar) values ".$values;
//        echo $values;

        $recordSet=$CONN->Execute($values) or user_error("Ū�����ѡI<br>$values",256);

        //�e�X�g�J�X�����T���M�s���^��C����
        echo "<center><BR><BR><BR><BR><H1><a href='index.php?type=$type'><img border='0' src='images/back.gif'> �w�s�W[$count]�����U����!<BR>�Ы����^�C�ܭ����ˬd</a></center>";
}
foot();

?>