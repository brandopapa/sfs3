<?php

// $Id: index.php 7844 2014-01-07 05:57:49Z infodaes $

include "report_config.php";
include "../../include/sfs_case_score.php";
include "../../include/sfs_case_score_bw.php";
//�{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�B�z�W�Ǧۭq���榡
if($_POST['do_key']=='�W��') {
        $default_filename='myown_reg.sxw';
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
        $upath=$UPLOAD_PATH."stud_report";
        if (!is_dir($upath))  { mkdir($upath) or die($upath."�إߥ��ѡI"); }

        //�W�ǥت��a
		$todir=$upath;
		$the_file=$todir.'/'.$filename;
		copy($_FILES['myown']['tmp_name'],$the_file);
        unlink($_FILES['myown']['tmp_name']);
		
        $todir=$upath."/reg/";
        if (is_dir($todir)) {
                deldir($todir);
        } else { mkdir($todir) or die($todir."�ت��ؿ��إߥ��ѡI"); }
       
        if (!file_exists($zipfile)) {
                die($zipfile."���s�b�I");
        }elseif(!file_exists($the_file)) {
                die($the_file."���s�b�I");
        }

        $cmd=$arg1." ".$zipfile." ".$the_file." ".$arg2." ".$todir;
        exec($cmd,$output,$rv);
}



//�Z�Ű}�C
$class_arr = class_base();
$postBtn = "�T�w";
$template=$_POST[template];
$sel_stud=$_POST[sel_stud];
$stud_id_list=implode(',',$sel_stud);

$min=1+$IS_JHORES;
$max=6+$IS_JHORES;

