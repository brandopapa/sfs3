{{* $Id: health_check_count.tpl 5743 2009-11-05 07:54:55Z brucelyc $ *}}

<table cellspacing="0" cellpadding="0"><tr>
<td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small" style="text-align:center;">
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
<td>���˥��`</td>
<td>���˲��`</td>
<td>���N��</td>
<td>�N��v</td>
<td>�Ƶ�(�Ψ�L���`����)</td>
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
{{if $smarty.post.class_name}}
<tr style="background-color:white;">
<td rowspan="11">��</td>
<td style="text-align:left;">���O���}(�t4��)</td>
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
<tr style="background-color:#f4feff;">
<td style="text-align:right;">���</td>
<td>{{$rowdata.1.Oph.My|intval}}</td>
<td>{{$rowdata.1.Oph.My/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.Oph.My|intval}}</td>
<td>{{$rowdata.2.Oph.My/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.Oph.My|intval}}</td>
<td>{{$rowdata.all.Oph.My/$studnum_arr.all*100|@round:2}}%</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:right;">����</td>
<td>{{$rowdata.1.Oph.Hy|intval}}</td>
<td>{{$rowdata.1.Oph.Hy/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.Oph.Hy|intval}}</td>
<td>{{$rowdata.2.Oph.Hy/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.Oph.Hy|intval}}</td>
<td>{{$rowdata.all.Oph.Hy/$studnum_arr.all*100|@round:2}}%</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:right;">����</td>
<td>{{$rowdata.1.Oph.Ast|intval}}</td>
<td>{{$rowdata.1.Oph.Ast/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.Oph.Ast|intval}}</td>
<td>{{$rowdata.2.Oph.Ast/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.Oph.Ast|intval}}</td>
<td>{{$rowdata.all.Oph.Ast/$studnum_arr.all*100|@round:2}}%</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:right;">�z��</td>
<td>{{$rowdata.1.Oph.Amb|intval}}</td>
<td>{{$rowdata.1.Oph.Amb/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.Oph.Amb|intval}}</td>
<td>{{$rowdata.2.Oph.Amb/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.Oph.Amb|intval}}</td>
<td>{{$rowdata.all.Oph.Amb/$studnum_arr.all*100|@round:2}}%</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">���O���`</td>
{{assign var=subject value="Oph"}}
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�׵�</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">����˴�</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">���y�_Ÿ</td>
{{assign var=nno value=5}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">��¥�U��</td>
{{assign var=nno value=6}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:#f4feff;">
<td rowspan="11">��<br>��<br>��</td>
<td style="text-align:left;">ť�O���`</td>
{{assign var=subject value="Ent"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�æ����ժ�</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�չD���</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�B�E��</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�c�����`</td>
{{assign var=nno value=5}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�իe?��</td>
{{assign var=nno value=6}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">ͪ�����</td>
{{assign var=nno value=7}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�C�ʻ�</td>
{{assign var=nno value=8}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�L�өʻ�</td>
{{assign var=nno value=9}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">��縢�~�j</td>
{{assign var=nno value=10}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:white;">
<td rowspan="4">�Y<br>�V</td>
<td style="text-align:left;">���V</td>
{{assign var=subject value="Hea"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�Ҫ����~</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�O�ڸ��~�j</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:white;">
<td rowspan="5" style="background-color:#f4feff;">��<br>��</td>
<td style="text-align:left;">�ݹ����`</td>
{{assign var=subject value="Pul"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">������</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�߫ߤ���</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�I�l�n���`</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:#f4feff;">
<td rowspan="3" style="background-color:white;">��<br>��</td>
<td style="text-align:left;">�x�ʸ~�j</td>
{{assign var=subject value="Dig"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">����</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:white;">
<td rowspan="6" style="background-color:#f4feff;">��<br>�W<br>�|<br>��</td>
<td style="text-align:left;">��W���s</td>
{{assign var=subject value="Spi"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�h�֫�</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�C���</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">���`�ܧ�</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">���~</td>
{{assign var=nno value=5}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:white;">
<td rowspan="5">�c<br>��<br>��<br>��</td>
<td style="text-align:left;">���A</td>
{{assign var=subject value="Uro"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">���n�~�j</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�]�ֲ��`</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">����R�ߦ��i</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:#f4feff;">
<td rowspan="7">��<br>��</td>
<td style="text-align:left;">�~</td>
{{assign var=subject value="Der"}}
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">��</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">����</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�νH</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�ïl</td>
{{assign var=nno value=5}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">����ʥֽ���</td>
{{assign var=nno value=6}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:white;">
<td rowspan="9">�f<br>��</td>
<td style="text-align:left;">�T��</td>
{{assign var=subject value="Ora"}}
{{assign var=nno value=7}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�ʤ�</td>
{{assign var=nno value=8}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">�f�Ľåͤ��}</td>
{{assign var=nno value=1}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">������</td>
{{assign var=nno value=2}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">���i��</td>
{{assign var=nno value=5}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">���P��</td>
{{assign var=nno value=3}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">���C�r�X����</td>
{{assign var=nno value=4}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:#f4feff;">
<td style="text-align:left;">�f���H�����`</td>
{{assign var=nno value=6}}
<td>{{$rowdata.1.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.1.$subject.$nno.un/$studnum_arr.1*100|@round:2}}%</td>
<td>{{$rowdata.2.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.2.$subject.$nno.un/$studnum_arr.2*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.un|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.un/$studnum_arr.all*100|@round:2}}%</td>
<td>{{$rowdata.all.$subject.$nno.2|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.se|intval}}</td>
<td>{{$rowdata.all.$subject.$nno.1|intval}}</td>
{{assign var=d value=$rowdata.all.$subject.$nno.se-$rowdata.all.$subject.$nno.1|intval}}
<td>{{$d/$rowdata.all.$subject.$nno.se*100|round}}%</td>
<td></td>
</tr>
<tr style="background-color:white;">
<td style="text-align:left;">��L</td>
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
<tr style="background-color:#f4feff;">
<td colspan="2">���G�z�˲��`</td>
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
<tr style="background-color:white;">
<td colspan="2">���ζ���</td>
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
{{/if}}
</table>
{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�����ʤ��� = �����H�� �� �����`�H�ơC</li>
	</ol>
</td></tr>
</table>
</td></tr></table>
