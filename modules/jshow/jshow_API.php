<?php
// $Id: board_show.php 7779 2013-11-20 16:09:00Z smallduh $
// --�t�γ]�w��
ini_set('memory_limit', '-1');
include	"config.php";
include_once "../../include/sfs_case_dataarray.php";

//echo $_GET['api_key'].";".$_GET['act'];;

if ($_GET['api_key']!=$api_key) {
  $row[1]="API Key ���~!";
}
//����
if ($_GET['act']=='test') {
	$row="����! �s�u���\!";
  $row=base64_encode(addslashes($row));
  //$row[1]="ok!";
}

//���o�O�骺��id��
if ($_GET['act']=='GetDayPicID') {
  $kind_id=intval($_GET['kind_id']);  //���w������
  $day=date("m-d");
  //���o�w�]�Ϥ��P����Ϥ�
  $sql="select init_pic_set,day_pic_set from jshow_setup where kind_id='$kind_id'";
  $res=$CONN->Execute($sql);
  $init_pic_set=$res->fields['init_pic_set'];
  $day_pic_set=$res->fields['day_pic_set'];
  $day_pic_set=unserialize($day_pic_set);
  
  //���o
  if ($day_pic_set[$day]==0) {
   if ($init_pic_set==0) {
   	 $row=0;
   } else {
     $row=$init_pic_set;  //�H�w�]�Ȩ��N
   }
  } else {
   $row=$day_pic_set[$day];
  }
}

//���o�Ykind_id���Ҧ���id
if ($_GET['act']=='GetPicByKindID') {
  $kind_id=intval($_GET['kind_id']);  //���w������
  //���o�w�]�Ϥ��P����Ϥ�
  $sql="select * from jshow_pic where kind_id='$kind_id' and display='1' order by sort";
  if ($_GET['visible']>0) $sql.=" limit ".$_GET['visible']; 
  $res=$CONN->Execute($sql);
  $ROW=$res->GetRows();
  //��X
  $row=array();
  foreach ($ROW as $k=>$v) {
        $row[$k]=array_base64_encode($v);
  }
}

//���o�Ykind_id���Ҧ���id���H��
if ($_GET['act']=='GetPicByKindIDorderByRand') {
  $kind_id=intval($_GET['kind_id']);  //���w������
  //�Y�����w����Ϥ�
  if ($_GET['visible_must']!="") {
    $must="and id not in (".$_GET['visible_must'].")";
    //���o����Ϥ�
    $sql="select * from jshow_pic where kind_id='$kind_id' and display='1' and id in (".$_GET['visible_must'].") order by sort";
  	$res=$CONN->Execute($sql);
  	$ROW_MUST=$res->GetRows();
  } else {
    $must="";
  }
  
  //���o�w�]�Ϥ��P����Ϥ�
  $sql="select * from jshow_pic where kind_id='$kind_id' and display='1' ".$must." order by RAND()";
  if ($_GET['visible']>0) $sql.=" limit ".$_GET['visible']; 
  $res=$CONN->Execute($sql);
  $ROW=$res->GetRows();
  //��X
  $row=array();
  $i=0;
  foreach ($ROW_MUST as $k=>$v) {
        $i++;
        $row[$i]=array_base64_encode($v);
  }
  foreach ($ROW as $k=>$v) {
        $i++;
        $row[$i]=array_base64_encode($v);
  }
}


//���okind_id���]�w��
if ($_GET['act']=='GetSetup') {
  $kind_id=intval($_GET['kind_id']);  //���w������
  
  //���o�w�]�Ϥ��P����Ϥ�
  $sql="select * from jshow_setup where kind_id='$kind_id'";
  $res=$CONN->Execute($sql);
  
  $ROW=$res->fetchRow();
  
  $row=array_base64_encode($ROW);
  
}


//Ū���� , ������X
if ($_GET['act']=='GetImage' and $_GET['id']!="") {	
	$id=intval($_GET['id']);
	$query="select * from jshow_pic where id='".$id."'";
	$res=$CONN->Execute($query) or die($query);
	$row= $res->fetchRow();	
	$filename=$row['filename'];
	
	//Ū������
	 $sFP=fopen($USR_DESTINATION.$filename,"r");							//���J�ɮ�
   $sFilesize=filesize($USR_DESTINATION.$filename); 				//�ɮפj�p
   $sFiletype=filetype($USR_DESTINATION.$filename);  				//�ɮ��ݩ�
       		
  //��X 
   $sFile=addslashes(fread($sFP,$sFilesize));
   $sFile=base64_encode($sFile);
   
   fclose($sFP);
	
	//�ǻ������
	 $row['content']=$sFile;
	 $row['filetype']=$sFiletype;
}


//�p�ƥ[1
if ($_GET['act']=='Url_Click') {
  $id=intval($_GET['id']);  //���w������
  
  //���o�w�]�Ϥ��P����Ϥ�
  $sql="select url,url_click from jshow_pic where id='$id'";
  $res=$CONN->Execute($sql);
  $url_click=$res->fields['url_click'];
  $row=$res->fields['url'];   //�ǥX�� url
  
  $url_click+=1;
  
  $sql="update jshow_pic set url_click='$url_click' where id='$id'";
  $res=$CONN->Execute($sql); 
  
}



//�e�X
exit(json_encode($row));

//�N�}�C�s�X
function array_base64_encode($arr) {
  $B_arr=array();
  foreach ($arr as $k=>$v) {
    $B_arr[$k]=base64_encode(addslashes($v));
  }
  	return $B_arr;
}