//�ץ��qstud_move�L�Ӫ��ѼƤ��a��year_seme�����D
if (count ($sel_stud) >0){
    if ($_POST['year_seme']==""){
        //���ѼƬOstud_move�a�Ӫ�
        $year_seme=$_POST['curr_seme'];
    }else{
        $year_seme=$_POST['year_seme'];
    }
$class_id=$_POST['class_id'];
$class_name=$class_arr[$class_id];

//����J�Ǵ�������� ==2012.11.12 by smallduh==================================
// �Y�Ǹ�ƪ�S�� student_sn �o�����, ���� seme_year_seme ���Ǧ~������, �G���J�Ǧ~�������
if ($class_id>700) {
 $STUD_STUDY_YEAR=sprintf("%d",substr($year_seme,0,3))-(sprintf("%d",substr($class_id,0,1))-7);
 $min_year_seme=sprintf("%03d",$STUD_STUDY_YEAR)."1";
 $max_year_seme=sprintf("%03d",$STUD_STUDY_YEAR+5)."2"; //�ꤤ
} else {
 $STUD_STUDY_YEAR=sprintf("%d",substr($year_seme,0,3))-(sprintf("%d",substr($class_id,0,1))-1);
 $min_year_seme=sprintf("%03d",$STUD_STUDY_YEAR)."1";
 $max_year_seme=sprintf("%03d",$STUD_STUDY_YEAR+8)."2"; //��p
}
//============================================================================


$test=pipa_log("�L���y�O����\r\n�Ǵ��G$year_seme\r\n�Z�šG$class_id $class_name\r\n�˦��G$template\r\n�ǥͦC��G$stud_id_list");		
switch($do_key) {
	case $postBtn:
	if(substr($template,0,5)=='tcc95' or substr($template,0,5)=='tc100' or substr($template,-3)=='reg'){
	
		//�ʧO
		$sex_arr = array("1"=>"�k","2"=>"�k");
		//�P���@�H���Y
		$guardian_relation_arr = guardian_relation();
		//�ǥͨ����O
		$stud_kind_arr = stud_kind();
		//�ǥͰ��O$year_seme
		$stud_abs_arr=stud_abs_kind();
			//return array("1"=>"�ư�","2"=>"�f��","3"=>"�m��","4"=>"���|","5"=>"����","6"=>"��L");
		//�ǥͲ��ʥN��
		$stud_move_arr=study_cond();
			//�[�J�׷~�N��99
			$stud_move_arr[55]='�׷~';
			
		//���o�׷~�ǥͲM��
		$graduate_kind=array();
		$sql="select stud_id,grad_kind from grad_stud where stud_id in ($stud_id_list) order by stud_id";
		$res=$CONN->Execute($sql) or user_error("Ū��grad_stud��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$stud_id=$res->fields['stud_id'];
			$graduate_kind[$stud_id]=$res->fields['grad_kind'];
			$res->MoveNext();
		}
		
		
		//���o���ĳ]�w
		$score_rule_arr = get_score_rule_arr();

		//���o��w�ǥͬy�����ǳƸ��
		$data_arr=array();
		
		//���ostud_base�򥻸��
		$sql="select student_sn,stud_id,stud_name,stud_sex,stud_study_year,stud_person_id,stud_birth_place,stud_addr_1,stud_addr_2,stud_birthday,stud_tel_1,stud_tel_2,stud_kind,enroll_school from stud_base where stud_id in ($stud_id_list) and stud_study_year='$STUD_STUDY_YEAR' order by curr_class_num";

		$res=$CONN->Execute($sql) or user_error("Ū��stud_base��ƥ��ѡI<br>$sql",256);
		$student_sn_arr=array();
		$student_sn_list_arr=array();
		while(!$res->EOF) {
			$stud_id=$res->fields['stud_id'];
			$student_sn=$res->fields['student_sn'];
			$stud_study_year=$res->fields['stud_study_year'];
			$student_sn_list.=$res->fields['student_sn'].',';
			$student_sn_arr[$res->fields['student_sn']]=$stud_id;
			$student_sn_list_arr[]=$res->fields['student_sn']; //�᭱�⦨�Z��
			for($i=0;$i<$res->FieldCount();$i++){
				$r=$res->fetchfield($i);
				$data_arr[$stud_id][$r->name]=$res->fields[$i];
			}
			
			$stud_birthday=$res->fields['stud_birthday'];
			$bir_temp_arr = explode("-",DtoCh($stud_birthday));		
			$data_arr[$stud_id]["stud_birthday"]=sprintf("%d�~%d��%d��",$bir_temp_arr[0],$bir_temp_arr[1],$bir_temp_arr[2]);
			
			$data_arr[$stud_id]["stud_study_year"]=$res->fields['stud_study_year'];	
			$data_arr[$stud_id]["enroll_school"]=$res->fields['enroll_school'];			
			$data_arr[$stud_id]["enroll_date"]=$res->fields['stud_study_year'].'�~08��';
			
			//����stud_base�L��� �h�۲��ʬ���(stud_move)->�s�ͤJ�Ǥ��j�M
			if(! $res->fields['enroll_school'])
			{
				$sql_enroll="select year(move_date) as enroll_year,month(move_date) as enroll_month,school from stud_move where move_kind=13 and student_sn=$student_sn;";
				$res_enroll=$CONN->Execute($sql_enroll) or user_error("Ū��stud_move��ƥ��ѡI<br>$sql_enroll",256);
				if($res_enroll->EOF)
				{
					//��stud_move_import->�s�ͤJ�Ǥ��j�M, ���ӬO�Τ���(�]��XML�פJ�|�g��stud_base->enroll_school)
					$sql_enroll_import="select year(move_date) as enroll_year,month(move_date) as enroll_month,school from stud_move_import where move_kind=13 and student_sn=$student_sn;";
					$res_enroll_import=$CONN->Execute($sql_enroll_import) or user_error("Ū��stud_move_import��ƥ��ѡI<br>$sql_enroll_import",256);
					if($res_enroll_import->EOF)
					{
						if(! $data_arr[$stud_id]["enroll_date"]) $data_arr[$stud_id]["enroll_date"]=($res_enroll_import->fields['enroll_year']-1911).'�~'.$res_import->fields['enroll_month'].'��';
						$data_arr[$stud_id]["enroll_school"]=$res_enroll_import->fields['school'];
					}
				} else
				{
					if(! $data_arr[$stud_id]["enroll_date"]) $data_arr[$stud_id]["enroll_date"]=($res_enroll->fields['enroll_year']-1911).'�~'.$res_enroll->fields['enroll_month'].'��';
					$data_arr[$stud_id]["enroll_school"]=$res_enroll->fields['school']?$res_enroll->fields['school']:$school_long_name;
				}
			}
		
			
			//��Ķ���
			$data_arr[$stud_id]['stud_sex']=$sex_arr[$data_arr[$stud_id]['stud_sex']];
			//��Ķ�ǥͨ���
			$this_kind_str='';
			$this_kind_arr=explode(',',$res->fields['stud_kind']);
			foreach($this_kind_arr as $value){
				if($value<>''){
					if($value<=17){   //�ۦ�w�q�������
						$this_kind_str.='['.$stud_kind_arr[$value].']';
					}
				}
			}
//print_r($res->fields['stud_kind']);
//echo "<BR>";
//echo $stud_id."===>".$this_kind_str."<BR>";
			
			$data_arr[$stud_id]['stud_kind']=$this_kind_str;

			//�[�J�Ǯթ��Y
			$data_arr[$stud_id]['school_long_name']=$school_long_name;

			//�Ӥ�  http://localhost/sfs3/data/photo/student/90/90002
			//��SXW����XML�w�q==>  <draw:image draw:style-name="fr1" draw:name="Graphic1" text:anchor-type="as-char" svg:width="1.956cm" svg:height="2.565cm" draw:z-index="0" xlink:href="#Pictures/sample.jpg" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad"/>
			$stud_photo_file="$UPLOAD_PATH/photo/student/$stud_study_year/$stud_id";
			//20170729 add by Brando Chang
			$stud_photo_img = $SFS_PATH_HTML.$UPLOAD_URL."/photo/student/$stud_study_year/$stud_id";
	//echo "<BR>".$stud_photo_file.'====>'.file_exists($stud_photo_file);
			if(file_exists($stud_photo_file)){
				//20170729 Update by Brando Chang
				//$data_arr[$stud_id]['photo']="$stud_id.jpg";
				$data_arr[$stud_id]['photo'] = $stud_photo_img;
				//20170729 Brando Chang move from context.xml
				//<draw:image draw:style-name="fr2" draw:name="�ϧ�1" text:anchor-type="as-char" svg:width="2.66cm" svg:height="3.487cm" draw:z-index="3" xlink:href="#Pictures/100000000000019D000001C1D53AE018.jpg" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad" />
				// end
				
				//'<draw:image draw:style-name="fr1" draw:name="Graphic1" text:anchor-type="as-char" svg:width="1.956cm" svg:height="2.565cm" draw:z-index="0" xlink:href="#Pictures/'.$stud_id.'.jpg" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad"/>';
	
			} else {
				$data_arr[$stud_id]['photo']='sample.jpg';
				//'<draw:image draw:style-name="fr1" draw:name="Graphic1" text:anchor-type="as-char" svg:width="1.956cm" svg:height="2.565cm" draw:z-index="0" xlink:href="#Pictures/sample.jpg" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad"/>';
			}
//echo "<textarea rows=50 cols=80>".$data_arr[$stud_id]["photo"]."</textarea>";
			$res->MoveNext();
		}
		
		//���o���@�H���
		$student_sn_list=substr($student_sn_list,0,-1);
		//2012.11.12��� student_sn���o
		//$sql="select stud_id,guardian_name,guardian_relation from stud_domicile where stud_id in ($stud_id_list)";
    $sql="select stud_id,guardian_name,guardian_relation from stud_domicile where student_sn in ($student_sn_list)";
		
		$res=$CONN->Execute($sql) or user_error("Ū��stud_domicile��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$stud_id=$res->fields['stud_id'];
			$data_arr[$stud_id][guardian_name]=$res->fields[guardian_name];
			$data_arr[$stud_id][guardian_relation]=$guardian_relation_arr[$res->fields[guardian_relation]];
			$res->MoveNext();
		}
		
		
		
		//����Ǧ~�Z�žɮv�}�C
		$class_teacher_arr=array();
		$sql="select class_id,teacher_1 from school_class";
		$res=$CONN->Execute($sql) or user_error("Ū��school_class��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$teacher_class_id=$res->fields['class_id'];
			$class_teacher_arr[$teacher_class_id]=$res->fields['teacher_1'];
			$res->MoveNext();
		}
		
		//���o���~�NŪ�Z�šB�y���P�ɮv
		//�����ͤ@�ӪŰ}�C  �H�K�t�Υ��]�w�X�{����
		$stud_grade=array();
		$stud_grade_semester=array();

		//���;Ǵ��ѷ�
		foreach($sel_stud as $stud_id){
			for($i=$min;$i<=$max;$i++){
				for($j=1;$j<=2;$j++){
					$k=$i.'_'.$j;
					$data_arr[$stud_id]["class_$k"]='';
					$data_arr[$stud_id]["seme_num_$k"]='';
					$data_arr[$stud_id]["teacher_$k"]='';
					$data_arr[$stud_id]["grade_$k"]='';
					
					//�קK��ǥ͵L�k�e�{�A���H�J�Ǧ~����NŪ�Ǧ~
					$defaule_seme_year_seme=sprintf('%03d%1d',$data_arr[$stud_id]["stud_study_year"]+$i-$IS_JHORES-1,$j);
					$stud_grade[$stud_id]["$defaule_seme_year_seme"]=$i;
					$stud_grade_semester[$stud_id][$k]=$defaule_seme_year_seme;
				}
			}
		}

		
		//��J�פJ���Ǵ��s�Z����
		$sql="select stud_id,seme_year_seme,seme_class_grade,seme_class_grade as grade,seme_num,seme_class_name from stud_seme_import where stud_id in ($stud_id_list)  and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme'";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_import��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			//�զ�school_class�榡��class_id
			//$stud_class_id=sprintf("%03d_%d_%02d_%02d",substr($res->fields['seme_year_seme'],0,3),substr($res->fields['seme_year_seme'],-1),$res->fields['grade'],substr($res->fields['seme_class'],-2));
			$stud_class_id=sprintf("%03d_%d_%02d_%02d",substr($res->fields['seme_year_seme'],0,3),substr($res->fields['seme_year_seme'],-1),$res->fields['grade'],0);
			$stud_id=$res->fields['stud_id'];
			$grade=$res->fields['grade'];
			$year=substr($res->fields['seme_year_seme'],0,3);
			$semester=substr($res->fields['seme_year_seme'],-1);
			$k=$grade.'_'.$semester;
	
			$data_arr[$stud_id]["class_$k"]=$class_name_kind_1[$grade].'�~'.$res->fields['seme_class_name'].'�Z';
			$data_arr[$stud_id]["seme_num_$k"]=$res->fields['seme_num'];
			
			$sql_teacher_name="SELECT teacher_name FROM stud_seme_import WHERE stud_id='$stud_id' AND seme_class_grade='$grade' AND seme_year_seme='".$res->fields['seme_year_seme']."';";
			$res_teacher_name=$CONN->Execute($sql_teacher_name);
			$data_arr[$stud_id]["teacher_$k"]=$res_teacher_name->fields['teacher_name'];
			
		
			$stud_semester='grade_'.$grade.'_'.$semester;
			$data_arr[$stud_id][$stud_semester]=$year+0;

			//���Ϳ���ǥ;Ǵ��~�Ź�Ӱ}�C
			$stud_grade[$stud_id][$res->fields['seme_year_seme']]=$grade;
			$stud_grade_semester[$stud_id][$k]=$res->fields['seme_year_seme'];
			
			$res->MoveNext();
		}
		
		//�b���ժ��Ǵ��s�Z����
		$sql="select stud_id,seme_year_seme,seme_class,left(seme_class,1) as grade,seme_num,seme_class_name from stud_seme where stud_id in ($stud_id_list)  and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme' ORDER BY stud_id,seme_year_seme";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			//�զ�school_class�榡��class_id
			$stud_class_id=sprintf("%03d_%d_%02d_%02d",substr($res->fields['seme_year_seme'],0,3),substr($res->fields['seme_year_seme'],-1),$res->fields['grade'],substr($res->fields['seme_class'],-2));
			$stud_id=$res->fields['stud_id'];
			$grade=$res->fields['grade'];
			$year=substr($res->fields['seme_year_seme'],0,3);
			$semester=substr($res->fields['seme_year_seme'],-1);
			$k=$grade.'_'.$semester;
	
			$data_arr[$stud_id]["class_$k"]=$class_name_kind_1[$grade].'�~'.$res->fields['seme_class_name'].'�Z';
			$data_arr[$stud_id]["seme_num_$k"]=$res->fields['seme_num'];
			$data_arr[$stud_id]["teacher_$k"]=$class_teacher_arr[$stud_class_id];

			
			$stud_semester='grade_'.$grade.'_'.$semester;
			$data_arr[$stud_id][$stud_semester]=($year+0).'�Ǧ~�ײ�'.$semester.'�Ǵ�';;

			//���Ϳ���ǥ;Ǵ��~�Ź�Ӱ}�C
			$stud_grade[$stud_id][$res->fields['seme_year_seme']]=$grade;
			$stud_grade_semester[$stud_id][$k]=$res->fields['seme_year_seme'];
			
			$res->MoveNext();
		}
		
		//�B�z���ʬ���
		//�����ͤ@�ӪŰ}�C  �H�K�t�Υ��]�w�X�{����
		foreach($sel_stud as $stud_id){
			for($i=1;$i<=20;$i++){
				$data_arr[$stud_id]["move_date_$i"]='';
				$data_arr[$stud_id]["move_kind_$i"]='';
				$data_arr[$stud_id]["move_unit_$i"]='';
				$data_arr[$stud_id]["move_c_date_$i"]='';
				$data_arr[$stud_id]["move_c_num_$i"]='';
				$data_arr[$stud_id]["move_county_$i"]='';
				$data_arr[$stud_id]["move_school_$i"]='';
			}
		}
		
		//substr(move_year_seme,1,length(move_year_seme)-1)-$stud_study_year<=9
		
		foreach($sel_stud as $stud_id){
			$stud_study_year=$data_arr[$stud_id]['stud_study_year'];
			$sql="(select * from stud_move_import where stud_id='$stud_id' and (substr(move_year_seme,1,length(move_year_seme)-1)-$stud_study_year)<=9 and (substr(move_year_seme,1,length(move_year_seme)-1)-$stud_study_year)>=0) UNION DISTINCT (select * from stud_move where stud_id='$stud_id' and (substr(move_year_seme,1,length(move_year_seme)-1)-$stud_study_year)<=9 and (substr(move_year_seme,1,length(move_year_seme)-1)-$stud_study_year)>=0) order by move_date";

//echo $sql;	
//exit;		
			$res=$CONN->Execute($sql) or user_error("Ū��stud_move_import��ƥ��ѡI<br>$sql",256);
			$no=0;
			$current_id='';
			$last_date='';
			$last_kind='';
			while(!$res->EOF) {
				//if($last_date=$res->fields['move_date'] and $last_kind=$res->fields['move_kind']) { }
				//else{				
					$no++;
					$stud_id=$res->fields['stud_id'];
					$date_temp_arr = explode("-",DtoCh($res->fields['move_date']));
					$data_arr[$stud_id]["move_date_$no"]=sprintf("%d/%02d/%02d",$date_temp_arr[0],$date_temp_arr[1],$date_temp_arr[2]);
					
					$move_kind=$res->fields['move_kind'];
					if($move_kind==5) if($graduate_kind[$stud_id]==2) $move_kind=55; 			
					
					$data_arr[$stud_id]["move_kind_$no"]=$stud_move_arr[$move_kind];
					
					$data_arr[$stud_id]["move_unit_$no"]=$res->fields['move_c_unit'];
					$c_date_temp_arr = explode("-",DtoCh($res->fields['move_c_date']));
					$data_arr[$stud_id]["move_c_date_$no"]=sprintf("%d/%02d/%02d",$c_date_temp_arr[0],$c_date_temp_arr[1],$c_date_temp_arr[2]);
					$data_arr[$stud_id]["move_c_num_$no"]=$res->fields['move_c_word'].$res->fields['move_c_num'];
					$data_arr[$stud_id]["move_county_$no"]=$res->fields['city'];
					$data_arr[$stud_id]["move_school_$no"]=$res->fields['school'];
					
					//$last_date=$res->fields['move_date'];
					//$last_kind=$res->fields['move_kind'];
				//}
				
				$res->MoveNext();
			}
		}
		
		
		//�B�z���`�ͬ���{����
		//�����ͤ@�ӪŰ}�C  �H�K�t�Υ��]�w�X�{����
		foreach($sel_stud as $stud_id){
			for($i=$min;$i<=$max;$i++){
				for($j=1;$j<=2;$j++){
					for($k=0;$k<=5;$k++){
						$item="nor_id".$k."_".$i."_".$j;
						$data_arr[$stud_id][$item]='';
					}
				}
			}
		}
//echo "<pre>";
//print_r($data_arr);
//echo "</pre><br><br><br>";
		$ttt = new EasyZip;
		$sql="select * from stud_seme_score_nor where student_sn in ($student_sn_list)";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_score_nor��ƥ��ѡI<br>$sql",256);
		$no=0;
		$current_sn=0;
		while(!$res->EOF) {
			if($current_sn<>$res->fields['student_sn']){
				$no=1;
				$current_sn=$res->fields['student_sn'];
			} else $no++;

			$stud_id=$student_sn_arr[$current_sn];
			//���o�Ǵ��ǥʹNŪ�~��
			$stud_year_seme=$res->fields['seme_year_seme'];
			$grade=$stud_grade[$stud_id]["$stud_year_seme"];
			$id=$res->fields['ss_id'];
			$semester=substr($res->fields['seme_year_seme'],-1);
			$nor_id="nor_id".$id."_".$grade."_".$semester;

			$data_arr[$stud_id][$nor_id]= $ttt->change_str($res->fields['ss_score_memo'],1,0);

			$res->MoveNext();
		}
		
		//�B�z�X�ʮu����
		//�����ͤ@�ӪŰ}�C  �H�K�t�Υ��]�w�X�{����
		foreach($sel_stud as $stud_id){
			for($i=$min;$i<=$max;$i++){
				for($j=1;$j<=2;$j++){
					for($k=1;$k<=6;$k++){
						//����
						$item="abs_".$k."_".$i."_".$j;
						$data_arr[$stud_id][$item]=0;
						//���خ֭p
						$kind_sum="abs_".$k."_sum";
						$data_arr[$stud_id][$kind_sum]=0;
						
						//��l���g
						$item2="rew_".$k."_".$i."_".$j;
						$data_arr[$stud_id][$item2]=0;
					}
					//�Ǵ��έp
					$semester_total="abs_total_".$i."_".$j;
					$data_arr[$stud_id][$semester_total]=0;
				}
			}
			$data_arr[$stud_id]['abs_total_sum']=0;
		}

		//�������W�Ҥ�ưѷӰ}�C
		$semester_grade_days=array();
		$sql="select * from seme_course_date";
		$res=$CONN->Execute($sql) or user_error("Ū��seme_course_date��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$semester=$res->fields['seme_year_seme'];
			$grade=$res->fields['class_year'];
			$semester_grade_days[$semester][$grade]=$res->fields['days'];
			$res->MoveNext();
		}
		//�]�w����ǥ����X�u���
		foreach($sel_stud as $stud_id){
			$data_arr[$stud_id][$y_s_sum]=0;
			for($i=$min;$i<=$max;$i++){
				for($j=1;$j<=2;$j++){
					$k=$i."_".$j;
					$study_semester=$stud_grade_semester[$stud_id][$k];
					$y_s="days_".$k;
					$y_s_sum="days_sum";
					$data_arr[$stud_id][$y_s]=$semester_grade_days[$study_semester][$i];
					$data_arr[$stud_id][$y_s_sum]+=$data_arr[$stud_id][$y_s];
				}
			}
		}

		//����ʮu����
		$sql="select * from stud_seme_abs WHERE stud_id in ($stud_id_list)  and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme'";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_abs��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$stud_id=$res->fields['stud_id'];
			$year_semester=$res->fields['seme_year_seme'];
			$abs_kind=$res->fields['abs_kind'];
			$abs_days=$res->fields['abs_days'];
			$grade=$stud_grade[$stud_id][$year_semester];
			$semester=substr($year_semester,-1);
			
			$item="abs_".$abs_kind."_".$grade."_".$semester;
			$data_arr[$stud_id][$item]=$abs_days;
			
			//�i��涵�X�p
			$item_sum="abs_".$abs_kind."_sum";
			$data_arr[$stud_id][$item_sum]+=$abs_days;
						
			//�i��Ǵ��έp  �N"���|"�P"����"�ư�
			if($abs_kind<4 and $abs_kind=6) {
				$semester_total="abs_total_".$grade."_".$semester;
				$data_arr[$stud_id][$semester_total]+=$abs_days;
			
				//�ʮu�`�έp
				$data_arr[$stud_id]['abs_total_sum']+=$abs_days;
			}

			$res->MoveNext();
		}

		//���g��� �w���� L441 ��l��0 
		$query="select stud_id,seme_year_seme,sr_kind_id,sr_num from stud_seme_rew where stud_id in ($stud_id_list)  and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme' order by seme_year_seme,sr_kind_id";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$stud_id = $res->fields['stud_id'];
			$year_semester=$res->fields['seme_year_seme'];
			$rew_kind= $res->fields['sr_kind_id'];
			$sr_num=$res->fields['sr_num'];
			$grade=$stud_grade[$stud_id][$year_semester];
			$semester=substr($year_semester,-1);			

			$item="rew_".$rew_kind."_".$grade."_".$semester;
			$data_arr[$stud_id][$item]=$sr_num;
			
			//�i��涵�X�p
			$item_sum="rew_".$rew_kind."_sum";
			$data_arr[$stud_id][$item_sum]+=$sr_num;
			
			$res->MoveNext();
		}
		
		foreach($sel_stud as $stud_id){
			for($i=$min;$i<=$max;$i++){
				for($j=1;$j<=2;$j++){
					$item="class_title_".$i."_".$j;
					$item1="club_title_".$i."_".$j;						
					$item2="association_name_".$i."_".$j;											
					
					$item3="service_date_".$i."_".$j;
					$item4="item_memo_".$i."_".$j;
					$item5="hours_".$i."_".$j;
					$item6="sponsor_".$i."_".$j;
					
					$data_arr[$stud_id][$item]='';
					$data_arr[$stud_id][$item1]='';
					$data_arr[$stud_id][$item2]='';
					$data_arr[$stud_id][$item3]='';
					$data_arr[$stud_id][$item4]='';
					$data_arr[$stud_id][$item5]='';
					$data_arr[$stud_id][$item6]='';
				}
			}
		}		
		//���o�ǥͪ��Ҧ����θ��								
		$sql="select s.stud_id,c.seme,c.kind,a.association_name,IFNULL(c.title,'---') as title from chc_leader c left join association a on a.student_sn = c.student_sn and a.seme_year_seme = c.seme left join stud_base s on c.student_sn=s.student_sn where s.stud_id in ($stud_id_list) order by c.seme,c.kind";
    $res = $CONN->Execute($sql) or die("Sql error, ".$sql);
		while(!$res->EOF) {
			$stud_id = $res->fields['stud_id'];
			$year_semester=$res->fields['seme'];
			$grade=$stud_grade[$stud_id][$year_semester];
			$semester=substr($year_semester,-1);
		  $club_name="association_name_".$grade."_".$semester;						  	
			if ($res->fields['kind'] == '0'){
				$item="class_title_".$grade."_".$semester;				
		  }
		  else{
		  	$item="club_title_".$grade."_".$semester;						  	
		  }
		  $data_arr[$stud_id][$item]= $res->fields['title'];
		  $data_arr[$stud_id][$club_name]= $res->fields['association_name'];
			$res->MoveNext();
		}
		
		//
 		//$sql="select a.*,b.student_sn,b.item_sn,round(b.minutes/60) as hours,b.studmemo from stud_service a,stud_service_detail b where a.sn=b.item_sn and b.student_sn='$student_sn' and a.confirm=1 order by service_date";
 		$sql="select s.stud_id,a.sn,a.year_seme,a.service_date,a.sponsor,a.item,a.memo,round(b.minutes/60) as hours from stud_service a left join stud_service_detail b on a.sn=b.item_sn left join stud_base s on b.student_sn=s.student_sn where s.stud_id in ($stud_id_list) and a.confirm=1 order by a.service_date";
		$res = $CONN->Execute($sql) or die("Sql error, ".$sql);
		while(!$res->EOF) {
			$sn = $res->fields['sn'];
			$stud_id = $res->fields['stud_id'];
			$year_semester=$res->fields['year_seme'];
			$grade=$stud_grade[$stud_id][$year_semester];
			$semester=substr($year_semester,-1);
		  $service_date="service_date_".$grade."_".$semester;
		  $item_memo="item_memo_".$grade."_".$semester;
		  $hours="hours_".$grade."_".$semester;
		  $sponsor="sponsor_".$grade."_".$semester;
		  
		  $data_arr[$stud_id][$service_date]= $res->fields['service_date'];
		  $data_arr[$stud_id][$item_memo]= $res->fields['item'].":".$res->fields['memo'];
		  $data_arr[$stud_id][$hours]= $res->fields['hours'];
		  $data_arr[$stud_id][$sponsor]= $res->fields['sponsor'];
			$res->MoveNext();
		}

								
		//�B�z�ǲ߻�즨�Z
		$all_semesters_arr=array();
		//���;ǥʹNŪ�L���Ǵ��}�C(��J)
		$sql="select DISTINCT seme_year_seme from stud_seme_import where stud_id in ($stud_id_list) and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme'";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme_import��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$all_semesters_arr[]=$res->fields['seme_year_seme'];
			$res->MoveNext();
		}

		//���;ǥʹNŪ�L���Ǵ��}�C(����)		
		$sql="select DISTINCT seme_year_seme from stud_seme where stud_id in ($stud_id_list) and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme'";
		$res=$CONN->Execute($sql) or user_error("Ū��stud_seme��ƥ��ѡI<br>$sql",256);
		while(!$res->EOF) {
			$all_semesters_arr[]=$res->fields['seme_year_seme'];
			$res->MoveNext();
		}
		
		$fin_score=cal_fin_score($student_sn_list_arr,$all_semesters_arr,"","");
		$link_ss=array("language"=>"�y��","chinese"=>"����y��","local"=>"�m�g�y��","english"=>"�^�y","math"=>"�ƾ�","life"=>"�ͬ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","art"=>"���N�P�H��","health"=>"���d�P��|","complex"=>"��X����");
		foreach($sel_stud as $stud_id){
			$student_sn=array_search($stud_id,$student_sn_arr); 
			foreach($link_ss as $key=>$value){
				for($i=$min;$i<=$max;$i++){
					for($j=1;$j<=2;$j++){
						$k=$i.'_'.$j;
						$target_semester=$stud_grade_semester[$stud_id][$k];
						if(!$target_semester) $target_semester='empty';
							//��즨�Z
														
							$item_score=$key."_".$i."_".$j."_score";
							$item_rate=$key."_".$i."_".$j."_rate";
							$item_grade=$key."_".$i."_".$j."_grade";
							$data_arr[$stud_id][$item_score]=$fin_score[$student_sn][$key][$target_semester][score];
							$data_arr[$stud_id][$item_rate]=$fin_score[$student_sn][$key][$target_semester][rate];
							$data_arr[$stud_id][$item_grade]=$data_arr[$stud_id][$item_score]?rep_score2str($data_arr[$stud_id][$item_score],$score_rule_arr[$target_semester][$i]):'';
							//�Ǵ����Z
							$semester_score=$i."_".$j."_score";
							$semester_rate=$i."_".$j."_rate";
							$semester_grade=$i."_".$j."_grade";
							$data_arr[$stud_id][$semester_score]=$fin_score[$student_sn][$target_semester][avg][score];
							$data_arr[$stud_id][$semester_rate]=$fin_score[$student_sn][$target_semester][total][rate];
							$data_arr[$stud_id][$semester_grade]=$data_arr[$stud_id][$semester_score]?rep_score2str($data_arr[$stud_id][$semester_score],$score_rule_arr[$target_semester][$i]):'';
						
							//echo $data_arr[$stud_id][$item_score]."---".$score_rule_arr[$target_semester][$i]."<BR>";
					}
				}
				$data_arr[$stud_id][($key."_avg_score")]=$fin_score[$student_sn][$key][avg][score];
				$data_arr[$stud_id][($key."_avg_rate")]=$fin_score[$student_sn][$key][avg][rate];
				$data_arr[$stud_id][($key."_avg_grade")]=$fin_score[$student_sn][$key][avg][score]?rep_score2str($fin_score[$student_sn][$key][avg][score],$score_rule_arr[$target_semester][$max]):'';
			}
			$data_arr[$stud_id]["avg_score"]=$fin_score[$student_sn][avg][score];
			$data_arr[$stud_id]["avg_grade"]=$fin_score[$student_sn][avg][score]?rep_score2str($fin_score[$student_sn][avg][score],$score_rule_arr[$target_semester][$max]):'';
		}
		
		$fin_score_non_area=cal_fin_score_non_area($student_sn_list_arr,$all_semesters_arr,"","");
		$link_ss=array("basic"=>"��¦�ҵ{","recite"=>"�g��I�w","calligraphy"=>"�Ѫk�w���r","lifelesson"=>"�ͩR�ҵ{","filialpiety"=>"�w�Q/���g","concept"=>"�z���ǲ�","lifespec"=>"�ͬ��W�d","healthylv"=>"���d�ͬ�","lifeskills"=>"�ͬ��ޯ�","gpactive"=>"�s�v����","svlr"=>"�A�Ⱦǲ�");
		foreach($sel_stud as $stud_id){
			$student_sn=array_search($stud_id,$student_sn_arr); 
			foreach($link_ss as $key=>$value){
				for($i=$min;$i<=$max;$i++){
					for($j=1;$j<=2;$j++){
						$k=$i.'_'.$j;
						$target_semester=$stud_grade_semester[$stud_id][$k];
						if(!$target_semester) $target_semester='empty';
							//�D��즨�Z
														
							$item_score=$key."_".$i."_".$j."_score";
							$item_rate=$key."_".$i."_".$j."_rate";
							$item_grade=$key."_".$i."_".$j."_grade";
							
							$data_arr[$stud_id][$item_score]=$fin_score_non_area[$student_sn][$key][$target_semester][score];
							$data_arr[$stud_id][$item_rate]=$fin_score_non_area[$student_sn][$key][$target_semester][rate];
							$data_arr[$stud_id][$item_grade]=$data_arr[$stud_id][$item_score]?rep_score2str($data_arr[$stud_id][$item_score],$score_rule_arr[$target_semester][$i]):'';

							//�Ǵ����Z
							$semester_score=$i."_".$j."_na_score";
							$semester_rate=$i."_".$j."_na_rate";
							$semester_grade=$i."_".$j."_na_grade";
							$data_arr[$stud_id][$semester_score]=$fin_score_non_area[$student_sn][$target_semester][avg][score];
							$data_arr[$stud_id][$semester_rate]=$fin_score_non_area[$student_sn][$target_semester][total][rate];
							$data_arr[$stud_id][$semester_grade]=$data_arr[$stud_id][$semester_score]?rep_score2str($data_arr[$stud_id][$semester_score],$score_rule_arr[$target_semester][$i]):'';
						
							//echo $data_arr[$stud_id][$item_score]."---".$score_rule_arr[$target_semester][$i]."<BR>";
					}
				}
				$data_arr[$stud_id][($key."_avg_score")]=$fin_score_non_area[$student_sn][$key][avg][score];
				$data_arr[$stud_id][($key."_avg_rate")]=$fin_score_non_area[$student_sn][$key][avg][rate];
				$data_arr[$stud_id][($key."_avg_grade")]=$fin_score_non_area[$student_sn][$key][avg][score]?rep_score2str($fin_score_non_area[$student_sn][$key][avg][score],$score_rule_arr[$target_semester][$max]):'';
			}
			$data_arr[$stud_id]["avg_na_score"]=$fin_score_non_area[$student_sn][avg][score];
			$data_arr[$stud_id]["avg_na_grade"]=$fin_score_non_area[$student_sn][avg][score]?rep_score2str($fin_score[$student_sn][avg][score],$score_rule_arr[$target_semester][$max]):'';
		}		

