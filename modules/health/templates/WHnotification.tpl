<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>�����魫���q���G�q����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=year_name value=$seme_class|@substr:0:-2}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=h value=$health_data->health_data.$sn.$year_seme}}
<TABLE style="border-collapse: collapse; margin: auto; font: 14pt �з���,�з���,serif; page-break-after: auto;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 12pt �з���,�з���,serif;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 16pt;">
          <TD style="font-size:16pt;">{{$school_data.sch_cname}}�@<strong>�����魫���q���G�q����</strong><br></TD>
                </TR>
                <TR>
                  <TD style="text-align: left;">
                  �˷R���a���G<br><p style="font-size:6pt;"></p>
                  �Q�l�k <strong>{{$year_data.$year_name}}{{$class_data.$seme_class}}�Z {{$seme_num}}</strong> �� <strong>{{$health_data->stud_base.$sn.stud_name}}</strong><br>
                  ���� <strong>{{$h.height}}</strong> ���� �魫 <strong>{{$h.weight}}</strong> ���� BMI�� <strong>{{$h.BMI}}</strong><br>
                  �g�PŪ���G <strong>{{$Bid_arr[$h.Bid]}}</strong><br><p style="font-size:6pt;"></p>

{{if $h.Bid==0}}
                  �Q�l�k���Ǵ����魫�ˬd���G�o�{�髬�G�p�A�����@�Q�l�k�����d�A�жQ�a�������R�ް_�Ĥl�G�z����]�O�_�������ߺD���}�y���H�αa����>
�|�@��i�@�B���ˬd�A�H�A�Ѧ��L��L��b�e�f�]���y���C�{�ȴ��ѥH�U������i��ơA�Ʊ�a����t�X�a�~�ͬ��A�H�ﵽ�䶼����i���p�C<br>
                  <ol style="font-size: 11pt;">
                        <li>�C�ѫ��ɶi�\�A�O���߱��r�֡B���Z�C�`�A�H�W�i�������U���ơC</li>
                        <li>���\���@�Ѥ����A�@�w�n�Y�B�q�n����a�n�n�C</li>
                        <li>�����n�w�q�B�������A��i�n�������t�b�T�\���C</li>
                        <li>�קK�v�T�Y���\���]���A�Ҧp���\�����Y�s���B���I�C</li>
                        <li>�h�ܶ}���P�i���`�ƪn�A���@���d�C</li>
                        <li>�C�ѭn�@�A�q��~�B�ʡC</li>
                        <li>�C�ѭn�ܨ��T�M�����A�ѳJ�ս�B�t��B���ͯ�B2�A�P�i�ൣ�ͪ��A����E���C</li>
                        <li>���H�����@��������g�@���u��C</li>
                  </ol>
{{elseif $h.Bid==1}}
                  �Q�l�k���Ǵ����魫�ˬd���G�o�{�髬�b���`�d�򤺡A�����@�Q�l�k�����d�A�жQ�a��������`�ͬ����A�~���U�O���}�n���ͬ������ߺD>�C�󦹦A���Ѭ�����i��Ƨ@�����U�ѦҡA�Ʊ�঳�ҧU�q�C����ݦ]�z�̪��V�O�A�϶Q�l�k��֦����`���d���ͪ��o�|�C<br>
                  <ol style="font-size: 11pt;">
                        <li>�����n���šA��i�n�������t�b�T�\���C</li>
                        <li>�C�ѭn�ܨ��T�M�����A�ѳJ�ս�B�t��B���ͯ�B2�A�P�i�ൣ�ͪ��A����E���C</li>
                        <li>���\����i�������šA�å]�A�@�����J�ժ������C�Ҧp�G�����@�M�B���]�J�@�өΥյN�J�@�ӡB�C�Y�@�ӡB���G�@���C</li>
                        <li>�ǵ��ѩ󬡰ʶq�j�A�ൣ�����\�~�A�i�W�[�@��G���I�ߡA�ר�ൣ�U�ȩ�Ǯɥi���Ѥ@���I�ߡ]�̦n�O�����s�~�^�C</li>
                        <li>�h�ܶ}���P�i���`�ƪn�A���@���d�C</li>
                        <li>�C�ѭn�@�A�q�B�ʡA�åB�����H��C</li>
                        <li>���b�Y���ɬݹq���A�i�\����^���M�֡A�קK�b�Y���ɶ��A�d�|�ൣ�C</li>
                  </ol>
{{else}}
                  �Q�l�k���Ǵ����魫�ˬd���G�o�{�魫�L���C�]�魫�L���e���ް_��Ŧ��ޯe�f�A�ʧ@���F���A����ζH���t�C�����@�Q�l�k���骺���d�A��>
��a����ۦ�����ǵ���`�����ߺD�O�_�����y���B�C�Y���A�аѦҥH�U�魫�����ơA�H��U�ǵ������魫�C<br>
                  <ol style="font-size: 11pt;">
                        <li>�������s�@���q�ĥλ]�B�N�B�N�B�D�աC</li>
                        <li>���ܶi�\���{�ǡA���ܴ��A�Y��B���M�סC</li>
                        <li>�@�w�b�\��W���\�A�Y�줣�j���n�Y�칡�C</li>
                        <li>����w���}�\��B�ߧY����C</li>
                        <li>�̦n��C��O���i�������������M�q�C</li>
                        <li>�קK�Y�s���d�]�A�ר䤣�n�ΦY�Ӽ��g�ۤv�C</li>
                        <li>�h��ܦY�_�ӳ·СA�Y���h�S��ɶ��������C</li>
                        <li>�Y���\���������j�P�ɡA�i��ܺ믫�O�q������B�`�N�O���ಾ�A�ο�C���q�������ɥR�]�p�GĬ���氮�B�h�������G�B���ո���>
�B�p���ʡB����^�C</li>
                        <li>�C��i���W�߹B�ʪ��n�ߺD�A�ë����H��C</li>
                        <li>�����魫���L�{�n�㦳�T�ߡA�Y�H�ߡB�M�ߩM��ߡC</li>
                  </ol>
{{/if}}
                  �@�@�@�@�@�@�@�@���P<br>
                  �Q�a��<p style="font-size:6pt;"></p>

          <p style="font-size: 10pt; text-align: right;">{{$school_data.sch_cname}} ���d���ߡ@�q�ҡ@�@ {{$smarty.now|date_format:"%Y"}}.{{$smarty.now|date_format:"%m"}}.{{$smarty.now|date_format:"%d"}}�@</p>
                  </TD>
                </TR>
                </TBODY>
          </TABLE>
        </TD>
  </TR>
  </TBODY>
</TABLE>
{{if $smarty.foreach.rows.iteration%2==1}}
<p style="border-bottom: dashed 1px;"></p>
{{else}}
<p style="page-break-after:always;"> </p>
{{/if}}
{{/foreach}}
</BODY></HTML>
