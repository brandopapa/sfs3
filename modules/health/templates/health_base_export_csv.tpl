"�����O","�ǮզW��","��O","�~�ŧO","�Z�O","�m�W","�����Ҹ�","�ʧO","�X�ͦ~���"
{{foreach from=$health_data->stud_data item=d key=seme_class}}
{{foreach from=$d item=dd key=seme_num name=rows}}
{{assign var=sn value=$dd.student_sn}}
{{assign var=ddd value=$health_data->stud_base.$sn}}
{{assign var=year_name value=$seme_class|@substr:0:-2}}
{{php}}
$d_arr=explode("-",$this->_tpl_vars['ddd']['stud_birthday']);
if (count($d_arr)==3) {
	$d_arr[0]-=1911;
	$this->_tpl_vars['ddd']['stud_birthday']=implode("",$d_arr);
}
{{/php}}
"{{$sch.sch_sheng}}","{{$sch.sch_cname_ss}}","�L","{{$seme_class|@substr:0:-2}}","{{$seme_class|@substr:-2:2}}","{{$ddd.stud_name}}","{{$ddd.stud_person_id}}","{{if $ddd.stud_sex==1}}�k{{else}}�k{{/if}}","{{$ddd.stud_birthday}}"
{{/foreach}}
{{/foreach}}
