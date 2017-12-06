<?php
// $Id: module-upgrade.php 6204 2010-09-30 23:31:15Z infodaes $

if(!$CONN){
	echo "go away !!";
	exit;
}
set_time_limit(0);
// 檢查更新否
// 更新記錄檔路徑
$upgrade_path = "upgrade/".get_store_path();

$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2011-5-6.txt";
$isOk = false;
if (!is_file($up_file_name) or $_reUpgrade){
	if (isset($_POST['doit'])) {
		$query = "ALTER TABLE `grad_stud` ADD `student_sn` INT NOT NULL , ADD INDEX ( `student_sn` ) ";
		if ($CONN->Execute($query))
		$temp_str = "$query\n 更新成功 ! \n";
		else
		$temp_str = "$query\n 更新失敗 ! \n";


		$query = "select student_sn,stud_id from stud_base ";
		$res = $CONN->Execute($query);

		$year = 100;  // 100學年前的資料
		while(!$res->EOF){
			$query = "update grad_stud  set  student_sn=".$res->fields[0]." where stud_id='".$res->fields[1]."' and stud_grad_year <= ".$year;
			$CONN->Execute($query) or trigger_error("SQL 語法錯誤<BR>$query", E_USER_ERROR);
			$res->MoveNext();
		}


		$temp_query = "新增 student_sn 欄位 -- by hami (2011-05-06)\n\n$temp_str";
		$fp = fopen ($up_file_name, "w");
		fwrite($fp,$temp_query);
		fclose ($fp);
		?>
	<script>
	alert('已升級完成!');	
	</script>
		<?php 
	}
	else {
		head();
	?>
	<div style="margin:20px; padding:10px">
	<h2>系統新增了欄位, 需一些時間才能完成升級動作,未升級完成時, 勿離開本頁</h2>
		<form method="post" action="" id="upgradForm">
		
		<input type="submit" name="doit" value="我了解, 開始升級" />
		</form>	
	</div>
	<?php 
		foot();
		exit;
	}
}
