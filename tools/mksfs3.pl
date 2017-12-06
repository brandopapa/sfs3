#! /usr/bin/perl
#---------------------------------------------------------
# $Id: mksfs3.pl 5311 2009-01-10 08:11:55Z hami $
#
# mksfs3.pl --- SFS3 �ǰȨt�μҲղ��;� 
# Written by OLS3 ver 1.0.2 (ols3@www.tnc.edu.tw)
#
# Copyright (C) 2003 OLS3 
# ���{���O�ۥѳn��A�i�H�̻P Perl �ۦP�����v���ڴ��G�C
#---------------------------------------------------------

system("clear");

$COPYRIGHT=<<C1;
#---------------------------------------------------------
# mksfs3.pl --- SFS3 �ǰȨt�μҲղ��;� 
# Written by OLS3 ver 1.0.2 (ols3@www.tnc.edu.tw)
# Copyright (C) 2003 OLS3 
# ���{���O�ۥѳn��A�i�H�̻P Perl �ۦP�����v���ڴ��G�C
#
# �o�Ӥp�{���i�H���z���� SFS3 �Ҳժ����F�ɮסA�z�u�n
# �s��ק�o���ɮסA�K�i�H�ܻ��P�a�s�@ SFS3 ���ҲաC
#---------------------------------------------------------
C1

print $COPYRIGHT;

# Questions for creating SFS3 module

# Q1 �Ҳէ@��
while(!$author) {
	print "\n�z�j�W? (���^��ҥi) ";
	$author=<>;
	chomp $author;
}

# Q2 �p�� email
while(!$your_email) {
	print "\n�z���q�l�l���}? ";
	$your_email=<>;
	chomp $your_email;
}

# Q3 �Ҳդ���W��
while(!$module_chinese_name) {
	print "\n�z���Ҳդ���W��? ";
	$module_chinese_name=<>;
	chomp $module_chinese_name;
}

# Q4 �Ҳեؿ��W��
while(!$module_ename) {
	print "\n�Ҳեؿ��W��? (�^�Ʀr����) ";
	$module_ename=<>;
	chomp $module_ename;
	if ( -f $module_ename || -d $module_ename ) {
	    print "�b�z���{�b���|���A$module_ename �w�s�b�F! �д��@����!\n";
	    $module_ename='';
	}
}

# Q �Ҳզs����|
while(!$module_path) {
	print "\n�Ҳզs����|?(�ҡG/var/www/html/sfs3/modules)\n    �� Enter ---> �ثe�����|\n    �� 1 -------> /var/www/html/sfs3/modules\n    �� 2 -------> /home/apache/htdocs/sfs3/modules)\n    �� 3 -------> /usr/local/apache/htdocs/sfs3/modules)\n�п�J�G[���|/Enter/1/2/3]�H ";
	$module_path=<>;
	if ($module_path eq "\n") { $module_path='.'; }
	chomp $module_path;
	if ($module_path == 1) { $module_path='/var/www/html/sfs3/modules'; }
	if ($module_path == 2) { $module_path='/home/apache/htdocs/sfs3/modules'; }
	if ($module_path == 3) { $module_path='/usr/local/apache/htdocs/sfs3/modules'; }

	if ( ! -d $module_path ) {
	    print "$module_path �o�Ӹ��|���s�b! �Э��s��J!\n";
	    $module_path='';
	} elsif ( ! -w $module_path ) {
	    print "$module_path �o�Ӹ��|�z�S���g�J�v! �Ф���root�����έ��s��J!\n";
	    $module_path='';
	}
}



# Q5 �Ҳեγ~²�z
while(!$module_simple_description) {
	print "\n�Ҳեγ~²�z? ";
	$module_simple_description=<>;
	chomp $module_simple_description;
}

# Q6 �ҲեD�n�ɦW
while(!$mainfile) {
	print "\n�ҲեD�n�ɦW? (��p easy.php) ";
	$mainfile=<>;
	chomp $mainfile;
}

# Q7 ��Ʈw����ƪ�W��
while($table_name eq '') {
	print "\n�ҲջݥΨ쪺��ƪ�W��? (�^�Ʀr/�Y�L�Ы�Enter) ";
	$table_name=<>;
}

chomp $table_name;

