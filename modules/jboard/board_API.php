<?php

// $Id: board_show.php 7779 2013-11-20 16:09:00Z smallduh $
// --�t�γ]�w��
ini_set('memory_limit', '-1');

include "board_config.php";
include_once "../../include/sfs_case_dataarray.php";

//echo $_GET['api_key'].";".$_GET['act'];
//mysqli
$mysqliconn = get_mysqli_conn();

if ($_GET['api_key'] != $api_key) {
    $row[1] = "API Key ���~!";
}
//����
if ($_GET['act'] == 'test') {
    $row = "����! �s�u���\!";
    $row = base64_encode(addslashes($row));
    //$row[1]="ok!";
}



if ($_GET['act'] == 'GetPages') {
    //��L���m������
    $CONN->Execute("UPDATE `jboard_p` SET b_sort = '100',top_days='0' WHERE (to_days(b_open_date) + top_days) < to_days(now( )) and top_days>0");

    //���ǤJ������
    $bk_id = $_GET['bk_id'];
    $page_count = $_GET['page_count'];  //�C���X�� 
    //�ˬd�O�_�}�� jboard_kind �� board_is_public=1
    //�}�l�զX sql
    //$sql_select = "select b_id from jboard_p  where bk_id='$bk_id' ";
    $sql_select = "select count(b_id) from jboard_p  where bk_id=? ";

    //�P�B�e�{�O�ϸ��
    /*
      $sql_sync="select bk_id,synchronize_days from jboard_kind where synchronize='$bk_id' and bk_id<>'$bk_id'";
      $res=$CONN->Execute($sql_sync) or die ($sql_sync);
     */

///mysqli
//$sql_sync="select bk_id,synchronize_days from jboard_kind where synchronize=? and bk_id<>?";
    $sql_sync = "select count(*) from jboard_kind where synchronize=? and bk_id<>?";
    $stmt = "";
    $stmt = $mysqliconn->prepare($sql_sync);
    $stmt->bind_param('ss', $bk_id, $bk_id);
    $stmt->execute();
    $stmt->bind_result($cc);
    $stmt->fetch();
    $stmt->close();
///mysqli
    //if ($res->RecordCount()) {
    if ($cc) {

///mysqli
        $sql_sync = "select bk_id,synchronize_days from jboard_kind where synchronize=? and bk_id<>?";
        $stmt = "";
        $stmt = $mysqliconn->prepare($sql_sync);
        $stmt->bind_param('ss', $bk_id, $bk_id);
        $stmt->execute();
        $stmt->bind_result($bk_idx, $synchronize_days);
///mysqli
        //while ($row=$res->fetchRow()) {
        //$SYNC[]=array('bk_id'=>$row['bk_id'],'days'=>$row['synchronize_days']); //�P�B�O�� id
        while ($stmt->fetch()) {
            $SYNC[] = array('bk_id' => $bk_idx, 'days' => $synchronize_days); //�P�B�O�� id
        }
    }
    //�P�B�e�{���O��
    if (count($SYNC) > 0) {
        foreach ($SYNC as $v) {
            $sql_select .=" or (bk_id='" . $v['bk_id'] . "' and to_days(b_open_date)+ " . $v['days'] . " > to_days(curdate()))";
        }
    }

    $sql_select.=" order by b_sort,b_open_date desc ,b_post_time desc ";

///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($sql_select);
    $stmt->bind_param('s', $bk_id);
    $stmt->execute();
    $stmt->bind_result($tol_num);
    $stmt->fetch();
    $stmt->close();
///mysqli
    //$result = $CONN->Execute($sql_select) or die ($sql_select);
    //$tol_num= $result->RecordCount($result);
    //�p�⭶��
    if ($tol_num % $page_count > 0)
        $tolpage = intval($tol_num / $page_count) + 1;
    else
        $tolpage = intval($tol_num / $page_count);

    $row = $tolpage;
}

