<?php

include "config.php";
sfs_check();

$year_seme=$_POST[year_seme]?$_POST[year_seme]:sprintf("%03d%d",curr_year(),curr_seme());

//�Ǵ����
$year_seme_select="<select name='year_seme' onchange=\"this.form.target='$_PHP[SCRIPT_NAME]'; this.form.submit()\">";
$query = "select year,semester from school_class where enable=1 group by year,semester order by year desc,semester ";
$result = $CONN->Execute($query) or trigger_error("SQL�y�k���~�G $query", E_USER_ERROR);
while(!$result->EOF){ 
	$key=sprintf("%03d%d",$result->fields[0],$result->fields[1]);
	$value=$result->fields[0]."�Ǧ~��".$result->fields[1]."�Ǵ�";
	$selected=($year_seme==$key)?' selected':'';
	$year_seme_select.="<option value='$key'$selected>$value</option>";	
	$result->MoveNext();
}
$year_seme_select.="</select>";

head("���ɬ�����Ƨ�����ˬd");
print_menu($menu_p);

$class_name_arr=class_base();

//��X�a�x����
$record_home=SFS_TEXT("�a�x����");

//����s�Z�O���̪��ǥͦC��(�u��ثe�b�Ǿǥ�)
$check_array=array(sse_relation=>"�������Y",sse_family_kind=>"�a�x����",sse_family_air=>"�a�x��^",sse_farther=>"���ޱФ覡",sse_mother=>"���ޱФ覡",sse_live_state=>"�~����",sse_rich_state=>"�g�٪��p",sse_s1=>"�̳߷R���",sse_s2=>"�̧x�����",sse_s3=>"�S��~��",sse_s4=>"����",sse_s5=>"�ͬ��ߺD",sse_s6=>"�H�����Y",sse_s7=>"�~�V�欰",sse_s8=>"���V�欰",sse_s9=>"�ǲߦ欰",sse_s10=>"���}�ߺD",sse_s11=>"�J�{�欰");
$error_array=array();

$sql="select a.*,b.stud_name,b.curr_class_num from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme ='$year_seme' and b.stud_study_cond in (0,15) order by curr_class_num";
$res=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G$sql", E_USER_ERROR);
while(!$res->EOF){
	$stud_id=$res->fields[stud_id];
	$student_sn=$res->fields[student_sn];
	$stud_name=$res->fields[stud_name];
	$grade=substr($res->fields[seme_class],0,-2);
	$class_name=$class_year[$grade].$res->fields[seme_class_name].'�Z';
	$curr_class_num=$res->fields[curr_class_num];
	$curr_class=substr($curr_class_num,0,-2);
	
	//���stud_eduh���  seme_year_seme  stud_id 
	$sql="SELECT * FROM stud_seme_eduh WHERE seme_year_seme='$year_seme' and stud_id='$stud_id';";
	$res2=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G$sql", E_USER_ERROR);
	$sse_family_kind=$res2->fields[sse_family_kind];
	//if($res2->recordcount()){
		foreach($check_array as $key=>$value){
			$value=str_replace(',','',$value);
			if(! $res2->fields[$key]){
				$error_array[$curr_class][$curr_class_num][stud_name]=$stud_name;
				$error_array[$curr_class][$curr_class_num][class_name]=$class_name;
				$error_array[$curr_class][$curr_class_num][sse_family_kind]=$record_home[$sse_family_kind];
				$error_array[$curr_class][$curr_class_num][error].=$value.',';	
			}
		}
		//if($error_array[$curr_class][$curr_class_num][error]) echo "<br>$sql<br>";
	//}
	$res->MoveNext();
}



//�}�l�C��
$showdata="<table border=1 cellpadding=3 cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'><tr><td colspan=$col bgcolor='#AAAAFF' align='center'>
			<tr align='center' bgcolor='#ffcccc'><td>�ثe�Z��</td><td>�y��</td><td>�m�W</td><td>��Ǵ��NŪ�Z��</td><td>�a�x����</td><td>�����O����</td></tr>";
$class_info='���Z�ŤH�Ʋέp�G';			
foreach($error_array as $class_id=>$students){
	$class_count=count($students);
	$class_info.="{$class_name_arr[$class_id]}($class_count);";
	foreach($students as $curr_class_num=>$value){
		//$stud_count=count($students);
		$class_no=substr($curr_class_num,-2);
		$showdata.="<tr align='center'><td width=70>{$class_name_arr[$class_id]}</td><td width=30>$class_no</td><td width=70>{$value[stud_name]}</td><td width=100>{$value[class_name]}</td><td width=60>{$value[sse_family_kind]}</td><td align='left'>{$value[error]}</td></tr>";
	}
}
$showdata.="</table>";
echo "<form name='myform' method='post'>$year_seme_select $showdata<br><font color='red' size=2>$class_info</font></form>";
foot();

?>
