{{* $Id: health_trans.tpl 5593 2009-08-19 05:40:41Z brucelyc $ *}}

<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.min.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.progressbar.min.js"></script>
<script type="text/javascript">
<!--
var pp=0, d, acc, pass;
var arr=[0{{foreach from=$class_arr item=d key=k}}, {{$k}}{{/foreach}}];
function go() {
	acc=$('#myid').attr('value');
	pass=$('#mypass').attr('value');
	if (acc && pass) {
		$('#upBtn').attr('disabled', true);
		$('#upBtn').attr('value', '  ��ƤW�Ǥ�, �еy��...  ');
		$("#upBtn").get(0).style.color = "red";
		$('#proc').show();
		$('#pb1').progressBar(0);
		d=100/{{$class_arr|@count}};
		$.each(arr,function(i, n){
			if (n>0) {
				$.post('{{$smarty.server.SCRIPT_NAME}}',{ id: n, year_seme: "{{$smarty.post.year_seme}}", act: "xml", acc: acc, pass: pass},function(data){
					if (data!=''){
						pp+=d;
						$('#pb1').progressBar(pp);
						$('#msg').html(data);
						if (pp>99) {
							$('#upBtn').attr('value', '�W�ǧ���');
							$("#upBtn").get(0).style.color = "blue";
						}
					}
				});
			}
		});
	}
}

//-->
</script>

<table border="0" cellspacing="0" cellpadding="0" class="small" style="width:100%;">
<tr><td style="vertical-align:top;">
<span style="color:blue;">�п�J���Ȩt�αb���K�X</span><br><br>
�b���G<input type="text" name="id" id="myid"><br>
�K�X�G<input type="password" name="pass" id="mypass"><br><br>
<div id="proc" style="display:none;">
�W�Ƕi�� <span class="progressBar" id="pb1">0%</span>
<br>
<div id="msg">
&nbsp;
</div></div><br>
<input type="button" id="upBtn" value="�}�l�W��" OnClick="go();">

{{*����*}}
<table class="small" style="width:100%;">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;width:100%;">
	<ol>
	<li>���{�����]��98�~�����x�����F���Ш|�B�鰷�즬���ǥͰ��d��ƦӼ��g�C</li>
	<li>�D�x�����Ǯո�ƱN�L�k�W�ǡC</li>
	</ol>
</td></tr>
</table>
</td>
</tr>
</form>
</table>
