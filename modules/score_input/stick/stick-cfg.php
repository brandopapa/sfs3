<?php
//$Id: stick-cfg.php 5518 2009-06-29 01:37:30Z brucelyc $
//預設的引入檔，不可移除。
require_once "./module-cfg.php";
require_once "stick/function.php";
include_once "../../include/config.php";
//您可以自己加入引入檔
include_once "../../include/sfs_case_subjectscore.php";
include_once "../../include/sfs_case_studclass.php";
include_once "../../include/sfs_case_score.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_oo_zip.php";
include_once "../../include/sfs_case_PLlib.php";

// 系統選項
$performance=array(1=>"日常行為表現",2=>"公共服務",3=>"團體活動表現",4=>"校外特殊表現");
$performance_option=array(1=>"表現優異",2=>"表現良好",3=>"表現尚可",4=>"需再加油",5=>"有待改進");

//九年一貫全部科目
$ss9[]="語文-本國語文";
$ss9[]="語文-鄉土語文";
$ss9[]="語文-英語";
$ss9[]="健康與體育";
$ss9[]="生活";
$ss9[]="數學";
$ss9[]="綜合活動";
$ss9[]="彈性課程";
$ss9[]="社會";
$ss9[]="藝術與人文";
$ss9[]="自然與生活科技";


//台南縣
$tnc_arr=array(
			array('表現分數','7','11.9'),
			array('表現等第','7.1','11.9'),
			array('九_語文-本國語文分數','7','11.9'),
			array('九_語文-鄉土語文分數','7','11.9'),
			array('九_語文-英語分數','7','11.9'),
			array('九_語文平均','7','11.9'),
			array('九_語文等第','7.1','11.9'),
			array('九_健康與體育分數','7','11.9'),
			array('九_健康與體育等第','7.1','11.9'),
			array('九_數學分數','7','11.9'),
			array('九_數學等第','7.1','11.9'),
			array('九_社會分數','7','11.9'),
			array('九_社會等第','7.1','11.9'),
			array('九_藝術與人文分數','7','11.9'),
			array('九_藝術與人文等第','7.1','11.9'),
			array('九_自然與生活科技分數','7','11.9'),
			array('九_自然與生活科技等第','7.1','11.9'),
			array('九_綜合活動分數','7','11.9'),
			array('九_綜合活動等第','7.1','11.9'),
			array('上課日數','7.1','11.9'),
			array('事假','7','11.9'),
			array('病假','7','11.9'),
			array('曠課','7','11.9'),
			array('缺席總日數','7.1','11.9'),
			array('導師評語及建議','3.8','11.9'),
);

