<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>�f���ˬd�q����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=year_name value=$seme_class|@substr:0:-2}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
<TABLE style="border-collapse: collapse; margin: auto; letter-spacing: -0.1em; font: 12pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="10" style="font-size:16pt;"><span style="font-size: 14pt;">{{$school_data.sch_cname}}</span>�@�@<strong>�f���ˬd�q����</strong></TD>
		</TR>
		<TR style="height: 15pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">�˷R���a���G</TD>
		</TR>
		<TR style="height: 15pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">�Q�l�k�@<strong>{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z {{$seme_num}} �� {{$health_data->stud_base.$sn.stud_name}}</strong></TD>
		</TR>
		<TR style="height: 30pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">�g�����f���ˬd�o�{�U�C���D</TD>
		</TR>
        <TR style="height: 30pt">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="8">�������p</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="2">�ˬd���G</TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�@</TD>
          <TD style="border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�T����</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >�ʤ���</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >�w�B�v</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >�ݩޤ�</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >���ͤ�</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >�إͤ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�`�@��</TD>
          <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; text-align: left; vertical-align: top;"
		  colSpan="2" rowSpan="4">
		  <br>�@{{if $dd.C1}}��{{else}}��{{/if}} �T��
		  <br>�@{{if $dd.C2}}��{{else}}��{{/if}} �ʤ�
		  <br>�@{{if $dd.C4}}��{{else}}��{{/if}} �ݩޤ�
		  <br>�@{{if $dd.C5}}��{{else}}��{{/if}} ���ͤ�
		  <br>�@{{if $dd.C6}}��{{else}}��{{/if}} �إͤ�
		  <br>�@{{if $dd.checks.Ora1}}��{{else}}��{{/if}} �f�Ľåͤ��}
		  <br>�@{{if $dd.checks.Ora4}}��{{else}}��{{/if}} ���C�r�X����
		  <br>�@{{if $dd.checks.Ora5}}��{{else}}��{{/if}} ���i��
		  <br>�@{{if $dd.checks.Ora6}}��{{else}}��{{/if}} �f���H�����`<br><br></TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;"
		  >��@��</TD>
          <TD style="border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.N1|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.N2|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.N3|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.N4|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.N5|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.N6|@intval}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.NTotal|@intval}}</TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�š@��</TD>
          <TD style="border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.n1|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.n2|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.n3|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.n4|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.n5|@intval}}</TD>
          <TD style="border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.n6|@intval}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$dd.nTotal|@intval}}</TD>
		</TR>
        <TR style="HEIGHT: 50pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;"
		  >��L�s<br>���ƶ�</TD>
          <TD style="border-left: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
          <TD style="border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
          <TD style="border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
          <TD style="border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
          <TD style="border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
          <TD style="border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;"
		  >�@</TD>
		</TR>
		</TBODY>
	  </TABLE><br>
	  <span style="font-size: 14pt;">�����@�Q�l�̤����d�A�бa�ܦX�����v�B���i�@�B�ˬd�A���ְ��n�B�v�u�@<br>�A�û��ɨ�`�N�f�īO���A�i���\�������n�ߺD�C<br>
	  ���|�@�ɸR<br>
	  </span>
	  <p style="font-size: 12pt; text-align:right;">�x�����߼�q������� ���d���ߡ@�@�q�ҡ@�@{{$smarty.now|date_format:"%Y"}} �~ {{$smarty.now|date_format:"%m"}} �� {{$smarty.now|date_format:"%d"}} ��</p>
	  <p style="border-bottom: dashed 4px;"></p>
	  <p style="font-size: 14pt; text-align:center;">�f���ˬd���B�v���p�]�^���^</p>
	  <p style="font-size: 14pt;"><strong>{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z {{$seme_num}} �� {{$health_data->stud_base.$sn.stud_name}}</strong></p>
	  <p style="font-size: 14pt;">��v�ˬd���G�G</p><br>
	  <p style="font-size: 14pt;">��v��ĳ�ƶ��G</p><br>
	  <p style="font-size: 14pt;">�a���s���ƶ��G</p><br><br>
	  <p style="font-size: 14pt; text-align: right;">�a��ñ�W�G�@�@�@�@�@�@�@�@����G�@�@�@�@</p>
	  <p style="font-size: 12pt; text-align: center;">�]�Цb�����B�v������A�N���^���浹�ť��Ѯv(�ɮv)���ٰ��d���߷J��C�^</p>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/foreach}}
</BODY></HTML>