# Q8 �Ҳժ���
while(!$module_version) {
	print "\n�Ҳժ���? (�榡�d�ҡG1.0.0) ";
	$module_version=<>;
	chomp $module_version;
}

# Q9 �Ҳիإߤ��
while(!$module_create_date) {
	print "\n�Ҳիإߤ��? (�榡�d�ҡG2003/05/03) ";
	$module_create_date=<>;
	chomp $module_create_date;
}

# �}�l�إ�
print "\n�� Enter ��}�l�۰ʲ��ͼҲռз��� ....\n";
my $ans=<>;

my $mkdir_no=mkdir "$module_path/$module_ename", 0775;

if (!$mkdir_no) {
    print "�}�� $module_ename �ؿ����~! $!\n";
    exit;
}

%FILES=(
1  => "author.txt",
2  => "config.php",
3  => "$mainfile",
4  => "index.php",
5  => "INSTALL",
6  => "module-cfg.php",
7  => "module.sql",
8  => "NEWS",
9  => "README",
10 => "MANIFEST"
);


$FILE_1=<<H1;
$module_ename - $module_chinese_name
�쪩�@�̡G$author

$your_email $module_create_date

$module_simple_description
H1

#--------------------------------------------------


$FILE_2=<<H2;
<?php

// \$Id\$

require_once "./module-cfg.php";

include_once "../../include/config.php";

?>
H2

#--------------------------------------------------

$FILE_3=<<H3;
<?php

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

// �s�� SFS3 �����Y
head("$module_chinese_name");

//
// �z���{���X�Ѧ��}�l



// SFS3 ������
foot();

?>
H3

#--------------------------------------------------

$FILE_4=<<H4;
<?php
// \$Id\$
header("Location: $mainfile");
?>
H4

#--------------------------------------------------


$FILE_5=<<H5;
* $module_chinese_name

** �w�˪k:

�� "�t�κ޲z" --> "�Ҳ��v���޲z"

** �Y���䥦�w�˻����A�иm��U�G

====
���G�o�̱ĥ� outline ���Ҧ��C

���� outline�A�аѦ� http://linux.tnc.edu.tw/techdoc/otl/ �������C
H5

#--------------------------------------------------


$FILE_6=<<H6;
<?php

// \$Id\$

//---------------------------------------------------
//
// 1.�o�̩w�q�G�Ҳո�ƪ�W�� (�� "�Ҳ��v���]�w" �{���ϥ�)
//   �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//-----------------------------------------------
//
// �Y���@�ӥH�W�A�б��� \$MODULE_TABLE_NAME �}�C�өw�q
//
// �]�i�H�ΥH�U�o�س]�k�G
//
// \$MODULE_TABLE_NAME=array(0=>"lunchtb", 1=>"xxxx");
// 
// \$MODULE_TABLE_NAME[0] = "lunchtb";
// \$MODULE_TABLE_NAME[1]="xxxx";
//
// �Ъ`�N�n�M module.sql ���� table �W�٤@�P!!!
//---------------------------------------------------

// ��ƪ�W�٩w�q

\$MODULE_TABLE_NAME[0] = "$table_name";

//---------------------------------------------------
//
// 2.�o�̩w�q�G�Ҳդ���W�١A�к�²�R�W (�� "�Ҳ��v���]�w" �{���ϥ�)
//
// ���|��ܵ��ϥΪ�
//-----------------------------------------------


\$MODULE_PRO_KIND_NAME = "$module_chinese_name";


//---------------------------------------------------
//
// 3. �o�̩w�q�G�Ҳժ���������T (�� "�۰ʧ�s�{��" ����)
//    �o�Ϫ� "�ܼƦW��" �Фŧ���!!!
//
//---------------------------------------------------

// �Ҳճ̫��s����
\$MODULE_UPDATE_VER="$module_version";

// �Ҳճ̫��s���
\$MODULE_UPDATE="$module_create_date";


//---------------------------------------------------
//
// 4. �o�̽Щw�q�G�z�o��{���ݭn�Ψ쪺�G�ܼƩα`��
//---------------------------------^^^^^^^^^^
//
// (���Q�Q "�ҲհѼƺ޲z" ���ު̡A�иm���)
//
// ��ĳ�G�о��q�έ^��j�g�өw�q�A�̦n�n��Ѧr���ݥX��N���N�q�C
//
// �o�Ϫ� "�ܼƦW��" �i�H�ۥѧ���!!!
//
//---------------------------------------------------


