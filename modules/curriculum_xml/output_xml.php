<?php
// $Id: output_xml.php 6036 2010-08-26 05:39:46Z infodaes $

require "config.php";

sfs_check();


//�p�G�T�w��XXML�ɮ�
if ($_POST[act]) {
	$out_arr=array();
	//�]�w�ѷӰ}�C
	$semester_arr=array(1=>'�W�Ǵ�',2=>'�U�Ǵ�');
	$class_year_arr=array(0=>'�����~��',1=>'�@�~��',2=>'�G�~��',3=>'�T�~��',4=>'�|�~��',5=>'���~��',6=>'���~��',7=>'�C�~��',8=>'�K�~��',9=>'�E�~��',10=>'�Q�~��',11=>'�Q�@�~��',12=>'�Q�G�~��');
	$dow_arr=array(1=>'�g�@',2=>'�g�G',3=>'�g�T',4=>'�g�|',5=>'�g��',6=>'�g��',7=>'�g��');
	$sector_arr=array(1=>'�Ĥ@�`',2=>'�ĤG�`',3=>'�ĤT�`',4=>'�ĥ|�`',5=>'�Ĥ��`',6=>'�Ĥ��`',7=>'�ĤC�`',8=>'�ĤK�`',9=>'�ĤE�`',10=>'�ĤQ�`',11=>'�ĤQ�@�`',12=>'�ĤQ�G�`',13=>'�ĤQ�T�`',14=>'�ĤQ�|�`');
	
	//�����ئW��
	$subject_arr=array();
	$sql="SELECT subject_id,subject_name FROM score_subject WHERE enable=1";
	$res=$CONN->Execute($sql) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql",256);
	while(!$res->EOF){
		$subject_id=$res->fields['subject_id'];
		$subject_arr[$subject_id]=$res->fields['subject_name'];
		$res->MoveNext();
	}	
//echo "<pre>";
//print_r($subject_arr);	
//echo "</pre>";	
	//����ҵ{���
	$ss_arr=array();
	$sql_ss="SELECT scope_id,ss_id,subject_id,link_ss FROM score_ss WHERE enable=1 ORDER BY year,semester,class_id";
	$res_ss=$CONN->Execute($sql_ss) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql_ss",256);
	while(!$res_ss->EOF){
		$ss_id=$res_ss->fields['ss_id'];
		$scope_id=$res_ss->fields['scope_id'];
		$subject_id=$res_ss->fields['subject_id'];
		$pos=strpos('>>'.$subject_arr[$scope_id],'�u��');
		$ss_arr[$ss_id]['category']=$pos?'�u�ʾǲ߸`��':'���ǲ߸`��';
		$pos=strpos('>>'.$res_ss->fields['link_ss'],'�y��');
		//�N �y��-����y�� �y��-�^�y �y��-�m�g�y��  �q�q�אּ  �y��
		$ss_arr[$ss_id]['learningareas']=$pos?'�y��':$res_ss->fields['link_ss'];
		$ss_arr[$ss_id]['subject']=$subject_arr[$subject_id]?$subject_arr[$subject_id]:$subject_arr[$scope_id];
//echo $ss_id.'-->'.$ss_arr[$ss_id]['learningareas'].'-->'.$ss_arr[$ss_id]['subject'].'---->'.$pos.'<br>';		
		$res_ss->MoveNext();
	}
	
	//����Ҫ��ƶi��}�C�x�s	
	foreach($_POST[year_seme] as $key=>$year_seme){
		$tmp=explode('_',$year_seme);
		$this_year=$tmp[0];
		$this_semester=$tmp[1];
		
		//����Z�ŦW��(school_class)		
		$class_name_arr=array();
		$sql_class="SELECT class_id,c_name FROM school_class WHERE enable=1 AND year=$this_year AND semester=$this_semester ORDER BY class_id";
		$res_class=$CONN->Execute($sql_class) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql_class",256);
		while(!$res_class->EOF){
			$class_id=$res_class->fields['class_id'];
			$class_name_arr[$class_id]=$res_class->fields['c_name'];
			$res_class->MoveNext();
		}
		
		
		$out_arr[$year_seme]['year']=$this_year;
		$out_arr[$year_seme]['semester']=iconv("Big5","UTF-8",$semester_arr[$this_semester]);
		
		$sql="SELECT * FROM score_course WHERE year=$this_year AND semester=$this_semester ORDER BY ";
		$sql.=$_POST['order']?'class_id,day,sector':'teacher_sn,day,sector';
		$res=$CONN->Execute($sql) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF){
			$teacher_sn=$res->fields['teacher_sn'];
			$course_id=$res->fields['course_id'];
			//�|������Ƥ~�i��Юv����^��
			if(!$out_arr[$year_seme]['teacherdata'][$teacher_sn]['name']){
				$sql_teacher="SELECT * FROM teacher_base WHERE teacher_sn=$teacher_sn";
				$res_teacher=$CONN->Execute($sql_teacher) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql_teacher",256);
				$teach_person_id=$res_teacher->fields['teach_person_id'];
				$target_id='';
				for($i=0;$i<10;$i++){
					if($_POST[mask][$i]) $char='*'; else $char=substr($teach_person_id,$i,1);
					$target_id.=$char;
				}
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['teach_person_id']=$target_id;	
				$name=$res_teacher->fields['name'];
				switch($_POST['name']){
					case 0: $name=''; break;
					case 1: $name='������'; break;
					case 2: $name=substr($name,0,2).'����'; break;
				}
				
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['name']=iconv("Big5","UTF-8",$name);
				
				//����Юv�Ҹ��(SFS3����@�@����ơA�s��Ʈw���ӭn���h��)
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['certificates'][$key2]['certdate']=iconv("Big5","UTF-8",$res_teacher->fields['certdate']);
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['certificates'][$key2]['certgroup']=iconv("Big5","UTF-8",$res_teacher->fields['certgroup']);
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['certificates'][$key2]['certarea']=iconv("Big5","UTF-8",$res_teacher->fields['certarea']);
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['certificates'][$key2]['certsujbect']=iconv("Big5","UTF-8",$res_teacher->fields['teach_sub_kind']);
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['certificates'][$key2]['certnumber']=iconv("Big5","UTF-8",$res_teacher->fields['teach_check_word']);
				
				//���ѥ��л��P���
				$domain_subject_arr=explode(';',$res_teacher->fields['master_subjects']); 
				foreach($domain_subject_arr as $key2=>$subject_data){
					$subject_data_arr=explode('_',$subject_data);
					$out_arr[$year_seme]['teacherdata'][$teacher_sn]['teachersubjects'][$key2]['domain']=iconv("Big5","UTF-8",$subject_data_arr[0]);
					$out_arr[$year_seme]['teacherdata'][$teacher_sn]['teachersubjects'][$key2]['expertise']=iconv("Big5","UTF-8",$subject_data_arr[1]);				
				}				
			}
			//����Ҫ���
			$out_arr[$year_seme]['curriculums'][$course_id]['teacheridnumber']=$out_arr[$year_seme]['teacherdata'][$teacher_sn]['teach_person_id'];
			$class_year=$res->fields['class_year'];
			$out_arr[$year_seme]['curriculums'][$course_id]['classyear']=iconv("Big5","UTF-8",$class_year_arr[$class_year]);
			$class_id=$res->fields['class_id'];
			$out_arr[$year_seme]['curriculums'][$course_id]['classname']=iconv("Big5","UTF-8",$class_name_arr[$class_id].'�Z');
			$dow=$res->fields['day'];
			$out_arr[$year_seme]['curriculums'][$course_id]['week']=iconv("Big5","UTF-8",$dow_arr[$dow]);
			$sector=$res->fields['sector'];
			$out_arr[$year_seme]['curriculums'][$course_id]['classtime']=iconv("Big5","UTF-8",$sector_arr[$sector]);

			$ss_id=$res->fields['ss_id'];
			$out_arr[$year_seme]['curriculums'][$course_id]['category']=iconv("Big5","UTF-8",$ss_arr[$ss_id]['category']);
			$out_arr[$year_seme]['curriculums'][$course_id]['learningareas']=iconv("Big5","UTF-8",$ss_arr[$ss_id]['learningareas']);
			$out_arr[$year_seme]['curriculums'][$course_id]['subject']=iconv("Big5","UTF-8",$ss_arr[$ss_id]['subject']);
			
			$res->MoveNext();
		}
	}
	
	//�}�l����BIG5��XML
	
	//����Ǯո��
	$sql='SELECT sch_sheng,sch_cname,sch_id FROM school_base';
	$res=$CONN->Execute($sql) or user_error("Ū���Ǯհ򥻸�ƥ��ѡI<br>$sql",256);
	$cityname=iconv("Big5","UTF-8",$res->fields['sch_sheng']);
	$schoolname=iconv("Big5","UTF-8",$res->fields['sch_cname']);
	$schoolid=iconv("Big5","UTF-8",$res->fields['sch_id']);
	
	$smarty->assign("cityname",$cityname);
	$smarty->assign("schoolname",$schoolname);
	$smarty->assign("schoolid",$schoolid);
	
	$smarty->assign("cert",$_POST['cert']);
	$smarty->assign("out_arr",$out_arr);
	
	switch($_POST['stylesheet']){
		case 0: $stylesheet=''; break;
		case 1: $stylesheet='<?xml-stylesheet type="text/xsl" href="./excoursetransform.xsl"?>'; break;
		case 2: $stylesheet='<?xml-stylesheet type="text/xsl" href="'.$SFS_PATH_HTML.get_store_path().'/excoursetransform.xsl"?>'; break;
	}
	$smarty->assign("stylesheet",$stylesheet);
				

	//�Nsmarty��X����ƥ�cache��
	ob_start();
	$smarty->display("curriculum_1_0.tpl");
	$xmls=ob_get_contents();
	ob_end_clean();
	
	$filename=$SCHOOL_BASE['sch_id'].$school_long_name.date('Ymd')."�Z�ŻP�Юv�Ҫ�XML�洫���.xml";
	header("Content-disposition: attachment; filename=$filename");
	header("Content-Type:text/xml; charset=utf-8");

	echo $xmls;
	exit;
}