//彰化縣
if($_REQUEST['cols']=="chc_1"){
$chc_arr=array(
			array('九_語文-本國語文分數',6.25,10.3),
			array('九_語文-鄉土語文分數',6.25,10.3),
			array('無',6.25,10.3),
			array('九_健康與體育分數',6.25,10.3),
			array('九_數學分數',6.25,10.3),
			array('九_生活分數',19,10.3),
			array('九_綜合活動分數',6.25,10.3),
			array('表現分數',37.8,10.3),
			array('上課日數',6.25,10.3),
			array('事假_成',6.25,10.3),
			array('病假_成',6.25,10.3),
			array('曠課_成',6.25,10.3),
			array('缺席總日數',6.25,10.3),
			array('導師評語及建議',6.2,10.3)
);}
//彰化縣
if($_REQUEST['cols']=="chc_2"){
$chc_arr=array(
			array('九_語文-本國語文分數',6.25,10.3),
			array('九_語文-鄉土語文分數',6.25,10.3),
			array('九_語文-英語分數',6.25,10.3),
			array('九_健康與體育分數',6.25,10.3),
			array('九_數學分數',6.25,10.3),
			array('九_社會分數',6.25,10.3),
			array('九_自然與生活科技分數',6.25,10.3),
			array('九_藝術與人文分數',6.25,10.3),
			array('九_綜合活動分數',6.25,10.3),
			array('表現分數',37.2,10.3),
			array('上課日數',6.25,10.3),
			array('事假_成',6.25,10.3),
			array('病假_成',6.25,10.3),
			array('曠課_成',6.25,10.3),
			array('缺席總日數',6.25,10.3),
			array('導師評語及建議',6.2,10.3)
);
}
//台中市
if($_REQUEST['cols']=="tc_1")
$tc_arr=array(
			array('九_語文-本國語文分數',7.0,11.5),
			array('九_語文-鄉土語文分數',7.2,11.5),
			array('九_語文-英語分數',7.2,11.5),
			array('九_語文平均',7.2,11.5),
			array('九_數學分數',7.3,11.5),
			array('九_生活分數',21.6,11.5),
			array('九_健康與體育分數',7.2,11.5),
			array('九_綜合活動分數',7.2,11.5),
			array('學期學習領域成績',15,11.5),
			array('表現分數',7.5,11.5),
			array('其他-1',7.5,11.5),
			array('其他-2',7.5,11.5),
			array('其他-3',7.5,11.5),
			array('上課日數',7.6,11.5),
			array('事假',7.6,11.5),
			array('病假',7.6,11.5),
			array('曠課',7.6,11.5),
			array('其他',7.6,11.5),
);
if($_REQUEST['cols']=="tc_2")
$tc_arr=array(
			array('九_語文-本國語文分數',7.0,11.5),
			array('九_語文-鄉土語文分數',7.2,11.5),
			array('九_語文-英語分數',7.2,11.5),
			array('九_語文平均',7.2,11.5),
			array('九_數學分數',7.3,11.5),
			array('九_社會分數',7.2,11.5),
			array('九_自然與生活科技分數',7.2,11.5),
			array('九_藝術與人文分數',7.2,11.5),
			array('九_健康與體育分數',7.2,11.5),
			array('九_綜合活動分數',7.2,11.5),
			array('學期學習領域成績',15,11.5),
			array('表現分數',7.5,11.5),
			array('其他-1',7.5,11.5),
			array('其他-2',7.5,11.5),
			array('其他-3',7.5,11.5),
			array('上課日數',7.6,11.5),
			array('事假',7.6,11.5),
			array('病假',7.6,11.5),
			array('曠課',7.6,11.5),
			array('其他',7.6,11.5),
);

//澎湖縣_低
if($_REQUEST['cols']=="phc_1")
$phc_arr=array(
			array('表現分數',8.0,12.0),
			array('表現等第',8.1,12.0),
			array('九_語文-本國語文分數',8.2,12.0),
			array('九_語文-英語分數',8.2,12.0),
			array('九_語文-鄉土語文分數',8.4,12.0),
			array('九_語文平均',8.4,12.0),
			array('九_健康與體育分數',8.4,12.0),
			array('九_數學分數',8.2,12.0),
			array('九_生活分數',24.6,12.0),
			array('九_綜合活動分數',8.2,12.0),
			array('學期學習領域成績',8.2,12.0),
			array('學期學習領域等第',8.2,12.0),
			array('上課日數',8.2,12.0),
			array('事假',8.2,12.0),
			array('病假',8.2,12.0),
			array('曠課',8.2,12.0),
			array('缺席總日數',8.2,12.0),

);

//澎湖縣_中高
if($_REQUEST['cols']=="phc_2")
$phc_arr=array(
			array('表現分數',8.0,12.0),
			array('表現等第',8.1,12.0),
			array('九_語文-本國語文分數',8.2,12.0),
			array('九_語文-英語分數',8.2,12.0),
			array('九_語文-鄉土語文分數',8.4,12.0),
			array('九_語文平均',8.4,12.0),
			array('九_健康與體育分數',8.4,12.0),
			array('九_數學分數',8.2,12.0),
			array('九_社會分數',8.2,12.0),
			array('九_藝術與人文分數',8.2,12.0),
			array('九_自然與生活科技分數',8.2,12.0),
			array('九_綜合活動分數',8.2,12.0),
			array('學期學習領域成績',8.2,12.0),
			array('學期學習領域等第',8.2,12.0),
			array('上課日數',8.2,12.0),
			array('事假',8.2,12.0),
			array('病假',8.2,12.0),
			array('曠課',8.2,12.0),
			array('缺席總日數',8.2,12.0),

);

