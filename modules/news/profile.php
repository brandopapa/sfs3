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
  	userdata($nb[userid]) ;		//���o�o�G�̸��
  }	
?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=big5">
	<title><? echo "�� $msg_id �����i ($subject)" ?> </title>
	</head>
	<body>
	<? echo "�@$news_title  �� �� $msg_id �����i" ?><br>
	�i��@���j<? echo $msg_date . ' ' . $msg_time ?><br>
	�i��@��j<? echo $group_name ?><br>
	�i�p���H�j<? echo $user_name ?><br>
	�i�H�@�c�j<? echo $user_eamil ?><br>
	�i�D�@���j<? echo $subject ?><br>
	�i���@�e�j<? echo disphtml($body); ?><br>
	<? if($attach) { echo "�i���@��j" . disphtml($attach); } ?>
	</center>
	</body>
	</html>
<?


?>