head('���Хq�Z�ŻP�Юv�Ҫ�洫XML�ץX');
print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='year_seme[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}

function check_select() {
  var i=0; j=0; answer=true;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].name=='year_seme[]') {
		if(document.myform.elements[i].checked) j++;
    }
    i++;
  }
  
  if(j==0) { alert("�|���������Ǵ��I"); answer=false; }
  
  return answer;
}

</script>
HERE;

//������Ҫ�Ǵ��A���ѿ�椧��
$sql="SELECT distinct year,semester FROM score_course ORDER BY year desc,semester desc";
$res=$CONN->Execute($sql) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql",256);

$main.="<form name='myform' method='post'>
		<table border=2 cellpadding=10 cellspacing=0 style='border-collapse: collapse; font-size=12pt;' bordercolor='#ffcfcf'>
		<tr align='center' bgcolor='#ffffaa'><td><input type='checkbox' name='tag_all' onClick='javascript:tagall(this.checked);'>��ܾǴ�</td><td>��X�ﶵ</td></tr><tr><td>";
while(!$res->EOF) {
	if(curr_year()-$res->fields[year]<$years) {
		$year_seme=$res->fields[year].'_'.$res->fields[semester];
		$year_seme_name=$res->fields[year].'�Ǧ~�ײ�'.$res->fields[semester].'�Ǵ�';
		$this_yeae_seme=curr_year().'_'.curr_seme();
		$checked=$this_yeae_seme==$year_seme?'checked':''; 
		$main.="<input type='checkbox' name='year_seme[]' value='$year_seme' $checked>$year_seme_name<br>";
	}
	$res->MoveNext();
}

