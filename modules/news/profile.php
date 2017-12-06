<?
  //$Id: profile.php 8694 2015-12-25 04:00:43Z qfon $
  include "config.php";
  
  $msg_id = intval($_GET['msg_id']) ;
  
  $tsqlstr =  " SELECT * FROM $tbname where msg_id = $msg_id " ; 
  $result = $CONN->Execute( $tsqlstr) ;   
  if($result) {
  	$nb= $result->FetchRow()   ;	
  	$subject = $nb[msg_subject] ;
  	$msg_date= $nb[msg_date] ;
  	$body= $nb[msg_body] ;
  	$attach = $nb[attach];
  	userdata($nb[userid]) ;		//取得發佈者資料
  }	
?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=big5">
	<title><? echo "第 $msg_id 號公告 ($subject)" ?> </title>
	</head>
	<body>
	<? echo "　$news_title  － 第 $msg_id 號公告" ?><br>
	【日　期】<? echo $msg_date . ' ' . $msg_time ?><br>
	【單　位】<? echo $group_name ?><br>
	【聯絡人】<? echo $user_name ?><br>
	【信　箱】<? echo $user_eamil ?><br>
	【主　旨】<? echo $subject ?><br>
	【內　容】<? echo disphtml($body); ?><br>
	<? if($attach) { echo "【附　件】" . disphtml($attach); } ?>
	</center>
	</body>
	</html>
<?


?>