<?php

// $Id: stud_move_config.php 6566 2011-10-06 02:26:37Z infodaes $

	//系統設定檔
	include "../../include/config.php";
	//函式庫
	include "../../include/sfs_case_PLlib.php";    
	//檢查更新指令
	include_once "module-upgrade.php";
	//新增按鈕名稱
	$newBtn = " 新增資料 ";
	//修改按鈕名稱
	$editBtn = " 確定修改 ";
	//刪除按鈕名稱
	$delBtn = " 確定刪除 ";
	//確定新增按鈕名稱
	$postMoveBtn = " 確定異動 ";
	$postInBtn = " 確定轉入 ";
	$postOutBtn = " 確定轉出 ";
	$postReinBtn = " 確定復學 ";
	$postHome = " 確定在家自學 ";
	$editModeBtn = " 修改模式 ";
	$browseModeBtn = " 瀏覽模式 ";	
	//預設國籍
	$default_country = "中華民國";
	//左選單設定顯示筆數
	$gridRow_num = 16;
	//左選單底色設定
	$gridBgcolor="#DDDDDC";
	//左選單男生顯示顏色
	$gridBoy_color = "blue";
	//左選單女生顯示顏色
	$gridGirl_color = "#FF6633";
	//預設第一個開啟班級 
	$default_begin_class = "601";	
	//調出類別
	$out_arr=array("7"=>"出國","8"=>"調校","11"=>"死亡","12"=>"中輟");
	//復學選擇類別
	$out_in_arr=array("7"=>"出國","8"=>"調校","12"=>"中輟");
	//升降級
	$demote_arr=array("9"=>"升級","10"=>"降級");
	//復學類別
	$rein_arr=array("3"=>"中輟復學","14"=>"轉學復學");
	//目錄內程式
	$student_menu_p = array("stud_move.php"=>"轉入","stud_move_out.php"=>"調出","stud_move_rein.php"=>"復學","stud_move_home.php"=>"在家自學","stud_demote.php"=>"升降級","stud_move_gradu.php"=>"畢業轉出","stud_move_new.php"=>"新生入學","stud_move_list2.php"=>"異動記錄列表","stud_move_print.php"=>"異動報表","stud_move_cal.php"=>"異動統計表","../stud_reg/"=>"學籍管理","stud_move_chiedit.php"=>"編修作業");
	
?>
