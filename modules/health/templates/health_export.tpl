{{* $Id: health_export.tpl 6433 2011-05-11 07:39:43Z brucelyc $ *}}

<table border="0" cellspacing="0" cellpadding="0">
<tr><td style="vertical-align:top;"><br>
{{if $sch_id}}
�Ш|���ǮեN��: <span style="color:red; border:#ccc solid thin;">{{$sch_id}}</span><br><br>
<input type="submit" name="export1" value="�ץX�u�����魫�vExcel²�ƪ��ɮ�"><br>
<input type="submit" name="export2" value="�ץX�u���O�ˬd�vExcel²�ƪ��ɮ�"><br>
<input type="submit" name="export3" value="�ץX�u���d�ˬd�vExcel²�ƪ��ɮ�"><br>
<input type="submit" name="export4" value="�ץX�u�f���ˬd�vExcel²�ƪ��ɮ�"><br>
<input type="submit" name="export5" value="�ץX�u�ӤH�e�f�v�vExcel²�ƪ��ɮ�"><br>
<input type="submit" name="export6" value="�ץX�u�˯f�vExcel²�ƪ��ɮ�"><br>
<input type="submit" name="export7" value="�ץX�u����P�ˬd�vExcel²�ƪ��ɮ�"><br><br>
{{else}}
<span style="color:red; border:#ccc solid thin; background: #ff0">�Q�վǮեN�X(�Ш|��)����,�гs�����ޤH���B�z</span>
<input type="submit" name="export"  disabled="true"  value="�ץX�ɮ�">
{{/if}}
{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>���{�����]��100�~��|�q�����ǥͰ��d��ƦӼ��g�C</li>
	</ol>
</td></tr>
</table>
</td>
</tr>
</form>
</table>
