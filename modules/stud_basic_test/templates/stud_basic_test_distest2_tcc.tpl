{{* $Id: stud_basic_test_distest2_tcc.tpl 5879 2010-03-02 17:47:48Z brucelyc $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>���Ϥ��M�K�դJ�Ǧb�ժ�{�ҩ���</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$student_sn item=d key=seme_class}}
{{foreach from=$d item=sn key=site_num}}
<TABLE style="border-collapse: collapse; margin: auto; font: 12pt Times New Roman,�з���,�з���; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt Times New Roman,�з���,�з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="20" style="font-size: 20pt; font-weight: bold;">���Ϥ��M�K�դJ�Ǧb�ժ�{�ҩ���</TD>
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
          colSpan="7">{{$stud_data.$sn.stud_birthday|@substr:0:2}}�~{{$stud_data.$sn.stud_birthday|@substr:2:2}}��{{$stud_data.$sn.stud_birthday|@substr:4:2}}��</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="3">�NŪ�~�Z�y��</TD>
{{assign var=y value=$seme_class|@substr:0:-2}}
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7"><span style="font-size: 18pt;">{{$y-6}} </span> �~ <span style="font-size: 18pt;"> {{$seme_class|@substr:-2:2|@intval}} </span> �Z�y���G<span style="font-size: 18pt;">{{$site_num}}</span></TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="3">�����Ҧr��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font: 16pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{$stud_data.$sn.stud_person_id}}</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�G�B�b�ժ�{</TD>
		</TR>
        <TR style="height: 27pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: center;" 
          colSpan="5">����</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��@<br>�W�Ǵ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��@<br>�U�Ǵ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��G<br>�W�Ǵ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��G<br>�U�Ǵ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">��T<br>�W�Ǵ�</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="5">�Ť��X�p</TD>
		</TR>
{{foreach from=$ss_link item=sl}}
        <TR style="height: 16pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="5" rowSpan="2">�@{{$css_link.$sl}}</TD>
{{foreach from=$semes item=si key=i}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{$fin_score.$sn.$sl.$si.score}}</TD>
{{/foreach}}
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 16pt; font-weight: bold;" 
          colSpan="5" rowSpan="2">{{s2n score=$fin_score.$sn.$sl semes=$semes}}</TD>
		</TR>
        <TR style="height: 16pt;font-size: 12pt;">
{{foreach from=$semes item=si key=i}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2">{{o2n score=$fin_score.$sn.$sl.$si.score}}</TD>
{{/foreach}}
		</TR>
{{/foreach}}
        <TR style="height: 30pt;font-size: 12pt;">
		  <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; text-align: left;"
		  colSpan="5">�@���� / ����</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="10">{{tavg score=$fin_score.$sn semes=$semes ss_link=$ss_link mode=1}}</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;"
		  colSpan="5">{{tavg score=$fin_score.$sn semes=$semes ss_link=$ss_link}}</TD>
	</TR>
        <TR style="height: 0pt;">
          <TD colSpan="20"></TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�T�B�e�{�覡</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="text-align: left; font-size: 12pt;">
		  <TABLE style="width:100%;">
		  <TR>
		    <TD style="vertical-align: top;" nowrap>1.�ĭp�覡�G</TD>
		    <TD>���Ǵ��]��@�W�Ǵ��ܰ�T�W�Ǵ��^�C�j���]�K�j��^�U��Ť��X�p�P�`�������Ť��C</TD>
		  </TR>
		  <TR>
		    <TD style="vertical-align: top;" nowrap>2.����覡�G</TD>
		    <TD>���Z���|�ˤ��J�������⬰�Ť��A90���H�W��5�Ť��A80���H�W���F90����4�Ť��A70���H�W���F80����3�Ť��A60���H�W���F70����2�Ť��A���F60����1�Ť��C</TD>
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
