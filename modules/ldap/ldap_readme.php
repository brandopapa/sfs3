<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);


//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

?>	
	<table border="0" bordercolor="#000000" style="border-collapse:collapse">
		<tr>
			<td>
				�����Ҳդ��\ sfs3 �ǰȨt�Υi�z�L LDAP���A���i��b���ˮֵn�J, �ثe�Ȥ��\�Юv�ήa�����b���C
			</td>
		</tr>
		<tr>
			<td>
				<br>
				���`�N! �A�w�˪� PHP5 �����ҥ� LDAP �M��A�ثe�t���˴����G�G
				<?php
				if (!extension_loaded("ldap")) {
					echo "<font color=red>��p�I�A�� PHP �å��ҥ� LDAP �M��A���pô�t�κ޲z���i��w�ˡC</font>";
				} else {
					echo "<font color=blue>�w�ҥ� LDAP �M��C</font>";
				} 
				?>
				<br>
			</td>
		</tr>
		<tr>
			<td><br>
				���ҥΥ��Ҳդ��e�A�нT�{LDAP���A���ξǰȨt�Τ����b���O�_�Ҧs�b�A�ثe�Ҳճ]�p�W�n�J����z�G<br>
				<img src="images/login_introduce.png"><br>
					�]���Y�w�˥��ҲաA�ñҥ� LDAP�n�J�A�ϥΪ̥H��u�n�޲z LDAP���A�������K�X�Y�i�C<br>
			</td>
		</tr>
		<tr>
			<td style="color:red"><br>�����n�ɥR�����G�ҥ� LDAP�n�J��A�U�@�o��LADP server �G�ٱ��ΡA<br>�Шt�κ޲z�̪����i�J MySQL ��Ʈw�A
				�ק� ldap ��ƪ��� enable ���A�N��ƭȥ� 1 �אּ 0 �A�Y�i��_�����n�J�C
				</td>
		</tr>
		<tr>
			<td><br>
				������ PHP5 �� LDAP �M��w�˻����A�аѦ� http://www.php.net/manual/en/ldap.installation.php �w�ˤ��C<br>
				�H FreeBSD ����, �Q�� ports �w�� php-extensions �|�D�`²��<br>
#cd /usr/ports/lang/php5-extensions <br>
#make config (����Ŀ� OpenLDAP support) <br>
<img src="images/php5-extensions.png"> <br>
#make install FORCE_PKG_REGISTER="yes" <br>
<img src="images/php5-extensions2.png"> <br>
�Y�i�w�˧���<br>
			</td>
		</tr>
	</table>
</form>
