{{* $Id: stud_list_stud_list_print.tpl 7678 2013-10-17 14:13:58Z infodaes $ *}}
<HTML><HEAD><TITLE>�ǥͦW��</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
<STYLE>
P 			{LINE-HEIGHT: 12pt}
H1			{font-size: 12px; margin-top:0; margin-bottom:0;text-align:center}
H3			{font-size: 16px; margin-top:0; margin-bottom:0;text-align:center}
TD			{border-top:0;border-left:0.75pt solid;border-right:0.75pt solid;border-bottom:0.75pt solid;text-align:center;vertical-align:middle;font-size:12px;font-family:Arial,�s�ө���}
TD.left	{border-top:0;border-left:1.5pt solid;border-right:0.75pt solid;border-bottom:0.75pt solid;text-align:center;vertical-align:middle;font-size:12px;font-family:Dotum,�s�ө���}
TD.right	{border-top:0;border-left:0.75pt solid;border-right:1.5pt solid;border-bottom:0.75pt solid;text-align:center;vertical-align:middle;font-size:12px;font-family:Dotum,�s�ө���}
TD.dotted {border-top:0;border-left:1.5pt dotted;border-right:1.5pt dotted;border-bottom:0;vertical-align: middle}
TD.dotted_left {border-top:0;border-left:1.5pt dotted;border-right:0;border-bottom:0;vertical-align:middle;}
TD.dotted_right {border-top:0;border-left:0;border-right:1.5pt dotted;border-bottom:0;vertical-align: middle}
TD.title	{border-top:1.5pt solid;border-left:1.5pt solid;border-right:1.5pt solid;border-bottom:0.75pt solid;vertical-align:middle}
TD.hr			{border-top:0;border-left:0.75pt solid;border-right:0.75pt solid;border-bottom:1.5pt solid;text-align:center;vertical-align:middle;font-size:12px;font-family:Arial,�s�ө���}
TD.hr_left	{border-top:0;border-left:1.5pt solid;border-right:0.75pt solid;border-bottom:1.5pt solid;text-align:center;vertical-align:middle;font-size:12px;font-family:Dotum}
TD.hr_right	{border-top:0;border-left:0.75pt solid;border-right:1.5pt solid;border-bottom:1.5pt solid;text-align:center;vertical-align:middle;font-size:12px;font-family:Dotum}
TD.empty {border-top:0;border-left:0;border-right:0;border-bottom:0;text-align:center;vertical-align: middle}
</STYLE>

<SCRIPT language=JavaScript>
		<!--
		function pp() {   
			if (window.confirm('�}�l�C�L�H')){
			self.print();}
		}
		//-->
</SCRIPT>

