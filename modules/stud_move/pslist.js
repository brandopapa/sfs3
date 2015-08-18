
function disp_text()
{
    var w = document.myform.selectschool.selectedIndex;
    var i = document.myform.selectcity.selectedIndex;
    var selected_city = document.myform.selectcity.options[i].text;
    var selected_value = document.myform.selectschool.options[w].value;
    var selected_text = document.myform.selectschool.options[w].text;
    document.myform.city.value = selected_city;
    document.myform.school.value = selected_text;
    document.myform.school_id.value = selected_value;
    if (selected_city == '��L' && selected_text == '��L') {
        document.myform.city.readOnly = false;
        document.myform.school.readOnly = false;
        document.myform.school_id.readOnly = false;
    } else {
        document.myform.city.readOnly = true;
        document.myform.school.readOnly = true;
        document.myform.school_id.readOnly = true;
    }
}

function fillCity() {
    document.myform.city.value = '';
    document.myform.school.value = '';
    document.myform.school_id.value = '';
    addOption(document.myform.selectcity, "��L", "��L", "");
    addOption(document.myform.selectcity, "�~�y��", "�~�y��", "");
    addOption(document.myform.selectcity, "��D�j����", "��D�j����", "");
    addOption(document.myform.selectcity, "�X��", "�X��", "");
    addOption(document.myform.selectcity, "�s�_��", "�s�_��", "");
    addOption(document.myform.selectcity, "�O�_��", "�O�_��", "");
    addOption(document.myform.selectcity, "�O����", "�O����", "");
    addOption(document.myform.selectcity, "�O�n��", "�O�n��", "");
    addOption(document.myform.selectcity, "������", "������", "");
    addOption(document.myform.selectcity, "�y����", "�y����", "");
    addOption(document.myform.selectcity, "��饫", "��饫", "");
    addOption(document.myform.selectcity, "�s�˿�", "�s�˿�", "");
    addOption(document.myform.selectcity, "�]�߿�", "�]�߿�", "");
    addOption(document.myform.selectcity, "���ƿ�", "���ƿ�", "");
    addOption(document.myform.selectcity, "�n�뿤", "�n�뿤", "");
    addOption(document.myform.selectcity, "���L��", "���L��", "");
    addOption(document.myform.selectcity, "�Ÿq��", "�Ÿq��", "");
    addOption(document.myform.selectcity, "�̪F��", "�̪F��", "");
    addOption(document.myform.selectcity, "�O�F��", "�O�F��", "");
    addOption(document.myform.selectcity, "�Ὤ��", "�Ὤ��", "");
    addOption(document.myform.selectcity, "���", "���", "");
    addOption(document.myform.selectcity, "�򶩥�", "�򶩥�", "");
    addOption(document.myform.selectcity, "�s�˥�", "�s�˥�", "");
    addOption(document.myform.selectcity, "�Ÿq��", "�Ÿq��", "");
    addOption(document.myform.selectcity, "������", "������", "");
    addOption(document.myform.selectcity, "�s����", "�s����", "");
}

