<?php
//Id$

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
//sfs_check();

// �s�� SFS3 �����Y
//���n�ϥ� SFS3 �����Y
//head("�ڪ�������");

//
// �z���{���X�Ѧ��}�l
//�ӤH�������
$act=($_POST['act'])?$_POST['act']:$_GET['act'];
$nowpage=$_POST['nowpage'];
$search_str=($_POST['search_str'])?$_POST['search_str']:$_GET['search_str'];
$search_str=trim($search_str);
$bh_sn=($_POST['bh_sn'])?$_POST['bh_sn']:$_GET['bh_sn'];
$kind_sn=($_POST['kind_sn'])?$_POST['kind_sn']:$_GET['kind_sn'];
//echo $bh_sn.$act.$search_str;
if(!$bh_sn) header("Location:./index.php");
$sql="select * from blog_home where bh_sn='$bh_sn' and enable=1";
$rs=$CONN->Execute($sql) or trigger_error($sql,256);
$check=$rs->RecordCount( );
if(!$check) header("Location:./index.php");
$style=$rs->fields['style'];
$css=$style."/style.css";
$main=$rs->fields['main'];
$direction=nl2br($rs->fields['direction']);
$alias=$rs->fields['alias'];
$start=$rs->fields['start'];
$cover_image=$UPLOAD_URL."blog/cover/".$bh_sn.".jpg";
if(!file_exists($UPLOAD_PATH."blog/cover/".$bh_sn.".jpg")) $cover_image="./default_cover_image.jpg";

//�峹���
if($kind_sn) $where_kind=" and kind_sn='$kind_sn' ";
if($act=="search_myblog" and $search_str!="") $where_search=" and (title like '%$search_str%' or content like '%$search_str%' or content2 like '%$search_str%')";

$sql2="select * from blog_content where bh_sn='$bh_sn' and  enable=1 $where_kind  $where_search order by dater DESC";
//�]�w�C����ܴX������
$pen=10;
$PA=fpage($pen,$sql2);
$sql2=$PA[0];

$rs2=$CONN->Execute($sql2) or trigger_error($sql2,256);
$i=0;
while(!$rs2->EOF){
	$bc_sn[$i]=$rs2->fields['bc_sn'];
	//���o�^������
		$sql4="select count(*) from blog_feelback where bc_sn='{$bc_sn[$i]}' ";
		$rs4=$CONN->Execute($sql4) or trigger_error($sql4,256);
		$feel_time[$i]=$rs4->fields['0'];
	$kind_sn[$i]=$rs2->fields['kind_sn'];
	$sql="select kind_name from blog_kind where kind_sn='{$kind_sn[$i]}' and enable=1 ";
	$rs3=$CONN->Execute($sql) or trigger_error($sql,256);
	$kind_name[$i]=$rs3->fields['kind_name'];
	$title[$i]=$rs2->fields['title'];
	$content[$i]=nl2br($rs2->fields['content']);
	$dater[$i]=$rs2->fields['dater'];
	//$dater[$i]=strtotime($dater[$i]);
	$date[$i]=date("F d, Y, l" ,strtotime($dater[$i]));
	$time[$i]=date("g:i A",strtotime($dater[$i]));
	$freq[$i]=$rs2->fields['freq'];
	$a_list.="
		<table class='content_tb'>
			<tr><td><div class='tb1'>{$date[$i]}</div></td></tr>
			<tr><td><div class='title_fnt'>{$title[$i]}</div><div class='kind_fnt'>�����G{$kind_name[$i]}</div></td></tr>
			<tr><td><div class='content_fnt'>{$content[$i]}</div><a href='continue.php?bh_sn=$bh_sn&bc_sn={$bc_sn[$i]}'>����\Ū...</a></td></tr>
			<tr><td><div class='alias_fnt'>$alias {$time[$i]} �I�\����{$freq[$i]} <a href='continue.php?bh_sn=$bh_sn&bc_sn={$bc_sn[$i]}#reback'>�^��</a>{$feel_time[$i]}</div></td></tr>
		</table>
	";
	$i++;
	$rs2->MoveNext();
}

$my_blog="
<span class='button1'><a href='".$SFS_PATH_HTML."modules/sfs3_blog'>�n�J</a></span>
";


$search="
<form action='{$_SERVER[PHP_SELF]}' method='POST'>
<input type='text' name='search_str' size='12'> <input type='submit' name='' value='�d��'>
<input type='hidden' name='bh_sn' value='$bh_sn'>
<input type='hidden' name='act' value='search_myblog'>
</form>
";

//��X�峹�����P�峹��������
$sql5="select kind_sn,kind_name from blog_kind where enable=1 and bh_sn='$bh_sn' ";
$rs5=$CONN->Execute($sql5) or trigger_error($sql5,256);
$m=0;
while(!$rs5->EOF){
	$kind_sn=$rs5->fields['kind_sn'];
	$kind_name=$rs5->fields['kind_name'];
		$sql6="select count(*) from blog_content where kind_sn='$kind_sn' and enable=1";
		$rs6=$CONN->Execute($sql6) or trigger_error($sql6,256);
		$kind_num=$rs6->fields['0'];
	$kind_list.="<div class='kind_list_fnt'><font color='#CC0D0D'>&raquo;</font><a href='{$_SERVER['PHP_SELF']}?kind_sn=$kind_sn&bh_sn=$bh_sn'>$kind_name</a> ($kind_num �g)</div>";
	$m++;
	$rs5->MoveNext();
}

