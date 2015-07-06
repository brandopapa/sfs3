
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
    // this function is used to fill the category list on load
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
        addOption(document.myform.selectdistrict, "�_��", "�_��", "");
        addOption(document.myform.selectdistrict, "�F��", "�F��", "");
        addOption(document.myform.selectdistrict, "�n��", "�n��", "");
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
// ON selection of category this function will work

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
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�g����') {
        addOption(document.myform.selectschool, "011503", "�p�߸μw�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "014524", "���ߤg���ꤤ", "");
        addOption(document.myform.selectschool, "014555", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "014356", "���߲M���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�O����') {
        addOption(document.myform.selectschool, "014501", "���ߪO���ꤤ", "");
        addOption(document.myform.selectschool, "014503", "���߭��y�ꤤ", "");
        addOption(document.myform.selectschool, "014504", "���ߦ��A�ꤤ", "");
        addOption(document.myform.selectschool, "014505", "���ߤ��s�ꤤ", "");
        addOption(document.myform.selectschool, "014506", "���߷s�H�ꤤ", "");
        addOption(document.myform.selectschool, "014552", "���߷˱X�ꤤ", "");
        addOption(document.myform.selectschool, "014573", "���ߤj�[�ꤤ", "");
        addOption(document.myform.selectschool, "014575", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "010301", "��ߵع����Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "011323", "�p�ߥ����������]�ꤤ", "");
        addOption(document.myform.selectschool, "014302", "���߮��s�������]�ꤤ", "");
        addOption(document.myform.selectschool, "014363", "���ߥ��_�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "014507", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "014508", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "014509", "���ߺ���ꤤ", "");
        addOption(document.myform.selectschool, "014510", "�����Y�e�ꤤ", "");
        addOption(document.myform.selectschool, "014559", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "011310", "�]�Ϊk�H��ݰ������]�ꤤ", "");
        addOption(document.myform.selectschool, "014353", "���ߤ��񰪤����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�T����') {
        addOption(document.myform.selectschool, "014512", "���ߥ��a�ꤤ", "");
        addOption(document.myform.selectschool, "014513", "���ߩ��Ӱꤤ", "");
        addOption(document.myform.selectschool, "014514", "���ߺѵذꤤ", "");
        addOption(document.myform.selectschool, "014561", "���ߤT�M�ꤤ", "");
        addOption(document.myform.selectschool, "014572", "���ߤG���ꤤ", "");
        addOption(document.myform.selectschool, "011306", "�p�ߪ����k�����]�ꤤ", "");
        addOption(document.myform.selectschool, "011316", "�p�߮�P�������]�ꤤ", "");
        addOption(document.myform.selectschool, "014311", "���ߤT���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�éM��') {
        addOption(document.myform.selectschool, "014516", "���ߥéM�ꤤ", "");
        addOption(document.myform.selectschool, "014517", "���ߺ֩M�ꤤ", "");
        addOption(document.myform.selectschool, "014315", "���ߥå��������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���M��') {
        addOption(document.myform.selectschool, "014518", "���ߤ��M�ꤤ", "");
        addOption(document.myform.selectschool, "014519", "���߿n�J�ꤤ", "");
        addOption(document.myform.selectschool, "014520", "���ߺs�M�ꤤ", "");
        addOption(document.myform.selectschool, "014554", "���ߦ۱j�ꤤ", "");
        addOption(document.myform.selectschool, "011309", "�]�Ϊk�H�n�s�������]�ꤤ", "");
        addOption(document.myform.selectschool, "011324", "�p�ߦ˪L�������]�ꤤ", "");
        addOption(document.myform.selectschool, "014362", "�����A�M�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�a�q��') {
        addOption(document.myform.selectschool, "014521", "�����a�q�ꤤ", "");
        addOption(document.myform.selectschool, "014560", "���߻��ꤤ", "");
        addOption(document.myform.selectschool, "014565", "���ߦy�s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '��L��') {
        addOption(document.myform.selectschool, "014523", "���߬a��ꤤ", "");
        addOption(document.myform.selectschool, "014569", "���ߨ|�L�ꤤ", "");
        addOption(document.myform.selectschool, "014574", "���ߤT�h�ꤤ", "");
        addOption(document.myform.selectschool, "014577", "���߮�l�}�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "014322", "���߾�L�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�T�l��') {
        addOption(document.myform.selectschool, "014525", "���ߤT�l�ꤤ", "");
        addOption(document.myform.selectschool, "014567", "���ߦw�˰ꤤ", "");
        addOption(document.myform.selectschool, "011329", "�]�Ϊk�H��װ������]�ꤤ", "");
        addOption(document.myform.selectschool, "014326", "���ߩ��w�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�K����') {
        addOption(document.myform.selectschool, "014527", "���ߤK���ꤤ", "");
        addOption(document.myform.selectschool, "011311", "�p�߸t�ߤk�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "014528", "���߮��s�ꤤ", "");
        addOption(document.myform.selectschool, "014558", "���߸q�ǰꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���Ѱ�') {
        addOption(document.myform.selectschool, "014529", "���ߤ��Ѱꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == 'Ī�w��') {
        addOption(document.myform.selectschool, "014530", "����Ī�w�ꤤ", "");
        addOption(document.myform.selectschool, "014576", "�����O���ꤤ", "");
        addOption(document.myform.selectschool, "011318", "�p�߮}�װ������]�ꤤ", "");
        addOption(document.myform.selectschool, "014357", "���ߤT���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�L�f��') {
        addOption(document.myform.selectschool, "014531", "���ߪL�f�ꤤ", "");
        addOption(document.myform.selectschool, "014571", "���߱R�L�ꤤ", "");
        addOption(document.myform.selectschool, "014579", "���ߨΪL�ꤤ", "");
        addOption(document.myform.selectschool, "011317", "�p�߿��^�������]�ꤤ", "");
        addOption(document.myform.selectschool, "010F01", "��ߪL�f�Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "014533", "���ߦ���ꤤ", "");
        addOption(document.myform.selectschool, "014568", "���߼̾�ꤤ", "");
        addOption(document.myform.selectschool, "014570", "���߫C�s�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "011312", "�p�߱R�q�������]�ꤤ", "");
        addOption(document.myform.selectschool, "014332", "���ߨq�p�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�H����') {
        addOption(document.myform.selectschool, "014534", "���߲H���ꤤ", "");
        addOption(document.myform.selectschool, "014566", "���ߥ��w�ꤤ", "");
        addOption(document.myform.selectschool, "011301", "�p�߲H���������]�ꤤ", "");
        addOption(document.myform.selectschool, "014364", "���ߦ˳򰪤����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�T�۰�') {
        addOption(document.myform.selectschool, "014536", "���ߤT�۰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�۪���') {
        addOption(document.myform.selectschool, "014537", "���ߥ۪��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�U����') {
        addOption(document.myform.selectschool, "014539", "���߸U���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�W�L��') {
        addOption(document.myform.selectschool, "014540", "���ߩW�L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "014541", "���ߤ�s�ꤤ", "");
        addOption(document.myform.selectschool, "014542", "���ߤ��p�ꤤ", "");
        addOption(document.myform.selectschool, "014580", "���߹F�[�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "011302", "�]�Ϊk�H�d�����簪�����]�ꤤ", "");
        addOption(document.myform.selectschool, "011322", "�]�Ϊk�H�R���k�����]�ꤤ", "");
        addOption(document.myform.selectschool, "011325", "�p�ߤΤH�������]�ꤤ", "");
        addOption(document.myform.selectschool, "014343", "���ߦw�d�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '��ڰ�') {
        addOption(document.myform.selectschool, "014544", "���߷�ڰꤤ", "");
        addOption(document.myform.selectschool, "014545", "���ߴܽ�ꤤ", "");
        addOption(document.myform.selectschool, "011399", "�p�߮ɫB�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�^�d��') {
        addOption(document.myform.selectschool, "014546", "���߰^�d�ꤤ", "");
        addOption(document.myform.selectschool, "014578", "�����ׯ]�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�`�|��') {
        addOption(document.myform.selectschool, "014549", "���߲`�|�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "014550", "���ߥ��˰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�Q�Ӱ�') {
        addOption(document.myform.selectschool, "014551", "���߯Q�Ӱꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "014338", "���ߪ��s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "014347", "�������˰������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�_��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "014348", "���ߥ��䰪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�Q�s��') {
        addOption(document.myform.selectschool, "313501", "���ߤ��ذꤤ", "");
        addOption(document.myform.selectschool, "313502", "���ߥ��Ͱꤤ", "");
        addOption(document.myform.selectschool, "313504", "���ߤ��s�ꤤ", "");
        addOption(document.myform.selectschool, "313505", "���ߴ��ưꤤ", "");
        addOption(document.myform.selectschool, "313301", "���ߦ�Q�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�H�q��') {
        addOption(document.myform.selectschool, "323502", "���߿����ꤤ", "");
        addOption(document.myform.selectschool, "323503", "���ߥæN�ꤤ", "");
        addOption(document.myform.selectschool, "323504", "����?���ꤤ", "");
        addOption(document.myform.selectschool, "323505", "���߫H�q�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�j�w��') {
        addOption(document.myform.selectschool, "331502", "�p�ߥߤH�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "333501", "���ߤ��R�ꤤ", "");
        addOption(document.myform.selectschool, "333502", "���ߤj�w�ꤤ", "");
        addOption(document.myform.selectschool, "333504", "���ߪکM�ꤤ", "");
        addOption(document.myform.selectschool, "333505", "���ߪ��ذꤤ", "");
        addOption(document.myform.selectschool, "333506", "�����h�Ͱꤤ", "");
        addOption(document.myform.selectschool, "333507", "���ߥ��ڰꤤ", "");
        addOption(document.myform.selectschool, "333508", "�����s���ꤤ", "");
        addOption(document.myform.selectschool, "330301", "��߮v�j�������]�ꤤ", "");
        addOption(document.myform.selectschool, "331301", "�p�ߩ������Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "331304", "�p�ߴ_�����簪�����]�ꤤ", "");
        addOption(document.myform.selectschool, "333301", "���ߩM���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "343502", "���ߪ��w�ꤤ", "");
        addOption(document.myform.selectschool, "343504", "���ߥ_�w�ꤤ", "");
        addOption(document.myform.selectschool, "343505", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "343506", "���ߤ��`�ꤤ", "");
        addOption(document.myform.selectschool, "343507", "�����ئ��ꤤ", "");
        addOption(document.myform.selectschool, "343302", "���ߤj�P�������]�ꤤ", "");
        addOption(document.myform.selectschool, "343303", "���ߤj���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "353501", "���߿þ��ꤤ", "");
        addOption(document.myform.selectschool, "353502", "���ߥj�F�ꤤ", "");
        addOption(document.myform.selectschool, "353503", "���߫n���ꤤ", "");
        addOption(document.myform.selectschool, "353504", "���ߥ��D�ꤤ", "");
        addOption(document.myform.selectschool, "353505", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "351301", "�p�߱j�����Ǫ��]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�j�P��') {
        addOption(document.myform.selectschool, "363501", "���߫ئ��ꤤ", "");
        addOption(document.myform.selectschool, "363502", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "363504", "���ߥ��v�ꤤ", "");
        addOption(document.myform.selectschool, "363506", "�������{�ꤤ", "");
        addOption(document.myform.selectschool, "363507", "���߭��y�ꤤ", "");
        addOption(document.myform.selectschool, "361301", "�p���R�פk�����]�ꤤ", "");
        addOption(document.myform.selectschool, "363302", "���ߦ��W�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�U�ذ�') {
        addOption(document.myform.selectschool, "373501", "���߸U�ذꤤ", "");
        addOption(document.myform.selectschool, "373503", "��������ꤤ", "");
        addOption(document.myform.selectschool, "373505", "�����s�s�ꤤ", "");
        addOption(document.myform.selectschool, "371301", "�p�ߥߤH�������]�ꤤ", "");
        addOption(document.myform.selectschool, "373302", "���ߤj�z�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '��s��') {
        addOption(document.myform.selectschool, "381501", "�p���R�߰ꤤ", "");
        addOption(document.myform.selectschool, "383501", "���ߤ�]�ꤤ", "");
        addOption(document.myform.selectschool, "383502", "���߹��ꤤ", "");
        addOption(document.myform.selectschool, "383503", "���ߥ_�F�ꤤ", "");
        addOption(document.myform.selectschool, "383504", "���ߴ����ꤤ", "");
        addOption(document.myform.selectschool, "383505", "���߿��ְꤤ", "");
        addOption(document.myform.selectschool, "383507", "���ߴ����ꤤ", "");
        addOption(document.myform.selectschool, "380301", "��߬F�j�������]�ꤤ", "");
        addOption(document.myform.selectschool, "381301", "�p�ߪF�s�������]�ꤤ", "");
        addOption(document.myform.selectschool, "381304", "�p�ߦA�����Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "381305", "�p�ߴ��尪�����]�ꤤ", "");
        addOption(document.myform.selectschool, "383302", "���߸U�ڰ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�n���') {
        addOption(document.myform.selectschool, "393501", "���߸ۥ��ꤤ", "");
        addOption(document.myform.selectschool, "393503", "���ߦ��w�ꤤ", "");
        addOption(document.myform.selectschool, "393301", "���߫n�䰪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "403501", "���ߤ���ꤤ", "");
        addOption(document.myform.selectschool, "403502", "�����R�s�ꤤ", "");
        addOption(document.myform.selectschool, "403503", "���ߤT���ꤤ", "");
        addOption(document.myform.selectschool, "403504", "���ߦ��ꤤ", "");
        addOption(document.myform.selectschool, "403505", "���ߪF��ꤤ", "");
        addOption(document.myform.selectschool, "403506", "���ߩ���ꤤ", "");
        addOption(document.myform.selectschool, "401302", "�p�ߤ��٤��Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "401303", "�p�߹F�H�k�����]�ꤤ", "");
        addOption(document.myform.selectschool, "400144", "��ߥx�W�����ǰ|", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�h�L��') {
        addOption(document.myform.selectschool, "413501", "���ߤh�L�ꤤ", "");
        addOption(document.myform.selectschool, "413502", "���������ꤤ", "");
        addOption(document.myform.selectschool, "413504", "���ߦܵ��ꤤ", "");
        addOption(document.myform.selectschool, "413505", "���߮�P�ꤤ", "");
        addOption(document.myform.selectschool, "413506", "���ߺ֦w�ꤤ", "");
        addOption(document.myform.selectschool, "413508", "���ߤѥ��ꤤ", "");
        addOption(document.myform.selectschool, "411302", "�p�߽òz�k�����]�ꤤ", "");
        addOption(document.myform.selectschool, "411303", "�p�ߵؿ����Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "413301", "���߶����������]�ꤤ", "");
        addOption(document.myform.selectschool, "413302", "���ߦ��ְ������]�ꤤ", "");
        addOption(document.myform.selectschool, "413F01", "���߱Ҵ��Ǯ�", "");
        addOption(document.myform.selectschool, "413F02", "���߱ҩ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '�_���') {
        addOption(document.myform.selectschool, "421501", "�p�߫��s�ꤤ", "");
        addOption(document.myform.selectschool, "423501", "���ߥ_��ꤤ", "");
        addOption(document.myform.selectschool, "423502", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "423503", "���ߩ��w�ꤤ", "");
        addOption(document.myform.selectschool, "423504", "���߮緽�ꤤ", "");
        addOption(document.myform.selectschool, "423505", "���ߥ۵P�ꤤ", "");
        addOption(document.myform.selectschool, "423506", "��������ꤤ", "");
        addOption(document.myform.selectschool, "421301", "�p�����հ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�_��' && document.myform.selectdistrict.value == '') {
        addOption(document.myform.selectschool, "313302", "���ߤ��[�������]�ꤤ", "");
        addOption(document.myform.selectschool, "400144", "��߻O�W�����ǰ|���]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j�w��') {
        addOption(document.myform.selectschool, "064512", "���ߤj�w�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�׭��') {
        addOption(document.myform.selectschool, "064501", "�����׭�ꤤ", "");
        addOption(document.myform.selectschool, "064502", "�����תF�ꤤ", "");
        addOption(document.myform.selectschool, "064503", "�����׫n�ꤤ", "");
        addOption(document.myform.selectschool, "064545", "�����׶��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '��l��') {
        addOption(document.myform.selectschool, "064504", "���߼�l�ꤤ", "");
        addOption(document.myform.selectschool, "064538", "���߼�q�ꤤ", "");
        addOption(document.myform.selectschool, "061301", "�]�Ϊk�H�`�K�ð������]�ꤤ", "");
        addOption(document.myform.selectschool, "061317", "�p�ߥ��尪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "064505", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "064541", "���ߤj�ذꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "064506", "���߯����ꤤ", "");
        addOption(document.myform.selectschool, "064551", "���߯��`�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�Z����') {
        addOption(document.myform.selectschool, "064507", "���ߦZ���ꤤ", "");
        addOption(document.myform.selectschool, "064308", "���ߦZ������]�ꤤ", "");
        addOption(document.myform.selectschool, "060F01", "��߻O���ҩ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�~�H��') {
        addOption(document.myform.selectschool, "064509", "���ߥ~�H�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j�Ұ�') {
        addOption(document.myform.selectschool, "064510", "���ߤj�Ұꤤ", "");
        addOption(document.myform.selectschool, "064511", "���ߤ�n�ꤤ", "");
        addOption(document.myform.selectschool, "064539", "���߶��Ѱꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�M����') {
        addOption(document.myform.selectschool, "064513", "���߲M���ꤤ", "");
        addOption(document.myform.selectschool, "064514", "���߲M�u�ꤤ", "");
        addOption(document.myform.selectschool, "064540", "���߲M���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�F����') {
        addOption(document.myform.selectschool, "064515", "���ߨF���ꤤ", "");
        addOption(document.myform.selectschool, "064534", "���ߥ_�հꤤ", "");
        addOption(document.myform.selectschool, "064535", "���߳��d�ꤤ", "");
        addOption(document.myform.selectschool, "064549", "���ߤ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '��ϰ�') {
        addOption(document.myform.selectschool, "064516", "���߱�ϰꤤ", "");
        addOption(document.myform.selectschool, "064342", "���ߤ��䰪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "064517", "�����s���ꤤ", "");
        addOption(document.myform.selectschool, "064518", "���ߥ|�e�ꤤ", "");
        addOption(document.myform.selectschool, "064550", "�����s�z�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j�{��') {
        addOption(document.myform.selectschool, "064519", "���ߤj�D�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�Q���') {
        addOption(document.myform.selectschool, "064520", "���߯Q��ꤤ", "");
        addOption(document.myform.selectschool, "064521", "���߷˫n�ꤤ", "");
        addOption(document.myform.selectschool, "064546", "���ߥ��w�ꤤ", "");
        addOption(document.myform.selectschool, "061313", "�p�ߩ��D�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '���p��') {
        addOption(document.myform.selectschool, "064522", "�������p�ꤤ", "");
        addOption(document.myform.selectschool, "064523", "���ߥ��_�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�ӥ���') {
        addOption(document.myform.selectschool, "064525", "���ߤӥ��ꤤ", "");
        addOption(document.myform.selectschool, "064526", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "064543", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "061315", "�p�ߵز��y�������]�ꤤ", "");
        addOption(document.myform.selectschool, "064336", "���ߪ����������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�۩���') {
        addOption(document.myform.selectschool, "064527", "���ߥ۩��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�F�հ�') {
        addOption(document.myform.selectschool, "064529", "���ߪF�հꤤ", "");
        addOption(document.myform.selectschool, "064530", "���ߪF�ذꤤ", "");
        addOption(document.myform.selectschool, "064531", "���ߪF�s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "064532", "���ߦ��\�ꤤ", "");
        addOption(document.myform.selectschool, "064537", "���ߥ��a�ꤤ", "");
        addOption(document.myform.selectschool, "064544", "���ߥ����ꤤ", "");
        addOption(document.myform.selectschool, "064547", "���ߥ߷s�ꤤ", "");
        addOption(document.myform.selectschool, "064548", "���߲n��ꤤ", "");
        addOption(document.myform.selectschool, "061310", "�p�ߤj���������]�ꤤ", "");
        addOption(document.myform.selectschool, "061314", "�p�߹����������]�ꤤ", "");
        addOption(document.myform.selectschool, "061318", "�p�ߥߤH�������]�ꤤ", "");
        addOption(document.myform.selectschool, "064324", "���ߤj���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�M����') {
        addOption(document.myform.selectschool, "064533", "���ߩM���ꤤ", "");
        addOption(document.myform.selectschool, "064552", "���߱��s�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '��ٰ�') {
        addOption(document.myform.selectschool, "191503", "�p���R�A�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "193516", "���ߤ��s�ꤤ", "");
        addOption(document.myform.selectschool, "193519", "���ߺ~�f�ꤤ", "");
        addOption(document.myform.selectschool, "193520", "���ߦw�M�ꤤ", "");
        addOption(document.myform.selectschool, "193521", "���ߦܵ��ꤤ", "");
        addOption(document.myform.selectschool, "193526", "���ߺ֬�ꤤ", "");
        addOption(document.myform.selectschool, "191301", "�p�ߪF�j�������]�ꤤ", "");
        addOption(document.myform.selectschool, "191302", "�p��߻�氪�����]�ꤤ", "");
        addOption(document.myform.selectschool, "193313", "���ߦ�b�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '���') {
        addOption(document.myform.selectschool, "193501", "���ߩ~���ꤤ", "");
        addOption(document.myform.selectschool, "193509", "���ߥ����ꤤ", "");
        addOption(document.myform.selectschool, "193510", "���ߦV�W�ꤤ", "");
        addOption(document.myform.selectschool, "193303", "���ߩ����������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�_��') {
        addOption(document.myform.selectschool, "193502", "�������Q�ꤤ", "");
        addOption(document.myform.selectschool, "193514", "���ߤ��v�ꤤ", "");
        addOption(document.myform.selectschool, "193518", "���ߥߤH�ꤤ", "");
        addOption(document.myform.selectschool, "191305", "�p�߷s���������]�ꤤ", "");
        addOption(document.myform.selectschool, "191313", "�p�߾���k�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�n��') {
        addOption(document.myform.selectschool, "193504", "���߱R�۰ꤤ", "");
        addOption(document.myform.selectschool, "193512", "���ߥ|�|�ꤤ", "");
        addOption(document.myform.selectschool, "191308", "�p�ߩy�簪�����]�ꤤ", "");
        addOption(document.myform.selectschool, "191309", "�p�ߩ��w�k�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�_�ٰ�') {
        addOption(document.myform.selectschool, "193505", "���ߤj�w�ꤤ", "");
        addOption(document.myform.selectschool, "193506", "���ߥ_�s�ꤤ", "");
        addOption(document.myform.selectschool, "193517", "���߱R�w�ꤤ", "");
        addOption(document.myform.selectschool, "193524", "���ߤT���ꤤ", "");
        addOption(document.myform.selectschool, "193525", "���ߥ|�i�p�ꤤ", "");
        addOption(document.myform.selectschool, "191311", "�p�߽ùD�������]�ꤤ", "");
        addOption(document.myform.selectschool, "193315", "���ߪF�s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "193507", "���ߪF�p�ꤤ", "");
        addOption(document.myform.selectschool, "193511", "���ߨ|�^�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�n�ٰ�') {
        addOption(document.myform.selectschool, "193508", "���߾����ꤤ", "");
        addOption(document.myform.selectschool, "193522", "���߸U�M�ꤤ", "");
        addOption(document.myform.selectschool, "193523", "���ߤj�~�ꤤ", "");
        addOption(document.myform.selectschool, "193527", "���ߤj�[�ꤤ", "");
        addOption(document.myform.selectschool, "191314", "�p�����F�������]�ꤤ", "");
        addOption(document.myform.selectschool, "193316", "���ߴf�尪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O����' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "064328", "���߷s���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�_��') {
        addOption(document.myform.selectschool, "213506", "���ߥ��w�ꤤ", "");
        addOption(document.myform.selectschool, "213507", "���ߦ��\�ꤤ", "");
        addOption(document.myform.selectschool, "213508", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "213517", "���ߤ��ꤤ", "");
        addOption(document.myform.selectschool, "211304", "�]�Ϊk�H�t�\�k�����]�ꤤ", "");
        addOption(document.myform.selectschool, "211317", "�p�߱X�s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�n��') {
        addOption(document.myform.selectschool, "213504", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "213515", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "213303", "���߫n�簪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "213501", "���߫�Ұꤤ", "");
        addOption(document.myform.selectschool, "213502", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "213514", "���ߴ_���ꤤ", "");
        addOption(document.myform.selectschool, "213518", "���߱R���ꤤ", "");
        addOption(document.myform.selectschool, "211301", "�p�ߪ��a�������]�ꤤ", "");
        addOption(document.myform.selectschool, "211310", "�p�ߥ��ؤk�����]�ꤤ", "");
        addOption(document.myform.selectschool, "211318", "�p�߼w���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���w��') {
        addOption(document.myform.selectschool, "111501", "�p�߫����ꤤ", "");
        addOption(document.myform.selectschool, "114501", "���ߤ��w�ꤤ", "");
        addOption(document.myform.selectschool, "114502", "���ߤ��w���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�C�Ѱ�') {
        addOption(document.myform.selectschool, "111502", "�p�߬L���ꤤ", "");
        addOption(document.myform.selectschool, "114528", "���߫��ꤤ", "");
        addOption(document.myform.selectschool, "114529", "���ߦ˾��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�k����') {
        addOption(document.myform.selectschool, "114503", "�����k���ꤤ", "");
        addOption(document.myform.selectschool, "114544", "���ߨF�[�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���q��') {
        addOption(document.myform.selectschool, "114504", "�������q�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ñd��') {
        addOption(document.myform.selectschool, "114505", "���ߥñd�ꤤ", "");
        addOption(document.myform.selectschool, "114543", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "114306", "���ߤj�W�������]�ꤤ", "");
        addOption(document.myform.selectschool, "114307", "���ߥä��������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s�T��') {
        addOption(document.myform.selectschool, "114508", "�����s�T�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s�ư�') {
        addOption(document.myform.selectschool, "114509", "���߷s�ưꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���ư�') {
        addOption(document.myform.selectschool, "114510", "���ߵ��ưꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ɤ���') {
        addOption(document.myform.selectschool, "114511", "���ߥɤ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s�W��') {
        addOption(document.myform.selectschool, "114512", "���ߤs�W�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�w�w��') {
        addOption(document.myform.selectschool, "114513", "���ߦw�w�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "114514", "���߷���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "114515", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "110328", "��߫n���ڹ��簪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�n�ư�') {
        addOption(document.myform.selectschool, "114516", "���߫n�ưꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "114517", "���ߥ���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�¨���') {
        addOption(document.myform.selectschool, "114518", "���߳¨��ꤤ", "");
        addOption(document.myform.selectschool, "111323", "�p�߾����������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�U���') {
        addOption(document.myform.selectschool, "114519", "���ߤU��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '���Ұ�') {
        addOption(document.myform.selectschool, "114520", "���ߤ��Ұꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�x�а�') {
        addOption(document.myform.selectschool, "114521", "���ߩx�аꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "114522", "���ߤj���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�Ψ���') {
        addOption(document.myform.selectschool, "114523", "���ߨΨ��ꤤ", "");
        addOption(document.myform.selectschool, "114524", "���ߨο��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ǥҰ�') {
        addOption(document.myform.selectschool, "114525", "���߾ǥҰꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '����') {
        addOption(document.myform.selectschool, "114526", "���ߦ��ꤤ", "");
        addOption(document.myform.selectschool, "111320", "�p�ߴ���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�N�x��') {
        addOption(document.myform.selectschool, "114527", "���߱N�x�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "114530", "���ߥ_���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�s���') {
        addOption(document.myform.selectschool, "114531", "���߫n�s�ꤤ", "");
        addOption(document.myform.selectschool, "114532", "���ߤӤl�ꤤ", "");
        addOption(document.myform.selectschool, "114533", "���߷s�F�ꤤ", "");
        addOption(document.myform.selectschool, "111313", "�p�߫n���������]�ꤤ", "");
        addOption(document.myform.selectschool, "111321", "�p�߿��갪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�Q����') {
        addOption(document.myform.selectschool, "114534", "�����Q���ꤤ", "");
        addOption(document.myform.selectschool, "111322", "�p�ߩ��F�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�ժe��') {
        addOption(document.myform.selectschool, "114535", "���ߥժe�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�h���') {
        addOption(document.myform.selectschool, "114536", "���߬h��ꤤ", "");
        addOption(document.myform.selectschool, "111318", "�p�߻�M�������]�ꤤ", "");
        addOption(document.myform.selectschool, "111326", "�p�߷s�a�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�F�s��') {
        addOption(document.myform.selectschool, "114537", "���ߪF�s�ꤤ", "");
        addOption(document.myform.selectschool, "114538", "���ߪF��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "114539", "���߫���ꤤ", "");
        addOption(document.myform.selectschool, "114540", "���ߵ׼d�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "213505", "���ߪ����ꤤ", "");
        addOption(document.myform.selectschool, "213509", "���߫ؿ��ꤤ", "");
        addOption(document.myform.selectschool, "213510", "���ߤ��s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�w����') {
        addOption(document.myform.selectschool, "213511", "���ߦw���ꤤ", "");
        addOption(document.myform.selectschool, "211320", "�]�Ϊk�H�O�ٰ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�n��' && document.myform.selectdistrict.value == '�w�n��') {
        addOption(document.myform.selectschool, "213512", "���ߦw�n�ꤤ", "");
        addOption(document.myform.selectschool, "213513", "���ߦw���ꤤ", "");
        addOption(document.myform.selectschool, "213519", "���ߩM���ꤤ", "");
        addOption(document.myform.selectschool, "213520", "���߮����ꤤ", "");
        addOption(document.myform.selectschool, "211315", "�p���s���������]�ꤤ", "");
        addOption(document.myform.selectschool, "213316", "���ߤg���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '��s��') {
        addOption(document.myform.selectschool, "124501", "���߻�s�ꤤ", "");
        addOption(document.myform.selectschool, "124503", "���߻��ꤤ", "");
        addOption(document.myform.selectschool, "124504", "���ߤ��Ұꤤ", "");
        addOption(document.myform.selectschool, "124505", "���߻�Ұꤤ", "");
        addOption(document.myform.selectschool, "124506", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "124543", "���߫C�~�ꤤ", "");
        addOption(document.myform.selectschool, "124549", "���ߤ��[�ꤤ", "");
        addOption(document.myform.selectschool, "124550", "���߻񵾰ꤤ", "");
        addOption(document.myform.selectschool, "121318", "�p�ߥ��q�������]�ꤤ", "");
        addOption(document.myform.selectschool, "124340", "���ߺָ۰������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�j�d��') {
        addOption(document.myform.selectschool, "124507", "���ߤj�d�ꤤ", "");
        addOption(document.myform.selectschool, "124508", "���߼�d�ꤤ", "");
        addOption(document.myform.selectschool, "124539", "���ߤ��ܰꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�j���') {
        addOption(document.myform.selectschool, "124509", "���ߤj��ꤤ", "");
        addOption(document.myform.selectschool, "124510", "���߷ˮH�ꤤ", "");
        addOption(document.myform.selectschool, "121307", "�]�Ϊk�H�������Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "121320", "�p�߸q�j��ڰ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���Q��') {
        addOption(document.myform.selectschool, "124512", "���߳��Q�ꤤ", "");
        addOption(document.myform.selectschool, "124302", "���ߤ�s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�j����') {
        addOption(document.myform.selectschool, "124514", "���ߤj���ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "124515", "���ߩ��s�ꤤ", "");
        addOption(document.myform.selectschool, "124516", "���߫e�p�ꤤ", "");
        addOption(document.myform.selectschool, "124546", "���߹ſ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�æw��') {
        addOption(document.myform.selectschool, "124517", "���ߥæw�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���Y��') {
        addOption(document.myform.selectschool, "124518", "���߾��Y�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '��x��') {
        addOption(document.myform.selectschool, "124519", "���߱�x�ꤤ", "");
        addOption(document.myform.selectschool, "124541", "���߳H�d�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�P�_��') {
        addOption(document.myform.selectschool, "124520", "���߿P�_�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "124521", "���ߪ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�򤺰�') {
        addOption(document.myform.selectschool, "124523", "���ߴ򤺰ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�X�_��') {
        addOption(document.myform.selectschool, "124524", "���߭X�_�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�мd��') {
        addOption(document.myform.selectschool, "124525", "���ߥмd�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "124526", "���������ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�X�s��') {
        addOption(document.myform.selectschool, "124527", "���ߺX�s�ꤤ", "");
        addOption(document.myform.selectschool, "124528", "���߶�I�ꤤ", "");
        addOption(document.myform.selectschool, "124529", "���ߤj�w�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���@��') {
        addOption(document.myform.selectschool, "124530", "���߬��@�ꤤ", "");
        addOption(document.myform.selectschool, "124531", "���߫n���ꤤ", "");
        addOption(document.myform.selectschool, "124532", "�����s�{�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���t��') {
        addOption(document.myform.selectschool, "124534", "�����_�Ӱꤤ", "");
        addOption(document.myform.selectschool, "124333", "���ߤ��t�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���L��') {
        addOption(document.myform.selectschool, "124535", "���ߧ��L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "124536", "���ߤ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�ҥP��') {
        addOption(document.myform.selectschool, "124537", "���ߥҥP�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�L���') {
        addOption(document.myform.selectschool, "124538", "���ߤ���ꤤ", "");
        addOption(document.myform.selectschool, "124311", "���ߪL�鰪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�����L��') {
        addOption(document.myform.selectschool, "124542", "���ߨ����L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���˰�') {
        addOption(document.myform.selectschool, "124544", "���ߤ@�Ұꤤ", "");
        addOption(document.myform.selectschool, "124322", "���߸��˰������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���Z��') {
        addOption(document.myform.selectschool, "124545", "���ߤj�W�ꤤ", "");
        addOption(document.myform.selectschool, "124313", "���ߤ��Z�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�Z�L��') {
        addOption(document.myform.selectschool, "124547", "���߭Z�L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�緽��') {
        addOption(document.myform.selectschool, "124548", "���߮緽�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�Q�L��') {
        addOption(document.myform.selectschool, "513501", "�����Q�L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "523502", "���߹ؤs�ꤤ", "");
        addOption(document.myform.selectschool, "523503", "���ߩ��ذꤤ", "");
        addOption(document.myform.selectschool, "523504", "���ߤC��ꤤ", "");
        addOption(document.myform.selectschool, "521301", "�p�ߩ��۰������]�ꤤ", "");
        addOption(document.myform.selectschool, "521303", "�p�ߤj�a�������]�ꤤ", "");
        addOption(document.myform.selectschool, "523301", "���߹��s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "533501", "���ߥ���ꤤ", "");
        addOption(document.myform.selectschool, "533502", "���ߤj�q�ꤤ", "");
        addOption(document.myform.selectschool, "533503", "���ߥ߼w�ꤤ", "");
        addOption(document.myform.selectschool, "533504", "�����s�ذꤤ", "");
        addOption(document.myform.selectschool, "533505", "���ߺ֤s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "543501", "���߷���ꤤ", "");
        addOption(document.myform.selectschool, "543502", "���ߥk���ꤤ", "");
        addOption(document.myform.selectschool, "543503", "���߫�l�ꤤ", "");
        addOption(document.myform.selectschool, "543504", "���߰���ꤤ", "");
        addOption(document.myform.selectschool, "543505", "���߻A�̰ꤤ(�p)", "");
        addOption(document.myform.selectschool, "540301", "��ߤ��s�j�Ǫ��ݰ���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�T����') {
        addOption(document.myform.selectschool, "553501", "���߹����ꤤ", "");
        addOption(document.myform.selectschool, "553502", "���ߤT���ꤤ", "");
        addOption(document.myform.selectschool, "553503", "���ߥ��ڰꤤ", "");
        addOption(document.myform.selectschool, "553504", "���߶����ꤤ", "");
        addOption(document.myform.selectschool, "553505", "���ߥ����ꤤ", "");
        addOption(document.myform.selectschool, "551301", "�p�ߥߧӰ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�e����') {
        addOption(document.myform.selectschool, "573501", "���߫e���ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�d����') {
        addOption(document.myform.selectschool, "583501", "���߭d���ꤤ", "");
        addOption(document.myform.selectschool, "583502", "���ߤ��ְꤤ", "");
        addOption(document.myform.selectschool, "583503", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "583505", "���߭^���ꤤ", "");
        addOption(document.myform.selectschool, "580301", "��߰��v�j�������]�ꤤ", "");
        addOption(document.myform.selectschool, "581301", "�p�ߴ_�ذ������]�ꤤ", "");
        addOption(document.myform.selectschool, "581302", "�p�߹D�����Ǫ��]�ꤤ", "");
        addOption(document.myform.selectschool, "583301", "���ߤ����������]�ꤤ", "");
        addOption(document.myform.selectschool, "583F01", "���߰����Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�e���') {
        addOption(document.myform.selectschool, "591501", "�p���u�ΰꤤ", "");
        addOption(document.myform.selectschool, "593501", "���߷�Ұꤤ", "");
        addOption(document.myform.selectschool, "593502", "���߫e��ꤤ", "");
        addOption(document.myform.selectschool, "593503", "���߷��װꤤ", "");
        addOption(document.myform.selectschool, "593504", "���ߥ��ذꤤ", "");
        addOption(document.myform.selectschool, "593505", "���߿����ꤤ", "");
        addOption(document.myform.selectschool, "593302", "���߷粻�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�X�z��') {
        addOption(document.myform.selectschool, "603501", "���ߺX�z�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�p���') {
        addOption(document.myform.selectschool, "613501", "���ߤp��ꤤ", "");
        addOption(document.myform.selectschool, "613502", "���߻�L�ꤤ", "");
        addOption(document.myform.selectschool, "613503", "���ߤ��s�ꤤ", "");
        addOption(document.myform.selectschool, "613504", "���ߩ��q�ꤤ", "");
        addOption(document.myform.selectschool, "613505", "�����\�Ȱꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�s����') {
        addOption(document.myform.selectschool, "563301", "���߷s���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�y����') {
        addOption(document.myform.selectschool, "024501", "���ߩy���ꤤ", "");
        addOption(document.myform.selectschool, "024502", "���ߤ��ذꤤ", "");
        addOption(document.myform.selectschool, "024503", "���ߴ_���ꤤ", "");
        addOption(document.myform.selectschool, "024524", "���߳ͱ۰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == 'ù�F��') {
        addOption(document.myform.selectschool, "024504", "����ù�F�ꤤ", "");
        addOption(document.myform.selectschool, "024505", "���ߪF���ꤤ", "");
        addOption(document.myform.selectschool, "024506", "���߰�ذꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�Y����') {
        addOption(document.myform.selectschool, "024507", "�����Y���ꤤ", "");
        addOption(document.myform.selectschool, "024526", "���ߤH��ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == 'Ĭ�D��') {
        addOption(document.myform.selectschool, "024508", "����Ĭ�D�ꤤ", "");
        addOption(document.myform.selectschool, "024509", "���ߤ�ưꤤ", "");
        addOption(document.myform.selectschool, "024510", "���߫n�w�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�T�P�m') {
        addOption(document.myform.selectschool, "024511", "���ߤT�P�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�G�˶m') {
        addOption(document.myform.selectschool, "024512", "�����G�˰ꤤ", "");
        addOption(document.myform.selectschool, "024513", "���ߧd�F�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�V�s�m') {
        addOption(document.myform.selectschool, "024514", "���ߥV�s�ꤤ", "");
        addOption(document.myform.selectschool, "024515", "���߶��w�ꤤ", "");
        addOption(document.myform.selectschool, "024525", "���߷O�ߵؼw�ֹ���ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "024516", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "024517", "���߿����ꤤ", "");
        addOption(document.myform.selectschool, "024518", "���ߧQ�A�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '���s�m') {
        addOption(document.myform.selectschool, "024519", "���߭��s�ꤤ", "");
        addOption(document.myform.selectschool, "024520", "���ߤ����ꤤ(�p)", "");
        addOption(document.myform.selectschool, "021301", "�p�߼z�O�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "024521", "���ߧ���ꤤ", "");
        addOption(document.myform.selectschool, "021310", "�p�ߤ��D�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�j�P�m') {
        addOption(document.myform.selectschool, "024523", "���ߤj�P�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�y����' && document.myform.selectdistrict.value == '�n�D�m') {
        addOption(document.myform.selectschool, "024322", "���߫n�D�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '���c��') {
        addOption(document.myform.selectschool, "031502", "�p�ߦ��o�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "034521", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "034522", "���ߤ��c�ꤤ", "");
        addOption(document.myform.selectschool, "034523", "���ߤj�[�ꤤ", "");
        addOption(document.myform.selectschool, "034524", "�����s���ꤤ", "");
        addOption(document.myform.selectschool, "034525", "���߿��n�ꤤ", "");
        addOption(document.myform.selectschool, "034526", "���ߦ۱j�ꤤ", "");
        addOption(document.myform.selectschool, "034527", "���ߪF���ꤤ", "");
        addOption(document.myform.selectschool, "034545", "�����s���ꤤ", "");
        addOption(document.myform.selectschool, "034563", "���߹L���ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '����') {
        addOption(document.myform.selectschool, "034501", "���߮��ꤤ", "");
        addOption(document.myform.selectschool, "034502", "���߫C�˰ꤤ", "");
        addOption(document.myform.selectschool, "034503", "���ߤ���ꤤ", "");
        addOption(document.myform.selectschool, "034504", "���߫ذ�ꤤ", "");
        addOption(document.myform.selectschool, "034505", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "034542", "���߷O��ꤤ", "");
        addOption(document.myform.selectschool, "034546", "���ߺ��װꤤ", "");
        addOption(document.myform.selectschool, "034551", "���ߦP�w�ꤤ", "");
        addOption(document.myform.selectschool, "034554", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "034556", "���߷|�]�ꤤ", "");
        addOption(document.myform.selectschool, "034562", "���߸g��ꤤ", "");
        addOption(document.myform.selectschool, "031313", "�p�߮��n�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == 'Ī�˰�') {
        addOption(document.myform.selectschool, "034506", "���߫n�r�ꤤ", "");
        addOption(document.myform.selectschool, "034507", "���ߤs�}�ꤤ", "");
        addOption(document.myform.selectschool, "034508", "���ߤj�˰ꤤ", "");
        addOption(document.myform.selectschool, "034550", "���ߥ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�j���') {
        addOption(document.myform.selectschool, "034509", "���ߤj��ꤤ", "");
        addOption(document.myform.selectschool, "034510", "���ߦ˳�ꤤ", "");
        addOption(document.myform.selectschool, "034565", "���߫C�H�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�j�˰�') {
        addOption(document.myform.selectschool, "034511", "���ߤj�˰ꤤ", "");
        addOption(document.myform.selectschool, "034513", "���ߤ��M�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�t�s��') {
        addOption(document.myform.selectschool, "034515", "���ߤj�^�ꤤ", "");
        addOption(document.myform.selectschool, "034552", "���ߩ��ְꤤ", "");
        addOption(document.myform.selectschool, "034555", "�����t�s�ꤤ", "");
        addOption(document.myform.selectschool, "034559", "���߰j�s�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�K�w��') {
        addOption(document.myform.selectschool, "034516", "���ߤK�w�ꤤ", "");
        addOption(document.myform.selectschool, "034517", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "031320", "�p�߷s���������]�ꤤ", "");
        addOption(document.myform.selectschool, "034347", "���ߥ��װ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "034518", "���ߤ��c�ꤤ", "");
        addOption(document.myform.selectschool, "034520", "���ߥ��n�ꤤ", "");
        addOption(document.myform.selectschool, "034543", "���ߥ����ꤤ", "");
        addOption(document.myform.selectschool, "034549", "���ߪF�w�ꤤ", "");
        addOption(document.myform.selectschool, "034560", "���ߥ���ꤤ", "");
        addOption(document.myform.selectschool, "031310", "�p�ߤ��M�������]�ꤤ", "");
        addOption(document.myform.selectschool, "031311", "�p�ߴ_���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "034528", "���߷����ꤤ", "");
        addOption(document.myform.selectschool, "034529", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "034530", "���ߴI���ꤤ", "");
        addOption(document.myform.selectschool, "034531", "���߷��ꤤ", "");
        addOption(document.myform.selectschool, "034544", "���߷����ꤤ", "");
        addOption(document.myform.selectschool, "034557", "���߷����ꤤ(�p)", "");
        addOption(document.myform.selectschool, "034564", "���߷�W�ꤤ", "");
        addOption(document.myform.selectschool, "031312", "�p�ߪv���������]�ꤤ", "");
        addOption(document.myform.selectschool, "031326", "�p�ߤj�ذ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�[����') {
        addOption(document.myform.selectschool, "034533", "�����[���ꤤ", "");
        addOption(document.myform.selectschool, "034534", "���߯󺪰ꤤ", "");
        addOption(document.myform.selectschool, "034332", "�����[���������]�ꤤ��", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�s�ΰ�') {
        addOption(document.myform.selectschool, "034535", "���߷s�ΰꤤ", "");
        addOption(document.myform.selectschool, "034536", "���ߤj�Y�ꤤ", "");
        addOption(document.myform.selectschool, "034537", "���ߥæw�ꤤ", "");
        addOption(document.myform.selectschool, "031319", "�p�߲M�ذ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�s���') {
        addOption(document.myform.selectschool, "034538", "�����s��ꤤ", "");
        addOption(document.myform.selectschool, "034539", "���߭ⶳ�ꤤ", "");
        addOption(document.myform.selectschool, "034540", "���ߥ۪��ꤤ", "");
        addOption(document.myform.selectschool, "034561", "���ߪZ�~�ꤤ", "");
    }
    if (document.myform.selectcity.value == '��饫' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "034541", "���ߤ��ذꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�˥_��') {
        addOption(document.myform.selectschool, "041501", "�p�߱d�D�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "044509", "���ߦ˥_�ꤤ", "");
        addOption(document.myform.selectschool, "044510", "���߻񩣰ꤤ", "");
        addOption(document.myform.selectschool, "044511", "���ߤ��a�ꤤ", "");
        addOption(document.myform.selectschool, "044526", "���߳շR�ꤤ", "");
        addOption(document.myform.selectschool, "044527", "���ߤ��R�ꤤ", "");
        addOption(document.myform.selectschool, "044529", "���ߦ��\�ꤤ", "");
        addOption(document.myform.selectschool, "041303", "�p�߸q���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�˪F��') {
        addOption(document.myform.selectschool, "044501", "���ߦ˪F�ꤤ", "");
        addOption(document.myform.selectschool, "044502", "���ߤG���ꤤ", "");
        addOption(document.myform.selectschool, "044503", "���߭��F�ꤤ", "");
        addOption(document.myform.selectschool, "044528", "���ߦ۱j�ꤤ", "");
        addOption(document.myform.selectschool, "041306", "�p�ߪF���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "044504", "��������ꤤ", "");
        addOption(document.myform.selectschool, "044505", "���ߥۥ��ꤤ", "");
        addOption(document.myform.selectschool, "044506", "���ߴI���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�s�H��') {
        addOption(document.myform.selectschool, "044507", "���߷s�H�ꤤ", "");
        addOption(document.myform.selectschool, "044508", "���߷Ӫ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�|�L�m') {
        addOption(document.myform.selectschool, "044512", "�����|�L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�s�׶m') {
        addOption(document.myform.selectschool, "044513", "���߷s�װꤤ", "");
        addOption(document.myform.selectschool, "044514", "���ߺ�ذꤤ", "");
        addOption(document.myform.selectschool, "044525", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "041305", "�p�ߩ��H�������]�ꤤ", "");
        addOption(document.myform.selectschool, "041307", "�p�ߥ��w�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '��s�m') {
        addOption(document.myform.selectschool, "044515", "���߾�s�ꤤ", "");
        addOption(document.myform.selectschool, "044516", "���ߵؤs�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�_�s�m') {
        addOption(document.myform.selectschool, "044517", "�����_�s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�_�H�m') {
        addOption(document.myform.selectschool, "044518", "���ߥ_�H�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�o�ܶm') {
        addOption(document.myform.selectschool, "044519", "���߮o�ܰꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '��f�m') {
        addOption(document.myform.selectschool, "044521", "���߷s��ꤤ", "");
        addOption(document.myform.selectschool, "044522", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "044320", "���ߴ�f�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '���p�m') {
        addOption(document.myform.selectschool, "044523", "���ߤ��p�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˿�' && document.myform.selectdistrict.value == '�y�۶m') {
        addOption(document.myform.selectschool, "044524", "���ߦy�۰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�]�ߥ�') {
        addOption(document.myform.selectschool, "054501", "���߭]�߰ꤤ", "");
        addOption(document.myform.selectschool, "054502", "���ߤj�۰ꤤ", "");
        addOption(document.myform.selectschool, "054503", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "051306", "�p�߫ػO�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�Y�ζm') {
        addOption(document.myform.selectschool, "054504", "�����Y�ΰꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���]�m') {
        addOption(document.myform.selectschool, "054505", "���ߤ��]�ꤤ", "");
        addOption(document.myform.selectschool, "054506", "�����b���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���r�m') {
        addOption(document.myform.selectschool, "054507", "���ߤ�L�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�b����') {
        addOption(document.myform.selectschool, "054510", "���߭P���ꤤ", "");
        addOption(document.myform.selectschool, "054309", "���߭b�̰������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�q�]��') {
        addOption(document.myform.selectschool, "054511", "���߳q�]�ꤤ", "");
        addOption(document.myform.selectschool, "054512", "���߫n�M�ꤤ", "");
        addOption(document.myform.selectschool, "054513", "���߯Q�ܰꤤ", "");
        addOption(document.myform.selectschool, "054514", "���߱ҷs�ꤤ", "");
        addOption(document.myform.selectschool, "054534", "���ߺֿ��Z�N�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "054515", "���ߦ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�Y����') {
        addOption(document.myform.selectschool, "054516", "�����Y���ꤤ", "");
        addOption(document.myform.selectschool, "054518", "���ߤ�^�ꤤ", "");
        addOption(document.myform.selectschool, "054532", "���߫ذ�ꤤ", "");
        addOption(document.myform.selectschool, "051305", "�p�ߤj���������]�ꤤ", "");
        addOption(document.myform.selectschool, "054317", "���߿��ذ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�˫n��') {
        addOption(document.myform.selectschool, "054519", "���ߦ˫n�ꤤ", "");
        addOption(document.myform.selectschool, "054520", "���߷ӫn�ꤤ", "");
        addOption(document.myform.selectschool, "051302", "�p�ߧg�ݰ������]�ꤤ", "");
        addOption(document.myform.selectschool, "054333", "���ߤj�P�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�T�W�m') {
        addOption(document.myform.selectschool, "054521", "���ߤT�W�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�n�ܶm') {
        addOption(document.myform.selectschool, "054522", "���߫n�ܰꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�y���m') {
        addOption(document.myform.selectschool, "054523", "���߳y���ꤤ", "");
        addOption(document.myform.selectschool, "054524", "���ߤj��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "054525", "���߫��s�ꤤ", "");
        addOption(document.myform.selectschool, "054526", "���ߺ��u�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�j��m') {
        addOption(document.myform.selectschool, "054527", "���ߤj��ꤤ", "");
        addOption(document.myform.selectschool, "054528", "���߫n��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "054529", "���߷��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '���w�m') {
        addOption(document.myform.selectschool, "054531", "���߮��w�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "050314", "��ߨ������簪�����]�ꤤ", "");
        addOption(document.myform.selectschool, "051307", "�p�ߥ��H���簪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�]�߿�' && document.myform.selectdistrict.value == '�T�q�m') {
        addOption(document.myform.selectschool, "054308", "���ߤT�q�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "074501", "���ߥ_��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�ֿ��m') {
        addOption(document.myform.selectschool, "074502", "���߳���ꤤ", "");
        addOption(document.myform.selectschool, "074521", "���ߺֿ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "074503", "���߳���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�u��m') {
        addOption(document.myform.selectschool, "074504", "���߽u��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���ƥ�') {
        addOption(document.myform.selectschool, "074505", "���߶����ꤤ", "");
        addOption(document.myform.selectschool, "074506", "���߹��w�ꤤ", "");
        addOption(document.myform.selectschool, "074507", "���߹��w�ꤤ", "");
        addOption(document.myform.selectschool, "074538", "���߹����ꤤ", "");
        addOption(document.myform.selectschool, "074540", "���߹����ꤤ", "");
        addOption(document.myform.selectschool, "074541", "���߫H�q�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "071311", "�p�ߺ�۰������]�ꤤ", "");
        addOption(document.myform.selectschool, "074308", "���߹������N�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "074509", "���ߪ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���L��') {
        addOption(document.myform.selectschool, "074510", "���߭��L�ꤤ", "");
        addOption(document.myform.selectschool, "074511", "���ߩ��۰ꤤ", "");
        addOption(document.myform.selectschool, "074536", "���ߤj�P�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�G�L��') {
        addOption(document.myform.selectschool, "074512", "���߸U���ꤤ", "");
        addOption(document.myform.selectschool, "074537", "���߭��ꤤ", "");
        addOption(document.myform.selectschool, "074313", "���ߤG�L�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�˶�m') {
        addOption(document.myform.selectschool, "074514", "���ߦ˶�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�j���m') {
        addOption(document.myform.selectschool, "074515", "���ߤj���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�ڭb�m') {
        addOption(document.myform.selectschool, "074516", "���߯��ꤤ", "");
        addOption(document.myform.selectschool, "074517", "���ߪڭb�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�˴���') {
        addOption(document.myform.selectschool, "074518", "���߷˴�ꤤ", "");
        addOption(document.myform.selectschool, "074339", "���ߦ��\�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�H�Q�m') {
        addOption(document.myform.selectschool, "074519", "���߮H�Q�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�H�߶m') {
        addOption(document.myform.selectschool, "074520", "���߮H�߰ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�q���m') {
        addOption(document.myform.selectschool, "074522", "���ߨq���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "074524", "���ߦ���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�j���m') {
        addOption(document.myform.selectschool, "074525", "���ߤj���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '��¶m') {
        addOption(document.myform.selectschool, "074526", "���ߪ�°ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�ùt�m') {
        addOption(document.myform.selectschool, "074527", "���ߥùt�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�G���m') {
        addOption(document.myform.selectschool, "074529", "���ߤG���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���Y�m') {
        addOption(document.myform.selectschool, "074530", "���ߪ��Y�ꤤ", "");
        addOption(document.myform.selectschool, "070F02", "��߹��ƱҴ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�Ч��m') {
        addOption(document.myform.selectschool, "074531", "���ߥЧ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�˦{�m') {
        addOption(document.myform.selectschool, "074532", "���߷˦{�ꤤ", "");
        addOption(document.myform.selectschool, "074533", "���߷˶��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '���Y�m') {
        addOption(document.myform.selectschool, "074534", "���߰��Y�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�M����') {
        addOption(document.myform.selectschool, "074535", "���ߩM�s�ꤤ", "");
        addOption(document.myform.selectschool, "074323", "���ߩM���������]�ꤤ", "");
        addOption(document.myform.selectschool, "070F01", "��ߩM������Ǯ�", "");
    }
    if (document.myform.selectcity.value == '���ƿ�' && document.myform.selectdistrict.value == '�Ф���') {
        addOption(document.myform.selectschool, "071317", "�p�ߤ忳�������]�ꤤ", "");
        addOption(document.myform.selectschool, "074328", "���ߥФ��������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�H����') {
        addOption(document.myform.selectschool, "081502", "�p�ߧ��Y�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "084505", "���߮H���ꤤ", "");
        addOption(document.myform.selectschool, "084506", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "084507", "���ߧ����ꤤ", "");
        addOption(document.myform.selectschool, "081314", "�p�ߴ��x�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�n�륫') {
        addOption(document.myform.selectschool, "084501", "���߫n��ꤤ", "");
        addOption(document.myform.selectschool, "084502", "���߫n�^�ꤤ", "");
        addOption(document.myform.selectschool, "084503", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "084504", "���߻��ꤤ", "");
        addOption(document.myform.selectschool, "084532", "������_�ꤤ", "");
        addOption(document.myform.selectschool, "081311", "�p�ߤ��|�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "084508", "���߯�ٰꤤ", "");
        addOption(document.myform.selectschool, "084510", "���ߤ�s�ꤤ", "");
        addOption(document.myform.selectschool, "084309", "���ߦ����������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�ˤs��') {
        addOption(document.myform.selectschool, "084511", "���ߦˤs�ꤤ", "");
        addOption(document.myform.selectschool, "084512", "���ߩ��M�ꤤ", "");
        addOption(document.myform.selectschool, "084513", "���ߪ��d�ꤤ", "");
        addOption(document.myform.selectschool, "084514", "���߷�˰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "084515", "���߶����ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�W���m') {
        addOption(document.myform.selectschool, "084516", "���ߦW���ꤤ", "");
        addOption(document.myform.selectschool, "084517", "���ߤT���ꤤ", "");
        addOption(document.myform.selectschool, "081313", "�p�ߥ������簪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "084518", "���߳����ꤤ", "");
        addOption(document.myform.selectschool, "084519", "���߷�p�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '���d�m') {
        addOption(document.myform.selectschool, "084520", "���ߤ��d�ꤤ", "");
        addOption(document.myform.selectschool, "084521", "���߲n��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "084522", "���߳����ꤤ", "");
        addOption(document.myform.selectschool, "084523", "���ߩ���ꤤ", "");
        addOption(document.myform.selectschool, "081312", "�p�ߤT�|�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '��m�m') {
        addOption(document.myform.selectschool, "084524", "���߰�m�ꤤ", "");
        addOption(document.myform.selectschool, "084525", "���ߥ_���ꤤ", "");
        addOption(document.myform.selectschool, "084526", "���ߥ_�s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "084527", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "084528", "���ߥ��M�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '�H�q�m') {
        addOption(document.myform.selectschool, "084529", "���߫H�q�ꤤ", "");
        addOption(document.myform.selectschool, "084530", "���ߦP�I�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�n�뿤' && document.myform.selectdistrict.value == '���R�m') {
        addOption(document.myform.selectschool, "084531", "���ߤ��R�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�L���m') {
        addOption(document.myform.selectschool, "091502", "�p�߲W���ꤤ", "");
        addOption(document.myform.selectschool, "094530", "���ߪL���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "091503", "�p�ߪF�n�ꤤ(�N��)", "");
        addOption(document.myform.selectschool, "094519", "���ߦ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�j�|�m') {
        addOption(document.myform.selectschool, "091505", "�p�ߺִ��ꤤ", "");
        addOption(document.myform.selectschool, "094512", "���ߥj�|�ꤤ", "");
        addOption(document.myform.selectschool, "094527", "���ߪF�M�ꤤ", "");
        addOption(document.myform.selectschool, "094544", "���߼̴�ͺA�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '��n��') {
        addOption(document.myform.selectschool, "094502", "���ߪF���ꤤ", "");
        addOption(document.myform.selectschool, "094301", "���ߤ�n�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�j��m') {
        addOption(document.myform.selectschool, "094503", "���ߤj��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�|��m') {
        addOption(document.myform.selectschool, "094504", "���߭��F�ꤤ", "");
        addOption(document.myform.selectschool, "094505", "���ߥ|��ꤤ", "");
        addOption(document.myform.selectschool, "091311", "�p�ߤ�Ͱ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '���L�m') {
        addOption(document.myform.selectschool, "094506", "���ߤ��L�ꤤ", "");
        addOption(document.myform.selectschool, "094526", "�����r�Q�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�G�[�m') {
        addOption(document.myform.selectschool, "094508", "���ߤG�[�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�ǩ��m') {
        addOption(document.myform.selectschool, "094509", "���߽ǩ��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�l��m') {
        addOption(document.myform.selectschool, "094510", "�����l��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�[�I�m') {
        addOption(document.myform.selectschool, "094511", "���߱[�I�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�F�նm') {
        addOption(document.myform.selectschool, "094513", "���ߪF�հꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "094514", "���ߤ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�椻��') {
        addOption(document.myform.selectschool, "094515", "���ߤ椻�ꤤ", "");
        addOption(document.myform.selectschool, "094516", "���߶��L�ꤤ", "");
        addOption(document.myform.selectschool, "094529", "���ߥۺh�ꤤ", "");
        addOption(document.myform.selectschool, "091308", "�p�ߥ��߰������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�����') {
        addOption(document.myform.selectschool, "094517", "���ߪ���ꤤ", "");
        addOption(document.myform.selectschool, "094518", "���߱R�w�ꤤ", "");
        addOption(document.myform.selectschool, "094543", "���ߪF���ꤤ", "");
        addOption(document.myform.selectschool, "091316", "�p�ߴ��l�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�_����') {
        addOption(document.myform.selectschool, "094520", "���ߥ_��ꤤ", "");
        addOption(document.myform.selectschool, "094521", "���߫ذ�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�f��m') {
        addOption(document.myform.selectschool, "094522", "���ߩy��ꤤ", "");
        addOption(document.myform.selectschool, "094523", "���ߤf��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�O��m') {
        addOption(document.myform.selectschool, "094524", "���߻O��ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�g�w��') {
        addOption(document.myform.selectschool, "094525", "���ߤg�w�ꤤ", "");
        addOption(document.myform.selectschool, "094528", "���߰����ꤤ", "");
        addOption(document.myform.selectschool, "091307", "�p�ߥæ~�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '�椻����') {
        addOption(document.myform.selectschool, "091320", "�p�ߺ��h�Q�ȹ��簪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���L��' && document.myform.selectdistrict.value == '���d�m') {
        addOption(document.myform.selectschool, "094307", "���߳��d�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���l��') {
        addOption(document.myform.selectschool, "104501", "���ߦ��l�ꤤ", "");
        addOption(document.myform.selectschool, "104502", "���ߪF�۰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���U��') {
        addOption(document.myform.selectschool, "104503", "���ߥ��U�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�F�۶m') {
        addOption(document.myform.selectschool, "104504", "���߹L���ꤤ", "");
        addOption(document.myform.selectschool, "104515", "���ߪF�a�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�j�L��') {
        addOption(document.myform.selectschool, "104505", "���ߤj�L�ꤤ", "");
        addOption(document.myform.selectschool, "101303", "�p�ߦP�ٰ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�s��m') {
        addOption(document.myform.selectschool, "104506", "���߷s��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "104507", "���ߥ����ꤤ", "");
        addOption(document.myform.selectschool, "104508", "���ߤj�N�ꤤ", "");
        addOption(document.myform.selectschool, "101304", "�p�ߨ�P�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���}�m') {
        addOption(document.myform.selectschool, "104509", "���ߤ��Űꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�ӫO��') {
        addOption(document.myform.selectschool, "104511", "���ߤӫO�ꤤ", "");
        addOption(document.myform.selectschool, "104512", "���߹ŷs�ꤤ", "");
        addOption(document.myform.selectschool, "104326", "���ߥüy�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�ˤf�m') {
        addOption(document.myform.selectschool, "104513", "���߷ˤf�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "104514", "���߳���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���W�m') {
        addOption(document.myform.selectschool, "104516", "���ߤ��W�ꤤ", "");
        addOption(document.myform.selectschool, "104517", "���ߩ��M�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���H�m') {
        addOption(document.myform.selectschool, "104518", "���ߤ��H�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�˱T�m') {
        addOption(document.myform.selectschool, "104520", "���ߪ@���ꤤ", "");
        addOption(document.myform.selectschool, "104319", "���ߦ˱T�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�q�˶m') {
        addOption(document.myform.selectschool, "104521", "���߸q�˰ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�f���m') {
        addOption(document.myform.selectschool, "104522", "���ߥ��M�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���s�m') {
        addOption(document.myform.selectschool, "104523", "���߱��s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�j�H�m') {
        addOption(document.myform.selectschool, "104524", "���ߤj�H�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�����s�m') {
        addOption(document.myform.selectschool, "104526", "���ߪ����s�ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�r���m') {
        addOption(document.myform.selectschool, "131501", "�p�߫n�a�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�̪F��') {
        addOption(document.myform.selectschool, "134501", "���ߩ����ꤤ", "");
        addOption(document.myform.selectschool, "134502", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "134503", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "134505", "�����b�n�ꤤ", "");
        addOption(document.myform.selectschool, "134506", "���ߦܥ��ꤤ", "");
        addOption(document.myform.selectschool, "131308", "�p�߳����������]�ꤤ", "");
        addOption(document.myform.selectschool, "134304", "���ߤj�P�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���v�m') {
        addOption(document.myform.selectschool, "134507", "���ߪ��v�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�ﬥ�m') {
        addOption(document.myform.selectschool, "134508", "�����ﬥ�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�E�p�m') {
        addOption(document.myform.selectschool, "134509", "���ߤE�p�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "134510", "���ߨ���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�Q�H�m') {
        addOption(document.myform.selectschool, "134511", "�����Q�H�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "134512", "���߰���ꤤ", "");
        addOption(document.myform.selectschool, "134513", "���߰����ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���H�m') {
        addOption(document.myform.selectschool, "134514", "���ߤ��H�ꤤ", "");
        addOption(document.myform.selectschool, "134515", "���߱R��ꤤ", "");
        addOption(document.myform.selectschool, "131311", "�p�߬��M�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�˥жm') {
        addOption(document.myform.selectschool, "134516", "���ߦ˥аꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '��{��') {
        addOption(document.myform.selectschool, "134517", "���߼�{�ꤤ", "");
        addOption(document.myform.selectschool, "134518", "���ߥ��K�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�U�r�m') {
        addOption(document.myform.selectschool, "134519", "���߸U�r�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�s��m') {
        addOption(document.myform.selectschool, "134520", "���߷s��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�U���m') {
        addOption(document.myform.selectschool, "134522", "���߸U���ꤤ", "");
        addOption(document.myform.selectschool, "134542", "���߸U�s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�s��m') {
        addOption(document.myform.selectschool, "134523", "���߷s��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�L��m') {
        addOption(document.myform.selectschool, "134525", "���ߪL��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�n�{�m') {
        addOption(document.myform.selectschool, "134526", "���߫n�{�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�ΥV�m') {
        addOption(document.myform.selectschool, "134527", "���ߨΥV�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�[�y�m') {
        addOption(document.myform.selectschool, "134528", "���߯[�y�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "134530", "���ߨ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '��K��') {
        addOption(document.myform.selectschool, "134531", "���߫�K�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���{�m') {
        addOption(document.myform.selectschool, "134532", "���ߺ��{�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���a�m') {
        addOption(document.myform.selectschool, "134533", "���ߺ��a�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '���Z�m') {
        addOption(document.myform.selectschool, "134535", "���߮��Z�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�d���m') {
        addOption(document.myform.selectschool, "134536", "���ߨd���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�D�s�m') {
        addOption(document.myform.selectschool, "134537", "���߷�l�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�F����') {
        addOption(document.myform.selectschool, "134538", "���ߪF�s�ꤤ", "");
        addOption(document.myform.selectschool, "134324", "���ߪF�䰪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�D�d�m') {
        addOption(document.myform.selectschool, "134321", "���ߪD�d�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�̪F��' && document.myform.selectdistrict.value == '�Ӹq�m') {
        addOption(document.myform.selectschool, "134334", "���ߨӸq�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�O�F��') {
        addOption(document.myform.selectschool, "141501", "�p�ߧ��@�ꤤ(�p)", "");
        addOption(document.myform.selectschool, "144501", "���߷s�Ͱꤤ", "");
        addOption(document.myform.selectschool, "144502", "���ߪF���ꤤ", "");
        addOption(document.myform.selectschool, "144503", "�����_��ꤤ", "");
        addOption(document.myform.selectschool, "144504", "���ߨ��n�ꤤ", "");
        addOption(document.myform.selectschool, "144505", "�����ץаꤤ", "");
        addOption(document.myform.selectschool, "144506", "���ߪ����ꤤ", "");
        addOption(document.myform.selectschool, "140301", "��߻O�F�j�Ǫ�����|�������]�ꤤ", "");
        addOption(document.myform.selectschool, "141307", "�p�ߨ|���������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���n�m') {
        addOption(document.myform.selectschool, "144507", "���ߪ���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "144508", "���߳����ꤤ", "");
        addOption(document.myform.selectschool, "144509", "���߷緽�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "144510", "�������s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���W�m') {
        addOption(document.myform.selectschool, "144511", "���ߦ��W�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�ӳ¨��m') {
        addOption(document.myform.selectschool, "144512", "���ߤj���ꤤ", "");
        addOption(document.myform.selectschool, "144513", "���߻��Z�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�j�Z�m') {
        addOption(document.myform.selectschool, "144514", "���ߤj�Z�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�F�e�m') {
        addOption(document.myform.selectschool, "144515", "���߳����ꤤ", "");
        addOption(document.myform.selectschool, "144516", "���߮����ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���\��') {
        addOption(document.myform.selectschool, "144517", "���߷s��ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���ضm') {
        addOption(document.myform.selectschool, "144518", "���ߪ��ذꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "144519", "���߮緽�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '���ݶm') {
        addOption(document.myform.selectschool, "144520", "���߮��ݰꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '��q�m') {
        addOption(document.myform.selectschool, "144521", "���ߺ�q�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�O�F��' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "144322", "���������������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�ɨ���') {
        addOption(document.myform.selectschool, "154501", "���ߥɨ��ꤤ", "");
        addOption(document.myform.selectschool, "154502", "���ߥɪF�ꤤ", "");
        addOption(document.myform.selectschool, "154503", "���ߤT���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�Ὤ��') {
        addOption(document.myform.selectschool, "154504", "���߬��[�ꤤ", "");
        addOption(document.myform.selectschool, "154505", "���ߪ�^�ꤤ", "");
        addOption(document.myform.selectschool, "154506", "���߰ꭷ�ꤤ", "");
        addOption(document.myform.selectschool, "154522", "���ߦ۱j�ꤤ", "");
        addOption(document.myform.selectschool, "151312", "�]�Ϊk�H�O�٤j�Ǫ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�s���m') {
        addOption(document.myform.selectschool, "154507", "���ߨq�L�ꤤ", "");
        addOption(document.myform.selectschool, "154508", "���߷s���ꤤ", "");
        addOption(document.myform.selectschool, "151306", "�p�߮��P�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�N�w�m') {
        addOption(document.myform.selectschool, "154509", "���ߦN�w�ꤤ", "");
        addOption(document.myform.selectschool, "154510", "���ߩy���ꤤ", "");
        addOption(document.myform.selectschool, "154523", "���ߤƤ��ꤤ", "");
        addOption(document.myform.selectschool, "150F01", "��ߪὬ�Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���׶m') {
        addOption(document.myform.selectschool, "154511", "���߹��װꤤ", "");
        addOption(document.myform.selectschool, "154512", "���ߥ��M�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���_�m') {
        addOption(document.myform.selectschool, "154513", "���ߥ��_�ꤤ", "");
        addOption(document.myform.selectschool, "154514", "���ߴI���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '��L��') {
        addOption(document.myform.selectschool, "154515", "���߻�L�ꤤ", "");
        addOption(document.myform.selectschool, "154516", "���߸U�a�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '�I���m') {
        addOption(document.myform.selectschool, "154517", "���ߴI���ꤤ", "");
        addOption(document.myform.selectschool, "154518", "���ߴI�_�ꤤ", "");
        addOption(document.myform.selectschool, "154521", "���ߪF���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���ضm') {
        addOption(document.myform.selectschool, "154519", "�������ذꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ὤ��' && document.myform.selectdistrict.value == '���J�m') {
        addOption(document.myform.selectschool, "154520", "���߷��J�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "164501", "���߰����ꤤ", "");
        addOption(document.myform.selectschool, "164502", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "164503", "���߼�n�ꤤ", "");
        addOption(document.myform.selectschool, "164513", "���ߤ���ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '���m') {
        addOption(document.myform.selectschool, "164504", "���ߴ��ꤤ", "");
        addOption(document.myform.selectschool, "164505", "���ߧӲM�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�ըF�m��') {
        addOption(document.myform.selectschool, "164506", "��������ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�ըF�m') {
        addOption(document.myform.selectschool, "164507", "���ߥըF�ꤤ", "");
        addOption(document.myform.selectschool, "164508", "���ߦN���ꤤ", "");
        addOption(document.myform.selectschool, "164514", "���߳����ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "164509", "���ߦ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '��w�m') {
        addOption(document.myform.selectschool, "164510", "���߱�w�ꤤ", "");
        addOption(document.myform.selectschool, "164511", "���߱N�D�ꤤ", "");
    }
    if (document.myform.selectcity.value == '���' && document.myform.selectdistrict.value == '�C���m') {
        addOption(document.myform.selectschool, "164512", "���ߤC���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�H�q��') {
        addOption(document.myform.selectschool, "173503", "���߫H�q�ꤤ", "");
        addOption(document.myform.selectschool, "173509", "���ߦ��\�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "171308", "�p�߸t�߰������]�ꤤ", "");
        addOption(document.myform.selectschool, "173304", "���ߤ��s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "173505", "���ߤ����ꤤ", "");
        addOption(document.myform.selectschool, "173510", "���ߥ��ذꤤ", "");
        addOption(document.myform.selectschool, "171306", "�p�ߤG�H�������]�ꤤ", "");
        addOption(document.myform.selectschool, "173314", "���ߤK�氪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�C����') {
        addOption(document.myform.selectschool, "173501", "���ߩ��w�ꤤ", "");
        addOption(document.myform.selectschool, "173513", "���ߦʺְꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '���R��') {
        addOption(document.myform.selectschool, "173502", "���߻ʶǰꤤ", "");
        addOption(document.myform.selectschool, "173508", "���߫n�a�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�w�ְ�') {
        addOption(document.myform.selectschool, "173512", "���߫ؼw�ꤤ", "");
        addOption(document.myform.selectschool, "173516", "���ߪZ�[�ꤤ", "");
        addOption(document.myform.selectschool, "173306", "���ߦw�ְ������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�򶩥�' && document.myform.selectdistrict.value == '�x�x��') {
        addOption(document.myform.selectschool, "173515", "�����䤺�ꤤ", "");
        addOption(document.myform.selectschool, "173307", "���߷x�x�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˥�' && document.myform.selectdistrict.value == '�_��') {
        addOption(document.myform.selectschool, "183503", "���ߥ��ذꤤ", "");
        addOption(document.myform.selectschool, "183508", "���߫n�ذꤤ", "");
        addOption(document.myform.selectschool, "183515", "���ߦ˥��ꤤ", "");
        addOption(document.myform.selectschool, "181307", "�p�߽Y�۰������]�ꤤ", "");
        addOption(document.myform.selectschool, "183306", "���ߦ��w�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˥�' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "181501", "�p�ߪ����ꤤ(�p)", "");
        addOption(document.myform.selectschool, "183501", "���߫صذꤤ", "");
        addOption(document.myform.selectschool, "183502", "���߰��^�ꤤ", "");
        addOption(document.myform.selectschool, "183504", "���ߨ|��ꤤ", "");
        addOption(document.myform.selectschool, "183505", "���ߥ��Z�ꤤ", "");
        addOption(document.myform.selectschool, "183510", "���ߤT���ꤤ", "");
        addOption(document.myform.selectschool, "183514", "���߷s��ꤤ", "");
        addOption(document.myform.selectschool, "181305", "�p�ߥ��_�������]�ꤤ", "");
        addOption(document.myform.selectschool, "181306", "�p���ƥ��k�����]�ꤤ", "");
        addOption(document.myform.selectschool, "183313", "���߫إ\�������]�ꤤ", "");
        addOption(document.myform.selectschool, "180301", "��߬�Ǥu�~��Ϲ��簪�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s�˥�' && document.myform.selectdistrict.value == '���s��') {
        addOption(document.myform.selectschool, "183509", "���ߴI§�ꤤ", "");
        addOption(document.myform.selectschool, "183511", "���ߤ���ꤤ", "");
        addOption(document.myform.selectschool, "183512", "���ߪ�L�ꤤ", "");
        addOption(document.myform.selectschool, "183307", "���߭��s�������]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '���') {
        addOption(document.myform.selectschool, "203505", "���ߥ��Ͱꤤ", "");
        addOption(document.myform.selectschool, "203506", "���ߥɤs�ꤤ", "");
        addOption(document.myform.selectschool, "203508", "���ߥ_��ꤤ", "");
        addOption(document.myform.selectschool, "200F01", "��߹Ÿq�Ҵ��Ǯ�", "");
    }
    if (document.myform.selectcity.value == '�Ÿq��' && document.myform.selectdistrict.value == '�F��') {
        addOption(document.myform.selectschool, "203501", "���ߤj�~�ꤤ", "");
        addOption(document.myform.selectschool, "203502", "���ߥ_���ꤤ", "");
        addOption(document.myform.selectschool, "203503", "���߹Ÿq�ꤤ", "");
        addOption(document.myform.selectschool, "203504", "���߫n���ꤤ", "");
        addOption(document.myform.selectschool, "203507", "��������ꤤ", "");
        addOption(document.myform.selectschool, "201304", "�p�߿��ذ������]�ꤤ", "");
        addOption(document.myform.selectschool, "201310", "�p�߹ŵذ������]�ꤤ", "");
        addOption(document.myform.selectschool, "201312", "�p�߻����������]�ꤤ", "");
        addOption(document.myform.selectschool, "201313", "�p�ߧ����k�����]�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "714501", "���ߪ����ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '������') {
        addOption(document.myform.selectschool, "714502", "���ߪ���ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '����m') {
        addOption(document.myform.selectschool, "714503", "���ߪ���ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '���F��') {
        addOption(document.myform.selectschool, "714504", "���ߪ��F�ꤤ", "");
    }
    if (document.myform.selectcity.value == '������' && document.myform.selectdistrict.value == '�P���m') {
        addOption(document.myform.selectschool, "714505", "���߯P���ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�n��m') {
        addOption(document.myform.selectschool, "724501", "���ߤ��ذꤤ(�p)", "");
        addOption(document.myform.selectschool, "724502", "���ߤ����ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�_��m') {
        addOption(document.myform.selectschool, "724503", "���ߤ��s�ꤤ", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�����m') {
        addOption(document.myform.selectschool, "724504", "���߷q��ꤤ(�p)", "");
    }
    if (document.myform.selectcity.value == '�s����' && document.myform.selectdistrict.value == '�F�޶m') {
        addOption(document.myform.selectschool, "724505", "���ߪF�ްꤤ(�p)", "");
    }

}
////////////////// 

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
