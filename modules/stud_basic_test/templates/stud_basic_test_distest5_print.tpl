{{* $Id: stud_basic_test_distest5_print.tpl 8373 2015-03-30 06:44:32Z chiming $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>{{$curr_year}}�Ǧ~�װ�����Ǧb�վǲ߻�즨�Z�ҩ���</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$student_sn item=d key=seme_class name=rows}}
{{foreach from=$d item=sn key=site_num}}
<TABLE style="border-collapse: collapse; margin: auto; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt �з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 30pt;">
          <TD colSpan="2" style="font: 16pt �ө���; font-weight: bold; border: windowtext 3pt solid; letter-spacing: -0.1em;">�@�먭���ǥ�</TD>
		  <TD colSpan="7"></TD>
		</TR>
        <TR style="height: 40pt;">
          <TD colSpan="9" style="font: 18pt �з���; font-weight: bold;"><span style="font-family: Times New Roman; font-weight: bold;">{{$curr_year}}</span>�Ǧ~�װ�����Ǧb�վǲ߻�즨�Z�ҩ���</TD>
		</TR>
        <TR style="height: 30pt; font-size: 12pt;">
          <TD style="text-align: left;" colSpan="5">�NŪ�ꤤ�G <span style="font-size: 16pt; letter-spacing: -0.1em;">{{$sch_arr.sch_cname}}</span></TD>
		  <TD style="text-align: left;" colSpan="4">�NŪ�ꤤ�N�X�G <span style="font: 18pt Times New Roman;">{{$sch_arr.sch_id}}</span></TD>
		</TR>
{{assign var=y value=$seme_class|@substr:0:-2}}
        <TR style="height: 30pt;font-size: 12pt;">
          <TD style="text-align: left;" colSpan="5">�Z�šG <span style="font: 18pt Times New Roman;">{{$y}}</span> �~ <span style="font: 18pt Times New Roman;">{{$seme_class|@substr:-2:2|@intval}}</span> �Z�@�@�m�W�G <span style="font-size: 16pt;">{{$stud_data.$sn.stud_name}}</span></TD>
          <TD style="text-align: left;" colSpan="4">�����ҲΤ@�s���G <span style="font: 18pt Times New Roman">{{$stud_data.$sn.stud_person_id}}</span></TD>
		</TR>
        <TR style="height: 27pt;font-size: 12pt; background-color: #EEEEEE;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: center;" 
          colSpan="2">���]�Ǭ�^</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >�K�~��<br>�W�Ǵ�<br><span style="font-family: Times New Roman;">(A)</span></TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >�K�~��<br>�U�Ǵ�<br><span style="font-family: Times New Roman;">(B)</span></TD>
          <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          >�E�~��<br>�W�Ǵ�<br><span style="font-family: Times New Roman;">(C)</span></TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">���(�Ǭ�)�Ǵ�<br>���Z����<span style="font-family: Times New Roman;">(A+B+C)/3</span></TD>
		  <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">���(�Ǭ�)�Ǵ���<br>�Z���ձƦW�ʤ���</TD>
		</TR>
{{foreach from=$s_arr item=sl key=j}}
{{if $j==10}}
        <TR style="height: 28pt; font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2" rowSpan="2">{{$sl}}</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >�K�~��<br>�W�Ǵ�<br><span style="font-family: Times New Roman;">(D)</span></TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >�K�~��<br>�U�Ǵ�<br><span style="font-family: Times New Roman;">(E)</span></TD>
          <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          >�E�~��<br>�W�Ǵ�<br><span style="font-family: Times New Roman;">(F)</span></TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2" rowSpan="2">---</TD>
		  <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" 
          colSpan="2" rowSpan="2">---</TD>
		</TR>
{{/if}}
{{if $j<>3}}
        <TR style="height: 28pt;font-size: 14pt;">
          {{if $j<>10}}
		  <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 12pt;" 
          colSpan="2">{{$sl}}</TD>
		  {{/if}}
		  {{assign var=sp_cal value=$stud_data.$sn.sp_cal}}
		  {{if $stud_data.$sn.stud_kind==2 || $stud_data.$sn.stud_kind==7}}{{assign var=sp_cal value=1}}{{/if}}
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          ><span style="font-family: Times New Roman;">{{if $sp_cal && $stud_data.$sn.enable0==""}}---{{else}}{{$rowdata.$sn.0.$j.score}}{{/if}}</span></TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          ><span style="font-family: Times New Roman;">{{if $sp_cal && $stud_data.$sn.enable1==""}}---{{else}}{{$rowdata.$sn.1.$j.score}}{{/if}}</span></TD>
          <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;" 
          ><span style="font-family: Times New Roman;">{{if $sp_cal && $stud_data.$sn.enable2==""}}---{{else}}{{$rowdata.$sn.2.$j.score}}{{/if}}</span></TD>
          {{if $j<>10}}
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2"><span style="font-family: Times New Roman;">{{$rowdata.$sn.3.$j.score|string_format:"%.2f"}}</span></TD>
		  <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2"><span style="font: 16pt Times New Roman; font-weight: bold;">{{$rowdata.$sn.3.$j.pr}}</span></TD>
		  {{/if}}
		</TR>
{{/if}}
{{/foreach}}
        <TR style="height: 28pt;font-size: 14pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 12pt;" 
          colSpan="2">�b��3�Ǵ����Z<br>�`����<br><span style="font-family: Times New Roman;">(D+E+F)/3</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="3"><span style="font-family: Times New Roman;">{{$rowdata.$sn.3.10.score|string_format:"%.2f"}}</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 12pt;" 
          colSpan="2">�b��3�Ǵ����Z<br>�`����<br>���ձƦW�ʤ���</TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2"><span style="font: 16pt Times New Roman; font-weight: bold;">{{$rowdata.$sn.3.10.pr}}</span></TD>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">�Ƶ�</TD>
          <TD style="border-right: windowtext 1.5pt solid; border-left: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; text-align: left;" 
          colSpan="7">1.�Ǵ����Z�����p��ܤp���I��ĤG��A�p���I��ĤT��|�ˤ��J�C<br>2.�ҫ��u�K�~�ŤW�Ǵ��B�K�~�ŤU�Ǵ��B�E�~�ŤW�Ǵ��v�Y�u�ꤤ�G�~�ŤW�Ǵ��B�G�~�ŤU�Ǵ��ΤT�~�ŤW�Ǵ��v�C<br>3.���]�Ǭ�^���ƦC���ǥѤW�ܤU�̧Ǭ���y��B�^�y�B�ƾǡB���|�B�۵M�P�ͬ���ޡB���N�P�H��B���d�P��|�κ�X���ʡA���Ǥ��o���N�ܰʡC</TD>
		</TR>
        <TR style="height: 0pt;">
          <TD style="border-top: windowtext 1.5pt solid;" colSpan="9"></TD>
		</TR>
		<TR>
		  <TD colSpan="9" style="height: 20pt; text-align: left;"></TD>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-top: windowtext 0.75pt dashed; text-align: right; color: CCCCCC;" colSpan="2">(�NŪ�ꤤ�W��)</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="3"></TD>
          <TD style="border-top: windowtext 0.75pt dashed; text-align: left;" colSpan="2"></TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="2"></TD>
		</TR>
        <TR>
          <TD>&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
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
