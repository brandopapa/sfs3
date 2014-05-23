<?php
                                                                                                                             
// $Id: config_calendar.php 5310 2009-01-10 07:57:56Z hami $

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";

//�p��G����ۮt���Ѽ�
function daydiff($day1,$day2){//$day1,2��00000000�榡
	//$day1= substr($day1,0,8);
	$day1=strtotime($day1);
	$day2=strtotime($day2);
	return (($day2-$day1)/(24*60*60));
}
//���o�P��
function get_week($selectday=""){//$selectday��00000000�榡
	if ($selectday=="")
		$selectday=getdate();
	else{
		$y=substr($selectday,0,4);
		$m=substr($selectday,4,2);
		$d=substr($selectday,6,2);
		$selectday=mktime(0,0,0,$m,$d,$y);
	}
	$selectday=getdate("$selectday");

	return $selectday["wday"];
}
//���o�P��(��)
function get_c_week($selectday=""){//$selectday��00000000�榡
	if ($selectday=="")
		$selectday=getdate();
	else{
		$y=substr($selectday,0,4);
		$m=substr($selectday,4,2);
		$d=substr($selectday,6,2);
		$selectday=mktime(0,0,0,$m,$d,$y);
	}
	$selectday=getdate("$selectday");
	switch ($selectday["wday"]){
		case '0':
			$week="��";
			break;
		case '1':
			$week="�@";
			break;
		case '2':
			$week="�G";
			break;
		case '3':
			$week="�T";
			break;
		case '4':
			$week="�|";
			break;
		case '5':
			$week="��";
			break;
		case '6':
			$week="��";
			break;
		default:
			$week="???";
	}
	return $week;
}


//������O�_�ŦX�X�{��h
//�ѼơG�g���_�l,�g������,�X�{�~,�X�{��,�X�{��,�X�{�P��,����,����
function check_date($restart_day,$restart_end,$sele_year,$sele_month,$sele_day,$sele_week,$test_day,$kind=""){

   $sele_time=$sele_year.sprintf("%02d",$sele_month).sprintf("%02d",$sele_day);

   //���`���B���ŦX�X�{���
   if ($kind=='0' and $sele_time!=$test_day) return false;

   $restart_day=substr($restart_day,0,4).substr($restart_day,5,2).substr($restart_day,8,2);
   $restart_end=substr($restart_end,0,4).substr($restart_end,5,2).substr($restart_end,8,2);

   //�ˬd�O�_�ŦX�X�{���

   if ($sele_time==$test_day)
      return true;

   //�ˬd�O�_�b�`���~

   if ($restart_day!="0000-00-00"){
      if (daydiff($restart_day,$test_day)< 0) return false;
   }

   if ($restart_end!="0000-00-00"){
      if (daydiff($test_day,$restart_end) < 0) return false;
   }

//   if ((daydiff($restart_day,$test_day)< 0 and $restart_day!="0000-00-00") or (daydiff($test_day,$restart_end)<0 and $restart_end!="0000-00-00"));
//      return false;

   //���`��
   switch($kind){
   
      case '0'://�C�g�u
           if ($test_day==$sele_time)
              return true;
           else
              return false;
           break;

      case 'w'://�C�g��
           if (get_week($test_day)==$sele_week)
              return true;
           else
              return false;
           break;
      case 'd'://�C��Ӥ��
           if (substr($test_day,6,2)==$sele_day)
              return true;
           else
              return false;
           break;
      case 'md'://�C�~�Ӥ�
           if (substr($test_day,4,2)==$sele_month and substr($test_day,6,2)==$sele_day)
              return true;
           else
              return false;
           break;
      default:
           echo false;
   }
}

?>
