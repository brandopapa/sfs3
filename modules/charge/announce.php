<?php
// $Id: announce.php 7873 2014-02-13 09:03:54Z infodaes $

include "config.php";
include "my_fun.php";
include "../../include/sfs_oo_zip2.php";

sfs_check();

//�Ǵ��O
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];
$class_id=$_POST[class_id];
$selected_stud=$_POST[selected_stud];
$dollars=$_POST[dollars];
$grade=substr($class_id,0,1);
$announce_template=$_POST[announce_template];


//�B�z�W�Ǧۭq���榡
if($_POST['do_key']=='�W��') {
        $default_filename='myown_template.sxw';
		$is_win=ereg('win', strtolower($_SERVER['SERVER_SOFTWARE']))?true:false;
        //�Q��score_paper�Ҳո̤w�g����unzip.exe
		$zipfile=($is_win)?"$SFS_PATH/modules/score_paper/UNZIP32.EXE":"/usr/bin/unzip";

        $arg1=($is_win)?"START /min cmd /c ":"";
        $arg2=($is_win)?"-d":"-d";

        if($_FILES['myown']['type'] == "application/vnd.sun.xml.writer"){
                $filename=$default_filename;
        }elseif(strtolower(substr($_FILES['myown']['name'],-3))=="sxw"){
                $filename=$default_filename;
        }else{
                die("�ФW��sxw�����ɮ�!!");
        }

        if (!is_dir($UPLOAD_PATH)) {
                die("�W�ǥؿ� $UPLOAD_PATH ���s�b�I");
        }


        //�Τ@�W�ǥؿ�
        $upath=$UPLOAD_PATH."charge";
        if (!is_dir($upath))  { mkdir($upath) or die($upath."�إߥ��ѡI"); }

        //�W�ǥت��a
		$todir=$upath;
		$the_file=$todir.'/'.$filename;
		copy($_FILES['myown']['tmp_name'],$the_file);
        unlink($_FILES['myown']['tmp_name']);
		
        if (!file_exists($zipfile)) {
                die($zipfile."���s�b�I");
        }elseif(!file_exists($the_file)) {
                die($the_file."���s�b�I");
        }

        $cmd=$arg1." ".$zipfile." ".$the_file." ".$arg2." ".$todir;
        exec($cmd,$output,$rv);
}

// ���X�Z�ŦW�ٰ}�C
$class_base= class_base($work_year_seme);

if($selected_stud AND $_POST['act']=='�C�L'){
	//���o���ئW��
	$sql="select * from charge_item where item_id=$item_id";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);

	$data_arr=get_item_stud_list($item_id,$selected_stud);

	//=============================================================================
	
	//�ɦW
	$filename=$work_year_seme."_���O�q����_".$res->fields[item]."_".$class_id.".sxw";
	
	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($announce_template);
	
	/*
	        // �[�J��ӥؿ�
	        $ttt->addDir("META-INF");

	        // �[�J�ɮ�
	        $ttt -> addFile("styles.xml");
	        $ttt -> addFile("meta.xml");
	        $ttt -> addFile("settings.xml");
	*/
	
	//�[�J xml �ɮר� zip ���A�@�������ɮ� 
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
	
	if (is_dir($announce_template)) { 
		if ($dh = opendir($announce_template)) { 
			while (($file = readdir($dh)) !== false) { 
				if($file=="." or $file==".." or $file=="content.xml" or $file=="Configurations2" or $file=="Thumbnails" or strtoupper(substr($file,-4))=='.SXW') {
					continue;
				}elseif(is_dir($announce_template."/".$file)){
					if ($dh2 = opendir($announce_template."/".$file)) { 
						while (($file2 = readdir($dh2)) !== false) { 
							if($file2=="." or $file2==".."){
								continue;
							}else{
								$data = $ttt->read_file($announce_template."/".$file."/".$file2);
								$ttt->add_file($data,$file."/".$file2);
							}
						} 
						closedir($dh2); 
					} 
				}else{
					$data = $ttt->read_file($announce_template."/".$file);
					$ttt->add_file($data,$file);
				}
			} 
			closedir($dh); 
		} 
	} 
		
	
	//Ū�X content.xml 
	$data = $ttt->read_file($announce_template."/content.xml");
	// �[�J���� tag
	$data = str_replace("<office:automatic-styles>",'<office:automatic-styles><style:style style:name="BREAK_PAGE" style:family="paragraph" style:parent-style-name="Standard"><style:properties fo:break-before="page"/></style:style>',$data);
	
	//��� content.xml
	$arr1 = explode("<office:body>",$data);
	//���Y
	$doc_head = $arr1[0]."<office:body>";
	$arr2 = explode("</office:body>",$arr1[1]);
	//��Ƥ��e
	$content_body = $arr2[0];
	//�ɧ�
	$doc_foot = "</office:body>".$arr2[1];
	$replace_data ="";
	
	foreach($data_arr as $key=>$val){
		//���X���
		$my_content_body=$content_body;
		//�N content.xml �� tag ���N
		$temp_arr["item"]=$res->fields[item];
		$temp_arr["school"]=$school_short_name;
		$temp_arr["year_seme"]=$work_year_seme;
		$temp_arr["class"]=$class_base[$class_id];
		$temp_arr["record_id"]=$data_arr[$key][record_id];
		$temp_arr["stud_name"]=$data_arr[$key][stud_name];
		$temp_arr["num"]=substr($temp_arr[record_id],-2);
		$temp_arr["total"]=$data_arr[$key][total];
		$temp_arr["barcode"]="*".$item_id."-".$temp_arr[record_id]."-".$temp_arr[total]."*";
		$temp_arr["guardian"]=$data_arr[$key][guardian];
		
		$temp_arr["authority"]=$res->fields[authority];
		$temp_arr["paid_method"]=$res->fields[paid_method];
		$temp_arr["paid_date"]='��'.$res->fields[start_date].'�_��'.$res->fields[end_date].'��';
		$temp_arr["announce_note"]=$res->fields[announce_note];
		$temp_arr["announce_note2"]=$res->fields[announce_note2];
		$temp_arr["footer"]=$m_arr['footer'];
		
		//�N�ӥإ[�J  �w�]�̦h�ӥؼƬ�20
		reset($array_keys);
		$detail_keys=array_keys($data_arr[$key][detail]);
		for($i=0;$i<20;$i++)
		{
			$temp_arr["detail_$i"]=$detail_keys[$i];
			$temp_arr["per_$i"]=$data_arr[$key][detail][$temp_arr["detail_$i"]][percent]?$data_arr[$key][detail][$temp_arr["detail_$i"]][percent]."%":"";
			$temp_arr["dollars_$i"]=$data_arr[$key][detail][$detail_keys[$i]][original]-$data_arr[$key][detail][$detail_keys[$i]][decrease_dollars];
		}
		// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
		$replace_data.=$ttt->change_temp($temp_arr,$my_content_body,0);
		//$replace_data.="<text:p text:style-name=\"break_page\"/>";  //����
	}
	//Ū�X XML ���Y
	$replace_data =$doc_head.$replace_data.$doc_foot;

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();
	
	//�H��y�覡�e�X sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");

	echo $sss;
	exit;
};

