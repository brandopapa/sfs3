<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- $Id: body2.tpl 5310 2009-01-10 07:57:56Z hami $ -->
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=big5">
	<TITLE>{{$school_long_name}}{{$curr_year}}
�Ǧ~�� �� {{$curr_seme}} �Ǵ��ǥͤ@����</TITLE>
	<META NAME="GENERATOR" CONTENT="OpenOffice.org 1.1.2  (Linux)">
	<META NAME="CREATED" CONTENT="20041004;20402000">
	<META NAME="CHANGED" CONTENT="20041004;20542300">
	<STYLE>
	<!--
		@page { size: 21cm 29.7cm; margin: 2cm }
		P { margin-bottom: 0.21cm }
		TD P { margin-bottom: 0.21cm }
		TH P { margin-bottom: 0.21cm; font-style: italic }
	-->
	</STYLE>
</HEAD>
<BODY LANG="zh-TW" DIR="LTR">
<P ALIGN=CENTER STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=3>{{$school_long_name}}{{$curr_year}}
�Ǧ~�� �� {{$curr_seme}} �Ǵ� {{$title_class}} �ǥͤ@����</FONT></FONT>
</P>
<P ALIGN=RIGHT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=3>������ : ���إ���
{{$today}}</FONT></FONT></P>
<TABLE WIDTH=100% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=4 CELLSPACING=0>
	<COL WIDTH=18*>
	<COL WIDTH=31*>
	<COL WIDTH=13*>
	<COL WIDTH=31*>
	<COL WIDTH=32*>
	<COL WIDTH=24*>
	<COL WIDTH=20*>
	<COL WIDTH=87*>
	<THEAD>
		<TR>
			<TH WIDTH=7%>
				<P><FONT FACE="�з���"><FONT SIZE=2>�Ǹ�</FONT></FONT></P>
			</TH>
			<TH WIDTH=12%>
				<P><FONT FACE="�з���"><FONT SIZE=2>�m�W</FONT></FONT></P>
			</TH>
			<TH WIDTH=5%>
				<P><FONT FACE="�з���"><FONT SIZE=2>�ʧO</FONT></FONT></P>
			</TH>
			<TH WIDTH=12%>
				<P><FONT SIZE=2><FONT FACE="�з���">�����Ҧr��</FONT></FONT></P>
			</TH>
			<TH WIDTH=12%>
				<P><FONT FACE="Times New Roman"><FONT SIZE=2><SPAN LANG="en-US">(</SPAN></FONT></FONT><FONT FACE="�з���"><FONT SIZE=2>�褸</FONT></FONT><FONT FACE="Times New Roman"><FONT SIZE=2><SPAN LANG="en-US">)</SPAN></FONT></FONT><FONT FACE="�з���"><FONT SIZE=2>�X��</FONT></FONT><FONT FACE="Times New Roman"><FONT SIZE=2><SPAN LANG="en-US"><BR></SPAN></FONT></FONT><FONT FACE="�з���"><FONT SIZE=2>�~���</FONT></FONT></P>
			</TH>
			<TH WIDTH=9%>
				<P><FONT FACE="�з���"><FONT SIZE=2>�J��</FONT></FONT><FONT FACE="Times New Roman"><FONT SIZE=2><SPAN LANG="en-US"><BR></SPAN></FONT></FONT><FONT FACE="�з���"><FONT SIZE=2>�ɶ�</FONT></FONT></P>
			</TH>
			<TH WIDTH=8%>
				<P><FONT FACE="�з���"><FONT SIZE=2>�J��</FONT></FONT><FONT FACE="Times New Roman"><FONT SIZE=2><SPAN LANG="en-US"><BR></SPAN></FONT></FONT><FONT FACE="�з���"><FONT SIZE=2>���</FONT></FONT></P>
			</TH>
			<TH WIDTH=34%>
				<P><FONT FACE="�з���"><FONT SIZE=2>���y�a�}</FONT></FONT></P>
			</TH>
		</TR>
	</THEAD>
	<TBODY>
	{{foreach from=$rowdata key=seme_class item=seme_class_data}}
	{{foreach from=$seme_class_data item=data}}
		<TR VALIGN=TOP>
			<TD WIDTH=7%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_id}}</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=12%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_name}}</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=5%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{if $data.stud_sex==1}}�k{{else}}�k{{/if}}</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=12%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_person_id}}</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=12%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_birthday}}</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=9%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_study_year}}-9-1</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=8%>
				<P ALIGN=CENTER><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_mschool_name}}</FONT></FONT>
				</P>
			</TD>
			<TD WIDTH=34%>
				<P ALIGN=LEFT><FONT FACE="�з���"><FONT SIZE=2>{{$data.stud_addr_1}}</FONT></FONT>
				</P>
			</TD>
		</TR>
	{{/foreach}}
	{{/foreach}}
	</TBODY>
</TABLE>
<P ALIGN=LEFT STYLE="margin-bottom: 0cm"><BR>
</P>
<P ALIGN=LEFT STYLE="margin-bottom: 0cm"><FONT SIZE=2><FONT FACE="�з���">�`�N�ƶ�</FONT></FONT><FONT FACE="Times New Roman"><SPAN LANG="en-US"><FONT SIZE=2><FONT FACE="�з���">:
</FONT></FONT></SPAN></FONT>
</P>
<OL>
	<LI><P ALIGN=LEFT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=2>���W�U����y�@���G���A�@���s�աA�@����������F���C</FONT></FONT></P>
	<LI><P ALIGN=LEFT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=2>�J�Ǹ������������~�θw�~�ǮզW�٤Φ~�šC</FONT></FONT></P>
	<LI><P ALIGN=LEFT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=2>��J�ǥͥ�Υ���ä��~�ŧO�˭q�C</FONT></FONT></P>
	<LI><P ALIGN=LEFT STYLE="margin-bottom: 0cm"><FONT FACE="�з���"><FONT SIZE=2>���W�U����ǥͤJ�ǫ�@�Ӥ뤺����C</FONT></FONT></P>
</OL>
</BODY>
</HTML>