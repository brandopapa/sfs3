{{* $Id: health_web_wh_csv.tpl 5530 2009-07-21 05:33:35Z brucelyc $ *}}
"PID","GradeID","Sem","Weight","Height"
{{foreach from=$rowdata item=d}}
"{{$d.stud_person_id}}","{{$d.year-$d.stud_study_year+$IS_JHORES+1}}","{{$d.semester}}","{{$d.weight}}","{{$d.height}}"
{{/foreach}}