//print_r($score_rule_arr[$target_semester][$max]);
/*	
echo "<PRE>";
print_r($data_arr);
echo "</PRE>";
exit;
*/

		//Openoffice�ɮת����|
		$oo_path = $template;
		
		//�ɦW
		$filename=$work_year_seme."���y������_".$_REQUEST[year_seme]."_".$class_id.".sxw";
		//�s�W�@�� zipfile ���
//		$ttt = new EasyZip;
		$ttt->setPath($oo_path);
		//�[�J xml �ɮר� zip ���A�@�������ɮ� 
		//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
		if (is_dir($oo_path)) { 
			if ($dh = opendir($oo_path)) { 
				while (($file = readdir($dh)) !== false) { 
					if($file=="." or $file==".." or $file=="content.xml" or $file=="Configurations2" or $file=="Thumbnails" or strtoupper(substr($file,-4))=='.SXW') {
						continue;
					}elseif(is_dir($oo_path."/".$file)){
						if ($dh2 = opendir($oo_path."/".$file)) { 
							while (($file2 = readdir($dh2)) !== false) { 
								if($file2=="." or $file2==".."){
									continue;
								}else{
									$data = $ttt->read_file($oo_path."/".$file."/".$file2);
									$ttt->add_file($data,$file."/".$file2);
								}
							} 
							closedir($dh2); 
						} 
					}else{
						$data = $ttt->read_file($oo_path."/".$file);
						$ttt->add_file($data,$file);
					}
				} 
				closedir($dh); 
			} 
		}
		
		//�[�J�Ϥ���SXW�ɮפ�
		foreach($sel_stud as $stud_id){
			$stud_study_year=$data_arr[$stud_id]["stud_study_year"];
			if($data_arr[$stud_id]["photo"]<>'sample.jpg'){
				$stud_photo_file="$UPLOAD_PATH/photo/student/$stud_study_year/$stud_id";
				//if(file_exists($stud_photo_file)){
					$data = $ttt->read_file($stud_photo_file);
					$ttt->add_file($data,"Pictures/$stud_id.jpg");
				//}
			}
		}

		//Ū�X content.xml 
		$data = $ttt->read_file("$oo_path/content.xml");
		
		// �[�J���� tag
		$data = str_replace("<office:automatic-styles>",'<office:automatic-styles><style:style style:name="BREAK_PAGE" style:family="paragraph" style:parent-style-name="Standard"><style:properties fo:break-before="page"/></style:style>',$data);
		//��� content.xml
		
		/***
		$arr1 = explode("<office:body>",$data);
		if (count($arr1)==1) {
			$arr1 = explode("<office:body text:use-soft-page-breaks=\"true\">",$data);
		}
    ***/
    
    $a1=explode ("<office:body",$data);
		$a2= split (">",$a1[1],2);
		//$A�����Ϊ����ަr��
		$A="<office:body".$a2[0].">";
		$arr1 = explode($A,$data);


		//���Y
		$doc_head = $arr1[0]."<office:body>";
		$arr2 = explode("</office:body>",$arr1[1]);
		//��Ƥ��e
		$content_body = $arr2[0];
		//�ɧ�
		$doc_foot = "</office:body>".$arr2[1];

		$replace_data ="";
		
		foreach($data_arr as $key=>$temp_arr){
			$my_content_body=$content_body;
			
//echo "<pre>";
//print_r($temp_arr);
//echo "</PRE><BR><BR><BR>";
			
			//�N�ǥͷӤ�����
			//if($temp_arr['photo']) $my_content_body=str_replace('sample.jpg',$temp_arr['photo'],$my_content_body);
			// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
			$replace_data.=$ttt->change_temp($temp_arr,$my_content_body,0);
			//$replace_data.="<text:p text:style-name=\"break_page\"/>";  //����
		}
