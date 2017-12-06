/**

$Id: sfs_script_value.js 5311 2009-01-10 08:11:55Z hami $
���N js_value.js

LogicalValue:�Τ_�P�_��H���ȬO�_�ŦX����A�{�w���Ѫ���ܦ��G
integer�G��ơA�i�P�_����ƩM�t���
number �G�B�I�ơA�P�˥i�P�O���t��
date �G������A�i�䴩�H�۩w���j�Ÿ�������榡�A�w�]�O�H'-'�����j�Ÿ�
string �G�P�_�@�Ӧr��]�A�Τ��]�A�Y�Ǧr��
�^�ǭȡGtrue��false

�ѼơG
ObjStr �G�ǭ�
ObjType�G�B�z���A('integer','number','date','string'���@)

��L�����G
�ŭȮɡA�^�ǿ��~�T���C

Author:PPDJ

*/
function LogicalValue(ObjStr,ObjType)
{
var str='';
if ((ObjStr==null) || (ObjStr=='') || ObjType==null)
{
alert('��� LogicalValue �ʤְѼ�');
return false;
}
var obj = document.all(ObjStr);
if (obj.value=='') return false;
for (var i=2;i<arguments.length;i++)
{
if (str!='')
str += ',';
str += 'arguments['+i+']';
}
str=(str==''?'obj.value':'obj.value,'+str);
var temp=ObjType.toLowerCase();
if (temp=='integer')
{
return eval('IsInteger('+str+')');
}
else if (temp=='number')
{
return eval('IsNumber('+str+')');
}
else if (temp=='string')
{
return eval('SpecialString('+str+')');
}
else if (temp=='date')
{
return eval('IsDate('+str+')');
}
else if (temp=='twToDate')
{
return eval('twToDate('+str+')');
}
else
{
alert('"'+temp+'"�����b�{�b������������');
return false;
}
}

/**
IsInteger: �Τ_�P�_�@�ӼƦr���r�Ŧ�O�_����ΡA
�i�P�_�O�_�O����Ʃέt��ơA��^�Ȭ�true��false
string: �ݭn�P�_���r��
sign: �Y�n�P�_�O����ƮɨϥΡA�O����'+'�A�t'-'�A���Ϋh��ܤ��@�P�_
Author: PPDJ
sample:
var a = '123';
if (IsInteger(a))
{
alert('a is a integer');
}
if (IsInteger(a,'+'))
{
alert(a is a positive integer);
}
if (IsInteger(a,'-'))
{
alert('a is a negative integer');
}
*/

function IsInteger(string ,sign)
{
var integer;
if ((sign!=null) && (sign!='-') && (sign!='+'))
{
alert('IsInter(string,sign)���ѼƥX���G\nsign��null��"-"��"+"');
return false;
}
integer = parseInt(string);
if (isNaN(integer))
{
return false;
}
else if (integer.toString().length==string.length)
{
if ((sign==null) || (sign=='-' && integer<0) || (sign=='+' && integer>0))
{
return true;
}
else
return false;
}
else
return false;
}

/**
twToDate: �N�������ର�褸���
�ѼơG
DateString�G �ݭn�P�_���r��
Dilimeter �G ��������j�Ÿ��A�w�]�Ȭ�'-'
Author: hami
*/

function twToDate(DateString,Dilimeter)
{
if (DateString==null) return false;
if (Dilimeter=='' || Dilimeter==null)
Dilimeter = '-';
var tempArray;
var tempa=0;	
var ttt ;
tempArray = DateString.split(Dilimeter);
tempa = parseInt(tempArray[0])+1911;	
ttt = tempa.toString();
ttt = ttt+Dilimeter+tempArray[1]+Dilimeter+tempArray[2];	
return  ttt;	
}

/*
��^�ȡG
true��false

�ѼơG
DateString�G �ݭn�P�_���r��
Dilimeter �G ��������j�Ÿ��A�w�]�Ȭ�'-'
Author: 


/**
IsDate: �Τ_�P�_�@�Ӧr��O�_�O����榡���r��

��^�ȡG
true��false

�ѼơG
DateString�G �ݭn�P�_���r��
Dilimeter �G ��������j�Ÿ��A�w�]�Ȭ�'-'
Author: PPDJ 


sample:
var date = '1999-1-2';
if (IsDate(date))
{
alert('You see, the default separator is "-");
}
date = '1999/1/2";
if (IsDate(date,'/'))
{
alert('The date\'s separator is "/");
}
*/

