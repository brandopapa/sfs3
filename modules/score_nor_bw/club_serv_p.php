<?php 
//$Id: ps_9401.php 7078 2013-01-16 07:27:26Z smallduh $

require_once("config.php");
include_once "../../include/sfs_case_score.php";
include_once "../../include/sfs_case_dataarray.php";

require_once ("../score_chart/chc_class2.php");

//���g����
$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");

//�v�ɤ���
$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ�',5=>'�����ϡ]�m��^',6=>'�դ�');
$squad_array=array(1=>'�ӤH��',2=>'������');

sfs_check();

//Ū���Ҳ��ܼ�
$M_SETUP=get_module_setup('score_nor');

$default_title=$_POST['default_title'];

//2012/12/7 by smalldh �[�J���λP�A�Ⱦǲ߰O��
$stud_service=$_POST['stud_service'];						//�O�_�C�L�A�Ⱦǲ�
$stud_club=$_POST['stud_club'];									//�O�_�C�L����
$stud_club_score=$_POST['stud_club_score'];			//�O�_�C�L���Φ��Z
$stud_chk_data=$_POST['stud_chk_data']; 				//�O�_�C�L���`�ͬ���{
$stud_chk_data_detail=$_POST['stud_chk_data_detail']; 				//�O�_�C�L���`�ͬ��ˮ֪�
$stud_reward=$_POST['stud_reward']; 						//�O�_�C�L���g
$stud_reward_detail=$_POST['stud_reward_detail']; 						//�O�_�C�L���g����

$stud_leader=$_POST['stud_leader']; 						//�O�_�C�L�F�����
$stud_race=$_POST['stud_race']; 								//�O�_�C�L�v�ɸ��
$stud_absent=$_POST['stud_absent']; 						//�O�_�C�L�X�ʮu
$stud_absent_detail=$_POST['stud_absent_detail']; 						//�O�_�C�L�X�ʮu����

$default_txt=$_POST['default_txt'];							//���Z����Ѥ�r

//////  �qSFS3���ت��禡���Ǯո�ƨ禡---------------------
$sch_data=get_school_base();

$img_title=get_title_pic();//Ū��¾�ٹϳ�

