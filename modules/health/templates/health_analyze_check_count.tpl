{{* $Id: health_analyze_check_count.tpl 6300 2011-01-30 19:06:42Z brucelyc $ *}}
{{assign var=h value=100}}
{{assign var=anum value=$bnum+$gnum}}
<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="3">��O</td>
<td rowspan="3">�ˬd�W�� \ �έp</td>
<td colspan="6">�ˬd���ص��G�o�{����</td>
<td colspan="5">���˴N���B�v�l�ܱ���</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="2">�k</td>
<td colspan="2">�k</td>
<td colspan="2">�X�p��</td>
<td>���˥�<br>�`��</td>
<td>���˲�<br>�`��</td>
<td>���N�墮</td>
<td>�N��v</td>
<td>�Ƶ����Ψ�L<br>���`���ء�</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�H��</td>
<td>�H</td>
<td>�H��</td>
<td>�H</td>
<td>�H��</td>
<td>�H</td>
<td>�H��</td>
<td>�H��</td>
<td>�H��</td>
<td>�H</td>
<td></td>
</tr>
<tr style="background-color: white;">
<td rowspan="11" style="text-align: center;">��</td>
<td>���O���}</td>
{{if $bnum!=$rowdata.1.Oph.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Oph.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Oph.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Oph.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Oph.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Oph.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Oph.1.0+$rowdata.2.Oph.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Oph.1.0-$rowdata.2.Oph.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td style="text-align: right;">���</td>
</tr>
<tr style="background-color: white;">
<td style="text-align: right;">����</td>
</tr>
<tr style="background-color: white;">
<td style="text-align: right;">����</td>
</tr>
<tr style="background-color: white;">
<td style="text-align: right;">�z��</td>
</tr>
<tr style="background-color: white;">
<td>���O���`</td>
{{if $bnum!=$rowdata.1.Oph.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Oph.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Oph.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Oph.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Oph.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Oph.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Oph.2.0+$rowdata.2.Oph.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Oph.2.0-$rowdata.2.Oph.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�׵�</td>
{{if $bnum!=$rowdata.1.Oph.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Oph.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Oph.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Oph.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Oph.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Oph.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Oph.3.0+$rowdata.2.Oph.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Oph.3.0-$rowdata.2.Oph.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>����˴�</td>
{{if $bnum!=$rowdata.1.Oph.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Oph.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Oph.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Oph.4.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Oph.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Oph.4.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Oph.4.0+$rowdata.2.Oph.4.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Oph.4.0-$rowdata.2.Oph.4.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>���y�_Ÿ</td>
{{if $bnum!=$rowdata.1.Oph.5.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Oph.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Oph.5.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Oph.5.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Oph.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Oph.5.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Oph.5.0+$rowdata.2.Oph.5.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Oph.5.0-$rowdata.2.Oph.5.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>��¥�U��</td>
{{if $bnum!=$rowdata.1.Oph.6.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Oph.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Oph.6.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Oph.6.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Oph.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Oph.6.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Oph.6.0+$rowdata.2.Oph.6.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Oph.6.0-$rowdata.2.Oph.6.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: #F0F0F0;">
<td rowspan="11" style="text-align: center;">�ջ��</td>
<td>ť�O���`</td>
{{if $bnum!=$rowdata.1.Ent.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.1.0+$rowdata.2.Ent.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.1.0-$rowdata.2.Ent.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�æ����ժ�</td>
{{if $bnum!=$rowdata.1.Ent.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.2.0+$rowdata.2.Ent.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.2.0-$rowdata.2.Ent.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�չD���</td>
{{if $bnum!=$rowdata.1.Ent.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.3.0+$rowdata.2.Ent.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.3.0-$rowdata.2.Ent.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�B�E��</td>
{{if $bnum!=$rowdata.1.Ent.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.4.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.4.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.4.0+$rowdata.2.Ent.4.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.4.0-$rowdata.2.Ent.4.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td></tr>
<tr style="background-color: #F0F0F0;">
<td>�c�����`</td>
{{if $bnum!=$rowdata.1.Ent.5.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.5.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.5.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.5.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.5.0+$rowdata.2.Ent.5.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.5.0-$rowdata.2.Ent.5.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�իe�@��</td>
{{if $bnum!=$rowdata.1.Ent.6.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.6.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.6.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.6.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.6.0+$rowdata.2.Ent.6.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.6.0-$rowdata.2.Ent.6.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>ͪ�����</td>
{{if $bnum!=$rowdata.1.Ent.7.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.7.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.7.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.7.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.7.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.7.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.7.0+$rowdata.2.Ent.7.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.7.0-$rowdata.2.Ent.7.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�C�ʻ�</td>
{{if $bnum!=$rowdata.1.Ent.8.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.8.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.8.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.8.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.8.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.8.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.8.0+$rowdata.2.Ent.8.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.8.0-$rowdata.2.Ent.8.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�L�өʻ�</td>
{{if $bnum!=$rowdata.1.Ent.9.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.9.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.9.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.9.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.9.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.9.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.9.0+$rowdata.2.Ent.9.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.9.0-$rowdata.2.Ent.9.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td></tr>
<tr style="background-color: #F0F0F0;">
<td>��縢�~�j</td>
{{if $bnum!=$rowdata.1.Ent.10.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ent.10.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ent.10.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ent.10.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ent.10.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ent.10.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ent.10.0+$rowdata.2.Ent.10.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ent.10.0-$rowdata.2.Ent.10.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: white;">
<td rowspan="4" style="text-align: center;">�Y�V</td>
<td>���V</td>
{{if $bnum!=$rowdata.1.Hea.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Hea.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Hea.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Hea.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Hea.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Hea.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Hea.1.0+$rowdata.2.Hea.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Hea.1.0-$rowdata.2.Hea.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�Ҫ����~</td>
{{if $bnum!=$rowdata.1.Hea.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Hea.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Hea.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Hea.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Hea.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Hea.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Hea.2.0+$rowdata.2.Hea.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Hea.2.0-$rowdata.2.Hea.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�O�ڸ��~�j</td>
{{if $bnum!=$rowdata.1.Hea.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Hea.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Hea.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Hea.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Hea.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Hea.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Hea.3.0+$rowdata.2.Hea.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Hea.3.0-$rowdata.2.Hea.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: #F0F0F0;">
<td rowspan="5" style="text-align: center;">�ݳ�</td>
<td>�ݹ����`</td>
{{if $bnum!=$rowdata.1.Pul.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Pul.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Pul.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Pul.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Pul.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Pul.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Pul.1.0+$rowdata.2.Pul.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Pul.1.0-$rowdata.2.Pul.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>

</tr>
<tr style="background-color: #F0F0F0;">
<td>������</td>
{{if $bnum!=$rowdata.1.Pul.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Pul.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Pul.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Pul.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Pul.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Pul.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Pul.2.0+$rowdata.2.Pul.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Pul.2.0-$rowdata.2.Pul.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�߫ߤ���</td>
{{if $bnum!=$rowdata.1.Pul.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Pul.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Pul.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Pul.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Pul.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Pul.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Pul.3.0+$rowdata.2.Pul.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Pul.3.0-$rowdata.2.Pul.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�I�l�n���`</td>
{{if $bnum!=$rowdata.1.Pul.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Pul.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Pul.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Pul.4.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Pul.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Pul.4.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Pul.4.0+$rowdata.2.Pul.4.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Pul.4.0-$rowdata.2.Pul.4.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: white;">
<td rowspan="6" style="text-align: center;">��W�|��</td>
<td>��W���s</td>
{{if $bnum!=$rowdata.1.Spi.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Spi.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Spi.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Spi.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Spi.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Spi.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Spi.1.0+$rowdata.2.Spi.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Spi.1.0-$rowdata.2.Spi.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�h�֫�</td>
{{if $bnum!=$rowdata.1.Spi.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Spi.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Spi.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Spi.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Spi.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Spi.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Spi.2.0+$rowdata.2.Spi.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Spi.2.0-$rowdata.2.Spi.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�C���</td>
{{if $bnum!=$rowdata.1.Spi.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Spi.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Spi.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Spi.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Spi.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Spi.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Spi.3.0+$rowdata.2.Spi.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Spi.3.0-$rowdata.2.Spi.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>���`�ܧ�</td>
{{if $bnum!=$rowdata.1.Spi.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Spi.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Spi.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Spi.4.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Spi.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Spi.4.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Spi.4.0+$rowdata.2.Spi.4.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Spi.4.0-$rowdata.2.Spi.4.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>���~</td>
{{if $bnum!=$rowdata.1.Spi.5.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Spi.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Spi.5.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Spi.5.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Spi.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Spi.5.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Spi.5.0+$rowdata.2.Spi.5.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Spi.5.0-$rowdata.2.Spi.5.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: #F0F0F0;">
<td rowspan="5" style="text-align: center;">�c���ʹ�</td>
<td>���A</td>
{{if $bnum!=$rowdata.1.Uro.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
<td></td>
<td></td>
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>���n�~�j</td>
{{if $bnum!=$rowdata.1.Uro.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
<td></td>
<td></td>
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�]�ֲ��`</td>
{{if $bnum!=$rowdata.1.Uro.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
<td></td>
<td></td>
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>����R�ߦ��i</td>
{{if $bnum!=$rowdata.1.Uro.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
<td></td>
<td></td>
<td>{{if $b}}{{$bnum-$rowdata.1.Uro.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Uro.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: white;">
<td rowspan="7" style="text-align: center;">�ֽ�</td>
<td>�~</td>
{{if $bnum!=$rowdata.1.Der.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Der.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Der.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Der.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Der.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Der.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Der.1.0+$rowdata.2.Der.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Der.1.0-$rowdata.2.Der.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>��</td>
{{if $bnum!=$rowdata.1.Der.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Der.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Der.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Der.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Der.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Der.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Der.2.0+$rowdata.2.Der.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Der.2.0-$rowdata.2.Der.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>����</td>
{{if $bnum!=$rowdata.1.Der.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Der.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Der.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Der.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Der.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Der.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Der.3.0+$rowdata.2.Der.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Der.3.0-$rowdata.2.Der.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�νH</td>
{{if $bnum!=$rowdata.1.Der.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Der.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Der.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Der.4.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Der.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Der.4.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Der.4.0+$rowdata.2.Der.4.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Der.4.0-$rowdata.2.Der.4.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>�ïl</td>
{{if $bnum!=$rowdata.1.Der.5.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Der.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Der.5.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Der.5.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Der.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Der.5.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Der.5.0+$rowdata.2.Der.5.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Der.5.0-$rowdata.2.Der.5.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>����ʥֽ���</td>
{{if $bnum!=$rowdata.1.Der.6.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Der.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Der.6.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Der.6.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Der.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Der.6.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Der.6.0+$rowdata.2.Der.6.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Der.6.0-$rowdata.2.Der.6.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: white;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: #F0F0F0;">
<td rowspan="9" style="text-align: center;">�f��</td>
<td>�T��</td>
{{if $bnum!=$rowdata.1.Ora.7.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.7.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.7.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.7.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.7.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.7.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.7.0+$rowdata.2.Ora.7.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.7.0-$rowdata.2.Ora.7.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�ʤ�</td>
{{if $bnum!=$rowdata.1.Ora.8.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.8.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.8.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.8.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.8.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.8.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.8.0+$rowdata.2.Ora.8.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.8.0-$rowdata.2.Ora.8.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�f�Ľåͤ��}</td>
{{if $bnum!=$rowdata.1.Ora.1.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.1.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.1.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.1.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.1.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.1.0+$rowdata.2.Ora.1.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.1.0-$rowdata.2.Ora.1.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>������</td>
{{if $bnum!=$rowdata.1.Ora.2.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.2.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.2.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.2.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.2.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.2.0+$rowdata.2.Ora.2.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.2.0-$rowdata.2.Ora.2.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>���i��</td>
{{if $bnum!=$rowdata.1.Ora.5.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.5.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.5.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.5.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.5.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.5.0+$rowdata.2.Ora.5.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.5.0-$rowdata.2.Ora.5.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>���P��</td>
{{if $bnum!=$rowdata.1.Ora.3.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.3.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.3.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.3.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.3.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.3.0+$rowdata.2.Ora.3.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.3.0-$rowdata.2.Ora.3.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>���C�r�X����</td>
{{if $bnum!=$rowdata.1.Ora.4.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.4.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.4.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.4.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.4.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.4.0+$rowdata.2.Ora.4.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.4.0-$rowdata.2.Ora.4.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>�f���H�����`</td>
{{if $bnum!=$rowdata.1.Ora.6.0}}{{assign var=b value=1}}{{else}}{{assign var=b value=0}}{{/if}}
<td>{{if $b}}{{$bnum-$rowdata.1.Ora.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.1.Ora.6.0/$bnum*100|round:2}}
<td>{{if $b}}{{$h-$v}}%{{/if}}</td>
{{if $gnum!=$rowdata.2.Ora.6.0}}{{assign var=g value=1}}{{else}}{{assign var=g value=0}}{{/if}}
<td>{{if $g}}{{$gnum-$rowdata.2.Ora.6.0}}{{/if}}</td>
{{assign var=v value=$rowdata.2.Ora.6.0/$gnum*100|round:2}}
<td>{{if $g}}{{$h-$v}}%{{/if}}</td>
{{assign var=av value=$rowdata.1.Ora.6.0+$rowdata.2.Ora.6.0}}
{{if $anum!=$av}}{{assign var=a value=1}}{{else}}{{assign var=a value=0}}{{/if}}
<td>{{if $a}}{{$bnum+$gnum-$rowdata.1.Ora.6.0-$rowdata.2.Ora.6.0}}{{/if}}</td>
{{assign var=v value=$av/$anum*100|round:2}}
<td>{{if $a}}{{$h-$v}}%{{/if}}</td>
</tr>
<tr style="background-color: #F0F0F0;">
<td>��L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color: white;">
<td colspan="2" style="text-align: center;">���G�z�˲��`</td>
</tr>
<tr style="background-color: white;">
<td colspan="2" style="text-align: center;">���ζ���</td>
</tr>
</table>
</td>
</tr></table>