//exit;
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
	}

	if($template=='ooo'){
	
	$ttt = new EasyZIP ;
	// �]�w�ɮץؿ�
	$ttt->setPath($template);

	$break ="<text:p text:style-name=\"P17\"/>";
	$doc_head = $ttt->read_file (dirname(__FILE__)."/ooo/con_head");
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/ooo/con_foot");
	$doc_stud_base = $ttt->read_file (dirname(__FILE__)."/ooo/con_stud_base");
	$doc_stud_move= $ttt->read_file (dirname(__FILE__)."/ooo/con_move");
	//$doc_main= $ttt->read_file (dirname(__FILE__)."/ooo/con_main");
	if ($IS_JHORES==0)
		$doc_abs = $ttt->read_file (dirname(__FILE__)."/ooo/con_abs");
	else
		$doc_abs = $ttt->read_file (dirname(__FILE__)."/ooo/con_abs_j");
	$doc_sign = $ttt->read_file (dirname(__FILE__)."/ooo/con_sign");
	$doc_page_head = $ttt->read_file (dirname(__FILE__)."/ooo/con_page_head");
	$doc_nor = $ttt->read_file (dirname(__FILE__)."/ooo/con_nor");
	$doc_score = $ttt->read_file (dirname(__FILE__)."/ooo/con_score");
	$doc_grade = $ttt->read_file (dirname(__FILE__)."/ooo/con_grade");

	
	
	$ttt->addDir("META-INF");
//	$data = $ttt->read_file(dirname(__FILE__)."/ooo/META-INF/manifest.xml");

//	$ttt->add_file($data,"/META-INF/manifest.xml");
	$ttt->addFile('settings.xml');
	$ttt->addFile('styles.xml');
	$ttt->addFile('meta.xml');

	//�嫬 
	$blood_arr = blood();
	//�X�ͦa
	$birth_state_arr = birth_state();
	//�ʧO
	$sex_arr = array("1"=>"�k","2"=>"�k");	
	//�s�\
	$is_live_arr = is_live();
	//�P���@�H���Y
	$guardian_relation_arr = guardian_relation();
	//�Ǿ�
	$edu_kind_arr  = edu_kind();
	//�ǥͨ����O 
	$stud_kind_arr = stud_kind();
	//�P���@�H���Y
	$guardian_relation_arr = guardian_relation();
	
	//�C�L�ɶ�
	$print_time = $now;
	

	$temp_arr["sch_cname"]= $sch_cname;

	$sql_select = "select a.*,b.fath_name,b.fath_birthyear,b.fath_alive,b.fath_education,b.fath_occupation,b.fath_unit,b.fath_phone,b.fath_hand_phone,b.moth_name,b.moth_birthyear,b.moth_alive,b.moth_education,b.moth_occupation,b.moth_unit,b.moth_phone,b.moth_hand_phone,b.guardian_name,b.guardian_relation,b.guardian_unit,b.guardian_hand_phone,b.guardian_phone,b.grandfath_name,b.grandfath_alive,b.grandmoth_name,b.grandmoth_alive  from stud_base a left join stud_domicile b on a.stud_id=b.stud_id  ";
	for ($ss=0;$ss < count ($sel_stud);$ss++)
		$temp_sel .= "'".$sel_stud[$ss]."',";
	$sql_select .= "where a.stud_id in (".substr($temp_sel,0,-1).")  and a.stud_study_year='$STUD_STUDY_YEAR'";
	 
	$sql_select .= " order by a.curr_class_num ";	
	$recordSet = $CONN->Execute($sql_select)or die ($sql_select);	
	$i =0;
	$data = '';
	//���o���ĳ]�w
	$score_rule_arr = get_score_rule_arr();

       	//���o���W��
        $subject_name_arr=&get_subject_name_arr();

	while (!$recordSet->EOF) {
		$stud_id = $recordSet->fields["stud_id"];
		$student_sn = $recordSet->fields["student_sn"];
		$stud_name = $recordSet->fields["stud_name"];
		$stud_sex = $recordSet->fields["stud_sex"];
		$stud_birthday = $recordSet->fields["stud_birthday"];
		$stud_blood_type = $recordSet->fields["stud_blood_type"];
		$stud_birth_place = $recordSet->fields["stud_birth_place"];
		$stud_kind = $recordSet->fields["stud_kind"];
		$stud_country = $recordSet->fields["stud_country"];
		$stud_country_kind = $recordSet->fields["stud_country_kind"];
		$stud_person_id = $recordSet->fields["stud_person_id"];
		$stud_country_name = $recordSet->fields["stud_country_name"];
		$stud_addr_1= $recordSet->fields["stud_addr_1"];
		$stud_addr_2 = $recordSet->fields["stud_addr_2"];
		$stud_tel_1 = $recordSet->fields["stud_tel_1"];
		$stud_tel_2 = $recordSet->fields["stud_tel_2"];
		$stud_tel_3 = $recordSet->fields["stud_tel_3"];
		$stud_mail = $recordSet->fields["stud_mail"];
		$stud_class_kind = $recordSet->fields["stud_class_kind"];
		$stud_spe_kind = $recordSet->fields["stud_spe_kind"];
		$stud_spe_class_kind = $recordSet->fields["stud_spe_class_kind"];
		$stud_spe_class_id = $recordSet->fields["stud_spe_class_id"];
		$stud_preschool_status = $recordSet->fields["stud_preschool_status"];
		$stud_preschool_id = $recordSet->fields["stud_preschool_id"];
		$stud_preschool_name = $recordSet->fields["stud_preschool_name"];
		$stud_mschool_status = $recordSet->fields["stud_mschool_status"];
		$stud_mschool_id = $recordSet->fields["stud_mschool_id"];
		$stud_mschool_name = $recordSet->fields["stud_mschool_name"];
		$stud_study_year = $recordSet->fields["stud_study_year"];
		$curr_class_num = $recordSet->fields["curr_class_num"];
		$fath_name = $recordSet->fields["fath_name"];
		$fath_birthyear = $recordSet->fields["fath_birthyear"];
		$fath_alive = $recordSet->fields["fath_alive"];
		$fath_education = $recordSet->fields["fath_education"];
		$fath_occupation = $recordSet->fields["fath_occupation"];
		$fath_unit = $recordSet->fields["fath_unit"];
		$fath_phone = $recordSet->fields["fath_phone"];		
		$fath_hand_phone = $recordSet->fields["fath_hand_phone"];
		$moth_name = $recordSet->fields["moth_name"];
		$moth_birthyear = $recordSet->fields["moth_birthyear"];
		$moth_alive = $recordSet->fields["moth_alive"];
		$moth_relation = $recordSet->fields["moth_relation"];
		$moth_education = $recordSet->fields["moth_education"];	
		$moth_occupation = $recordSet->fields["moth_occupation"];
		$moth_unit = $recordSet->fields["moth_unit"];
		$moth_work_name = $recordSet->fields["moth_work_name"];
		$moth_phone = $recordSet->fields["moth_phone"];
		$moth_hand_phone = $recordSet->fields["moth_hand_phone"];
		$guardian_name = $recordSet->fields["guardian_name"];
		$guardian_phone = $recordSet->fields["guardian_phone"];
		$guardian_relation = $recordSet->fields["guardian_relation"];
		$guardian_unit = $recordSet->fields["guardian_unit"];
		$guardian_work_name = $recordSet->fields["guardian_work_name"];
		$guardian_hand_phone = $recordSet->fields["guardian_hand_phone"];
		$grandfath_name = $recordSet->fields["grandfath_name"];
		$grandfath_alive = $recordSet->fields["grandfath_alive"];
		$grandmoth_name = $recordSet->fields["grandmoth_name"];
		$grandmoth_alive = $recordSet->fields["grandmoth_alive"];
		$stud_study_cond = $recordSet->fields["stud_study_cond"];
	
		//�ǥͨ����O
		$stud_kind_temp='';
		$stud_kind_temp_arr = explode(",",$stud_kind);
		for ($iii=0;$iii<count($stud_kind_temp_arr);$iii++) {
			if ($stud_kind_temp_arr[$iii]<>'')
				$stud_kind_temp .= $stud_kind_arr[$stud_kind_temp_arr[$iii]].",";
		}
	
		$temp_arr["stud_kind"]= substr($stud_kind_temp,0,-1);
	
	
		//�ǥͰ򥻸��	
		$bir_temp_arr = explode("-",DtoCh($stud_birthday));		
		$temp_arr["stud_birthday"]=sprintf("%d�~%d��%d��",$bir_temp_arr[0],$bir_temp_arr[1],$bir_temp_arr[2]);
		$temp_arr["stud_blood_type"]=$blood_arr[$stud_blood_type];
		$temp_arr["stud_sex"]=$sex_arr[$stud_sex];
		$temp_arr["stud_name"]=$stud_name;
		$temp_arr["stud_id"]=$stud_id;
		$temp_arr["study_begin_date"]=$stud_study_year;		
		$temp_arr["stud_person_id"]=$stud_person_id;
		$temp_arr["stud_birth_place"]=$birth_state_arr[sprintf("%02d",$stud_birth_place)];
		$temp_arr["curr_year"]= Num2CNum(substr($curr_class_num,0,1));
		$temp_arr["curr_class"] = $class_name[substr($curr_class_num,1,2)];
		$temp_arr["curr_num"] = intval(substr($curr_class_num,-2))."��";
		$temp_arr["sch_cname"] = $SCHOOL_BASE[sch_cname];
		$temp_arr["stud_addr_1"] = $stud_addr_1;
		$temp_arr["stud_addr_2"] = $stud_addr_2;
		$temp_arr["stud_tel_1"] = $stud_tel_1;
		$temp_arr["stud_tel_2"] = $stud_tel_2;
	
		//���˸��
		$temp_arr["fath_name"] = $fath_name;
		$temp_arr["fath_alive"] = $is_live_arr[$fath_alive];
		 
		$temp_arr["fath_birthyear"] = $fath_birthyear;
		$temp_arr["fath_education"] = $edu_kind_arr[$fath_education];
		$temp_arr["fath_occupation"] = $fath_occupation;
		$temp_arr["fath_unit"] = $fath_unit;
		$temp_arr["fath_phone"] = $fath_phone;
		$temp_arr["fath_hand_phone"] = $fath_hand_phone;
	
		//���˸��
		$temp_arr["moth_name"] = $moth_name;
		$temp_arr["moth_alive"] = $is_live_arr[$moth_alive];
		$temp_arr["moth_birthyear"] = $moth_birthyear;
		$temp_arr["moth_education"] = $edu_kind_arr[$moth_education];
		$temp_arr["moth_occupation"] = $moth_occupation;
		$temp_arr["moth_unit"] = $moth_unit;
		$temp_arr["moth_phone"] = $moth_phone;
		$temp_arr["moth_hand_phone"] = $moth_hand_phone;
	
		//���@�H
		$temp_arr["guardian_name"]= $guardian_name;
		$temp_arr["guardian_relation"]= $guardian_relation_arr[$guardian_relation];
		$temp_arr["guardian_phone"]= $guardian_phone;
		$temp_arr["guardian_unit"]= $guardian_unit;
		$temp_arr["guardian_hand_phone"]= $guardian_hand_phone;
		
		//������
		$temp_arr["grandfath_name"] = $grandfath_name."(".$is_live_arr[$grandfath_alive].")";
		$temp_arr["grandmoth_name"] = $grandmoth_name."(".$is_live_arr[$grandmoth_alive].")";

//		$temp_arr["grandmoth_alive"] = $is_live_arr[$grandmoth_alive];
		
		//�Ǧ~��
		$temp_arr["seme_1"] = Num2CNum($stud_study_year) ;
		$temp_arr["seme_2"] = Num2CNum($stud_study_year+1) ;
		$temp_arr["seme_3"] = Num2CNum($stud_study_year+2) ;
		$temp_arr["seme_4"] = Num2CNum($stud_study_year+3) ;
		$temp_arr["seme_5"] = Num2CNum($stud_study_year+4) ;
		$temp_arr["seme_6"] = Num2CNum($stud_study_year+5) ;
		//�Ǧ~�y��
		$temp_arr["stud_seme_1"]='-';
		$temp_arr["stud_seme_2"]='-';
		$temp_arr["stud_seme_3"]='-';
		$temp_arr["stud_seme_4"]='-';
		$temp_arr["stud_seme_5"]='-';
		$temp_arr["stud_seme_6"]='-';
		//�J�ǾǮ�
		$temp_arr["stud_per_school"]=($IS_JHORES>0)?$stud_mschool_name:$stud_preschool_name;
		//���y���ʰO��
		
		$query = "select left(seme_class,1) as aa,right(seme_class,2) as bb,seme_class_name,seme_num from stud_seme where stud_id='$stud_id' and seme_year_seme like '%1' and  seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme' order by seme_year_seme   ";
		$res = $CONN->Execute($query) or die($query);
		while(!$res->EOF) {
		  $temp_arr["stud_seme_".$res->fields[0]] = Num2CNum($res->fields[0]).$res->fields[2].$res->fields[3]."��";
		  $res->MoveNext();
	}
		//���y����
		$temp_stud_move = $doc_stud_move;
		$query = "select * from stud_move where stud_id='$stud_id' and move_year_seme>='$min_year_seme' and move_year_seme<='$max_year_seme' order by move_date" ;
		$res = $CONN->Execute($query);
		while(!$res->EOF){
			$move_kind = $ttt->change_str($move_kind_arr[$res->fields[move_kind]]);
			$move_date = $res->fields[move_date];
			$move_c_unit = $ttt->change_str($res->fields[move_c_unit]);
			$move_year_seme = $res->fields[move_year_seme];
			$move_year_seme = sprintf("%d/%d",substr($move_year_seme,0,-1),substr($move_year_seme,-1));
			$move_year_seme = $ttt->change_str($move_year_seme);
			$move_c_unit = $ttt->change_str($res->fields[move_c_unit]);
			$move_c_num = $ttt->change_str($res->fields[move_c_num]);
			$school=$ttt->change_str($res->fields[school]);
			$school_id=$ttt->change_str($res->fields[school_id]);

			$temp_stud_move .= '<table:table-row><table:table-cell table:style-name="學�??��?�??.A2" table:value-type="string"><text:p text:style-name="P12">'.$move_kind.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.$move_date.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.$move_year_seme.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.$school_id.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.$school.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.$move_c_unit.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.G2" table:value-type="string"><text:p text:style-name="P12">'.$move_c_num.'</text:p></table:table-cell></table:table-row>';
			$res->MoveNext();
		}
			if($res->Recordcount()==0)
				$temp_stud_move .= '<table:table-row><table:table-cell table:style-name="學�??��?�??.A2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.B2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell><table:table-cell table:style-name="學�??��?�??.G2" table:value-type="string"><text:p text:style-name="P12">'.'-'.'</text:p></table:table-cell></table:table-row>';
		$temp_stud_move .= "</table:table>";

		//�X�ʮu�O��
		$temp_stud_abs = $doc_abs;
		//���X�u���
		$query = "select * from seme_course_date";
		$res = $CONN->Execute($query) or trigger_error("���]�w���X�u���,��[�а�]/[�Ǵ���]�w]�]�w��A�ާ@�����@�~",E_USER_ERROR);
		while(!$res->EOF){
			$abs_days_arr[$res->fields[seme_year_seme]][$res->fields[class_year]] = $res->fields[days];
			$res->MoveNext();
		}	
		//abs_kind 1"=>"�ư�","2"=>"�f��","3"=>"�m��"
		$query = "select * from stud_seme_abs where stud_id='$stud_id' and abs_kind<4  and seme_year_seme>='$min_year_seme' and seme_year_seme<='$max_year_seme' order by seme_year_seme,abs_kind";
		$res = $CONN->Execute($query);
		$temp_abs_arr = array();
		reset($temp_abs_arr);
		while(!$res->EOF){
			$seme_year_seme = $res->fields[seme_year_seme];
			$abs_kind = $res->fields[abs_kind];
			$temp_abs_arr[$seme_year_seme][$abs_kind] = $res->fields[abs_days];
			$res->MoveNext();
		}
		while(list($id,$val) = each($temp_abs_arr)){
			$t_id = substr($id,0,-1);
			$seme_name = (substr($id,-1)==1)?"�W":"�U";
			$seme_name = Num2CNum($t_id-$stud_study_year+1).$seme_name;
			$seme_name = $ttt->change_str($seme_name);
			$tol_abs_day = $val[1]+$val[2]+$val[3];
			$abs_days = $abs_days_arr[$id][$t_id-$stud_study_year+1+$IS_JHORES];
			$temp_stud_abs .='<table:table-row><table:table-cell table:style-name="?�缺席�???A2" table:value-type="string"><text:p text:style-name="P14">'.$seme_name.'</text:p></table:table-cell><table:table-cell table:style-name="?�缺席�???B2" table:value-type="string"><text:p text:style-name="P14">'.$abs_days.'</text:p></table:table-cell><table:table-cell table:style-name="?�缺席�???B2" table:value-type="string"><text:p text:style-name="P14">'.$val[1].'</text:p></table:table-cell><table:table-cell table:style-name="?�缺席�???B2" table:value-type="string"><text:p text:style-name="P14">'.$val[2].'</text:p></table:table-cell><table:table-cell table:style-name="?�缺席�???B2" table:value-type="string"><text:p text:style-name="P14">'.$val[3].'</text:p></table:table-cell><table:table-cell table:style-name="?�缺席�???F2" table:value-type="string"><text:p text:style-name="P14">'.$tol_abs_day.'</text:p></table:table-cell></table:table-row>';
		}
		$temp_stud_abs .= "</table:table>";
		
		$class_data_arr = array();
		//�ɮv�m�W
		$query="select * from stud_seme where student_sn='$student_sn'";
		$res=$CONN->Execute($query) or die($query);
		while(!$res->EOF) {
			$class_data_arr[$res->fields['seme_year_seme']][class_name]=$res->fields['seme_class'];
			$res->MoveNext();
		}
		while(list($s,$v)=each($class_data_arr)) {
			$class_id=sprintf("%03d_%d_%02d_%02d",substr($s,0,3),substr($s,-1,1),substr($class_data_arr[$s][class_name],0,-2),substr($class_data_arr[$s][class_name],-2,2));
			$query="select teacher_1 from school_class where class_id='$class_id' and enable='1'";
			$res=$CONN->Execute($query) or die($query);
			$class_data_arr[$s][teacher]=$res->fields['teacher_1'];
		}

		//���`�ͬ���{
		$temp_stud_nor = $doc_nor;
		$query = "select seme_year_seme,ss_score,ss_score_memo from stud_seme_score_nor where student_sn='$student_sn' order by seme_year_seme";
		$res= $CONN->Execute($query);
		while(!$res->EOF){
			$seme_year_seme = $res->fields[seme_year_seme];
			$ss_score = round($res->fields[ss_score],0);
			$ss_score_memo = $ttt->change_str($res->fields[ss_score_memo]);
			$t_id = substr($seme_year_seme,0,-1);
			$seme_name = (substr($seme_year_seme,-1)==1)?"�W":"�U";
		//	$this_year = $t_id-$stud_study_year+1;
			$this_year = $t_id-$stud_study_year+1+$IS_JHORES ;
			$seme_name = Num2CNum($this_year).$seme_name;
			$seme_name = $ttt->change_str($seme_name);
			$ss_rule = $ss_score?rep_score2str($ss_score,$score_rule_arr[$seme_year_seme][$this_year]):'';
//			echo "$ss_score,$ss_rule".$score_rule_arr[$seme_year_seme][$this_year];exit;
			$ss_rule = $ttt->change_str($ss_rule);
			$teacher_name = $ttt->change_str($class_data_arr[$seme_year_seme][teacher]);
			$temp_stud_nor .='<table:table-row><table:table-cell table:style-name="?�常??��表�?�?A2" table:value-type="string"><text:p text:style-name="P13">'.$seme_name.'</text:p></table:table-cell><table:table-cell table:style-name="?�常??��表�?�?B2" table:value-type="string"><text:p text:style-name="P13">'.$ss_score.'</text:p></table:table-cell><table:table-cell table:style-name="?�常??��表�?�?B2" table:value-type="string"><text:p text:style-name="P13">'.$ss_rule.'</text:p></table:table-cell><table:table-cell table:style-name="?�常??��表�?�?B2" table:value-type="string"><text:p text:style-name="P18">'.$ss_score_memo.'</text:p></table:table-cell><table:table-cell table:style-name="?�常??��表�?�?E2" table:value-type="string"><text:p text:style-name="P13">'.$teacher_name.'</text:p></table:table-cell></table:table-row>';
			$res->MoveNext();
		}
		
		$temp_stud_nor .="</table:table>";	
		
		//�ǲ߻�����
		$temp_stud_score =$doc_score;
	

		$query = "select a.seme_year_seme,a.ss_id,a.ss_score,a.ss_score_memo from stud_seme_score a,score_ss b where a.ss_id=b.ss_id and a.student_sn='$student_sn' and a.ss_score is not NULL and b.enable='1' order by b.year,b.semester,b.class_year,b.sort";
		$res = $CONN->Execute($query);
		while(!$res->EOF){
			$ss_id = $res->fields[ss_id];
			$year = substr($res->fields[seme_year_seme],0,-1);
			$semester = substr($res->fields[seme_year_seme],-1);
			//$this_year = $year-$stud_study_year+1;
			if ($IS_JHORES>0)
				$this_year = $year-$stud_study_year+1+$IS_JHORES ;
			else
				$this_year = $year-$stud_study_year+1;
			
//			$semester = $res->fields[semester];
			$ss_score = intval($res->fields[ss_score]);
			$ss_rule = $ss_score?rep_score2str($ss_score,$score_rule_arr[$seme_year_seme][$this_year]):'';
			$ss_rule = $ttt->change_str($ss_rule);
			$ss_score_memo = $ttt->change_str($res->fields[ss_score_memo]);
			$ss_name = $ttt->change_str(rep_get_ss_name($ss_id,$subject_name_arr));
			$year_seme = "$year-$semester";	
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
                        $seme_name = $ttt->change_str($seme_name);	
			$temp_stud_score.='<table:table-row><table:table-cell table:style-name="學�????�??�??�?A2" table:value-type="string"><text:p text:style-name="P13">'.$year_seme.'</text:p></table:table-cell><table:table-cell table:style-name="學�????�??�??�?B2" table:value-type="string"><text:p text:style-name="P13">'.$seme_name .'</text:p></table:table-cell><table:table-cell table:style-name="學�????�??�??�?B2" table:value-type="string"><text:p text:style-name="P13">'.$ss_name.'</text:p></table:table-cell><table:table-cell table:style-name="學�????�??�??�?B2" table:value-type="string"><text:p text:style-name="P13">'.$ss_score.'</text:p></table:table-cell><table:table-cell table:style-name="學�????�??�??�?B2" table:value-type="string"><text:p text:style-name="P13">'.$ss_rule.'</text:p></table:table-cell><table:table-cell table:style-name="學�????�??�??�?F2" table:value-type="string"><text:p text:style-name="P18">'.$ss_score_memo.'</text:p></table:table-cell></table:table-row>';
			$res->MoveNext();
		}
		$temp_stud_score .="</table:table>";	
		
		//���~���Z
		$temp_stud_grade =$doc_grade;		
		for($i=0;$i<1;$i++) {
			$temp_stud_grade .='<table:table-row><table:table-cell table:style-name="?�業??��.A2" table:value-type="string"><text:p text:style-name="P13">--</text:p></table:table-cell><table:table-cell table:style-name="?�業??��.B2" table:value-type="string"><text:p text:style-name="P13">--</text:p></table:table-cell><table:table-cell table:style-name="?�業??��.B2" table:value-type="string"><text:p text:style-name="P13">--</text:p></table:table-cell><table:table-cell table:style-name="?�業??��.B2" table:value-type="string"><text:p text:style-name="P13">--</text:p></table:table-cell><table:table-cell table:style-name="?�業??��.B2" table:value-type="string"><text:p text:style-name="P13">--</text:p></table:table-cell><table:table-cell table:style-name="?�業??��.F2" table:value-type="string"><text:p text:style-name="P13">--</text:p></table:table-cell></table:table-row>';
			

		}
		$temp_stud_grade .="</table:table>";
		
		//�ĤG����
		$temp_page_head = change_temp(array("stud_id"=>"$stud_id","stud_name"=>"$stud_name","stud_sex"=>$sex_arr[$stud_sex]),$doc_page_head);

		$doc_sign = change_temp(array("print_time"=>"�C�L�ɶ�: $print_time"),$doc_sign);
		//���N�򥻸��
		$data .= change_temp($temp_arr,$doc_stud_base).$temp_stud_move.$temp_stud_abs.$doc_sign.$temp_page_head.$temp_stud_nor.$temp_stud_score.$temp_stud_grade;
	
		$recordSet->MoveNext();	
		//����
		if (!$recordSet->EOF)
			$data .= $break;
	}
	$sss = $doc_head.$data.$doc_foot;

	$ttt->add_file($sss,"content.xml");


	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	
	echo  $ttt->file();
	
	exit;	
	break;
	}
}
}