//�j�M��
if ($_GET['act'] == 'GetSearch') {
    $search_startday = $_GET['search_startday'];
    $search_endday = $_GET['search_endday'];
    $search_room = $_GET['search_room'];
    $search_teachertitle = $_GET['search_teachertitle'];
    $search_key = $_GET['search_key'];
    $search_limit = $_GET['search_limit'];
    $page_office = $_GET['page_office'];

    //$sql_select="select * from jboard_p where b_open_date>='$search_startday' and b_open_date<='$search_endday'";
    $sql_select = "select b_id,bk_id,b_open_date,b_days,b_unit,b_title,b_name,b_sub,b_con,b_hints,b_url,b_post_time,b_own_id,b_is_intranet,b_is_marquee,b_signs,b_is_sign,teacher_sn,b_sort,top_days from jboard_p where b_open_date>=? and b_open_date<=?";
    //������B��
    if ($search_room != "") {
        //$sql_select.=" and b_unit='$search_room'";
        $sql_select.=" and b_unit=?";
    }
    //������¾��
    if ($search_teachertitle != "") {
        //$sql_select.=" and b_title='$search_teachertitle'";
        $sql_select.=" and b_title=?";
    }
    //����������r
    if ($search_key != "") {
        //$search_key=iconv("UTF-8","BIG5//IGNORE",$search_key);
        //$sql_select.=" and b_sub like '%".addslashes($search_key)."%'";
        $sql_select.=" and b_sub like ?";
    }
    //������j�M�d��
    if ($search_limit == '1') {
        $offices = explode(",", $page_office);
        $sql_select2 = "";
        foreach ($offices as $OFFICE) {
            $sql_select2.="bk_id='" . $OFFICE . "' or ";
        }
        $sql_select2 = substr($sql_select2, 0, strlen($sql_select2) - 4);

        $sql_select.=" and (" . $sql_select2 . ")";
    }

    /*
      echo $sql_select;
      exit();
     */
    //���� sql
    $sql_select.=" order by b_open_date desc limit 100";

    //$result = $CONN->Execute($sql_select) or die ($sql_select);
    ///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($sql_select);
    $stmt->mbind_param('ss', $search_startday, $search_endday);
    if ($search_room != "")
        $stmt->mbind_param('s', $search_room);
    if ($search_teachertitle != "")
        $stmt->mbind_param('s', $search_teachertitle);
    if ($search_key != "") {
        $search_key = iconv("UTF-8", "BIG5//IGNORE", $search_key);
        $search_key = "%" . addslashes($search_key) . "%";
        $stmt->mbind_param('s', $search_key);
    }
    $stmt->execute();
    $stmt->bind_result($b_id, $bk_id, $b_open_date, $b_days, $b_unit, $b_title, $b_name, $b_sub, $b_con, $b_hints, $b_url, $b_post_time, $b_own_id, $b_is_intranet, $b_is_marquee, $b_signs, $b_is_sign, $teacher_sn, $b_sort, $top_days);

///mysqli
    //$ROW=$result->GetRows();
///mysqli
    $meta = $stmt->result_metadata();
    while ($field = $meta->fetch_field()) {
        $params[] = &$row[$field->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    while ($stmt->fetch()) {
        foreach ($row as $key => $val) {
            $c[$key] = $val;
        }
        $ROW[] = $c;
    }
    $stmt->close();
///mysqli
    //��X
    $row = array();
    foreach ($ROW as $k => $v) {
        $row[$k] = array_base64_encode($v);
    }
} // end if GetSearch
//���o�Ҧ��B��
if ($_GET['act'] == 'GetRooms') {
    /* �B�ǰ}�C */
    $ROOM = room_kind();
    $row = array_base64_encode($ROOM);
}

//���o�Ҧ�¾��
if ($_GET['act'] == 'GetTeacherTitle') {
    /* ¾�ٰ}�C */
    $TEACHER_TITLE = title_kind();
    $row = array_base64_encode($TEACHER_TITLE);
}


if ($_GET['act'] == 'GetMarquee') {
    $bk_id = $_GET['bk_id'];

    //�]���O $html_link
    //$query = "select b_id,b_sub,b_is_intranet,b_title from jboard_p where bk_id='$bk_id' and";        
    $query = "select b_id,b_sub,b_is_intranet,b_title from jboard_p where bk_id=? and";
    $query.=" b_is_marquee = '1' and ((to_days(b_open_date)+b_days > to_days(current_date())) or (to_days(b_open_date)+" . $max_marquee_days . " > to_days(current_date())));";

    //$result = $CONN->Execute($query) or die($query);
///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($query);
    $stmt->bind_param('s', $bk_id);
    $stmt->execute();
    $stmt->bind_result($b_id, $b_sub, $b_is_intranet, $b_title);
///mysqli
    //$ROW=$result->GetRows();
///mysqli
    $meta = $stmt->result_metadata();
    while ($field = $meta->fetch_field()) {
        $params[] = &$row[$field->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    while ($stmt->fetch()) {
        foreach ($row as $key => $val) {
            $c[$key] = $val;
        }
        $ROW[] = $c;
    }
    $stmt->close();
///mysqli
    //��X
    $row = array();
    foreach ($ROW as $k => $v) {
        $v['b_title'] = $TEACHER_TITLE[$v['b_title']];
        $row[$k] = array_base64_encode($v);
    }
}

if ($_GET['act'] == 'GetList') {

    //���ǤJ������
    $bk_id = $_GET['bk_id'];
    $post_page = $_GET['post_page'];    //�ĴX��
    $page_count = $_GET['page_count'];  //�C���X�� 
    $search_key = $_GET['search_key'];  //���S�����ޱ���
    //�ˬd�O�_�}�� jboard_kind �� board_is_public=1
    //$sql_boardname="select board_name from jboard_kind where bk_id='$bk_id'";
    $sql_boardname = "select board_name from jboard_kind where bk_id=?";
    //$res=$CONN->Execute($sql_boardname);
///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($sql_boardname);
    $stmt->bind_param('s', $bk_id);
    $stmt->execute();
    $stmt->bind_result($board_name);
    $stmt->fetch();
    $stmt->close();
///mysqli
    //$board_name=$res->fields['board_name'];
    //�}�l�զX sql
    //$sql_select = "select a.*,b.board_name from jboard_p a,jboard_kind b where a.bk_id=b.bk_id and ( a.bk_id='$bk_id' ";
    $sql_select = "select a.b_id,a.bk_id,a.b_open_date,a.b_days,a.b_unit,a.b_title,a.b_name,a.b_sub,a.b_con,a.b_hints,a.b_url,a.b_post_time,a.b_own_id,a.b_is_intranet,a.b_is_marquee,a.b_signs,a.b_is_sign,a.teacher_sn,a.b_sort,a.top_days,b.board_name from jboard_p a,jboard_kind b where a.bk_id=b.bk_id and ( a.bk_id=? ";

    //�P�B�e�{�O�ϸ��
    //$sql_sync="select bk_id,synchronize_days from jboard_kind where synchronize='$bk_id' and bk_id<>'$bk_id'";
    $sql_sync = "select count(*) from jboard_kind where synchronize=? and bk_id<>?";
///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($sql_sync);
    $stmt->bind_param('ss', $bk_id, $bk_id);
    $stmt->execute();
    $stmt->bind_result($cc1);
    $stmt->fetch();
    $stmt->close();
///mysqli
    //$res=$CONN->Execute($sql_sync) or die ($sql_sync);
    //if ($res->RecordCount()) {
    if ($cc1) {
        ///mysqli
        $sql_sync = "select bk_id,synchronize_days from jboard_kind where synchronize=? and bk_id<>?";
        $stmt = "";
        $stmt = $mysqliconn->prepare($sql_sync);
        $stmt->bind_param('ss', $bk_id, $bk_id);
        $stmt->execute();
        $stmt->bind_result($bk_idx, $synchronize_days);
        ///mysqli
        //while ($row=$res->fetchRow()) {		
        //$SYNC[]=array('bk_id'=>$row['bk_id'],'days'=>$row['synchronize_days']); //�P�B�O�� id
        while ($stmt->fetch()) {
            $SYNC[] = array('bk_id' => $bk_idx, 'days' => $synchronize_days); //�P�B�O�� id
        }
    }
    //�P�B�e�{���O��
    if (count($SYNC) > 0) {
        foreach ($SYNC as $v) {
            $sql_select .=" or (a.bk_id='" . $v['bk_id'] . "' and to_days(a.b_open_date)+ " . $v['days'] . " > to_days(curdate()))";
        }
    }


    //����J����	
    if ($search_key != "") {
        //$search_key=iconv("UTF-8","BIG5//IGNORE",$search_key);
        //$sql_select.=") and a.b_sub like '%".addslashes($search_key)."%'";
        $sql_select.=") and a.b_sub like ?";
    }

    $sql_select.=(($search_key == "") ? ")" : "") . " order by a.b_sort,a.b_open_date desc ,a.b_post_time desc ";

    //���X���
    $sql_select .= " limit " . ($post_page * $page_count) . ", $page_count";

    //$result = $CONN->Execute($sql_select) or die ($sql_select);
    ///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($sql_select);
    $stmt->mbind_param('s', $bk_id);
    if ($search_key != "") {
        $search_key = iconv("UTF-8", "BIG5//IGNORE", $search_key);
        $search_key = "%" . addslashes($search_key) . "%";
        $stmt->mbind_param('s', $search_key);
    }
    $stmt->execute();
    $stmt->bind_result($b_id, $bk_id, $b_open_date, $b_days, $b_unit, $b_title, $b_name, $b_sub, $b_con, $b_hints, $b_url, $b_post_time, $b_own_id, $b_is_intranet, $b_is_marquee, $b_signs, $b_is_sign, $teacher_sn, $b_sort, $top_days, $board_name);

///mysqli			
    //$ROW=$result->GetRows();
///mysqli
    $meta = $stmt->result_metadata();
    while ($field = $meta->fetch_field()) {
        $params[] = &$row[$field->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    while ($stmt->fetch()) {
        foreach ($row as $key => $val) {
            $c[$key] = $val;
        }
        $ROW[] = $c;
    }
    $stmt->close();
///mysqli	  
    //��X
    $row = array();
    foreach ($ROW as $k => $v) {
        $v['board_name'] = $board_name;
        $row[$k] = array_base64_encode($v);
    }
}



//Ū���@�g�峹
if ($_GET['act'] == 'GetOne' and $_GET['b_id'] != '') {
    $b_id = intval($_GET['b_id']);
    $query = "update jboard_p set b_hints = b_hints+1 where b_id='$b_id' ";
    $res = $CONN->Execute($query);
    $query = "select  a.*,b.board_name from jboard_p a,jboard_kind b where a.bk_id=b.bk_id  and a.b_id='$b_id'";
    $result = $CONN->Execute($query);
    $row = $result->fetchRow();
    $row = array_base64_encode($row);
}

//Ū���@�g�峹��������C��
if ($_GET['act'] == 'GetFileNameList' and $_GET['b_id'] != '') {
    $b_id = intval($_GET['b_id']);
    $query = "select new_filename,org_filename from jboard_files where b_id='$b_id'";
    $result = $CONN->Execute($query);
    $ROW = $result->GetRows();

    //��X
    $row = array();
    foreach ($ROW as $k => $v) {
        $row[$k] = array_base64_encode($v);
    }
}


//Ū���� , ������X
if ($_GET['act'] == 'GetImage' and $_GET['b_id'] != "" and $_GET['name'] != "") {
    $name = $_GET['name'];
    $b_id = intval($_GET['b_id']);
    //$query="select filetype,content from jboard_images where b_id='".$b_id."' and filename='".$name."'";
    $query = "select filetype,content from jboard_images where b_id=$b_id and filename=?";
///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($query);
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($filetype, $content);
    $stmt->fetch();
    $stmt->close();
///mysqli				
    //$res=$CONN->Execute($query) or die($query);
    //$row= $r:qexites->fetchRow();
    $row['filetype'] = $filetype;
    $row['content'] = $content;
}

//Ū���ɮ� , ������X
if ($_GET['act'] == 'GetFile' and $_GET['b_id'] != "" and $_GET['name'] != "") {
    $name = $_GET['name'];
    $b_id = intval($_GET['b_id']);
    //���AŪ����� MySQL ��Ʈw�� content �� , 2014.09.30�_�אּ�ɮפ覡
    //$query="select org_filename,filetype,content from jboard_files where b_id='".$b_id."' and new_filename='".$name."'";
    //$query="select org_filename,filetype from jboard_files where b_id='".$b_id."' and new_filename='".$name."'";
    $query = "select org_filename,filetype from jboard_files where b_id='" . $b_id . "' and new_filename=?";
///mysqli
    $stmt = "";
    $stmt = $mysqliconn->prepare($query);
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->bind_result($org_filename, $filetype);
    $stmt->fetch();
    $stmt->close();
///mysqli				


    $row['filetype'] = $filetype;

    //$res=$CONN->Execute($query) or die($query);
    //$row= $res->fetchRow();	
    $row['org_filename'] = base64_encode(addslashes($org_filename));

    // 2014.09.30 �אּŪ�ɤ覡, ���ɮ�Ū�J, �s�X, �s�J�ܼ� $row['content'] , ���AŪ����� MySQL ��Ʈw�� content ��
    $sFP = fopen($Download_Path . $name, "r");    //���J�ɮ�
    $sFilesize = filesize($Download_Path . $name);  //�ɮפj�p       		
    $sFile = addslashes(fread($sFP, $sFilesize));
    $row['content'] = base64_encode($sFile);
}


//�e�X
exit(json_encode($row));

//�N�}�C�s�X
function array_base64_encode($arr) {
    $B_arr = array();
    foreach ($arr as $k => $v) {
        $B_arr[$k] = base64_encode(addslashes($v));
    }
    return $B_arr;
}
