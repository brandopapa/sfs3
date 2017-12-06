{{* $Id: health_other_cdc.tpl 6239 2010-10-21 08:44:47Z brucelyc $ *}}
{{assign var=k value=2}}
"學校代碼","學校名稱","學生姓名","性別","年級","班級","座號"
{{foreach from=$rowdata item=d key=sn}}
"{{$s_arr.sch_id}}","{{$s_arr.sch_cname}}","{{$d.stud_name}}","{{$k-$d.stud_sex}}","{{$d.seme_class|@substr:0:1}}","{{$d.seme_class|@substr:-2:2}}","{{$d.seme_num}}"
{{/foreach}}
