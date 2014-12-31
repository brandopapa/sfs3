<?php
// $Id: dl_pdf2.php 5310 2009-01-10 07:57:56Z hami $

require('../../include/sfs_case_chinese.php');

class PDF extends PDF_Chinese
{
	//Page header
	function Header($title)
	{
		global $title;
		$this->SetFont('Big5','B',12);
		//Title
		$this->MultiCell(0,10,$title,0);
		//Line break
		//$this->Ln(10);
	}

	//Page footer
	function Footer()
	{
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Big5','I',8);
		//Page number
		$this->Cell(0,10,'�� '.$this->PageNo().'/{nb}',0,0,'C');
	}

	//Simple table
	function BasicTable($header,$data)
	{
		//Header
		$col_num=count($header);
		if($col_num>10) $this->SetFont('Big5','',10);
		//$col_width=round(170/$col_num,0);
		//�C�@�Ӧr���w�]���e��
		$col_width=1.8;
		//�C�����w�]���r����
		$default_char=4;
		$i=0;
		$col="";
		foreach($header as $col){
			if(strlen($col)) {
				if(strlen($col)>8) $col_width_a[$i]=$col_width*8 ;
    			else $col_width_a[$i]=$col_width*strlen($col) ;//�W�L4�Ӥ���r�N�I�_
				//echo $col_width_a[$i]."---";
			}
			else $col_width_a[$i]=$col_width*$default_char ;
			$i++;
		}

		foreach($data as $row){
			$col="";
			$i=0;
			foreach($row as $col){
				if(strlen($col)) {
					if(strlen($col)>8) $new_col_width_a[$i]=$col_width*8;
					else $new_col_width_a[$i]=$col_width*strlen($col) ;//�W�L4�Ӥ���r�N�I�_
				}
				if($new_col_width_a[$i] > $col_width_a[$i]) $col_width_a[$i]=$new_col_width_a[$i];
				//echo $col_width_a[$i]."---";
				$i++;
			}
			//echo "<br>";
		}


		//print_r($col_width_a);
		$i=0;
		foreach($header as $col){
			//if(strlen($col)) $col_width_a[$i]=$col_width*strlen($col) ;
			//else $col_width_a[$i]=$col_width*$default_char ;
			if(strlen($col)>8) $col=substr($col,0,8);//�W�L4�Ӥ���r�N�I�_
 			$this->Cell($col_width_a[$i],7,$col,1,'','C');
			$i++;
		}
		$this->Ln();
		//Data
		$this->SetFont('Big5','',10);
		foreach($data as $row){
			$i=0;
			foreach($row as $col){
				if(strlen($col)>8) $col=substr($col,0,8);//�W�L4�Ӥ���r�N�I�_
				$this->Cell($col_width_a[$i],7,$col,1,'','C');
				$i++;
			}
			$this->Ln();
		}
	}

	//���e�����Ѥ�r�A�C�H���P
	function Comm1($comment1)
	{
		$this->SetFont('Big5','',10);
		if($comment1!=""){
			$this->MultiCell(0,10,$comment1,0);
			//$this->Ln(10);
		}
	}

	//���᪺���Ѥ�r�A�C�H�ۦP
	function Comm2($comment2)
	{
		$this->SetFont('Big5','',10);
		//Title
		$this->MultiCell(0,10,$comment2,0);
		//Line break
		$this->Ln(10);
	}

}


//title:��󪺩��Y
//header:��檺�Ĥ@�C�A�@���}�C
//big_data:��檺���e�A�G���ΤT���}�C
function creat_pdf($title,$header,$data,$comment1="",$comment2=""){

/*�o�̬O�ѻ��d��
	//��󪺩��D
	$title="��󪺩��D";
	//��檺�Ĥ@�C�A�@���}�C
	$header=array("","�P���@","�P���G","�P���T","�P���|","�P����","�P����");
	//��檺���e�A�ĤG�C����A�G���ΤT���}�C
	$dim=arrs($arr);
	//dim=2�A�`��A���ݤ���
	//dim=3�A�C�H�@���A�n����
*/
	$dim=arrs($data);

	//����pdf��
	$pdf=new PDF();
	$pdf->Open();
	$pdf->AddBig5Font();
	$pdf->Header($title);
	$pdf->AliasNbPages();
	/*	�Y�O�C�@�ӤH�@������ƫh�]�]�N�O�@�ӤH������n�����i��U�@���ƪ���X�^
		���N�C�@�ӤH����ƳƧ�
		�pdata1��1�����ӤH���Z��
		data2��2�����ӤH���Z��
		�̦�����
		�b���Xpdf�ɮ�
		�C�@�ӤH�����I�s�@��
		$pdf->AddPage();
		$pdf->SetFont('Big5','',12);
		$pdf->BasicTable($header,$data);
	*/
	if($dim==2){//�`��
		$pdf->AddPage();
		$pdf->SetFont('Big5','',10);
		$pdf->Comm1($comment1);
		$pdf->BasicTable($header,$data);
		$pdf->Comm2($comment2);
	}elseif($dim==3){//�C�H�@��
		$k=0;
		foreach($data as $data_val){
			$pdf->AddPage();
			$pdf->SetFont('Big5','',10);
			$pdf->Comm1($comment1[$k]);
			$pdf->BasicTable($header,$data_val);
			$pdf->Comm2($comment2);
			$k++;
		}
	}
	$pdf->Output();

}

//�P�_�X���}�C
function arrs($arr,$CC="0"){
	if(!is_array($arr)){
		//echo "<br>".$CC;
		return $CC;
	}else{
		$CC++;
		//echo "<br>".$CC;
		$arr=$arr[0];
		$CC=arrs($arr,$CC);
		return $CC;
	}
}
?>
