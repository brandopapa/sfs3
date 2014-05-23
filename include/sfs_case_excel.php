<?php
//$Id: sfs_case_excel.php 6437 2011-05-12 05:56:53Z brucelyc $
require_once $SPREADSHEET_PATH."Excel/Writer.php";
require_once $INCLUDE_PATH."sfs_case_encoding.php";

class sfs_xls{

	var $xls;	//����ɮת���
	var $titleText;	//��ƪ���D
	var $input_encoding;	//�r��
	var $bold;	//�ʦr��
	var $size="12";	//�r��j�p
	var $fcolor="black";	//�r���C��
	var $font="Arial";	//�r��
	var $border_no="";	//�ؽu����
	var $bcolor="black";	//�ؽu�C��
	var $bwidth=1;	//�ؽu�ʲ�
	var $btop="";	//�ؽu_���u
	var $bleft="";	//�ؽu_���u
	var $bright="";	//�ؽu_�k�u
	var $bbottom="";	//�ؽu_���u
	var $merge;	//�X�����
	var $filename="book.xls";	//�w�]�ɦW
	var $sheet_no=1;	//�ثe����ƪ�Ǧ�
	var $cart;	//�ثe����ƪ���
	var $row_no=0;	//�ثe����ƦC
	var $row_height=16.5;	//�w�]�C��
	var $row_weight=8.38;	//�w�]��e
	var $mergeArr=array(); //�X���x�s��}�C, �C�Ӥj�x�s��Harray($first_row, $first_col, $last_row, $last_col)����
	var $rowText=array(); //��W�}�C
	var $items=array();	//�g�J�����
	var $f=array();	//format�}�C

	function sfs_xls() {
		$this->xls =& new Spreadsheet_Excel_Writer();
	}

	function setTitle($title="") {
		if ($this->input_encoding) {
			$this->titleText=iconv("Big5",$this->input_encoding,$title);
		} else {
			$this->titleText=$title;
		}
	}

	function setRowText($arr=array()) {
		if (is_array($arr)) $this->rowText[]=$arr;
	}

	function setUTF8() {
		$this->input_encoding = "utf-8";
		$this->xls->setVersion(8,"utf-8");
	}

	function init_format() {
		$this->bwidth = "";
		$this->btop = "";
		$this->bleft = "";
		$this->bright = "";
		$this->bbottom = "";
		$this->merge = "";
	}

	function setBorderStyle($no) {
		if (!empty($no)) {
			$this->border_no=$no;
			switch ($no) {
				case 0:
					$this->setBorder();
					break;
				case 1:
					$this->bwidth=1;
					$this->setBorder(1,1,1,1);
					break;
				case 2:
					$this->bwidth=2;
					$this->setBorder(2,2,2,2);
					break;
				case 3:
				case 4:
				case 5:
				case 6:
					switch($no) {
						case 3:
							$bo=1;
							$bi=0;
							break;
						case 4:
							$bo=2;
							$bi=0;
							break;
						case 5:
							$bo=1;
							$bi=1;
							break;
						case 6:
							$bo=2;
							$bi=1;
							break;
					}

					//�q�w�U����ث���
					$this->setBorder($bo,$bi,$bo,$bi);
					$this->f[1]=$this->addFormat();
					$this->setBorder($bo,$bi,$bi,$bi);
					$this->f[2]=$this->addFormat();
					$this->setBorder($bo,$bi,$bi,$bo);
					$this->f[3]=$this->addFormat();
					$this->setBorder($bi,$bi,$bo,$bi);
					$this->f[4]=$this->addFormat();
					$this->setBorder($bi,$bi,$bi,$bi);
					$this->f[5]=$this->addFormat();
					$this->setBorder($bi,$bi,$bi,$bo);
					$this->f[6]=$this->addFormat();
					$this->setBorder($bi,$bo,$bo,$bi);
					$this->f[7]=$this->addFormat();
					$this->setBorder($bi,$bo,$bi,$bi);
					$this->f[8]=$this->addFormat();
					$this->setBorder($bi,$bo,$bi,$bo);
					$this->f[9]=$this->addFormat();
					break;
			}
		}
	}