if($_REQUEST['cols']=="cyc_1")
$cyc_arr=array(
        array('九_語文-本國語文分數',5.6,11),
        array('九_語文-英語分數',5.6,11),
        array('九_語文-鄉土語文分數',5.6,11),
        array('九_語文-平均',5.6,11),
        array('九_語文-等第',5.6,11),
        array('九_數學分數',5.6,11),
        array('九_數學等第',5.6,11),
        array('九_生活分數',16.9,11),
        array('九_生活等第',16.9,11),
        array('九_健康與體育分數',5.6,11),
        array('九_健康與體育等第',5.6,11),
        array('九_綜合活動分數',5.6,11),
        array('九_綜合活動等第',5.6,11),
        array('彈性課程-分數',5.6,11),
        array('彈性課程-等第',5.6,11),
        array('彈性課程二-分數',5.6,11),
        array('彈性課程二-等第',5.6,11),
        array('彈性課程三-分數',5.6,11),
        array('彈性課程三-等第',5.6,11),
        array('彈性課程四-分數',5.6,11),
        array('彈性課程四-等第',5.6,11),
        array('學習領域成績分數',5.6,11),
        array('學習領域成績等第',5.6,11),
);

if($_REQUEST['cols']=="cyc_2")
$cyc_arr=array(
        array('九_語文-本國語文分數',5.6,11),
        array('九_語文-英語分數',5.6,11),
        array('九_語文-鄉土語文分數',5.6,11),
        array('九_語文-平均',5.6,11),
        array('九_語文-等第',5.6,11),
        array('九_數學分數',5.6,11),
        array('九_數學等第',5.6,11),
        array('九_自然與生活科技分數',5.6,11),
        array('九_自然與生活科技等第',5.6,11),
        array('九_藝術與人文分數',5.6,11),
        array('九_藝術與人文等第',5.6,11),
        array('九_社會分數',5.6,11),
        array('九_社會等第',5.6,11),
        array('九_健康與體育分數',5.6,11),
        array('九_健康與體育等第',5.6,11),
        array('九_綜合活動分數',5.6,11),
        array('九_綜合活動等第',5.6,11),
        array('彈性課程-分數',5.6,11),
        array('彈性課程-等第',5.6,11),
        array('彈性課程二-分數',5.6,11),
        array('彈性課程二-等第',5.6,11),
        array('彈性課程三-分數',5.6,11),
        array('彈性課程三-等第',5.6,11),
        array('彈性課程四-分數',5.6,11),
        array('彈性課程四-等第',5.6,11),
        array('學習領域成績分數',5.6,11),
        array('學習領域成績等第',5.6,11),
);

if($_REQUEST['cols']=="cyc_3")
$cyc_arr=array(
        array('九_語文-本國語文分數',6.5,10),
        array('九_語文-英語分數',6.5,10),
        array('九_語文-鄉土語文分數',6.5,10),
        array('九_語文-平均',6.5,10),
        array('九_語文-等第',6.5,10),
        array('九_數學分數',6.5,10),
        array('九_數學等第',6.5,10),
        array('九_自然與生活科技分數',6.5,10),
        array('九_自然與生活科技等第',6.5,10),
        array('九_藝術與人文分數',6.5,10),
        array('九_藝術與人文等第',6.5,10),
        array('九_社會分數',6.5,10),
        array('九_社會等第',6.5,10),
        array('九_健康與體育分數',6.5,10),
        array('九_健康與體育等第',6.5,10),
        array('九_綜合活動分數',6.5,10),
        array('九_綜合活動等第',6.5,10),
        array('彈性課程-分數',6.5,10),
        array('彈性課程-等第',6.5,10),
        array('彈性課程二-分數',6.5,10),
        array('彈性課程二-等第',6.5,10),
        array('學習領域成績分數',6.5,10),
        array('學習領域成績等第',6.5,10),
        array('生活表現分數',6.5,10),
        array('生活表現等第',6.5,10),
        array('應出席日數',6.5,10),
        array('事假_成',6.5,10),
        array('病假_成',6.5,10),
        array('曠課_成',6.5,10),
);
?>
