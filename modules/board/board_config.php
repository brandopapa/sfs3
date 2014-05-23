<?php

// $Id: board_config.php 7779 2013-11-20 16:09:00Z smallduh $

/* �ǰȨt�γ]�w�� */
require_once "../../include/config.php";
/* �ǰȨt�Ψ禡�w */
require_once "../../include/sfs_case_PLlib.php";

include "module-upgrade.php";

//���o�Ҳճ]�w
$m_arr = &get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

/* �W���ɮץت��ؿ� */
$path_str = "school/board/";
set_upload_path($path_str);
$USR_DESTINATION = $UPLOAD_PATH.$path_str;

/*�U�����| */
$download_path = $UPLOAD_URL.$path_str;


//������Ƴ]�w
$days = array("1"=>"�@��","2"=>"�G��","3"=>"�T��","4"=>"�|��","5"=>"����","6"=>"����","7"=>"�@�P��","14"=>"�G�P��","21"=>"�T�P��","30"=>"�@�Ӥ�","92"=>"�T�Ӥ�","183"=>"�b�~","365"=>"�@�~");

//�����a�}�]�w
$school_addr = $SCHOOL_BASE[sch_cname_s]."�a�}�G".$SCHOOL_BASE[sch_post_num].$SCHOOL_BASE[sch_addr];

//�����q�ܳ]�w
$school_tel = "�q�ܡG".$SCHOOL_BASE[sch_phone];

//�����ǯu�]�w
$school_fax = "�ǯu�G".$SCHOOL_BASE[sch_fax];

//��ƾ�s��
$calendar_url ="/school/calendar/";


//�ˬd�O�_������ ip
$insite_arr = explode(",",$insite_ip);

$is_home_ip = check_home_ip($insite_arr);


// �ˬd�O�_�^ñ
function CheckIsSigned($b_signs,$is_all=0){
		if (empty($b_signs))
		return false;
		$arr = explode(",",$b_signs);
		$temp_id_arr = array();
		$temp_time_arr = array();
		foreach($arr as $val){
			if ($val){
				$temp_arr = explode("^",$val);
				$temp_id_arr[] = $temp_arr[0];
				$temp_time_arr[$temp_arr[0]] = $temp_arr[1];
			}
		}
		if ($is_all){
			return $temp_time_arr;
		}
		else{
			if (in_array($_SESSION['session_tea_sn'],$temp_id_arr))
			return $temp_time_arr[$_SESSION['session_tea_sn']];
			else
			return false;
		}
	}


// ���o�W�Ǥ��
function board_getFileArray($b_id){
        global $USR_DESTINATION,$CONN;
        $res_arr=array();
        if ($b_id) {
                $sPath = $USR_DESTINATION.'/'.$b_id;
                if (!is_dir($sPath))
                        return false;

                $oHandle = opendir( $sPath );
                $res_arr = array();
                while ( $sFilename = readdir( $oHandle ) ) {
                        if ( $sFilename == "." || $sFilename == ".." )
                        continue;
                        $id_arr = explode('-',$sFilename);
                        $id = $id_arr[0];
                        $res_arr[$id]['new_filename'] = $sFilename;
                        $query="select id,org_filename from board_files where b_id='$b_id' and new_filename='$sFilename'";
                        $res=$CONN->Execute($query) or die($query);
                        if ($res->RecordCount()>0) {
                         $res_arr[$id]['id']=$res->fields['id'];
                         $res_arr[$id]['org_filename']=$res->fields['org_filename'];
                        } else {
                        	$res_arr[$id]['org_filename']="";
                        }
                }
        }
        return $res_arr;
}

function redir_str( $surl ,$str="",$sec) {
  //�� $sec ���A��V��$sul �����A������b header����
  print("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">");
  print("<meta http-equiv=\"refresh\" content=\"" . $sec . "; url=" . $surl ."\">  \n" ) ;
  print("</head><body>");
  print($str);
  print("</body></html>");
  //�Ƶ��Aphp ����� Header("Location:cal2.php") ;�|���W��}�A�L�k�X�{�T���ε���
}

//�ˬd�ϥ��v
function board_checkid($chk){
	global $conID,$session_log_id ,$app_name,$session_tea_sn;
	$chkary= explode ("/",$chk);

	$pp	= $chkary[count($chkary)-2];
	$post_office = -1;
	$teach_title_id = -1;
	$teach_id = -1 ;
	$dbquery = " select a.teacher_sn,a.login_pass,a.name,b.post_office,b.teach_title_id ";
	$dbquery .="from teacher_base a ,teacher_post b  ";
	$dbquery .="where a.teacher_sn = b.teacher_sn and a.teacher_sn='$_SESSION[session_tea_sn]'";
	$result= mysql_query($dbquery,$conID)or ("<br>��Ƴs�����~<br>\n $dbquery");

	if (mysql_num_rows($result) > 0){
		$row = mysql_fetch_array($result);
		$post_office = $row["post_office"];
		$teach_title_id	= $row["teach_title_id"];
		$teacher_sn =	$row["teacher_sn"];

		$dbquery = "select pro_kind_id from board_check where pro_kind_id ='$chk' and (post_office='$post_office' or post_office='99' or teach_title_id='$teach_title_id' or teacher_sn='$teacher_sn')";

		$result= mysql_query($dbquery,$conID)or die("<br>��Ʈw�s�����~<br>\n $dbquery");
		if (mysql_num_rows ($result)>0)	{
			return true;
		}
		else
			return false;
	}
	else
		return false;
}
?>
