<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>���O���}�q����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>

{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}

{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num }}

{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{assign var=year_name value=$seme_class|@substr:0:-2}}

<TABLE style="border-collapse: collapse; margin: auto; font: 14pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 14pt �з���,�з���,serif;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 16pt;">
          <TD style="font-size:16pt;"><span style="font-size: 14pt;">{{$school_data.sch_cname}}</span>�@�@<strong>���O���}�q����</strong></TD>
		</TR>
		<TR>
		  <TD style="text-align: left;">
		  �˷R���a���G<br>
		  �Q�l�k <strong>{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z {{$seme_num}} �� {{$health_data->stud_base.$sn.stud_name}}</strong> <br>
		  ���Ǵ����O�ˬd���G�� <strong>���O���}</strong>�C<br>
		  �жQ�a���a�Q�l�k�e����|����i�@�B���ˬd�B�v�A�H�K�v�T�ǲߡA�ýз��P�ﵽ�Q�l�k���ͬ��ߺD�G
		  <ol style="font-size: 12pt;">
			<li>�ݮѼg�r�ɡA���խn�ݥ��A�ѻP�������Z���n�b35�������C</li>
			<li>�ݹq���Ψϥιq���A�C30������10�����C</li>
			<li>�ݹq���ɥ��u���i�ӷt�A�n�O���G���إH�W�Z���C</li>
			<li>�ίv�n�R���A���n���]�C</li>
			<li>�`�����Ū������A������q����i���C</li>
			<li>�i���滷�������ߺD�A�æh����~���ʡC</li>
			<li>���q��֪�Z���β������ʡC</li>
			<li>�бN�^���� {{$smarty.post.rmonth}} �� {{$smarty.post.rday}} ��e��^���d���ߨð����ˡC</li>
		  </ol>
		  �@�@�@�@�@�@�@�@���P<br>
		  �Q�a��<br>

          <p style="font-size: 12pt; text-align: right;">{{$school_data.sch_cname}} ���d���ߡ@�q�ҡ@�@ {{$smarty.now|date_format:"%Y"}} �~ {{$smarty.now|date_format:"%m"}} �� {{$smarty.now|date_format:"%d"}} ��@�@</p>
		  <p style="border-bottom: dashed 4px;"></p>
		  <p style="font-size: 16pt; text-align: center; height: 16pt;"><strong>��|�]�E�ҡ^����ˬd�^��</strong></span></p>
		  <strong>{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z {{$seme_num}} ��       �ǥͩm�W�G{{$health_data->stud_base.$sn.stud_name}}</strong><br>
		  �@�B�E���|�ҦW�١G<br>
		  �G�B�ˬd����G�@�@�@�~�@�@�@��@�@�@��<br>
		  �T�B��vñ���G<br><br>
		  �|�B��v�ˬd���G�G�@�����`�@�����`�]�Щ�U�C���إ��ġA�i�ƿ�^<br>
		  �@1.�z���G�@�������@���k���@�������@�@���B��0.5�H�U<br>
		  �@2.�׵��G�@�����ס@���~�ס@���W�U�ס@���沴<br>
		  �@3.�}�������G�]������^<br>
		  �@�@(1)����G�@�������@���k���@�������@���׼ơG<u>�@�@</u><br>
		  �@�@(2)�����G�@�������@���k���@�������@���׼ơG<u>�@�@</u><br>
		  �@�@(3)�����G�@�������@���k���@�������@���׼ơG<u>�@�@</u><br>
		  �@�@(4)�������G��<br>
		  �@4.��L���`�G�]�е����^<br><br>
		  ���B��v��ĳ�B�z�G�]�i�ƿ�^<br>
		  �@��(1)�t�����B���@��(2)����@��(3)�B���v���@��(4)�I��<br>
		  �@��(5)�w���l�ܡ@�@��(6)��L<u>�@�@�@�@�@�@�@�@�@�@�@�@</u><br>
		  ���B���체����˩��~��v����]�G<br>
		  �@��(1)�t���v���@��(2)��q���K�@��(3)�a���S�ɶ��@��(4)�g�٧x��<br>
		  �@��(5)���ݭn�@�@��(6)��L<u>�@�@�@�@�@�@�@�@�@�@�@�@</u>
		  <p style="font-size: 14pt; text-align: right;">�a��ñ���G�@�@�@�@�@�@�@�@�~�@�@��@�@��</p>
		  </TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/foreach}}
</BODY></HTML>