function IsDate(DateString , Dilimeter)
{
if (DateString==null) return false;
if (Dilimeter=='' || Dilimeter==null)
Dilimeter = '-';
var tempy='';
var tempm='';
var tempd='';
var mm=0;
var tempArray;
if (DateString.length<8 && DateString.length>10)
return false; 
tempArray = DateString.split(Dilimeter);
if (tempArray.length!=3)
return false;
if (tempArray[0].length==4)
{
tempy = tempArray[0];
tempd = tempArray[2];
}
else
{
tempy = tempArray[2];
tempd = tempArray[1];
}
tempm = tempArray[1];
if((tempm.length==2)&&(tempm.substring(0,1)=='0'))
tempm = tempm.substring(2,1);
if((tempd.length==2)&& (tempd.substring(0,1)=='0'))
tempd = tempd.substring(2,1);
var tDateString = tempy + '/'+tempm.toString() + '/'+tempd.toString()+' 8:0:0';//�[�K�p?�O�]?��??�_?�K?
var tempDate = new Date(tDateString);
if (isNaN(tempDate))
return false;
if (((tempDate.getUTCFullYear()).toString()==tempy) && (tempDate.getMonth()==parseInt(tempm)-1) && (tempDate.getDate()==parseInt(tempd)))
{
return true;
}
else
{
return false;
}
}


/**
IsNumber: �Τ_�P�_�@�ӼƦr���r��O�_�Ʀr�ȫ��A
�٥i�P�_�O�_�O���έt�A��^�Ȭ�true��false
string: �ݭn�P�_���r�Ŧ�
sign: �Y�n�P�_�O����ƮɨϥΡA�O����'+'�A�t'-'�A���Ϋh��ܤ��@�P�_
Author: PPDJ
sample:
var a = '123';
if (IsNumber(a))
{
alert('a is a number');
}
if (IsNumber(a,'+'))
{
alert(a is a positive number);
}
if (IsNumber(a,'-'))
{
alert('a is a negative number');
}
*/

function IsNumber(string,sign)
{
var number;
if (string==null) return false;
if ((sign!=null) && (sign!='-') && (sign!='+'))
{
alert('IsNumber(string,sign)���ѼƥX���G\nsign��null��"-"��"+"');
return false;
}
number = new Number(string);
if (isNaN(number))
{
return false;
}
else if ((sign==null) || (sign=='-' && number<0) || (sign=='+' && number>0))
{
return true;
}
else
return false;
}



/**
SpecialString: �Τ_�P�_�@�Ӧr�Ŧ�O�_�t���Τ��t���Y�Ǧr��

��^�ȡG
true��false

�ѼơG
string �G �ݭn�P�_���r��
compare �G ������r��(��Ǧr��)
BelongOrNot�G true��false�A"true"���string���C�@�Ӧr�곣�]�t�bcompare���A
"false"���string���C�@�Ӧr�ų����]�t�bcompare��

Author: PPDJ
sample1:
var str = '123G';
if (SpecialString(str,'1234567890'))
{
alert('Yes, All the letter of the string in \'1234567890\'');
}
else
{
alert('No, one or more letters of the string not in \'1234567890\'');
}
�p�G���檺�Oelse����
sample2:
var password = '1234';
if (!SpecialString(password,'\'"@#$%',false))
{
alert('Yes, The password is correct.');
}
else
{
alert('No, The password is contain one or more letters of \'"@#$%\'');
}
�p�G���檺�Oelse����
*/
function SpecialString(string,compare,BelongOrNot)
{
if ((string==null) || (compare==null) || ((BelongOrNot!=null) && (BelongOrNot!=true) && (BelongOrNot!=false)))
{
alert('function SpecialString(string,compare,BelongOrNot)????');
return false;
}
if (BelongOrNot==null || BelongOrNot==true)
{
for (var i=0;i<string.length;i++)
{
if (compare.indexOf(string.charAt(i))==-1)
return false
}
return true;
}
else
{
for (var i=0;i<string.length;i++)
{
if (compare.indexOf(string.charAt(i))!=-1)
return false
}
return true;
}
}
function checkok()
{
	var OK=true;	
	var chk_date='';	
	chk_date = twToDate(document.myform.tempbirthday.value,'-');
	alert(chk_date);
	if(IsDate(chk_date))
	{
		document.myform.birthday.value = chk_date;		
	}
	else
	{
		alert(document.myform.tempbirthday.value + '\n ���O���T�����');
		OK=false;
	}	
	return OK
}

function setfocus(element) {
	element.focus();
 return;
}