// �ݶ�


//---------------------------------------------------
//
// 5. �o�̩w�q�G�w�]�ȭn�� "�ҲհѼƺ޲z" �{���ӱ��ު̡A
//    �Y���Q�A�i�����]�w�C
//
// �榡�G var �N���ܼƦW��
//       msg �N����ܰT��
//       value �N���ܼƳ]�w��
//
// �Y�z�M�w�N�o���ܼƥ�� "�ҲհѼƺ޲z" �ӱ��ޡA����z���Ҳյ{��
// �N�n��o���ܼƦ��P���A�]�N�O���G�Y�o���ܼƭȦb�ҲհѼƺ޲z�����ܡA
// �z���ҲմN�n�w��o���ܼƦ����P���ʧ@�ϬM�C
//
// �Ҧp�G�Y�d���O�ҲաA���ѨC����ܵ��ƪ�����A�p�U�G
// \$SFS_MODULE_SETUP[1] =
// array('var'=>"PAGENUM", 'msg'=>"�C����ܵ���", 'value'=>10);
//
// �W�z���N��O���G�z�w�q�F�@���ܼ� PAGENUM�A�o���ܼƪ��w�]�Ȭ� 10
// PAGENUM ������W�٬� "�C����ܵ���"�A�o���ܼƦb�w�˼Ҳծɷ|�g�J
// pro_module �o�� table ��
//
// �ڭ̦����Ѥ@�Ө禡 get_module_setup
// �ѱz���Υثe�o���ܼƪ��̷s���p�ȡA
//
// �ϥΪk�G
//
// \$ret_array =& get_module_setup("$module_ename")
//
//
// �Ա��аѦ� include/sfs_core_module.php ���������C
//
// �o�Ϫ� "�ܼƦW�� \$SFS_MODULE_SETUP" �Фŧ���!!!
//---------------------------------------------------


//\$SFS_MODULE_SETUP[0] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>1);

// ��2,3,4....�ӡA�̦������G 

// \$SFS_MODULE_SETUP[1] =
//	array('var'=>"xxxx", 'msg'=>"yyyy", 'value'=>0);

// \$SFS_MODULE_SETUP[2] =
//	array('var'=>"ssss", 'msg'=>"tttt", 'value'=>1);

?>
H6


#--------------------------------------------------


$FILE_7=<<H7;
#
# ��ƪ�榡�G `$table_name`
#
# �бN�z����ƪ� CREATE TABLE �y�k�m��U�C
# �Y�L�A�h�бN���� module.sql �R���C




H7

#--------------------------------------------------

$FILE_8=<<H8;
* $module_create_date $module_version

$module_simple_description

====
���G�o�̱ĥ� outline ���Ҧ��C

���� outline�A�аѦ� http://linux.tnc.edu.tw/techdoc/otl/ �������C
H8

#--------------------------------------------------

$FILE_9=<<H9;
* �аѦ� INSTALL ������

====
���G�o�̱ĥ� outline ���Ҧ��C

���� outline�A�аѦ� http://linux.tnc.edu.tw/techdoc/otl/ �������C
H9


#--------------------------------------------------

$manifest=join "\n", sort values %FILES;

$FILE_10=<<HA;
* ���Ҳ��ɮצC��M��G(MANIFEST)

$manifest

HA

#--------------------------------------------------


print "\n�w�۰ʲ��ͥH�U SFS3 �зǼҲ��ɮסG\n\n";


foreach $n (keys %FILES) {

	$content="FILE_$n";
	create_module_file($FILES{$n}, $$content);

}


print "\n����!\n�۰ʲ��ͪ��Ҳ��ɮץ��b * $module_ename * �ؿ���!\n\n";
print "�ХH�o�ǼзǼҲ��ɬ����[�A�ӳ]�p�z���Ҳ�!\n\n";
print "�ѦҸ귽�G\n";
print "http://linux.tnc.edu.tw/techdoc/sfs-module-howto/t1.html\n";


#--------------------------------------

sub create_module_file {
    my ($filename, $content)=@_;

	print "$module_path/$module_ename/$filename\n";
	open(F, "> $module_path/$module_ename/$filename") || die;
	print F $content;
	close(F);
}



