<?php
//$Id: score_input.php 8273 2015-01-10 14:35:18Z brucelyc $
include "config.php";

//�{��
sfs_check();

//�q�X�����������Y
head("�S�����");
print_menu($school_menu_p);

//�D�n���e
if ($_REQUEST[year_seme]) {
	$ys=explode("_",$_REQUEST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
} else {
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
}

$id=$_REQUEST[id];
$class_id=$_POST[class_id];
$score_spec="score_spec_".$sel_year."_".$sel_seme;
$creat_table_sql="
	CREATE TABLE if not exists $score_spec(
		sn int(11) NOT NULL auto_increment,
		student_sn int(10) unsigned NOT NULL default '0',
		id int(10) unsigned NOT NULL default '0',
		score_str text,
		PRIMARY KEY (student_sn,id),
		UNIQUE KEY (sn)
	)";
$CONN->Execute($creat_table_sql) or die($creat_table_sql);

if ($_POST[save]) {
	$score=$_POST[score];
	while(list($student_sn,$v)=each($score)) {
		reset($v);
		$score_str="";
		while(list($sid,$sc)=each($v)) {
			$score_str.=$sc."@@";
		}
		if ($score_str!="") $score_str=substr($score_str,0,-2);
		$query="select * from $score_spec where student_sn='$student_sn' and id='$id'";
		$res=$CONN->Execute($query);
		if ($res->RecordCount()>0) {
			$query="update $score_spec set score_str='$score_str' where student_sn='$student_sn' and id='$id'";
		} else {
			$query="insert into $score_spec (student_sn,id,score_str) values ('$student_sn','$id','$score_str')";
		}
		$CONN->Execute($query);
	}
}

if ($id) {
	$query="select * from test_manage where id='$id'";
	$res=$CONN->Execute($query);
	$sel_year=$res->fields[year];
	$sel_seme=$res->fields[semester];
	$c_year=$res->fields[c_year];
	$subject_str=$res->fields[subject_str];
	$ratio_str=$res->fields[ratio_str];
	$class_menu=class_menu($sel_year,$sel_seme,$c_year,$class_id);
}
$main="<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>\n";
$year_seme_menu=year_seme_menu($sel_year,$sel_seme);
$test_menu=test_menu($sel_year,$sel_seme,$id);
$main.="<form name=\"f1\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
	<table>
	<tr>
	<td>$year_seme_menu</td><td>$test_menu</td><td>$class_menu</td>
	</tr>
	</table>\n";
if ($class_id) {
	$subject=explode("@@",$subject_str);
	$subject_title="";
	while(list($k,$v)=each($subject)) {
		$subject_title.="<td>$v</td>";
	}
	$main.="<table border=0 cellspacing=1 cellpadding=2 bgcolor=#cccccc class=main_body>\n
		<tr bgcolor='#E1ECFF' align='center'><td>�y��</td><td>�m�W</td>$subject_title</tr>\n";
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$class=explode("_",$class_id);
	$seme_class=intval($class[2].$class[3]);
	$query="select a.student_sn,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and b.stud_study_cond='0' and seme_class='$seme_class' order by a.seme_num";
	$res=$CONN->Execute($query);
	$all_sn="";
	while (!$res->EOF) {
		$sn=$res->fields[student_sn];
		$stud_name[$sn]=$res->fields[stud_name];
		$student_sn[$res->fields[seme_num]]=$sn;
		$all_sn.="'".$sn."',";
		$res->MoveNext();
	}
	if ($all_sn) $all_sn=substr($all_sn,0,-1);
	$query="select * from $score_spec where student_sn in ($all_sn) and id='$id'";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$score_str=$res->fields[score_str];
		$sn=$res->fields[student_sn];
		$score[$sn]=explode("@@",$score_str);
		$res->MoveNext();
	}
	while(list($num,$sn)=each($student_sn)) {
		reset ($subject);
		$subject_input="";
		if ($num % 5==0) {
			$bgcolor1="#CACFFF";
			$bgcolor2="#CACFFF";
		} else {
			$bgcolor1="#E1ECFF";
			$bgcolor2="#ffffff";
		}
		$i=0;
		$cols=count($subject);
		while(list($k,$v)=each($subject)) {
			$subject_input.="<td bgcolor='$bgcolor2'><input type='text' size='3' name='score[".$sn."][".$k."]' value='".$score[$sn][$i]."' onfocus=\"this.select();return false;\" onkeydown=\"moveit2(this,event,$cols);\"  class='sc'></td>";
			$i++;
		}
		$main.="<tr bgcolor='$bgcolor1' align='center'><td>$num</td><td>".$stud_name[$sn]."</td>$subject_input</tr>\n";
	}
	$main.="</table><input type='submit' name='save' value='�x�s'> <a href='./score_output.php?id=$id&class_id=$class_id'>�C�L</a><input type='hidden' name='subject_str' value='$subject_str'><input type='hidden' name='ratio_str' value='$ratio_str'>";
}
$main.="</tr></table></form>";
echo $main;

//�G������
foot();
?>
<script language="JavaScript">
<!--
function moveit2(chi,event,cols) {
	var pKey = event.keyCode;//�Q�r�� 38�V�W 40�V�U;37�V��;39�V�k
	if (pKey==40 || pKey==38 || pKey==37 || pKey==39 ) {
		var max=document.f1.elements.length ;//�Ҧ�����ƶq
		var Go=0;//�n���ʦ�m
		TText= new Array ; //��r���}�C
		var Tin=0; //��r���}�C����
		var Tin_now=0; //��r���}�C���ޥثe��m
		for(i=0; i<max; i++) {
			var obj = document.f1.elements[i];
			if (obj.type == 'text')	{
				TText[Tin]=i; //�O�U���b�Ҧ��������ĴX��
				if(obj.name==chi.name ) {Tin_now=Tin;} //�p�G�O�Ƕi�Ӫ����,�N�O�U�����b��r���}�C���ޭ�
				Tin=Tin+1;
			}
		}
		if (Tin==1 ) return false;//�Ȥ@�ӴN���n���F
//		if (pKey==40 || pKey==39 ) KK=40;
//		if (pKey==38 || pKey==37 ) KK=38;
		switch (pKey){ //�`�j
			case 40://�V�U
				Tin=Tin-1;//���o���ޭ�
				((Tin_now+cols) > Tin ) ? Go=TText[Tin_now] : Go=TText[(Tin_now+cols)];
				document.f1.elements[Go].focus();
				return false;
				break;
			case 38://�V�W
				Tin=Tin-1;//���o���ޭ�
				((Tin_now-cols) < 0 ) ? Go=TText[Tin_now] : Go=TText[(Tin_now-cols)];
				document.f1.elements[Go].focus();
				return false;
				break;
			case 39://�V�k
				Tin=Tin-1;//���o���ޭ�
				(Tin_now == Tin ) ? Go=TText[0] : Go=TText[Tin_now+1];
				document.f1.elements[Go].focus();
				return false;
				break;
			case 37://�V��
				Tin=Tin-1;//���o���ޭ�
				(Tin_now == 0 ) ? Go=TText[Tin] : Go=TText[(Tin_now-1)];
				document.f1.elements[Go].focus();
				return false;
				break;
			default:
				return false;
		}
	}
}
//-->
</script>
