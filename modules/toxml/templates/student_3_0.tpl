<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE ���y�洫��� SYSTEM "http://sfscvs.tc.edu.tw/student_3_0_tcc.dtd" >
<���y�洫���>
{{foreach from=$data_arr item=content key=arr_key}}
	<�ǥͰ򥻸��>
		<�򥻸��>
			<�ǥͩm�W>{{$data_arr[$arr_key].stud_name}}</�ǥͩm�W>
{{assign var=stud_sex value=$data_arr[$arr_key].stud_sex}}
			<�ǥͩʧO>{{$sex_arr[$stud_sex]}}</�ǥͩʧO>
			<�ǥͥͤ�>{{$data_arr[$arr_key].stud_birthday}}</�ǥͥͤ�>
			<�{�b�~��>{{$data_arr[$arr_key].year_num}}</�{�b�~��>
			<�{�b�Z��>{{$data_arr[$arr_key].class_num}}</�{�b�Z��>
			<�{�b�y��>{{$data_arr[$arr_key].site_num}}</�{�b�y��>
			<�ǥͨ������O>
{{assign var=stud_kind value=$data_arr[$arr_key].stud_kind}}
{{foreach from=$stud_kind item=sk_arr key=sk_key}}
				<�ǥͨ������O_��Ƥ��e>
					<�ǥͨ������O_���O>{{$stud_kind_arr[$sk_key]}}</�ǥͨ������O_���O>
					<�ǥͨ������O_�Ƶ�>null</�ǥͨ������O_�Ƶ�>
				</�ǥͨ������O_��Ƥ��e>
{{/foreach}}
			</�ǥͨ������O>
			<����>
				<����_�~��a>{{$data_arr[$arr_key].yuanzhumin.area}}</����_�~��a>
				<����_�ڧO>{{$data_arr[$arr_key].yuanzhumin.clan}}</����_�ڧO>
			</����>
			<�������ҷ�>
				<���y>{{$data_arr[$arr_key].stud_country}}</���y>
{{assign var=id_kind value=$data_arr[$arr_key].stud_country_kind}}
				<�ҷӺ���>{{$id_kind_arr[$id_kind]}}</�ҷӺ���>
				<�ҷӸ��X>{{$data_arr[$arr_key].stud_person_id}}</�ҷӸ��X>
				<���~�a>{{$data_arr[$arr_key].stud_country_name}}</���~�a>
			</�������ҷ�>
			<�s�����>
				<���y�a�}>
					<���y�a�}_�����W>{{$data_arr[$arr_key].stud_addr_1.0}}</���y�a�}_�����W>
					<���y�a�}_�m���ϦW>{{$data_arr[$arr_key].stud_addr_1.1}}</���y�a�}_�m���ϦW>
					<���y�a�}_����>{{$data_arr[$arr_key].stud_addr_1.2}}</���y�a�}_����>
					<���y�a�}_�F>{{$data_arr[$arr_key].stud_addr_1.3}}</���y�a�}_�F>
					<���y�a�}_����>{{$data_arr[$arr_key].stud_addr_1.4}}</���y�a�}_����>
					<���y�a�}_�q>{{$data_arr[$arr_key].stud_addr_1.5}}</���y�a�}_�q>
					<���y�a�}_��>{{$data_arr[$arr_key].stud_addr_1.6}}</���y�a�}_��>
					<���y�a�}_��>{{$data_arr[$arr_key].stud_addr_1.7}}</���y�a�}_��>
					<���y�a�}_��>{{$data_arr[$arr_key].stud_addr_1.8}}</���y�a�}_��>
					<���y�a�}_��>{{$data_arr[$arr_key].stud_addr_1.9}}</���y�a�}_��>
					<���y�a�}_��>{{$data_arr[$arr_key].stud_addr_1.10}}</���y�a�}_��>
					<���y�a�}_�Ӥ�>{{$data_arr[$arr_key].stud_addr_1.11}}</���y�a�}_�Ӥ�>
					<���y�a�}_��L>{{$data_arr[$arr_key].stud_addr_1.12}}</���y�a�}_��L>
				</���y�a�}>
				<�q�T�a�}>
					<�q�T�a�}_�����W>{{$data_arr[$arr_key].stud_addr_2.0}}</�q�T�a�}_�����W>
					<�q�T�a�}_�m���ϦW>{{$data_arr[$arr_key].stud_addr_2.1}}</�q�T�a�}_�m���ϦW>
					<�q�T�a�}_����>{{$data_arr[$arr_key].stud_addr_2.2}}</�q�T�a�}_����>
					<�q�T�a�}_�F>{{$data_arr[$arr_key].stud_addr_2.3}}</�q�T�a�}_�F>
					<�q�T�a�}_����>{{$data_arr[$arr_key].stud_addr_2.4}}</�q�T�a�}_����>
					<�q�T�a�}_�q>{{$data_arr[$arr_key].stud_addr_2.5}}</�q�T�a�}_�q>
					<�q�T�a�}_��>{{$data_arr[$arr_key].stud_addr_2.6}}</�q�T�a�}_��>
					<�q�T�a�}_��>{{$data_arr[$arr_key].stud_addr_2.7}}</�q�T�a�}_��>
					<�q�T�a�}_��>{{$data_arr[$arr_key].stud_addr_2.8}}</�q�T�a�}_��>
					<�q�T�a�}_��>{{$data_arr[$arr_key].stud_addr_2.9}}</�q�T�a�}_��>
					<�q�T�a�}_��>{{$data_arr[$arr_key].stud_addr_2.10}}</�q�T�a�}_��>
					<�q�T�a�}_�Ӥ�>{{$data_arr[$arr_key].stud_addr_2.11}}</�q�T�a�}_�Ӥ�>
					<�q�T�a�}_��L>{{$data_arr[$arr_key].stud_addr_2.12}}</�q�T�a�}_��L>
				</�q�T�a�}>
				<�q�T�q��>{{$data_arr[$arr_key].stud_tel_2}}</�q�T�q��>
				<��ʹq��>{{$data_arr[$arr_key].stud_tel_3}}</��ʹq��>
			</�s�����>
			<�ǥͯZ�ũʽ�>
{{assign var=class_kind value=$data_arr[$arr_key].stud_class_kind}}
{{assign var=stud_spe_kind value=$data_arr[$arr_key].stud_spe_kind}}
{{assign var=stud_spe_class_kind value=$data_arr[$arr_key].stud_spe_class_kind}}
{{assign var=stud_spe_class_id value=$data_arr[$arr_key].stud_spe_class_id}}
				<�Z�ũʽ�>{{$class_kind_arr[$class_kind]}}</�Z�ũʽ�>
				<�S�ЯZ���O>{{$spe_kind_arr[$stud_spe_kind]}}</�S�ЯZ���O>
				<�S�ЯZ�Z�O>{{$spe_class_kind_arr[$stud_spe_class_kind]}}</�S�ЯZ�Z�O>
				<�S��Z�W�ҩʽ�>{{$spe_class_id_arr[$stud_spe_class_id]}}</�S��Z�W�ҩʽ�>
			</�ǥͯZ�ũʽ�>
			<�J�ǫe�Ш|���>
				<���X��J��>
{{assign var=preschool_status value=$data_arr[$arr_key].stud_preschool_status}}
					<���X��J�Ǹ��>{{$preschool_status_arr[$preschool_status]}}</���X��J�Ǹ��>
					<���X��_�Ш|���ǮեN�X>{{$data_arr[$arr_key].stud_preschool_id}}</���X��_�Ш|���ǮեN�X>
					<���X��_�ǮզW��>{{$data_arr[$arr_key].stud_preschool_name}}</���X��_�ǮզW��>
				</���X��J��>
				<��p�J��>
{{assign var=preschool_status value=$data_arr[$arr_key].stud_Mschool_status}}
					<��p�J�Ǹ��>{{$preschool_status_arr[$preschool_status]}}</��p�J�Ǹ��>
					<��p_�Ш|���ǮեN�X>{{$data_arr[$arr_key].stud_mschool_id}}</��p_�Ш|���ǮեN�X>
					<��p_�ǮզW��>{{$data_arr[$arr_key].stud_mschool_name}}</��p_�ǮզW��>
				</��p�J��>
			</�J�ǫe�Ш|���>
			<���׷~�֭�帹>
{{assign var=grad_kind value=$data_arr[arr_key].grad_kind}}
				<���׷~�O>{{$grad_kind_arr[$grad_kind]}}</���׷~�O>
				<���׷~_���>{{$data_arr[$arr_key].grad_date}}</���׷~_���>
				<���׷~_�r>{{$data_arr[$arr_key].grad_word}}</���׷~_�r>
				<���׷~_��>{{$data_arr[$arr_key].grad_num}}</���׷~_��>
			</���׷~�֭�帹>
			<���˰򥻸��>
				<����_�m�W>{{$data_arr[$arr_key].fath_name}}</����_�m�W>
				<����_�X�ͦ~��>{{$data_arr[$arr_key].fath_birthyear}}</����_�X�ͦ~��>
				<����_����y></����_����y>
				<����_�w�J���إ�����y></����_�w�J���إ�����y>
{{assign var=f_is_live value=$data_arr[$arr_key].fath_alive}}
				<����_�s�\>{{$is_live_arr[$f_is_live]}}</����_�s�\>
{{assign var=f_rela value=$data_arr[$arr_key].fath_relation}}
				<�P�����Y>{{$f_rela_arr[$f_rela]}}</�P�����Y>
				<����_�����Ҹ�>{{$data_arr[$arr_key].fath_p_id}}</����_�����Ҹ�>
{{assign var=f_edu value=$data_arr[$arr_key].fath_education}}
				<����_�Ш|�{��>{{$edu_kind_arr[$f_edu]}}</����_�Ш|�{��>
{{assign var=f_grad_kind value=$data_arr[$arr_key].fath_grad_kind}}
				<����_���׷~�O>{{$grad_kind_arr[$f_grad_kind]}}</����_���׷~�O>
				<����_¾�~>{{$data_arr[$arr_key].fath_occupation}}</����_¾�~>
				<����_�A�ȳ��>{{$data_arr[$arr_key].fath_unit}}</����_�A�ȳ��>
				<����_¾��>{{$data_arr[$arr_key].fath_work_name}}</����_¾��>
				<����_�q�ܸ��X-��>{{$data_arr[$arr_key].fath_phone}}</����_�q�ܸ��X-��>
				<����_�q�ܸ��X-�v>{{$data_arr[$arr_key].fath_home_phone}}</����_�q�ܸ��X-�v>
				<����_��ʹq��>{{$data_arr[$arr_key].fath_hand_phone}}</����_��ʹq��>
				<����_�q�l�l��H�c>{{$data_arr[$arr_key].fath_email}}</����_�q�l�l��H�c>
			</���˰򥻸��>
			<���˰򥻸��>
				<����_�m�W>{{$data_arr[$arr_key].moth_name}}</����_�m�W>
				<����_�X�ͦ~��>{{$data_arr[$arr_key].moth_birthyear}}</����_�X�ͦ~��>
				<����_����y></����_����y>
				<����_�w�J���إ�����y></����_�w�J���إ�����y>
{{assign var=m_is_live value=$data_arr[$arr_key].moth_alive}}
				<����_�s�\>{{$is_live_arr[$m_is_live]}}</����_�s�\>
{{assign var=m_rela value=$data_arr[$arr_key].moth_relation}}
				<�P�����Y>{{$m_rela_arr[$m_rela]}}</�P�����Y>
				<����_�����Ҹ�>{{$data_arr[$arr_key].moth_p_id}}</����_�����Ҹ�>
{{assign var=m_edu value=$data_arr[$arr_key].moth_education}}
				<����_�Ш|�{��>{{$edu_kind_arr[$m_edu]}}</����_�Ш|�{��>
{{assign var=m_grad_kind value=$data_arr[$arr_key].moth_grad_kind}}
				<����_���׷~�O>{{$grad_kind_arr[$m_grad_kind]}}</����_���׷~�O>
				<����_¾�~>{{$data_arr[$arr_key].moth_occupation}}</����_¾�~>
				<����_�A�ȳ��>{{$data_arr[$arr_key].moth_unit}}</����_�A�ȳ��>
				<����_¾��>{{$data_arr[$arr_key].moth_work_name}}</����_¾��>
				<����_�q�ܸ��X-��>{{$data_arr[$arr_key].moth_phone}}</����_�q�ܸ��X-��>
				<����_�q�ܸ��X-�v>{{$data_arr[$arr_key].moth_home_phone}}</����_�q�ܸ��X-�v>
				<����_��ʹq��>{{$data_arr[$arr_key].moth_hand_phone}}</����_��ʹq��>
				<����_�q�l�l��H�c>{{$data_arr[$arr_key].moth_email}}</����_�q�l�l��H�c>
			</���˰򥻸��>
			<�����򥻸��>
				<����_�m�W>{{$data_arr[$arr_key].grandfath_name}}</����_�m�W>
{{assign var=gf_is_live value=$data_arr[$arr_key].grandfath_alive}}
				<����_�s�\>{{$is_live_arr[$gf_is_live]}}</����_�s�\>
			</�����򥻸��>
			<�����򥻸��>
				<����_�m�W>{{$data_arr[$arr_key].grandmoth_name}}</����_�m�W>
{{assign var=gm_is_live value=$data_arr[$arr_key].grandmoth_alive}}
				<����_�s�\>{{$is_live_arr[$gm_is_live]}}</����_�s�\>
			</�����򥻸��>
			<���@�H>
				<���@�H_�m�W>{{$data_arr[$arr_key].guardian_name}}</���@�H_�m�W>
{{assign var=g_rela value=$data_arr[$arr_key].guardian_relation}}
				<�P���@�H�����Y>{{$g_rela_arr[$m_rela]}}</�P���@�H�����Y>
				<���@�H_�����Ҹ�>{{$data_arr[$arr_key].guardian_p_id}}</���@�H_�����Ҹ�>
				<���@�H_�a�}>{{$data_arr[$arr_key].guardian_address}}</���@�H_�a�}>
				<���@�H_�A�ȳ��>{{$data_arr[$arr_key].guardian_unit}}</���@�H_�A�ȳ��>
				<���@�H_¾��>{{$data_arr[$arr_key].grandmoth_name}}</���@�H_¾��>
				<���@�H_�s���q��>{{$data_arr[$arr_key].guardian_phone}}</���@�H_�s���q��>
				<���@�H_��ʹq��>{{$data_arr[$arr_key].guardian_hand_phone}}</���@�H_��ʹq��>
				<���@�H_�q�l�l��H�c>{{$data_arr[$arr_key].guardian_email}}</���@�H_�q�l�l��H�c>
			</���@�H>
			<�S�̩n�f>
{{assign var=bs_arr value=$data_arr[$arr_key].bro_sis}}
{{foreach from=$bs_arr item=bs key=bs_key}}
				<�S�̩n�f_��Ƥ��e>
{{assign var=bs_calling value=$bs_arr[$bs_key].bs_calling}}
					<�S�̩n�f_�ٿ�>{{$bs_calling_kind_arr[$bs_calling]}}</�S�̩n�f_�ٿ�>
					<�S�̩n�f_�m�W>{{$bs_arr[$bs_key].bs_name}}</�S�̩n�f_�m�W>
				</�S�̩n�f_��Ƥ��e>
{{/foreach}}
			</�S�̩n�f>
			<��L����>
{{assign var=kin_arr value=$data_arr[$arr_key].kinfolk}}
{{foreach from=$kin_arr item=kin key=kin_key}}
				<��L����_��Ƥ��e>
					<��L����_�m�W>{{$kin_arr[$kin_key].kin_name}}</��L����_�m�W>
{{assign var=kin_calling value=$kin_arr[$kin_key].kin_calling}}
					<��L����_�ٿ�>{{$g_rela_arr[$kin_calling]}}</��L����_�ٿ�>
					<��L����_�s���q��>{{$kin_arr[$kin_key].kin_phone}}</��L����_�s���q��>
					<��L����_��ʹq��>{{$kin_arr[$kin_key].kin_hand_phone}}</��L����_��ʹq��>
					<��L����_�q�l�l��H�c>{{$kin_arr[$kin_key].kin_email}}</��L����_�q�l�l��H�c>
				</��L����_��Ƥ��e>
{{/foreach}}
			</��L����>
		</�򥻸��>
		<�Ǵ����>
{{assign var=semester_arr value=$data_arr[$arr_key].semester}}
{{foreach from=$semester_arr item=semester key=semester_key}}
			<�ӧO�Ǵ����>
				<�Ǧ~�O>{{$semester_arr[$semester_key].year}}</�Ǧ~�O>
				<�Ǵ��O>{{$semester_arr[$semester_key].semester}}</�Ǵ��O>
				<�Z�Ůy��>
{{assign var=study_year value=$semester_arr[$semester_key].study_year}}
					<�~��>{{$study_year}}</�~��>
					<�Z��>{{$semester_arr[$semester_key].seme_class_name}}</�Z��>
					<�y��>{{$semester_arr[$semester_key].seme_num}}</�y��>
				</�Z�Ůy��>
				<�Ǵ����Z>
					<�ɮv�m�W>{{$semester_arr[$semester_key].teacher}}</�ɮv�m�W>
					<�y��_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.language.$semester_key.score}}</�y��_�ǲ߻��ʤ���Z>
					<�y��_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.chinese}};{{$data_arr[$arr_key].semester_score_memo.$semester_key.local}};{{$data_arr[$arr_key].semester_score_memo.$semester_key.english}}</�y��_�ǲ߻���r�y�z>
					<����y��ʤ���Z>{{$data_arr[$arr_key].semester_score.chinese.$semester_key.score}}</����y��ʤ���Z>
					<���g�y��ʤ���Z>{{$data_arr[$arr_key].semester_score.local.$semester_key.score}}</���g�y��ʤ���Z>
					<���g�y�����O></���g�y�����O>
					<�^�y�ʤ���Z>{{$data_arr[$arr_key].semester_score.english.$semester_key.score}}</�^�y�ʤ���Z>
					<�ƾ�_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.math.$semester_key.score}}</�ƾ�_�ǲ߻��ʤ���Z>
					<�ƾ�_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.math}}</�ƾ�_�ǲ߻���r�y�z>
					<�۵M�P�ͬ����_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.nature.$semester_key.score}}</�۵M�P�ͬ����_�ǲ߻��ʤ���Z>
					<�۵M�P�ͬ����_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.nature}}</�۵M�P�ͬ����_�ǲ߻���r�y�z>
					<���|_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.social.$semester_key.score}}</���|_�ǲ߻��ʤ���Z>
					<���|_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.social}}</���|_�ǲ߻���r�y�z>
					<���d�P��|_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.health.$semester_key.score}}</���d�P��|_�ǲ߻��ʤ���Z>
					<���d�P��|_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.health}}</���d�P��|_�ǲ߻���r�y�z>
					<���N�P�H��_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.art.$semester_key.score}}</���N�P�H��_�ǲ߻��ʤ���Z>
					<���N�P�H��_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.art}}</���N�P�H��_�ǲ߻���r�y�z>
					<�ͬ��ҵ{_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.life.$semester_key.score}}</�ͬ��ҵ{_�ǲ߻��ʤ���Z>
					<�ͬ��ҵ{_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.life}}</�ͬ��ҵ{_�ǲ߻���r�y�z>
					<��X����_�ǲ߻��ʤ���Z>{{$data_arr[$arr_key].semester_score.complex.$semester_key.score}}</��X����_�ǲ߻��ʤ���Z>
					<��X����_�ǲ߻���r�y�z>{{$data_arr[$arr_key].semester_score_memo.$semester_key.complex}}</��X����_�ǲ߻���r�y�z>
					<�u�ʮɼ�>
{{assign var=semester_elasticity_arr value=$data_arr[$arr_key].semester_score_memo.$semester_key.elasticity}}
{{foreach from=$semester_elasticity_arr item=elasticity_data key=subject_id}}
						<�u�ʮɼ�_�������>
							<�u�ʮɼ�_��ئW��>{{$elasticity_data.subject_name}}</�u�ʮɼ�_��ئW��>
							<�u�ʮɼ�_��ئʤ���Z>{{$elasticity_data.score}}</�u�ʮɼ�_��ئʤ���Z>
						</�u�ʮɼ�_�������>
{{/foreach}}
					</�u�ʮɼ�>
				</�Ǵ����Z>
				<��`�ͬ���{>
					<��`�ͬ���{_��r�y�z>{{$data_arr[$arr_key].semester_score_nor.$semester_key.ss_score_memo}}</��`�ͬ���{_��r�y�z>
					<�Ǵ��X�ʮu_���X�u���>{{$seme_course_date_arr[$semester_key].$study_year}}</�Ǵ��X�ʮu_���X�u���>
					<�Ǵ��X�ʮu_�ư���>{{$data_arr[$arr_key].semester_absence.$semester_key.1}}</�Ǵ��X�ʮu_�ư���>
					<�Ǵ��X�ʮu_�f����>{{$data_arr[$arr_key].semester_absence.$semester_key.2}}</�Ǵ��X�ʮu_�f����>
					<�Ǵ��X�ʮu_�m�Ҽ�>{{$data_arr[$arr_key].semester_absence.$semester_key.3}}</�Ǵ��X�ʮu_�m�Ҽ�>
					<�Ǵ��X�ʮu_��L����>{{$data_arr[$arr_key].semester_absence.$semester_key.others}}</�Ǵ��X�ʮu_��L����>
					<�Ǵ��X�ʮu_���>{{if $jhores>=6}}�`{{else}}��{{/if}}</�Ǵ��X�ʮu_���>
				</��`�ͬ���{>
				<�S���u�}��{>
{{assign var=semester_spe_arr value=$data_arr[$arr_key].semester_spe.$semester_key}}
{{foreach from=$semester_spe_arr item=semester_spe_data key=ss_id}}
					<�u�}��{����>
						<�u�}��{_���>{{$semester_spe_data.sp_date}}</�u�}��{_���>
						<�u�}��{_�ƥ�>{{$semester_spe_data.sp_memo}}</�u�}��{_�ƥ�>
					</�u�}��{����>
{{/foreach}}
				</�S���u�}��{>
				<�߲z����>
{{assign var=psy_test_arr value=$data_arr[$arr_key].psy_test.$semester_key}}
{{foreach from=$psy_test_arr item=psy_test_data key=sn}}
					<�߲z����_��Ƥ��e>
						<�߲z����_�W��>{{$psy_test_data.item}}</�߲z����_�W��>
						<�߲z����_��l����>{{$psy_test_data.score}}</�߲z����_��l����>
						<�߲z����_�`�Ҽ˥�>{{$psy_test_data.model}}</�߲z����_�`�Ҽ˥�>
						<�߲z����_�зǤ���>{{$psy_test_data.standard}}</�߲z����_�зǤ���>
						<�߲z����_�ʤ�����>{{$psy_test_data.pr}}</�߲z����_�ʤ�����>
						<�߲z����_����>{{$psy_test_data.explanation}}</�߲z����_����>
					</�߲z����_��Ƥ��e>
{{/foreach}}
				</�߲z����>
				<���ɬ���>
					<�������Y>{{$data_arr[$arr_key].semester_eduh.$semester_key.sse_relation}}</�������Y>
					<�a�x��^>{{$data_arr[$arr_key].semester_eduh.$semester_key.sse_family_air}}</�a�x��^>
					<���ޱФ覡>{{$data_arr[$arr_key].semester_eduh.$semester_key.sse_father}}</���ޱФ覡>
					<���ޱФ覡>{{$data_arr[$arr_key].semester_eduh.$semester_key.sse_mother}}</���ޱФ覡>
					<�~����>{{$data_arr[$arr_key].semester_eduh.$semester_key.sse_live_state}}</�~����>
					<�g�٪��p>{{$data_arr[$arr_key].semester_eduh.$semester_key.sse_rich_state}}</�g�٪��p>
					<�̳߷R�ǲ߻��>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s1 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�̳߷R�ǲ߻��_��Ƥ��e>{{$sse_data}}</�̳߷R�ǲ߻��_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�̳߷R�ǲ߻��>
					<�̧x���ǲ߻��>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s2 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�̧x���ǲ߻��_��Ƥ��e>{{$sse_data}}</�̧x���ǲ߻��_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�̧x���ǲ߻��>
					<�S��~��>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s3 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�S��~��_��Ƥ��e>{{$sse_data}}</�S��~��_��Ƥ��e>
{{/if}}
{{/foreach}}
						<�Z�N_��L></�Z�N_��L>
						<�־��t��_��L></�־��t��_��L>
					</�S��~��>
					<����>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s4 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<����_��Ƥ��e>{{$sse_data}}</����_��Ƥ��e>
{{/if}}
{{/foreach}}
					</����>
					<�ͬ��ߺD>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s5 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�ͬ��ߺD_��Ƥ��e>{{$sse_data}}</�ͬ��ߺD_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�ͬ��ߺD>
					<�H�����Y>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s6 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�H�����Y_��Ƥ��e>{{$sse_data}}</�H�����Y_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�H�����Y>
					<�~�V�欰>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s7 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�~�V�欰_��Ƥ��e>{{$sse_data}}</�~�V�欰_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�~�V�欰>
					<���V�欰>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s8 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<���V�欰_��Ƥ��e>{{$sse_data}}</���V�欰_��Ƥ��e>
{{/if}}
{{/foreach}}
					</���V�欰>
					<�ǲߦ欰>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s9 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�ǲߦ欰_��Ƥ��e>{{$sse_data}}</�ǲߦ欰_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�ǲߦ欰>
					<���}�ߺD>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s10 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<���}�ߺD_��Ƥ��e>{{$sse_data}}</���}�ߺD_��Ƥ��e>
{{/if}}
{{/foreach}}
					</���}�ߺD>
					<�J�{�欰>
{{foreach from=$data_arr[$arr_key].semester_eduh.$semester_key.sse_s11 item=sse_data key=sn}}
{{if $sse_data<>""}}
						<�J�{�欰_��Ƥ��e>{{$sse_data}}</�J�{�欰_��Ƥ��e>
{{/if}}
{{/foreach}}
					</�J�{�欰>
				</���ɬ���>
				<���ɳX�ͬ���>
{{foreach from=$data_arr[$arr_key].semester_talk.$semester_key item=talk_data key=sn}}
					<���ɳX�ͬ���_��Ƥ��e>
						<�������>{{$talk_data.sst_date}}</�������>
						<�s����H>{{$talk_data.sst_name}}</�s����H>
						<�s���ƶ�>{{$talk_data.sst_main}}</�s���ƶ�>
						<���e�n�I>{{$talk_data.sst_memo}}</���e�n�I>
					</���ɳX�ͬ���_��Ƥ��e>
{{/foreach}}
				</���ɳX�ͬ���>
			</�ӧO�Ǵ����>
{{/foreach}}
		</�Ǵ����>
		<���ʸ��>
{{foreach from=$data_arr[$arr_key].stud_move item=move_data key=move_id}}
			<���ʸ��_��Ƥ��e>
				<��NŪ����>{{$move_data.move_c_unit}}</��NŪ����>
				<��NŪ�ǮզW��>{{$move_data.school}}</��NŪ�ǮզW��>
				<��NŪ�ǮեN�X></��NŪ�ǮեN�X>
				<���ʤ��>{{$move_data.move_date}}</���ʤ��>
				<���ʮ֭�����W��>{{$move_data.move_c_unit}}</���ʮ֭�����W��>
				<���ʭ�]>{{$move_data.move_kind}}</���ʭ�]>
				<�֭�帹_���>{{$move_data.move_c_date}}</�֭�帹_���>
				<�֭�帹_�r>{{$move_data.move_c_word}}</�֭�帹_�r>
				<�֭�帹_��>{{$move_data.move_c_num}}</�֭�帹_��>
			</���ʸ��_��Ƥ��e>
{{/foreach}}
		</���ʸ��>
		<�������>
			<�����ʮu>
				<�����`�ʮu_�ư���>{{$data_arr[$arr_key].absent.$semester_key.summary.1}}</�����`�ʮu_�ư���>
				<�����`�ʮu_�f����>{{$data_arr[$arr_key].absent.$semester_key.summary.2}}</�����`�ʮu_�f����>
				<�����`�ʮu_�m�Ҽ�>{{$data_arr[$arr_key].absent.$semester_key.summary.3}}</�����`�ʮu_�m�Ҽ�>
				<�����`�ʮu_��L����>{{$data_arr[$arr_key].absent.$semester_key.summary.others}}</�����`�ʮu_��L����>
				<�����`�ʮu_���>��</�����`�ʮu_���>
				<�����ʮu_��Ƥ��e>
{{foreach from=$data_arr[$arr_key].absent.$semester_key.monthly item=monthly_data key=monthly_id}}
					<�����ʮu_������>
						<�����ʮu_�~>{{$monthly_data.year}}</�����ʮu_�~>
						<�����ʮu_��>{{$monthly_data.month}}</�����ʮu_��>
						<�����ʮu_�ư���>{{$monthly_data.1}}</�����ʮu_�ư���>
						<�����ʮu_�f����>{{$monthly_data.2}}</�����ʮu_�f����>
						<�����ʮu_�m�Ҽ�>{{$monthly_data.3}}</�����ʮu_�m�Ҽ�>
						<�����ʮu_��L����>{{$monthly_data.others}}</�����ʮu_��L����>
					</�����ʮu_������>
{{/foreach}}
				</�����ʮu_��Ƥ��e>
			</�����ʮu>
			<�������Z>
				<�������Z_�y��>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.language item=language_data key=language_id}}
					<�������Z_�y���Ƥ��e>
						<�������Z_�y����q�ҧO>{{$language_id}}</�������Z_�y����q�ҧO>
						<�������Z_����y��ʤ���Z>{{$language_data.chinese}}</�������Z_����y��ʤ���Z>
						<�������Z_���g�y��ʤ���Z>{{$language_data.local}}</�������Z_���g�y��ʤ���Z>
						<�������Z_�^�y�ʤ���Z>{{$language_data.english}}</�������Z_�^�y�ʤ���Z>
					</�������Z_�y���Ƥ��e>
{{/foreach}}
				</�������Z_�y��>
				<�������Z_�ƾ�>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.math item=math_data key=math_id}}
					<�������Z_�ƾǸ�Ƥ��e>
						<�������Z_�ƾǻ��q�ҧO>{{$math_id}}</�������Z_�ƾǻ��q�ҧO>
						<�������Z_�ƾǻ��ʤ���Z>{{$math_data.area_score.average}}</�������Z_�ƾǻ��ʤ���Z>
					</�������Z_�ƾǸ�Ƥ��e>
{{/foreach}}
				</�������Z_�ƾ�>
				<�������Z_�۵M�P�ͬ����>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.nature item=nature_data key=nature_id}}
					<�������Z_�۵M�P�ͬ���޸�Ƥ��e>
						<�������Z_�۵M�P�ͬ���޻��q�ҧO>{{$nature_id}}</�������Z_�۵M�P�ͬ���޻��q�ҧO>
						<�������Z_�۵M�P�ͬ���޻��ʤ���Z>{{$nature_data.area_score.average}}</�������Z_�۵M�P�ͬ���޻��ʤ���Z>
					</�������Z_�۵M�P�ͬ���޸�Ƥ��e>
{{/foreach}}
				</�������Z_�۵M�P�ͬ����>
				<�������Z_���|>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.social item=social_data key=social_id}}
					<�������Z_���|��Ƥ��e>
						<�������Z_���|���q�ҧO>{{$social_id}}</�������Z_���|���q�ҧO>
						<�������Z_���|���ʤ���Z>{{$social_data.area_score.average}}</�������Z_���|���ʤ���Z>
					</�������Z_���|��Ƥ��e>
{{/foreach}}
				</�������Z_���|>
				<�������Z_���d�P��|>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.health item=health_data key=health_id}}
					<�������Z_���d�P��|��Ƥ��e>
						<�������Z_���d�P��|���q�ҧO>{{$health_id}}</�������Z_���d�P��|���q�ҧO>
						<�������Z_���d�P��|���ʤ���Z>{{$health_data.area_score.average}}</�������Z_���d�P��|���ʤ���Z>
					</�������Z_���d�P��|��Ƥ��e>
{{/foreach}}
				</�������Z_���d�P��|>
				<�������Z_���N�P�H��>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.art item=art_data key=art_id}}
					<�������Z_���N�P�H���Ƥ��e>
						<�������Z_���N�P�H����q�ҧO>{{$art_id}}</�������Z_���N�P�H����q�ҧO>
						<�������Z_���N�P�H����ʤ���Z>{{$art_data.area_score.average}}</�������Z_���N�P�H����ʤ���Z>
					</�������Z_���N�P�H���Ƥ��e>
{{/foreach}}
				</�������Z_���N�P�H��>
				<�������Z_�ͬ��ҵ{>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.life item=life_data key=life_id}}
					<�������Z_�ͬ��ҵ{��Ƥ��e>
						<�������Z_�ͬ��ҵ{���q�ҧO>{{$life_id}}</�������Z_�ͬ��ҵ{���q�ҧO>
						<�������Z_�ͬ��ҵ{���ʤ���Z>{{$life_data.area_score.average}}</�������Z_�ͬ��ҵ{���ʤ���Z>
					</�������Z_�ͬ��ҵ{��Ƥ��e>
{{/foreach}}
				</�������Z_�ͬ��ҵ{>
				<�������Z_��X����>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.complex item=complex_data key=complex_id}}
					<�������Z_��X���ʸ�Ƥ��e>
						<�������Z_��X���ʻ��q�ҧO>{{$complex_id}}</�������Z_��X���ʻ��q�ҧO>
						<�������Z_��X���ʻ��ʤ���Z>{{$complex_data.area_score.average}}</�������Z_��X���ʻ��ʤ���Z>
					</�������Z_��X���ʸ�Ƥ��e>
{{/foreach}}
				</�������Z_��X����>
				<�������Z_�u�ʤ������>
{{foreach from=$data_arr[$arr_key].this_semester_score.$semester_key.elasticity item=elasticity_data key=elasticity_id}}
					<�������Z_�u�ʮɼ�>
						<�������Z_�u�ʮɼƬ�ئW��>{{$elasticity_data.subject_name}}</�������Z_�u�ʮɼƬ�ئW��>
						<�������Z_�u�ʮɼƬ�ئʤ���Z>{{$elasticity_data.score}}</�������Z_�u�ʮɼƬ�ئʤ���Z>
					</�������Z_�u�ʮɼ�>
{{/foreach}}
				</�������Z_�u�ʤ������>
			</�������Z>
			<�������g>
{{foreach from=$data_arr[$arr_key].reward.$semester_key item=reward_data key=reward_id}}
				<�������g����>
					<�������g_���>{{$reward_data.reward_date}}</�������g_���>
					<�������g_���O>{{$reward_data.kind}}</�������g_���O>
					<�������g_����>{{$reward_data.amount}}</�������g_����>
					<�������g_�ƥ�>{{$reward_data.reward_reason}}</�������g_�ƥ�>
				</�������g����>
{{/foreach}}
			</�������g>
			<���ά���>
				<���ά��ʤ��e>
					<���ΦW��>null</���ΦW��>
					<���ά��ʦ��Z>null</���ά��ʦ��Z>
				</���ά��ʤ��e>
			</���ά���>
		</�������>
{{if $smarty.post.career}}
		<�ͲP���ɬ���>
			<�ڪ������G��>
				<�ۧڻ{��>
{{assign var=career_self value=$data_arr[$arr_key].career.self}}
{{foreach from=$career_self item=grade_data key=grade}}
					<�ۧڻ{��_��Ƥ��e>
						<�~��>{{$grade}}</�~��>
						<�ө�>
{{foreach from=$grade_data.personality item=item_data key=item_id}}
							<�ө�_��Ƥ��e>
								<����>{{$item_data}}</����>
							</�ө�_��Ƥ��e>
{{/foreach}}
						</�ө�>
						<�𶢿���>
{{foreach from=$grade_data.interest item=item_data key=item_id}}
							<�𶢿���_��Ƥ��e>
								<����>{{$item_data}}</����>
							</�𶢿���_��Ƥ��e>
{{/foreach}}
							</�𶢿���>
						<�M��>
{{foreach from=$grade_data.specialty item=item_data key=item_id}}
							<�M��_��Ƥ��e>
								<����>{{$item_data}}</����>
							</�M��_��Ƥ��e>
{{/foreach}}
						</�M��>
					</�ۧڻ{��_��Ƥ��e>
{{/foreach}}
				</�ۧڻ{��>
				<¾�~�P��>
{{assign var=career_job value=$data_arr[$arr_key].career.job}}
{{foreach from=$career_job item=grade_data key=grade}}
					<¾�~�P��_��Ƥ��e>
						<�~��>{{$grade}}</�~��>
						<��ĳ���ӥi��ܪ�¾�~>{{$career_job.$grade.suggestion.1}}</��ĳ���ӥi��ܪ�¾�~>
						<����ĳ���H>{{$career_job.$grade.suggestion.2}}</����ĳ���H>
						<��ĳ��ܳo��¾�~����]>{{$career_job.$grade.suggestion.3}}</��ĳ��ܳo��¾�~����]>
						<�ڳ̷P���쪺¾�~>{{$career_job.$grade.myown.1}}</�ڳ̷P���쪺¾�~>
						<�ڹ�o¾�~�P���쪺��]>{{$career_job.$grade.myown.2}}</�ڹ�o¾�~�P���쪺��]>
						<�o��¾�~�ݨ�ƪ��Ǿ���O�M���Ψ�L����>{{$career_job.$grade.myown.3}}</�o��¾�~�ݨ�ƪ��Ǿ���O�M���Ψ�L����>
						<�ڷQ�n�i�@�B�F�Ѫ�¾�~>{{$career_job.$grade.others.1}}</�ڷQ�n�i�@�B�F�Ѫ�¾�~>
						<���¾�~�ɭ���������>
{{assign var=weights value=$grade_data.weight}}
{{foreach from=$weights item=item_data key=item_id}}
							<���¾�~�ɭ���������_��Ƥ��e>
								<����������>{{$item_data}}</����������>
							</���¾�~�ɭ���������_��Ƥ��e>
{{/foreach}}
						</���¾�~�ɭ���������>
					</¾�~�P��_��Ƥ��e>
{{/foreach}}
				</¾�~�P��>
			</�ڪ������G��>
			<�U���߲z����>
{{assign var=career_psy value=$data_arr[$arr_key].career.psy}}
{{foreach from=$career_psy item=psy_data key=sn}}
				<�U���߲z����_��Ƥ��e>
					<�������O>{{$psy_data.id}}</�������O>
					<����W��>{{$psy_data.title}}</����W��>
					<���絲�G>
{{foreach from=$psy_data.item item=item_data key=item_key}}
						<���絲�G_��Ƥ��e>
							<�����綵��>{{$item_key}}</�����綵��>
							<�ʤ����ũμзǤ���>{{$item_data}}</�ʤ����ũμзǤ���>
						</���絲�G_��Ƥ��e>
{{/foreach}}
						<�A�X�NŪ���Ǯ����O�M��O>{{$psy_data.study}}</�A�X�NŪ���Ǯ����O�M��O>
						<�A�X�q�ƪ��u�@���O>{{$psy_data.job}}</�A�X�q�ƪ��u�@���O>
					</���絲�G>
				</�U���߲z����_��Ƥ��e>
{{/foreach}}
			</�U���߲z����>

			<�ǲߦ��G�ίS���{>
				<�ڪ��ǲߪ�{>
					<���ǲߦ��Z>
{{assign var=semester_arr value=$data_arr[$arr_key].semester}}
{{foreach from=$semester_arr item=semester key=semester_key}}
{{assign var=study_year value=$semester_arr[$semester_key].study_year}}
{{assign var=study_seme value=$semester_arr[$semester_key].semester}}
						<���ǲߦ��Z_��Ƥ��e>
							<�~��>{{$study_year}}</�~��>
							<�Ǵ�>{{$study_seme}}</�Ǵ�>
							<�y����_���>{{$data_arr[$arr_key].semester_score.chinese.$semester_key.score}}</�y����_���>
							<�y����_�^�y>{{$data_arr[$arr_key].semester_score.english.$semester_key.score}}</�y����_�^�y>
							<�ƾǻ��>{{$data_arr[$arr_key].semester_score.math.$semester_key.score}}</�ƾǻ��>
							<���|���>{{$data_arr[$arr_key].semester_score.social.$semester_key.score}}</���|���>
							<�۵M�P�ͬ���޻��>{{$data_arr[$arr_key].semester_score.nature.$semester_key.score}}</�۵M�P�ͬ���޻��>
							<���N�P�H����>{{$data_arr[$arr_key].semester_score.art.$semester_key.score}}</���N�P�H����>
							<���d�P��|���>{{$data_arr[$arr_key].semester_score.health.$semester_key.score}}</���d�P��|���>
							<��X���ʻ��>{{$data_arr[$arr_key].semester_score.complex.$semester_key.score}}</��X���ʻ��>
							<�ۧڬ٫�>{{$data_arr[$arr_key].career.ponder.3.1.$study_year.$study_seme}}</�ۧڬ٫�>
						</���ǲߦ��Z_��Ƥ��e>
{{/foreach}}
					</���ǲߦ��Z>
					<�Ш|�|�Ҫ�{>
						<���>{{$data_arr[$arr_key].career.exam.c}}</���>
						<�ƾ�>{{$data_arr[$arr_key].career.exam.m}}</�ƾ�>
						<�^�y>{{$data_arr[$arr_key].career.exam.e}}</�^�y>
						<���|>{{$data_arr[$arr_key].career.exam.s}}</���|>
						<�۵M>{{$data_arr[$arr_key].career.exam.n}}</�۵M>
						<�g�@����>{{$data_arr[$arr_key].career.exam.w}}</�g�@����>
					</�Ш|�|�Ҫ�{>
					<��A���˴���{>
{{assign var=career_fitness value=$data_arr[$arr_key].career.fitness}}
{{foreach from=$career_fitness item=fitness_data key=id}}
						<��A���˴���{_��Ƥ��e>
							<�˴����>{{$fitness_data.organization}}</�˴����>
							<�˴����>{{$fitness_data.test_y}}-{{$fitness_data.test_m}}-01</�˴����>
							<�˴��ɦ~��>{{$fitness_data.age}}</�˴��ɦ~��>
							<����>{{$fitness_data.tall}}</����>
							<�魫>{{$fitness_data.weigh}}</�魫>
							<�����q����>{{$fitness_data.bmt}}</�����q����>
							<������e�s>
								<�˴����Z>{{$fitness_data.test1}}</�˴����Z>
								<�ʤ�����>{{$fitness_data.prec1}}</�ʤ�����>
							</������e�s>
							<�ߩw����>
								<�˴����Z>{{$fitness_data.test3}}</�˴����Z>
								<�ʤ�����>{{$fitness_data.prec3}}</�ʤ�����>
							</�ߩw����>
							<���װ_��>
								<�˴����Z>{{$fitness_data.test2}}</�˴����Z>
								<�ʤ�����>{{$fitness_data.prec2}}</�ʤ�����>
							</���װ_��>
							<�ߪ;A��>
								<�˴����Z>{{$fitness_data.test4}}</�˴����Z>
								<�ʤ�����>{{$fitness_data.prec4}}</�ʤ�����>
							</�ߪ;A��>
						</��A���˴���{_��Ƥ��e>
{{/foreach}}
					</��A���˴���{>
				</�ڪ��ǲߪ�{>
				<�ڪ��g��>
					<�F��>
{{assign var=semester_arr value=$data_arr[$arr_key].semester}}
{{foreach from=$semester_arr item=semester key=semester_key}}
{{assign var=study_year value=$semester_arr[$semester_key].study_year}}
{{assign var=study_seme value=$semester_arr[$semester_key].semester}}
						<�F��_��Ƥ��e>
							<�~��>{{$study_year}}</�~��>
							<�Ǵ�>{{$study_seme}}</�Ǵ�>
							<�F���W��>
{{assign var=cadre_arr value=$data_arr[$arr_key].career.ponder.3.2.$study_year.$study_seme.1}}
{{foreach from=$cadre_arr item=cadre key=cadre_key}}
								<�F���W��_��Ƥ��e>
									<�W��>{{$cadre}}</�W��>
								</�F���W��_��Ƥ��e>
{{/foreach}}
							</�F���W��>
							<�p�Ѯv>
{{assign var=lt_arr value=$data_arr[$arr_key].career.ponder.3.2.$study_year.$study_seme.2}}
{{foreach from=$lt_arr item=lt key=lt_key}}
								<�p�Ѯv_��Ƥ��e>
									<�W��>{{$lt}}</�W��>
								</�p�Ѯv_��Ƥ��e>
{{/foreach}}
							</�p�Ѯv>
							<�ۧڬ٫�>{{$data_arr[$arr_key].career.ponder.3.2.$study_year.$study_seme.data}}</�ۧڬ٫�>
						</�F��_��Ƥ��e>
{{/foreach}}
					</�F��>
					<����>
{{assign var=association_arr value=$data_arr[$arr_key].career.association}}
{{foreach from=$association_arr item=association key=sn}}
						<����_��Ƥ��e>
							<�~��>{{$association.grade}}</�~��>
							<�Ǵ�>{{$association.semester}}</�Ǵ�>
							<���ΦW��>{{$association.association_name}}</���ΦW��>
							<���¾��>{{$association.stud_post}}</���¾��>
							<�ۧڬ٫�>{{$association.stud_feedback}}</�ۧڬ٫�>
						</����_��Ƥ��e>
{{/foreach}}
					</����>
				</�ڪ��g��>
				<�ѻP�U���v�ɦ��G>
{{assign var=race_arr value=$data_arr[$arr_key].career.race}}
{{foreach from=$race_arr item=race key=sn}}
					<�ѻP�U���v�ɦ��G_��Ƥ��e>
						<�d��>{{$race.level}}</�d��>
						<�ʽ�>{{$race.squad}}</�ʽ�>
						<�v�ɦW��>{{$race.name}}</�v�ɦW��>
						<�o���W��>{{$race.rank}}</�o���W��>
						<�ҮѤ��>{{$race.certificate_date}}</�ҮѤ��>
						<�D����>{{$race.sponsor}}</�D����>
						<�Ƶ�>{{$race.memo}}</�Ƶ�>
					</�ѻP�U���v�ɦ��G_��Ƥ��e>
{{/foreach}}
				</�ѻP�U���v�ɦ��G>
				<�欰��{���g����>
{{assign var=semester_arr value=$data_arr[$arr_key].semester}}
{{foreach from=$semester_arr item=semester key=semester_key}}
{{assign var=study_year value=$semester_arr[$semester_key].study_year}}
{{assign var=study_seme value=$semester_arr[$semester_key].semester}}
					<�欰��{���g����_��Ƥ��e>
						<�~��>{{$study_year}}</�~��>
						<�Ǵ�>{{$study_seme}}</�Ǵ�>
						<���g����>
							<���y>
								<�ż�>{{$data_arr[$arr_key].career.reward_effective.$study_year.$study_seme.1}}</�ż�>
								<�p�\>{{$data_arr[$arr_key].career.reward_effective.$study_year.$study_seme.3}}</�p�\>
								<�j�\>{{$data_arr[$arr_key].career.reward_effective.$study_year.$study_seme.9}}</�j�\>
							</���y>
							<�g�B>
								<ĵ�i>{{$data_arr[$arr_key].career.reward_effective.$study_year.$study_seme.a}}</ĵ�i>
								<�p�L>{{$data_arr[$arr_key].career.reward_effective.$study_year.$study_seme.b}}</�p�L>
								<�j�L>{{$data_arr[$arr_key].career.reward_effective.$study_year.$study_seme.c}}</�j�L>
							</�g�B>
						</���g����>
						<�P�L����>
							<ĵ�i>{{$data_arr[$arr_key].career.reward_canceled.$study_year.$study_seme.a}}</ĵ�i>
							<�p�L>{{$data_arr[$arr_key].career.reward_canceled.$study_year.$study_seme.b}}</�p�L>
							<�j�L>{{$data_arr[$arr_key].career.reward_canceled.$study_year.$study_seme.c}}</�j�L>
						</�P�L����>
						<�ۧڬ٫�>{{$data_arr[$arr_key].career.ponder.3.4.$study_year.$study_seme}}</�ۧڬ٫�>
					</�欰��{���g����_��Ƥ��e>
{{/foreach}}
				</�欰��{���g����>
				<�A�Ⱦǲ߬���>
{{assign var=service_arr value=$data_arr[$arr_key].career.service}}
{{foreach from=$service_arr item=service key=sn}}
					<�A�Ⱦǲ߬���_��Ƥ��e>
						<�~��>{{$service.grade}}</�~��>
						<�Ǵ�>{{$service.semester}}</�Ǵ�>
						<�A�Ȥ��>{{$service.service_date}}</�A�Ȥ��>
						<�A�ȶ���>{{$service.item}}</�A�ȶ���>
						<�ɼ�>{{$service.hours}}</�ɼ�>
						<�D����>{{$service.sponsor}}</�D����>
						<�ۧڬ٫�>{{$service.feedback}}</�ۧڬ٫�>
					</�A�Ⱦǲ߬���_��Ƥ��e>
{{/foreach}}
				</�A�Ⱦǲ߬���>
				<�ͲP�ձ����ʬ���>
{{assign var=explore_arr value=$data_arr[$arr_key].career.explore}}
{{foreach from=$explore_arr item=explore key=sn}}
					<�ͲP�ձ����ʬ���_��Ƥ��e>
						<�~��>{{$explore.grade}}</�~��>
						<�Ǵ�>{{$explore.semester}}</�Ǵ�>
						<�ձ��ǵ{�θs��>{{$explore.course}}</�ձ��ǵ{�θs��>
						<���ʤ覡>{{$explore.activity}}</���ʤ覡>
						<���쪺�{��>{{$explore.degree}}</���쪺�{��>
						<�ۧڬ٫�>{{$explore.ponder}}</�ۧڬ٫�>
					</�ͲP�ձ����ʬ���_��Ƥ��e>
{{/foreach}}
				</�ͲP�ձ����ʬ���>
			</�ǲߦ��G�ίS���{>
			<�ͲP�ξ㭱���[>
				<�ͲP���>
{{assign var=think_arr value=$data_arr[$arr_key].career.think}}
{{foreach from=$think_arr item=think key=id}}
					<�ͲP���_��Ƥ��e>
						<����>{{$id}}</����>
						<���e>{{$think}}</���e>
					</�ͲP���_��Ƥ��e>
{{/foreach}}
				</�ͲP���>
				<�ͲP��V>
					<��ܤ�V>
{{assign var=direction_arr value=$data_arr[$arr_key].career.direction}}
{{foreach from=$direction_arr.item item=direction_item key=id}}
						<��ܤ�V_��Ƥ��e>
							<����>{{$id}}</����>
							<�ۤv���Q�k>{{$direction_item.self}}</�ۤv���Q�k>
							<�a��������>{{$direction_item.parent}}</�a��������>
							<�ǮձЮv����ĳ>{{$direction_item.teacher}}</�ǮձЮv����ĳ>
							<�Ƶ�>{{$direction_item.memo}}</�Ƶ�>
						</��ܤ�V_��Ƥ��e>
{{/foreach}}
					</��ܤ�V>
					<�Q�k�M�a������ΦѮv��ĳ�@�P>{{if $direction_arr.identical}}�O{{else}}�_{{/if}}</�Q�k�M�a������ΦѮv��ĳ�@�P>
					<�O�_�@�P��]>{{$direction_arr.reason}}</�O�_�@�P��]>
					<���椣�P�p�󷾳q>{{$direction_arr.communicate}}</���椣�P�p�󷾳q>
				</�ͲP��V>
				<�Q��Ū���ǵ{�ά�O>
{{assign var=aspiration_arr value=$data_arr[$arr_key].career.aspiration}}
{{foreach from=$aspiration_arr item=aspiration_item key=order}}
					<�Q��Ū���ǵ{�ά�O_��Ƥ��e>
						<�ǮծզW>{{$aspiration_item.school}}</�ǮծզW>
						<�ǵ{�ά�O>{{$aspiration_item.course}}</�ǵ{�ά�O>
						<�a�z��m>{{$aspiration_item.position}}</�a�z��m>
						<��q�覡>{{$aspiration_item.transportation}}</��q�覡>
						<����ɶ�>{{$aspiration_item.transportation_time}}</����ɶ�>
						<���𨮸�>{{$aspiration_item.transportation_toll}}</���𨮸�>			
						<�Ƶ�>{{$aspiration_item.memo}}</�Ƶ�>
					</�Q��Ū���ǵ{�ά�O_��Ƥ��e>
{{/foreach}}
				</�Q��Ū���ǵ{�ά�O>
			</�ͲP�ξ㭱���[>
			<�ͲP�o�i�W����>
				<�ͲP���֪�>
{{foreach from=$aspiration_arr item=aspiration_item key=order}}
{{if $aspiration_item.factor}}
					<�ͲP���֪�_��Ƥ��e>
						<�զW>{{$aspiration_item.school}}</�զW>
						<��O>{{$aspiration_item.course}}</��O>
						<�ӤH�]��>
{{foreach from=$factors.self item=item_data key=item_key}}
							<�ӤH�]��_��Ƥ��e>
								<�Ҽ{�]��>{{$item_data}}</�Ҽ{�]��>
								<�ŦX�{�פ���>{{$aspiration_item.factor.self.$item_key}}</�ŦX�{�פ���>
							</�ӤH�]��_��Ƥ��e>
{{/foreach}}
						</�ӤH�]��>
						<���Ҧ]��>
{{foreach from=$factors.env item=item_data key=item_key}}
							<���Ҧ]��_��Ƥ��e>
								<�Ҽ{�]��>{{$item_data}}</�Ҽ{�]��>
								<�ŦX�{�פ���>{{$aspiration_item.factor.env.$item_key}}</�ŦX�{�פ���>
							</���Ҧ]��_��Ƥ��e>
{{/foreach}}
						</���Ҧ]��>
						<��T�]��>
{{foreach from=$factors.info item=item_data key=item_key}}
							<��T�]��_��Ƥ��e>
								<�Ҽ{�]��>{{$item_data}}</�Ҽ{�]��>
								<�ŦX�{�פ���>{{$aspiration_item.factor.info.$item_key}}</�ŦX�{�פ���>
							</��T�]��_��Ƥ��e>
{{/foreach}}
						</��T�]��>
					</�ͲP���֪�_��Ƥ��e>
{{/if}}
{{/foreach}}
				</�ͲP���֪�>
				<�����߲z���絲�G>
{{assign var=test_arr value=$data_arr[$arr_key].career.test}}
					<�ʦV������Ƴ̰���������>
{{foreach from=$test_arr.1 item=test_item key=item_key}}
						<�ʦV������Ƴ̰���������_��Ƥ��e>
							<����>{{math equation="x+1" x=$item_key assign="item_key"}}{{$item_key}}</����>
							<������>{{$test_item}}</������>
						</�ʦV������Ƴ̰���������_��Ƥ��e>
{{/foreach}}
					</�ʦV������Ƴ̰���������>
					<���������Ƴ̰���������>
{{foreach from=$test_arr.2 item=test_item key=item_key}}
						<���������Ƴ̰���������_��Ƥ��e>
							<����>{{math equation="x+1" x=$item_key assign="item_key"}}{{$item_key}}</����>
							<������>{{$test_item}}</������>
						</���������Ƴ̰���������_��Ƥ��e>
{{/foreach}}
					</���������Ƴ̰���������>
				</�����߲z���絲�G>
				<�ǲߪ�{>
					<���>{{$data_arr[$arr_key].semester_score.chinese.avg.score}}</���>
					<�^�y>{{$data_arr[$arr_key].semester_score.english.avg.score}}</�^�y>
					<�ƾ�>{{$data_arr[$arr_key].semester_score.math.avg.score}}</�ƾ�>
					<���|>{{$data_arr[$arr_key].semester_score.social.avg.score}}</���|>
					<�۵M>{{$data_arr[$arr_key].semester_score.nature.avg.score}}</�۵M>
					<���N�P�H��>{{$data_arr[$arr_key].semester_score.art.avg.score}}</���N�P�H��>
					<���d�P��|>{{$data_arr[$arr_key].semester_score.health.avg.score}}</���d�P��|>
					<��X����>{{$data_arr[$arr_key].semester_score.complex.avg.score}}</��X����>		
				</�ǲߪ�{>
				<�Q��Ū���Ǯ�>
{{assign var=school_arr value=$data_arr[$arr_key].career.school}}
{{foreach from=$school_arr item=school_item key=item_key}}
					<�Q��Ū���Ǯ�_��Ƥ��e>
						<���@��>{{$item_key}}</���@��>
						<�զW>{{$school_item}}</�զW>
					</�Q��Ū���Ǯ�_��Ƥ��e>
{{/foreach}}
				</�Q��Ū���Ǯ�>
				<�v����X�N��>
					<�a��>
{{assign var=opinion_arr value=$data_arr[$arr_key].career.opinion.parent}}
{{foreach from=$opinion_arr item=opinion_item key=item_key}}
						<�a���Ʊ�_��Ƥ��e>
							<���>{{$opinion_item}}</���>
						</�a���Ʊ�_��Ƥ��e>
{{/foreach}}
						<�a���N������>{{$data_arr[$arr_key].career.opinion.parent.memo}}</�a���N������>
					</�a��>
					<�ɮv>
{{assign var=opinion_arr value=$data_arr[$arr_key].career.opinion.tutor}}
{{foreach from=$opinion_arr item=opinion_item key=item_key}}
						<�ɮv��ĳ_��Ƥ��e>
							<��ĳ>{{$opinion_item}}</��ĳ>
						</�ɮv��ĳ_��Ƥ��e>
{{/foreach}}
						<�ɮv��ĳ����>{{$data_arr[$arr_key].career.opinion.tutor.memo}}</�ɮv��ĳ����>
					</�ɮv>
					<���ɱЮv>
{{assign var=opinion_arr value=$data_arr[$arr_key].career.opinion.guidance}}
{{foreach from=$opinion_arr item=opinion_item key=item_key}}
						<���ɱЮv��ĳ_��Ƥ��e>
							<��ĳ>{{$opinion_item}}</��ĳ>
						</���ɱЮv��ĳ_��Ƥ��e>
{{/foreach}}
						<���ɱЮv��ĳ����>{{$data_arr[$arr_key].career.opinion.guidance.memo}}</���ɱЮv��ĳ����>
					</���ɱЮv>
				</�v����X�N��>
			</�ͲP�o�i�W����>
			<��L�ͲP���ɬ���>
				<�ͲP���ɬ���>
{{assign var=item_arr value=$data_arr[$arr_key].career.guidance}}
{{foreach from=$item_arr item=item key=key}}
					<�ͲP���ɬ���_��Ƥ��e>
						<���>{{$item.guidance_date}}</���>
						<��H>{{$item.target}}</��H>
						<���ɭ��I�Ϋ�ĳ>{{$item.emphasis}}</���ɭ��I�Ϋ�ĳ>
						<���ɱЮv>{{$item.teacher_name}}</���ɱЮv>
					</�ͲP���ɬ���_��Ƥ��e>
{{/foreach}}
				</�ͲP���ɬ���>
				<�ͲP�Ը߬���>
{{assign var=item_arr value=$data_arr[$arr_key].career.consultation}}
{{foreach from=$item_arr item=item key=key}}
					<�ͲP�Ը߬���_��Ƥ��e>
						<�~��>{{$item.grade}}</�~��>
						<�Ǵ�>{{$item.semester}}</�Ǵ�>
						<�Ըߪ��v��>{{$item.teacher_name}}</�Ըߪ��v��>
						<�Q�׭��I�ηN��>{{$item.emphasis}}</�Q�׭��I�ηN��>
						<�Ƶ�>{{$item.memo}}</�Ƶ�>
					</�ͲP�Ը߬���_��Ƥ��e>
{{/foreach}}
				</�ͲP�Ը߬���>
				<�a������>
{{assign var=item_arr value=$data_arr[$arr_key].career.parent}}
{{foreach from=$item_arr item=item key=key}}
					<�a������_��Ƥ��e>
						<�~��>{{$item.grade}}</�~��>
						<�Ѿ\���>
{{assign var=item_arr value=$item.consult}}
{{foreach from=$consult_arr item=consult_item key=consult_key}}
							<�Ѿ\���_��Ƥ��e>
								<����>{{$consult_item}}</����>
							</�Ѿ\���_��Ƥ��e>
{{/foreach}}
						</�Ѿ\���>
						<���Ĥl�����y�Ϋ�ĳ>{{$item.suggestion}}</���Ĥl�����y�Ϋ�ĳ>
						<���Ĥl�����y�Ϋ�ĳ���>{{$item.suggestion_date}}</���Ĥl�����y�Ϋ�ĳ���>
						<�ˮv���q>{{$item.tutor_name}}</�ˮv���q>
						<�ˮv���q���>{{$item.tutor_confirm}}</�ˮv���q���>
					</�a������_��Ƥ��e>
{{/foreach}}
				</�a������>
			</��L�ͲP���ɬ���>
			<�Ǯլ����B�Ǽf�\����>
{{foreach from=$semester_arr item=semester key=semester_key}}
{{assign var=study_year value=$semester_arr[$semester_key].study_year}}
{{assign var=study_seme value=$semester_arr[$semester_key].semester}}
				<�Ǯլ����B�Ǽf�\����_��Ƥ��e>
					<�~��>{{$study_year}}</�~��>
					<�Ǵ�>{{$study_seme}}</�Ǵ�>
					<�f�\�H��>{{$data_arr[$arr_key].career.ponder.9.9.$study_year.$study_seme.teacher}}</�f�\�H��>
					<�f�\���>{{$data_arr[$arr_key].career.ponder.9.9.$study_year.$study_seme.date}}</�f�\���>
					<�Ƶ�>{{$data_arr[$arr_key].career.ponder.9.9.$study_year.$study_seme.memo}}</�Ƶ�>
				</�Ǯլ����B�Ǽf�\����_��Ƥ��e>
{{/foreach}}
			</�Ǯլ����B�Ǽf�\����>
		</�ͲP���ɬ���>
{{/if}}		
	</�ǥͰ򥻸��>
{{/foreach}}
</���y�洫���>
