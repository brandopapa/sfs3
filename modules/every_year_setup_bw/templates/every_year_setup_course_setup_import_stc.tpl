{{* $Id: every_year_setup_course_setup_import_stc.tpl 6188 2010-09-23 02:30:46Z brucelyc $ *}}
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
<tr bgcolor="#FFFFFF">
<td class="title_sbody1" nowrap>�m�i��פJ�@�~�n2.�W��<font color='red'>(STC�ƽҨt��)</font>�]�w�ɡG</td><td><input type=file name="upload_file"></td>
<td class="title_sbody1" nowrap><input type=submit name="upload" value="�W��"></td>
<td class="title_sbody1" nowrap><input type=submit value="�^��������A"></td>
<input type="hidden" name="year_seme" value="{{$sel_year}}-{{$sel_seme}}">
<input type="hidden" name="import" value="1">
</tr>
<tr bgcolor="#FFFFFF">
<td class="title_sbody1" colspan="4" style="text-align:left;background-color:white;" nowrap>
<font color="blue">���Х���ܶפJ���ءG</font><br>
<input type="radio" name="file_name" value="ClassNum" {{if $enable_class}}disabled{{else}}checked{{/if}}>1.�Z�ų]�w��(ClassNum) <input type="checkbox" name="force7" {{if $enable_class}}disabled{{/if}}>�j��q�C�~�Ŷ}�l�פJ<br>
<input type="radio" name="file_name" value="ClassTab" {{if $enable_class}}checked{{else}}disabled{{/if}}>2.�Ҫ�]�w��(ClassTab)<br>
<input type="radio" name="file_name" value="CoursNam" {{if $enable_class==0}}disabled{{/if}}>3.��ئW����(CoursNam)<br>
<input type="radio" name="file_name" value="ClassCur" {{if $enable_class==0}}disabled{{/if}}>4.�Z�Űt����(ClassCur)<br>
<input type="radio" name="file_name" value="TeachNam" {{if $enable_class==0}}disabled{{/if}}>5.�Юv�m�W��(TeachNam)
</td>
</tr>
</form>
</table>
<br>
<table>
<tr bgcolor="#FBFBC4"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td></tr>
<tr><td style="line-height: 150%;">
<ol>
<li class="small">STC�ƽҨt�Τ��U�ɮפ��e���@�w�����p�A�Ъ����ϥθӨt���ɮסA���Ҳդ��t���ѽd���ɨѤH�u�@�~�ϥΡC</li>
<li class="small">�ФťH�H�u�覡�ۦ����ɦW���ɮפ��e�A�H�קK���i�w�������~�o�͡C</li>
<li class="small">�Ш̧ǶפJ�Z�ų]�w��(ClassNum)�B�Ҫ�]�w��(ClassTab)�B��ئW����(CoursNam)�B�Z�Űt����(ClassCur)�B�Юv�m�W��(TeachNam)�C</li>
</ol>
</td>
</tr>
</table>