//��ܯZ��

head();
print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='sel_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;
if ($_REQUEST[year_seme]=='')
	$_REQUEST[year_seme] = sprintf("%03d%d",curr_year(),curr_seme());

echo "<form  enctype='multipart/form-data' action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"myform\">";
$sel1 = new drop_select();
$sel1->top_option =  "��ܾǦ~";
$sel1->s_name = "year_seme";
$sel1->id = $_REQUEST[year_seme];
$sel1->is_submit = true;
$sel1->arr = get_class_seme();
$sel1->do_select();

echo "&nbsp;&nbsp;";
$sel1 = new drop_select();
$sel1->top_option =  "��ܯZ��";
$sel1->s_name = "class_id";
$sel1->id = $class_id;
$sel1->is_submit = true;
$sel1->arr = class_base($_REQUEST[year_seme]);
$sel1->do_select();

if($class_id<>'') {
	$query = "select a.student_sn,a.stud_id,a.stud_name,a.curr_class_num,a.stud_study_cond from stud_base a , stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[year_seme]' and seme_class='$_REQUEST[class_id]' order by b.seme_num";
	$result = $CONN->Execute($query) or die ($query);
	if (!$result->EOF) {
 		echo '&nbsp;<input type="button" value="����" onClick="javascript:tagall(1);">&nbsp;';
 		echo '<input type="button" value="��������" onClick="javascript:tagall(0);">';
		echo "<a href='check_stud_seme.php'> <font color=red size=2>�ץ��Z�ŦW�ٿ��~����</font></a>";
		echo "<table border=1>";
		$ii=0;
		while (!$result->EOF) {
			$stud_id = $result->fields[stud_id];
			$student_sn = $result->fields[student_sn];
			$stud_name = $result->fields[stud_name];
			$curr_class_num = substr($result->fields[curr_class_num],-2);
			$stud_study_cond = $result->fields[stud_study_cond];
			$move_kind ='';
			if ($stud_study_cond >0) $move_kind= "<font color=red>(".$move_kind_arr[$stud_study_cond].")</font>";
				if($stud_study_cond==5) {
					$query = "select grad_kind from grad_stud where student_sn=$student_sn";
					$rt = $CONN->Execute($query) or die ($query);
					if($rt->fields[0]==2) $move_kind= "<font color='#cccccc'>�׷~</font>";				
				}
				
			if ($ii %2 ==0)
				$tr_class = "class=title_sbody1";
			else
				$tr_class = "class=title_sbody2";
			
			if ($ii % 5 == 0)
				echo "<tr $tr_class >";
			echo "<td ><input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$stud_id\"><label for=\"c_$stud_id\">$curr_class_num. $stud_name $move_kind</label></td>\n";
				
			if ($ii % 5 == 4)
				echo "</tr>";
			$ii++;
			$result->MoveNext();
		}
		echo"</table>";
		
		//�ˬd�O�_���W�Ǯ榡
		$myown_dir=$UPLOAD_PATH."stud_report/reg";
		if(file_exists("$myown_dir/content.xml")) $myown_style="<option value='$myown_dir' selected>�ۭq�W�Ǫ��榡";

		echo " Open Office ����X(.sxw)�G";
		echo "<select name='template'>$myown_style
			<option value='ooo'".($template=='ooo'?' selected':'').">�ǲή榡			
			<option value='tcc95_reg_ps'".($template=='tcc95_reg_ps'?' selected':'').">95��pA4�榡
			<option value='tcc95_reg_jh'".($template=='tcc95_reg_jh'?' selected':'').">95�ꤤA4�榡
			<option value='tc100_reg_ps'".($template=='tc100_reg_ps'?' selected':'').">�O����100��pA4�榡
			<option value='tc100_reg_jh'".($template=='tc100_reg_jh'?' selected':'').">�O����100�ꤤA4�榡</select>";
			
		echo "<input type=\"submit\" name=\"do_key\" value=\"$postBtn\">";
		echo "<input type=\"hidden\" name=\"filename\" value=\"reg2_class{$class_id}.sxw\">";
		echo '<br><font color=green size=2><a href='.$UPLOAD_URL.'stud_report/myown_reg.sxw>���W�Ǧۭq�榡�G</a><input type="file" name="myown"><input type="submit" name="do_key" value="�W��" onclick="if(this.form.myown.value) { return confirm(\'�W�ǫ�|�N��W�Ǯ榡�����A�z�T�w�n�o�˰���?\'); } else return false;"></font>';
	}
}



foot();




function change_temp($arr,$source) {
	global $ttt;
	$temp_str = $source;
	while(list($id,$val) = each($arr)){
		$val =$ttt->change_str($val);
		$temp_str = str_replace("{".$id."}", $val,$temp_str);
	}
	return $temp_str;
}
?>
