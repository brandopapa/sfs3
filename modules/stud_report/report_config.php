<?php
include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_oo_zip2.php";
include_once "../../include/sfs_case_subjectscore.php";
$move_kind_arr= array("0"=>"�b�y","1"=>"��X","2"=>"��J","3"=>"�����_��","4"=>"��Ǵ_��","5"=>"���~","6"=>"���","7"=>"�X��","8"=>"�ծ�","9"=>"�ɯ�","10"=>"����","11"=>"���`","12"=>"����","13"=>"�s�ͤJ��","14"=>"��Ǵ_��","15"=>"�b�a�۾�","99"=>"�R��");
require_once "./module-cfg.php";

function get_score_rule_arr(){
	global $CONN;
	$query = "select  year,semester,class_year,rule from score_setup";
	$res = $CONN->Execute($query);
	$res_arr = array();
	while(!$res->EOF){
		$seme_year_seme =sprintf("%03d%d",$res->fields[year],$res->fields[semester]);
		$class_year = $res->fields[class_year];
		$rule = $res->fields[rule];
		$res_arr[$seme_year_seme][$class_year] = $rule;
	//	echo "$seme_year_seme , $class_year = $rule <BR>";
		$res->MoveNext();
	}
	return $res_arr;
}
//���o�~�׽ҵ{�W�ٰ}�C
function rep_get_ss_name($ss_id,$subject_name_arr){
        global $CONN;
		$ss_id=intval($ss_id);
        $query = "select * from score_ss where  ss_id='$ss_id'";
        $res = $CONN->Execute($query);
	$ss_id=$res->fields[ss_id];
	$scope_id=$res->fields[scope_id];
	$subject_id=$res->fields[subject_id];
                                                                                                               
	//���o���W��
	$scope_name=$subject_name_arr[$scope_id][subject_name];
	//���o�Ǭ�W��
	$subject_name=(!empty($subject_id))?$subject_name_arr[$subject_id][subject_name]:"";
	$show_ss=(empty($subject_name))?$scope_name:$scope_name."-".$subject_name;
	return $show_ss;
}
                                                                                                               

function rep_score2str($score,$rule){
        //���ѳW�h
	$r=explode("\n",$rule);
	while(list($k,$v)=each($r)){
		$rule_a=array();
		$str=explode("_",$v);
		$du_str = (double)$str[2];
                                                                                                               
		if($str[1]==">="){
			if($score >= $du_str)return $str[0];
		}elseif($str[1]==">"){
			if($score > $du_str)return $str[0];
		}elseif($str[1]=="="){
			if($score == $du_str)return $str[0];
		}elseif($str[1]=="<"){
			if($score < $du_str)return $str[0];
		}elseif($str[1]=="<="){
			if($score <= $du_str)return $str[0];
		}
	}


}

function get_rep_score_subject(){
	global $CONN;
	$query = "select * from score_subject where enable=1";
	$res=$CONN->Execute($query);
	$res_arr = array();
	while(!$res->EOF){
		$subject_id = $res->fields[subject_id];
		$subject_name = $res->fields[subject_name];
		$subject_kind = $res->fields[subject_kind];
		$res_arr[$subject_id][$subject_kind] = $subject_name;
		$res->MoveNext();
	}
	return $res_arr;
}

//�R���ؿ�
function deldir($dir){
        $current_dir = opendir($dir);
        while($entryname = readdir($current_dir)){
                if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
                        deldir("${dir}/${entryname}");
                }elseif($entryname != "." and $entryname!=".."){
                        unlink("${dir}/${entryname}");
                }
        }
        closedir($current_dir);
        rmdir(${dir});
}

?>
