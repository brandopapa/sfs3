<?php
		$fileCount = count($_FILES);
		if ($fileCount > 0){
			//�W���ɮ�
			//$file_path = "$USR_DESTINATION/$b_id";
				$tt = time();
			for($i=1 ; $i<=$fileCount; $i++){
				if ($_FILES["resourceFile_$i"]['name']=='')
					continue;
				if (!check_is_php_file($_FILES["resourceFile_$i"]['name'])){
					//if (!is_dir($file_path))	mkdir($file_path,0700);
					//copy($_FILES["resourceFile_$i"]['tmp_name'],$file_path."/".$tt.'_'.$i.'-'.$_FILES["resourceFile_$i"]['name']);
					$org_filename=$_FILES["resourceFile_$i"]['name'];
		      //������ɦW
      		$expand_name=explode(".",$org_filename);
      		$nn=count($expand_name)-1;  //���̫�@�ӷ���ɦW
      		$ATTR=strtolower($expand_name[$nn]); //��p�g���ɦW
					$new_filename=$tt."_".$i."-".date("Y_m_d");
					//copy($_FILES["resourceFile_$i"]['tmp_name'],$file_path."/".$tt.'_'.$i.'-'.$_FILES["resourceFile_$i"]['name']);
				  //copy($_FILES["resourceFile_$i"]['tmp_name'],$file_path."/".$new_filename);
				  //�x�s���ɸ�T
       		$sFP=fopen($_FILES["resourceFile_$i"]['tmp_name'],"r");				//���J�ɮ�
       		$sFilesize=filesize($_FILES["resourceFile_$i"]['tmp_name']); 	//�ɮפj�p       		
       		if ($sFilesize>$Max_upload*1024*1024) {
       	   continue;
       	  }else{
       		$sFiletype=$_FILES["resourceFile_$i"]['type'];  							//�ɮ��ݩ�
       		
       		//��X , ���ɮפ��e�s�J
       		$sFile=addslashes(fread($sFP,filesize($_FILES["resourceFile_$i"]['tmp_name'])));
       		$sFile=base64_encode($sFile);
				  
				  $query="insert into jboard_files (b_id,org_filename,new_filename,filesize,filetype,content) values ('$b_id','$org_filename','$new_filename','$sFilesize','$sFiletype','$sFile')";
				  $CONN->Execute($query) or die ($query);				  
				  }
				}
			}
		}

?>