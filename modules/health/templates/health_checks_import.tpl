{{* $Id: health_checks_import.tpl 6449 2011-05-19 15:12:19Z brucelyc $ *}}
<script>
function chk_file() {
	if (document.myform.upload_file.value=="") {
		alert("�Х���ܤW���ɮ�");
	} else {
		document.myform.encoding="multipart/form-data";
		document.myform.submit();
	}
}
</script>

<table border="0" cellspacing="0" cellpadding="0">
<tr><td style="vertical-align:top;"><br>
<input type="radio" name="" checked>�פJ�u�z���ˬd�v���<br>
<input type="radio" name="">�פJ�u������ˬd�v���<br>
<input type="file" name="upload_file">
<input type="button" name="upload" value="�W���ɮ�" OnClick="chk_file();"><br>

{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>���{�����פJ���˳��Ҵ��Ѥ����˹q�l��ƦӼ��g�C</li>
	</ol>
</td></tr>
</table>
</td>
</tr>
</form>
</table>
