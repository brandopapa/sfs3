{{* $Id: stud_list_stud_list_csv_all.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
"�Z��","�y��","�Ǹ�","�m�W"
{{foreach from=$class_arr item=d}}
{{assign var=site_num value=$smarty.section.i.index+1}}
"{{$d.seme_class}}","{{$d.seme_num}}","{{$d.stud_id}}","{{$d.stud_name}}"
{{/foreach}}
