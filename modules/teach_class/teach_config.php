<?php
	// $Id: teach_config.php 8495 2015-08-21 09:28:00Z smallduh $
	//系統設定檔
	include_once "../../include/config.php";
	//函式庫
	include_once "../../include/sfs_case_PLlib.php";
	
	include_once "../../include/sfs_case_dataarray.php";
	//新增按鈕名稱
	$newBtn = " 新增資料 ";
	//修改按鈕名稱
	$editBtn = " 確定修改 ";
	//刪除按鈕名稱
	$delBtn = " 確定刪除 ";
	//確定新增按鈕名稱
	$postBtn = " 確定新增 ";
	//新增時啟用流水號功能
	$is_IDauto = 1 ; // 0 為取消	

	//搜尋代號
	$srchID = " 搜尋代號 ";
	//搜尋姓名
	$srchName = " 搜尋姓名 ";

	
	//左選單設定顯示筆數
	$gridRow_num = 16;
	//左選單底色設定
	$gridBgcolor="#DDDDDC";
	//左選單男生顯示顏色
	$gridBoy_color = "blue";
	//左選單女生顯示顏色
	$gridGirl_color = "#FF6633";
	//照片寬度
	$img_width = 120;	
	
	//目錄內程式
	$teach_menu_p = array("teach_list.php"=>"基本資料","teach_post.php"=>"任職資料","teach_connect.php"=>"網路資料","mteacher.php"=>"匯入教師資料","teach_list_photo.php"=>"在職教師一覽表","teach_list_subject.php"=>"任教一覽表");
	
	//設定上傳圖片路徑
	$img_path = "photo/teacher";
	
	/* 上傳檔案暫存目錄 */
	$path_str = "temp/teacher";
	set_upload_path($path_str);
	$temp_path = $UPLOAD_PATH.$path_str;
	
  //取得模組設定
  $m_arr = get_sfs_module_set();
  extract($m_arr, EXTR_OVERWRITE);
  

	//取得流水號
	function get_sfs_id() {
		global $DEFAULT_TEA_ID_TITLE, $DEFAULT_TEA_ID_NUMS,$CONN;
		$sqlstr = "select max(teach_id) as mm from teacher_base ";
		if ($DEFAULT_TEA_ID_TITLE)
			$sqlstr .= " where teach_id like '$DEFAULT_TEA_ID_TITLE%'";
		$result = $CONN->Execute($sqlstr) or die ($sqlstr);
		
		$num = 1;
		for ($i=0;$i<strlen($DEFAULT_TEA_ID_NUMS);$i++)
			$num *= 10;
		
		if ($result->fields[0] == '' ) {//第一筆			
			$temp = $num+ intval($DEFAULT_TEA_ID_NUMS);
		}
		else {
			$temp = substr($result->fields[0],strlen($DEFAULT_TEA_ID_TITLE));
			$temp = $num + intval($temp)+1;		
		}
		$temp =  $DEFAULT_TEA_ID_TITLE.substr($temp,1);	
		return $temp;	
	}


	
?>
