{{* $Id: Growthnotification.tpl 5711 2009-10-26 02:24:01Z brucelyc $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>���������ǥ������श�q����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$health_data->stud_data item=ddd key=seme_class}}
{{foreach from=$ddd item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=year_name value=$seme_class|@substr:0:-2}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{assign var=h value=$health_data->health_data.$sn}}
<TABLE style="border-collapse: collapse; margin: auto; font: 14pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
        <TR style="height: 16pt;">
          <TD style="font-size:16pt;"><span style="font-size: 14pt;">{{$school_data.sch_cname}}</span>�@�@<strong>���������ǥ������श�q����</strong></TD>
		</TR>
		<TR>
		  <TD style="text-align: left;">
		  <TABLE style="font: 14pt �з���,�з���,serif;">
		  <TR><TD style="width:65%">
		  �˷R���a���G<br>
		  �Q�l�k <strong>{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z{{$seme_num}} �� {{$health_data->stud_base.$sn.stud_name}}</strong> �g���չ�I���d�ˬd�������q���ʡA�o�{���æ������ͪ��𺢲{�H�I�����@�Q�l�k�����d�A�бa�L�e�������c�M����v�B�i�@�B�ˬd�A�]�Y�O�A���Q�դ�q���A�B����o�T�w�E�_�̡A��ĳ�^����|�N�E�^�A�H�ⴤ�v��������ɾ��I<br>
		  </TD><TD style="width:35%;vertical-align:top;">
		  <TABLE style="font-size:8pt;" cellSpacing="0" cellPadding="0">
			<TR>
			<TD colSpan="3" style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align:center;">���~�����魫�O��</TD>
			</TR>
{{foreach from=$h item=hh key=ys}}
{{if ($ys|substr:-1:1)==1}}
			<TR>
			<TD style="border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;">{{$ys|substr:0:-1|intval}}�Ǧ~:</TD>
			<TD style="border-top: windowtext 0.75pt solid;">{{$hh.height}}����&nbsp;</TD>
			<TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;">{{$hh.weight}}����</TD>
			</TR>
{{/if}}
{{/foreach}}
			<TR>
			<TD colSpan="3" style="border-top: windowtext 1.5pt solid;">&nbsp;</TD>
			</TR>
		  </TABLE>
		  </TD>
		  </TR>
		  </TABLE>
		  �@�@�@�@�@�@�@�@���P<br>
		  �Q�a��<br>
		  
          <p style="font-size: 12pt; text-align: right;">{{$school_data.sch_cname}} ���d���ߡ@�q�ҡ@�@ {{$smarty.now|date_format:"%Y"}} �~ {{$smarty.now|date_format:"%m"}} �� {{$smarty.now|date_format:"%d"}} ��@�@</p>
		  <p style="border-bottom: dashed 4px;"></p>
		  <p style="font-size: 16pt; text-align: center; height: 16pt;"><strong>�N��^��</strong></span></p>
		  <p style="font-size: 10pt">{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z{{$seme_num}}��{{$health_data->stud_base.$sn.stud_name}} ����{{$h.$year_seme.height}}���� �魫{{$h.$year_seme.weight}}����<br>
		  ���˨���<u>�@�@�@</u>���� ���˨���<u>�@�@�@</u>����</p>
		  �N���ˬd���G�]�H�U����|��g�^<br>
		  �N�E��|�W�١G�@�@�@�@�@�@�@�@�f�����X�G<br>
		  �N�E����G�@�@�~�@�@��@�@��<br>
		  ��vñ���G<br><br>
		  �ˬd���ؤ��e�G<br><br><span style="font-size: 12pt">
		  �����G�@�@�@�@�����@�Ъ������G�@�@�@�@����<br><br>
		  �魫�G�@�@�@�@����@�X�ͮ��魫�G�@�@�@�@����<br><br>
		  ��X�� �����ˬd<br><br>
		  ����G�G�@�@�����G�@�@�Ҫ������G�@�@�ͪ��E���G�@�@�V����G�@�@IGF-I�G<br><br>
		  ��L�ˬd<br><br></span>
		  ��v��ĳ�B�z�G�]�i�ƿ�^<br>
		  1.�E�_�W�١G<br>
		  �@���a�کʸG�p�����ʸG�p���S�o�ʸG�p���ͪ��E���ʥF<br>
		  �@���z�S�Ǥ�g���H�h�}�g���鰩�o�|�������E�v���`<br>
		  </TD>
		</TR>
  </TBODY>
</TABLE>
{{/foreach}}
{{/foreach}}
</BODY></HTML>
