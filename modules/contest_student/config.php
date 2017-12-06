<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z smallduh $

	//系統設定檔
	include_once "./module-cfg.php";
	include_once "../../include/config.php";
	// 公用函式
	include_once "../../include/sfs_case_PLlib.php";
	include_once "../../include/sfs_case_dataarray.php";
	include_once "../../include/sfs_oo_overlib.php";
	
	require_once "./module-upgrade.php";
	  

//上傳位置 , 記錄在 sfs3 的 config.php裡
// $UPLOAD_PATH 實體位置
// $UPLOAD_URL  URL位置
//
$UPLOAD_BASE=$UPLOAD_PATH."contest";

//最新消息 
$UPLOAD_NEWS_PATH=$UPLOAD_PATH."contest/news/"; 
$UPLOAD_NEWS_URL =$UPLOAD_URL."contest/news/";
//靜畫
$UPLOAD_PAINTING_PATH=$UPLOAD_PATH."contest/painting/";
$UPLOAD_PAINTING_URL =$UPLOAD_URL."contest/painting/";
//動畫
$UPLOAD_ANIMATION_PATH=$UPLOAD_PATH."contest/animation/";
$UPLOAD_ANIMATION_URL =$UPLOAD_URL."contest/animation/";
//簡報
$UPLOAD_IMPRESS_PATH=
$UPLOAD_PATH."contest/impress/";
$UPLOAD_IMPRESS_URL =$UPLOAD_URL."contest/impress/";

$UPLOAD_P=array('0'=>$UPLOAD_NEWS_PATH,'2'=>$UPLOAD_PAINTING_PATH,'3'=>$UPLOAD_ANIMATION_PATH,'4'=>$UPLOAD_IMPRESS_PATH);
$UPLOAD_U=array('0'=>$UPLOAD_NEWS_URL,'2'=>$UPLOAD_PAINTING_URL,'3'=>$UPLOAD_ANIMATION_URL,'4'=>$UPLOAD_IMPRESS_URL);

//競賽類別
$PHP_CONTEST=array('1'=>"查資料比賽",'2'=>"電腦繪圖-靜態",'3'=>"電腦繪圖-動畫",'4'=>"簡報製作");

//預設競賽說明 , 此為台中市100學年競賽規則說明
$PHP_MEMO[1]="1.答案正確且評審超連結至參賽者所填入之答案來源網址，可直接在該頁面上呈現正確答案者，該題評判為「答對」。\\n2.答案錯誤或來源網址錯誤，該題評判為「答錯」。 \\n3.答案來源網址屬於下列其一者，該題評判為「答錯」： \\n(1)使用論壇討論區、Yahoo知識+等問答網址者。 \\n(2)文件檔(例如DOC或PDF或PPT等等，因評審無法確知答案在該份文件的第幾頁) \\n(3)搜尋引擎的暫存頁面。 \\n4.評分時，以答對題數多少為成績，答對題數相同者，以作答題數較少者為優勝。";
$PHP_MEMO[2]=$PHP_MEMO[3]="所有作品應該由參賽者使用滑鼠或繪圖筆、板等設備，利用繪圖軟體之工具或功能親手繪製，不得使用現成圖片(含圖庫光碟、繪圖軟體所附百寶箱圖庫、利用掃描器或數位相機取得之圖片)，凡經評審發現或經檢舉使用現成圖片者，該作品取消參賽資格(已得獎者，取消名次，其他參賽者維持原公告成績，不再變更)。\\n1.靜態類作品以Gimp、Inkscape 等自由軟體或作業系統內建的繪圖軟體繪製，並以JPG或Png格式上傳至競賽主機。\\n2.靜態類作品像素大小以1024x768 pixel製作。\\n3.動畫類作品以swf或Gif等動畫格式上傳至競賽主機。\\n4.作品須同意創用CC授權(姓名標示─非商業性─相同方式分享)";
$PHP_MEMO[4]="競賽方式：\\n1.作品以openoffice-Impress製作，並以odp檔案格式上傳至競賽主機。\\n2.檔案大小限制於30MB以內，簡報總頁數不超過30頁。\\n3.請於作品開頭或結尾中加入創用CC授權標示。\\n4.使用軟體限競賽場地提供之軟體，不得自行安裝。\\n評分標準：\\n資料結構35％、內容25％、手法創意5％、色彩美觀5％、版面安排設計25％、創用CC運用5%。";

//預設評分細目 , 繪圖
$SCORE_PAINT=array('1'=>"主題性25%",'2'=>"原創性30%",'3'=>"美術技法15%",'4'=>"電腦技法30%");
//預設評分細目 , 簡報
$SCORE_IMPRESS=array('1'=>"資料結構35％",'2'=>"內容25％",'3'=>"手法創意5％",'4'=>"色彩美觀5％",'5'=>"版面安排設計25％",'6'=>"創用CC運用5%");

//變數轉換
$OPEN[0]="關閉";
$OPEN[1]="開啟";


//取得管理權設定值
$MANAGER=checkid($_SERVER['SCRIPT_FILENAME'],1);

//讀取環境變數 $ITEM[0],$ITEM[1].....
$M_SETUP=get_module_setup('contest_teacher');

$PHP_PAGE=$M_SETUP['page'];
$PHP_FILE_ATTR=$M_SETUP['upload_file_attr'];	  
	  

//載入本模組的專用函式庫
include_once ('../contest_teacher/include/myfunctions.php');
include_once ('../contest_teacher/include/itembank.inc.php');
include_once ('../contest_teacher/include/test.inc.php');
include_once ('../contest_teacher/include/judge.inc.php');

?>