//�@�g���s�i�峹�C��
//�W��§��������
$lastweek =  mktime (0,0,0,date("m"),date("d")-7,  date("Y"));
$sql6="select * from blog_content where enable=1 and UNIX_TIMESTAMP(dater)>$lastweek and bh_sn='$bh_sn' order by dater DESC";
$rs6=$CONN->Execute($sql6) or trigger_error($sql6,256);
while(!$rs6->EOF){
	$nc_bc_sn=$rs6->fields['bc_sn'];
	$nc_title=$rs6->fields['title'];
	$nc_dater=date("Y/m/d" ,strtotime($rs6->fields['dater']));
	$new_content.="<div class='new_content_list_fnt'><font color='#CC0D0D'>&raquo;</font><a href='continue.php?bh_sn=$bh_sn&bc_sn=$nc_bc_sn'>$nc_title</a>$nc_dater</div>";
	$rs6->MoveNext();
}

//�@�g���s�i�^���C��
$bc_sn_str=implode(",",$bc_sn);
if($bc_sn_str=="") $bc_sn_str=0;
$sql7="select bc_sn,feel_date from blog_feelback where UNIX_TIMESTAMP(feel_date)>$lastweek and bc_sn in ($bc_sn_str) order by feel_date DESC";
$rs7=$CONN->Execute($sql7) or trigger_error($sql7,256);
while(!$rs7->EOF){
	$nf_bc_sn=$rs7->fields['bc_sn'];
	$nf_feel_date=date("Y/m/d" ,strtotime($rs7->fields['feel_date']));
	$sql8="select title from blog_content where enable=1 and bc_sn='$nf_bc_sn' ";
	$rs8=$CONN->Execute($sql8) or trigger_error($sql8,256);
	$nf_title=$rs8->fields['title'];
	$new_feel.="<div class='new_content_list_fnt'><font color='#CC0D0D'>&raquo;</font><a href='continue.php?bh_sn=$bh_sn&bc_sn=$nf_bc_sn'>RE:$nf_title</a>$nf_feel_date</div>";
	$rs7->MoveNext();
}


$main="
<html>
	<head>
		<title>�ڪ��ն�Blog</title><meta http-equiv='Content-Type' content='text/html; charset=big5'>
		<link rel=stylesheet href='themes/$css' type='text/css'>
	</head>
		<body><p>
			<table class='main_tb'>
				<tr><td colspan='2'><table  class='second_tb'><tr><td class='td_second_left'><div  class='log_div'><a href='./'><img src='log4.gif' width='80' height='16' border='0'></a></div><div class='fnt2'>$main</div><div class='fnt3'>$direction</div></td><td  class='td_second_right'><a href='my_blog.php?bh_sn=$bh_sn'><img src='$cover_image' border='0' alt=''></a></td></tr></table></td></tr>
				<tr>
				<td  class='td_left'>
					$a_list
				</td>
				<td  class='td_right'>
					$PA[1] <p>
					<div class='fnt1'>��D�G$alias (Since:$start) </div><p>
					<div class='tb2'>�޲z�ڪ�Blog</div><p>$my_blog<p>
					<div class='tb2'>�峹�j�M</div><p>$search<p>
					<div class='tb2'>�峹����</div><p>$kind_list<p>
					<div class='tb2'>�s�i�峹</div><p>$new_content<p>
					<div class='tb2'>�s�i�^��</div><p>$new_feel<p>
				</td>
				</tr>
			</table>
";
echo $main;
// SFS3 ������
//foot();

function cmp($a,$b) {

      if ($a == $b) return 0;
      return ($a > $b) ? -1 : 1;

   }
function fpage($pen,$sql){
    global $nowpage,$bh_sn;
    //�`�@���X��
    $rs1 = @mysql_query($sql) or trigger_error($sql,256);
    $kk = mysql_num_rows($rs1) ;
    $d=$kk%$pen;
    if($d==0) $pagenum=$kk/$pen;
    else $pagenum=ceil($kk/$pen);

    //�ثe���ĴX��
    if($nowpage=="") $nowpage=1;
    $start=($nowpage-1)*$pen;

    $limit_str=" limit $start , $pen";
    $end_sql=$sql.$limit_str;
    $pageArr[0]=$end_sql;

    $menu.="<form action='{$_SERVER['PHP_SELF']}' method='POST'><select name='nowpage' onchange='this.form.submit()'>\n";
    for($i=1;$i<=$pagenum;$i++){
        if($i==$nowpage) $selected[$i]="selected";
        $menu.="<option value='$i' $selected[$i]>�� $i ��</option>\n";
    }
    $menu.="
	</select>
	<input type='hidden' name='bh_sn' value='$bh_sn'>
	</form>\n";
    $pageArr[1]=$menu;

    //�Ǧ^�]�tlimit��sql�y�k�٦�������
    return $pageArr;
}
?>
