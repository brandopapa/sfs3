<?php
//$Id: module-cfg.php 5519 2009-06-29 01:38:11Z brucelyc $

//---------------------------------------------------
//
// 1.這裡定義：模組資料表名稱 (供 "模組權限設定" 程式使用)
//   這區的 "變數名稱" 請勿改變!!!
//-----------------------------------------------
//
// 若有一個以上，請接續此 $MODULE_TABLE_NAME 陣列來定義
//
// 也可以用以下這種設法：
//
// $MODULE_TABLE_NAME=array(0=>"lunchtb", 1=>"xxxx");
// 
// $MODULE_TABLE_NAME[0] = "lunchtb";
// $MODULE_TABLE_NAME[1]="xxxx";
//
// 請注意要和 module.sql 中的 table 名稱一致!!!
//---------------------------------------------------

// 資料表名稱定義

$MODULE_TABLE_NAME[0] = "score_paper_bw";

//---------------------------------------------------
//
// 2.這裡定義：模組中文名稱，請精簡命名 (供 "模組權限設定" 程式使用)
//
// 它會顯示給使用者
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "自訂成績單_福智內部";


//---------------------------------------------------
//
// 3. 這裡定義：模組版本相關資訊 (供 "自動更新程式" 取用)
//    這區的 "變數名稱" 請勿改變!!!
//
//---------------------------------------------------

// 模組最後更新版本
$MODULE_UPDATE_VER="1.0.0";

// 模組最後更新日期
$MODULE_UPDATE="2003-12-02";

//重要模組，免被勿刪
$SYS_MODULE=1;

//---------------------------------------------------
//
// 4. 這裡請定義：您這支程式需要用到的：變數或常數
//---------------------------------^^^^^^^^^^
//
// (不想被 "模組參數管理" 控管者，請置放於此)
//
// 建議：請儘量用英文大寫來定義，最好要能由字面看出其代表的意義。
//
// 這區的 "變數名稱" 可以自由改變!!!
//
//---------------------------------------------------

//目錄內程式
$school_menu_p = array(
"input.php"=>"相關資料輸入",
"make_bw.php"=>"成績單製作",
"index.php"=>"自訂成績單",
"paper_upload.php"=>"管理上傳成績單",
"mark.php"=>"成績單標籤",
"stick.php"=>"成績貼條",
"faq.php"=>"問題集"
);
// 系統選項
$performance=array(1=>"平常行為表現",2=>"團體活動表現",3=>"公共服務",4=>"校外特殊表現");
$performance_option=array(1=>"表現優異",2=>"表現良好",3=>"表現尚可",4=>"需再加油",5=>"有待改進");

//九年一貫全部科目
$ss9[]="語文-本國語文";
$ss9[]="語文-鄉土語文";
$ss9[]="語文-英語";
$ss9[]="數學";
$ss9[]="健康與體育";
$ss9[]="生活";
$ss9[]="自然與生活科技";
$ss9[]="社會";
$ss9[]="藝術與人文";
$ss9[]="綜合活動";
//$ss9[]="彈性課程"; //正確為彈性學習時數, 若有成績應併入各學習領域, 故無此領域存在


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
			array('事假_成','7','11.9'),
			array('病假_成','7','11.9'),
			array('曠課_成','7','11.9'),
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
);
}
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
			array('表現分數',37.8,10.3),
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
			array('事假_成',7.6,11.5),
			array('病假_成',7.6,11.5),
			array('曠課_成',7.6,11.5),
			array('其他_成',7.6,11.5),
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
			array('事假_成',7.6,11.5),
			array('病假_成',7.6,11.5),
			array('曠課_成',7.6,11.5),
			array('其他_成',7.6,11.5),
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

//---------------------------------------------------
//
// 5. 這裡定義：預設值要由 "模組參數管理" 程式來控管者，
//    若不想，可不必設定。
//
// 格式： var 代表變數名稱
//       msg 代表顯示訊息
//       value 代表變數設定值
//
// 若您決定將這些變數交由 "模組參數管理" 來控管，那麼您的模組程式
// 就要對這些變數有感知，也就是說：若這些變數值在模組參數管理中改變，
// 您的模組就要針對這些變數有不同的動作反映。
//
// 例如：某留言板模組，提供每頁顯示筆數的控制，如下：
// $SFS_MODULE_SETUP[1] =
// array('var'=>"PAGENUM", 'msg'=>"每頁顯示筆數", 'value'=>10);
//
// 上述的意思是說：您定義了一個變數 PAGENUM，這個變數的預設值為 10
// PAGENUM 的中文名稱為 "每頁顯示筆數"，這個變數在安裝模組時會寫入
// pro_module 這個 table 中
//
// 我們有提供一個函式 get_module_setup
// 供您取用目前這個變數的最新狀況值，
//
// 使用法：
//
// $ret_array =& get_module_setup("module_makeer")
//
//
// 詳情請參考 include/sfs_core_module.php 中的說明。
//
// 這區的 "變數名稱 $SFS_MODULE_SETUP" 請勿改變!!!
//---------------------------------------------------


//$SFS_MODULE_SETUP[0] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>1);

// 第2,3,4....個，依此類推： 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