	function setBorder($top=0,$bottom=0,$left=0,$right=0) {
		$this->btop=$top;
		$this->bleft=$left;
		$this->bright=$right;
		$this->bbottom=$bottom;
	}

	function addFormat() {
		$format =& $this->xls->addFormat();

		//Set font
		if (!$this->font) $this->font="Arial";
		$format->setFontFamily($this->font);

		//Set font size
		if (!$this->size) $this->size=12;
		$format->setSize($this->size);

		//Set font bold
		if ($this->bold) $format->setBold();

		//Set font color
		if (!$this->fcolor) $this->fcolor="black";
		if ($this->fcolor) $format->setColor($this->fcolor);

		//Check border color
		if (!$this->bcolor) $this->bcolor="black";

		//Check border width
		if (!$this->bwidth) $this->bwidth=1;

		//Set border top
		if ($this->btop!="") {
			$format->setTop($this->btop);
			$format->setTopColor($this->bcolor);
		}

		//Set border right
		if ($this->bright!="") {
			$format->setRight($this->bright);
			$format->setRightColor($this->bcolor);
		}

		//Set border left
		if ($this->bleft!="") {
			$format->setLeft($this->bleft);
			$format->setLeftColor($this->bcolor);
		}

		//Set border bottom
		if ($this->bbottom!="") {
			$format->setBottom($this->bbottom);
			$format->setBottomColor($this->bcolor);
		}

		//Set column merge
		if ($this->merge) {
			$format->setAlign('merge');
		}

		return $format;
	}

	function addSheet($sheetname="") {
		$this->row_no=0;
		if ($sheetname=="") {
			$sheetname="sheet".$this->sheet_no;
			$this->sheet_no++;
		}
		if ($this->input_encoding) $sheetname=iconv("Big5",$this->input_encoding,$sheetname);
		$this->cart =& $this->xls->addWorksheet($sheetname);
		if ($this->input_encoding) $this->cart->setInputEncoding($this->input_encoding);
	}

	function writeSheet($format="") {
		if ($format=="") $format=$this->addFormat();
		if ($this->cart) {
			// Set the row height
			$this->cart->setRow($this->row_no,$this->row_height);

			// Set the column width
			$this->cart->setColumn($this->row_no,3,$this->row_weight);

			// Set Title
			if ($this->titleText) {
				$this->cart->write($this->row_no,0,$this->titleText,$f);
				$this->row_no++;
			}

			if (is_array($this->rowText)) $this->items=array_merge($this->rowText,$this->items);

			while(list($k,$item)=each($this->items)) {
				// �B�z�S����ؼ˦�
				if ($this->border_no>2) {
					if ($this->row_no==0) {
						// ���k�ΤW�ؽu�βʽu
						$r=0;
					} elseif ($k==count($this->items)) {
						// ���k�ΤU�ؽu�βʽu
						$r=6;
					} else {
						//�ȥ��k�ؽu�βʽu
						$r=3;
					}
				}

				//�B�z�X���x�s��
				if (count($this->mergeArr)>0) {
					reset($this->mergeArr);
					while(list($k,$v)=each($this->mergeArr)) {
						$this->cart->setMerge($v[0], $v[1], $v[2], $v[3]);
					}
				}

				for ($col=0;$col<count($item);$col++) {
					// �B�z�S����ؼ˦�
					if ($this->border_no>2) {
						if ($col==0) {
							$f=$this->f[$r+1];
						} elseif ($col==(count($item)-1)) {
							$f=$this->f[$r+3];
						} else {
							$f=$this->f[$r+2];
						}
					} else {
						$f=$format;
					}
					if ($this->input_encoding) {
						$d=spec_uni($item[$col]);
						$d=iconv("Big5","UTF-8//IGNORE",$d);
					} else {
						$d=$item[$col];
					}
					$this->cart->writeString($this->row_no,$col,$d,$f);
				}
				// �B�z�C�ƥ[�@
				$this->row_no++;
			}
		}
	}

	function writeFile() {
		if ($this->items) {
			$i=$this->items;
			while(list($sheetname,$this->items)=each($i)) {
				$this->addSheet($sheetname);
				$this->writeSheet();
			}
		}
	}

	function process() {
		$this->xls->send($this->filename);
		$this->xls->close();
	}
}
?>
