{{* $Id: health_stud_list_csv.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
"�Z��","�y��","�Ǹ�","�m�W","�����Ҧr��","�X�ͤ��","�s���a�}","�s���H","�s���q��"
{{foreach from=$health_data->stud_data item=sd key=seme_class}}
{{foreach from=$sd item=d key=seme_num}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->stud_base.$sn}}
"{{$seme_class}}","{{$seme_num}}","{{$dd.stud_id}}","{{$dd.stud_name}}","{{$dd.stud_person_id}}","{{$dd.stud_birthday}}","{{$dd.stud_addr_2}}","{{$dd.guardian_name}}","{{$dd.stud_tel_2}}"
{{/foreach}}
{{/foreach}}