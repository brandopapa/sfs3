{{* $Id: body.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="header.tpl"}}
{{foreach from=$rowdata key=seme_class item=seme_class_data}}
{{assign var="temp_id" value=$temp_id+1}}
{{if $temp_id>1}}
<P STYLE="margin-bottom: 0cm; page-break-before: always"></P>
{{/if}}
<P ALIGN=RIGHT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=4>���إ���
{{$today}}</FONT></FONT></P>
<P STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=4>{{$school_long_name}} {{$curr_year}}
�Ǧ~�� �� {{$curr_seme}} �Ǵ��ǥͤ@���� </FONT></FONT><FONT FACE="Times New Roman"><FONT SIZE=4><SPAN LANG="en-US">
</SPAN></FONT></FONT><P ALIGN=RIGHT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=4></SPAN></FONT></FONT><FONT FACE="�з���"><FONT SIZE=4>{{$class_name_arr[$seme_class]}}</FONT></FONT><FONT FACE="Times New Roman"><FONT SIZE=4><SPAN LANG="en-US"> �ť��Ѯv�G{{$class_tea_arr[$seme_class]}}</FONT></FONT></P></P>
<TABLE WIDTH=643 BORDER=1 BORDERCOLOR="#000000" CELLPADDING=4 CELLSPACING=0>
	<COL WIDTH=39>
	<COL WIDTH=66>
	<COL WIDTH=113>
	<COL WIDTH=49>
	<COL WIDTH=106>
	<COL WIDTH=97>
	<COL WIDTH=115>
	<THEAD>
		<TR VALIGN=TOP>
			<TH WIDTH=39>
				<P ALIGN=CENTER><FONT FACE="�з���">�Ǹ�</FONT></P>
			</TH>
			<TH WIDTH=66>
				<P ALIGN=CENTER><FONT FACE="�з���">�Ǹ�</FONT></P>
			</TH>
			<TH WIDTH=113>
				<P ALIGN=CENTER><FONT FACE="�з���">�m�W</FONT></P>
			</TH>
			<TH WIDTH=49>
				<P ALIGN=CENTER><FONT FACE="�з���">�ʧO</FONT></P>
			</TH>
			<TH WIDTH=106>
				<P ALIGN=CENTER><FONT FACE="�з���">�X�ͦ~���<BR>(�褸)</FONT></P>
			</TH>
			<TH WIDTH=97>
				<P ALIGN=CENTER><FONT FACE="�з���">�J�Ǧ~��</FONT></P>
			</TH>
			<TH WIDTH=115>
				<P ALIGN=CENTER><FONT FACE="�з���">�Ƶ�</FONT></P>
			</TH>
		</TR>
	</THEAD>
	<TBODY>
	{{foreach from=$seme_class_data item=data}}
		<TR VALIGN=TOP>
			<TD WIDTH=39 valign="center" >
				<P ALIGN=CENTER >{{$data.seme_num}}
				</P>
			</TD>
			<TD WIDTH=66 valign="center" >
				<P ALIGN=CENTER>{{$data.stud_id}}
				</P>
			</TD>
			<TD WIDTH=113 valign="center" >
				<P ALIGN=CENTER>{{$data.stud_name}}
				</P>
			</TD>
			<TD WIDTH=49 valign="center" >
				<P ALIGN=CENTER>{{if $data.stud_sex==1}}�k{{else}}�k{{/if}}
				</P>
			</TD>
			<TD WIDTH=106 valign="center" >
				<P ALIGN=CENTER>{{$data.stud_birthday}}
				</P>
			</TD>
			<TD WIDTH=97 valign="center" >
				<P ALIGN=CENTER>{{$data.stud_study_year}}-9-1
				</P>
			</TD>
			<TD WIDTH=115 valign="center" >
				<P ALIGN=CENTER><BR>
				</P>
			</TD>
		</TR>
	{{/foreach}}
	</TBODY>
</TABLE>

{{/foreach}}
{{include file="footer.tpl"}}
