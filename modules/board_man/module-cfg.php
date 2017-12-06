<?php

//---------------------------------------------------
//
// 1.這裡定義：系統變數 (供 "模組安裝管理" 程式使用)
//------------------------------------------
//
// "模組安裝管理" 程式會寫入貴校的 SFS/pro_kind 表中
//
// 建議：請儘量用英文大寫來定義，最好能由字面看出其代表的意義。
//---------------------------------------------------


// 您這個模組的名稱，就是您這個模組放置在 SFS 中的目錄名稱

$MODULE_NAME = "board_man";


// 模組置放主要目錄：
// 可選擇的有 school 及 module

$MODULE_MAIN_DIR="school";


// 模組置放路徑：
// 請儘量使用變數代換，勿修改!

$MODULE_STORE_PATH  = "$MODULE_MAIN_DIR/$MODULE_NAME";



// 預設是否開啟使用?
$MODULE_PRO_ISLIVE = 1;

//---------------------------------------------------
//
// 2.這裡定義：模組資料表名稱 (供 "模組安裝管理" 程式使用)
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


//
// 3.這裡定義：模組中文名稱，請精簡命名 (供 "模組安裝管理" 程式使用)
//
// 它會顯示給使用者
//-----------------------------------------------


$MODULE_PRO_KIND_NAME = "校務佈告欄管理程式";


//---------------------------------------------------
//
// 4. 這裡定義：模組版本相關資訊 (供 "相關系統程式" 取用)
//
//---------------------------------------------------

// 模組版本
$MODULE_VER="2.0.1";

// 模組程式作者
$MODULE_AUTHOR="hami";

// 模組版權種類
$MODULE_LICENSE="";

// 模組外顯名稱(供 "模組設定" 程式使用)
$MODULE_DISPLAY_NAME="校務佈告欄管理程式";

// 模組隸屬群組
$MODULE_GROUP_NAME="校務行政";

// 模組開始日期
$MODULE_CREATE_DATE="2002-12-15";

// 模組最後更新日期
$MODULE_UPDATE="2003-04-06 08:30:00";

// 模組更新者
$MODULE_UPDATE_MAN="hami";


//---------------------------------------------------
//
// 5. 這裡請定義：您這支程式需要用到的：變數或常數
//------------------------------^^^^^^^^^^
//
// (不想被 "模組設定" 程式控管者，請置放於此)
//
// 建議：請儘量用英文大寫來定義，最好要能由字面看出其代表的意義。
//---------------------------------------------------



//---------------------------------------------------
//
// 6. 這裡定義：預設值要由 "模組設定" 程式來控管者，
//    若不想，可不必設定。
//
// 格式： var 代表變數名稱
//       msg 代表顯示訊息
//       value 代表變數設定值
//---------------------------------------------------


// 第2,3,4....個，依此類推： 

// $SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// $SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
