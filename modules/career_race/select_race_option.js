
//������O
function SelectR_name(reset_option) {
	  if (reset_option) {
     removeAllOptions(document.myform.r_name);
     addOption(document.myform.r_name, "", "�п���v�ɶ���", "");
    }
    //��|��
    //����
    if (document.myform.level.value == '4' && document.myform.nature.value=='��|��') {
        addOption(document.myform.r_name, "���]���^�ŹB�ʷ|", "���]���^�ŹB�ʷ|", "");
        addOption(document.myform.r_name, "���]���^�Ť����Ǯ��p�X�B�ʷ|", "���]���^�Ť����Ǯ��p�X�B�ʷ|", "");
        addOption(document.myform.r_name, "����y���p�ɪ���", "����y���p�ɪ���", "");
        addOption(document.myform.r_name, "������p�ǯZ�ڤj�����O�A����", "������p�ǯZ�ڤj�����O�A����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    }
    //����
    if (document.myform.level.value == '2' && document.myform.nature.value=='��|��') {
        addOption(document.myform.r_name, "���ꤤ���ǮչB�ʷ|", "���ꤤ���ǮչB�ʷ|", "");
        addOption(document.myform.r_name, "����B�ʷ|", "����B�ʷ|", "");
        addOption(document.myform.r_name, "����y���p��", "����y���p��", "");
        addOption(document.myform.r_name, "�����B�ʷ|", "�����B�ʷ|", "");
        addOption(document.myform.r_name, "����U�涵�A����", "����U�涵�A����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    }

		//���
    if (document.myform.level.value == '1' && document.myform.nature.value=='��|��')
    {
        addOption(document.myform.r_name, "���L�ǧJ�B�ʷ|", "���L�ǧJ�B�ʷ|", "");
        addOption(document.myform.r_name, "�@�ɹB�ʷ|", "�@�ɹB�ʷ|", "");
        addOption(document.myform.r_name, "�Ȭw�B�ʷ|", "�Ȭw�B�ʷ|", "");
        addOption(document.myform.r_name, "�@�ɤ��ǥ͹B�ʷ|", "�@�ɤ��ǥ͹B�ʷ|", "");
        addOption(document.myform.r_name, "�@�ɬצU�涵�A����", "�@�ɬצU�涵�A����", "");
        addOption(document.myform.r_name, "�Ȭw�צU�涵�A����", "�Ȭw�צU�涵�A����", "");	
        addOption(document.myform.r_name, "�F�ȹB", "�F�ȹB", "");	
        addOption(document.myform.r_name, "�@�ɬשΨȬw�ס]�t�U�涵�^", "�@�ɬשΨȬw�ס]�t�U�涵�^", "");	
        addOption(document.myform.r_name, "�C�~���L�ǧJ�B�ʷ|", "�C�~���L�ǧJ�B�ʷ|", "");
        addOption(document.myform.r_name, "�F�ȹB�ʷ|", "�F�ȹB�ʷ|", "");
        addOption(document.myform.r_name, "�Ȭw�C�~�B�ʷ|", "�Ȭw�C�~�B�ʷ|", "");
        addOption(document.myform.r_name, "�Ȭw�F�y�B�ʷ|", "�Ȭw�F�y�B�ʷ|", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    }
    
    //�����
    //����
    if (document.myform.level.value == '4' && document.myform.nature.value=='�����') {
        addOption(document.myform.r_name, "���]���^�Ť��p�Ǭ�Ǯi���|", "���]���^�Ť��p�Ǭ�Ǯi���|", "");
        addOption(document.myform.r_name, "ContestWorld GreenMech Contest �@�ɾ������v�ɿ�(��)����", "ContestWorld GreenMech Contest �@�ɾ������v�ɿ�(��)����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    }
    //����
    if (document.myform.level.value == '2' && document.myform.nature.value=='�����') {
        addOption(document.myform.r_name, "���ꤤ�p�Ǭ�Ǯi���|", "���ꤤ�p�Ǭ�Ǯi���|", "");
        addOption(document.myform.r_name, "����u�~�����H�j��", "����u�~�����H�j��", "");
        addOption(document.myform.r_name, "����깩�׾����H�j��", "����깩�׾����H�j��", "");
        addOption(document.myform.r_name, "ContestWorld GreenMech Contest �@�ɾ������v�ɥ�����", "ContestWorld GreenMech Contest �@�ɾ������v�ɥ�����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    }

		//���
    if (document.myform.level.value == '1' && document.myform.nature.value=='�����')
    {
        addOption(document.myform.r_name, "��ڬ�i", "��ڬ�i", "");
        addOption(document.myform.r_name, "�[���j��Ǯi���|", "�[���j��Ǯi���|", "");
        addOption(document.myform.r_name, "������ڬ�Ǯi���|", "������ڬ�Ǯi���|", "");
        addOption(document.myform.r_name, "�����p�լ�Ǯi���|", "�����p�լ�Ǯi���|", "");
        addOption(document.myform.r_name, "�����ڬ�ޮi���|", "�����ڬ�ޮi���|", "");
        addOption(document.myform.r_name, "�s�[�Y��ޮi���|", "�s�[�Y��ޮi���|", "");
        addOption(document.myform.r_name, "���L�ǧJ�v��", "���L�ǧJ�v��", "");
        addOption(document.myform.r_name, "�@�ɬ׫C�֦~����H�v��", "�@�ɬ׫C�֦~����H�v��", "");
        addOption(document.myform.r_name, "��ڶ��L�ǧJ�����H�j��", "��ڶ��L�ǧJ�����H�j��", "");
        addOption(document.myform.r_name, "ContestWorld GreenMech Contest �@�ɾ������v��", "ContestWorld GreenMech Contest �@�ɾ������v��", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    }


    //�y����
    if (document.myform.nature.value=='�y����') {
    	//����
    	if (document.myform.level.value == '3') {
        addOption(document.myform.r_name, "���]���^�y���v��", "���]���^�y���v��", "");
        addOption(document.myform.r_name, "���]���^Ū�̼@���v��", "���]���^Ū�̼@���v��", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
    	//����
    	if (document.myform.level.value == '2') {
        addOption(document.myform.r_name, "����y���v��", "����y���v��", "");
        addOption(document.myform.r_name, "�Ш|�������Ч@��", "�Ш|�������Ч@��", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
	  } // end if �y����

    //������
    if (document.myform.nature.value=='������') {
    	//����
    	if (document.myform.level.value == '4') {
        addOption(document.myform.r_name, "����ǥͭ��֤��ɿ�(��)����", "����ǥͭ��֤��ɿ�(��)����", "");
        addOption(document.myform.r_name, "����v�Ͷm�g�q�����ɿ�(��)����", "����v�Ͷm�g�q�����ɿ�(��)����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
    	//����
    	if (document.myform.level.value == '2') {
        addOption(document.myform.r_name, "���ꭵ�֤���", "���ꭵ�֤���", "");
        addOption(document.myform.r_name, "����v�Ͷm�g�q������", "����v�Ͷm�g�q������", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}

			//���
    	if (document.myform.level.value == '1')	{
        addOption(document.myform.r_name, "�g�~�]�ҩ��A�T�Ӱ�a�H�W��������", "�g�~�]�ҩ��A�T�Ӱ�a�H�W��������", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
	  } // end if ������
    
    //���N��
    if (document.myform.nature.value=='���N��') {
    	//����
    	if (document.myform.level.value == '4') {
        addOption(document.myform.r_name, "����ǥͬ��N���ɿ�(��)����", "����ǥͬ��N���ɿ�(��)����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
    	//����
    	if (document.myform.level.value == '2') {
        addOption(document.myform.r_name, "����ǥͬ��N����", "����ǥͬ��N����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}

			//���
    	if (document.myform.level.value == '1')	{
        addOption(document.myform.r_name, "�g�~�]�ҩ��A�T�Ӱ�a�H�W��������", "�g�~�]�ҩ��A�T�Ӱ�a�H�W��������", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
	  } // end if ���N��
	  
    //�R����
    if (document.myform.nature.value=='�R����') {
    	//����
    	if (document.myform.level.value == '4') {
        addOption(document.myform.r_name, "����ǥͻR�Ф��ɿ�(��)����", "����ǥͻR�Ф��ɿ�(��)����", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
    	//����
    	if (document.myform.level.value == '2') {
        addOption(document.myform.r_name, "����ǥͻR�Ф���", "����ǥͻR�Ф���", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}

			//���
    	if (document.myform.level.value == '1')	{
        addOption(document.myform.r_name, "�g�~�]�ҩ��A�T�Ӱ�a�H�W��������", "�g�~�]�ҩ��A�T�Ӱ�a�H�W��������", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
	  } // end if �R����
	  
    //�����Ш|��
    if (document.myform.nature.value=='�����Ш|��') {
    	//����
    	if (document.myform.level.value == '4') {
        addOption(document.myform.r_name, "���]���^�ŧ����v��", "���]���^�ŧ����v��", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
 	  } // end if �����Ш|��
 	  
    //��X��
    if (document.myform.nature.value=='��X��') {
    	//����
    	if (document.myform.level.value == '4') {
        addOption(document.myform.r_name, "����ǥͳзN���@���ɿ�(��)����(��зN�����v��)", "����ǥͳзN���@���ɿ�(��)����(��зN�����v��)", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
    	//����
    	if (document.myform.level.value == '2') {
        addOption(document.myform.r_name, "����ǥͳзN���@����(��зN�����v��)", "����ǥͳзN���@����(��зN�����v��)", "");
        addOption(document.myform.r_name, "����ǥ͹ϵe�ѳЧ@��", "����ǥ͹ϵe�ѳЧ@��", "");
        addOption(document.myform.r_name, "����k�W��Ʈw�v�ɬ���", "����k�W��Ʈw�v�ɬ���", "");
        addOption(document.myform.r_name, "�������O���ѬD�ԾݻO��", "�������O���ѬD�ԾݻO��", "");
        addOption(document.myform.r_name, "�O�W�Ǯպ��ɳ����|", "�O�W�Ǯպ��ɳ����|", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}

			//���
    	if (document.myform.level.value == '1')	{
        addOption(document.myform.r_name, "��ھǮպ��ɳ����|", "��ھǮպ��ɳ����|", "");
        addOption(document.myform.r_name, "��L", "��L", "");
    	}
	  } // end if ��X��
	  
	  //��L��
    if (document.myform.level.value == '4' && document.myform.nature.value=='��L��') {
        addOption(document.myform.r_name, "��L", "��L", "");
        document.myform.weight.value='0';
        document.myform.weight_tech.value='0';
		}
    if (document.myform.level.value == '2' && document.myform.nature.value=='��L��') {
        addOption(document.myform.r_name, "��L", "��L", "");
        document.myform.weight.value='0';
        document.myform.weight_tech.value='0';
		}
    if (document.myform.level.value == '1' && document.myform.nature.value=='��L��') {
        addOption(document.myform.r_name, "��L", "��L", "");
        document.myform.weight.value='0';
        document.myform.weight_tech.value='0';
		}

	  
	  

    
}


////////////////// 

function Check_select() {
  if (document.myform.r_name.value=='��L') {
        document.myform.weight.value='0';
        document.myform.weight_tech.value='0';
  } else {
        document.myform.weight.value='1';
        document.myform.weight_tech.value='1';
  }
}

function removeAllOptions(selectbox)
{
    var i;
    for (i = selectbox.options.length - 1; i >= 0; i--)
    {
//selectbox.options.remove(i);
        selectbox.remove(i);
    }
}


function addOption(selectbox, value, text)
{
    var optn = document.createElement("OPTION");
    optn.text = text;
    optn.value = value;
    selectbox.options.add(optn);
}