<BODY onload="pp();return true;">
<TABLE style="BORDER-COLLAPSE: collapse" cellSpacing=0 cellPadding=0 width=652 border=0>
  <TR>
    <TD width="642" class="empty">
      <TABLE style="BORDER-COLLAPSE: collapse" cellSpacing="0" cellPadding="0" width="631" border="0">
        <TR style="HEIGHT: 40pt">
        	{{assign var=c_sel_1 value=$smarty.post.c_id.1}}
        	{{assign var=c_sel_2 value=$smarty.post.c_id.2}}
        	{{assign var=c_sel_3 value=$smarty.post.c_id.3}}
          <TD width="19" rowSpan="{{$max_num+2}}" class="dotted_left">          
          <TD colSpan="4" class="title">
            <H3>{{$sel_year}}�Ǧ~��{{$sel_seme}}�Ǵ�</H3>
            <H3>{{$class_arr.$c_sel_1}}<br>�ɮv�G{{$tutor.$c_sel_1}}</H3>
          <TD width="19" rowSpan="{{$max_num+2}}" class="dotted_right">          
          <TD width="19" rowSpan="{{$max_num+2}}" class="dotted_left">          
          <TD colSpan="4" class="title">
            <H3>{{$sel_year}}�Ǧ~��{{$sel_seme}}�Ǵ�</H3>
            <H3>{{$class_arr.$c_sel_2}}<br>�ɮv�G{{$tutor.$c_sel_2}}</H3>
          <TD width="19" rowSpan="{{$max_num+2}}" class="dotted_right">          
          <TD width="19" rowSpan="{{$max_num+2}}" class="dotted_left">          
          <TD colSpan="4" class="title">
            <H3>{{$sel_year}}�Ǧ~��{{$sel_seme}}�Ǵ�</H3>
            <H3>{{$class_arr.$c_sel_3}}<br>�ɮv�G{{$tutor.$c_sel_3}}</H3>
          <TD width="19" rowSpan="{{$max_num+2}}" class="dotted_right">          
        </TR>
        <TR style="HEIGHT: 20pt">
          <TD width="34" class="left"><h1>�y��</h1></TD>
          <TD width="46"><h1>�Ǹ�</h1></TD>
          <TD width="56"><h1>�m�W</h1></TD>
          <TD width="50" class="right"><h1>{{$oth_str}}</h1></TD>
          <TD width="34" class="left"><h1>�y��</h1></TD>
          <TD width="46"><h1>�Ǹ�</h1></TD>
          <TD width="56"><h1>�m�W</h1></TD>
          <TD width="50" class="right"><h1>{{$oth_str}}</h1></TD>
          <TD width="34" class="left"><h1>�y��</h1></TD>
          <TD width="46"><h1>�Ǹ�</h1></TD>
          <TD width="56"><h1>�m�W</h1></TD>
          <TD width="50" class="right"><h1>{{$oth_str}}</h1></TD>
        </TR>
{{section name=i start=0 loop=$max_num}}
	{{assign var=site_num value=$smarty.section.i.index+1}}
	{{if ($site_num % 5) != 0}}
        <TR style="HEIGHT: 12pt">
          <TD class="left">{{$site_num}}</TD>
          <TD>{{$data_arr.1.$site_num.stud_id}}</TD>
          <TD>{{$data_arr.1.$site_num.stud_name}}</TD>
          <TD class="right">{{$data_arr.1.$site_num.oth}} </TD>
          <TD class="left">{{$site_num}}</TD>
          <TD>{{$data_arr.2.$site_num.stud_id}}</TD>
          <TD>{{$data_arr.2.$site_num.stud_name}}</TD>
          <TD class="right">{{$data_arr.2.$site_num.oth}} </TD>
          <TD class="left">{{$site_num}}</TD>
          <TD>{{$data_arr.3.$site_num.stud_id}}</TD>
          <TD>{{$data_arr.3.$site_num.stud_name}}</TD>
          <TD class="right">{{$data_arr.3.$site_num.oth}} </TD>
        </TR>
	{{else}}
        <TR style="HEIGHT: 12pt">
          <TD class="hr_left">{{$site_num}}</TD>
          <TD class="hr">{{$data_arr.1.$site_num.stud_id}}</TD>
          <TD class="hr">{{$data_arr.1.$site_num.stud_name}}</TD>
          <TD class="hr_right">{{$data_arr.1.$site_num.oth}} </TD>
          <TD class="hr_left">{{$site_num}}</TD>
          <TD class="hr">{{$data_arr.2.$site_num.stud_id}}</TD>
          <TD class="hr">{{$data_arr.2.$site_num.stud_name}}</TD>
          <TD class="hr_right">{{$data_arr.2.$site_num.oth}} </TD>
          <TD class="hr_left">{{$site_num}}</TD>
          <TD class="hr">{{$data_arr.3.$site_num.stud_id}}</TD>
          <TD class="hr">{{$data_arr.3.$site_num.stud_name}}</TD>
          <TD class="hr_right">{{$data_arr.3.$site_num.oth}} </TD>
        </TR>
	{{/if}}
{{/section}}
</TABLE>
</BODY>
</HTML>