$id_mask_list='';
for($i=0;$i<10;$i++){
	$show=$i?$i:'�r��';
	$mask_char=substr($masks,$i,1);
	$checked=($mask_char=='*')?'checked':'';
	$id_mask_list.="<input type='checkbox' name='mask[$i]' value='$show' $checked>$show ";
}
//

$main.="</td><td valign='top'>
<br>���Ҫ��ƱƧǤ覡�G<input type='radio' name='order' value=0 checked>�Z�Ÿ`�� <input type='radio' name='order' value=1>�Юv�`�� 
<br><br>���Юv�Ҹ�ƿ�X�G<input type='radio' name='cert' value=1 checked>����X <input type='radio' name='cert' value=2>�u��X����P�Ҹ� <input type='radio' name='cert' value=3>��X�ԲӸ��
<br><br>�������ҲΤ@�s���B�n�G$id_mask_list
<br><br>���Юv�m�W��X�G<input type='radio' name='name' value=0 checked>�ť� <input type='radio' name='name' value=1>������ <input type='radio' name='name' value=2>��X���r (������) <input type='radio' name='name' value=3>��X���W (���j��)
<br><br>���˵��˦��ѷӡG<input type='radio' name='stylesheet' value=0>�L <input type='radio' name='stylesheet' value=1 checked>�۹���|(./excoursetransform.xsl) <input type='radio' name='stylesheet' value=2>�Ǯ�SFS3�˦��ɪ��ѷӵ�����|
</td></tr>
<tr><td colspan=2>
<input type='submit' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:20px; width=100%; height=80' value='�ץXXML' name='act' onclick='return check_select();'></td></tr></table></form>";

echo $main;

foot();


?>