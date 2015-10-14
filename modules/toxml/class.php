<?php

// $Id:$

//include_once "../../include/sfs_case_ado.php";
include_once "../../include/sfs_case_dataarray.php";
include_once "../../include/sfs_case_score.php";
include_once "../../include/sfs_case_subjectscore.php";
include_once "../../include/sfs_oo_zip2.php";
include_once "../12basic_career/my_fun.php";

class sfsxmlfile
{
	var $student_sn;
	var $out_arr;
	var $sn_str;
	var $zip;

	function sfsxmlfile()
	{
		$this->init();
	}

	function init()
	{
		$this->out_arr=array();
		$this->zip = new EasyZip;
	}

	function output()
	{
		if (count($this->student_sn)>0) {
			$this->sn_str="'".implode("','",array_keys($this->student_sn))."'";
			$this->base();
//			$this->seme();
//			$this->move();
//			$this->mid_seme();
		}
	}

	function base()
	{
		global $CONN,$addr,$all_reward,$IS_JHORES;
		
		//���X�Z�žɮv�m�W�ѷӡA�U�����Ǵ���Ʒ|�Ψ�
		$class_teacher_name=class_teacher();
		
		//���o���W��(�u�ʽҵ{����ܦW��)
        $subject_name_arr=get_subject_name_arr();
		
		//���ɸ�ưѷӰ}�C
		$sse_relation_arr = sfs_text("�������Y");
		$sse_family_kind_arr=sfs_text("�a�x����");
		$sse_family_air_arr=sfs_text("�a�x��^");
		$sse_teach_arr=sfs_text("�ޱФ覡");
		$sse_live_state_arr=sfs_text("�~����");
		$sse_rich_state_arr=sfs_text("�g�٪��p");
		
		$sse_arr= array("1"=>"�߷R�x�����","2"=>"�߷R�x�����","3"=>"�S��~��","4"=>"����","5"=>"�ͬ��ߺD","6"=>"�H�����Y","7"=>"�~�V�欰","8"=>"���V�欰","9"=>"�ǲߦ欰","10"=>"���}�ߺD","11"=>"�J�{�欰");
		while(list($id,$val)= each($sse_arr)){
			$temp_sse_arr = sfs_text("$val");
			${"sse_arr_$id"} = $temp_sse_arr;
		}
		
		//��`�ͬ���{���O�ѷ�
		$ss_arr=array('0'=>'[��`�欰]','1'=>'[���鬡��]','2'=>'[���@�A��-�դ�]','3'=>'[���@�A��-����]','4'=>'[�S���{-�դ�]','4'=>'[�S���{-�ե~]');
		
		//���ʰ}�C�ѷ�
		$study_cond_arr=study_cond();
		
		//���X stud_base ���
		$query="select a.*,left(a.curr_class_num,length(a.curr_class_num)-4) as year_num,mid(a.curr_class_num,length(a.curr_class_num)-3,2) as class_num,right(a.curr_class_num,2) as site_num,b.grad_kind,b.grad_date,b.grad_word,b.grad_num from stud_base a left join grad_stud b on a.student_sn=b.student_sn where a.student_sn in ($this->sn_str) order by a.student_sn";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			//�B�z�ǥͨ����O 1~18 ���зǿﶵ
			$oth_arr=array();
			$stud_kind_arr=explode(",",$res->fields[stud_kind]);
			$stud_id=$res->fields['stud_id'];
			$student_sn=$res->fields['student_sn'];
			reset($stud_kind_arr);
			while(list($k,$v)=each($stud_kind_arr)) {
				if (intval($v)<19 and $v!="") $oth_arr[stud_kind][]=$v;
			}
			//�B�z���y��}�M�s����}
			
			//���ϽեX�����̭����O���E���s�}	�N�a�}�������ӷs�}	
			//$sql_move="select new_address from stud_seme_move where student_sn=$student_sn and move_id=8 order by move_date desc";
			$sql_move="select new_address from stud_move where stud_id='$stud_id' and move_kind='8' order by move_date desc";
			$res_move=$CONN->Execute($sql_move);
			$addr=$res_move->fields['new_address'];

			if($addr) $oth_arr[stud_addr_1]=change_addr_str($addr);	else
			{			
				$addr=$res->fields[stud_addr_1];
				$oth_arr[stud_addr_1]=change_addr_str($addr);
				//$oth_arr[stud_addr_1][12]=implode("",array_slice($oth_arr[stud_addr_1],4,8));
			}
			$addr=$res->fields[stud_addr_2];
			$oth_arr[stud_addr_2]=change_addr_str($addr);
			//$oth_arr[stud_addr_2][12]=implode("",array_slice($oth_arr[stud_addr_2],4,8));
			$this->out_arr[$res->fields[student_sn]]=array_merge($res->FetchRow(),$oth_arr);
			
			
	
			
		}
		//���X stud_domicile ���
		$query="select * from stud_domicile where student_sn in ($this->sn_str) order by student_sn";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			 $this->out_arr[$res->fields[student_sn]]=array_merge($this->out_arr[$res->fields[student_sn]],$res->FetchRow());
		}
		//���X stud_brother_sister ���
		$query="select bs_id,bs_name,bs_calling,bs_gradu,bs_birthyear,student_sn from stud_brother_sister where student_sn in ($this->sn_str) order by student_sn";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			 $this->out_arr[$res->fields[student_sn]][bro_sis][$res->fields[bs_id]]=$res->FetchRow();
		}
		//���X stud_kinfolk ���
		$query="select kin_id,kin_name,kin_calling,kin_phone,kin_hand_phone,kin_email,student_sn from stud_kinfolk where student_sn in ($this->sn_str) order by student_sn";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			 $this->out_arr[$res->fields[student_sn]][kinfolk][$res->fields[kin_id]]=$res->FetchRow();
		}
		
		//���X�������(stud_subkind)
		$query="select student_sn,clan,area from stud_subkind where type_id=9 AND student_sn in ($this->sn_str) order by student_sn";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			 $this->out_arr[$res->fields[student_sn]][yuanzhumin]=$res->FetchRow();
		}
		
		//�����`�ͬ���{�������
		$query="select * from stud_seme_score_nor where student_sn in ($this->sn_str) order by student_sn,seme_year_seme,ss_id";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];
			$ss_id=$res->fields[ss_id];

			if($res->fields[ss_score_memo])  $this->out_arr[$current_student_sn][semester_score_nor][$current_seme_year_seme][ss_score_memo].=$ss_arr[$ss_id].$this->zip->change_str($res->fields[ss_score_memo],1,0).' ';			
			$res->MoveNext();
		}
		
		//����X�ʮu�έp���
		$query="select a.*,b.student_sn from stud_seme_abs a,stud_base b where b.student_sn in ($this->sn_str) AND a.stud_id=b.stud_id order by b.student_sn,a.abs_kind";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];
			$absence_kind=$res->fields['abs_kind'];
			$absence_days=$res->fields['abs_days'];
			$this->out_arr[$current_student_sn][semester_absence][$current_seme_year_seme][$absence_kind]=$absence_days;
			//�[�`��L����
			if($absence_kind>3) $this->out_arr[$current_student_sn][semester_absence][$current_seme_year_seme][others]+=$absence_days;
			$res->movenext();
		}
		
		 
		//����S���{���
		$query="select a.*,b.student_sn from stud_seme_spe a,stud_base b where b.student_sn in ($this->sn_str) AND a.stud_id=b.stud_id order by b.student_sn,a.seme_year_seme";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];
			$ss_id=$res->fields[ss_id];
			$this->out_arr[$current_student_sn][semester_spe][$current_seme_year_seme][$ss_id][sp_date]=$res->fields[sp_date];
			$this->out_arr[$current_student_sn][semester_spe][$current_seme_year_seme][$ss_id][sp_memo]=$res->fields[sp_memo];
			$res->movenext();
		}
		
		//����߲z�������
		$query="select * from stud_psy_test where student_sn in ($this->sn_str) order by student_sn,year,semester";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=sprintf("%03d%d",$res->fields[year],$res->fields[semester]);
			$sn=$res->fields[sn];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][test_date]=$res->fields[test_date];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][item]=$res->fields[item];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][score]=$res->fields[score];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][model]=$res->fields[model];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][standard]=$res->fields[standard];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][pr]=$res->fields[pr];
			$this->out_arr[$current_student_sn][psy_test][$current_seme_year_seme][$sn][explanation]=$res->fields[explanation];
			$res->movenext();
		}
		
		//������ɬ���A��
		$query="select a.*,b.student_sn from stud_seme_eduh a,stud_base b where b.student_sn in ($this->sn_str) AND a.stud_id=b.stud_id order by b.student_sn,a.seme_year_seme";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];
			$row_data=$res->FetchRow();
			//$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme]=$row_data;
 			
 			//�������Y
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_relation]=$sse_relation_arr[$row_data[sse_relation]];
			//�a�x����
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_family_kind]=$sse_family_kind_arr[$row_data[sse_family_kind]];
			//�a�x��^
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_family_air]=$sse_family_air_arr[$row_data[sse_family_air]];
			//�ޱФ覡
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_father]=$sse_teach_arr[$row_data[sse_farther]];
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_mother]=$sse_teach_arr[$row_data[sse_mother]];
			//�~����
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_live_state]=$sse_live_state_arr[$row_data[sse_live_state]];
			//�g�٪��p
			$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][sse_rich_state]=$sse_rich_state_arr[$row_data[sse_rich_state]];

			$sse_arr= array("1"=>"�߷R�x�����","2"=>"�߷R�x�����","3"=>"�S��~��","4"=>"����","5"=>"�ͬ��ߺD","6"=>"�H�����Y","7"=>"�~�V�欰","8"=>"���V�欰","9"=>"�ǲߦ欰","10"=>"���}�ߺD","11"=>"�J�{�欰");	
			foreach($sse_arr as $key=>$val) {
				$sse_no="sse_s$key";
				$sse_no_data=explode(",",$row_data[$sse_no]);
				$temp_arr=${"sse_arr_$key"};
				foreach($sse_no_data as $key2=>$val2) $sse_no_data[$key2]=$temp_arr[$val2];
				$this->out_arr[$current_student_sn][semester_eduh][$current_seme_year_seme][$sse_no]=$sse_no_data;
			}
		}

		//���X���ɳX�ͬ���
		$query="select a.*,b.student_sn from stud_seme_talk a,stud_base b where b.student_sn in ($this->sn_str) and a.stud_id=b.stud_id order by b.student_sn,a.seme_year_seme,a.sst_date";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];			
			$sst_id=$res->fields[sst_id];
			$row_data=$res->FetchRow();
			$this->out_arr[$current_student_sn][semester_talk][$current_seme_year_seme][$sst_id]=$row_data;
		}
	
		//���X���ʬ��� (�p��stud_move & stud_move_import)
		$query="(select * from stud_move_import where student_sn in ($this->sn_str)) UNION DISTINCT (select * from stud_move where student_sn in ($this->sn_str)) order by student_sn,move_date";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$move_id=$res->fields[move_id];
			$move_kind=$res->fields[move_kind];
			$row_data=$res->FetchRow();
			
			//�ഫ�������O����r
			$row_data[move_kind]=$study_cond_arr[$move_kind];
			$this->out_arr[$current_student_sn][stud_move][$move_id]=$row_data;			
		}
		
		//���X�ǲ߻���r�ԭz
		$query="SELECT a.seme_year_seme, a.ss_id, a.ss_score, a.ss_score_memo,student_sn,a.student_sn,b.subject_id, b.ss_id, b.link_ss
