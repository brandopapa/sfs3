<!-- //$Id: chi_text.js 5311 2009-01-10 08:11:55Z hami $ -->
<script language="JavaScript">
<!--


function moveit2(chi,event) {
	var pKey = event.keyCode;//�Q�r�� 38�V�W 40�V�U;37�V��;39�V�k
	if (pKey==40 || pKey==38  ) {
//	if (pKey==40 || pKey==38 || pKey==37 || pKey==39 ) {
	var max=document.f1.elements.length ;//�Ҧ�����ƶq
	var Go=0;//�n���ʦ�m
	TText= new Array ; //��r���}�C
	var Tin=0; //��r���}�C����
	var Tin_now=0; //��r���}�C���ޥثe��m
	for(i=0; i<max; i++) {
	var obj = document.f1.elements[i];
	if (obj.type == 'text')
	{
	TText[Tin]=i; //�O�U���b�Ҧ��������ĴX��
if(obj.name==chi.name ) {Tin_now=Tin;} //�p�G�O�Ƕi�Ӫ����,�N�O�U�����b��r���}�C���ޭ�
	Tin=Tin+1;
	}
	}
if (Tin==1 ) return false;//�Ȥ@�ӴN���n���F
// if (pKey==40 || pKey==39 ) KK=40;
// if (pKey==38 || pKey==37 ) KK=38;
switch (pKey){ //�`�j
	case 40://�V�U
		Tin=Tin-1;//���o���ޭ�
		(Tin_now == Tin ) ? Go=TText[0] : Go=TText[Tin_now+1];
		document.f1.elements[Go].focus();
		return false;
		break;
	case 38://�V�W
		Tin=Tin-1;//���o���ޭ�
		(Tin_now == 0 ) ? Go=TText[Tin] : Go=TText[(Tin_now-1)];
		document.f1.elements[Go].focus();
		return false;
		break;
		default:
	return false;
	}
	}
}

//-->
</script>
