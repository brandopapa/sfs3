{{* $Id: stud_basic_test_distest3_print_ttct.tpl 5902 2010-03-08 16:17:07Z brucelyc $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>99�O�F�ϧK�դJ�Ǧb�ժ�{�ҩ���</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$student_sn item=d key=seme_class name=rows}}
{{foreach from=$d item=sn key=site_num}}
<TABLE style="border-collapse: collapse; margin: auto; font: 12pt Times New Roman,�з���,�з���; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt Times New Roman,�з���,�з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="20" style="font-size: 20pt; font-weight: bold;">�O�F��99�Ǧ~�קK�դJ��<br>�b�ժ�{�ҩ���</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�@�B�ǥͰ򥻸��</TD>
		</TR>
        <TR style="height: 30pt; font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�ǥͩm�W</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font-size: 18pt;" 
          colSpan="7">{{$stud_data.$sn.stud_name}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�ʡ@�O</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{if $stud_data.$sn.stud_sex==1}}<span style="font-size: 20pt;">��</span>�k�@<span style="font-size: 20pt;">��</span>�k{{else}}<span style="font-size: 20pt;">��</span>�k�@<span style="font-size: 20pt;">��</span>�k{{/if}}</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�NŪ�Ǯ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid; font-size: 13pt;" 
          colSpan="7">{{$sch_arr.sch_cname}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�͡@��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{$stud_data.$sn.stud_birthday}}</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="3">�NŪ�Z��</TD>
{{assign var=y value=$seme_class|@substr:0:-2}}
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7"><span style="font-size: 18pt;">{{$y-6}} </span> �~ <span style="font-size: 18pt;"> {{$seme_class|@substr:-2:2|@intval}} </span> �Z�y���G<span style="font-size: 18pt;">{{$site_num}}</span></TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="3">�����Ҧr��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font: 16pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{$stud_data.$sn.stud_person_id}}</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�G�B�b�ժ�{ &nbsp;( ���Ǵ��C�j���Υ��� )</TD>
		</TR>
        <TR style="height: 27pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: center;" 
          colSpan="6">����</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��@<br>�W�Ǵ�</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��@<br>�U�Ǵ�</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��G<br>�W�Ǵ�</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��G<br>�U�Ǵ�</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��T<br>�W�Ǵ�</TD>
		  <TD style="width:10%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="4">����</TD>
		</TR>
{{foreach from=$s_arr item=sl key=j}}
{{if $j<10}}
        <TR style="height: 28pt;font-size: 12pt;">
{{if $j==1}}
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="2" rowSpan="3">&nbsp; �y��<br>&nbsp; ���</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="4">�@{{$sl}}</TD>
{{elseif $j<4}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="4">�@{{$sl}}</TD>
{{else}}
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="6">�@{{$sl}}</TD>
{{/if}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{$rowdata.$sn.0.$j.score}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{$rowdata.$sn.1.$j.score}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{$rowdata.$sn.2.$j.score}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{$rowdata.$sn.3.$j.score}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{$rowdata.$sn.4.$j.score}}</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 16pt; font-weight: bold;" 
          colSpan="4">{{$rowdata.$sn.5.$j.score|string_format:"%.2f"}}</TD>
		</TR>
{{/if}}
{{/foreach}}
        <TR style="height: 30pt;font-size: 12pt;">
		  <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">�T�~���`�H��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$sex0}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">�C�j��쥭��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$rowdata.$sn.5.10.score|string_format:"%.2f"}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="4">�C�j��쥭��<br>���իe�ʤ���</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$rowdata.$sn.5.10.pr}}�H</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="4">�C�j���<br>�K��إ���</TD>
{{assign var=t value=$rowdata.$sn.5.10.score*7+$rowdata.$sn.5.3.score}}
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$t/8|string_format:"%.2f"}}</TD>
	</TR>
        <TR style="height: 0pt;">
          <TD colSpan="20"></TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�T�B�b�ժ�{�ĭp�覡</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="text-align: left; font-size: 12pt;">
		  <TABLE style="width:100%;">
		  <TR>
		    <TD style="vertical-align: top;" nowrap>1.�ĭp�覡�G</TD>
		    <TD>�ĭp���Ǵ��]��@�W�Ǵ��ܰ�T�W�Ǵ��^�C�j��줧�U��쥭���]���ܤp�Ʋ�2��^�H�ΤC�j��쥭���M�C�j���K�쥭���C</TD>
		  </TR>
		  <TR>
		    <TD style="vertical-align: top;" nowrap>2.�e�{�覡�G</TD>
		    <TD>�U�ꤤ�����O�e�{�ǥͦb�y����B�ƾǻ��B�۵M�P�ͬ���޻��B���|���B���d�P��|���B���N�P�H����B��X���ʻ�쵥�C���Ǵ��`�����ʤ���C</TD>
		  </TR>
		  </TABLE>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-top: windowtext 0.75pt dashed; text-align: right;" colSpan="4">�ꤤ�f��<br>�H���ֳ�</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="8"></TD>
          <TD style="border-top: windowtext 0.75pt dashed; text-align: left;" colSpan="4">��@�@�@��<br>�аȳB�ֳ�</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="4"></TD>
		</TR>
        <TR>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/foreach}}
{{/foreach}}
</BODY></HTML>