FROM stud_seme_score a, score_ss b
WHERE a.student_sn in ($this->sn_str) AND a.ss_id = b.ss_id AND a.ss_score IS  NOT  NULL  AND b.enable =  '1'
ORDER  BY b.year, b.semester, b.class_year, b.sort";
		$res_score_memo=$CONN->Execute($query) or die("SQL���~�G $query");
		
		$link_ss=array("�y��"=>"language","�y��-����y��"=>"chinese","�y��-���g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�ͬ�"=>"life","�۵M�P�ͬ����"=>"nature","���|"=>"social","���N�P�H��"=>"art","���d�P��|"=>"health","��X����"=>"complex","�u�ʽҵ{"=>"elasticity");
		while(!$res_score_memo->EOF) {
			$current_student_sn=$res_score_memo->fields['student_sn'];
			$current_seme=$res_score_memo->fields['seme_year_seme'];
			$current_area=$res_score_memo->fields['link_ss'];
			$current_area=$link_ss[$current_area];
			if($current_area=='elasticity'){  //�u�ʽҵ{
				$subject_id=$res_score_memo->fields['subject_id'];
				$this->out_arr[$current_student_sn][semester_score_memo][$current_seme][elasticity][$subject_id][subject_name]=$subject_name_arr[$subject_id][subject_name];
				$this->out_arr[$current_student_sn][semester_score_memo][$current_seme][elasticity][$subject_id][score]=$res_score_memo->fields['ss_score'];
			} else {
				$this->out_arr[$current_student_sn][semester_score_memo][$current_seme][$current_area].= $this->zip->change_str($res_score_memo->fields['ss_score_memo'],1,0);
			}
			$res_score_memo->MoveNext();
		}
		
		//���X���մN�ǾǴ��P���Z���
		$query="select seme_year_seme,left(seme_year_seme,3) as year,right(seme_year_seme,1) as semester,left(seme_class,1) as study_year,right(seme_class,2) as study_class,seme_class_name,seme_num,student_sn from stud_seme where student_sn in ($this->sn_str) order by student_sn,seme_year_seme";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];
			$row_data=$res->FetchRow();
			$this->out_arr[$current_student_sn][semester][$current_seme_year_seme]=$row_data;
			//�[�J�Z�žɮv�m�W
			$class_id=sprintf("%03d_%d_%02d_%02d",$row_data['year'],$row_data['semester'],$row_data['study_year'],$row_data['study_class']);
			$this->out_arr[$current_student_sn][semester][$current_seme_year_seme][teacher]=$class_teacher_name[$class_id];
			
			//������;Ǵ����Z���
			$query="select distinct seme_year_seme from stud_seme_score where student_sn=$current_student_sn order by seme_year_seme";
			$res_score=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res_score->EOF) {
				 $score_semester_list_arr[]=$res_score->fields['seme_year_seme'];
				 $res_score->MoveNext();
			}
			$current_student_score=cal_fin_score(array($current_student_sn),$score_semester_list_arr,"","");
			$this->out_arr[$current_student_sn][semester_score]=$current_student_score[$current_student_sn];
		}
		
		//���X�L�մN�ǾǴ��P���Z���
		$query="select seme_year_seme,left(seme_year_seme,3) as year,right(seme_year_seme,1) as semester,seme_class_grade as study_year,seme_class_name,seme_num,student_sn,teacher_name from stud_seme_import where student_sn in ($this->sn_str) order by student_sn,seme_year_seme";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_seme_year_seme=$res->fields[seme_year_seme];
			$row_data=$res->FetchRow();
			$this->out_arr[$current_student_sn][semester][$current_seme_year_seme]=$row_data;
			//�[�J�Z�žɮv�m�W
			//$class_id=sprintf("%03d_%d_%02d_%02d",$row_data['year'],$row_data['semester'],$row_data['study_year'],$row_data['study_class']);
			$this->out_arr[$current_student_sn][semester][$current_seme_year_seme][teacher]=$res->fields[teacher_name];
			
			//������;Ǵ����Z���
			$query="select distinct seme_year_seme from stud_seme_score where student_sn=$current_student_sn order by seme_year_seme";
			$res_score=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res_score->EOF) {
				 $score_semester_list_arr[]=$res_score->fields['seme_year_seme'];
				 $res_score->MoveNext();
			}
			$current_student_score=cal_fin_score(array($current_student_sn),$score_semester_list_arr,"","");
			$this->out_arr[$current_student_sn][semester_score]=$current_student_score[$current_student_sn];
		}
		
		//��������ʮu���

		$current_year=curr_year();
		$current_seme=curr_seme();
		$current_year_seme=sprintf("%03d%d",$current_year,$current_seme);
		$query="select a.sasn,a.year,a.semester,a.absent_kind,year(a.date) as abs_year,month(a.date) as abs_month,b.student_sn from stud_absent a,stud_base b where b.student_sn in ($this->sn_str) AND a.year=$current_year AND a.semester=$current_seme AND a.stud_id=b.stud_id order by b.student_sn,a.year,a.semester";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		$abs_kind_arry=stud_abs_kind();
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$current_sasn=$res->fields[sasn];
			$current_abs_kind=array_search($res->fields[absent_kind],$abs_kind_arry);
			$current_year_month=sprintf("%03d%d",$res->fields[abs_year],$res->fields[abs_month]);
			$this->out_arr[$current_student_sn][absent][$current_year_seme][monthly][$current_year_month][year]=$res->fields[abs_year]-1911;
			$this->out_arr[$current_student_sn][absent][$current_year_seme][monthly][$current_year_month][month]=$res->fields[abs_month];

			if($current_abs_kind>3){
				$this->out_arr[$current_student_sn][absent][$current_year_seme][summary][others]+=1;
				$this->out_arr[$current_student_sn][absent][$current_year_seme][monthly][$current_year_month][others]+=1;				
			} else {
				$this->out_arr[$current_student_sn][absent][$current_year_seme][summary][$current_abs_kind]+=1;
				$this->out_arr[$current_student_sn][absent][$current_year_seme][monthly][$current_year_month][$current_abs_kind]+=1;	
			}
			$res->MoveNext();
		}	
		
		//����������g���
		$reward_array=array();
		$reward_array['1']=array('kind'=>"�ż�",'amount'=>"1");
		$reward_array['2']=array('kind'=>"�ż�",'amount'=>"2");
		$reward_array['3']=array('kind'=>"�p�\\",'amount'=>"1");
		$reward_array['4']=array('kind'=>"�p�\\",'amount'=>"2");
		$reward_array['5']=array('kind'=>"�j�\\",'amount'=>"1");
		$reward_array['6']=array('kind'=>"�j�\\",'amount'=>"2");
		$reward_array['7']=array('kind'=>"�j�\\",'amount'=>"3");
		$reward_array['-1']=array('kind'=>"ĵ�i",'amount'=>"1");
		$reward_array['-2']=array('kind'=>"ĵ�i",'amount'=>"2");
		$reward_array['-3']=array('kind'=>"�p�L",'amount'=>"1");
		$reward_array['-4']=array('kind'=>"�p�L",'amount'=>"2");
		$reward_array['-5']=array('kind'=>"�j�L",'amount'=>"1");
		$reward_array['-6']=array('kind'=>"�j�L",'amount'=>"2");
		$reward_array['-7']=array('kind'=>"�j�L",'amount'=>"3");
		
		$current_year_seme=sprintf("%3d%d",$current_year,$current_seme);
		$current_seme_year_seme=$current_year_seme=sprintf("%03d%d",$current_year,$current_seme);	
		$semester_limit=$all_reward?"and reward_year_seme=$current_year_seme":"";
		$query="select * from reward where student_sn in ($this->sn_str) $semester_limit and reward_cancel_date='0000-00-00' order by student_sn,reward_date";
		$res=$CONN->Execute($query) or die("SQL���~�G $query");
		while(!$res->EOF) {
			$current_student_sn=$res->fields[student_sn];
			$reward_id=$res->fields[reward_id];
			$row_data=$res->FetchRow();
			$reward_kind=$row_data['reward_kind'];
			$row_data['kind']=$reward_array[$reward_kind][kind];
			$row_data['amount']=$reward_array[$reward_kind][amount];
			$this->out_arr[$current_student_sn][reward][$current_seme_year_seme][$reward_id]=$row_data;
		}
		

		//����������Z���
		$target_table="score_semester_".$current_year."_".$current_seme;
		
		$query="SELECT a.ss_id,a.test_sort,a.test_kind,a.score,a.student_sn,b.subject_id,b.scope_id,b.rate,b.link_ss
				FROM $target_table a, score_ss b
				WHERE a.student_sn in ($this->sn_str) AND a.ss_id=b.ss_id AND b.enable='1' AND test_kind ='�w�����q'
				ORDER BY a.ss_id,a.test_sort";
		$res_scoreArr=$CONN->Execute($query) or die("SQL���~�G $query");
		
		foreach($res_scoreArr as $res_score) {
			$current_student_sn=$res_score->fields['student_sn'];
			$current_area_chinese=$res_score->fields['link_ss'];
			$current_test_sort=$res_score->fields['test_sort'];
			$current_area=$link_ss[$current_area_chinese];
			$subject_id=$res_score->fields['subject_id']?$res_score->fields['subject_id']:$res_score->fields['scope_id'];
			if(substr($current_area_chinese,0,4)=="�y��") {
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][language][$current_test_sort][$current_area]=$res_score->fields['score'];
			} elseif($current_area=='elasticity'){  //�u�ʽҵ{
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][elasticity][$subject_id][subject_name]=$subject_name_arr[$subject_id][subject_name];
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][elasticity][$subject_id][score]=$res_score->fields['score'];
			} else {
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][subjects][$subject_id][subject_name]=$subject_name_arr[$subject_id][subject_name];
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][subjects][$subject_id][rate]=$res_score->fields['rate'];
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][subjects][$subject_id][score]=$res_score->fields['score'];
				
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][area_score][rate]+=$res_score->fields['rate'];
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][area_score][score]+=$res_score->fields['rate']*$res_score->fields['score'];
				
				//�p��[�v����
				$total_score=$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][area_score][score];
				$total_rate=$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][area_score][rate];
				$this->out_arr[$current_student_sn][this_semester_score][$current_seme_year_seme][$current_area][$current_test_sort][area_score][average]=$total_score/$total_rate;
			}
			
		}

		if($_POST['career']){
			$min=$IS_JHORES?7:4;
			$max=$IS_JHORES?9:6;
			//����өʡB�U�����ʰѷӪ�
			$personality_items=SFS_TEXT('�ө�(�H��S��)');
			$activity_items=SFS_TEXT('�U������');
			//����ͲP���ɤ�U���
			//���o�ڪ������G�ƬJ�����
			$query="select student_sn,personality,interest,specialty from career_mystory where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				//����ۧڻ{�ѦU�Ӷ��ت����e
				$personality_array=unserialize($res->fields['personality']);
				foreach($personality_array as $grade=>$grade_value){
					foreach($grade_value as $key=>$value){
						$this->out_arr[$current_student_sn]['career']['self'][$grade]['personality'][]=$personality_items[$key];
					}
				}

				$interest_array=unserialize($res->fields['interest']);
				foreach($interest_array as $grade=>$grade_value){
					foreach($grade_value as $key=>$value){
						$this->out_arr[$current_student_sn]['career']['self'][$grade]['interest'][]=$activity_items[$key];
					}
				}
				
				$specialty_array=unserialize($res->fields['specialty']);
				foreach($specialty_array as $grade=>$grade_value){
					foreach($grade_value as $key=>$value){
						$this->out_arr[$current_student_sn]['career']['self'][$grade]['specialty'][]=$activity_items[$key];
					}
				}
	
				$res->MoveNext();
			}
			
			//���o�ڪ������G�ƬJ�����
			$query="select student_sn,occupation_suggestion,occupation_myown,occupation_others,occupation_weight from career_mystory where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				//����ۧڻ{�ѦU�Ӷ��ت����e
				$suggestion_array=unserialize($res->fields['occupation_suggestion']);
				foreach($suggestion_array as $grade=>$grade_value){
					foreach($grade_value as $key=>$value){
						$this->out_arr[$current_student_sn]['career']['job'][$grade]['suggestion'][$key]=$value;
					}
				}

				$myown_array=unserialize($res->fields['occupation_myown']);
				foreach($myown_array as $grade=>$grade_value){
					foreach($grade_value as $key=>$value){
						$this->out_arr[$current_student_sn]['career']['job'][$grade]['myown'][$key]=$value;
					}
				}
		
				$others_array=unserialize($res->fields['occupation_others']);
				foreach($myown_array as $grade=>$grade_value){
						$this->out_arr[$current_student_sn]['career']['job'][$grade]['others']=$grade_value;
				}
					
				//������¾�~�ɭ���������ѷӪ�
				$weight_items=SFS_TEXT('���¾�~�ɭ���������');
				$weight_array=unserialize($res->fields['occupation_weight']);

				foreach($weight_array as $grade=>$grade_value){
					foreach($grade_value as $key=>$value){
						$this->out_arr[$current_student_sn]['career']['job'][$grade]['weight'][$key]=$weight_items[$key];
					}
				}

				$res->MoveNext();
			}
			
			//�U���߲z����
			$menu_arr=array(1=>'�ʦV����',2=>'�������',3=>'��L����');
			//���o�߲z����J�����
			$query="select * from career_test where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				$id=$res->fields['id'];
				$sn=$res->fields['sn'];
				$content=unserialize($res->fields['content']);
				$title=$content['title'];
				$test_result=$content['data'];
				$study=$res->fields['study'];
				$job=$res->fields['job'];
				
				$this->out_arr[$current_student_sn]['career']['psy'][$sn]['id']=$menu_arr[$id];
				$this->out_arr[$current_student_sn]['career']['psy'][$sn]['title']=$title;
				$this->out_arr[$current_student_sn]['career']['psy'][$sn]['study']=$study;
				$this->out_arr[$current_student_sn]['career']['psy'][$sn]['job']=$job;
				foreach($test_result as $key=>$value) $this->out_arr[$current_student_sn]['career']['psy'][$sn]['item'][$key]=$value;

				$res->MoveNext();
			}

			//����ۧڬ٫�
			$query="select * from career_self_ponder where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				$id=explode('-',$res->fields['id']);
				$main=$id[0];
				$sub=$id[1];
				
				$contents=unserialize($res->fields['content']);
				foreach($contents as $key=>$value){
					$id=explode('-',$key);
					$grade=$id[0];
					$semester=$id[1];
					$this->out_arr[$current_student_sn]['career']['ponder'][$main][$sub][$grade][$semester]=$value;
				}
				$res->MoveNext();
			}
			
			//����Ш|�|�Ҧ��Z���
			$subject_arr=array('w','c','e','m','n','s');
			$query="select * from career_exam where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				foreach($subject_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['exam'][$value]=$res->fields[$value];			
				$res->MoveNext();
			}
			

			//�����A���˴����
			$item_arr=array('age','test_y','test_m','up_date','test1','test2','test3','test4','prec1','prec2','prec3','prec4','tall','weigh','bmt','prec_t','prec_w','prec_b','reward','organization');
			$query="select * from fitness_data where student_sn in ($this->sn_str) and test_y>0 and test_m>0 order by c_curr_seme";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				$id=$res->fields['id'];
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['fitness'][$id][$value]=$res->fields[$value];
				$res->MoveNext();
			}
			
			//����N�ǾǴ����
			$stud_seme_arr=array();
			$table=array('stud_seme_import','stud_seme');
			foreach($table as $key=>$value){
				$query="select * from $value where student_sn in ($this->sn_str) order by student_sn,seme_year_seme";
				$res=$CONN->Execute($query) or die("SQL���~�G $query");
				while(!$res->EOF){
					$current_student_sn=$res->fields['student_sn'];
					$stud_grade=substr($res->fields['seme_class'],0,-2);
					$year_seme=$res->fields['seme_year_seme'];
					$semester=substr($year_seme,-1);	
					$stud_seme_arr[$current_student_sn][$year_seme]['grade']=$stud_grade;
					$res->MoveNext();
				}
			}
			
			//�F����Ƥw�g�g�bcareer_self_ponder��  �e���w�g�s�X�F!
			//���θ��
			$item_arr=array('score','association_name','description','stud_post','stud_feedback');
			$query="select * from association where student_sn in ($this->sn_str) order by seme_year_seme";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				$seme_year_seme=$res->fields['seme_year_seme'];
				$this->out_arr[$current_student_sn]['career']['association'][$sn]['grade']=$stud_seme_arr[$current_student_sn][$seme_year_seme]['grade'];
				$this->out_arr[$current_student_sn]['career']['association'][$sn]['semester']=substr($seme_year_seme,-1);
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['association'][$sn][$value]=$res->fields[$value];				

				$res->MoveNext();
			}
			
			
			//�U���v�ɦ��G
			$level_array=array(1=>'���',2=>'����B�O�W��',3=>'�ϰ�ʡ]�󿤥��^',4=>'�١B���ҥ�',5=>'�����ϡ]�m��^',6=>'�դ�');
			$squad_array=array(1=>'�ӤH��',2=>'������');
			$item_arr=array('name','rank','certificate_date','sponsor','memo');
			
			$query="select * from career_race where student_sn in ($this->sn_str) order by certificate_date";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['race'][$sn][$value]=$res->fields[$value];
				$this->out_arr[$current_student_sn]['career']['race'][$sn]['level']=$level_array[$res->fields['level']];
				$this->out_arr[$current_student_sn]['career']['race'][$sn]['squad']=$squad_array[$res->fields['squad']];				
				
				$res->MoveNext();
			}
			
			//���g����
			$seme_reward=array();
			$sql="SELECT * FROM reward WHERE student_sn in ($this->sn_str) ORDER BY reward_year_seme,reward_date";
			$res=$CONN->Execute($sql) or die("SQL���~�G $query");
			while(!$res->EOF)
			{
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				$reward_kind=$res->fields['reward_kind'];
				$reward_cancel_date=$res->fields['reward_cancel_date'];
				//�Ǵ��έp
				$reward_year_seme=$res->fields['reward_year_seme'];
				$semester=substr($reward_year_seme,-1);
				$stud_grade=$stud_seme_arr[$current_student_sn][$seme_year_seme]['grade'];
				switch($reward_kind){
					case 1:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][1]++;	break;
					case 2:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][1]+=2; break;
					case 3:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][3]++;	break;
					case 4:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][3]+=2; break;
					case 5:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][9]++;	break;
					case 6:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][9]+=2; break;
					case 7:	$this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester][9]+=3; break;
					case -1: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['a']++; break;
					case -2: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['a']+=2; break;
					case -3: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['b']++; break;
					case -4: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['b']+=2; break;
					case -5: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['c']++; break;
					case -6: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['c']+=2; break;
					case -7: $this->out_arr[$current_student_sn]['career']['reward_effective'][$stud_grade][$semester]['c']+=3; break;
					/*
					case 1:	$seme_reward_effective[$current_student_sn][$seme_key][1]++;	$seme_reward_effective[$current_student_sn]['sum'][1]++;	break;
					case 2:	$seme_reward_effective[$current_student_sn][$seme_key][1]+=2;	$seme_reward_effective[$current_student_sn]['sum'][1]+=2; break;
					case 3:	$seme_reward_effective[$current_student_sn][$seme_key][3]++;	$seme_reward_effective[$current_student_sn]['sum'][3]++;	break;
					case 4:	$seme_reward_effective[$current_student_sn][$seme_key][3]+=2;	$seme_reward_effective[$current_student_sn]['sum'][3]+=2; break;
					case 5:	$seme_reward_effective[$current_student_sn][$seme_key][9]++;	$seme_reward_effective[$current_student_sn]['sum'][9]++;	break;
					case 6:	$seme_reward_effective[$current_student_sn][$seme_key][9]+=2;	$seme_reward_effective[$current_student_sn]['sum'][9]+=2; break;
					case 7:	$seme_reward_effective[$current_student_sn][$seme_key][9]+=3;	$seme_reward_effective[$current_student_sn]['sum'][9]+=3; break;
					case -1: $seme_reward_effective[$current_student_sn][$seme_key][-1]++;	$seme_reward_effective[$current_student_sn]['sum'][-1]++; break;
					case -2: $seme_reward_effective[$current_student_sn][$seme_key][-1]+=2;	$seme_reward_effective[$current_student_sn]['sum'][-1]+=2; break;
					case -3: $seme_reward_effective[$current_student_sn][$seme_key][-3]++;	$seme_reward_effective[$current_student_sn]['sum'][-3]++; break;
					case -4: $seme_reward_effective[$current_student_sn][$seme_key][-3]+=2;	$seme_reward_effective[$current_student_sn]['sum'][-3]+=2; break;
					case -5: $seme_reward_effective[$current_student_sn][$seme_key][-9]++;	$seme_reward_effective[$current_student_sn]['sum'][-9]++; break;
					case -6: $seme_reward_effective[$current_student_sn][$seme_key][-9]+=2;	$seme_reward_effective[$current_student_sn]['sum'][-9]+=2; break;
					case -7: $seme_reward_effective[$current_student_sn][$seme_key][-9]+=3;	$seme_reward_effective[$current_student_sn]['sum'][-9]+=3; break;
					*/
				}
				//�P�L�έp
				if($reward_cancel_date<>'0000-00-00'){
					switch($reward_kind){
						case -1: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['a']++; break;
						case -2: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['a']+=2; break;
						case -3: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['b']++; break;
						case -4: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['b']+=2; break;
						case -5: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['c']++; break;
						case -6: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['c']+=2; break;
						case -7: $this->out_arr[$current_student_sn]['career']['reward_canceled'][$stud_grade][$semester]['c']+=3; break;
						/*
						case -1: $seme_reward_canceled[$current_student_sn][$seme_key][-1]++; $seme_reward_canceled[$current_student_sn]['sum'][-1]++; break;
						case -2: $seme_reward_canceled[$seme_key][-1]+=2; $seme_reward_canceled[$current_student_sn]['sum'][-1]+=2; break;
						case -3: $seme_reward_canceled[$current_student_sn][$seme_key][-3]++; $seme_reward_canceled[$current_student_sn]['sum'][-3]++; break;
						case -4: $seme_reward_canceled[$current_student_sn][$seme_key][-3]+=2; $seme_reward_canceled[$current_student_sn]['sum'][-3]+=2; break;
						case -5: $seme_reward_canceled[$current_student_sn][$seme_key][-9]++; $seme_reward_canceled[$current_student_sn]['sum'][-9]++; break;
						case -6: $seme_reward_canceled[$current_student_sn][$seme_key][-9]+=2; $seme_reward_canceled[$current_student_sn]['sum'][-9]+=2; break;
						case -7: $seme_reward_canceled[$current_student_sn][$seme_key][-9]+=3; $seme_reward_canceled[$current_student_sn]['sum'][-9]+=3; break;
						*/
					}
				}			
				$res->MoveNext();
			}
			
			//�A�Ⱦǲ�
			$room_arr=room_kind();
			$item_arr=array('minutes','bonus','studmemo','feedback','year_seme','service_date','item','memo','sponsor');
			$query="select a.*,b.* from stud_service_detail a inner join stud_service b on a.item_sn=b.sn where confirm=1 and a.student_sn in ($this->sn_str) order by year_seme";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$recno++;
				$current_student_sn=$res->fields['student_sn'];
				$year_seme=$res->fields['year_seme'];
				$semester=substr($reward_year_seme,-1);
				$grade=$stud_seme_arr[$current_student_sn][$year_seme]['grade'];
				$this->out_arr[$current_student_sn]['career']['service'][$recno]['grade']=$grade;
				$this->out_arr[$current_student_sn]['career']['service'][$recno]['semester']=$semester;
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['service'][$recno][$value]=$res->fields[$value];
				$this->out_arr[$current_student_sn]['career']['service'][$recno]['department']=$room_arr[$res->fields['department']];
				$this->out_arr[$current_student_sn]['career']['service'][$recno]['hours']=$this->out_arr[$current_student_sn]['career']['service'][$recno]['minutes']/60;
			
				$res->MoveNext();
			}
		
			//����өʡB�U�����ʰѷӪ�
			$course_array=SFS_TEXT('�ͲP�ձ��ǵ{�θs��');
			$activity_array=SFS_TEXT('�ͲP�ձ����ʤ覡');
			
			$query="select * from career_explore where student_sn in ($this->sn_str) order by seme_key";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];				
				$id=explode('-',$res->fields['seme_key']);
				$this->out_arr[$current_student_sn]['career']['explore'][$sn]['grade']=$id[0];
				$this->out_arr[$current_student_sn]['career']['explore'][$sn]['semester']=$id[1];
				$this->out_arr[$current_student_sn]['career']['explore'][$sn]['course']=$course_array[$res->fields['course_id']];
				$this->out_arr[$current_student_sn]['career']['explore'][$sn]['activity']=$activity_array[$res->fields['activity_id']];
				$this->out_arr[$current_student_sn]['career']['explore'][$sn]['degree']=$res->fields['degree'];
				$this->out_arr[$current_student_sn]['career']['explore'][$sn]['ponder']=$res->fields['self_ponder'];				
				
				$res->MoveNext();
			}
			
			//����ͲP��V��Ҷ��ذѷӪ�
			$ponder_items=SFS_TEXT('�ͲP��V��Ҷ���');
			//����ͲP��ܤ�V�ѷӪ�
			$direction_items=SFS_TEXT('�ͲP��ܤ�V');
			
			//���o�J�����
			$query="select * from career_view where student_sn in ($this->sn_str) order by update_time";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				$ponder_array=unserialize($res->fields['ponder']);				
				foreach($ponder_items as $key=>$value){
					$this->out_arr[$current_student_sn]['career']['think'][$value]=$ponder_array[$key];
				}
				
				$direction_array=unserialize($res->fields['direction']);
				foreach($direction_array['item'] as $key=>$value)
					foreach($value as $key2=>$value2) 
						if($key2<>'memo') $direction_array['item'][$key][$key2]=$direction_items[$value2];  //�i��N�X-��r�ഫ
				$this->out_arr[$current_student_sn]['career']['direction']=$direction_array;		
				
				$res->MoveNext();
			}
		
			//����ҵ{���@
			$item_arr=array('school','course','position','transportation','transportation_time','transportation_toll','memo');
			$query="select * from career_course where aspiration_order>0 and student_sn in ($this->sn_str) order by aspiration_order";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$aspiration_order=$res->fields['aspiration_order'];
				$current_student_sn=$res->fields['student_sn'];
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['aspiration'][$aspiration_order][$value]=$res->fields[$value];
				$this->out_arr[$current_student_sn]['career']['aspiration'][$aspiration_order]['factor']=unserialize($res->fields['factor']);
				$res->MoveNext();
			}
			
			//���o�U������̰���������
			$query="select sn,student_sn,id,highest,study update_time  from career_test where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				$id=$res->fields['id'];
				$highest_arr=explode(',',$res->fields['highest']);
				foreach($highest_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['test'][$id]=$highest_arr;	
			
				$res->MoveNext();
			}

			//����Q��Ū���Ǯո��
			$id=0;
			$query="select student_sn,aspiration_order,school from career_course where student_sn in ($this->sn_str) order by aspiration_order";
			$res=$CONN->Execute($query) or die("SQL���~�G $query");
			while(!$res->EOF){
				$current_student_sn=$res->fields['student_sn'];
				if(!array_search($res->fields['school'],$this->out_arr[$current_student_sn]['career']['school'])) {
					$id++;
					$this->out_arr[$current_student_sn]['career']['school'][$id]=$res->fields['school'];
				}
				$res->MoveNext();
			}
			
			//����ͲP��ܤ�V�ѷӪ�
			$direction_items=SFS_TEXT('�ͲP��ܤ�V');
			
			//���o�v����X�N���J�����
			$item_arr=array('parent','tutor','guidance');
			$query="select * from career_opinion where student_sn in ($this->sn_str)";
			$res=$CONN->Execute($query);
			while(!$res->EOF){
				$sn=$res->fields['sn'];	
				$current_student_sn=$res->fields['student_sn'];				
				foreach($item_arr as $key=>$value){
					if($res->fields[$value]){  //�קK�ŭȸgExplode�ᤴ�|���ͪŰ}�C����
						$items=explode(',',$res->fields[$value]);
						foreach($items as $key2=>$value2) $this->out_arr[$current_student_sn]['career']['opinion'][$value][$key2]=$direction_items[$value2];
					}
					$memo=$value.'_memo';
					$this->out_arr[$current_student_sn]['career']['opinion'][$value]['memo']=$res->fields[$memo];
				}
				$res->MoveNext();
			}
			
			//����J���Ը߬���
			$item_arr=array('guidance_date','target','emphasis','teacher_name');
			$query="select * from career_guidance where student_sn in ($this->sn_str) order by guidance_date";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['guidance'][$sn][$value]=$res->fields[$value];
				$res->MoveNext();
			}
			
			$item_arr=array('consultation_date','teacher_name','emphasis','memo');
			$query="select * from career_consultation where student_sn in ($this->sn_str) order by consultation_date";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['consultation'][$sn][$value]=$res->fields[$value];
				$seme_key=explode('-',$res->fields['seme_key']);
				$this->out_arr[$current_student_sn]['career']['consultation'][$sn]['grade']=$seme_key[0];
				$this->out_arr[$current_student_sn]['career']['consultation'][$sn]['semester']=$seme_key[1];
				$res->MoveNext();
			}
			
			$items_ref=array(1=>'�ڪ������G��',2=>'�U���߲z����',3=>'�ǲߦ��G�ίS���{',4=>'�ͲP���ɬ���',5=>'�ͲP�ξ㭱���[',6=>'�ͲP�o�i�W����');
			$item_arr=array('suggestion','suggestion_date','tutor_confirm ','tutor_name'); 
			$query="select * from career_parent where student_sn in ($this->sn_str) order by suggestion_date";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$current_student_sn=$res->fields['student_sn'];
				foreach($item_arr as $key=>$value) $this->out_arr[$current_student_sn]['career']['parent'][$sn][$value]=$res->fields[$value];
				$seme_key=explode('-',$res->fields['seme_key']);
				$this->out_arr[$current_student_sn]['career']['parent'][$sn]['grade']=$seme_key[0];
				$this->out_arr[$current_student_sn]['career']['parent'][$sn]['semester']=$seme_key[1];
				$items=unserialize($res->fields['items']);
				foreach($items as $key=>$value) $this->out_arr[$current_student_sn]['career']['parent'][$sn]['consult'][$key]=$items_ref[$key];

				$res->MoveNext();
			}
			
			
			

/*
echo '<pre>';
print_r($this->out_arr[$current_student_sn]['career']['ponder']);
echo '</pre>';
exit;	
*/

		}		
		
	}
}
?>