function SelectCity() {
    removeAllOptions(document.myform.selectdistrict);
    addOption(document.myform.selectdistrict, "", "�п�ܰϰ�", "");
    // this function is used to fill the category list on load
    if (document.myform.selectcity.value == '��L') {
        addOption(document.myform.selectdistrict, "��L", "��L", "");
    }
    if (document.myform.selectcity.value == '�~�y��') {
        addOption(document.myform.selectdistrict, "�~�y��", "�~�y��", "");
    }
    if (document.myform.selectcity.value == '��D�j����') {
        addOption(document.myform.selectdistrict, "��D�j����", "��D�j����", "");
    }
    if (document.myform.selectcity.value == '�X��') {
        addOption(document.myform.selectdistrict, "�X��", "�X��", "");
    }
    if (document.myform.selectcity.value == '�s�_��')
    {
        addOption(document.myform.selectdistrict, "�éM��", "�éM��", "");
        addOption(document.myform.selectdistrict, "�K����", "�K����", "");
        addOption(document.myform.selectdistrict, "�Q�Ӱ�", "�Q�Ӱ�", "");
        addOption(document.myform.selectdistrict, "�g����", "�g����", "");
        addOption(document.myform.selectdistrict, "�O����", "�O����", "");
        addOption(document.myform.selectdistrict, "��L��", "��L��", "");
        addOption(document.myform.selectdistrict, "�a�q��", "�a�q��", "");
        addOption(document.myform.selectdistrict, "�T�l��", "�T�l��", "");
        addOption(document.myform.selectdistrict, "���M��", "���M��", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�U����", "�U����", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "�s����", "�s����", "");
        addOption(document.myform.selectdistrict, "�`�|��", "�`�|��", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�W�L��", "�W�L��", "");
        addOption(document.myform.selectdistrict, "��ڰ�", "��ڰ�", "");
        addOption(document.myform.selectdistrict, "���˰�", "���˰�", "");
        addOption(document.myform.selectdistrict, "�^�d��", "�^�d��", "");
        addOption(document.myform.selectdistrict, "���˰�", "���˰�", "");
        addOption(document.myform.selectdistrict, "�H����", "�H����", "");
        addOption(document.myform.selectdistrict, "�۪���", "�۪���", "");
        addOption(document.myform.selectdistrict, "�T�۰�", "�T�۰�", "");
        addOption(document.myform.selectdistrict, "�s����", "�s����", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "���Ѱ�", "���Ѱ�", "");
        addOption(document.myform.selectdistrict, "Ī�w��", "Ī�w��", "");
        addOption(document.myform.selectdistrict, "�L�f��", "�L�f��", "");
        addOption(document.myform.selectdistrict, "�T����", "�T����", "");
    }
    if (document.myform.selectcity.value == '�O�_��') {
        addOption(document.myform.selectdistrict, "�Q�s��", "�Q�s��", "");
        addOption(document.myform.selectdistrict, "�H�q��", "�H�q��", "");
        addOption(document.myform.selectdistrict, "�j�w��", "�j�w��", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�j�P��", "�j�P��", "");
        addOption(document.myform.selectdistrict, "�U�ذ�", "�U�ذ�", "");
        addOption(document.myform.selectdistrict, "��s��", "��s��", "");
        addOption(document.myform.selectdistrict, "�n���", "�n���", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�h�L��", "�h�L��", "");
        addOption(document.myform.selectdistrict, "�_���", "�_���", "");
    }
    if (document.myform.selectcity.value == '�O����') {
        addOption(document.myform.selectdistrict, "��l��", "��l��", "");
        addOption(document.myform.selectdistrict, "�׭��", "�׭��", "");
        addOption(document.myform.selectdistrict, "�Z����", "�Z����", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�j����", "�j����", "");
        addOption(document.myform.selectdistrict, "�~�H��", "�~�H��", "");
        addOption(document.myform.selectdistrict, "�F�հ�", "�F�հ�", "");
        addOption(document.myform.selectdistrict, "�۩���", "�۩���", "");
        addOption(document.myform.selectdistrict, "�s����", "�s����", "");
        addOption(document.myform.selectdistrict, "�M����", "�M����", "");
        addOption(document.myform.selectdistrict, "��ϰ�", "��ϰ�", "");
        addOption(document.myform.selectdistrict, "�j�Ұ�", "�j�Ұ�", "");
        addOption(document.myform.selectdistrict, "�F����", "�F����", "");
        addOption(document.myform.selectdistrict, "�s����", "�s����", "");
        addOption(document.myform.selectdistrict, "�Q���", "�Q���", "");
        addOption(document.myform.selectdistrict, "�j�{��", "�j�{��", "");
        addOption(document.myform.selectdistrict, "�j����", "�j����", "");
        addOption(document.myform.selectdistrict, "���p��", "���p��", "");
        addOption(document.myform.selectdistrict, "�ӥ���", "�ӥ���", "");
        addOption(document.myform.selectdistrict, "�M����", "�M����", "");
        addOption(document.myform.selectdistrict, "�j�w��", "�j�w��", "");
        addOption(document.myform.selectdistrict, "�_��", "�_��", "");
        addOption(document.myform.selectdistrict, "�_�ٰ�", "�_�ٰ�", "");
        addOption(document.myform.selectdistrict, "��ٰ�", "��ٰ�", "");
        addOption(document.myform.selectdistrict, "����", "����", "");
        addOption(document.myform.selectdistrict, "�F��", "�F��", "");
        addOption(document.myform.selectdistrict, "���", "���", "");
        addOption(document.myform.selectdistrict, "�n��", "�n��", "");
        addOption(document.myform.selectdistrict, "�n�ٰ�", "�n�ٰ�", "");
    }
    if (document.myform.selectcity.value == '�O�n��') {
        addOption(document.myform.selectdistrict, "�F��", "�F��", "");
        addOption(document.myform.selectdistrict, "�n��", "�n��", "");
        addOption(document.myform.selectdistrict, "�_��", "�_��", "");
        addOption(document.myform.selectdistrict, "���w��", "���w��", "");
        addOption(document.myform.selectdistrict, "�k����", "�k����", "");
        addOption(document.myform.selectdistrict, "���q��", "���q��", "");
        addOption(document.myform.selectdistrict, "�s�T��", "�s�T��", "");
        addOption(document.myform.selectdistrict, "�ñd��", "�ñd��", "");
        addOption(document.myform.selectdistrict, "�s�ư�", "�s�ư�", "");
        addOption(document.myform.selectdistrict, "�s�W��", "�s�W��", "");
        addOption(document.myform.selectdistrict, "�ɤ���", "�ɤ���", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�n�ư�", "�n�ư�", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "���ư�", "���ư�", "");
        addOption(document.myform.selectdistrict, "�s����", "�s����", "");
        addOption(document.myform.selectdistrict, "�w�w��", "�w�w��", "");
        addOption(document.myform.selectdistrict, "�¨���", "�¨���", "");
        addOption(document.myform.selectdistrict, "�Ψ���", "�Ψ���", "");
        addOption(document.myform.selectdistrict, "����", "����", "");
        addOption(document.myform.selectdistrict, "�C�Ѱ�", "�C�Ѱ�", "");
        addOption(document.myform.selectdistrict, "�N�x��", "�N�x��", "");
        addOption(document.myform.selectdistrict, "�_����", "�_����", "");
        addOption(document.myform.selectdistrict, "�ǥҰ�", "�ǥҰ�", "");
        addOption(document.myform.selectdistrict, "�U���", "�U���", "");
        addOption(document.myform.selectdistrict, "���Ұ�", "���Ұ�", "");
        addOption(document.myform.selectdistrict, "�x�а�", "�x�а�", "");
        addOption(document.myform.selectdistrict, "�j����", "�j����", "");
        addOption(document.myform.selectdistrict, "�s���", "�s���", "");
        addOption(document.myform.selectdistrict, "�Q����", "�Q����", "");
        addOption(document.myform.selectdistrict, "�ժe��", "�ժe��", "");
        addOption(document.myform.selectdistrict, "�h���", "�h���", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�F�s��", "�F�s��", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�w����", "�w����", "");
        addOption(document.myform.selectdistrict, "�w�n��", "�w�n��", "");
    }
    if (document.myform.selectcity.value == '������') {
        addOption(document.myform.selectdistrict, "��s��", "��s��", "");
        addOption(document.myform.selectdistrict, "�L���", "�L���", "");
        addOption(document.myform.selectdistrict, "�j�d��", "�j�d��", "");
        addOption(document.myform.selectdistrict, "�j���", "�j���", "");
        addOption(document.myform.selectdistrict, "���Z��", "���Z��", "");
        addOption(document.myform.selectdistrict, "�j����", "�j����", "");
        addOption(document.myform.selectdistrict, "���Q��", "���Q��", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "���Y��", "���Y��", "");
        addOption(document.myform.selectdistrict, "�P�_��", "�P�_��", "");
        addOption(document.myform.selectdistrict, "�мd��", "�мd��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "���˰�", "���˰�", "");
        addOption(document.myform.selectdistrict, "�򤺰�", "�򤺰�", "");
        addOption(document.myform.selectdistrict, "�X�_��", "�X�_��", "");
        addOption(document.myform.selectdistrict, "�æw��", "�æw��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "��x��", "��x��", "");
        addOption(document.myform.selectdistrict, "�X�s��", "�X�s��", "");
        addOption(document.myform.selectdistrict, "���@��", "���@��", "");
        addOption(document.myform.selectdistrict, "���t��", "���t��", "");
        addOption(document.myform.selectdistrict, "���L��", "���L��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�ҥP��", "�ҥP��", "");
        addOption(document.myform.selectdistrict, "�����L��", "�����L��", "");
        addOption(document.myform.selectdistrict, "�Z�L��", "�Z�L��", "");
        addOption(document.myform.selectdistrict, "�緽��", "�緽��", "");
        addOption(document.myform.selectdistrict, "�Q�L��", "�Q�L��", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�T����", "�T����", "");
        addOption(document.myform.selectdistrict, "�s����", "�s����", "");
        addOption(document.myform.selectdistrict, "�e����", "�e����", "");
        addOption(document.myform.selectdistrict, "�d����", "�d����", "");
        addOption(document.myform.selectdistrict, "�e���", "�e���", "");
        addOption(document.myform.selectdistrict, "�X�z��", "�X�z��", "");
        addOption(document.myform.selectdistrict, "�p���", "�p���", "");
    }
    if (document.myform.selectcity.value == '�y����') {
        addOption(document.myform.selectdistrict, "�y����", "�y����", "");
        addOption(document.myform.selectdistrict, "ù�F��", "ù�F��", "");
        addOption(document.myform.selectdistrict, "Ĭ�D��", "Ĭ�D��", "");
        addOption(document.myform.selectdistrict, "�Y����", "�Y����", "");
        addOption(document.myform.selectdistrict, "�G�˶m", "�G�˶m", "");
        addOption(document.myform.selectdistrict, "���s�m", "���s�m", "");
        addOption(document.myform.selectdistrict, "����m", "����m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "�V�s�m", "�V�s�m", "");
        addOption(document.myform.selectdistrict, "�T�P�m", "�T�P�m", "");
        addOption(document.myform.selectdistrict, "�j�P�m", "�j�P�m", "");
        addOption(document.myform.selectdistrict, "�n�D�m", "�n�D�m", "");
    }
    if (document.myform.selectcity.value == '��饫') {
        addOption(document.myform.selectdistrict, "����", "����", "");
        addOption(document.myform.selectdistrict, "�K�w��", "�K�w��", "");
        addOption(document.myform.selectdistrict, "�j�˰�", "�j�˰�", "");
        addOption(document.myform.selectdistrict, "Ī�˰�", "Ī�˰�", "");
        addOption(document.myform.selectdistrict, "�t�s��", "�t�s��", "");
        addOption(document.myform.selectdistrict, "�j���", "�j���", "");
        addOption(document.myform.selectdistrict, "���c��", "���c��", "");
        addOption(document.myform.selectdistrict, "�s���", "�s���", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�s�ΰ�", "�s�ΰ�", "");
        addOption(document.myform.selectdistrict, "�_����", "�_����", "");
        addOption(document.myform.selectdistrict, "�[����", "�[����", "");
    }
    if (document.myform.selectcity.value == '�s�˿�') {
        addOption(document.myform.selectdistrict, "�˪F��", "�˪F��", "");
        addOption(document.myform.selectdistrict, "�˥_��", "�˥_��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�s�H��", "�s�H��", "");
        addOption(document.myform.selectdistrict, "��f�m", "��f�m", "");
        addOption(document.myform.selectdistrict, "�s�׶m", "�s�׶m", "");
        addOption(document.myform.selectdistrict, "��s�m", "��s�m", "");
        addOption(document.myform.selectdistrict, "�|�L�m", "�|�L�m", "");
        addOption(document.myform.selectdistrict, "�_�s�m", "�_�s�m", "");
        addOption(document.myform.selectdistrict, "�_�H�m", "�_�H�m", "");
        addOption(document.myform.selectdistrict, "�o�ܶm", "�o�ܶm", "");
        addOption(document.myform.selectdistrict, "�y�۶m", "�y�۶m", "");
        addOption(document.myform.selectdistrict, "���p�m", "���p�m", "");
    }
    if (document.myform.selectcity.value == '�]�߿�') {
        addOption(document.myform.selectdistrict, "�]�ߥ�", "�]�ߥ�", "");
        addOption(document.myform.selectdistrict, "�Y�ζm", "�Y�ζm", "");
        addOption(document.myform.selectdistrict, "���]�m", "���]�m", "");
        addOption(document.myform.selectdistrict, "���r�m", "���r�m", "");
        addOption(document.myform.selectdistrict, "�T�q�m", "�T�q�m", "");
        addOption(document.myform.selectdistrict, "�b����", "�b����", "");
        addOption(document.myform.selectdistrict, "�q�]��", "�q�]��", "");
        addOption(document.myform.selectdistrict, "���m", "���m", "");
        addOption(document.myform.selectdistrict, "�Y����", "�Y����", "");
        addOption(document.myform.selectdistrict, "�˫n��", "�˫n��", "");
        addOption(document.myform.selectdistrict, "�T�W�m", "�T�W�m", "");
        addOption(document.myform.selectdistrict, "�n�ܶm", "�n�ܶm", "");
        addOption(document.myform.selectdistrict, "�y���m", "�y���m", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "�j��m", "�j��m", "");
        addOption(document.myform.selectdistrict, "���m", "���m", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "���w�m", "���w�m", "");
    }
    if (document.myform.selectcity.value == '���ƿ�') {
        addOption(document.myform.selectdistrict, "���ƥ�", "���ƥ�", "");
        addOption(document.myform.selectdistrict, "���m", "���m", "");
        addOption(document.myform.selectdistrict, "��¶m", "��¶m", "");
        addOption(document.myform.selectdistrict, "�M����", "�M����", "");
        addOption(document.myform.selectdistrict, "�u��m", "�u��m", "");
        addOption(document.myform.selectdistrict, "����m", "����m", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�ֿ��m", "�ֿ��m", "");
        addOption(document.myform.selectdistrict, "�q���m", "�q���m", "");
        addOption(document.myform.selectdistrict, "�˴���", "�˴���", "");
        addOption(document.myform.selectdistrict, "�H�Q�m", "�H�Q�m", "");
        addOption(document.myform.selectdistrict, "�H�߶m", "�H�߶m", "");
        addOption(document.myform.selectdistrict, "���L��", "���L��", "");
        addOption(document.myform.selectdistrict, "�j���m", "�j���m", "");
        addOption(document.myform.selectdistrict, "�ùt�m", "�ùt�m", "");
        addOption(document.myform.selectdistrict, "�Ф���", "�Ф���", "");
        addOption(document.myform.selectdistrict, "���Y�m", "���Y�m", "");
        addOption(document.myform.selectdistrict, "�G���m", "�G���m", "");
        addOption(document.myform.selectdistrict, "�_����", "�_����", "");
        addOption(document.myform.selectdistrict, "�Ч��m", "�Ч��m", "");
        addOption(document.myform.selectdistrict, "���Y�m", "���Y�m", "");
        addOption(document.myform.selectdistrict, "�˦{�m", "�˦{�m", "");
        addOption(document.myform.selectdistrict, "�G�L��", "�G�L��", "");
        addOption(document.myform.selectdistrict, "�j���m", "�j���m", "");
        addOption(document.myform.selectdistrict, "�˶�m", "�˶�m", "");
        addOption(document.myform.selectdistrict, "�ڭb�m", "�ڭb�m", "");
    }
    if (document.myform.selectcity.value == '�n�뿤') {
        addOption(document.myform.selectdistrict, "�H����", "�H����", "");
        addOption(document.myform.selectdistrict, "�n�륫", "�n�륫", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�ˤs��", "�ˤs��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�W���m", "�W���m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "���d�m", "���d�m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "��m�m", "��m�m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "�H�q�m", "�H�q�m", "");
        addOption(document.myform.selectdistrict, "���R�m", "���R�m", "");
    }
    if (document.myform.selectcity.value == '���L��') {
        addOption(document.myform.selectdistrict, "�j�|�m", "�j�|�m", "");
        addOption(document.myform.selectdistrict, "�椻��", "�椻��", "");
        addOption(document.myform.selectdistrict, "�L���m", "�L���m", "");
        addOption(document.myform.selectdistrict, "��n��", "��n��", "");
        addOption(document.myform.selectdistrict, "�l��m", "�l��m", "");
        addOption(document.myform.selectdistrict, "�j��m", "�j��m", "");
        addOption(document.myform.selectdistrict, "�����", "�����", "");
        addOption(document.myform.selectdistrict, "�g�w��", "�g�w��", "");
        addOption(document.myform.selectdistrict, "�ǩ��m", "�ǩ��m", "");
        addOption(document.myform.selectdistrict, "�F�նm", "�F�նm", "");
        addOption(document.myform.selectdistrict, "�O��m", "�O��m", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "�G�[�m", "�G�[�m", "");
        addOption(document.myform.selectdistrict, "�[�I�m", "�[�I�m", "");
        addOption(document.myform.selectdistrict, "���d�m", "���d�m", "");
        addOption(document.myform.selectdistrict, "�_����", "�_����", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "�|��m", "�|��m", "");
        addOption(document.myform.selectdistrict, "�f��m", "�f��m", "");
        addOption(document.myform.selectdistrict, "���L�m", "���L�m", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��') {
        addOption(document.myform.selectdistrict, "���l��", "���l��", "");
        addOption(document.myform.selectdistrict, "���U��", "���U��", "");
        addOption(document.myform.selectdistrict, "�j�L��", "�j�L��", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "�ˤf�m", "�ˤf�m", "");
        addOption(document.myform.selectdistrict, "�s��m", "�s��m", "");
        addOption(document.myform.selectdistrict, "���}�m", "���}�m", "");
        addOption(document.myform.selectdistrict, "�F�۶m", "�F�۶m", "");
        addOption(document.myform.selectdistrict, "����m", "����m", "");
        addOption(document.myform.selectdistrict, "�q�˶m", "�q�˶m", "");
        addOption(document.myform.selectdistrict, "�ӫO��", "�ӫO��", "");
        addOption(document.myform.selectdistrict, "���W�m", "���W�m", "");
        addOption(document.myform.selectdistrict, "���H�m", "���H�m", "");
        addOption(document.myform.selectdistrict, "�f���m", "�f���m", "");
        addOption(document.myform.selectdistrict, "�˱T�m", "�˱T�m", "");
        addOption(document.myform.selectdistrict, "���s�m", "���s�m", "");
        addOption(document.myform.selectdistrict, "�j�H�m", "�j�H�m", "");
        addOption(document.myform.selectdistrict, "�����s�m", "�����s�m", "");
    }
    if (document.myform.selectcity.value == '�̪F��') {
        addOption(document.myform.selectdistrict, "�̪F��", "�̪F��", "");
        addOption(document.myform.selectdistrict, "�U���m", "�U���m", "");
        addOption(document.myform.selectdistrict, "�ﬥ�m", "�ﬥ�m", "");
        addOption(document.myform.selectdistrict, "�E�p�m", "�E�p�m", "");
        addOption(document.myform.selectdistrict, "���v�m", "���v�m", "");
        addOption(document.myform.selectdistrict, "�Q�H�m", "�Q�H�m", "");
        addOption(document.myform.selectdistrict, "����m", "����m", "");
        addOption(document.myform.selectdistrict, "����m", "����m", "");
        addOption(document.myform.selectdistrict, "��{��", "��{��", "");
        addOption(document.myform.selectdistrict, "�U�r�m", "�U�r�m", "");
        addOption(document.myform.selectdistrict, "���H�m", "���H�m", "");
        addOption(document.myform.selectdistrict, "�˥жm", "�˥жm", "");
        addOption(document.myform.selectdistrict, "�s��m", "�s��m", "");
        addOption(document.myform.selectdistrict, "�D�d�m", "�D�d�m", "");
        addOption(document.myform.selectdistrict, "�F����", "�F����", "");
        addOption(document.myform.selectdistrict, "�s��m", "�s��m", "");
        addOption(document.myform.selectdistrict, "�[�y�m", "�[�y�m", "");
        addOption(document.myform.selectdistrict, "�r���m", "�r���m", "");
        addOption(document.myform.selectdistrict, "�L��m", "�L��m", "");
        addOption(document.myform.selectdistrict, "�n�{�m", "�n�{�m", "");
        addOption(document.myform.selectdistrict, "�ΥV�m", "�ΥV�m", "");
        addOption(document.myform.selectdistrict, "��K��", "��K��", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "���{�m", "���{�m", "");
        addOption(document.myform.selectdistrict, "�D�s�m", "�D�s�m", "");
        addOption(document.myform.selectdistrict, "�T�a���m", "�T�a���m", "");
        addOption(document.myform.selectdistrict, "���a�m", "���a�m", "");
        addOption(document.myform.selectdistrict, "���O�m", "���O�m", "");
        addOption(document.myform.selectdistrict, "���Z�m", "���Z�m", "");
        addOption(document.myform.selectdistrict, "�Ӹq�m", "�Ӹq�m", "");
        addOption(document.myform.selectdistrict, "�K��m", "�K��m", "");
        addOption(document.myform.selectdistrict, "��l�m", "��l�m", "");
        addOption(document.myform.selectdistrict, "�d���m", "�d���m", "");
    }
    if (document.myform.selectcity.value == '�O�F��') {
        addOption(document.myform.selectdistrict, "�O�F��", "�O�F��", "");
        addOption(document.myform.selectdistrict, "���n�m", "���n�m", "");
        addOption(document.myform.selectdistrict, "�ӳ¨��m", "�ӳ¨��m", "");
        addOption(document.myform.selectdistrict, "�j�Z�m", "�j�Z�m", "");
        addOption(document.myform.selectdistrict, "��q�m", "��q�m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "���W�m", "���W�m", "");
        addOption(document.myform.selectdistrict, "�F�e�m", "�F�e�m", "");
        addOption(document.myform.selectdistrict, "���\��", "���\��", "");
        addOption(document.myform.selectdistrict, "���ضm", "���ضm", "");
        addOption(document.myform.selectdistrict, "���p�m", "���p�m", "");
        addOption(document.myform.selectdistrict, "�F���m", "�F���m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "���ݶm", "���ݶm", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��') {
        addOption(document.myform.selectdistrict, "�Ὤ��", "�Ὤ��", "");
        addOption(document.myform.selectdistrict, "�s���m", "�s���m", "");
        addOption(document.myform.selectdistrict, "�N�w�m", "�N�w�m", "");
        addOption(document.myform.selectdistrict, "���׶m", "���׶m", "");
        addOption(document.myform.selectdistrict, "��L��", "��L��", "");
        addOption(document.myform.selectdistrict, "���_�m", "���_�m", "");
        addOption(document.myform.selectdistrict, "���J�m", "���J�m", "");
        addOption(document.myform.selectdistrict, "���ضm", "���ضm", "");
        addOption(document.myform.selectdistrict, "�ɨ���", "�ɨ���", "");
        addOption(document.myform.selectdistrict, "�I���m", "�I���m", "");
        addOption(document.myform.selectdistrict, "�I���m", "�I���m", "");
        addOption(document.myform.selectdistrict, "�q�L�m", "�q�L�m", "");
        addOption(document.myform.selectdistrict, "�U�a�m", "�U�a�m", "");
        addOption(document.myform.selectdistrict, "���˶m", "���˶m", "");
    }
    if (document.myform.selectcity.value == '���') {
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "���m", "���m", "");
        addOption(document.myform.selectdistrict, "�ըF�m", "�ըF�m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "��w�m", "��w�m", "");
        addOption(document.myform.selectdistrict, "�C���m", "�C���m", "");
    }
    if (document.myform.selectcity.value == '�򶩥�') {
        addOption(document.myform.selectdistrict, "���R��", "���R��", "");
        addOption(document.myform.selectdistrict, "�w�ְ�", "�w�ְ�", "");
        addOption(document.myform.selectdistrict, "�C����", "�C����", "");
        addOption(document.myform.selectdistrict, "�x�x��", "�x�x��", "");
        addOption(document.myform.selectdistrict, "�H�q��", "�H�q��", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
    }
    if (document.myform.selectcity.value == '�s�˥�') {
        addOption(document.myform.selectdistrict, "�F��", "�F��", "");
        addOption(document.myform.selectdistrict, "�_��", "�_��", "");
        addOption(document.myform.selectdistrict, "���s��", "���s��", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��') {
        addOption(document.myform.selectdistrict, "�F��", "�F��", "");
        addOption(document.myform.selectdistrict, "���", "���", "");
    }
    if (document.myform.selectcity.value == '������') {
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "����m", "����m", "");
        addOption(document.myform.selectdistrict, "������", "������", "");
        addOption(document.myform.selectdistrict, "���F��", "���F��", "");
        addOption(document.myform.selectdistrict, "�P���m", "�P���m", "");
    }
    if (document.myform.selectcity.value == '�s����') {
        addOption(document.myform.selectdistrict, "�n��m", "�n��m", "");
        addOption(document.myform.selectdistrict, "�_��m", "�_��m", "");
        addOption(document.myform.selectdistrict, "�����m", "�����m", "");
        addOption(document.myform.selectdistrict, "�F�޶m", "�F�޶m", "");
    }
}

function SelectDistrict() {
    removeAllOptions(document.myform.selectschool);
    addOption(document.myform.selectschool, "", "�п�ܾǮ�", "");
    if (document.myform.selectcity.value == '��L' && document.myform.selectdistrict.value == '��L') {
        addOption(document.myform.selectschool, "??????", "��L", "");
    }
    if (document.myform.selectcity.value == '�~�y��' && document.myform.selectdistrict.value == '�~�y��') {
        addOption(document.myform.selectschool, "??????", "�~�y��", "");
    }
    if (document.myform.selectcity.value == '��D�j����' && document.myform.selectdistrict.value == '��D�j����') {
        addOption(document.myform.selectschool, "??????", "��D�j����", "");
    }
    if (document.myform.selectcity.value == '�X��' && document.myform.selectdistrict.value == '�X��') {
        addOption(document.myform.selectschool, "??????", "�X��", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�éM��') {
        addOption(document.myform.selectschool, "011601", "�p�ߨ|�~��p", "");
        addOption(document.myform.selectschool, "011603", "�p�ߤΤH��p", "");
        addOption(document.myform.selectschool, "011604", "�p�ߦ˪L��p", "");
        addOption(document.myform.selectschool, "014641", "���ߥéM��p", "");
        addOption(document.myform.selectschool, "014642", "���ߨq�԰�p", "");
        addOption(document.myform.selectschool, "014643", "���߳��˰�p", "");
        addOption(document.myform.selectschool, "014644", "���ߺ��˰�p", "");
        addOption(document.myform.selectschool, "014645", "���ߥå���p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�K����') {
        addOption(document.myform.selectschool, "011602", "�p�߸t�߰�p", "");
        addOption(document.myform.selectschool, "014746", "���ߤK����p", "");
        addOption(document.myform.selectschool, "014747", "���ߪ��|��p", "");
        addOption(document.myform.selectschool, "014748", "���ߦ̭ܰ�p", "");
        addOption(document.myform.selectschool, "014805", "���ߤj�r��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�Q�Ӱ�') {
        addOption(document.myform.selectschool, "011606", "�p�߫H��ج�ˤl��p", "");
        addOption(document.myform.selectschool, "014684", "���߯Q�Ӱ�(��)�p", "");
        addOption(document.myform.selectschool, "014685", "���ߺ֤s��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�g����') {
        addOption(document.myform.selectschool, "011607", "�p�߸μw��(��)�p", "");
        addOption(document.myform.selectschool, "014646", "���ߤg����p", "");
        addOption(document.myform.selectschool, "014647", "���߲M����p", "");
        addOption(document.myform.selectschool, "014648", "���߳��H��p", "");
        addOption(document.myform.selectschool, "014649", "���߼s�ְ�p", "");
        addOption(document.myform.selectschool, "014773", "���߼֧Q��p", "");
        addOption(document.myform.selectschool, "014774", "���ߦw�M��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�O����') {
        addOption(document.myform.selectschool, "014601", "���ߪO����p", "");
        addOption(document.myform.selectschool, "014602", "���߰����p", "");
        addOption(document.myform.selectschool, "014603", "���߷s�H��p", "");
        addOption(document.myform.selectschool, "014604", "���߮H�Y��p", "");
        addOption(document.myform.selectschool, "014605", "���߲�����p", "");
        addOption(document.myform.selectschool, "014606", "���߫�H��p", "");
        addOption(document.myform.selectschool, "014607", "���߮��s��p", "");
        addOption(document.myform.selectschool, "014608", "���ߦ��A��p", "");
        addOption(document.myform.selectschool, "014610", "���ߤ�t��p", "");
        addOption(document.myform.selectschool, "014611", "���ߨF�[��p", "");
        addOption(document.myform.selectschool, "014612", "���ߤ�w��p", "");
        addOption(document.myform.selectschool, "014766", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "014768", "���߹���p", "");
        addOption(document.myform.selectschool, "014769", "���ߤj�[��p", "");
        addOption(document.myform.selectschool, "014770", "���߷ˬw��p", "");
        addOption(document.myform.selectschool, "014771", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "014772", "���߭��y��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '��L��') {
        addOption(document.myform.selectschool, "014613", "���߾�L��p", "");
        addOption(document.myform.selectschool, "014614", "���ߤ�L��p", "");
        addOption(document.myform.selectschool, "014615", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "014616", "���ߪZ�L��p", "");
        addOption(document.myform.selectschool, "014617", "���ߤs�ΰ�p", "");
        addOption(document.myform.selectschool, "014618", "���ߨ|�w��p", "");
        addOption(document.myform.selectschool, "014619", "���߬a���p", "");
        addOption(document.myform.selectschool, "014767", "���ߤT�h��p", "");
        addOption(document.myform.selectschool, "014775", "���ߴ^�ְ�p", "");
        addOption(document.myform.selectschool, "014776", "���ߨ|�L��p", "");
        addOption(document.myform.selectschool, "014814", "���߮�l�}��(��)�p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�a�q��') {
        addOption(document.myform.selectschool, "014620", "�����a�q��p", "");
        addOption(document.myform.selectschool, "014621", "���ߤG����p", "");
        addOption(document.myform.selectschool, "014622", "���ߤ����p", "");
        addOption(document.myform.selectschool, "014623", "���߻���p", "");
        addOption(document.myform.selectschool, "014777", "���߫ذ��p", "");
        addOption(document.myform.selectschool, "014804", "���ߥæN��p", "");
        addOption(document.myform.selectschool, "014807", "���ߩ��ְ�p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�T�l��') {
        addOption(document.myform.selectschool, "014624", "���ߤT�l��p", "");
        addOption(document.myform.selectschool, "014625", "���ߤj�H��p", "");
        addOption(document.myform.selectschool, "014626", "���ߥ��q��p", "");
        addOption(document.myform.selectschool, "014627", "���ߦ��ְ�p", "");
        addOption(document.myform.selectschool, "014628", "���ߤj����p", "");
        addOption(document.myform.selectschool, "014629", "���߫ئw��p", "");
        addOption(document.myform.selectschool, "014630", "���ߴ�����p", "");
        addOption(document.myform.selectschool, "014631", "���ߦ����p", "");
        addOption(document.myform.selectschool, "014632", "���ߤ��d��p", "");
        addOption(document.myform.selectschool, "014778", "���ߦw�˰�p", "");
        addOption(document.myform.selectschool, "014799", "���ߤ��ذ�p", "");
        addOption(document.myform.selectschool, "014806", "���ߤ����p", "");
        addOption(document.myform.selectschool, "014815", "�����s�H��p", "");
        addOption(document.myform.selectschool, "013601", "���ߥ_�j��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���M��') {
        addOption(document.myform.selectschool, "014633", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "014634", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "014635", "���߿��n��p", "");
        addOption(document.myform.selectschool, "014636", "���ߨq�s��p", "");
        addOption(document.myform.selectschool, "014637", "���߿n�J��p", "");
        addOption(document.myform.selectschool, "014638", "���ߦ۱j��p", "");
        addOption(document.myform.selectschool, "014639", "�����A�M��p", "");
        addOption(document.myform.selectschool, "014640", "���ߴ��s��p", "");
        addOption(document.myform.selectschool, "014796", "���ߥ��_��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "014650", "���ߦ����p", "");
        addOption(document.myform.selectschool, "014651", "���ߪ��w��p", "");
        addOption(document.myform.selectschool, "014652", "���߫O����p", "");
        addOption(document.myform.selectschool, "014653", "���߱R�w��p", "");
        addOption(document.myform.selectschool, "014654", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "014655", "���ߥ_�p��p", "");
        addOption(document.myform.selectschool, "014656", "���ߪF�s��p", "");
        addOption(document.myform.selectschool, "014657", "���ߥն���p", "");
        addOption(document.myform.selectschool, "014779", "���߼̾��p", "");
        addOption(document.myform.selectschool, "014797", "���ߨq�p��p", "");
        addOption(document.myform.selectschool, "014798", "���ߪ��s��p", "");
        addOption(document.myform.selectschool, "014811", "���߫C�s��(��)�p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�U����') {
        addOption(document.myform.selectschool, "014658", "���߸U����p", "");
        addOption(document.myform.selectschool, "014659", "���߳��h��p", "");
        addOption(document.myform.selectschool, "014660", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "014661", "���ߤj�W��p", "");
        addOption(document.myform.selectschool, "014662", "���߮r�}��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "014663", "���ߪ��s��p", "");
        addOption(document.myform.selectschool, "014664", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "014665", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "014780", "���ߪ�����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "014709", "���ߥ��˰�p", "");
        addOption(document.myform.selectschool, "014710", "���ߵ׮��p", "");
        addOption(document.myform.selectschool, "014711", "���ߤQ����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "014666", "���߷s����p", "");
        addOption(document.myform.selectschool, "014667", "���ߪ����p", "");
        addOption(document.myform.selectschool, "014668", "���߫C���p", "");
        addOption(document.myform.selectschool, "014669", "�������p��p", "");
        addOption(document.myform.selectschool, "014670", "���ߤj�װ�p", "");
        addOption(document.myform.selectschool, "014671", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "014672", "���ߦw�|��p", "");
        addOption(document.myform.selectschool, "014673", "����������p", "");
        addOption(document.myform.selectschool, "014674", "���ߩ}�ذ�p", "");
        addOption(document.myform.selectschool, "014675", "�����t�s��p", "");
        addOption(document.myform.selectschool, "014781", "���߷s�M��p", "");
        addOption(document.myform.selectschool, "014794", "���ߥ_�s��p", "");
        addOption(document.myform.selectschool, "014813", "���߹F�[��(��)�p", "");
        addOption(document.myform.selectschool, "011302", "�p�߱d�����簪�����]��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�`�|��') {
        addOption(document.myform.selectschool, "014676", "���߲`�|��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "014677", "���ߥ����p", "");
        addOption(document.myform.selectschool, "014678", "���ߩM����p", "");
        addOption(document.myform.selectschool, "014679", "���ߥéw��p", "");
        addOption(document.myform.selectschool, "014680", "���߶�����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�W�L��') {
        addOption(document.myform.selectschool, "014682", "���ߩW�L��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '��ڰ�') {
        addOption(document.myform.selectschool, "014686", "���߷�ڰ�p", "");
        addOption(document.myform.selectschool, "014687", "���߸q���p", "");
        addOption(document.myform.selectschool, "014688", "���߷�a��p", "");
        addOption(document.myform.selectschool, "014689", "���߷��ذ�p", "");
        addOption(document.myform.selectschool, "014690", "���ߤE����p", "");
        addOption(document.myform.selectschool, "014691", "���ߥʤs��p", "");
        addOption(document.myform.selectschool, "014692", "���߾��}��p", "");
        addOption(document.myform.selectschool, "014693", "���ߵUֻ��p", "");
        addOption(document.myform.selectschool, "014694", "���߷�F��p", "");
        addOption(document.myform.selectschool, "014695", "���ߦN�y��p", "");
        addOption(document.myform.selectschool, "014696", "���߻��Y��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "014697", "�������˰�p", "");
        addOption(document.myform.selectschool, "014698", "���߬a�L��p", "");
        addOption(document.myform.selectschool, "014699", "���ߤW�L��p", "");
        addOption(document.myform.selectschool, "014700", "���ߨd����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�^�d��') {
        addOption(document.myform.selectschool, "014702", "���߰^�d��p", "");
        addOption(document.myform.selectschool, "014703", "���ߺֶ���p", "");
        addOption(document.myform.selectschool, "014704", "���߿D����p", "");
        addOption(document.myform.selectschool, "014706", "���ߩM����p", "");
        addOption(document.myform.selectschool, "014708", "���ߺֳs��p", "");
        addOption(document.myform.selectschool, "014809", "�����ׯ]��(��)�p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "014709", "���ߥ��˰�p", "");
        addOption(document.myform.selectschool, "014710", "���ߵ׮��p", "");
        addOption(document.myform.selectschool, "014711", "���ߤQ����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�H����') {
        addOption(document.myform.selectschool, "014712", "���߲H����p", "");
        addOption(document.myform.selectschool, "014713", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "014714", "���ߤ�ư�p", "");
        addOption(document.myform.selectschool, "014715", "���ߤѥͰ�p", "");
        addOption(document.myform.selectschool, "014716", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "014717", "���߿�����p", "");
        addOption(document.myform.selectschool, "014718", "���ߩ��s��p", "");
        addOption(document.myform.selectschool, "014719", "���ߤ٤s��p", "");
        addOption(document.myform.selectschool, "014720", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "014721", "���ߩW����p", "");
        addOption(document.myform.selectschool, "014722", "���ߦ˳��p", "");
        addOption(document.myform.selectschool, "014782", "���߾H����p", "");
        addOption(document.myform.selectschool, "014783", "���߷s����p", "");
        addOption(document.myform.selectschool, "014817", "���߷s����p", "");
        addOption(document.myform.selectschool, "011301", "�p�߲H���������]��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�۪���') {
        addOption(document.myform.selectschool, "014723", "���ߥ۪���p", "");
        addOption(document.myform.selectschool, "014724", "���߰��ذ�p", "");
        addOption(document.myform.selectschool, "014725", "���ߦѱ���p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�T�۰�') {
        addOption(document.myform.selectschool, "014726", "���ߤT�۰�p", "");
        addOption(document.myform.selectschool, "014727", "���߾�s��p", "");
        addOption(document.myform.selectschool, "014728", "���߿��ذ�p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "014729", "���߷s����p", "");
        addOption(document.myform.selectschool, "014730", "���ߤ����p", "");
        addOption(document.myform.selectschool, "014731", "���߫���p", "");
        addOption(document.myform.selectschool, "014732", "�����Y�e��p", "");
        addOption(document.myform.selectschool, "014733", "���߰����p", "");
        addOption(document.myform.selectschool, "014734", "�����צ~��p", "");
        addOption(document.myform.selectschool, "014735", "���ߤ����p", "");
        addOption(document.myform.selectschool, "014736", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "014737", "���ߥ��w��p", "");
        addOption(document.myform.selectschool, "014738", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "014765", "���߿��ư�p", "");
        addOption(document.myform.selectschool, "014788", "���ߺa�I��p", "");
        addOption(document.myform.selectschool, "014789", "���߸Υ���p", "");
        addOption(document.myform.selectschool, "014790", "���߷s����p", "");
        addOption(document.myform.selectschool, "014791", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "014801", "���ߩ�����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "014739", "���߮��s��p", "");
        addOption(document.myform.selectschool, "014740", "���ߩ��Ӱ�p", "");
        addOption(document.myform.selectschool, "014795", "���ߦP�a��p", "");
        addOption(document.myform.selectschool, "014812", "���߸q�ǰ�p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���Ѱ�') {
        addOption(document.myform.selectschool, "014741", "���ߦ��{��p", "");
        addOption(document.myform.selectschool, "014742", "���ߧ�d��p", "");
        addOption(document.myform.selectschool, "014743", "���ߤ��Ѱ�p", "");
        addOption(document.myform.selectschool, "014792", "���߼w����p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == 'Ī�w��') {
        addOption(document.myform.selectschool, "014744", "����Ī�w��p", "");
        addOption(document.myform.selectschool, "014745", "�����O����p", "");
        addOption(document.myform.selectschool, "014786", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "014787", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "014808", "���ߩ��q��p", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�L�f��') {
        addOption(document.myform.selectschool, "014749", "���ߪL�f��p", "");
        addOption(document.myform.selectschool, "014750", "���߫n�հ�p", "");
        addOption(document.myform.selectschool, "014751", "���߹��_��p", "");
        addOption(document.myform.selectschool, "014752", "���߷祭��p", "");
        addOption(document.myform.selectschool, "014753", "���߿��ְ�p", "");
        addOption(document.myform.selectschool, "014793", "�����R���p", "");
        addOption(document.myform.selectschool, "014802", "�����R�L��p", "");
        addOption(document.myform.selectschool, "014816", "�����Y���p", "");
        addOption(document.myform.selectschool, "010F01", "��ߪL�f�Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�T����') {
        addOption(document.myform.selectschool, "014754", "���ߤT����p", "");
        addOption(document.myform.selectschool, "014755", "���ߥúְ�p", "");
        addOption(document.myform.selectschool, "014756", "���ߥ��a��p", "");
        addOption(document.myform.selectschool, "014757", "���߫p�w��p", "");
        addOption(document.myform.selectschool, "014758", "���ߺѵذ�p", "");
        addOption(document.myform.selectschool, "014759", "���ߤT����p", "");
        addOption(document.myform.selectschool, "014760", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "014761", "���ߥ��q��p", "");
        addOption(document.myform.selectschool, "014762", "���߭׼w��p", "");
        addOption(document.myform.selectschool, "014763", "���ߤG����p", "");
        addOption(document.myform.selectschool, "014764", "���߿��\��p", "");
        addOption(document.myform.selectschool, "014784", "���߭�����p", "");
        addOption(document.myform.selectschool, "014785", "���ߤ��ذ�p", "");
        addOption(document.myform.selectschool, "014803", "���߶�����p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�Q�s��') {
        addOption(document.myform.selectschool, "313601", "���ߪQ�s��p", "");
        addOption(document.myform.selectschool, "313602", "���ߦ�Q��p", "");
        addOption(document.myform.selectschool, "313604", "���ߴ��ư�p", "");
        addOption(document.myform.selectschool, "313605", "���ߥ��Ͱ�p", "");
        addOption(document.myform.selectschool, "313606", "���ߥ��v��p", "");
        addOption(document.myform.selectschool, "313607", "���ߥ��ڰ�p", "");
        addOption(document.myform.selectschool, "313608", "���ߤT����p", "");
        addOption(document.myform.selectschool, "313609", "���߰��d��p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�H�q��') {
        addOption(document.myform.selectschool, "323601", "���߿�����p", "");
        addOption(document.myform.selectschool, "323602", "���ߥìK��p", "");
        addOption(document.myform.selectschool, "323603", "���ߥ��_��p", "");
        addOption(document.myform.selectschool, "323604", "���ߤT����p", "");
        addOption(document.myform.selectschool, "323605", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "323606", "���ߧd����p", "");
        addOption(document.myform.selectschool, "323607", "���ߺּw��p", "");
        addOption(document.myform.selectschool, "323608", "���ߥæN��p", "");
        addOption(document.myform.selectschool, "323609", "���߳շR��p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�j�w��') {
        addOption(document.myform.selectschool, "330601", "��߻O�_�Фj��p", "");
        addOption(document.myform.selectschool, "331601", "�p�ߴ_����p", "");
        addOption(document.myform.selectschool, "331602", "�p�ߥߤH��(��)�p", "");
        addOption(document.myform.selectschool, "331603", "�p�߷s���p��", "");
        addOption(document.myform.selectschool, "333601", "�����s�w��p", "");
        addOption(document.myform.selectschool, "333602", "���ߤj�w��p", "");
        addOption(document.myform.selectschool, "333603", "���ߩ��w��p", "");
        addOption(document.myform.selectschool, "333604", "���߫ئw��p", "");
        addOption(document.myform.selectschool, "333605", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "333606", "���ߪ��ذ�p", "");
        addOption(document.myform.selectschool, "333607", "���ߥj�F��p", "");
        addOption(document.myform.selectschool, "333608", "���߻ʶǰ�p", "");
        addOption(document.myform.selectschool, "333609", "���ߤ��]��p", "");
        addOption(document.myform.selectschool, "333610", "���߷s�Ͱ�p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "343601", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "343602", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "343603", "���ߪ��w��p", "");
        addOption(document.myform.selectschool, "343604", "���ߪ��K��p", "");
        addOption(document.myform.selectschool, "343605", "���ߤj����p", "");
        addOption(document.myform.selectschool, "343606", "���ߤj�ΰ�p", "");
        addOption(document.myform.selectschool, "343607", "���ߤ��`��p", "");
        addOption(document.myform.selectschool, "343608", "���ߦN�L��p", "");
        addOption(document.myform.selectschool, "343609", "�����h�Ͱ�p", "");
        addOption(document.myform.selectschool, "343610", "���ߥæw��p", "");
        addOption(document.myform.selectschool, "343611", "�����ئ���p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "353601", "���߿þ���p", "");
        addOption(document.myform.selectschool, "353602", "���ߪe����p", "");
        addOption(document.myform.selectschool, "353603", "���ߩ��q��p", "");
        addOption(document.myform.selectschool, "353604", "���߰�y��p", "");
        addOption(document.myform.selectschool, "353605", "���߫n����p", "");
        addOption(document.myform.selectschool, "353606", "���ߪF����p", "");
        addOption(document.myform.selectschool, "353607", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "353608", "�O�_���ߤj�Ǫ��p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�j�P��') {
        addOption(document.myform.selectschool, "363601", "���߽��ܰ�p", "");
        addOption(document.myform.selectschool, "363602", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "363603", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "363604", "���ߥüְ�p", "");
        addOption(document.myform.selectschool, "363605", "����������p", "");
        addOption(document.myform.selectschool, "363606", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "363607", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "363608", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "363609", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�U�ذ�') {
        addOption(document.myform.selectschool, "371601", "�p�ߥ����p��", "");
        addOption(document.myform.selectschool, "373601", "���߷s�M��p", "");
        addOption(document.myform.selectschool, "373602", "���������p", "");
        addOption(document.myform.selectschool, "373603", "���ߪF���p", "");
        addOption(document.myform.selectschool, "373604", "���ߤj�z��p", "");
        addOption(document.myform.selectschool, "373605", "���ߦ���p", "");
        addOption(document.myform.selectschool, "373606", "���߸U�j��p", "");
        addOption(document.myform.selectschool, "373607", "���ߵئ���p", "");
        addOption(document.myform.selectschool, "373608", "���ߦ����p", "");
        addOption(document.myform.selectschool, "373609", "���ߦѪQ��p", "");
        addOption(document.myform.selectschool, "373610", "�����s�s��p", "");
        addOption(document.myform.selectschool, "373611", "���ߺ֬P��p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '��s��') {
        addOption(document.myform.selectschool, "380601", "��߬F�j��p", "");
        addOption(document.myform.selectschool, "381601", "�p���R�ߤp��", "");
        addOption(document.myform.selectschool, "381602", "�p�ߤ��s�p��", "");
        addOption(document.myform.selectschool, "381603", "�p�ߦA���p��", "");
        addOption(document.myform.selectschool, "383601", "���ߴ�����p", "");
        addOption(document.myform.selectschool, "383602", "���ߪZ�\��p", "");
        addOption(document.myform.selectschool, "383603", "���߿��w��p", "");
        addOption(document.myform.selectschool, "383604", "���߷ˤf��p", "");
        addOption(document.myform.selectschool, "383605", "���߿�����p", "");
        addOption(document.myform.selectschool, "383606", "���ߧӲM��p", "");
        addOption(document.myform.selectschool, "383607", "���ߴ�����p", "");
        addOption(document.myform.selectschool, "383608", "���ߤ�]��p", "");
        addOption(document.myform.selectschool, "383609", "���ߥëذ�p", "");
        addOption(document.myform.selectschool, "383610", "���߹���p", "");
        addOption(document.myform.selectschool, "383611", "���߳չŰ�p", "");
        addOption(document.myform.selectschool, "383612", "���߫��n��p", "");
        addOption(document.myform.selectschool, "383613", "���ߩ��D��p", "");
        addOption(document.myform.selectschool, "383614", "���߸U�ڰ�p", "");
        addOption(document.myform.selectschool, "383615", "���ߤO���p", "");
        addOption(document.myform.selectschool, "383616", "���߸U����p", "");
        addOption(document.myform.selectschool, "383617", "���߸U�ְ�p", "");
        addOption(document.myform.selectschool, "383618", "���߿��ذ�p", "");
        addOption(document.myform.selectschool, "383619", "���ߨ����p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�n���') {
        addOption(document.myform.selectschool, "393601", "���߫n���p", "");
        addOption(document.myform.selectschool, "393602", "�����²���p", "");
        addOption(document.myform.selectschool, "393603", "���ߥɦ���p", "");
        addOption(document.myform.selectschool, "393604", "���ߦ��w��p", "");
        addOption(document.myform.selectschool, "393605", "���߭J�A��p", "");
        addOption(document.myform.selectschool, "393606", "���ߪF�s��p", "");
        addOption(document.myform.selectschool, "393607", "���߭׼w��p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "403601", "���ߤ����p", "");
        addOption(document.myform.selectschool, "403602", "���ߺѴ��p", "");
        addOption(document.myform.selectschool, "403603", "���߼����p", "");
        addOption(document.myform.selectschool, "403604", "���ߪF���p", "");
        addOption(document.myform.selectschool, "403605", "���ߦ���p", "");
        addOption(document.myform.selectschool, "403606", "���߱d���p", "");
        addOption(document.myform.selectschool, "403607", "���ߩ����p", "");
        addOption(document.myform.selectschool, "403608", "�����R�s��p", "");
        addOption(document.myform.selectschool, "403609", "���߷s���p", "");
        addOption(document.myform.selectschool, "403610", "���ߤ���p", "");
        addOption(document.myform.selectschool, "403611", "���ߤj���p", "");
        addOption(document.myform.selectschool, "403612", "���߫n���p", "");
        addOption(document.myform.selectschool, "403613", "�����R���p", "");
        addOption(document.myform.selectschool, "400144", "��߻O�W�����ǰ|���]��p", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�h�L��') {
        addOption(document.myform.selectschool, "411601", "�p�ߵؿ��p��", "");
        addOption(document.myform.selectschool, "413601", "���ߤh�L��p", "");
        addOption(document.myform.selectschool, "413602", "���ߤh�F��p", "");
        addOption(document.myform.selectschool, "413603", "���ߺ֪L��p", "");
        addOption(document.myform.selectschool, "413604", "���߶����s��p", "");
        addOption(document.myform.selectschool, "413605", "���ߪ��l��p", "");
        addOption(document.myform.selectschool, "413606", "���߫B�n��p", "");
        addOption(document.myform.selectschool, "413607", "���ߴI�w��p", "");
        addOption(document.myform.selectschool, "413608", "���߼C���p", "");
        addOption(document.myform.selectschool, "413609", "���߷ˤs��p", "");
        addOption(document.myform.selectschool, "413610", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "413611", "���ߦ��ְ�p", "");
        addOption(document.myform.selectschool, "413612", "�������˰�p", "");
        addOption(document.myform.selectschool, "413613", "���߸�Ī��p", "");
        addOption(document.myform.selectschool, "413614", "���߫B�A��p", "");
        addOption(document.myform.selectschool, "413615", "���ߤѥ���p", "");
        addOption(document.myform.selectschool, "413616", "���ߤ����p", "");
        addOption(document.myform.selectschool, "413617", "���ߪۤs��p", "");
        addOption(document.myform.selectschool, "413618", "����������p", "");
        addOption(document.myform.selectschool, "413619", "���ߤT�ɰ�p", "");
        addOption(document.myform.selectschool, "413F01", "���߱Ҵ��Ǯ�", "");
        addOption(document.myform.selectschool, "413F02", "���߱ҩ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�_���') {
        addOption(document.myform.selectschool, "421601", "�p�����դp��", "");
        addOption(document.myform.selectschool, "421602", "�p�߫��s���Ǫ��p", "");
        addOption(document.myform.selectschool, "423601", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "423602", "���߶h�P��p", "");
        addOption(document.myform.selectschool, "423603", "���ߥ۵P��p", "");
        addOption(document.myform.selectschool, "423604", "���������p", "");
        addOption(document.myform.selectschool, "423605", "���ߴ�а�p", "");
        addOption(document.myform.selectschool, "423606", "���߲M����p", "");
        addOption(document.myform.selectschool, "423607", "���߬u����p", "");
        addOption(document.myform.selectschool, "423608", "���ߤj�ٰ�p", "");
        addOption(document.myform.selectschool, "423609", "���ߴ�s��p", "");
        addOption(document.myform.selectschool, "423610", "���߮緽��p", "");
        addOption(document.myform.selectschool, "423611", "���ߤ�L��p", "");
        addOption(document.myform.selectschool, "423612", "���߸q���p", "");
        addOption(document.myform.selectschool, "423613", "���ߥ߹A��p", "");
        addOption(document.myform.selectschool, "423614", "���ߩ��w��p", "");
        addOption(document.myform.selectschool, "423615", "���߬w����p", "");
        addOption(document.myform.selectschool, "423616", "���ߤ�ư�p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j�w��') {
        addOption(document.myform.selectschool, "064682", "���ߤj�w��p", "");
        addOption(document.myform.selectschool, "064683", "���ߤT����p", "");
        addOption(document.myform.selectschool, "064684", "���߮��Y��p", "");
        addOption(document.myform.selectschool, "064685", "���ߤj�w�ϥæw��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '��l��') {
        addOption(document.myform.selectschool, "061601", "�p�ߵز��y��p", "");
        addOption(document.myform.selectschool, "064626", "���߼�l��p", "");
        addOption(document.myform.selectschool, "064627", "���߹�����p", "");
        addOption(document.myform.selectschool, "064628", "���ߪF�_��p", "");
        addOption(document.myform.selectschool, "064629", "���߼�l�Ϸs����p", "");
        addOption(document.myform.selectschool, "064741", "���߼涧��p", "");
        addOption(document.myform.selectschool, "064760", "�����Y�a��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�׭��') {
        addOption(document.myform.selectschool, "064601", "�����׭��p", "");
        addOption(document.myform.selectschool, "064602", "���߷��J��p", "");
        addOption(document.myform.selectschool, "064603", "���߫n����p", "");
        addOption(document.myform.selectschool, "064604", "���ߴI�K��p", "");
        addOption(document.myform.selectschool, "064605", "�����ק���p", "");
        addOption(document.myform.selectschool, "064606", "���߯Τl��p", "");
        addOption(document.myform.selectschool, "064607", "�����ץа�p", "");
        addOption(document.myform.selectschool, "064608", "���ߦX�@��p", "");
        addOption(document.myform.selectschool, "064751", "���߸�Ī�[��p", "");
        addOption(document.myform.selectschool, "064759", "���ߺֶ���p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�Z����') {
        addOption(document.myform.selectschool, "064609", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "064610", "���ߦZ����p", "");
        addOption(document.myform.selectschool, "064611", "���ߤ�ܰ�p", "");
        addOption(document.myform.selectschool, "064612", "���ߤC�P��p", "");
        addOption(document.myform.selectschool, "064613", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "064614", "���ߦZ���Ϯ��w��p", "");
        addOption(document.myform.selectschool, "060F01", "��߻O���ҩ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "064615", "���߯�����p", "");
        addOption(document.myform.selectschool, "064616", "�����׬w��p", "");
        addOption(document.myform.selectschool, "064617", "���ߪ��f��p", "");
        addOption(document.myform.selectschool, "064618", "���ߦ`����p", "");
        addOption(document.myform.selectschool, "064619", "���ߩ��̰�p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "064620", "���ߤj����p", "");
        addOption(document.myform.selectschool, "064621", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "064622", "���ߤj����p", "");
        addOption(document.myform.selectschool, "064623", "���ߤW����p", "");
        addOption(document.myform.selectschool, "064624", "���ߦ��ܰ�p", "");
        addOption(document.myform.selectschool, "064625", "���߶�����p", "");
        addOption(document.myform.selectschool, "064746", "���ߤ嶮��p", "");
        addOption(document.myform.selectschool, "064765", "���ߤ��_��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�~�H��') {
        addOption(document.myform.selectschool, "064630", "���ߥ~�H��p", "");
        addOption(document.myform.selectschool, "064631", "���ߦw�w��p", "");
        addOption(document.myform.selectschool, "064632", "�����K�s��p", "");
        addOption(document.myform.selectschool, "064633", "���߰����p", "");
        addOption(document.myform.selectschool, "064634", "���ߤ�����p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�F�հ�') {
        addOption(document.myform.selectschool, "064635", "���ߪF�հ�p", "");
        addOption(document.myform.selectschool, "064636", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "064637", "���ߥ۫���p", "");
        addOption(document.myform.selectschool, "064638", "���ߪF�հϦ��\��p", "");
        addOption(document.myform.selectschool, "064639", "���ߥۨ���p", "");
        addOption(document.myform.selectschool, "064640", "���ߤ����p", "");
        addOption(document.myform.selectschool, "064641", "���߷s����p", "");
        addOption(document.myform.selectschool, "064642", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "064747", "���߷s����p", "");
        addOption(document.myform.selectschool, "064762", "���ߪF�s��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�۩���') {
        addOption(document.myform.selectschool, "064643", "���ߥ۩���p", "");
        addOption(document.myform.selectschool, "064644", "���ߤg����p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "064645", "���߷s����p", "");
        addOption(document.myform.selectschool, "064646", "���߷s���ϪF����p", "");
        addOption(document.myform.selectschool, "064647", "���ߤj�n��p", "");
        addOption(document.myform.selectschool, "064648", "���ߨ󦨰�p", "");
        addOption(document.myform.selectschool, "064649", "���ߤj�L��p", "");
        addOption(document.myform.selectschool, "064650", "���߱X�s��p", "");
        addOption(document.myform.selectschool, "064651", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "064730", "���ߺ֥���p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�M����') {
        addOption(document.myform.selectschool, "064652", "���߲M����p", "");
        addOption(document.myform.selectschool, "064653", "���ߦ���p", "");
        addOption(document.myform.selectschool, "064654", "���߫ذ��p", "");
        addOption(document.myform.selectschool, "064655", "���ߤj�q��p", "");
        addOption(document.myform.selectschool, "064656", "���ߤT�а�p", "");
        addOption(document.myform.selectschool, "064657", "���ߥҫn��p", "");
        addOption(document.myform.selectschool, "064658", "���߰�����p", "");
        addOption(document.myform.selectschool, "064659", "���ߤj����p", "");
        addOption(document.myform.selectschool, "064660", "���ߪF�s��p", "");
        addOption(document.myform.selectschool, "064739", "����?�}��p", "");
        addOption(document.myform.selectschool, "064754", "���ߧd���p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '��ϰ�') {
        addOption(document.myform.selectschool, "064661", "���߱�ϰ�p", "");
        addOption(document.myform.selectschool, "064662", "���߱�n��p", "");
        addOption(document.myform.selectschool, "064663", "���߱�ϰϤ�����p", "");
        addOption(document.myform.selectschool, "064664", "���ߥù��p", "");
        addOption(document.myform.selectschool, "064744", "���ߤ����p", "");
        addOption(document.myform.selectschool, "064757", "���ߤj�w��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j�Ұ�') {
        addOption(document.myform.selectschool, "064665", "���ߤj�Ұ�p", "");
        addOption(document.myform.selectschool, "064666", "���߼w�ư�p", "");
        addOption(document.myform.selectschool, "064667", "���ߤj�ҰϤ����p", "");
        addOption(document.myform.selectschool, "064668", "���߶��Ѱ�p", "");
        addOption(document.myform.selectschool, "064669", "���ߤ�Z��p", "");
        addOption(document.myform.selectschool, "064670", "���ߤ�n��p", "");
        addOption(document.myform.selectschool, "064671", "���ߪF����p", "");
        addOption(document.myform.selectschool, "064672", "���ߵ��s��p", "");
        addOption(document.myform.selectschool, "064673", "���ߦ����p", "");
        addOption(document.myform.selectschool, "064674", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�F����') {
        addOption(document.myform.selectschool, "064675", "���ߨF����p", "");
        addOption(document.myform.selectschool, "064676", "���ߤ����p", "");
        addOption(document.myform.selectschool, "064677", "���ߦ˪L��p", "");
        addOption(document.myform.selectschool, "064678", "���ߥ_�հ�p", "");
        addOption(document.myform.selectschool, "064679", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "064680", "���ߤ��]��p", "");
        addOption(document.myform.selectschool, "064681", "���߳��p��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "064686", "�����s�s��p", "");
        addOption(document.myform.selectschool, "064687", "�����s����p", "");
        addOption(document.myform.selectschool, "064688", "�����s�z��p", "");
        addOption(document.myform.selectschool, "064689", "�����s����p", "");
        addOption(document.myform.selectschool, "064690", "�����s���p", "");
        addOption(document.myform.selectschool, "064691", "�����s�u��p", "");
        addOption(document.myform.selectschool, "064692", "�����s�p��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�Q���') {
        addOption(document.myform.selectschool, "064693", "���߯Q���p", "");
        addOption(document.myform.selectschool, "064694", "���߹�����p", "");
        addOption(document.myform.selectschool, "064695", "���߳ح���p", "");
        addOption(document.myform.selectschool, "064696", "���ߪF���p", "");
        addOption(document.myform.selectschool, "064697", "���߷˧���p", "");
        addOption(document.myform.selectschool, "064698", "���ߦ�����p", "");
        addOption(document.myform.selectschool, "064699", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "064743", "���ߤE�w��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j�{��') {
        addOption(document.myform.selectschool, "064700", "���ߤj�{��p", "");
        addOption(document.myform.selectschool, "064701", "���߷�p��p", "");
        addOption(document.myform.selectschool, "064702", "���ߥö���p", "");
        addOption(document.myform.selectschool, "064703", "���߰l����p", "");
        addOption(document.myform.selectschool, "064704", "���ߤj����p", "");
        addOption(document.myform.selectschool, "064755", "���ߤs����p", "");
        addOption(document.myform.selectschool, "064761", "���߷礫��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "064705", "���ߤj����p", "");
        addOption(document.myform.selectschool, "064706", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "064707", "���߱R����p", "");
        addOption(document.myform.selectschool, "064708", "���߶��p", "");
        addOption(document.myform.selectschool, "064709", "���߷竰��p", "");
        addOption(document.myform.selectschool, "064710", "���߰�����p", "");
        addOption(document.myform.selectschool, "064711", "���߯���p", "");
        addOption(document.myform.selectschool, "064738", "���߯q����p", "");
        addOption(document.myform.selectschool, "064748", "���ߤj����p", "");
        addOption(document.myform.selectschool, "064752", "���ߥö���p", "");
        addOption(document.myform.selectschool, "064753", "���߬��s��p", "");
        addOption(document.myform.selectschool, "064756", "���ߥ߷s��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '���p��') {
        addOption(document.myform.selectschool, "064712", "�������p��p", "");
        addOption(document.myform.selectschool, "064713", "���߹��a��p", "");
        addOption(document.myform.selectschool, "064714", "���ߥ|�w��p", "");
        addOption(document.myform.selectschool, "064715", "���ߤ��ְ�p", "");
        addOption(document.myform.selectschool, "064716", "���߸U�װ�p", "");
        addOption(document.myform.selectschool, "064717", "���߮p����p", "");
        addOption(document.myform.selectschool, "064718", "���߮�L��p", "");
        addOption(document.myform.selectschool, "064719", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "064720", "�������p�ϥ�����p", "");
        addOption(document.myform.selectschool, "064749", "���ߦN�p��p", "");
        addOption(document.myform.selectschool, "064763", "���ߥ��_��(��)�p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�ӥ���') {
        addOption(document.myform.selectschool, "064721", "���ߤӥ��Ϥӥ���p", "");
        addOption(document.myform.selectschool, "064722", "���ߩy�Y��p", "");
        addOption(document.myform.selectschool, "064723", "���߷s����p", "");
        addOption(document.myform.selectschool, "064724", "���ߩW�L��p", "");
        addOption(document.myform.selectschool, "064725", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "064726", "���߶��˰�p", "");
        addOption(document.myform.selectschool, "064727", "�����Y�X��p", "");
        addOption(document.myform.selectschool, "064728", "���ߪF�X��p", "");
        addOption(document.myform.selectschool, "064740", "���߫إ���p", "");
        addOption(document.myform.selectschool, "064742", "���ߤӥ��Ϥ��ذ�p", "");
        addOption(document.myform.selectschool, "064745", "���ߪF����p", "");
        addOption(document.myform.selectschool, "064750", "���߷s����p", "");
        addOption(document.myform.selectschool, "064758", "���ߨ�Ţ�H��p", "");
        addOption(document.myform.selectschool, "064764", "���ߪ�����p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�M����') {
        addOption(document.myform.selectschool, "064729", "���ߩM���ϩM����p", "");
        addOption(document.myform.selectschool, "064731", "���ߥէN��p", "");
        addOption(document.myform.selectschool, "064732", "���߹F�[��p", "");
        addOption(document.myform.selectschool, "064733", "���ߤ��|��p", "");
        addOption(document.myform.selectschool, "064734", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "064735", "���߳շR��p", "");
        addOption(document.myform.selectschool, "064736", "���ߦۥѰ�p", "");
        addOption(document.myform.selectschool, "064737", "���߱��s��(��)�p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�_��') {
        addOption(document.myform.selectschool, "190601", "��߻O���Фj���p", "");
        addOption(document.myform.selectschool, "191602", "�p�ߨ|����p", "");
        addOption(document.myform.selectschool, "193616", "���ߥ_�Ϥӥ���p", "");
        addOption(document.myform.selectschool, "193617", "���ߥ_�Ϥ��ذ�p", "");
        addOption(document.myform.selectschool, "193618", "���߿w���p", "");
        addOption(document.myform.selectschool, "193619", "���߰����p", "");
        addOption(document.myform.selectschool, "193620", "���߬٤T��p", "");
        addOption(document.myform.selectschool, "193642", "���ߥߤH��p", "");
        addOption(document.myform.selectschool, "193654", "���߿���p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�_�ٰ�') {
        addOption(document.myform.selectschool, "191604", "�p�߷V�N�p��", "");
        addOption(document.myform.selectschool, "191605", "�p�ߩ��D���M���y�p��", "");
        addOption(document.myform.selectschool, "193632", "���ߥ_�ٰ�p", "");
        addOption(document.myform.selectschool, "193633", "���߹�����p", "");
        addOption(document.myform.selectschool, "193634", "���ߥ|�i�p��p", "");
        addOption(document.myform.selectschool, "193635", "���ߪQ�˰�p", "");
        addOption(document.myform.selectschool, "193636", "���߭x�\��p", "");
        addOption(document.myform.selectschool, "193637", "���ߥ_�ٰϤj�|��p", "");
        addOption(document.myform.selectschool, "193638", "���߳{�Ұ�p", "");
        addOption(document.myform.selectschool, "193639", "���߫إ\��p", "");
        addOption(document.myform.selectschool, "193640", "���ߥ_�ٰϷs����p", "");
        addOption(document.myform.selectschool, "193641", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "193643", "���ߥ_�ٰϤ����p", "");
        addOption(document.myform.selectschool, "193647", "���ߤ�߰�p", "");
        addOption(document.myform.selectschool, "193648", "���ߥ|����p", "");
        addOption(document.myform.selectschool, "193653", "���߳�����p", "");
        addOption(document.myform.selectschool, "193658", "���ߪF����p", "");
        addOption(document.myform.selectschool, "193660", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "191302", "�p��߻�氪�����]��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '��ٰ�') {
        addOption(document.myform.selectschool, "191606", "�p���R�A��(��)�p", "");
        addOption(document.myform.selectschool, "193621", "���ߦ�ٰ�p", "");
        addOption(document.myform.selectschool, "193622", "���ߦ�ٰϮ��w��p", "");
        addOption(document.myform.selectschool, "193623", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "193624", "���ߦ�ٰϥæw��p", "");
        addOption(document.myform.selectschool, "193625", "���ߨ�M��p", "");
        addOption(document.myform.selectschool, "193626", "���ߤj����p", "");
        addOption(document.myform.selectschool, "193645", "���߭��y��p", "");
        addOption(document.myform.selectschool, "193649", "���ߦ���p", "");
        addOption(document.myform.selectschool, "193650", "���߰�w��p", "");
        addOption(document.myform.selectschool, "193651", "���ߤW�۰�p", "");
        addOption(document.myform.selectschool, "193659", "���ߤW�w��p", "");
        addOption(document.myform.selectschool, "193661", "���ߪ��w��p", "");
        addOption(document.myform.selectschool, "193662", "���ߴf�Ӱ�p", "");
        addOption(document.myform.selectschool, "193664", "���ߪF����p", "");
        addOption(document.myform.selectschool, "191301", "�p�ߪF�j�������]��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '����') {
        addOption(document.myform.selectschool, "193601", "���ߤ��ϥ��_��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "193602", "���߻O����p", "");
        addOption(document.myform.selectschool, "193603", "���ߤj����p", "");
        addOption(document.myform.selectschool, "193604", "���ߪF�Ϧ��\��p", "");
        addOption(document.myform.selectschool, "193605", "���߶i�w��p", "");
        addOption(document.myform.selectschool, "193606", "���ߤO���p", "");
        addOption(document.myform.selectschool, "193607", "���߼ַ~��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '���') {
        addOption(document.myform.selectschool, "193608", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "193609", "���ߩ��H��p", "");
        addOption(document.myform.selectschool, "193610", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "193611", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "193612", "���ߦ�Ϥ�����p", "");
        addOption(document.myform.selectschool, "193644", "���ߤj�i��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�n��') {
        addOption(document.myform.selectschool, "193613", "���߫n�ϩM����p", "");
        addOption(document.myform.selectschool, "193614", "���߰����p", "");
        addOption(document.myform.selectschool, "193615", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "193657", "���߾�q��p", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�n�ٰ�') {
        addOption(document.myform.selectschool, "193627", "���߫n�ٰ�p", "");
        addOption(document.myform.selectschool, "193628", "��������p", "");
        addOption(document.myform.selectschool, "193629", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "193630", "���߬K�w��p", "");
        addOption(document.myform.selectschool, "193631", "���߾�����p", "");
        addOption(document.myform.selectschool, "193646", "���߫n�ٰϪF����p", "");
        addOption(document.myform.selectschool, "193652", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "193655", "���ߥìK��p", "");
        addOption(document.myform.selectschool, "193656", "���ߴf���p", "");
        addOption(document.myform.selectschool, "193663", "���ߤj�[��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�_��') {
        addOption(document.myform.selectschool, "211601", "�p���_���p��", "");
        addOption(document.myform.selectschool, "213616", "���ߥߤH��p", "");
        addOption(document.myform.selectschool, "213617", "���ߤ����p", "");
        addOption(document.myform.selectschool, "213618", "���߶}����p", "");
        addOption(document.myform.selectschool, "213619", "���ߤj����p", "");
        addOption(document.myform.selectschool, "213637", "���ߤj���p", "");
        addOption(document.myform.selectschool, "213642", "���ߤ夸��p", "");
        addOption(document.myform.selectschool, "213645", "���߽�_��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "213601", "���ߪF�ϳӧQ��p", "");
        addOption(document.myform.selectschool, "213602", "���߳շR��p", "");
        addOption(document.myform.selectschool, "213603", "���ߪF�Ϥj�P��p", "");
        addOption(document.myform.selectschool, "213604", "���ߪF����p", "");
        addOption(document.myform.selectschool, "213605", "���߼w����p", "");
        addOption(document.myform.selectschool, "213606", "���߱R�ǰ�p", "");
        addOption(document.myform.selectschool, "213639", "���ߪF�ϴ_����p", "");
        addOption(document.myform.selectschool, "213640", "���߱R����p", "");
        addOption(document.myform.selectschool, "213646", "���߸Τ��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�n��') {
        addOption(document.myform.selectschool, "213607", "���ߧӶ}��p", "");
        addOption(document.myform.selectschool, "213608", "���߫n�Ϸs����p", "");
        addOption(document.myform.selectschool, "213609", "���ٰ߬`��p", "");
        addOption(document.myform.selectschool, "213610", "���߳߾��p", "");
        addOption(document.myform.selectschool, "213611", "�����s�^��p", "");
        addOption(document.myform.selectschool, "213612", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "213613", "���ߥõذ�p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���w��') {
        addOption(document.myform.selectschool, "114601", "���ߤ��w��p", "");
        addOption(document.myform.selectschool, "114602", "���ߤ���p", "");
        addOption(document.myform.selectschool, "114603", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "114604", "���ߨ̤���p", "");
        addOption(document.myform.selectschool, "114605", "���ߤj�Ұ�p", "");
        addOption(document.myform.selectschool, "114606", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "114607", "���߼w�n��p", "");
        addOption(document.myform.selectschool, "114608", "���ߪ�s��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�k����') {
        addOption(document.myform.selectschool, "114609", "�����k����p", "");
        addOption(document.myform.selectschool, "114610", "�����k�n��p", "");
        addOption(document.myform.selectschool, "114611", "���߫O���p", "");
        addOption(document.myform.selectschool, "114612", "���ߤj���p", "");
        addOption(document.myform.selectschool, "114778", "���ߤ�ư�p", "");
        addOption(document.myform.selectschool, "114785", "���߬��˭��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���q��') {
        addOption(document.myform.selectschool, "114613", "�������q��p", "");
        addOption(document.myform.selectschool, "114614", "���ߤ��Ұ�p", "");
        addOption(document.myform.selectschool, "114615", "���߫O�F��p", "");
        addOption(document.myform.selectschool, "114616", "���߱R�M��p", "");
        addOption(document.myform.selectschool, "114617", "���ߤ�M��p", "");
        addOption(document.myform.selectschool, "114618", "���߲`�|��p", "");
        addOption(document.myform.selectschool, "114619", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s�T��') {
        addOption(document.myform.selectschool, "114620", "�����s�T��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ñd��') {
        addOption(document.myform.selectschool, "114623", "���ߥñd��p", "");
        addOption(document.myform.selectschool, "114624", "���ߤj�W��p", "");
        addOption(document.myform.selectschool, "114625", "���ߤT����p", "");
        addOption(document.myform.selectschool, "114626", "���ߦ�հ�p", "");
        addOption(document.myform.selectschool, "114627", "���ߥñd�ϴ_����p", "");
        addOption(document.myform.selectschool, "114628", "�����s���p", "");
        addOption(document.myform.selectschool, "114629", "���ߤj����p", "");
        addOption(document.myform.selectschool, "114776", "���߱X�s��p", "");
        addOption(document.myform.selectschool, "114777", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "114782", "���ߥëH��p", "");
        addOption(document.myform.selectschool, "114784", "���ߥñd�ϳӧQ��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s�ư�') {
        addOption(document.myform.selectschool, "114630", "���߷s�ư�p", "");
        addOption(document.myform.selectschool, "114631", "���ߨ��ް�p", "");
        addOption(document.myform.selectschool, "114632", "���ߤf�O��p", "");
        addOption(document.myform.selectschool, "114633", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "114779", "���ߥ��s��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s�W��') {
        addOption(document.myform.selectschool, "114635", "���ߤs�W��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ɤ���') {
        addOption(document.myform.selectschool, "114636", "���ߥɤ���p", "");
        addOption(document.myform.selectschool, "114637", "���߼h�L��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "114638", "���߷����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�n�ư�') {
        addOption(document.myform.selectschool, "114639", "���߫n�ư�p", "");
        addOption(document.myform.selectschool, "114640", "���ߥ_�d��p", "");
        addOption(document.myform.selectschool, "114641", "���ߦ�H��p", "");
        addOption(document.myform.selectschool, "114642", "���ߥɤs��p", "");
        addOption(document.myform.selectschool, "114643", "���߷�p��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "114644", "���ߥ����p", "");
        addOption(document.myform.selectschool, "114646", "���ߥ��a��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���ư�') {
        addOption(document.myform.selectschool, "114647", "���ߵ��ư�p", "");
        addOption(document.myform.selectschool, "114648", "���߭X�ް�p", "");
        addOption(document.myform.selectschool, "114649", "���ߵ��ưϤj�P��p", "");
        addOption(document.myform.selectschool, "114650", "���ߤj����p", "");
        addOption(document.myform.selectschool, "114651", "���߶�����p", "");
        addOption(document.myform.selectschool, "114652", "���ߵ��}��p", "");
        addOption(document.myform.selectschool, "114653", "���ߤp�s��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "114654", "���߷s����p", "");
        addOption(document.myform.selectschool, "114655", "���ߤj����p", "");
        addOption(document.myform.selectschool, "110328", "��߫n���ڹ��簪�����]��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�w�w��') {
        addOption(document.myform.selectschool, "114656", "���ߦw�w��p", "");
        addOption(document.myform.selectschool, "114657", "���߫n�w��p", "");
        addOption(document.myform.selectschool, "114658", "���ߦw�w�ϫn����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�¨���') {
        addOption(document.myform.selectschool, "114659", "���߳¨���p", "");
        addOption(document.myform.selectschool, "114660", "���߰����p", "");
        addOption(document.myform.selectschool, "114661", "���ߤ奿��p", "");
        addOption(document.myform.selectschool, "114662", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "114663", "���ߦw�~��p", "");
        addOption(document.myform.selectschool, "114664", "���ߥ_�հ�p", "");
        addOption(document.myform.selectschool, "114665", "���ߴ����p", "");
        addOption(document.myform.selectschool, "114667", "���߬��w��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�Ψ���') {
        addOption(document.myform.selectschool, "114668", "���ߨΨ���p", "");
        addOption(document.myform.selectschool, "114669", "���ߨο���p", "");
        addOption(document.myform.selectschool, "114670", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "114671", "���߶󤺰�p", "");
        addOption(document.myform.selectschool, "114672", "���ߤl�s��p", "");
        addOption(document.myform.selectschool, "114673", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "114674", "���߳q����p", "");
        addOption(document.myform.selectschool, "114780", "���߫H�q��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '����') {
        addOption(document.myform.selectschool, "114675", "���ߦ���p", "");
        addOption(document.myform.selectschool, "114676", "���ߴ�F��p", "");
        addOption(document.myform.selectschool, "114677", "���ߦ��Ϧ��\��p", "");
        addOption(document.myform.selectschool, "114678", "���߫����p", "");
        addOption(document.myform.selectschool, "114680", "���ߪQ�L��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�C�Ѱ�') {
        addOption(document.myform.selectschool, "114681", "���ߤC�Ѱ�p", "");
        addOption(document.myform.selectschool, "114682", "���߫���p", "");
        addOption(document.myform.selectschool, "114683", "���ߦ˾���p", "");
        addOption(document.myform.selectschool, "114684", "���ߤT�Ѱ�p", "");
        addOption(document.myform.selectschool, "114685", "���ߥ��_��p", "");
        addOption(document.myform.selectschool, "114686", "���߿w�[��p", "");
        addOption(document.myform.selectschool, "114688", "�����s�s��p", "");
        addOption(document.myform.selectschool, "114689", "���߫إ\��p", "");
        addOption(document.myform.selectschool, "114691", "���ߤj���p", "");
        addOption(document.myform.selectschool, "114692", "���߾�L��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�N�x��') {
        addOption(document.myform.selectschool, "114693", "���߱N�x��p", "");
        addOption(document.myform.selectschool, "114694", "�����x�L��p", "");
        addOption(document.myform.selectschool, "114695", "���߭d�M��p", "");
        addOption(document.myform.selectschool, "114696", "�������ʰ�p", "");
        addOption(document.myform.selectschool, "114697", "���ߪ�����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "114699", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "114700", "���߳H�d��p", "");
        addOption(document.myform.selectschool, "114701", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "114702", "�����A���p", "");
        addOption(document.myform.selectschool, "114703", "�������K��p", "");
        addOption(document.myform.selectschool, "114705", "���ߤT�O��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ǥҰ�') {
        addOption(document.myform.selectschool, "114706", "���߾ǥҰ�p", "");
        addOption(document.myform.selectschool, "114707", "���ߤ��w��p", "");
        addOption(document.myform.selectschool, "114708", "���ߦv���p", "");
        addOption(document.myform.selectschool, "114709", "���߳��w��p", "");
        addOption(document.myform.selectschool, "114710", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�U���') {
        addOption(document.myform.selectschool, "114711", "���ߤU���p", "");
        addOption(document.myform.selectschool, "114712", "���ߤ����p", "");
        addOption(document.myform.selectschool, "114713", "���߶P�ذ�p", "");
        addOption(document.myform.selectschool, "114714", "���ߥҤ���p", "");
        addOption(document.myform.selectschool, "114716", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���Ұ�') {
        addOption(document.myform.selectschool, "114717", "���ߤ��Ұ�p", "");
        addOption(document.myform.selectschool, "114718", "���ߪL���p", "");
        addOption(document.myform.selectschool, "114722", "���߹ūn��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�x�а�') {
        addOption(document.myform.selectschool, "114720", "���ߩx�а�p", "");
        addOption(document.myform.selectschool, "114721", "���߶��а�p", "");
        addOption(document.myform.selectschool, "114723", "���ߴ�ް�p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "114724", "���ߤj����p", "");
        addOption(document.myform.selectschool, "114726", "���ߤG�˰�p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s���') {
        addOption(document.myform.selectschool, "114728", "���߷s���p", "");
        addOption(document.myform.selectschool, "114729", "���߷s����p", "");
        addOption(document.myform.selectschool, "114730", "���߷s����p", "");
        addOption(document.myform.selectschool, "114731", "���߷s��Ϸs����p", "");
        addOption(document.myform.selectschool, "114732", "���߷s�i��p", "");
        addOption(document.myform.selectschool, "114733", "���߫n���p", "");
        addOption(document.myform.selectschool, "114734", "���߷s�Ͱ�p", "");
        addOption(document.myform.selectschool, "114735", "���ߤg�w��p", "");
        addOption(document.myform.selectschool, "114736", "���ߤ��۰�p", "");
        addOption(document.myform.selectschool, "114781", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�Q����') {
        addOption(document.myform.selectschool, "114737", "�����Q����p", "");
        addOption(document.myform.selectschool, "114738", "�����w����p", "");
        addOption(document.myform.selectschool, "114739", "����?�Y���p", "");
        addOption(document.myform.selectschool, "114740", "���ߤ�z��p", "");
        addOption(document.myform.selectschool, "114742", "���ߦˮH��p", "");
        addOption(document.myform.selectschool, "114743", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "114744", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "114747", "���ߤ����p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ժe��') {
        addOption(document.myform.selectschool, "114748", "���ߥժe��p", "");
        addOption(document.myform.selectschool, "114749", "���ߥ��װ�p", "");
        addOption(document.myform.selectschool, "114750", "���ߦ˪���p", "");
        addOption(document.myform.selectschool, "114751", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "114753", "���ߥP���p", "");
        addOption(document.myform.selectschool, "114755", "���ߪe�F��p", "");
        addOption(document.myform.selectschool, "114756", "���ߤj�˰�p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�h���') {
        addOption(document.myform.selectschool, "114758", "���߬h���p", "");
        addOption(document.myform.selectschool, "114759", "���ߪG�ݰ�p", "");
        addOption(document.myform.selectschool, "114760", "���߭��˰�p", "");
        addOption(document.myform.selectschool, "114761", "���ߤӱd��p", "");
        addOption(document.myform.selectschool, "114762", "���߷s�s��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "114763", "���߫����p", "");
        addOption(document.myform.selectschool, "114764", "���ߵ׼d��p", "");
        addOption(document.myform.selectschool, "114765", "���ߦw�˰�p", "");
        addOption(document.myform.selectschool, "114766", "���߷s�F��p", "");
        addOption(document.myform.selectschool, "114767", "���ߥæw��p", "");
        addOption(document.myform.selectschool, "114768", "���߷s�Ű�p", "");
        addOption(document.myform.selectschool, "114769", "���߾�H��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�F�s��') {
        addOption(document.myform.selectschool, "114770", "���ߪF�s��p", "");
        addOption(document.myform.selectschool, "114771", "���߸t���p", "");
        addOption(document.myform.selectschool, "114772", "���ߪF���p", "");
        addOption(document.myform.selectschool, "114774", "���߫C�s��p", "");
        addOption(document.myform.selectschool, "114775", "���ߦN���A��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "210601", "��߻O�n�j�Ǫ��p", "");
        addOption(document.myform.selectschool, "213614", "���ߨ�i��p", "");
        addOption(document.myform.selectschool, "213620", "���ߤ���Ϧ��\��p", "");
        addOption(document.myform.selectschool, "213621", "���ߥúְ�p", "");
        addOption(document.myform.selectschool, "213622", "���ߩ��q��p", "");
        addOption(document.myform.selectschool, "213623", "���߶i�ǰ�p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�w����') {
        addOption(document.myform.selectschool, "213615", "���߷s�n��p", "");
        addOption(document.myform.selectschool, "213624", "���ߥ۪���p", "");
        addOption(document.myform.selectschool, "213625", "���ߦ����p", "");
        addOption(document.myform.selectschool, "213641", "���ߦw����p", "");
        addOption(document.myform.selectschool, "213644", "���߻�����p", "");
        addOption(document.myform.selectschool, "211320", "�]�Ϊk�H�O�ٰ������]��p", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�w�n��') {
        addOption(document.myform.selectschool, "213626", "���ߦw����p", "");
        addOption(document.myform.selectschool, "213627", "���ߩM����p", "");
        addOption(document.myform.selectschool, "213628", "���߮��F��p", "");
        addOption(document.myform.selectschool, "213629", "���ߦw�y��p", "");
        addOption(document.myform.selectschool, "213630", "���ߤg����p", "");
        addOption(document.myform.selectschool, "213631", "���߫C���p", "");
        addOption(document.myform.selectschool, "213632", "���������p", "");
        addOption(document.myform.selectschool, "213633", "������c��p", "");
        addOption(document.myform.selectschool, "213634", "���ߪ��w��p", "");
        addOption(document.myform.selectschool, "213635", "���ߦw�n�ϫn����p", "");
        addOption(document.myform.selectschool, "213636", "���ߦw����p", "");
        addOption(document.myform.selectschool, "213638", "���߮�����p", "");
        addOption(document.myform.selectschool, "213643", "���߾ǪF��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '��s��') {
        addOption(document.myform.selectschool, "124601", "���߻�s��p", "");
        addOption(document.myform.selectschool, "124602", "���ߤj�F��p", "");
        addOption(document.myform.selectschool, "124603", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "124604", "���߻�s�Ϥ�����p", "");
        addOption(document.myform.selectschool, "124605", "���ߤ��Ұ�p", "");
        addOption(document.myform.selectschool, "124606", "���߱䤽��p", "");
        addOption(document.myform.selectschool, "124607", "���߸ۥ���p", "");
        addOption(document.myform.selectschool, "124608", "���߫n����p", "");
        addOption(document.myform.selectschool, "124609", "���ߤ��ְ�p", "");
        addOption(document.myform.selectschool, "124610", "���߻�s�Ϥ��s��p", "");
        addOption(document.myform.selectschool, "124611", "���߷s�Ұ�p", "");
        addOption(document.myform.selectschool, "124612", "���߻�s�ϩ�����p", "");
        addOption(document.myform.selectschool, "124740", "���߻���p", "");
        addOption(document.myform.selectschool, "124742", "���ߤ�w��p", "");
        addOption(document.myform.selectschool, "124743", "���߷翳��p", "");
        addOption(document.myform.selectschool, "124748", "���ߥ��q��p", "");
        addOption(document.myform.selectschool, "124749", "���ߺָ۰�p", "");
        addOption(document.myform.selectschool, "124751", "���߹L���p", "");
        addOption(document.myform.selectschool, "124752", "���ߤ��[��p", "");
        addOption(document.myform.selectschool, "124761", "���ߤ�ذ�p", "");
        addOption(document.myform.selectschool, "124762", "���߻񵾰�p", "");
        addOption(document.myform.selectschool, "124739", "������_��p", "");
    }

    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�L���') {
        addOption(document.myform.selectschool, "124613", "���ߪL���p", "");
        addOption(document.myform.selectschool, "124614", "���ߤ����p", "");
        addOption(document.myform.selectschool, "124615", "���ߴ�H��p", "");
        addOption(document.myform.selectschool, "124616", "���ߪ����p", "");
        addOption(document.myform.selectschool, "124617", "���ߦ§���p", "");
        addOption(document.myform.selectschool, "124757", "���ߤ�����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�j�d��') {
        addOption(document.myform.selectschool, "124618", "���ߥêڰ�p", "");
        addOption(document.myform.selectschool, "124619", "���߯ζ��p", "");
        addOption(document.myform.selectschool, "124620", "���ߩ��q��p", "");
        addOption(document.myform.selectschool, "124621", "���߬L����p", "");
        addOption(document.myform.selectschool, "124622", "���߼�d��p", "");
        addOption(document.myform.selectschool, "124623", "���ߤ��ܰ�p", "");
        addOption(document.myform.selectschool, "124624", "���߷˼d��p", "");
        addOption(document.myform.selectschool, "124625", "���ߤj�d��p", "");
        addOption(document.myform.selectschool, "124750", "���ߤs����p", "");
        addOption(document.myform.selectschool, "124756", "���߫��ܰ�p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�j���') {
        addOption(document.myform.selectschool, "124626", "���ߤj���p", "");
        addOption(document.myform.selectschool, "124627", "���ߤE����p", "");
        addOption(document.myform.selectschool, "124628", "���߷ˮH��p", "");
        addOption(document.myform.selectschool, "124629", "���ߩh�s��p", "");
        addOption(document.myform.selectschool, "124630", "���ߤ��d��p", "");
        addOption(document.myform.selectschool, "124631", "���ߤp�W��p", "");
        addOption(document.myform.selectschool, "124632", "���߿��а�p", "");
        addOption(document.myform.selectschool, "124633", "�����s�ذ�p", "");
        addOption(document.myform.selectschool, "121320", "�p�߸q�j��ڰ������]��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���Z��') {
        addOption(document.myform.selectschool, "124634", "���ߤ��Z��p", "");
        addOption(document.myform.selectschool, "124635", "���߯Q�L��p", "");
        addOption(document.myform.selectschool, "124636", "���ߤK����p", "");
        addOption(document.myform.selectschool, "124637", "�����W����p", "");
        addOption(document.myform.selectschool, "124744", "���ߵn�o��p", "");
        addOption(document.myform.selectschool, "124747", "���ߦ˫��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "124638", "���ߤj���Ϥj����p", "");
        addOption(document.myform.selectschool, "124639", "���߹Ÿ۰�p", "");
        addOption(document.myform.selectschool, "124746", "�����[����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���Q��') {
        addOption(document.myform.selectschool, "124640", "���߳��Q��p", "");
        addOption(document.myform.selectschool, "124641", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "124642", "���ߤj�ذ�p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "124643", "���ߩ��s��p", "");
        addOption(document.myform.selectschool, "124644", "���߫e�p��p", "");
        addOption(document.myform.selectschool, "124645", "���߹ſ���p", "");
        addOption(document.myform.selectschool, "124646", "���ߥ����p", "");
        addOption(document.myform.selectschool, "124647", "���߫����p", "");
        addOption(document.myform.selectschool, "124648", "���ߩM����p", "");
        addOption(document.myform.selectschool, "124745", "���ߦ˳��p", "");
        addOption(document.myform.selectschool, "124758", "���߹ؤѰ�p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���Y��') {
        addOption(document.myform.selectschool, "124650", "���ߥK����p", "");
        addOption(document.myform.selectschool, "124651", "���ߤ��L��p", "");
        addOption(document.myform.selectschool, "124652", "���ߥҳ��p", "");
        addOption(document.myform.selectschool, "124653", "���߿��}��p", "");
        addOption(document.myform.selectschool, "124753", "���߾��Y��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�P�_��') {
        addOption(document.myform.selectschool, "124654", "���߿P�_��p", "");
        addOption(document.myform.selectschool, "124655", "���߾�s��p", "");
        addOption(document.myform.selectschool, "124656", "���߲`����p", "");
        addOption(document.myform.selectschool, "124657", "���ߦw�۰�p", "");
        addOption(document.myform.selectschool, "124658", "���߻񶯰�p", "");
        addOption(document.myform.selectschool, "124659", "���ߪ��s��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�мd��') {
        addOption(document.myform.selectschool, "124660", "���ߥмd�Ϸs����p", "");
        addOption(document.myform.selectschool, "124661", "���߱R�w��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "124664", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "124665", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "124666", "���ߴ_�w��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "124667", "���߸��˰�p", "");
        addOption(document.myform.selectschool, "124668", "���߸��˰Ϥj����p", "");
        addOption(document.myform.selectschool, "124669", "���ߤU�|��p", "");
        addOption(document.myform.selectschool, "124670", "���ߦ˺���p", "");
        addOption(document.myform.selectschool, "124671", "���ߤT���p", "");
        addOption(document.myform.selectschool, "124672", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "124673", "���ߤ@�Ұ�p", "");
        addOption(document.myform.selectschool, "124760", "���߽����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�򤺰�') {
        addOption(document.myform.selectschool, "124674", "���ߤ���p", "");
        addOption(document.myform.selectschool, "124675", "���ߩ��v��p", "");
        addOption(document.myform.selectschool, "124676", "���ߤj���p", "");
        addOption(document.myform.selectschool, "124677", "���߮��H��p", "");
        addOption(document.myform.selectschool, "124678", "���ߤT�J��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�X�_��') {
        addOption(document.myform.selectschool, "124679", "���߭X�_��p", "");
        addOption(document.myform.selectschool, "124680", "���߭X�_�Ϧ��\��p", "");
        addOption(document.myform.selectschool, "124681", "���߬�[��p", "");
        addOption(document.myform.selectschool, "124754", "���߿��F��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�æw��') {
        addOption(document.myform.selectschool, "124682", "���ߥæw��p", "");
        addOption(document.myform.selectschool, "124683", "���߷s���p", "");
        addOption(document.myform.selectschool, "124741", "���ߺ��s��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "124684", "����������p", "");
        addOption(document.myform.selectschool, "124685", "���߫n�w��p", "");
        addOption(document.myform.selectschool, "124686", "���߹��ְ�p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '��x��') {
        addOption(document.myform.selectschool, "124687", "���߱�x��p", "");
        addOption(document.myform.selectschool, "124688", "���߳H�d��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�X�s��') {
        addOption(document.myform.selectschool, "124689", "���ߺX�s��p", "");
        addOption(document.myform.selectschool, "124690", "���߷ˬw��p", "");
        addOption(document.myform.selectschool, "124691", "���ߺX�s�Ϲ��s��p", "");
        addOption(document.myform.selectschool, "124692", "���߶���p", "");
        addOption(document.myform.selectschool, "124693", "���ߺX����p", "");
        addOption(document.myform.selectschool, "124694", "�������f��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���@��') {
        addOption(document.myform.selectschool, "124697", "���߬��@��p", "");
        addOption(document.myform.selectschool, "124698", "���ߪF����p", "");
        addOption(document.myform.selectschool, "124699", "���ߦN�v��p", "");
        addOption(document.myform.selectschool, "124700", "�����s�{��p", "");
        addOption(document.myform.selectschool, "124701", "���ߤ��°�p", "");
        addOption(document.myform.selectschool, "124702", "���߼s����p", "");
        addOption(document.myform.selectschool, "124703", "�����s�s��p", "");
        addOption(document.myform.selectschool, "124704", "���ߺ֦w��p", "");
        addOption(document.myform.selectschool, "124705", "���ߦN�F��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���t��') {
        addOption(document.myform.selectschool, "124706", "���ߤ��t��p", "");
        addOption(document.myform.selectschool, "124707", "�����y�@��p", "");
        addOption(document.myform.selectschool, "124708", "���߷s�o��p", "");
        addOption(document.myform.selectschool, "124709", "�����s����p", "");
        addOption(document.myform.selectschool, "124710", "���߷s�°�p", "");
        addOption(document.myform.selectschool, "124711", "�����_�Ӱ�p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���L��') {
        addOption(document.myform.selectschool, "124712", "���ߤ����p", "");
        addOption(document.myform.selectschool, "124713", "���ߤW����p", "");
        addOption(document.myform.selectschool, "124714", "���߷s�ܰ�p", "");
        addOption(document.myform.selectschool, "124715", "���߶��Ӱ�p", "");
        addOption(document.myform.selectschool, "124716", "���ߧ��L��p", "");
        addOption(document.myform.selectschool, "124730", "���ߧ��L�ϥ��ڤj�R��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "124718", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "124719", "�����[�F��p", "");
        addOption(document.myform.selectschool, "124720", "���߷��W��p", "");
        addOption(document.myform.selectschool, "124721", "���ߪ��˰�p", "");
        addOption(document.myform.selectschool, "124722", "���ߤ�]��p", "");
        addOption(document.myform.selectschool, "124723", "���ߦ����p", "");
        addOption(document.myform.selectschool, "124724", "���ߴ��q��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�ҥP��') {
        addOption(document.myform.selectschool, "124725", "���ߥҥP��p", "");
        addOption(document.myform.selectschool, "124726", "���ߤp�L��p", "");
        addOption(document.myform.selectschool, "124727", "�����_����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�����L��') {
        addOption(document.myform.selectschool, "124731", "���ߥ��Ͱ�p", "");
        addOption(document.myform.selectschool, "124755", "���ߨ����L�ϥ��v��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�Z�L��') {
        addOption(document.myform.selectschool, "124732", "���߭Z�L��p", "");
        addOption(document.myform.selectschool, "124733", "���ߦh�ǰ�p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�緽��') {
        addOption(document.myform.selectschool, "124734", "���߮緽��p", "");
        addOption(document.myform.selectschool, "124735", "���߫ؤs��p", "");
        addOption(document.myform.selectschool, "124736", "���߿�����p", "");
        addOption(document.myform.selectschool, "124737", "�����_�s��p", "");
        addOption(document.myform.selectschool, "124738", "���߼̤s��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�Q�L��') {
        addOption(document.myform.selectschool, "513601", "�����Q�L��p�@", "");
        addOption(document.myform.selectschool, "513602", "�����Q�L�ϩ�����p�@", "");
        addOption(document.myform.selectschool, "513603", "���ߥ��a��p�@", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "523601", "���߹��s�Ϲ��s��p�@", "");
        addOption(document.myform.selectschool, "523602", "���߹�����p�@", "");
        addOption(document.myform.selectschool, "523603", "���ߤ�����p�@", "");
        addOption(document.myform.selectschool, "523604", "���߹��s�Ϥ��s��p�@", "");
        addOption(document.myform.selectschool, "523605", "���߹ؤs��p�@", "");
        addOption(document.myform.selectschool, "523606", "�����s�ذ�p�@", "");
        addOption(document.myform.selectschool, "523607", "���ߤE�p��p�@", "");
        addOption(document.myform.selectschool, "521301", "�p�ߩ��۰������]��p", "");
        addOption(document.myform.selectschool, "521303", "�p�ߤj�a�������]��p", "");
        addOption(document.myform.selectschool, "521401", "�p�ߤ������ժ��]��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "533601", "���ߥ����p�@", "");
        addOption(document.myform.selectschool, "533602", "�����«���p", "");
        addOption(document.myform.selectschool, "533603", "���߷s����p", "");
        addOption(document.myform.selectschool, "533604", "���߷s����p", "");
        addOption(document.myform.selectschool, "533605", "���ߩ��w��p", "");
        addOption(document.myform.selectschool, "533606", "���߳ӧQ��p", "");
        addOption(document.myform.selectschool, "533607", "���̤߫s��p", "");
        addOption(document.myform.selectschool, "533608", "���ߥòM��p", "");
        addOption(document.myform.selectschool, "533609", "���߷s�W��p", "");
        addOption(document.myform.selectschool, "533610", "���ߺ֤s��p", "");
        addOption(document.myform.selectschool, "533611", "���ߤ婲��p", "");
        addOption(document.myform.selectschool, "533612", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "543601", "���߷����p", "");
        addOption(document.myform.selectschool, "543602", "���߫�l��p", "");
        addOption(document.myform.selectschool, "543603", "���ߴ�����p", "");
        addOption(document.myform.selectschool, "543604", "���ߥk����p", "");
        addOption(document.myform.selectschool, "543605", "���߲�����p", "");
        addOption(document.myform.selectschool, "543606", "���ߥ[����p", "");
        addOption(document.myform.selectschool, "543607", "���߷�����p", "");
        addOption(document.myform.selectschool, "543608", "���߻A�̰�(��)�p", "");
        addOption(document.myform.selectschool, "543609", "���ߪo�t��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�T����') {
        addOption(document.myform.selectschool, "553601", "���ߤT����p", "");
        addOption(document.myform.selectschool, "553602", "���߹�����p", "");
        addOption(document.myform.selectschool, "553603", "���߷R���p", "");
        addOption(document.myform.selectschool, "553604", "���ߤQ����p", "");
        addOption(document.myform.selectschool, "553605", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "553606", "���߳շR��p", "");
        addOption(document.myform.selectschool, "553607", "���߷���p", "");
        addOption(document.myform.selectschool, "553608", "���ߤT���ϥ��ڰ�p", "");
        addOption(document.myform.selectschool, "553609", "���߲��q��p", "");
        addOption(document.myform.selectschool, "553610", "���ߥ��Z��p", "");
        addOption(document.myform.selectschool, "553611", "���ߪF����p", "");
        addOption(document.myform.selectschool, "553612", "���ߪe�ذ�p", "");
        addOption(document.myform.selectschool, "553613", "���߶�����p", "");
        addOption(document.myform.selectschool, "553614", "���ߪe����p", "");
    }

    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "563601", "���߷s���Ϸs����p�@", "");
        addOption(document.myform.selectschool, "563602", "���ߤj�P��p�@", "");
        addOption(document.myform.selectschool, "563603", "���߫H�q��p�@", "");
        addOption(document.myform.selectschool, "563604", "���ߤC���p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�e����') {
        addOption(document.myform.selectschool, "573601", "���߫e����p�@", "");
        addOption(document.myform.selectschool, "573602", "���߫ذ��p�@", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�d����') {
        addOption(document.myform.selectschool, "583601", "���߭d�w��p�@", "");
        addOption(document.myform.selectschool, "583602", "���߭d���Ϧ��\��p", "");
        addOption(document.myform.selectschool, "583603", "���ߤ��v��p�@", "");
        addOption(document.myform.selectschool, "583604", "���߳ͱ۰�p", "");
        addOption(document.myform.selectschool, "583605", "���ߥ|����p�@", "");
        addOption(document.myform.selectschool, "583606", "���ߺ֪F��p�@", "");
        addOption(document.myform.selectschool, "583607", "���߭d���Ϥ�����p�@", "");
        addOption(document.myform.selectschool, "583608", "���ߺֱd��p", "");
        addOption(document.myform.selectschool, "580301", "��߰��v�j�������]��p", "");
        addOption(document.myform.selectschool, "583F01", "���߰����Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�e���') {
        addOption(document.myform.selectschool, "593601", "���߫e���p�@", "");
        addOption(document.myform.selectschool, "593602", "���߷�Ұ�p�@", "");
        addOption(document.myform.selectschool, "593603", "���ߤ��R��p�@", "");
        addOption(document.myform.selectschool, "593604", "���߼ָs��p�@", "");
        addOption(document.myform.selectschool, "593605", "���߷R�s��p�@", "");
        addOption(document.myform.selectschool, "593606", "���ߴ_����p�@", "");
        addOption(document.myform.selectschool, "593607", "���߷��װ�p�@", "");
        addOption(document.myform.selectschool, "593608", "���ߩ�����p�@", "");
        addOption(document.myform.selectschool, "593609", "���ߥ��ذ�p�@", "");
        addOption(document.myform.selectschool, "593610", "���߷粻��p", "");
        addOption(document.myform.selectschool, "593611", "���������p", "");
        addOption(document.myform.selectschool, "593612", "���ߦ򤽰�p", "");
        addOption(document.myform.selectschool, "593613", "���߫e��ϥ��v��p", "");
        addOption(document.myform.selectschool, "593614", "���߬�����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�X�z��') {
        addOption(document.myform.selectschool, "603601", "���ߺX�z��p", "");
        addOption(document.myform.selectschool, "603602", "���ߤj�°�p", "");
        addOption(document.myform.selectschool, "603603", "���ߤ��w��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�p���') {
        addOption(document.myform.selectschool, "613601", "���ߤp���p", "");
        addOption(document.myform.selectschool, "613602", "���߻�L��p", "");
        addOption(document.myform.selectschool, "613604", "���߫C�s��p", "");
        addOption(document.myform.selectschool, "613605", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "613606", "���߻���p", "");
        addOption(document.myform.selectschool, "613607", "���ߩW����p", "");
        addOption(document.myform.selectschool, "613608", "���ߤG�d��p", "");
        addOption(document.myform.selectschool, "613609", "���۪߮L��p", "");
        addOption(document.myform.selectschool, "613610", "���ߺ~����p", "");
        addOption(document.myform.selectschool, "613611", "���ߵؤs��p", "");
        addOption(document.myform.selectschool, "613612", "���ߴ�M��p", "");
        addOption(document.myform.selectschool, "613613", "���߻񶧰�p", "");
        addOption(document.myform.selectschool, "613614", "���ߩ��q��p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�y����') {
        addOption(document.myform.selectschool, "024601", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "024602", "���ߩy����p", "");
        addOption(document.myform.selectschool, "024603", "���ߤO���p", "");
        addOption(document.myform.selectschool, "024604", "���߷s�Ͱ�p", "");
        addOption(document.myform.selectschool, "024605", "���ߥ��_��p", "");
        addOption(document.myform.selectschool, "024606", "���ߨ|�~��p", "");
        addOption(document.myform.selectschool, "024607", "���߳ͱ۰�p", "");
        addOption(document.myform.selectschool, "024608", "���߾�����p", "");
        addOption(document.myform.selectschool, "024609", "���߫n�̰�p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == 'ù�F��') {
        addOption(document.myform.selectschool, "024610", "����ù�F��p", "");
        addOption(document.myform.selectschool, "024611", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "024612", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "024613", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "024614", "���ߦ˪L��p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == 'Ĭ�D��') {
        addOption(document.myform.selectschool, "024615", "����Ĭ�D��p", "");
        addOption(document.myform.selectschool, "024616", "���߰��ɰ�p", "");
        addOption(document.myform.selectschool, "024617", "���߽��ܰ�p", "");
        addOption(document.myform.selectschool, "024618", "���ߤh�Ӱ�p", "");
        addOption(document.myform.selectschool, "024619", "���ߥüְ�p", "");
        addOption(document.myform.selectschool, "024620", "���߫n�w��p", "");
        addOption(document.myform.selectschool, "024621", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "024622", "���ߨ|�^��p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�Y����') {
        addOption(document.myform.selectschool, "024623", "�����Y����p", "");
        addOption(document.myform.selectschool, "024624", "���ߦ˦w��p", "");
        addOption(document.myform.selectschool, "024625", "���ߤG����p", "");
        addOption(document.myform.selectschool, "024626", "���ߤj�˰�p", "");
        addOption(document.myform.selectschool, "024627", "���ߤj����p", "");
        addOption(document.myform.selectschool, "024628", "���߱�D��p", "");
        addOption(document.myform.selectschool, "024698", "���ߤH���(��)�p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�G�˶m') {
        addOption(document.myform.selectschool, "024629", "�����G�˰�p", "");
        addOption(document.myform.selectschool, "024630", "���ߥ|����p", "");
        addOption(document.myform.selectschool, "024631", "�����s���p", "");
        addOption(document.myform.selectschool, "024632", "���ߥɥа�p", "");
        addOption(document.myform.selectschool, "024633", "���ߤT����p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '���s�m') {
        addOption(document.myform.selectschool, "024634", "���߭��s��p", "");
        addOption(document.myform.selectschool, "024635", "���߲`����p", "");
        addOption(document.myform.selectschool, "024636", "���ߤC���p", "");
        addOption(document.myform.selectschool, "024637", "���ߦP�ְ�p", "");
        addOption(document.myform.selectschool, "024638", "���ߴ�s��p", "");
        addOption(document.myform.selectschool, "024639", "���ߤj���p", "");
        addOption(document.myform.selectschool, "024640", "���ߤ�����(��)�p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "024643", "���ߧ����p", "");
        addOption(document.myform.selectschool, "024644", "���ߥj�F��p", "");
        addOption(document.myform.selectschool, "024645", "���ߤ��]��p", "");
        addOption(document.myform.selectschool, "024646", "���߹L����p", "");
        addOption(document.myform.selectschool, "024647", "���ߤj�ְ�p", "");
        addOption(document.myform.selectschool, "024648", "���߷s�n��p", "");
        addOption(document.myform.selectschool, "021310", "�p�ߤ��D�������]��p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "024649", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "024650", "���߾Ƕi��p", "");
        addOption(document.myform.selectschool, "024651", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "024652", "���ߧQ�A��p", "");
        addOption(document.myform.selectschool, "024653", "���ߧ��°�p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�V�s�m') {
        addOption(document.myform.selectschool, "024654", "���ߥV�s��p", "");
        addOption(document.myform.selectschool, "024655", "���ߪF����p", "");
        addOption(document.myform.selectschool, "024656", "���߶��w��p", "");
        addOption(document.myform.selectschool, "024657", "���ߪZ�W��p", "");
        addOption(document.myform.selectschool, "024658", "���߼s����p", "");
        addOption(document.myform.selectschool, "024659", "���ߤj�i��p", "");
        addOption(document.myform.selectschool, "024660", "���߬_�L��p", "");
        addOption(document.myform.selectschool, "024699", "���߷O�ߵؼw�ֹ����(��)�p", "");
        addOption(document.myform.selectschool, "024701", "���߲M����p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�T�P�m') {
        addOption(document.myform.selectschool, "024661", "���ߤT�P��p", "");
        addOption(document.myform.selectschool, "024662", "���ߤj�w��p", "");
        addOption(document.myform.selectschool, "024663", "���߾˩���p", "");
        addOption(document.myform.selectschool, "024664", "���߸U�I��p", "");
        addOption(document.myform.selectschool, "024665", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�j�P�m') {
        addOption(document.myform.selectschool, "024668", "���ߥ|�u��p", "");
        addOption(document.myform.selectschool, "024669", "���߫n�s��p", "");
        addOption(document.myform.selectschool, "024670", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "024671", "���ߴH�˰�p", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�n�D�m') {
        addOption(document.myform.selectschool, "024672", "���߫n�D��p", "");
        addOption(document.myform.selectschool, "024673", "���ߺѭ԰�p", "");
        addOption(document.myform.selectschool, "024674", "���ߪZ���p", "");
        addOption(document.myform.selectschool, "024675", "���߿D���p", "");
        addOption(document.myform.selectschool, "024676", "���ߪF�D��p", "");
        addOption(document.myform.selectschool, "024677", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "024678", "���ߪ��v��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�s���') {
        addOption(document.myform.selectschool, "031601", "�p�ߺָS������p", "");
        addOption(document.myform.selectschool, "031602", "�p�߿ե˰�p", "");
        addOption(document.myform.selectschool, "034722", "�����s���p", "");
        addOption(document.myform.selectschool, "034723", "���߼w�s��p", "");
        addOption(document.myform.selectschool, "034724", "���߼��s��p", "");
        addOption(document.myform.selectschool, "034725", "���ߥ۪���p", "");
        addOption(document.myform.selectschool, "034726", "���߰����p", "");
        addOption(document.myform.selectschool, "034727", "�����s����p", "");
        addOption(document.myform.selectschool, "034728", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "034729", "���ߪZ�~��p", "");
        addOption(document.myform.selectschool, "034755", "�����s�P��p", "");
        addOption(document.myform.selectschool, "034769", "���ߤT�|��p", "");
        addOption(document.myform.selectschool, "034785", "�������s��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '���c��') {
        addOption(document.myform.selectschool, "031603", "�p�ߦ��o��(��)�p", "");
        addOption(document.myform.selectschool, "034666", "���ߤ��c��p", "");
        addOption(document.myform.selectschool, "034667", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "034668", "���߷s����p", "");
        addOption(document.myform.selectschool, "034669", "���ߪݨ���p", "");
        addOption(document.myform.selectschool, "034670", "���߷s���p", "");
        addOption(document.myform.selectschool, "034671", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "034672", "���ߴ�����p", "");
        addOption(document.myform.selectschool, "034673", "���ߴI�x��p", "");
        addOption(document.myform.selectschool, "034674", "���߫C�H��p", "");
        addOption(document.myform.selectschool, "034675", "���ߤ��c��p", "");
        addOption(document.myform.selectschool, "034676", "���ߤj�[��p", "");
        addOption(document.myform.selectschool, "034677", "���ߤs�F��p", "");
        addOption(document.myform.selectschool, "034678", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "034679", "���ߦۥ߰�p", "");
        addOption(document.myform.selectschool, "034680", "�����s����p", "");
        addOption(document.myform.selectschool, "034681", "���ߤ��w��p", "");
        addOption(document.myform.selectschool, "034745", "���߿����p", "");
        addOption(document.myform.selectschool, "034746", "���ߵس԰�p", "");
        addOption(document.myform.selectschool, "034753", "���ߪL�˰�p", "");
        addOption(document.myform.selectschool, "034764", "���ߩ��ְ�p", "");
        addOption(document.myform.selectschool, "034765", "���߿�����p", "");
        addOption(document.myform.selectschool, "034773", "���ߤ����p", "");
        addOption(document.myform.selectschool, "034774", "���ߤ��Ͱ�p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '����') {
        addOption(document.myform.selectschool, "031604", "�p�߱d�ܺ���(��)�p", "");
        addOption(document.myform.selectschool, "034601", "���߮���p", "");
        addOption(document.myform.selectschool, "034602", "���ߪF����p", "");
        addOption(document.myform.selectschool, "034603", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "034604", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "034605", "���߷|�]��p", "");
        addOption(document.myform.selectschool, "034606", "���߫ذ��p", "");
        addOption(document.myform.selectschool, "034607", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "034608", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "034609", "���߫n����p", "");
        addOption(document.myform.selectschool, "034610", "���ߦ����p", "");
        addOption(document.myform.selectschool, "034611", "�����s�s��p", "");
        addOption(document.myform.selectschool, "034612", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "034743", "���߫C�˰�p", "");
        addOption(document.myform.selectschool, "034747", "���ߦP�w��p", "");
        addOption(document.myform.selectschool, "034752", "���߫ؼw��p", "");
        addOption(document.myform.selectschool, "034756", "���ߤj����p", "");
        addOption(document.myform.selectschool, "034758", "���߷O���p", "");
        addOption(document.myform.selectschool, "034759", "���ߤj�~��p", "");
        addOption(document.myform.selectschool, "034760", "���ߦP�w��p", "");
        addOption(document.myform.selectschool, "034775", "���߲��q��p", "");
        addOption(document.myform.selectschool, "034780", "���ߧְּ�p", "");
        addOption(document.myform.selectschool, "034781", "���ߥö���p", "");
        addOption(document.myform.selectschool, "034782", "���߷s�H��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == 'Ī�˰�') {
        addOption(document.myform.selectschool, "034613", "���߫n�r��p", "");
        addOption(document.myform.selectschool, "034614", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "034615", "����Ī�˰�p", "");
        addOption(document.myform.selectschool, "034616", "���ߤj�˰�p", "");
        addOption(document.myform.selectschool, "034617", "���߷s����p", "");
        addOption(document.myform.selectschool, "034618", "���ߥ~����p", "");
        addOption(document.myform.selectschool, "034619", "���߳�����p", "");
        addOption(document.myform.selectschool, "034620", "���߮����p", "");
        addOption(document.myform.selectschool, "034621", "���ߤs�}��p", "");
        addOption(document.myform.selectschool, "034622", "���ߤj�ذ�p", "");
        addOption(document.myform.selectschool, "034623", "���߷s����p", "");
        addOption(document.myform.selectschool, "034744", "�����A����p", "");
        addOption(document.myform.selectschool, "034761", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "034786", "�����s�w��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�j���') {
        addOption(document.myform.selectschool, "034624", "���ߤj���p", "");
        addOption(document.myform.selectschool, "034625", "���ߦ`�Y��p", "");
        addOption(document.myform.selectschool, "034626", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "034627", "���߷ˮ���p", "");
        addOption(document.myform.selectschool, "034628", "���߼魵��p", "");
        addOption(document.myform.selectschool, "034629", "���ߦ˳��p", "");
        addOption(document.myform.selectschool, "034630", "���ߪG�L��p", "");
        addOption(document.myform.selectschool, "034631", "���ߦZ���p", "");
        addOption(document.myform.selectschool, "034632", "���ߨF�[��p", "");
        addOption(document.myform.selectschool, "034633", "���߮H�߰�p", "");
        addOption(document.myform.selectschool, "034634", "���ߤ��v��p", "");
        addOption(document.myform.selectschool, "034635", "���߳��d��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�t�s��') {
        addOption(document.myform.selectschool, "034636", "�����t�s��p", "");
        addOption(document.myform.selectschool, "034637", "���߹ؤs��p", "");
        addOption(document.myform.selectschool, "034638", "���ߺַ���p", "");
        addOption(document.myform.selectschool, "034639", "���ߤj�^��p", "");
        addOption(document.myform.selectschool, "034640", "���ߤj�H��p", "");
        addOption(document.myform.selectschool, "034641", "���ߤj�|��p", "");
        addOption(document.myform.selectschool, "034642", "���ߤs����p", "");
        addOption(document.myform.selectschool, "034643", "�����s�ذ�p", "");
        addOption(document.myform.selectschool, "034644", "���߷s����p", "");
        addOption(document.myform.selectschool, "034645", "���߼ֵ���p", "");
        addOption(document.myform.selectschool, "034751", "���߰j�s��(��)�p", "");
        addOption(document.myform.selectschool, "034757", "���ߩ��ְ�p", "");
        addOption(document.myform.selectschool, "034762", "���ߤ�ذ�p", "");
        addOption(document.myform.selectschool, "034770", "���߷����p", "");
        addOption(document.myform.selectschool, "034772", "���߫n����p", "");
        addOption(document.myform.selectschool, "034776", "���ߦ۱j��p", "");
        addOption(document.myform.selectschool, "034784", "���ߤ�Y��p", "");
        addOption(document.myform.selectschool, "034787", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "034789", "���ߤj���p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�K�w��') {
        addOption(document.myform.selectschool, "034646", "���ߤj����p", "");
        addOption(document.myform.selectschool, "034647", "���ߤj�i��p", "");
        addOption(document.myform.selectschool, "034648", "���ߤK�w��p", "");
        addOption(document.myform.selectschool, "034649", "���߷��װ�p", "");
        addOption(document.myform.selectschool, "034650", "���߾]�̰�p", "");
        addOption(document.myform.selectschool, "034651", "���ߤj�w��p", "");
        addOption(document.myform.selectschool, "034652", "���߭XФ��p", "");
        addOption(document.myform.selectschool, "034653", "���߼s����p", "");
        addOption(document.myform.selectschool, "034748", "���ߤj����p", "");
        addOption(document.myform.selectschool, "031320", "�p�߷s���������]��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�j�˰�') {
        addOption(document.myform.selectschool, "034654", "���ߤj�˰�p", "");
        addOption(document.myform.selectschool, "034655", "���߬��ذ�p", "");
        addOption(document.myform.selectschool, "034656", "���ߤ��]��p", "");
        addOption(document.myform.selectschool, "034657", "���ߺ֦w��p", "");
        addOption(document.myform.selectschool, "034658", "���ߦʦN��p", "");
        addOption(document.myform.selectschool, "034659", "���߷粻��p", "");
        addOption(document.myform.selectschool, "034660", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "034661", "���߭���L��p", "");
        addOption(document.myform.selectschool, "034662", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "034663", "���߹��R��p", "");
        addOption(document.myform.selectschool, "034664", "���߫n����p", "");
        addOption(document.myform.selectschool, "034665", "���ߥúְ�p", "");
        addOption(document.myform.selectschool, "034763", "���ߥФ߰�p", "");
        addOption(document.myform.selectschool, "034788", "���ߤ��M��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "034682", "���߫n�հ�p", "");
        addOption(document.myform.selectschool, "034683", "���ߧ��ΰ�p", "");
        addOption(document.myform.selectschool, "034684", "���߷s�հ�p", "");
        addOption(document.myform.selectschool, "034685", "���ߩ��s��p", "");
        addOption(document.myform.selectschool, "034686", "���ߪF�հ�p", "");
        addOption(document.myform.selectschool, "034687", "���ߤs�װ�p", "");
        addOption(document.myform.selectschool, "034688", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "034689", "���ߥ_�հ�p", "");
        addOption(document.myform.selectschool, "034742", "���ߪF�w��p", "");
        addOption(document.myform.selectschool, "034750", "���߲��w��p", "");
        addOption(document.myform.selectschool, "034754", "���ߤ�ư�p", "");
        addOption(document.myform.selectschool, "034766", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "034767", "���߸q����p", "");
        addOption(document.myform.selectschool, "034778", "���߷s�a��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "034690", "���߷�����p", "");
        addOption(document.myform.selectschool, "034691", "���ߤW�а�p", "");
        addOption(document.myform.selectschool, "034692", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "034693", "���ߴI����p", "");
        addOption(document.myform.selectschool, "034694", "���߷���p", "");
        addOption(document.myform.selectschool, "034695", "���ߤW���p", "");
        addOption(document.myform.selectschool, "034696", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "034697", "���߷�H��p", "");
        addOption(document.myform.selectschool, "034698", "���߰��a��p", "");
        addOption(document.myform.selectschool, "034699", "���ߥ|����p", "");
        addOption(document.myform.selectschool, "034700", "���߷����p", "");
        addOption(document.myform.selectschool, "034749", "���߷�����p", "");
        addOption(document.myform.selectschool, "034768", "���߷���p", "");
        addOption(document.myform.selectschool, "034771", "���߷��߰�p", "");
        addOption(document.myform.selectschool, "034779", "���߷�����(��)�p", "");
        addOption(document.myform.selectschool, "034529", "���ߤ����ꤤ���]��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�s�ΰ�') {
        addOption(document.myform.selectschool, "034701", "���߷s�ΰ�p", "");
        addOption(document.myform.selectschool, "034702", "���߱Ҥ��p", "");
        addOption(document.myform.selectschool, "034703", "���ߪF����p", "");
        addOption(document.myform.selectschool, "034704", "�����Y�w��p", "");
        addOption(document.myform.selectschool, "034705", "���ߥæw��p", "");
        addOption(document.myform.selectschool, "034706", "���߲´��p", "");
        addOption(document.myform.selectschool, "034707", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "034708", "���ߤj�Y��p", "");
        addOption(document.myform.selectschool, "034709", "���߳H����p", "");
        addOption(document.myform.selectschool, "034710", "���ߪ��l��p", "");
        addOption(document.myform.selectschool, "034711", "���߮H����p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�[����') {
        addOption(document.myform.selectschool, "034712", "�����[����p", "");
        addOption(document.myform.selectschool, "034713", "���ߤj���p", "");
        addOption(document.myform.selectschool, "034714", "���߫O�Ͱ�p", "");
        addOption(document.myform.selectschool, "034715", "���߷s�Y��p", "");
        addOption(document.myform.selectschool, "034716", "���߱[�W��p", "");
        addOption(document.myform.selectschool, "034717", "���ߤW�j��p", "");
        addOption(document.myform.selectschool, "034718", "���ߨ|����p", "");
        addOption(document.myform.selectschool, "034719", "���߯󺪰�p", "");
        addOption(document.myform.selectschool, "034720", "���ߴI�L��p", "");
        addOption(document.myform.selectschool, "034721", "���߾�L��p", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "034730", "���ߤ��ذ�p", "");
        addOption(document.myform.selectschool, "034731", "���ߤT����p", "");
        addOption(document.myform.selectschool, "034732", "���߸q����p", "");
        addOption(document.myform.selectschool, "034733", "����������p", "");
        addOption(document.myform.selectschool, "034734", "���߫�����p", "");
        addOption(document.myform.selectschool, "034735", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "034736", "���߰��q��p", "");
        addOption(document.myform.selectschool, "034737", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "034738", "���ߤT����p", "");
        addOption(document.myform.selectschool, "034740", "����ù�B��p", "");
        addOption(document.myform.selectschool, "034741", "���ߤ�����p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�˪F��') {
        addOption(document.myform.selectschool, "041601", "�p�ߤW����p", "");
        addOption(document.myform.selectschool, "044619", "���ߦ˪F��p", "");
        addOption(document.myform.selectschool, "044620", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "044621", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "044622", "���ߤG����p", "");
        addOption(document.myform.selectschool, "044623", "���ߦˤ���p", "");
        addOption(document.myform.selectschool, "044624", "���߭�����p", "");
        addOption(document.myform.selectschool, "044625", "���߳��װ�p", "");
        addOption(document.myform.selectschool, "044626", "���߷�p��p", "");
        addOption(document.myform.selectschool, "044679", "���ߤW�]��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�˥_��') {
        addOption(document.myform.selectschool, "041602", "�p�߱d�D��(��)�p", "");
        addOption(document.myform.selectschool, "044627", "���ߦ˥_��p", "");
        addOption(document.myform.selectschool, "044628", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "044629", "���ߦˤ���p", "");
        addOption(document.myform.selectschool, "044630", "���߷s����p", "");
        addOption(document.myform.selectschool, "044631", "���ߤ��a��p", "");
        addOption(document.myform.selectschool, "044632", "���ߪF����p", "");
        addOption(document.myform.selectschool, "044633", "�����ץа�p", "");
        addOption(document.myform.selectschool, "044634", "���߳¶��p", "");
        addOption(document.myform.selectschool, "044635", "���߷s���p", "");
        addOption(document.myform.selectschool, "044636", "���߻񩣰�p", "");
        addOption(document.myform.selectschool, "044678", "���߳շR��p", "");
        addOption(document.myform.selectschool, "044680", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "044682", "���ߤQ����p", "");
        addOption(document.myform.selectschool, "044683", "���߿�����p", "");
        addOption(document.myform.selectschool, "044684", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "044601", "���������p", "");
        addOption(document.myform.selectschool, "044602", "���ߪF�w��p", "");
        addOption(document.myform.selectschool, "044603", "���ߥۥ���p", "");
        addOption(document.myform.selectschool, "044604", "���ߩW�L��p", "");
        addOption(document.myform.selectschool, "044605", "���߫n�M��p", "");
        addOption(document.myform.selectschool, "044606", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "044607", "���ߪF����p", "");
        addOption(document.myform.selectschool, "044608", "�����A�s��p", "");
        addOption(document.myform.selectschool, "044609", "���ߥɤs��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�s�H��') {
        addOption(document.myform.selectschool, "044610", "���߷s�H��p", "");
        addOption(document.myform.selectschool, "044611", "���߷s�P��p", "");
        addOption(document.myform.selectschool, "044612", "���߷Ӫ���p", "");
        addOption(document.myform.selectschool, "044613", "���߲M����p", "");
        addOption(document.myform.selectschool, "044614", "���߷ӪF��p", "");
        addOption(document.myform.selectschool, "044615", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "044616", "���ߪD�d��p", "");
        addOption(document.myform.selectschool, "044617", "�����_�۰�p", "");
        addOption(document.myform.selectschool, "044618", "���ߤ�s��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '��f�m') {
        addOption(document.myform.selectschool, "044637", "���߷s���p", "");
        addOption(document.myform.selectschool, "044638", "���ߩM����p", "");
        addOption(document.myform.selectschool, "044639", "���߫H�հ�p", "");
        addOption(document.myform.selectschool, "044640", "���ߴ�f��p", "");
        addOption(document.myform.selectschool, "044642", "���ߪ��w��p", "");
        addOption(document.myform.selectschool, "044643", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "044644", "���ߵؿ���p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�s�׶m') {
        addOption(document.myform.selectschool, "044641", "���ߤs�T��p", "");
        addOption(document.myform.selectschool, "044650", "���ߺֿ���p", "");
        addOption(document.myform.selectschool, "044651", "���߷s�װ�p", "");
        addOption(document.myform.selectschool, "044652", "���߷翳��p", "");
        addOption(document.myform.selectschool, "044653", "���ߺ��s��p", "");
        addOption(document.myform.selectschool, "044654", "���߮H�M��p", "");
        addOption(document.myform.selectschool, "044681", "���ߪQ�L��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '��s�m') {
        addOption(document.myform.selectschool, "044645", "���߾�s��p", "");
        addOption(document.myform.selectschool, "044646", "���ߥмd��p", "");
        addOption(document.myform.selectschool, "044647", "���ߤj�{��p", "");
        addOption(document.myform.selectschool, "044648", "���ߨF�|��p", "");
        addOption(document.myform.selectschool, "044649", "���ߤ��W��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�|�L�m') {
        addOption(document.myform.selectschool, "044655", "�����|�L��p", "");
        addOption(document.myform.selectschool, "044656", "���ߺѼ��p", "");
        addOption(document.myform.selectschool, "044657", "���ߤ��s��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�_�s�m') {
        addOption(document.myform.selectschool, "044658", "�����_�s��p", "");
        addOption(document.myform.selectschool, "044659", "���߷s����p", "");
        addOption(document.myform.selectschool, "044660", "�������˰�p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�_�H�m') {
        addOption(document.myform.selectschool, "044662", "���ߥ_�H��p", "");
        addOption(document.myform.selectschool, "044663", "���ߤj�W��p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�o�ܶm') {
        addOption(document.myform.selectschool, "044664", "���߮o�ܰ�p", "");
        addOption(document.myform.selectschool, "044665", "���ߴI����p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�y�۶m') {
        addOption(document.myform.selectschool, "044666", "���ߦy�۰�p", "");
        addOption(document.myform.selectschool, "044667", "���߹ſ���p", "");
        addOption(document.myform.selectschool, "044668", "���߷s�ְ�p", "");
        addOption(document.myform.selectschool, "044669", "���߱����p", "");
        addOption(document.myform.selectschool, "044670", "�����A�̰�p", "");
        addOption(document.myform.selectschool, "044671", "���ߥɮp��p", "");
        addOption(document.myform.selectschool, "044672", "���ߥ۽U��p", "");
        addOption(document.myform.selectschool, "044673", "���ߨq�r��p", "");
        addOption(document.myform.selectschool, "044674", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '���p�m') {
        addOption(document.myform.selectschool, "044675", "���ߤ��p��p", "");
        addOption(document.myform.selectschool, "044676", "���߮�s��p", "");
        addOption(document.myform.selectschool, "044677", "���ߪ���p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�]�ߥ�') {
        addOption(document.myform.selectschool, "054601", "���߫إ\��p", "");
        addOption(document.myform.selectschool, "054602", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "054603", "���߹��|��p", "");
        addOption(document.myform.selectschool, "054604", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "054605", "���߱Ҥ��p", "");
        addOption(document.myform.selectschool, "054606", "���߷s�^��p", "");
        addOption(document.myform.selectschool, "054717", "���ߤ�ذ�p", "");
        addOption(document.myform.selectschool, "054718", "���ߺ֬P��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�Y�ζm') {
        addOption(document.myform.selectschool, "054607", "�����Y�ΰ�p", "");
        addOption(document.myform.selectschool, "054608", "���ߩ��w��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���]�m') {
        addOption(document.myform.selectschool, "054609", "���ߤ��]��p", "");
        addOption(document.myform.selectschool, "054610", "���ߤ��\��p", "");
        addOption(document.myform.selectschool, "054611", "���ߺְ��p", "");
        addOption(document.myform.selectschool, "054612", "�����b����p", "");
        addOption(document.myform.selectschool, "054614", "���߶}�q��p", "");
        addOption(document.myform.selectschool, "054615", "���߫n�e��p", "");
        addOption(document.myform.selectschool, "054721", "���ߤ��R��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���r�m') {
        addOption(document.myform.selectschool, "054616", "���߻��r��p", "");
        addOption(document.myform.selectschool, "054617", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "054618", "���ߤE���p", "");
        addOption(document.myform.selectschool, "054619", "���߷s����p", "");
        addOption(document.myform.selectschool, "054620", "���߿�����p", "");
        addOption(document.myform.selectschool, "054621", "���ߤ�p��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�T�q�m') {
        addOption(document.myform.selectschool, "054622", "���߫ؤ���p", "");
        addOption(document.myform.selectschool, "054623", "���߹�����p", "");
        addOption(document.myform.selectschool, "054624", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "054625", "�����U����p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�b����') {
        addOption(document.myform.selectschool, "054627", "���߭b�̰�p", "");
        addOption(document.myform.selectschool, "054628", "���ߤ�b��p", "");
        addOption(document.myform.selectschool, "054629", "���ߤs�}��p", "");
        addOption(document.myform.selectschool, "054630", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "054631", "�����ťа�p", "");
        addOption(document.myform.selectschool, "054632", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "054633", "���ߪL�˰�p", "");
        addOption(document.myform.selectschool, "054634", "���߿��H��p", "");
        addOption(document.myform.selectschool, "054722", "���߫��ܰ�p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�q�]��') {
        addOption(document.myform.selectschool, "054635", "���߳q�]��p", "");
        addOption(document.myform.selectschool, "054636", "���ߤ��ְ�p", "");
        addOption(document.myform.selectschool, "054637", "���߫�����p", "");
        addOption(document.myform.selectschool, "054638", "���߱ҩ���p", "");
        addOption(document.myform.selectschool, "054639", "���߷s�H��p", "");
        addOption(document.myform.selectschool, "054640", "���߯Q�ܰ�p", "");
        addOption(document.myform.selectschool, "054641", "���߫n�M��p", "");
        addOption(document.myform.selectschool, "054642", "���ߩW����p", "");
        addOption(document.myform.selectschool, "054643", "���ߦ`�Y��p", "");
        addOption(document.myform.selectschool, "054644", "���߷����p", "");
        addOption(document.myform.selectschool, "054645", "���ߺֿ��Z�N��(��)�p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "054646", "���ߦ���p", "");
        addOption(document.myform.selectschool, "054647", "���ߤ����p", "");
        addOption(document.myform.selectschool, "054648", "���߹����p", "");
        addOption(document.myform.selectschool, "054649", "���߷���p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�Y����') {
        addOption(document.myform.selectschool, "054650", "�����Y����p", "");
        addOption(document.myform.selectschool, "054651", "���ߤ��X��p", "");
        addOption(document.myform.selectschool, "054652", "���ߥís��p", "");
        addOption(document.myform.selectschool, "054653", "���ߦy�s��p", "");
        addOption(document.myform.selectschool, "054654", "���߹�����p", "");
        addOption(document.myform.selectschool, "054655", "���ߤ�ذ�p", "");
        addOption(document.myform.selectschool, "054656", "���ߦZ�ܰ�p", "");
        addOption(document.myform.selectschool, "054657", "���߷s����p", "");
        addOption(document.myform.selectschool, "054658", "���߫H�w��p", "");
        addOption(document.myform.selectschool, "054715", "���߫ذ��p", "");
        addOption(document.myform.selectschool, "054720", "�����Ϯ��p", "");
        addOption(document.myform.selectschool, "054724", "���߫H�q��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�˫n��') {
        addOption(document.myform.selectschool, "054659", "���ߦ˫n��p", "");
        addOption(document.myform.selectschool, "054660", "���߷ӫn��p", "");
        addOption(document.myform.selectschool, "054661", "���ߤj�H��p", "");
        addOption(document.myform.selectschool, "054662", "���߳��H��p", "");
        addOption(document.myform.selectschool, "054663", "���߮��f��p", "");
        addOption(document.myform.selectschool, "054716", "���ߦ˿���p", "");
        addOption(document.myform.selectschool, "054719", "���߷s�n��p", "");
        addOption(document.myform.selectschool, "054723", "���ߤs�ΰ�p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�T�W�m') {
        addOption(document.myform.selectschool, "054664", "���ߤT�W��p", "");
        addOption(document.myform.selectschool, "054667", "���ߤj�W��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�n�ܶm') {
        addOption(document.myform.selectschool, "054668", "���߫n�ܰ�p", "");
        addOption(document.myform.selectschool, "054669", "���ߥЬ���p", "");
        addOption(document.myform.selectschool, "054670", "���߫n�H��p", "");
        addOption(document.myform.selectschool, "054671", "���ߪF�e��p", "");
        addOption(document.myform.selectschool, "054672", "���߽��ܰ�p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�y���m') {
        addOption(document.myform.selectschool, "054673", "���߳y����p", "");
        addOption(document.myform.selectschool, "054674", "���߽ͤ��p", "");
        addOption(document.myform.selectschool, "054675", "�����A����p", "");
        addOption(document.myform.selectschool, "054676", "�����s�@��p", "");
        addOption(document.myform.selectschool, "054677", "���߹��ְ�p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "054679", "���߫��s��p", "");
        addOption(document.myform.selectschool, "054680", "���߷s���(��)�p", "");
        addOption(document.myform.selectschool, "054681", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "054683", "�����s�|��p", "");
        addOption(document.myform.selectschool, "054684", "���߷ˬw��p", "");
        addOption(document.myform.selectschool, "054685", "���ߥ~�H��p", "");
        addOption(document.myform.selectschool, "054686", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "054687", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "054688", "���ߦP����p", "");
        addOption(document.myform.selectschool, "054689", "���߮��_��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�j��m') {
        addOption(document.myform.selectschool, "054690", "���ߤj���p", "");
        addOption(document.myform.selectschool, "054691", "���߫n���p", "");
        addOption(document.myform.selectschool, "054692", "���ߵؿ���p", "");
        addOption(document.myform.selectschool, "054693", "���ߤj�n��p", "");
        addOption(document.myform.selectschool, "054694", "���ߪF����p", "");
        addOption(document.myform.selectschool, "054695", "���ߪZ�a��p", "");
        addOption(document.myform.selectschool, "054696", "���߷s�}��p", "");
        addOption(document.myform.selectschool, "054697", "���߮ߪL��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "054698", "���߷���p", "");
        addOption(document.myform.selectschool, "054699", "�����תL��p", "");
        addOption(document.myform.selectschool, "054700", "���ߥÿ���p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "054701", "���ߨ�����p", "");
        addOption(document.myform.selectschool, "054702", "���ߤ��W��p", "");
        addOption(document.myform.selectschool, "054703", "�����ץа�p", "");
        addOption(document.myform.selectschool, "054704", "���ߩW�L��p", "");
        addOption(document.myform.selectschool, "054705", "�������s��p", "");
        addOption(document.myform.selectschool, "054706", "���ߴ��s��p", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���w�m') {
        addOption(document.myform.selectschool, "054707", "���߮��w��(��)�p", "");
        addOption(document.myform.selectschool, "054708", "���߮�����p", "");
        addOption(document.myform.selectschool, "054709", "���߲M�w��p", "");
        addOption(document.myform.selectschool, "054711", "���ߨZ����p", "");
        addOption(document.myform.selectschool, "054712", "���߶H���p", "");
        addOption(document.myform.selectschool, "054714", "���߱����p", "");
        addOption(document.myform.selectschool, "054725", "���ߤh�L��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���ƥ�') {
        addOption(document.myform.selectschool, "074601", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "074602", "���ߥ��Ͱ�p", "");
        addOption(document.myform.selectschool, "074603", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "074604", "���߫n����p", "");
        addOption(document.myform.selectschool, "074605", "���߫n����p", "");
        addOption(document.myform.selectschool, "074606", "���ߪF�ڰ�p", "");
        addOption(document.myform.selectschool, "074607", "���߮��M��p", "");
        addOption(document.myform.selectschool, "074608", "���ߤT����p", "");
        addOption(document.myform.selectschool, "074609", "�����p����p", "");
        addOption(document.myform.selectschool, "074610", "���ߤj�˰�p", "");
        addOption(document.myform.selectschool, "074611", "���߰�t��p", "");
        addOption(document.myform.selectschool, "074612", "���ߧ֩x��p", "");
        addOption(document.myform.selectschool, "074613", "���ߥ۵P��p", "");
        addOption(document.myform.selectschool, "074614", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "074774", "���߫H�q��(��)�p", "");
        addOption(document.myform.selectschool, "074775", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "074615", "���ߪ���p", "");
        addOption(document.myform.selectschool, "074616", "���ߴI�s��p", "");
        addOption(document.myform.selectschool, "074617", "�����_�s��p", "");
        addOption(document.myform.selectschool, "074618", "���ߦP�w��p", "");
        addOption(document.myform.selectschool, "074619", "���ߤ�w��p", "");
        addOption(document.myform.selectschool, "074620", "���߭X�y��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '��¶m') {
        addOption(document.myform.selectschool, "074621", "���ߪ�°�p", "");
        addOption(document.myform.selectschool, "074622", "���ߤ岻��p", "");
        addOption(document.myform.selectschool, "074623", "���ߵثn��p", "");
        addOption(document.myform.selectschool, "074624", "���߹��R��p", "");
        addOption(document.myform.selectschool, "074625", "���ߤT�K��p", "");
        addOption(document.myform.selectschool, "074626", "���ߥըF��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�M����') {
        addOption(document.myform.selectschool, "074627", "���ߩM����p", "");
        addOption(document.myform.selectschool, "074628", "���ߩM�F��p", "");
        addOption(document.myform.selectschool, "074629", "���ߤj�Ű�p", "");
        addOption(document.myform.selectschool, "074630", "���ߤj�a��p", "");
        addOption(document.myform.selectschool, "074631", "���߷s�ܰ�p", "");
        addOption(document.myform.selectschool, "074632", "���߰��^��p", "");
        addOption(document.myform.selectschool, "074769", "���ߩM����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�u��m') {
        addOption(document.myform.selectschool, "074633", "���߽u���p", "");
        addOption(document.myform.selectschool, "074634", "���߾嶧��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "074635", "���߷s���p", "");
        addOption(document.myform.selectschool, "074636", "���ߦ��F��p", "");
        addOption(document.myform.selectschool, "074637", "���ߦ�����p", "");
        addOption(document.myform.selectschool, "074638", "���ߤj�P��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "074639", "���߳����p", "");
        addOption(document.myform.selectschool, "074640", "���ߤ�}��p", "");
        addOption(document.myform.selectschool, "074641", "���߬��z��p", "");
        addOption(document.myform.selectschool, "074642", "���߮��H��p", "");
        addOption(document.myform.selectschool, "074643", "���߷s����p", "");
        addOption(document.myform.selectschool, "074644", "���߯���p", "");
        addOption(document.myform.selectschool, "074645", "���߳��f��p", "");
        addOption(document.myform.selectschool, "074646", "���ߪF����p", "");
        addOption(document.myform.selectschool, "074771", "���߳��F��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�ֿ��m') {
        addOption(document.myform.selectschool, "074647", "���ߺ�����p", "");
        addOption(document.myform.selectschool, "074649", "���ߦ�հ�p", "");
        addOption(document.myform.selectschool, "074650", "���ߤj����p", "");
        addOption(document.myform.selectschool, "074651", "���ߥ��װ�p", "");
        addOption(document.myform.selectschool, "074652", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "074653", "���ߨ|�s��p", "");
        addOption(document.myform.selectschool, "074648", "���ߤ����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�q���m') {
        addOption(document.myform.selectschool, "074654", "���ߨq����p", "");
        addOption(document.myform.selectschool, "074655", "���߰�����p", "");
        addOption(document.myform.selectschool, "074656", "���ߵ��s��p", "");
        addOption(document.myform.selectschool, "074657", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "074658", "���߰����p", "");
        addOption(document.myform.selectschool, "074659", "���ߨ|����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�˴���') {
        addOption(document.myform.selectschool, "074660", "���߷˴��p", "");
        addOption(document.myform.selectschool, "074661", "���ߪF�˰�p", "");
        addOption(document.myform.selectschool, "074662", "���ߴ���p", "");
        addOption(document.myform.selectschool, "074663", "���ߴ�F��p", "");
        addOption(document.myform.selectschool, "074664", "���ߴ�n��p", "");
        addOption(document.myform.selectschool, "074665", "���߶����p", "");
        addOption(document.myform.selectschool, "074777", "���ߴ�_��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�H�Q�m') {
        addOption(document.myform.selectschool, "074666", "���߮H�Q��p", "");
        addOption(document.myform.selectschool, "074667", "���ߤj���p", "");
        addOption(document.myform.selectschool, "074668", "���߫n���p", "");
        addOption(document.myform.selectschool, "074669", "���ߦn�װ�p", "");
        addOption(document.myform.selectschool, "074670", "���ߥüְ�p", "");
        addOption(document.myform.selectschool, "074671", "���߷s����p", "");
        addOption(document.myform.selectschool, "074672", "���ߤѲ���p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�H�߶m') {
        addOption(document.myform.selectschool, "074673", "���߮H�߰�p", "");
        addOption(document.myform.selectschool, "074674", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "074675", "�������]��p", "");
        addOption(document.myform.selectschool, "074676", "����ù���p", "");
        addOption(document.myform.selectschool, "074677", "���߻�����p", "");
        addOption(document.myform.selectschool, "074678", "���߱���p", "");
        addOption(document.myform.selectschool, "074679", "���ߩ��t��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���L��') {
        addOption(document.myform.selectschool, "074680", "���߭��L��p", "");
        addOption(document.myform.selectschool, "074681", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "074682", "�����R�װ�p", "");
        addOption(document.myform.selectschool, "074683", "���߹��H��p", "");
        addOption(document.myform.selectschool, "074684", "���߭��F��p", "");
        addOption(document.myform.selectschool, "074685", "�����ǩ���p", "");
        addOption(document.myform.selectschool, "074686", "���ߪF�s��p", "");
        addOption(document.myform.selectschool, "074687", "���߫C�s��p", "");
        addOption(document.myform.selectschool, "074688", "���ߩ����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�j���m') {
        addOption(document.myform.selectschool, "074689", "���ߤj����p", "");
        addOption(document.myform.selectschool, "074690", "���ߤj���p", "");
        addOption(document.myform.selectschool, "074691", "���ߧ��W��p", "");
        addOption(document.myform.selectschool, "074692", "���ߧ��F��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�ùt�m') {
        addOption(document.myform.selectschool, "074693", "���ߥùt��p", "");
        addOption(document.myform.selectschool, "074694", "���ߺּw��p", "");
        addOption(document.myform.selectschool, "074695", "���ߥÿ���p", "");
        addOption(document.myform.selectschool, "074696", "���ߺֿ���p", "");
        addOption(document.myform.selectschool, "074697", "���߼w����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�Ф���') {
        addOption(document.myform.selectschool, "074698", "���ߥФ���p", "");
        addOption(document.myform.selectschool, "074699", "���ߤT���p", "");
        addOption(document.myform.selectschool, "074700", "���ߤj�w��p", "");
        addOption(document.myform.selectschool, "074701", "���ߤ��w��p", "");
        addOption(document.myform.selectschool, "074702", "���ߪF�M��p", "");
        addOption(document.myform.selectschool, "074703", "���ߩ�§��p", "");
        addOption(document.myform.selectschool, "074776", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���Y�m') {
        addOption(document.myform.selectschool, "074704", "���ߪ��Y��p", "");
        addOption(document.myform.selectschool, "074705", "���߾��Y��p", "");
        addOption(document.myform.selectschool, "074706", "���ߴ¿���p", "");
        addOption(document.myform.selectschool, "074707", "���߲M����p", "");
        addOption(document.myform.selectschool, "074708", "����������p", "");
        addOption(document.myform.selectschool, "074772", "�����ª���p", "");
        addOption(document.myform.selectschool, "074773", "���߱[����p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�G���m') {
        addOption(document.myform.selectschool, "074709", "���ߤG����p", "");
        addOption(document.myform.selectschool, "074710", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "074711", "���߷��u��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "074712", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "074713", "���߸U�Ӱ�p", "");
        addOption(document.myform.selectschool, "074714", "�������C��p", "");
        addOption(document.myform.selectschool, "074715", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "074716", "����������p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�Ч��m') {
        addOption(document.myform.selectschool, "074717", "���ߥЧ���p", "");
        addOption(document.myform.selectschool, "074719", "���߳��װ�p", "");
        addOption(document.myform.selectschool, "074720", "���ߤ��װ�p", "");
        addOption(document.myform.selectschool, "074718", "���߫n���p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���Y�m') {
        addOption(document.myform.selectschool, "074721", "���߰��Y��p", "");
        addOption(document.myform.selectschool, "074722", "���ߦX����p", "");
        addOption(document.myform.selectschool, "074723", "�����ױ[��p", "");
        addOption(document.myform.selectschool, "074724", "���ߪܴ°�p", "");
        addOption(document.myform.selectschool, "074725", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "074726", "���ߤj���p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�˦{�m') {
        addOption(document.myform.selectschool, "074727", "���߷˦{��p", "");
        addOption(document.myform.selectschool, "074728", "���߹��q��p", "");
        addOption(document.myform.selectschool, "074729", "���ߤT����p", "");
        addOption(document.myform.selectschool, "074730", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "074731", "���߼�v��p", "");
        addOption(document.myform.selectschool, "074732", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "074733", "���ߦ`�d��p", "");
        addOption(document.myform.selectschool, "074734", "���ߤj����p", "");
        addOption(document.myform.selectschool, "074735", "���߫n�{��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�G�L��') {
        addOption(document.myform.selectschool, "074736", "���ߤG�L��p", "");
        addOption(document.myform.selectschool, "074737", "���߿��ذ�p", "");
        addOption(document.myform.selectschool, "074738", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "074739", "���ߨ|�w��p", "");
        addOption(document.myform.selectschool, "074740", "���߭��а�p", "");
        addOption(document.myform.selectschool, "074741", "���߼s����p", "");
        addOption(document.myform.selectschool, "074742", "���߸U����p", "");
        addOption(document.myform.selectschool, "074743", "���߷s�Ͱ�p", "");
        addOption(document.myform.selectschool, "074744", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "074745", "���߭���p", "");
        addOption(document.myform.selectschool, "074746", "���߸U�X��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�j���m') {
        addOption(document.myform.selectschool, "074747", "���ߤj����p", "");
        addOption(document.myform.selectschool, "074748", "���ߥå���p", "");
        addOption(document.myform.selectschool, "074749", "���ߦ���p", "");
        addOption(document.myform.selectschool, "074750", "���߬��װ�p", "");
        addOption(document.myform.selectschool, "074751", "���߳��ܰ�p", "");
        addOption(document.myform.selectschool, "074752", "���߼��Y��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�˶�m') {
        addOption(document.myform.selectschool, "074753", "���ߦ˶��p", "");
        addOption(document.myform.selectschool, "074754", "���ߥ��Y��p", "");
        addOption(document.myform.selectschool, "074755", "���ߥ��t��p", "");
        addOption(document.myform.selectschool, "074756", "���ߪ��w��p", "");
        addOption(document.myform.selectschool, "074757", "���ߤg�w��p", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�ڭb�m') {
        addOption(document.myform.selectschool, "074758", "���ߪڭb��p", "");
        addOption(document.myform.selectschool, "074759", "���߫�d��p", "");
        addOption(document.myform.selectschool, "074760", "���ߥ��v��p", "");
        addOption(document.myform.selectschool, "074761", "���ߨ|�ذ�p", "");
        addOption(document.myform.selectschool, "074762", "���߯���p", "");
        addOption(document.myform.selectschool, "074763", "���߫طs��p", "");
        addOption(document.myform.selectschool, "074764", "���ߺ~�_��p", "");
        addOption(document.myform.selectschool, "074765", "���ߤ��\��p", "");
        addOption(document.myform.selectschool, "074766", "���߷s�_��p", "");
        addOption(document.myform.selectschool, "074767", "���߸��W��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�H����') {
        addOption(document.myform.selectschool, "081601", "�p�ߴ��x��p", "");
        addOption(document.myform.selectschool, "081602", "�p�ߧ��Y��(��)�p", "");
        addOption(document.myform.selectschool, "084615", "���߮H����p", "");
        addOption(document.myform.selectschool, "084616", "���߫n����p", "");
        addOption(document.myform.selectschool, "084617", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "084618", "���ߥv���p", "");
        addOption(document.myform.selectschool, "084619", "���߷R����p", "");
        addOption(document.myform.selectschool, "084620", "���߷˫n��p", "");
        addOption(document.myform.selectschool, "084621", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "084622", "���߮緽��p", "");
        addOption(document.myform.selectschool, "084623", "�����Q���p", "");
        addOption(document.myform.selectschool, "084624", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "084625", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "084626", "���ߤ��p��p", "");
        addOption(document.myform.selectschool, "084627", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�n�륫') {
        addOption(document.myform.selectschool, "084601", "���߫n���p", "");
        addOption(document.myform.selectschool, "084602", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "084603", "���߷s�װ�p", "");
        addOption(document.myform.selectschool, "084604", "������L��p", "");
        addOption(document.myform.selectschool, "084605", "���ߦ�����p", "");
        addOption(document.myform.selectschool, "084606", "���߼w����p", "");
        addOption(document.myform.selectschool, "084607", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "084608", "���ߥ��a��p", "");
        addOption(document.myform.selectschool, "084609", "���ߤ�s��p", "");
        addOption(document.myform.selectschool, "084610", "���߹��ذ�p", "");
        addOption(document.myform.selectschool, "084611", "���ߺs�M��p", "");
        addOption(document.myform.selectschool, "084612", "���߹ũM��p", "");
        addOption(document.myform.selectschool, "084613", "���ߥ��_��p", "");
        addOption(document.myform.selectschool, "084614", "���ߤd���p", "");
        addOption(document.myform.selectschool, "084748", "���ߺs����p", "");
        addOption(document.myform.selectschool, "084750", "���߱d�ذ�p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "084629", "���߯�ٰ�p", "");
        addOption(document.myform.selectschool, "084630", "���ߴ��M��p", "");
        addOption(document.myform.selectschool, "084631", "���߷s�ܰ�p", "");
        addOption(document.myform.selectschool, "084632", "���ߺѮp��p", "");
        addOption(document.myform.selectschool, "084633", "���ߤg����p", "");
        addOption(document.myform.selectschool, "084634", "�������V��p", "");
        addOption(document.myform.selectschool, "084635", "���ߪ��p��p", "");
        addOption(document.myform.selectschool, "084636", "���ߤ����p", "");
        addOption(document.myform.selectschool, "084637", "���ߥ��L��p", "");
        addOption(document.myform.selectschool, "084638", "���ߩW����p", "");
        addOption(document.myform.selectschool, "084639", "���߹�����p", "");
        addOption(document.myform.selectschool, "084640", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "084641", "���ߴI�\��p", "");
        addOption(document.myform.selectschool, "084749", "���ߪ�s��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�ˤs��') {
        addOption(document.myform.selectschool, "084642", "���ߦˤs��p", "");
        addOption(document.myform.selectschool, "084643", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "084644", "���ߪ��d��p", "");
        addOption(document.myform.selectschool, "084645", "���߹L�˰�p", "");
        addOption(document.myform.selectschool, "084646", "���ߤj�b��p", "");
        addOption(document.myform.selectschool, "084647", "���߷�˰�p", "");
        addOption(document.myform.selectschool, "084648", "���ߨq�L��p", "");
        addOption(document.myform.selectschool, "084649", "���߶��L��p", "");
        addOption(document.myform.selectschool, "084650", "�����U����p", "");
        addOption(document.myform.selectschool, "084651", "���߱��Y��p", "");
        addOption(document.myform.selectschool, "084652", "���ߤ��{��p", "");
        addOption(document.myform.selectschool, "084653", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "084751", "���߫e�s��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "084655", "���߶�����p", "");
        addOption(document.myform.selectschool, "084656", "���߹i�d��p", "");
        addOption(document.myform.selectschool, "084657", "���ߥé���p", "");
        addOption(document.myform.selectschool, "084658", "���ߩM����p", "");
        addOption(document.myform.selectschool, "084659", "���ߴI�s��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�W���m') {
        addOption(document.myform.selectschool, "084660", "���ߦW����p", "");
        addOption(document.myform.selectschool, "084661", "���߷s���p", "");
        addOption(document.myform.selectschool, "084662", "���ߦW�^��p", "");
        addOption(document.myform.selectschool, "084663", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "084664", "���ߤ}�c��p", "");
        addOption(document.myform.selectschool, "084665", "���ߥ��װ�p", "");
        addOption(document.myform.selectschool, "084666", "���߹�����p", "");
        addOption(document.myform.selectschool, "084667", "���߷s����p", "");
        addOption(document.myform.selectschool, "081313", "�p�ߥ������簪�����]��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "084668", "���߳�����p", "");
        addOption(document.myform.selectschool, "084669", "���ߨq�p��p", "");
        addOption(document.myform.selectschool, "084670", "���ߤ����p", "");
        addOption(document.myform.selectschool, "084671", "���߻�İ�p", "");
        addOption(document.myform.selectschool, "084672", "���ߤ����p", "");
        addOption(document.myform.selectschool, "084673", "���ߪ�m��p", "");
        addOption(document.myform.selectschool, "084674", "���߷�а�p", "");
        addOption(document.myform.selectschool, "084675", "���ߩM����p", "");
        addOption(document.myform.selectschool, "084676", "���߼s����p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '���d�m') {
        addOption(document.myform.selectschool, "084677", "���ߤ��d��p", "");
        addOption(document.myform.selectschool, "084678", "���߲n���p", "");
        addOption(document.myform.selectschool, "084679", "���ߥüְ�p", "");
        addOption(document.myform.selectschool, "084680", "���ߥñd��p", "");
        addOption(document.myform.selectschool, "084681", "���߲M����p", "");
        addOption(document.myform.selectschool, "084682", "���ߦܸ۰�p", "");
        addOption(document.myform.selectschool, "084683", "���ߥéM��p", "");
        addOption(document.myform.selectschool, "084684", "���߼s�ְ�p", "");
        addOption(document.myform.selectschool, "084685", "���ߩM����p", "");
        addOption(document.myform.selectschool, "084686", "���߼s�^��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "084687", "���߳�����p", "");
        addOption(document.myform.selectschool, "084688", "�����Y����p", "");
        addOption(document.myform.selectschool, "084689", "���ߪF����p", "");
        addOption(document.myform.selectschool, "084690", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "084691", "���ߩ����p", "");
        addOption(document.myform.selectschool, "084693", "���߷s����p", "");
        addOption(document.myform.selectschool, "084694", "���߼w�ư�p", "");
        addOption(document.myform.selectschool, "084695", "���ߦ@�M��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '��m�m') {
        addOption(document.myform.selectschool, "084696", "���߰�m��p", "");
        addOption(document.myform.selectschool, "084697", "���ߥ_�s��p", "");
        addOption(document.myform.selectschool, "084698", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "084699", "���ߺ��t��p", "");
        addOption(document.myform.selectschool, "084700", "���ߪ��y��p", "");
        addOption(document.myform.selectschool, "084701", "���߫n���p", "");
        addOption(document.myform.selectschool, "084702", "���ߨ|�ְ�p", "");
        addOption(document.myform.selectschool, "084703", "���ߴ䷽��p", "");
        addOption(document.myform.selectschool, "084704", "���ߪ��ְ�p", "");
        addOption(document.myform.selectschool, "084705", "���߰��p��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "084706", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "084707", "���߰p�|��p", "");
        addOption(document.myform.selectschool, "084708", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "084709", "���߷s����p", "");
        addOption(document.myform.selectschool, "084710", "���ߥɮp��p", "");
        addOption(document.myform.selectschool, "084711", "���ߥÿ���p", "");
        addOption(document.myform.selectschool, "084714", "���ߦ�����p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�H�q�m') {
        addOption(document.myform.selectschool, "084716", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "084717", "����ù�R��p", "");
        addOption(document.myform.selectschool, "084718", "���ߦP�I��p", "");
        addOption(document.myform.selectschool, "084719", "���߷R���p", "");
        addOption(document.myform.selectschool, "084720", "���ߤH�M��p", "");
        addOption(document.myform.selectschool, "084721", "���ߦa�Q��p", "");
        addOption(document.myform.selectschool, "084722", "���ߪF�H��p", "");
        addOption(document.myform.selectschool, "084724", "���߼�n��p", "");
        addOption(document.myform.selectschool, "084727", "���߮�L��p", "");
        addOption(document.myform.selectschool, "084728", "���߶��ذ�p", "");
        addOption(document.myform.selectschool, "084729", "���߷s�m��p", "");
        addOption(document.myform.selectschool, "084730", "���ߤ[����p", "");
        addOption(document.myform.selectschool, "084731", "�������s��p", "");
        addOption(document.myform.selectschool, "084732", "�����ץC��p", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '���R�m') {
        addOption(document.myform.selectschool, "084733", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "084734", "���߿˷R��p", "");
        addOption(document.myform.selectschool, "084735", "���ߪk�v��p", "");
        addOption(document.myform.selectschool, "084736", "���ߦX�@��p", "");
        addOption(document.myform.selectschool, "084737", "���ߤ��U��p", "");
        addOption(document.myform.selectschool, "084738", "���ߤO���p", "");
        addOption(document.myform.selectschool, "084739", "���߫n�װ�p", "");
        addOption(document.myform.selectschool, "084740", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "084741", "�����f�s��p", "");
        addOption(document.myform.selectschool, "084742", "���ߵo����p", "");
        addOption(document.myform.selectschool, "084743", "���߸U�װ�p", "");
        addOption(document.myform.selectschool, "084744", "���ߥ��R��p", "");
        addOption(document.myform.selectschool, "084745", "���߬K����p", "");
        addOption(document.myform.selectschool, "084746", "���߬�����p", "");
        addOption(document.myform.selectschool, "084747", "���߲M�Ұ�p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�j�|�m') {
        addOption(document.myform.selectschool, "091602", "�p�ߺִ���p", "");
        addOption(document.myform.selectschool, "094612", "���ߥj�|��p", "");
        addOption(document.myform.selectschool, "094613", "���ߪF�M��p", "");
        addOption(document.myform.selectschool, "094614", "���ߥå���p", "");
        addOption(document.myform.selectschool, "094615", "���ߵؤs��p", "");
        addOption(document.myform.selectschool, "094616", "���ߴѤs��p", "");
        addOption(document.myform.selectschool, "094617", "���۪߮L��p", "");
        addOption(document.myform.selectschool, "094618", "���߼̴��(��)�p", "");
        addOption(document.myform.selectschool, "094619", "���߯����ͺA�a���p", "");
        addOption(document.myform.selectschool, "094620", "���ߵثn��p", "");
        addOption(document.myform.selectschool, "094621", "���߿�����p", "");
        addOption(document.myform.selectschool, "094622", "���ߤs�p��p", "");
        addOption(document.myform.selectschool, "094623", "���ߤ��P��p", "");
        addOption(document.myform.selectschool, "094624", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�椻��') {
        addOption(document.myform.selectschool, "094601", "��������p", "");
        addOption(document.myform.selectschool, "094603", "���߷����p", "");
        addOption(document.myform.selectschool, "094604", "���߱��L��p", "");
        addOption(document.myform.selectschool, "094605", "���ߥۺh��p", "");
        addOption(document.myform.selectschool, "094606", "���߷ˬw��p", "");
        addOption(document.myform.selectschool, "094607", "���ߪL�Y��p", "");
        addOption(document.myform.selectschool, "094608", "���߫O����p", "");
        addOption(document.myform.selectschool, "094609", "������n��p", "");
        addOption(document.myform.selectschool, "094611", "���ߤ[�w��p", "");
        addOption(document.myform.selectschool, "094755", "���߶��L��p", "");
        addOption(document.myform.selectschool, "091601", "�p�ߺ��h�Q�Ȥp��", "");
        addOption(document.myform.selectschool, "094602", "������F��p", "");
        addOption(document.myform.selectschool, "094610", "���ߤ��۰�p", "");
        addOption(document.myform.selectschool, "094756", "���ߤ椻��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�L���m') {
        addOption(document.myform.selectschool, "094625", "���ߪL����p", "");
        addOption(document.myform.selectschool, "094626", "���߭�����p", "");
        addOption(document.myform.selectschool, "094627", "���ߤE�|��p", "");
        addOption(document.myform.selectschool, "094628", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "094629", "���ߪL����p", "");
        addOption(document.myform.selectschool, "094630", "���ߥ��Ͱ�p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '��n��') {
        addOption(document.myform.selectschool, "094631", "���ߤ�n��p", "");
        addOption(document.myform.selectschool, "094632", "���ߤj�F��p", "");
        addOption(document.myform.selectschool, "094633", "���ߥ��t��p", "");
        addOption(document.myform.selectschool, "094634", "���߭�����p", "");
        addOption(document.myform.selectschool, "094635", "���ߤ�w��p", "");
        addOption(document.myform.selectschool, "094636", "���߹��u��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�l��m') {
        addOption(document.myform.selectschool, "094637", "�����l���p", "");
        addOption(document.myform.selectschool, "094638", "�����ǥ���p", "");
        addOption(document.myform.selectschool, "094639", "���ߤj����p", "");
        addOption(document.myform.selectschool, "094640", "���ߤ��X��p", "");
        addOption(document.myform.selectschool, "094641", "���߹��M��p", "");
        addOption(document.myform.selectschool, "094642", "���ߨ|����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�j��m') {
        addOption(document.myform.selectschool, "094643", "���ߤj���p", "");
        addOption(document.myform.selectschool, "094644", "�������ܰ�p", "");
        addOption(document.myform.selectschool, "094645", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "094646", "���߹ſ���p", "");
        addOption(document.myform.selectschool, "094647", "�����p����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "094648", "���ߪ����p", "");
        addOption(document.myform.selectschool, "094649", "���ߥߤ���p", "");
        addOption(document.myform.selectschool, "094650", "���ߤj�ٰ�p", "");
        addOption(document.myform.selectschool, "094651", "���ߤ��˰�p", "");
        addOption(document.myform.selectschool, "094652", "���ߥ��_��p", "");
        addOption(document.myform.selectschool, "094653", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "094654", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "094655", "���߷G�ϰ�p", "");
        addOption(document.myform.selectschool, "094656", "���ߴf�Ӱ�p", "");
        addOption(document.myform.selectschool, "094658", "���ߦw�y��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�g�w��') {
        addOption(document.myform.selectschool, "094659", "���ߤg�w��p", "");
        addOption(document.myform.selectschool, "094660", "���߰�����p", "");
        addOption(document.myform.selectschool, "094661", "���߰�}��p", "");
        addOption(document.myform.selectschool, "094662", "���߫�H��p", "");
        addOption(document.myform.selectschool, "094663", "���ߨq���p", "");
        addOption(document.myform.selectschool, "094664", "���߷s�ܰ�p", "");
        addOption(document.myform.selectschool, "094665", "���ߧ��[��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�ǩ��m') {
        addOption(document.myform.selectschool, "094666", "���߽ǩ���p", "");
        addOption(document.myform.selectschool, "094667", "�����s�ɰ�p", "");
        addOption(document.myform.selectschool, "094668", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "094669", "���߼���p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�F�նm') {
        addOption(document.myform.selectschool, "094670", "���ߪF�հ�p", "");
        addOption(document.myform.selectschool, "094671", "���ߦw�n��p", "");
        addOption(document.myform.selectschool, "094672", "���ߩ��۰�p", "");
        addOption(document.myform.selectschool, "094673", "���ߦP�w��p", "");
        addOption(document.myform.selectschool, "094674", "�����s���p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�O��m') {
        addOption(document.myform.selectschool, "094675", "���߻O���p", "");
        addOption(document.myform.selectschool, "094676", "���߱[�װ�p", "");
        addOption(document.myform.selectschool, "094677", "���߬u�{��p", "");
        addOption(document.myform.selectschool, "094678", "���߷s����p", "");
        addOption(document.myform.selectschool, "094679", "���ߩ|�w��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "094680", "���ߤ����p", "");
        addOption(document.myform.selectschool, "094681", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "094682", "���߼s����p", "");
        addOption(document.myform.selectschool, "094683", "���ߦw�w��p", "");
        addOption(document.myform.selectschool, "094684", "���ߧd���p", "");
        addOption(document.myform.selectschool, "094685", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "094686", "���ߤ���p", "");
        addOption(document.myform.selectschool, "094687", "���ߤ忳��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�G�[�m') {
        addOption(document.myform.selectschool, "094688", "���ߤG�[��p", "");
        addOption(document.myform.selectschool, "094689", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "094690", "���ߪo����p", "");
        addOption(document.myform.selectschool, "094691", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "094692", "���ߥéw��p", "");
        addOption(document.myform.selectschool, "094693", "���߸q���p", "");
        addOption(document.myform.selectschool, "094694", "���ߦ�����p", "");
        addOption(document.myform.selectschool, "094695", "���ߨӴf��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�[�I�m') {
        addOption(document.myform.selectschool, "094696", "���߱[�I��p", "");
        addOption(document.myform.selectschool, "094697", "�����׺a��p", "");
        addOption(document.myform.selectschool, "094698", "���ߤj����p", "");
        addOption(document.myform.selectschool, "094699", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "094700", "���߶�����p", "");
        addOption(document.myform.selectschool, "094701", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '���d�m') {
        addOption(document.myform.selectschool, "094702", "���߳��d��p", "");
        addOption(document.myform.selectschool, "094703", "���߾��Y��p", "");
        addOption(document.myform.selectschool, "094704", "���ߩ�§��p", "");
        addOption(document.myform.selectschool, "094705", "���߿��ذ�p", "");
        addOption(document.myform.selectschool, "094706", "�����צw��p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "094707", "���߫n����p", "");
        addOption(document.myform.selectschool, "094708", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "094709", "���ߦn����p", "");
        addOption(document.myform.selectschool, "094710", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "094711", "���ߪF�a��p", "");
        addOption(document.myform.selectschool, "094712", "���ߴ¶���p", "");
        addOption(document.myform.selectschool, "094713", "���ߨ�����p", "");
        addOption(document.myform.selectschool, "094714", "���߹�����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "094715", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "094716", "���߷s�Ͱ�p", "");
        addOption(document.myform.selectschool, "094717", "���߫ȭ��p", "");
        addOption(document.myform.selectschool, "094718", "���ߤs����p", "");
        addOption(document.myform.selectschool, "094719", "���ߤ��w��p", "");
        addOption(document.myform.selectschool, "094720", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "094721", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "094722", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "094723", "���ߩM����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�|��m') {
        addOption(document.myform.selectschool, "094724", "���ߥ|���p", "");
        addOption(document.myform.selectschool, "094725", "���ߪF����p", "");
        addOption(document.myform.selectschool, "094726", "���߭��F��p", "");
        addOption(document.myform.selectschool, "094727", "���ߪL���p", "");
        addOption(document.myform.selectschool, "094728", "���ߤT�[��p", "");
        addOption(document.myform.selectschool, "094729", "���߫ض���p", "");
        addOption(document.myform.selectschool, "094730", "���߫n����p", "");
        addOption(document.myform.selectschool, "094731", "���߳�����p", "");
        addOption(document.myform.selectschool, "094732", "���ߩ��w��p", "");
        addOption(document.myform.selectschool, "094733", "���߫صذ�p", "");
        addOption(document.myform.selectschool, "094734", "���ߤ����p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�f��m') {
        addOption(document.myform.selectschool, "094735", "���ߤf���p", "");
        addOption(document.myform.selectschool, "094736", "���ߤ����p", "");
        addOption(document.myform.selectschool, "094737", "���ߪ����p", "");
        addOption(document.myform.selectschool, "094738", "���ߤU�[��p", "");
        addOption(document.myform.selectschool, "094739", "���߿��n��p", "");
        addOption(document.myform.selectschool, "094740", "���߱R���p", "");
        addOption(document.myform.selectschool, "094741", "���ߦ��s��p", "");
        addOption(document.myform.selectschool, "094742", "���߻O����p", "");
        addOption(document.myform.selectschool, "094743", "���߳����p", "");
        addOption(document.myform.selectschool, "094744", "���߹L���p", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '���L�m') {
        addOption(document.myform.selectschool, "094746", "�����r�Q��p", "");
        addOption(document.myform.selectschool, "094747", "���ߦy�s��p", "");
        addOption(document.myform.selectschool, "094748", "���ߧ�����p", "");
        addOption(document.myform.selectschool, "094749", "���ߤ奿��p", "");
        addOption(document.myform.selectschool, "094750", "���߸ۥ���p", "");
        addOption(document.myform.selectschool, "094751", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "094752", "���ߩM�w��p", "");
        addOption(document.myform.selectschool, "094753", "���ߤ���L��p", "");
        addOption(document.myform.selectschool, "094754", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���l��') {
        addOption(document.myform.selectschool, "104601", "���ߦ��l��p", "");
        addOption(document.myform.selectschool, "104602", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "104603", "�������˰�p", "");
        addOption(document.myform.selectschool, "104604", "���ߦ˧���p", "");
        addOption(document.myform.selectschool, "104605", "���ߪQ����p", "");
        addOption(document.myform.selectschool, "104742", "���߲��M��p", "");
        addOption(document.myform.selectschool, "104606", "���ߤj�m��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���U��') {
        addOption(document.myform.selectschool, "104607", "���ߥ��U��p", "");
        addOption(document.myform.selectschool, "104608", "���ߴ��s��p", "");
        addOption(document.myform.selectschool, "104609", "���ߥæw��p", "");
        addOption(document.myform.selectschool, "104610", "���߹L����p", "");
        addOption(document.myform.selectschool, "104611", "���߶Q�L��p", "");
        addOption(document.myform.selectschool, "104612", "���߷s���p", "");
        addOption(document.myform.selectschool, "104613", "���߷s�°�p", "");
        addOption(document.myform.selectschool, "104614", "���ߦn����p", "");
        addOption(document.myform.selectschool, "104736", "���ߥ��s��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�j�L��') {
        addOption(document.myform.selectschool, "104615", "���ߤj�L��p", "");
        addOption(document.myform.selectschool, "104616", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "104617", "���ߤ��L��p", "");
        addOption(document.myform.selectschool, "104618", "���߱Ƹ���p", "");
        addOption(document.myform.selectschool, "104620", "���ߪ��ΰ�p", "");
        addOption(document.myform.selectschool, "104739", "���ߥ��L��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "104621", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "104622", "���ߪF�a��p", "");
        addOption(document.myform.selectschool, "104623", "���ߤT����p", "");
        addOption(document.myform.selectschool, "104624", "���ߵ׮H��p", "");
        addOption(document.myform.selectschool, "104625", "���߿�����p", "");
        addOption(document.myform.selectschool, "104626", "���ߨq�L��p", "");
        addOption(document.myform.selectschool, "104627", "���ߪQ�s��p", "");
        addOption(document.myform.selectschool, "104628", "���ߤj�T��p", "");
        addOption(document.myform.selectschool, "104743", "���ߺְּ�p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�ˤf�m') {
        addOption(document.myform.selectschool, "104629", "���߷ˤf��p", "");
        addOption(document.myform.selectschool, "104630", "���߬��L��p", "");
        addOption(document.myform.selectschool, "104631", "���߮�L��p", "");
        addOption(document.myform.selectschool, "104632", "���߬h����p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�s��m') {
        addOption(document.myform.selectschool, "104633", "���߷s���p", "");
        addOption(document.myform.selectschool, "104634", "���ߤ����p", "");
        addOption(document.myform.selectschool, "104635", "���ߤ�ܰ�p", "");
        addOption(document.myform.selectschool, "104636", "���ߥj����p", "");
        addOption(document.myform.selectschool, "104637", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "104638", "���ߦw�M��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���}�m') {
        addOption(document.myform.selectschool, "104639", "���߻[�Y��p", "");
        addOption(document.myform.selectschool, "104640", "���ߤ��}��p", "");
        addOption(document.myform.selectschool, "104641", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "104642", "�����W����p", "");
        addOption(document.myform.selectschool, "104643", "���ߧ�d��p", "");
        addOption(document.myform.selectschool, "104645", "���ߥ_����p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�F�۶m') {
        addOption(document.myform.selectschool, "104647", "���ߪF�۰�p", "");
        addOption(document.myform.selectschool, "104648", "���߶���p", "");
        addOption(document.myform.selectschool, "104649", "���ߤT����p", "");
        addOption(document.myform.selectschool, "104650", "�����s���p", "");
        addOption(document.myform.selectschool, "104651", "���ߤU����p", "");
        addOption(document.myform.selectschool, "104652", "���ߴ��Y��p", "");
        addOption(document.myform.selectschool, "104653", "�����s�^��p", "");
        addOption(document.myform.selectschool, "104654", "���ߺ��d��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "104655", "���߳����p", "");
        addOption(document.myform.selectschool, "104656", "���߭��d��p", "");
        addOption(document.myform.selectschool, "104657", "���ߤU���p", "");
        addOption(document.myform.selectschool, "104658", "���ߺѼ��p", "");
        addOption(document.myform.selectschool, "104659", "���ߦ˶��p", "");
        addOption(document.myform.selectschool, "104660", "���߫���p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�q�˶m') {
        addOption(document.myform.selectschool, "104661", "���߸q�˰�p", "");
        addOption(document.myform.selectschool, "104663", "���ߥ��a��p", "");
        addOption(document.myform.selectschool, "104665", "���߹L����p", "");
        addOption(document.myform.selectschool, "104666", "���ߩM����p", "");
        addOption(document.myform.selectschool, "104668", "���߫n����p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�ӫO��') {
        addOption(document.myform.selectschool, "104669", "���ߤӫO��p", "");
        addOption(document.myform.selectschool, "104670", "���ߦw�F��p", "");
        addOption(document.myform.selectschool, "104671", "���߫n�s��p", "");
        addOption(document.myform.selectschool, "104672", "���߷s���p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���W�m') {
        addOption(document.myform.selectschool, "104673", "���ߤ��W��p", "");
        addOption(document.myform.selectschool, "104674", "���ߤj�[��p", "");
        addOption(document.myform.selectschool, "104675", "���߬h�L��p", "");
        addOption(document.myform.selectschool, "104676", "���ߩ��M��p", "");
        addOption(document.myform.selectschool, "104677", "���߸q����p", "");
        addOption(document.myform.selectschool, "104678", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "104679", "���ߥ_�^��p", "");
        addOption(document.myform.selectschool, "104680", "���߫n�t��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���H�m') {
        addOption(document.myform.selectschool, "104681", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "104682", "���ߤj����p", "");
        addOption(document.myform.selectschool, "104683", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "104684", "���߳�����p", "");
        addOption(document.myform.selectschool, "104685", "���ߩM����p", "");
        addOption(document.myform.selectschool, "104686", "���ߦP����p", "");
        addOption(document.myform.selectschool, "104688", "�����N����p", "");
        addOption(document.myform.selectschool, "104690", "���ߪ��f��p", "");
        addOption(document.myform.selectschool, "104692", "�����W���p", "");
        addOption(document.myform.selectschool, "104738", "���ߩM����p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�f���m') {
        addOption(document.myform.selectschool, "104693", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "104694", "���ߤ��|��p", "");
        addOption(document.myform.selectschool, "104695", "���߾�����p", "");
        addOption(document.myform.selectschool, "104696", "���ߤj���p", "");
        addOption(document.myform.selectschool, "104698", "���߻س���p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�˱T�m') {
        addOption(document.myform.selectschool, "104700", "���ߦ˱T��p", "");
        addOption(document.myform.selectschool, "104702", "�����s�s��p", "");
        addOption(document.myform.selectschool, "104704", "���߳�����p", "");
        addOption(document.myform.selectschool, "104705", "���߶�R��p", "");
        addOption(document.myform.selectschool, "104706", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "104707", "���߮緽��p", "");
        addOption(document.myform.selectschool, "104708", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "104709", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "104710", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "104712", "���߸q����p", "");
        addOption(document.myform.selectschool, "104713", "���ߨF�|��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���s�m') {
        addOption(document.myform.selectschool, "104715", "���߱��s��p", "");
        addOption(document.myform.selectschool, "104716", "���߱��`��p", "");
        addOption(document.myform.selectschool, "104717", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "104719", "���ߤӿ���p", "");
        addOption(document.myform.selectschool, "104720", "���߷稽��p", "");
        addOption(document.myform.selectschool, "104721", "���ߤj�n��p", "");
        addOption(document.myform.selectschool, "104722", "���߷�p��p", "");
        addOption(document.myform.selectschool, "104724", "���ߤөM��p", "");
        addOption(document.myform.selectschool, "104725", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "104740", "���߱��_��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�j�H�m') {
        addOption(document.myform.selectschool, "104726", "���ߤj�H��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�����s�m') {
        addOption(document.myform.selectschool, "104727", "���߹F����p", "");
        addOption(document.myform.selectschool, "104729", "���ߤQ�r��p", "");
        addOption(document.myform.selectschool, "104730", "���ߨӦN��p", "");
        addOption(document.myform.selectschool, "104731", "�����פs��p", "");
        addOption(document.myform.selectschool, "104732", "���ߤs����p", "");
        addOption(document.myform.selectschool, "104733", "���߷s����p", "");
        addOption(document.myform.selectschool, "104734", "���ߪ����s��(��)�p", "");
        addOption(document.myform.selectschool, "104735", "���߭��L��p", "");
        addOption(document.myform.selectschool, "104737", "���߯��s��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�̪F��') {
        addOption(document.myform.selectschool, "130601", "��̪߫F�Фj��p", "");
        addOption(document.myform.selectschool, "134601", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "134602", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "134603", "���߮��װ�p", "");
        addOption(document.myform.selectschool, "134604", "���ߤ��]��p", "");
        addOption(document.myform.selectschool, "134606", "�����b�n��p", "");
        addOption(document.myform.selectschool, "134607", "���߭ⶳ��p", "");
        addOption(document.myform.selectschool, "134608", "���߳ӧQ��p", "");
        addOption(document.myform.selectschool, "134609", "�����k�Ӱ�p", "");
        addOption(document.myform.selectschool, "134610", "���߫e�i��p", "");
        addOption(document.myform.selectschool, "134611", "���߭�a��p", "");
        addOption(document.myform.selectschool, "134612", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "134613", "���߫ذ��p", "");
        addOption(document.myform.selectschool, "134614", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "134615", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "134616", "���ߩM����p", "");
        addOption(document.myform.selectschool, "134772", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "134773", "���߷����p", "");
        addOption(document.myform.selectschool, "134774", "���߱R����p", "");
        addOption(document.myform.selectschool, "134786", "���ߥ��Ͱ�p", "");
        addOption(document.myform.selectschool, "134605", "���ߤj�P��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�U���m') {
        addOption(document.myform.selectschool, "134617", "���߸U����p", "");
        addOption(document.myform.selectschool, "134618", "���߷s�ܰ�p", "");
        addOption(document.myform.selectschool, "134619", "���߿��ذ�p", "");
        addOption(document.myform.selectschool, "134620", "���߷s����p", "");
        addOption(document.myform.selectschool, "134621", "���ߪ��ְ�p", "");
        addOption(document.myform.selectschool, "134622", "���߼s�w��p", "");
        addOption(document.myform.selectschool, "134623", "���߿��ư�p", "");
        addOption(document.myform.selectschool, "134775", "���ߥ|����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�ﬥ�m') {
        addOption(document.myform.selectschool, "134624", "�����ﬥ��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�E�p�m') {
        addOption(document.myform.selectschool, "134625", "���ߤE�p��p", "");
        addOption(document.myform.selectschool, "134626", "���߫��ܰ�p", "");
        addOption(document.myform.selectschool, "134627", "���ߴf�A��p", "");
        addOption(document.myform.selectschool, "134771", "���ߤT�h��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���v�m') {
        addOption(document.myform.selectschool, "134628", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "134629", "�����c�ذ�p", "");
        addOption(document.myform.selectschool, "134630", "���߼w���p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�Q�H�m') {
        addOption(document.myform.selectschool, "134631", "�����Q�H��p", "");
        addOption(document.myform.selectschool, "134632", "���ߥK����p", "");
        addOption(document.myform.selectschool, "134633", "���߰��԰�p", "");
        addOption(document.myform.selectschool, "134634", "���߷s���p", "");
        addOption(document.myform.selectschool, "134635", "���ߴ^���p", "");
        addOption(document.myform.selectschool, "134636", "���߮�����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "134637", "���߰����p", "");
        addOption(document.myform.selectschool, "134638", "�����¼d��p", "");
        addOption(document.myform.selectschool, "134639", "���߷s�װ�p", "");
        addOption(document.myform.selectschool, "134640", "���ߥФl��p", "");
        addOption(document.myform.selectschool, "134641", "���߷s�n��p", "");
        addOption(document.myform.selectschool, "134642", "���߮��s��p", "");
        addOption(document.myform.selectschool, "134644", "���߼s����p", "");
        addOption(document.myform.selectschool, "134645", "���߫n�ذ�p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "134646", "���ߨ����p", "");
        addOption(document.myform.selectschool, "134647", "���߸�����p", "");
        addOption(document.myform.selectschool, "134648", "���ߤg�w��p", "");
        addOption(document.myform.selectschool, "134649", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "134780", "���߶�Ӱ�p", "");
        addOption(document.myform.selectschool, "134781", "���ߥɥа�p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '��{��') {
        addOption(document.myform.selectschool, "134651", "���߼�{��p", "");
        addOption(document.myform.selectschool, "134652", "���ߥ��K��p", "");
        addOption(document.myform.selectschool, "134653", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "134654", "���ߥ|�L��p", "");
        addOption(document.myform.selectschool, "134655", "���߼�n��p", "");
        addOption(document.myform.selectschool, "134656", "���߼�F��p", "");
        addOption(document.myform.selectschool, "134777", "���߼�@��p", "");
        addOption(document.myform.selectschool, "134778", "���߼�M��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�U�r�m') {
        addOption(document.myform.selectschool, "134657", "���߸U�r��p", "");
        addOption(document.myform.selectschool, "134658", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "134659", "���ߨΦ���p", "");
        addOption(document.myform.selectschool, "134661", "���ߨ��s��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���H�m') {
        addOption(document.myform.selectschool, "134662", "���ߤ��H��p", "");
        addOption(document.myform.selectschool, "134663", "���ߨ|�^��p", "");
        addOption(document.myform.selectschool, "134664", "���߹�����p", "");
        addOption(document.myform.selectschool, "134665", "���߱R���p", "");
        addOption(document.myform.selectschool, "134666", "���߷s�Ͱ�p", "");
        addOption(document.myform.selectschool, "134667", "���ߺa�ذ�p", "");
        addOption(document.myform.selectschool, "134668", "���߾�����p", "");
        addOption(document.myform.selectschool, "134669", "���߹i�d��p", "");
        addOption(document.myform.selectschool, "134670", "���߮��w��p", "");
        addOption(document.myform.selectschool, "134671", "���ߪF�հ�p", "");
        addOption(document.myform.selectschool, "134672", "�����ץа�p", "");
        addOption(document.myform.selectschool, "134673", "���ߴI�а�p", "");
        addOption(document.myform.selectschool, "134776", "���ߪF���p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�˥жm') {
        addOption(document.myform.selectschool, "134674", "���ߦ˥а�p", "");
        addOption(document.myform.selectschool, "134675", "���ߦ�հ�p", "");
        addOption(document.myform.selectschool, "134676", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�s��m') {
        addOption(document.myform.selectschool, "134677", "���߷s���p", "");
        addOption(document.myform.selectschool, "134678", "���ߤj����p", "");
        addOption(document.myform.selectschool, "134679", "���߸U����p", "");
        addOption(document.myform.selectschool, "134680", "���߻���p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�D�d�m') {
        addOption(document.myform.selectschool, "134681", "���ߪD�d��p", "");
        addOption(document.myform.selectschool, "134682", "���߹��w��p", "");
        addOption(document.myform.selectschool, "134683", "���߫ؿ���p", "");
        addOption(document.myform.selectschool, "134684", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�F����') {
        addOption(document.myform.selectschool, "134686", "���ߪF���p", "");
        addOption(document.myform.selectschool, "134687", "���ߪF����p", "");
        addOption(document.myform.selectschool, "134688", "���߮��ذ�p", "");
        addOption(document.myform.selectschool, "134689", "���ߥH�߰�p", "");
        addOption(document.myform.selectschool, "134690", "���ߤj���p", "");
        addOption(document.myform.selectschool, "134779", "���ߪF����p", "");
        addOption(document.myform.selectschool, "134783", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�s��m') {
        addOption(document.myform.selectschool, "134691", "���߷s���p", "");
        addOption(document.myform.selectschool, "134692", "���ߥP�N��p", "");
        addOption(document.myform.selectschool, "134693", "���߯Q�s��p", "");
        addOption(document.myform.selectschool, "134694", "���ߴ���p", "");
        addOption(document.myform.selectschool, "134695", "�����Q�w��p", "");
        addOption(document.myform.selectschool, "134785", "���ߥ˺���p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�[�y�m') {
        addOption(document.myform.selectschool, "134696", "���߯[�y��p", "");
        addOption(document.myform.selectschool, "134697", "���ߤѫn��p", "");
        addOption(document.myform.selectschool, "134698", "���ߥ��w��p", "");
        addOption(document.myform.selectschool, "134699", "���ߥըF��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�r���m') {
        addOption(document.myform.selectschool, "134700", "���߮r����p", "");
        addOption(document.myform.selectschool, "134701", "���ߴ�F��p", "");
        addOption(document.myform.selectschool, "134702", "���ߤO����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�L��m') {
        addOption(document.myform.selectschool, "134703", "���ߪL���p", "");
        addOption(document.myform.selectschool, "134704", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "134705", "���ߦ˪L��p", "");
        addOption(document.myform.selectschool, "134706", "���߱T�p��p", "");
        addOption(document.myform.selectschool, "134707", "���ߤ��Q��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�n�{�m') {
        addOption(document.myform.selectschool, "134708", "���߫n�{��p", "");
        addOption(document.myform.selectschool, "134709", "���ߦP�w��p", "");
        addOption(document.myform.selectschool, "134710", "���߷˥_��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�ΥV�m') {
        addOption(document.myform.selectschool, "134711", "���ߨΥV��p", "");
        addOption(document.myform.selectschool, "134712", "���߶�l��p", "");
        addOption(document.myform.selectschool, "134713", "���ߪʶ��p", "");
        addOption(document.myform.selectschool, "134714", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "134715", "���ߤj�s��p", "");
        addOption(document.myform.selectschool, "134716", "���ߥɥ���p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '��K��') {
        addOption(document.myform.selectschool, "134717", "���߫�K��p", "");
        addOption(document.myform.selectschool, "134718", "���߹��i��p", "");
        addOption(document.myform.selectschool, "134720", "���ߤs����p", "");
        addOption(document.myform.selectschool, "134721", "���ߤj����p", "");
        addOption(document.myform.selectschool, "134722", "���ߤ��u��p", "");
        addOption(document.myform.selectschool, "134723", "���ߤj����p", "");
        addOption(document.myform.selectschool, "134724", "���߾��B��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "134725", "���ߨ�����p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���{�m') {
        addOption(document.myform.selectschool, "134729", "���ߺ��{��p", "");
        addOption(document.myform.selectschool, "134730", "���ߪ��ְ�p", "");
        addOption(document.myform.selectschool, "134731", "���ߥô��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�D�s�m') {
        addOption(document.myform.selectschool, "134735", "���߷����p", "");
        addOption(document.myform.selectschool, "134736", "���ߥ[�S��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�T�a���m') {
        addOption(document.myform.selectschool, "134737", "���ߤT�a��p", "");
        addOption(document.myform.selectschool, "134740", "���߫C�s��p", "");
        addOption(document.myform.selectschool, "134741", "���߫C����p", "");
        addOption(document.myform.selectschool, "134742", "���ߤf����p", "");
        addOption(document.myform.selectschool, "134784", "�����ɹŰ�p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���a�m') {
        addOption(document.myform.selectschool, "134744", "���ߨθq��p", "");
        addOption(document.myform.selectschool, "134746", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "134787", "���ߪ��a�ʦX��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���O�m') {
        addOption(document.myform.selectschool, "134748", "�������O��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���Z�m') {
        addOption(document.myform.selectschool, "134751", "���ߪZ���p", "");
        addOption(document.myform.selectschool, "134752", "���߮��Z��p", "");
        addOption(document.myform.selectschool, "134753", "���߸U�w��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�Ӹq�m') {
        addOption(document.myform.selectschool, "134754", "���ߨӸq��p", "");
        addOption(document.myform.selectschool, "134755", "���߱�Ű�p", "");
        addOption(document.myform.selectschool, "134756", "���ߤ�ְ�p", "");
        addOption(document.myform.selectschool, "134757", "���߫n�M��p", "");
        addOption(document.myform.selectschool, "134758", "���ߥj�Ӱ�p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�K��m') {
        addOption(document.myform.selectschool, "134759", "���߬K���p", "");
        addOption(document.myform.selectschool, "134760", "���ߤO����p", "");
        addOption(document.myform.selectschool, "134761", "���ߥj�ذ�p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '��l�m') {
        addOption(document.myform.selectschool, "134762", "���߷��L��p", "");
        addOption(document.myform.selectschool, "134763", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "134764", "���ߤ����p", "");
        addOption(document.myform.selectschool, "134765", "���߯�H��p", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�d���m') {
        addOption(document.myform.selectschool, "134766", "���ߥ۪���p", "");
        addOption(document.myform.selectschool, "134768", "���߰��h��p", "");
        addOption(document.myform.selectschool, "134769", "���ߨd����p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�O�F��') {
        addOption(document.myform.selectschool, "140601", "��߻O�F�j�Ǫ��p", "");
        addOption(document.myform.selectschool, "141601", "�p�ߧ��@��(��)�p", "");
        addOption(document.myform.selectschool, "144601", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "144602", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "144603", "���ߥ�����p", "");
        addOption(document.myform.selectschool, "144604", "�����_���p", "");
        addOption(document.myform.selectschool, "144605", "���߷s�Ͱ�p", "");
        addOption(document.myform.selectschool, "144606", "�����ר���p", "");
        addOption(document.myform.selectschool, "144607", "�����׺a��p", "");
        addOption(document.myform.selectschool, "144608", "���߰�����p", "");
        addOption(document.myform.selectschool, "144609", "�����׷���p", "");
        addOption(document.myform.selectschool, "144610", "���߱d�ְ�p", "");
        addOption(document.myform.selectschool, "144611", "�����צ~��p", "");
        addOption(document.myform.selectschool, "144612", "���ߨ��n��p", "");
        addOption(document.myform.selectschool, "144613", "���ߩ��W��p", "");
        addOption(document.myform.selectschool, "144614", "���߫n����p", "");
        addOption(document.myform.selectschool, "144615", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "144616", "���߫ةM��p", "");
        addOption(document.myform.selectschool, "144617", "�����ץа�p", "");
        addOption(document.myform.selectschool, "144618", "���ߴI����p", "");
        addOption(document.myform.selectschool, "144619", "���߷s���p", "");
        addOption(document.myform.selectschool, "144701", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���n�m') {
        addOption(document.myform.selectschool, "144620", "���߻��԰�p", "");
        addOption(document.myform.selectschool, "144621", "���߷Ŭu��p", "");
        addOption(document.myform.selectschool, "144622", "���ߧQ�Ű�p", "");
        addOption(document.myform.selectschool, "144623", "���ߪ����p", "");
        addOption(document.myform.selectschool, "144624", "���ߪF����p", "");
        addOption(document.myform.selectschool, "144625", "���ߴI�s��p", "");
        addOption(document.myform.selectschool, "144627", "���ߤj�n��p", "");
        addOption(document.myform.selectschool, "144628", "���ߤӥ���p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�ӳ¨��m') {
        addOption(document.myform.selectschool, "144629", "���ߤj����p", "");
        addOption(document.myform.selectschool, "144630", "���߭�����p", "");
        addOption(document.myform.selectschool, "144632", "���ߤT�M��p", "");
        addOption(document.myform.selectschool, "144633", "���߬��M��p", "");
        addOption(document.myform.selectschool, "144635", "���ߤj�˰�p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�j�Z�m') {
        addOption(document.myform.selectschool, "144636", "���ߩ|�Z��p", "");
        addOption(document.myform.selectschool, "144637", "���ߤj�Z��p", "");
        addOption(document.myform.selectschool, "144638", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '��q�m') {
        addOption(document.myform.selectschool, "144640", "���ߺ�q��p", "");
        addOption(document.myform.selectschool, "144641", "���ߤ��]��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "144642", "���߳�����p", "");
        addOption(document.myform.selectschool, "144643", "�����s�а�p", "");
        addOption(document.myform.selectschool, "144644", "���ߥæw��p", "");
        addOption(document.myform.selectschool, "144645", "���߷��װ�p", "");
        addOption(document.myform.selectschool, "144646", "���߷緽��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "144647", "�������s��p", "");
        addOption(document.myform.selectschool, "144648", "���ߤ�ܰ�p", "");
        addOption(document.myform.selectschool, "144649", "���߼w����p", "");
        addOption(document.myform.selectschool, "144650", "���߹q����p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���W�m') {
        addOption(document.myform.selectschool, "144651", "���ߺ֭��p", "");
        addOption(document.myform.selectschool, "144652", "���ߤj�Y��p", "");
        addOption(document.myform.selectschool, "144653", "���߸U�w��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�F�e�m') {
        addOption(document.myform.selectschool, "144655", "���ߪF�e��p", "");
        addOption(document.myform.selectschool, "144656", "���߳�����p", "");
        addOption(document.myform.selectschool, "144659", "���߮�����p", "");
        addOption(document.myform.selectschool, "144660", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "144703", "���߿�����p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���\��') {
        addOption(document.myform.selectschool, "144662", "���ߤT����p", "");
        addOption(document.myform.selectschool, "144663", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "144664", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "144665", "���ߤT�P��p", "");
        addOption(document.myform.selectschool, "144666", "���ߩM����p", "");
        addOption(document.myform.selectschool, "144667", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "144668", "���߳շR��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���ضm') {
        addOption(document.myform.selectschool, "144669", "���ߪ��ذ�p", "");
        addOption(document.myform.selectschool, "144671", "���߹�H��p", "");
        addOption(document.myform.selectschool, "144672", "���ߦ˴��p", "");
        addOption(document.myform.selectschool, "144673", "���ߤT����p", "");
        addOption(document.myform.selectschool, "144674", "���߼̭��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���p�m') {
        addOption(document.myform.selectschool, "144676", "���߹�����p", "");
        addOption(document.myform.selectschool, "144677", "���ߤ��F��p", "");
        addOption(document.myform.selectschool, "144678", "���߷s����p", "");
        addOption(document.myform.selectschool, "144679", "���߻��Z��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�F���m') {
        addOption(document.myform.selectschool, "144680", "���ߦw�Ұ�p", "");
        addOption(document.myform.selectschool, "144681", "���ߤg?��p", "");
        addOption(document.myform.selectschool, "144683", "���߻O?��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "144685", "����������p", "");
        addOption(document.myform.selectschool, "144686", "���߷��o��p", "");
        addOption(document.myform.selectschool, "144687", "���ߪF�M��p", "");
        addOption(document.myform.selectschool, "144688", "���߮Ԯq��p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "144689", "���߮緽��p", "");
        addOption(document.myform.selectschool, "144690", "���ߪZ����p", "");
        addOption(document.myform.selectschool, "144692", "�����}�s��p", "");
        addOption(document.myform.selectschool, "144693", "���߬�����p", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���ݶm') {
        addOption(document.myform.selectschool, "144694", "���߮��ݰ�p", "");
        addOption(document.myform.selectschool, "144695", "���ߪ�Ӱ�p", "");
        addOption(document.myform.selectschool, "144696", "���߮r����p", "");
        addOption(document.myform.selectschool, "144697", "���߼s���p", "");
        addOption(document.myform.selectschool, "144698", "�����A�̰�p", "");
        addOption(document.myform.selectschool, "144700", "���ߥ[����p", "");
        addOption(document.myform.selectschool, "144702", "����������p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�Ὤ��') {
        addOption(document.myform.selectschool, "150601", "��ߪF�ؤj�Ǫ��]��p", "");
        addOption(document.myform.selectschool, "151602", "�p�߮��P��p", "");
        addOption(document.myform.selectschool, "154601", "���ߩ�§��p", "");
        addOption(document.myform.selectschool, "154602", "���ߩ��q��p", "");
        addOption(document.myform.selectschool, "154603", "���ߩ��G��p", "");
        addOption(document.myform.selectschool, "154604", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "154605", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "154606", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "154607", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "154608", "���ߤ��ذ�p", "");
        addOption(document.myform.selectschool, "154610", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "154611", "���ߥ_�ذ�p", "");
        addOption(document.myform.selectschool, "154612", "����ű�j��p", "");
        addOption(document.myform.selectschool, "154613", "���߰�ְ�p", "");
        addOption(document.myform.selectschool, "154711", "���ߤ����p", "");
        addOption(document.myform.selectschool, "151312", "�]�Ϊk�H�O�٤j�Ǫ������]��p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�s���m') {
        addOption(document.myform.selectschool, "154614", "���߷s����p", "");
        addOption(document.myform.selectschool, "154615", "���ߥ_�H��p", "");
        addOption(document.myform.selectschool, "154616", "���߱d�ְ�p", "");
        addOption(document.myform.selectschool, "154617", "���߹Ũ���p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�N�w�m') {
        addOption(document.myform.selectschool, "154618", "���ߦN�w��p", "");
        addOption(document.myform.selectschool, "154619", "���ߩy����p", "");
        addOption(document.myform.selectschool, "154620", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "154621", "���߽_����p", "");
        addOption(document.myform.selectschool, "154622", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "154623", "���߫n�ذ�p", "");
        addOption(document.myform.selectschool, "154624", "���ߤƤ���p", "");
        addOption(document.myform.selectschool, "154625", "���ߤө���p", "");
        addOption(document.myform.selectschool, "150F01", "��ߪὬ�Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���׶m') {
        addOption(document.myform.selectschool, "154626", "���߹��װ�p", "");
        addOption(document.myform.selectschool, "154627", "�����פs��p", "");
        addOption(document.myform.selectschool, "154628", "�����׸̰�p", "");
        addOption(document.myform.selectschool, "154629", "���ߧӾǰ�p", "");
        addOption(document.myform.selectschool, "154630", "���ߥ��M��p", "");
        addOption(document.myform.selectschool, "154631", "���߷ˤf��p", "");
        addOption(document.myform.selectschool, "154632", "���ߤ�ܰ�p", "");
        addOption(document.myform.selectschool, "154633", "���ߤ�棰�p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '��L��') {
        addOption(document.myform.selectschool, "154634", "���߻�L��p", "");
        addOption(document.myform.selectschool, "154636", "���ߤj�a��p", "");
        addOption(document.myform.selectschool, "154637", "���߻񤯰�p", "");
        addOption(document.myform.selectschool, "154638", "���ߥ_�L��p", "");
        addOption(document.myform.selectschool, "154640", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "154642", "���ߪL�a��p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���_�m') {
        addOption(document.myform.selectschool, "154643", "���ߥ��_��p", "");
        addOption(document.myform.selectschool, "154644", "���ߤӤ����p", "");
        addOption(document.myform.selectschool, "154648", "���ߤj�i��p", "");
        addOption(document.myform.selectschool, "154707", "���ߦ�I��p", "");
        addOption(document.myform.selectschool, "154708", "���ߤj����p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���J�m') {
        addOption(document.myform.selectschool, "154649", "���߷��J��p", "");
        addOption(document.myform.selectschool, "154650", "���߷�_��p", "");
        addOption(document.myform.selectschool, "154651", "���߷����p", "");
        addOption(document.myform.selectschool, "154652", "�����b����p", "");
        addOption(document.myform.selectschool, "154653", "���߻R�b��p", "");
        addOption(document.myform.selectschool, "154654", "���ߴI����p", "");
        addOption(document.myform.selectschool, "154705", "���ߩ_����p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���ضm') {
        addOption(document.myform.selectschool, "154655", "�������ذ�p", "");
        addOption(document.myform.selectschool, "154656", "���ߴ�f��p", "");
        addOption(document.myform.selectschool, "154657", "�����R����p", "");
        addOption(document.myform.selectschool, "154658", "���߷s����p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�ɨ���') {
        addOption(document.myform.selectschool, "154660", "���ߥɨ���p", "");
        addOption(document.myform.selectschool, "154661", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "154662", "���߷�����p", "");
        addOption(document.myform.selectschool, "154663", "���߼֦X��p", "");
        addOption(document.myform.selectschool, "154664", "�����[����p", "");
        addOption(document.myform.selectschool, "154665", "���߰��d��p", "");
        addOption(document.myform.selectschool, "154666", "���ߪQ����p", "");
        addOption(document.myform.selectschool, "154667", "���߬K���p", "");
        addOption(document.myform.selectschool, "154668", "���߼w�Z��p", "");
        addOption(document.myform.selectschool, "154669", "���ߤT����p", "");
        addOption(document.myform.selectschool, "154670", "���ߤj���p", "");
        addOption(document.myform.selectschool, "154671", "���ߪ��}��p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�I���m') {
        addOption(document.myform.selectschool, "154672", "���ߴI����p", "");
        addOption(document.myform.selectschool, "154674", "���ߪF����p", "");
        addOption(document.myform.selectschool, "154675", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "154676", "���ߧd����p", "");
        addOption(document.myform.selectschool, "154677", "���߾ǥа�p", "");
        addOption(document.myform.selectschool, "154678", "���ߥ��װ�p", "");
        addOption(document.myform.selectschool, "154680", "���ߪF�˰�p", "");
        addOption(document.myform.selectschool, "154679", "���߸U���p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�q�L�m') {
        addOption(document.myform.selectschool, "154681", "���ߨq�L��p", "");
        addOption(document.myform.selectschool, "154682", "���ߴI�@��p", "");
        addOption(document.myform.selectschool, "154683", "���߱R�w��p", "");
        addOption(document.myform.selectschool, "154684", "���ߩM����p", "");
        addOption(document.myform.selectschool, "154685", "���ߴ�����p", "");
        addOption(document.myform.selectschool, "154686", "���ߤT�̰�p", "");
        addOption(document.myform.selectschool, "154687", "���ߨΥ���p", "");
        addOption(document.myform.selectschool, "154688", "���߻ɪ���p", "");
        addOption(document.myform.selectschool, "154689", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "154690", "���߻�����p", "");
        addOption(document.myform.selectschool, "154691", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "154710", "���ߦ��_��p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�U�a�m') {
        addOption(document.myform.selectschool, "154692", "���߸U�a��p", "");
        addOption(document.myform.selectschool, "154693", "���ߩ��Q��p", "");
        addOption(document.myform.selectschool, "154694", "���ߨ�����p", "");
        addOption(document.myform.selectschool, "154695", "���߰�����p", "");
        addOption(document.myform.selectschool, "154696", "���ߦ�L��p", "");
        addOption(document.myform.selectschool, "154697", "���߬�����p", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���˶m') {
        addOption(document.myform.selectschool, "154698", "���ߨ��˰�p", "");
        addOption(document.myform.selectschool, "154699", "���߱[�s��p", "");
        addOption(document.myform.selectschool, "154700", "���ߥߤs��p", "");
        addOption(document.myform.selectschool, "154701", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "154702", "���ߨ��M��p", "");
        addOption(document.myform.selectschool, "154703", "���ߨ��ְ�p", "");
        addOption(document.myform.selectschool, "154704", "���ߥj����p", "");
        addOption(document.myform.selectschool, "154706", "���ߨ�����p", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "164601", "���߰�����p", "");
        addOption(document.myform.selectschool, "164602", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "164603", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "164604", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "164605", "���ߥ۬u��p", "");
        addOption(document.myform.selectschool, "164606", "���ߪF�ð�p", "");
        addOption(document.myform.selectschool, "164607", "���߿�����p", "");
        addOption(document.myform.selectschool, "164608", "���ߤs����p", "");
        addOption(document.myform.selectschool, "164609", "���ߤ��w��p", "");
        addOption(document.myform.selectschool, "164610", "���߮ɸ̰�p", "");
        addOption(document.myform.selectschool, "164611", "���߭��d��p", "");
        addOption(document.myform.selectschool, "164612", "���ߪ꤫��p", "");
        addOption(document.myform.selectschool, "164645", "���ߤ�D��p", "");
        addOption(document.myform.selectschool, "164646", "���ߤ����p", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "164614", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "164615", "���ߦ�˰�p", "");
        addOption(document.myform.selectschool, "164616", "���ߴ���p", "");
        addOption(document.myform.selectschool, "164617", "���ߪG����p", "");
        addOption(document.myform.selectschool, "164618", "�����s����p", "");
        addOption(document.myform.selectschool, "164619", "���߹i����p", "");
        addOption(document.myform.selectschool, "164620", "���ߨF���p", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�ըF�m') {
        addOption(document.myform.selectschool, "164621", "���ߤ��ٰ�p", "");
        addOption(document.myform.selectschool, "164623", "����������p", "");
        addOption(document.myform.selectschool, "164624", "���ߴ�l��p", "");
        addOption(document.myform.selectschool, "164625", "���ߨ��r��p", "");
        addOption(document.myform.selectschool, "164627", "���߳�����p", "");
        addOption(document.myform.selectschool, "164628", "���ߦN����p", "");
        addOption(document.myform.selectschool, "164629", "���߫�d��p", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "164630", "���ߦX���p", "");
        addOption(document.myform.selectschool, "164631", "���ߦ��W��p", "");
        addOption(document.myform.selectschool, "164633", "���ߤj����p", "");
        addOption(document.myform.selectschool, "164634", "���ߦ��F��p", "");
        addOption(document.myform.selectschool, "164635", "���ߨ�����p", "");
        addOption(document.myform.selectschool, "164636", "���ߤ��P��p", "");
        addOption(document.myform.selectschool, "164637", "���ߥ~�P��p", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '��w�m') {
        addOption(document.myform.selectschool, "164638", "���߱�w��p", "");
        addOption(document.myform.selectschool, "164639", "���߱N�x��p", "");
        addOption(document.myform.selectschool, "164641", "���ߪ�����p", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�C���m') {
        addOption(document.myform.selectschool, "164643", "���ߤC����p", "");
        addOption(document.myform.selectschool, "164644", "���������p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�H�q��') {
        addOption(document.myform.selectschool, "173606", "���ߪF�H��p", "");
        addOption(document.myform.selectschool, "173607", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "173608", "���߲`�D��p", "");
        addOption(document.myform.selectschool, "173609", "���ߤ�ܰ�p", "");
        addOption(document.myform.selectschool, "173610", "���ߪF����p", "");
        addOption(document.myform.selectschool, "173641", "���߲`����p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "171601", "�p�߸t�ߤp��", "");
        addOption(document.myform.selectschool, "173619", "���ߤ��M��p", "");
        addOption(document.myform.selectschool, "173620", "���ߥP�}��p", "");
        addOption(document.myform.selectschool, "173621", "���ߤ��s��p", "");
        addOption(document.myform.selectschool, "173622", "���ߴ���p", "");
        addOption(document.myform.selectschool, "173623", "���ߤ��ذ�p", "");
        addOption(document.myform.selectschool, "173624", "���ߤӥ���p", "");
        addOption(document.myform.selectschool, "173625", "���߼w�M��p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "173601", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "173602", "���ߥ��ذ�p", "");
        addOption(document.myform.selectschool, "173603", "���ߩ�����p", "");
        addOption(document.myform.selectschool, "173604", "���ߩM����p", "");
        addOption(document.myform.selectschool, "173605", "���ߤK���p", "");
        addOption(document.myform.selectschool, "171306", "�p�ߤG�H�������]��p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '���R��') {
        addOption(document.myform.selectschool, "173611", "���ߤ��R��p", "");
        addOption(document.myform.selectschool, "173612", "���߫H�q��p", "");
        addOption(document.myform.selectschool, "173613", "���ߦ��\��p", "");
        addOption(document.myform.selectschool, "173614", "���߫n�a��p", "");
        addOption(document.myform.selectschool, "173615", "���ߩ|����p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�w�ְ�') {
        addOption(document.myform.selectschool, "173616", "���ߦw�ְ�p", "");
        addOption(document.myform.selectschool, "173617", "���ߦ�w��p", "");
        addOption(document.myform.selectschool, "173618", "���ߪZ�[��p", "");
        addOption(document.myform.selectschool, "173633", "���߫ؼw��p", "");
        addOption(document.myform.selectschool, "173638", "���߶��t��p", "");
        addOption(document.myform.selectschool, "173640", "���ߪ��ְ�p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�C����') {
        addOption(document.myform.selectschool, "173626", "���ߤC����p", "");
        addOption(document.myform.selectschool, "173627", "���ߵؿ���p", "");
        addOption(document.myform.selectschool, "173628", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "173629", "���߰��n��p", "");
        addOption(document.myform.selectschool, "173630", "���ߺ�����p", "");
        addOption(document.myform.selectschool, "173631", "���ߴ_����p", "");
        addOption(document.myform.selectschool, "173632", "���ߩ|����p", "");
        addOption(document.myform.selectschool, "173639", "���ߪ�����p", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�x�x��') {
        addOption(document.myform.selectschool, "173634", "���ߤK����p", "");
        addOption(document.myform.selectschool, "173635", "���߷x�x��p", "");
        addOption(document.myform.selectschool, "173636", "���߷x����p", "");
        addOption(document.myform.selectschool, "173637", "�����䤺��p", "");
        addOption(document.myform.selectschool, "173642", "���߷x���p", "");
    }
    if (document.myform.selectcity.value == '�s�˥�' && document.myform.selectdistrict.value == '�_��') {
        addOption(document.myform.selectschool, "180601", "��߷s�˱Фj���p", "");
        addOption(document.myform.selectschool, "183602", "���ߥ_����p", "");
        addOption(document.myform.selectschool, "183603", "���ߥ��I��p", "");
        addOption(document.myform.selectschool, "183605", "���ߦ����p", "");
        addOption(document.myform.selectschool, "183611", "���߸�����p", "");
        addOption(document.myform.selectschool, "183612", "���߫n�d��p", "");
        addOption(document.myform.selectschool, "183626", "�����ª���p", "");
    }
    if (document.myform.selectcity.value == '�s�˥�' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "181601", "�p���ƥ���p", "");
        addOption(document.myform.selectschool, "181602", "�p�ߪ�����(��)�p", "");
        addOption(document.myform.selectschool, "183601", "���߷s�˰�p", "");
        addOption(document.myform.selectschool, "183604", "���ߪF����p", "");
        addOption(document.myform.selectschool, "183606", "���ߦ˽���p", "");
        addOption(document.myform.selectschool, "183607", "���ߪF���p", "");
        addOption(document.myform.selectschool, "183608", "���ߤT����p", "");
        addOption(document.myform.selectschool, "183609", "�����s�s��p", "");
        addOption(document.myform.selectschool, "183610", "�������F��p", "");
        addOption(document.myform.selectschool, "183613", "���߫إ\��p", "");
        addOption(document.myform.selectschool, "183614", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "183627", "���߶�����p", "");
        addOption(document.myform.selectschool, "183628", "���߬���p", "");
        addOption(document.myform.selectschool, "183629", "���߰��p��p", "");
        addOption(document.myform.selectschool, "183630", "���߫C����p", "");
        addOption(document.myform.selectschool, "180301", "��߬�Ǥu�~��Ϲ��簪�����]��p", "");
    }
    if (document.myform.selectcity.value == '�s�˥�' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "183615", "���߭��s��p", "");
        addOption(document.myform.selectschool, "183616", "���ߪ�L��p", "");
        addOption(document.myform.selectschool, "183617", "���ߴ�n��p", "");
        addOption(document.myform.selectschool, "183618", "���ߤj�ܰ�p", "");
        addOption(document.myform.selectschool, "183619", "���߭XФ��p", "");
        addOption(document.myform.selectschool, "183620", "���ߴ¤s��p", "");
        addOption(document.myform.selectschool, "183621", "���ߤj���p", "");
        addOption(document.myform.selectschool, "183622", "���ߤ����p", "");
        addOption(document.myform.selectschool, "183623", "���߫n�i��p", "");
        addOption(document.myform.selectschool, "183625", "���߳��H��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "200601", "��߹Ÿq�j�Ǫ��p", "");
        addOption(document.myform.selectschool, "203601", "���߱R���p", "");
        addOption(document.myform.selectschool, "203604", "���ߥ��ڰ�p", "");
        addOption(document.myform.selectschool, "203605", "���߫ūH��p", "");
        addOption(document.myform.selectschool, "203608", "���߹ť_��p", "");
        addOption(document.myform.selectschool, "203610", "���ߪL�˰�p", "");
        addOption(document.myform.selectschool, "203612", "���ߺ멾��p", "");
        addOption(document.myform.selectschool, "203614", "���������p", "");
        addOption(document.myform.selectschool, "203615", "���߿��w��p", "");
        addOption(document.myform.selectschool, "203619", "���ߤ嶮��p", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���') {
        addOption(document.myform.selectschool, "203602", "���߳շR��p", "");
        addOption(document.myform.selectschool, "203603", "���߫�����p", "");
        addOption(document.myform.selectschool, "203606", "���ߤj�P��p", "");
        addOption(document.myform.selectschool, "203607", "���ߧӯ��p", "");
        addOption(document.myform.selectschool, "203609", "���߹�����p", "");
        addOption(document.myform.selectschool, "203611", "���ߥ_���p", "");
        addOption(document.myform.selectschool, "203613", "���ߨ|�H��p", "");
        addOption(document.myform.selectschool, "203616", "���ߥ@���p", "");
        addOption(document.myform.selectschool, "203617", "���߿��Ű�p", "");
        addOption(document.myform.selectschool, "203618", "���ߴ�W��p", "");
        addOption(document.myform.selectschool, "200F01", "��߹Ÿq�Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "714601", "���ߪ����p", "");
        addOption(document.myform.selectschool, "714606", "���߶}ޱ��p", "");
        addOption(document.myform.selectschool, "714607", "���߬f����p", "");
        addOption(document.myform.selectschool, "714619", "���ߥ��q��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "714602", "���ߪ����(��)�p", "");
        addOption(document.myform.selectschool, "714613", "���ߥj���p", "");
        addOption(document.myform.selectschool, "714614", "���ߪ�����p", "");
        addOption(document.myform.selectschool, "714618", "���ߴ�H��p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "714603", "���ߤ�����p", "");
        addOption(document.myform.selectschool, "714604", "���߽�g��p", "");
        addOption(document.myform.selectschool, "714605", "���ߥj����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���F��') {
        addOption(document.myform.selectschool, "714608", "���ߦh�~��p", "");
        addOption(document.myform.selectschool, "714609", "���ߪ��F��p", "");
        addOption(document.myform.selectschool, "714610", "���ߦ����p", "");
        addOption(document.myform.selectschool, "714611", "���ߦw�i��p", "");
        addOption(document.myform.selectschool, "714612", "���߭z����p", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�P���m') {
        addOption(document.myform.selectschool, "714615", "���ߨ�����p", "");
        addOption(document.myform.selectschool, "714616", "���ߤW����p", "");
        addOption(document.myform.selectschool, "714620", "���ߦ�f��p", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�n��m') {
        addOption(document.myform.selectschool, "724601", "���ߤ��ذ�(��)�p", "");
        addOption(document.myform.selectschool, "724602", "���ߤ�����(��)�p", "");
        addOption(document.myform.selectschool, "724603", "���ߤ��R��p", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�_��m') {
        addOption(document.myform.selectschool, "724604", "���߶����p", "");
        addOption(document.myform.selectschool, "724605", "����?����p", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "724606", "���߷q���(��)�p", "");
        addOption(document.myform.selectschool, "724607", "���ߪF����p", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�F�޶m') {
        addOption(document.myform.selectschool, "724608", "���ߪF�ް�(��)�p", "");
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