if($_POST){
	
	$year_seme=split("_",$_POST[year_seme]);//093_1	
	$sel_year=$year_seme[0]; $sel_seme=$year_seme[1];  //���o�Ǧ~�ξǴ�
  $seme_year_seme=sprintf('%03d%1d',$year_seme[0],$year_seme[1]); //1011 ,1001 ,0991 .....�榡

	//�ǮզW��, �D���ήժ���¾��
	$smarty->assign("school_name",$sch_data[sch_cname]);
	$smarty->assign("img_1",$img_title["�ժ�"]);
	$img_3=($img_title["�ǰȥD��"]=="")?$img_title["�V�ɥD��"]:$img_title["�ǰȥD��"];
	$smarty->assign("img_3",$img_3);
	
  $query="select title_name from teacher_title where teach_title_id=3";
  list($sign_3_title)=mysql_fetch_row(mysql_query($query));
	
	$smarty->assign("sign_3_title",$sign_3_title);


	$class_ary=get_class_info($_POST[grade],$_POST[year_seme]);
	

  //�ǰe�U�ؤĿ�C�L������
  $smarty->assign("default_title",$default_title);
	$smarty->assign("IS_JHORES",$IS_JHORES);
  
  $smarty->assign("stud_service",$stud_service);  			// �O�_�C�L�A�Ⱦǲ߸��
  $smarty->assign("stud_club",$stud_club);  						// �O�_�C�L���θ��
  $smarty->assign("stud_club_score",$stud_club_score);  // �O�_�]�t���Φ��Z
  $smarty->assign("stud_chk_data",$stud_chk_data);  		// �O�_�C�L���`�ͬ��ˮ�
  $smarty->assign("stud_reward",$stud_reward);  				// �O�_�C�L���g���
 	$smarty->assign("stud_reward_detail",$stud_reward_detail);				// �O�_�C�L���g����
 	$smarty->assign("stud_absent",$stud_absent);  				// �O�_�C�L�X�ʮu���
 	$smarty->assign("stud_absent_detail",$stud_absent_detail);  				// �O�_�C�L�X�ʮu��Ʃ���
	$smarty->assign("stud_race",$stud_race);  						// �O�_�C�L�v�ɸ��
	$smarty->assign("stud_leader",$stud_leader);  				// �O�_�C�L�F�����


			//�p��Ǵ��_����
			//�_�l��
 			$sql="select day from school_day where year='$sel_year' and seme='$sel_seme' and day_kind='start'";
  		$res=$CONN->Execute($sql) or die("SQL���~:$sql");
 			$seme_start_date=$res->fields[0];
 
 			//������
 			$sql="select day from school_day where year='$sel_year' and seme='$sel_seme' and day_kind='end'";
 			$res=$CONN->Execute($sql) or die("SQL���~:$sql");
 			$seme_end_date=$res->fields[0];
 			
 $smarty->assign("seme_start_date",$seme_start_date);  	//�Ǵ��_�l��
 $smarty->assign("seme_end_date",$seme_end_date); 			//�Ǵ�������

 //���`��{ , �ˮ֪���
	$itemdata=get_chk_item($sel_year,$sel_seme);


	//�}�l
	
	$page_i=0;  //�p��, �w�C�L�F�X��, �ĤG����@�}�l���n�e����
	
 foreach ($_POST[class_id] as $class_id_key=>$null) {
 	
 	//�̯Z�Ť��P, �ǤJ�Z�žǦ~�׸��
	$smarty->assign("class_info",$class_ary[$class_id_key]);//�Z�žǦ~�׸��

  //���o�ӯZ�Ū����
	$class_data = new data_class($class_id_key,$disable_subject_memo_title);
	
  $class=class_id_2_old($class_id_key);


  //echo "<pre>";
	//print_r($seme_scope);


  //=====================================================================================
 	foreach ($class_data->stud_base as $student_sn=>$stud) {  
 
		if($page_i>0){
			$smarty->assign("break_page","<P STYLE='page-break-before: always;'>");
		}else {
			$smarty->assign("break_page","");
		}
		
		//�v�ɰO�� ���ҮѤ���P�w�Ǵ� ==============================================================================
		if ($stud_race=='checked') {

		  $RACE=get_race_record($seme_start_date,$seme_end_date,$student_sn);
		  
		  $race_print="
		   	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;font-size:10pt' bordercolor='#111111' width='100%'>
  				<tr align='center' bgcolor='#AAAAAA'>
						<td width='15'>NO.</td>
						<td width='120' colspan='2'>�d��ʽ�</td><td>�v�ɦW��</td><td>�o���W��</td><td>�ҮѤ��</td><td>�D����</td><td>�r��</td><td>�Ƶ�</td>
				</tr>";
			$i=0;
			if (count($RACE)>0) {
			foreach ($RACE as $sn=>$race) {
	    $i++;
	    $race_print.="
	    <tr>
					<td>".$i."</td>
					<td>".$level_array[$race['level']]."</td>
					<td>".$squad_array[$race['squad']]."</td>
					<td align='left'>".$race['name']."</td>
					<td>".$race['rank']."</td>
					<td>".$race['certificate_date']."</td>
					<td align='left'>".$race['sponsor']."</td>
					<td align='left'>".$race['word']."</td>
					<td align='left'>".$race['memo']."</td>
			</tr>";	    
			}
		 } else {
	    $race_print.="<tr><td colspan='9'>�L����n���O��</td></tr>";
		 }
     $race_print.="</table>";

		 $smarty->assign("race_print",$race_print);
		
		}
		
		//�F����� 2013/09/03 =============================================================================================
		if ($stud_leader=='checked') {
			
			$sql="select seme_class from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme'";
			$res=$CONN->Execute($sql);
			
			$seme_key=substr($res->fields['seme_class'],0,1)."-".$sel_seme;
			
			//���X�ӥͷF���������(�]�t�Ҧ��Ǵ����}�C���, �H�U�u��ܥ��Ǵ�, ��L�Ǵ��h�H hidden �覡)
			$query="select * from career_self_ponder where student_sn='$student_sn' and id='3-2'";
 			$res_ponder=$CONN->Execute($query);
 			$ponder_array=unserialize($res_ponder->fields['content']); //�G���}�C
 			
 			//���ηF��
 		 $association_leader="";
		 $query="select association_name,score,stud_post from association where seme_year_seme='$seme_year_seme' and student_sn=$student_sn";
		 $res=$CONN->Execute($query);
	    
	   while ($row=$res->fetchRow()) {
	   	//�դ�����, �n�ˬd����, �~�ժ��Ϋh�@�߳q�L
	   		$query="select pass_score from stud_club_base where club_sn='".$row['club_sn']."'";
	   		$res_pass=mysql_query($query);
	   		list($pass_score)=mysql_fetch_row($res_pass);
	     
	   	if ((($row['score']>=$pass_score and $row['club_sn']>0) or ($row['club_sn']==0) and $row['stud_post']!="")) {
 			 $association_name=$row['association_name'];
 			 $stud_post=$row['stud_post'];
       $association_leader.=($association_leader=='')?$stud_post."(".$association_name.")":"�B".$stud_post."(".$association_name.")";
	    }
	   } 				

      $leader_print="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
      <tr><td align='center'>�Z�ŷF��</td><td align='center'>�p�Ѯv</td></td><td align='center'>���ηF��</td></tr>";
      $leader_print.="<tr><td align='center'>";
      $leader_print.=($ponder_array[$seme_key][1][1]!="")?$ponder_array[$seme_key][1][1]:"&nbsp;";
      $leader_print.=($ponder_array[$seme_key][1][2]!="")?"�B".$ponder_array[$seme_key][1][2]:"";
      $leader_print.="</td><td align='center'>";
      $leader_print.=($ponder_array[$seme_key][2][1]!="")?$ponder_array[$seme_key][2][1]:"";
      $leader_print.=($ponder_array[$seme_key][2][2]!="")?"�B".$ponder_array[$seme_key][2][2]:"&nbsp;";
      $leader_print.="</td><td align='center'>";
      $leader_print.=($association_leader!="")?$association_leader:"&nbsp;";      
      $leader_print.="</td></tr></table>";
				
			$smarty->assign("leader_print",$leader_print);
	  }
		//���m�Ҳέp 2013/09/02 =============================================================================================
		if ($stud_absent=='checked') {
			//�O�_�L����
			if ($stud_absent_detail=='checked') {
			 
			$print_str=stud_absent_statForm($sel_year,$sel_seme,$class_id_key,$stud['stud_id'],$seme_start_date,$seme_end_date);
			
			//���ݩ���, �u�n�`���
			} else {
			//���o���m�����O
			$absent_kind_array= SFS_TEXT("���m�����O");
		
			//�W�[���|�o�����O
			$abkind_TXT="<td>���|</td>";
	
			//�s�@���D
			foreach($absent_kind_array as $abkind){
			$abkind_TXT.="<td>$abkind</td>";
			}
		
			$print_str="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"100%\">\n
			<tr>
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"14%\">���|</td>\n
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"14%\">�m��</td>\n
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"14%\">�ư�</td>\n
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"14%\">�f��</td>\n
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"14%\">�ల</td>\n
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"14%\">����</td>\n
			<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"16%\">���i�ܤO</td></tr>\n";
		
			//���o�ӾǥͥX�ʮu�έp���
			$aaa=getOneAbsent($stud['stud_id'],$sel_year,$sel_seme,"����");
		
			//�U�د��m�Ҽ�
		
				$d_b=($i%5==0 || $i==count($stud))?"1.5pt":"0.75pt";
			
				$sections_data="<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">$aaa[f]</font></td>\n";
			foreach($absent_kind_array as $abkind){
				$r_b=($abkind=="���i�ܤO")?"1.5pt":"0.75pt";
				$sections_data.="<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt $r_b 1.5pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">$aaa[$abkind]</font></td>\n";
			}
		
			$print_str.="<tr>".$sections_data."</tr></table>\n";
			
			} // end if $stud_abcent_detail
				
					
			$smarty->assign("absent_print",$print_str);
					
		} // end if $stud_absent	
		
		
		//���g�O�� 2013/09/01 =============================================================================================
		if ($stud_reward=='checked') {
			
			$smarty->assign("reward_kind",$reward_arr);
			$query="select * from reward where student_sn='$student_sn' and reward_year_seme='".$seme_year_seme."' order by reward_div,reward_date desc";
			$res=$CONN->Execute($query);
			$smarty->assign("reward_rows",$res->GetRows());
			for($i=1;$i<=6;$i++) { $f[$i]=0; $t[$i]=0; }
			$smarty->assign("f",$f);
		}
		
    //���`�ˮ֪� 2013/08/31 ======================================
		
		if ($stud_chk_data=='checked') {
			
    $sn_value=$student_sn;
    
			$chk_data="";
			
			//�O�_�Ŀ��ˮ֪�
			if ($stud_chk_data_detail=="checked") {
					
			//�ˮ֪��
			$chk_item=chk_kind();
			$chk_value=get_chk_value($sn_value,$sel_year,$sel_seme,$chk_item,"value");
			
			//�}�l����HTML��� �ˮ֪�
			$chk_data="<table  STYLE='font-size: ".$item_px."px' border=2 cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolorlight='#000000' bordercolordark='#000000' width='100%'>
						<tr bgcolor='#FFCCCC'><td colspan='2' align='center'>���`�ͬ��ˮֶ���</td><td align='center'>��{���p</td><td align='center'>�Ƶ�</td></tr>";
			
			//�����Ƭ��G���}�C
			$data_array=array();			
			foreach($itemdata['items'] as $key=>$value) {
				$main=$value['main'];
				$sub=$value['sub'];
				$data_array[$main][$sub]=$value['item'];
			}
			//�Ԧ��ˮֶ��ر��ΦC��
			foreach($data_array as $key=>$main) {
				$rowspan=count($main)-1;
				$chk_data.="<tr><td rowspan=$rowspan align='center'>".$main[0]."</td>";
				for($i=1;$i<=$rowspan;$i++){
					$chk_data.="<td>".$main[$i]."</td>";
					$chk_data.="<td align='center' width='120'>".$chk_value[$key][$i]['score']."</td><td>".$chk_value[$key][$i]['memo']."</td></tr>";					
				}
			}
			$chk_data.="</table>";
			
		  } // end if ($stud_chk_data_detail=="checked")
		  
			//��L��{��r
			$query="select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$sn_value' order by ss_id";
			//echo $query;
			//exit();
			$res=$CONN->Execute($query) or die("SQL���~! query=$query");
			$r=array();
			while(!$res->EOF) {
				$r[$res->fields['ss_id']]=$res->fields['ss_score_memo'];
				$res->MoveNext();
			}
			$nor_memo=$r;
			
			//�欰�y�z
			$chk_data.="<table border=2 cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolorlight='#000000' bordercolordark='#000000' width='100%'>
						<tr><td rowspan=4 align='center' bgcolor='#c4d9ff' width=80>�欰�y�z<BR>�P<BR>�����ĳ</td>
						<td align='center' bgcolor='#c4d9ff' width=80>���`�ͬ�</td><td>$nor_memo[0]</td></tr>
						<tr><td align='center' bgcolor='#c4d9ff' width=80>���鬡��</td><td>$nor_memo[1]</td></tr>
						<tr><td align='center' bgcolor='#c4d9ff' width=80>���@�A��</td><td>���դ�: $nor_memo[2]<br>������: $nor_memo[3]</td></tr>
						<tr><td align='center' bgcolor='#c4d9ff' width=80>�S���{</td><td>���դ�: $nor_memo[4] <br>���ե~: $nor_memo[5]</td></tr>
						</table>";
		
		$smarty->assign("chk_data",$chk_data);  
		     
    } // end if $stud_chk_data 
    
    
    

    //2012/12/7 by smallduh �W�[���λP�A�Ⱦǲ߰O�� ================================================================
   	//���o�A�Ⱦǲ߻P���ά��ʰO�� 2012/12/7 �H $student_sn�� $seme_year_seme ���������
   	if ($IS_JHORES==6 and $stud_service=='checked') {
	   $query="select b.sn,a.minutes,a.feedback,b.service_date,b.department,b.item,b.memo,b.sponsor from stud_service_detail a,stud_service b where a.item_sn=b.sn and b.year_seme='$seme_year_seme' and b.confirm=1 and a.student_sn=$student_sn order by service_date";
	   $res=mysql_query($query);
	   $service_detail="";
	   $MINS=0; $HOURS=0;
	   while ($row=mysql_fetch_array($res)) {
	   	 $service_detail[$row['sn']]['service_date']=$row['service_date'];
	     $service_detail[$row['sn']]['department']=getPostRoom($row['department']);
	     $service_detail[$row['sn']]['sponsor']=$row['sponsor'];
	     $service_detail[$row['sn']]['item']=$row['item'];
	     $service_detail[$row['sn']]['memo']=$row['memo'];
	     $service_detail[$row['sn']]['hour']=round($row['minutes']/60,2);
	     $service_detail[$row['sn']]['feedback']=$row['feedback'];
	     $MINS+=$row['minutes'];
	   }
	   
	   $HOURS=round($MINS/60,2);
	   
	   $smarty->assign("service_detail",$service_detail); //���ǥͥ��Ǵ����A�ȩ���
	   $smarty->assign("HOURS",$HOURS); //�`�A�Ȯɼ�
	  }
	
	 
	  //���ά���=================================================================
	  if ($IS_JHORES==6 and $stud_club=='checked') {
	   $query="select association_name,score,description,club_sn,stud_feedback from association where seme_year_seme='$seme_year_seme' and student_sn=$student_sn";
	   $res=mysql_query($query);
	   $club_detail="";
	   $j=0;
	    
	   while ($row=mysql_fetch_array($res)) {
	   	//�դ�����, �n�ˬd����, �~�ժ��Ϋh�@�߳q�L
	   		$query="select pass_score from stud_club_base where club_sn='".$row['club_sn']."'";
	   		$res_pass=mysql_query($query);
	   		list($pass_score)=mysql_fetch_row($res_pass);
	     
	   	if (($row['score']>=$pass_score and $row['club_sn']>0) or ($row['club_sn']==0) ) {
	   	  $j++;
	      $club_detail[$j]['association_name']=$row['association_name'];
	      $club_detail[$j]['score']=score2str($row['score'],$class);
	      $club_detail[$j]['description']=$row['description'];
	      $club_detail[$j]['stud_feedback']=$row['stud_feedback'];
	    }
	   }
	  		  	
	   $smarty->assign("club_detail",$club_detail);
	   
	  }
    //============================================================================================================================

		$smarty->assign("stud",$stud);
		$smarty->assign("default_txt",$default_txt);
		
		$smarty->display("stud_club_serv_p.tpl");

		$page_i++;
    
	} // end foreach stud
	 
 } // end foreach class

} // end if post


//�Ǧ^�A�ȳ�� ==================================================================================================================
function getPostRoom($room_id) {
  global $CONN;
  $sql_select = "select room_name from school_room where room_id='$room_id'";
  $result=$CONN->Execute($sql_select);
  $room_name=$result->fields['room_name'];	
  return $room_name;
}

//���o�Y�@�ǥͬY�몺�U�د��m�Ҳֿn����
function getOneAbsent($stud_id,$sel_year,$sel_seme,$mode=""){
	global $CONN,$absent_kind_array;
	foreach($absent_kind_array as $abkind){
	 $theData[$abkind]=0;
	}
	$theData[f]=0;
	
	$sql_select="select section, absent_kind from stud_absent where stud_id='$stud_id' and year='$sel_year' and semester='$sel_seme'";
	//echo $sql_select;
	//exit();
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	
	while($row=$recordSet->fetchRow()){
		list($section,$kind)=$row;
		//echo $section.",".$kind."<br>";
		if($mode=="����"){
			$n=($section=="allday")?7:1;
			$m=($section=="allday")?2:1;
			if ($kind=="�m��" && ($section=="uf" || $section=="df")) $theData[f]+=$m;
			if ($section!="uf" && $section!="df") $theData[$kind]+=$n;
		}else{
			$theData[$section]+=1;	
		}		
	}
  //print_r($theData);
  
	return $theData;
}


//Ū���v�ɰO�� �G���}�C �ǤJ����, ���Ǵ�, �ǥ�
function get_race_record($st_date,$end_date,$student_sn) {
	
 global $CONN;
 
 $students=array();

 $query="select * from `career_race` where certificate_date>='$st_date' and certificate_date<='$end_date' and student_sn='$student_sn' order by certificate_date";
 $res=$CONN->Execute($query) or die("SQL���~:$query");;
 while ($row=$res->FetchRow()) {			//Ū���@��, �é�J�}�C $row �� 

   $student_sn=$row['student_sn'];
   $sn=$row['sn'];
   
   //Ū�J�v�ɸ��
   foreach($row as $k=>$v) {
     $students[$sn][$k]=$v;
   }
   	   
 } // end while
 
 return $students;

} // end function 

//���m�ҩ���
//��@�ǥͪ��ʪp�ҩ���
function &stud_absent_statForm($sel_year,$sel_seme,$class_id,$stud_id,$start_date,$end_date){
	global $CONN,$IS_JHORES;
	//���o�Y�Z�`��
	$all_sections=get_class_cn($class_id);
	
	for($i=1;$i<=$all_sections;$i++){		
			$sections_txt.="<td>".$i."</td>";		
	}

	$sql="select date,absent_kind,section from stud_absent where (date>='$start_date') and (date<='$end_date') and stud_id='$stud_id' order by date,section";
	$rs=$CONN->Execute($sql);
	$aaa="";
	$data="";
	$total=array();
	$lis=0;
	while(!$rs->EOF){
		$the_date=$rs->fields['date'];
		$absent_kind=$rs->fields['absent_kind'];
		$section=$rs->fields['section'];
		if ($the_date != $pre_date) {
			if ($have_data) {
				$data.=show_data($pre_date,$aaa,$all_sections);
				$aaa="";
			}
			$pre_date=$the_date;
			$have_data=1;
			if ($lis!=0 && ($lis%5)==0 ) $data.="<tr><td colspan=".($all_sections+11)." align='center'><hr size='1'></tr>";
			$lis++;
		}
		$aaa[$section]=$absent_kind;
		$total[$absent_kind][$section]++;
		$total[sum][$section]++;
		$rs->MoveNext();
	}
	if ($lis>0) { $data.=show_data($the_date,$aaa,$all_sections); } else {$data="<td colspan=".($all_sections+11)." align='center'><font size='2'><i>�L�n��������m�ҰO��</i></font></td>";}

	//���o���m�����O
	$absent_kind_array= SFS_TEXT("���m�����O");
	$sum_data="";
	for ($i=0;$i<count($absent_kind_array);$i++) {
		$section_data="";
		$kind=$absent_kind_array[$i];
		for($j=1;$j<=$all_sections;$j++){
			$k=($IS_JHORES!=0)?$total[$kind][$j]+$total[$kind][allday]:$total[$kind][$j];
			if ($k==0) $k="";
			$section_data.="<td bgcolor='#FFFFFF'>".$k."</td>";
			$ttotal[$kind]+=$total[$kind][$j];
		}
		$ttotal[$kind]+=($IS_JHORES==0)?$total[$kind][allday]:$total[$kind][allday]*$all_sections;
		$sum_data.="<td>".$ttotal[$kind]."</td>";
	}
	if ($IS_JHORES!=0) {
		$section_data="";
		for($j=1;$j<=$all_sections;$j++){
			$section_data.="<td bgcolor='#FFFFFF'></td>";
		}
		$ufs=$total[�m��][uf]+$total[�m��][allday];
		$dfs=$total[�m��][df]+$total[�m��][allday];
		$sum_data="$sum_data<td>".($ufs+$dfs)."</td>";
	}
	
		$query="select * from school_base";
		$res=$CONN->Execute($query);
		$school_name=$res->fields[sch_cname];
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$query="select a.stud_name,b.seme_num from stud_base a,stud_seme b where b.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and a.stud_id='$stud_id'";
		$res=$CONN->Execute($query);
		$stud_name=$res->fields[stud_name];
		$seme_num=$res->fields[seme_num];
		$query="select * from school_class where class_id='$class_id'";
		$res=$CONN->Execute($query);
		$c_name=$res->fields[c_name];
		$c_year=$res->fields[c_year];
		$today=date("Y-m-d");	
	
	
	//���o���m�����O
	$absent_kind_array= SFS_TEXT("���m�����O");
	
	$main="
	<center><small>�έp�ɶ��G".$start_date."��".$end_date."</small><br>
	<table cellspacing='1' cellpadding='3' class='small' width='100%'>
	<tr align='center'>
	<td>�ʮu���</td>		
	<td>�P��</td>		
	<td>��</td>
	$sections_txt
	<td>��</td><td>�m</td><td>��</td><td>�f</td><td>��</td><td>��</td><td>��</td><td>�X</td>
	</tr>
	<tr>
	<td colspan=".($all_sections+11)." align='center'><hr size='2'></td>
	</tr>
	$data
	<tr>
	<td colspan=".($all_sections+11)." align='center'><hr size='2'></td>
	</tr>
	<tr align='center'>
	<td>�֭p</td><td colspan=".($all_sections+3)."></td>$sum_data
	</tr>
	</table></center>
	";
	return $main;
}

function show_data($the_date,$a,$all_sections) {
	global $IS_JHORES,$class_name_kind_1;
	//�U�@�`���
	$w=explode("-",$the_date);
	$ww=date("w", mktime (0,0,0,$w[1],$w[2],$w[0]));
	$section_data="";
	$k="";
	$ak=array("�m��"=>0,"�ư�"=>0,"�f��"=>0,"�ల"=>0,"����"=>0,"���i�ܤO"=>0,"�X"=>0);
	if ($IS_JHORES!=0 && !empty($a[allday])) {
		$k=$a[allday];
		$a[uf]=$k;
		$a[df]=$k;
	}
	for($j=1;$j<=$all_sections;$j++){
		if ($k) $a[$j]=$k;
			$section_data.="<td>".substr($a[$j],0,2)."</td>";
			if ($a[$j]) $ak[$a[$j]]++;
		
	}
	$data="
		<tr align='center'>
		<td>$the_date</td>
		<td>".$class_name_kind_1[$ww]."
		<td>".substr($a[uf],0,2)."</td>
		$section_data
		<td>".substr($a[df],0,2)."</td>
		";
	
		if ($a[uf]=="�m��") $ak["�X"]++;
		if ($a[df]=="�m��") $ak["�X"]++;
		while (list($x,$y)=each($ak)) {
			$data.="<td>".intval($y)."</td>";
		}
		$data.="</tr>";
	
	return $data;
}

//���o�ӯZ�ҵ{�`��
function get_class_cn($class_id=""){
	global $CONN;
	//���o�Y�Z�ǥͰ}�C
	$c=class_id_2_old($class_id);
	
	//���o�ӯZ���X�`��
	$sql_select = "select sections from score_setup where year = '$c[0]' and semester='$c[1]' and class_year='$c[3]'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("SQL�y�k���~�G $sql_select", E_USER_ERROR);
	list($all_sections) = $recordSet->FetchRow();
	return $all_sections;
}

?>
