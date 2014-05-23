<?php
// $Id: output_xml.php 6036 2010-08-26 05:39:46Z infodaes $

require "config.php";

sfs_check();


//�p�G�T�w��XXML�ɮ�
if ($_POST[act]) {
	$out_arr=array();

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
//exit;
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
		//�N"�ͬ�"�אּ"�ͬ��ҵ{"
		if($ss_arr[$ss_id]['learningareas']=='�ͬ�') $ss_arr[$ss_id]['learningareas']='�ͬ��ҵ{';
		//�N"�u�ʾǲ�"�אּ"�u�ʽҵ{"
		if($ss_arr[$ss_id]['learningareas']=='�u�ʾǲ�') $ss_arr[$ss_id]['learningareas']='�u�ʽҵ{';
                //���w�q�E�~�@�e�����h�אּ�u�ʽҵ{
		if($ss_arr[$ss_id]['learningareas']=='') $ss_arr[$ss_id]['learningareas']='�u�ʽҵ{';
		$res_ss->MoveNext();
	}
	
	//����Ҫ��ƶi��}�C�x�s	
	foreach($_POST[year_seme] as $key=>$year_seme){
		$tmp=explode('_',$year_seme);
		$this_year=$tmp[0];
		$this_semester=$tmp[1];
		
		$sql="SELECT * FROM score_course WHERE year=$this_year AND semester=$this_semester ORDER BY teacher_sn,ss_id,class_id";
		$res=$CONN->Execute($sql) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF){
			$teacher_sn=$res->fields['teacher_sn'];
			$ss_id=$res->fields['ss_id'];
			//�|������Ƥ~�i��Юv����^��
			if(!$out_arr[$year_seme]['teacherdata'][$teacher_sn]['name']){
				$sql_teacher="SELECT * FROM teacher_base WHERE teacher_sn=$teacher_sn";
				$res_teacher=$CONN->Execute($sql_teacher) or user_error("Ū���Ҫ�]�w��ƥ��ѡI<br>$sql_teacher",256);
				$teach_person_id=$res_teacher->fields['teach_person_id'];
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['teach_person_id']=$teach_person_id;
				$name=$res_teacher->fields['name'];
				switch($_POST['name']){
					case 0: $name=''; break;
					case 1: $name='������'; break;
					case 2: $name=substr($name,0,2).'����'; break;
				}
				$out_arr[$year_seme]['teacherdata'][$teacher_sn]['name']=iconv("Big5","UTF-8",$name);
			}
			//����Ҫ���
			$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id]['subject_name']=iconv("Big5","UTF-8",$ss_arr[$ss_id]['subject']);
			$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id]['learningareas']=iconv("Big5","UTF-8",$ss_arr[$ss_id]['learningareas']);
			
			//�̥��ݽҤ��O�p��
			$counter_type='counter_'.$res->fields['c_kind'];
			$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id][$counter_type]=$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id][$counter_type]+1;
			$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id]['counter']=$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id]['counter']+1;
			
			$class_name=sprintf('%d%02d',$res->fields['class_year'],$res->fields['class_name']).',';
			$class_check=' '.$out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id]['class_list'];
			if(! strpos($class_check,$class_name)) $out_arr[$year_seme]['teacherdata'][$teacher_sn]['subjects'][$ss_id]['class_list'].=$class_name;
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
	$smarty->assign("x_id",$_POST['x_id']);
	$smarty->assign("x_pwd",$_POST['x_pwd']);
			
	$smarty->assign("this_year",$this_year);
	$smarty->assign("this_semester",$this_semester);
	
	$smarty->assign("cert",$_POST['cert']);
	$smarty->assign("out_arr",$out_arr);

	//�Nsmarty��X����ƥ�cache��
	ob_start();
	$smarty->display("curriculum_x.tpl");
	$xmls=ob_get_contents();
	ob_end_clean();
	
	$filename=$SCHOOL_BASE['sch_id'].$school_long_name.date('Ymd')."���p�ǱЮv���B�t�νҪ�XML�洫���.xml";
	header("Content-disposition: attachment; filename=$filename");
	header("Content-Type:text/xml; charset=utf-8");
 //�]�� IE 6,7,8 �b SSL �Ҧ��U�L�k�U��
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

	echo $xmls;
	exit;
}


head('��Хq���p�ǱЮv���B�t�νҪ�洫XML�ץX');
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
		<tr align='center' bgcolor='#ffffaa'><td>��ܾǴ�</td><td>��X�ﶵ</td></tr><tr><td>";
		//<tr align='center' bgcolor='#ffffaa'><td><input type='checkbox' name='tag_all' onClick='javascript:tagall(this.checked);'>��ܾǴ�</td><td>��X�ﶵ</td></tr><tr><td>";
while(!$res->EOF) {
	if(curr_year()-$res->fields[year]<$years) {
		$year_seme=$res->fields[year].'_'.$res->fields[semester];
		$year_seme_name=$res->fields[year].'�Ǧ~�ײ�'.$res->fields[semester].'�Ǵ�';
		$this_yeae_seme=curr_year().'_'.curr_seme();
		$checked=$this_yeae_seme==$year_seme?'checked':''; 
		//$main.="<input type='checkbox' name='year_seme[]' value='$year_seme' $checked>$year_seme_name<br>";
		$main.="<input type='radio' name='year_seme[]' value='$year_seme' $checked>$year_seme_name<br>";
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
/*
$main.="</td><td valign='top' align='center'>
<br><br>���פJ�b���G<input type='text' name='x_id' value='$x_id'>
<br><br>���פJ�K�X�G<input type='PASSWORD' name='x_pwd' value='$x_pwd'>
<br><br>���Юv�m�W��X�G<input type='radio' name='name' value=0>�ť� <input type='radio' name='name' value=1>������ <input type='radio' name='name' value=2>��X���r (������) <input type='radio' name='name' value=3 checked>��X���W (���j��)
<br><br><br><font size=2 color='red'>���w�]���b���K�X�i�ܼҲ��ܼƳ]�w</font>
</td></tr>
<tr><td colspan=2>
<input type='submit' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:20px; width=100%; height=80' value='�ץXXML' name='act' onclick='return check_select();'></td></tr></table></form>";
*/
$main.="</td><td valign='top' align='center'><br><br>���Юv�m�W��X�G<input type='radio' name='name' value=0>�ť� <input type='radio' name='name' value=1>������ <input type='radio' name='name' value=2>��X���r (������) <input type='radio' name='name' value=3 checked>��X���W (���j��)
<br><br>
<input type='submit' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:20px; width=100%; height=80' value='�ץXXML' name='act' onclick='return check_select();'></td></tr></table></form>";

echo $main;

foot();


?>