//�q�X����
head("���O�޲z");

print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;


//��V������
$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";
echo print_menu($MENU_P,$linkstr);


//���o�~�׻P�Ǵ����U�Կ��
$seme_list=get_class_seme();
$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAAA' width='100%'><form enctype='multipart/form-data' name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>
	<select name='work_year_seme' onchange='this.form.submit()'>";
foreach($seme_list as $key=>$value){
	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";
}
$main.="</select><select name='item_id' onchange='this.form.submit()'><option></option>";

//���o�~�׶���
$sql_select="select * from charge_item where year_seme='$work_year_seme' order by end_date desc";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while(!$res->EOF) {
	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";
	$res->MoveNext();
}
$main.="</select>";
if($item_id)
{
	//Openofiice���O���ɮת����|
	$oo_path = "ooo";

	//��ܯZ��
	$class_list=get_item_class($item_id,$class_base,$class_id);
	$main.="$class_list<font color=green size=2><a href='".$UPLOAD_URL."charge/myown_template.sxw'> ���W�Ǧۭq�榡�G</a><input type='file' name='myown'><input type='submit' name='do_key' value='�W��' onclick=\"if(this.form.myown.value) { return confirm(\'�W�ǫ�|�N��W�Ǯ榡�����A�z�T�w�n�o�˰���?\'); } else return false;\"></font>";

	if($class_id)
	{
		//���o�e�w�}�C�ǥ͸��
		//$sql_select="select a.record_id,a.student_sn,a.dollars,b.stud_name,b.stud_sex,c.guardian_name from charge_record a,stud_base b,stud_domicile c where a.student_sn=b.student_sn AND b.student_sn=c.student_sn AND item_id=$item_id AND record_id like '$work_year_seme$class_id%' order by record_id";
		$sql_select="select a.record_id,a.student_sn,a.dollars,b.stud_name,b.stud_sex from charge_record a,stud_base b where a.student_sn=b.student_sn AND item_id=$item_id AND record_id like '$work_year_seme$class_id%' order by record_id";
		$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$col=7; //�]�w�C�@�C��ܴX�H

		$studentdata="";
		while(list($record_id,$student_sn,$dollars,$stud_name,$stud_sex)=$recordSet->FetchRow()) {
			//������@�H�m�W
			$sql="select guardian_name from stud_domicile where student_sn=$student_sn";
			$rs=$CONN->Execute($sql)  or user_error("Ū�����ѡI<br>$sql",256);
			$$guardian_name=$rs->fields[0];			
			
			if($recordSet->currentrow() % $col==1) $studentdata.="<tr>";
			if($dollars) {
				$studentdata.="<td bgcolor='#CCCCCC' align='center'>(".substr($record_id,-2).")$stud_name<BR>�C $dollars</td>";
			} else {
				$studentdata.="<td bgcolor=".($stud_sex==1?"#CCFFCC":"#FFCCCC")."><input type='checkbox' name='selected_stud[]' value='$student_sn,$record_id,$stud_name,$guardian_name' id='stud_selected'>(".substr($record_id,-2).")$stud_name</td>";
			}
			if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
		}
		$studentdata.="<tr><td align='center' colspan='$col'>�C�G�wú�ڡ@�@<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>�@�@";
		$studentdata.="OpenOffice���O��榡�G".get_announce_template($oo_path)."<input type='submit' value='�C�L' name='act'>";
		$studentdata.="</td></tr>";
	}
}
echo $main.$studentdata."</form></table>";
foot();
?>
