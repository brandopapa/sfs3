<?php

//$Id: sfs_case_graph.php 7771 2013-11-15 06:39:56Z smallduh $
$path="";
while(!is_file($path."jpgraph/jpgraph.php")) {
	$path="../".$path;
}

include_once $path."jpgraph/jpgraph.php";

class sfs_nbar{

	var $datay=array();	//���
	var $graph="";
	var $ybplot=array();
	var $mfont=FF_CHINESE;	//�D���D�r��
	var $mfont_size=14;	//�D���D�r�j�p
	var $lfont=FF_CHINESE;	//�ϨҦr��
	var $xfont=FF_CHINESE;	//x�b�r��
	var $xlfont=FF_CHINESE;	//x�b���Ҧr��
	var $xfont_size=12;	//x�b�r�j�p
	var $xlfont_size=10;	//x�b���Ҧr�j�p
	var $yfont=FF_CHINESE;	//y�b�r��
	var $yfont_size=12;	//y�b�r�j�p
	var $ybcolor=array("#9999ef","#993366","yellow","green","#b8860b");	//bar�C��}�C
	var $yfcolor=array("#9999ef","#993366","black","green","#b8860b");	//bar�C��}�C
	var $num_str="%d";	//�Ʀr�榡

	function sfs_nbar($gx=640,$gy=480) {
		global $path;

		include_once $path."jpgraph/jpgraph_bar.php";
		$this->graph=new Graph($gx,$gy);
		$this->graph->SetBox();
		$this->graph->img->SetMargin(70,90,70,70);
		$this->set_mfont();
		$this->set_lfont();
		$this->set_lshadow();
		$this->set_margincolor();
		$this->set_lpos();
		$this->graph->SetScale("textlin");
		$this->graph->legend->SetLeftMargin(0);

		//�]�wx�b
		$this->set_xfont();
		$this->graph->xaxis->SetTitleMargin(30);
		$this->graph->xaxis->SetLabelMargin(12);
		$this->graph->xaxis->SetLabelAlign('center','center');

		//�]�wy1�b
		$this->set_yfont();
		$this->graph->yaxis->SetTitleSide(SIDE_LEFT);
		$this->graph->yaxis->title->Align('center','top');
		$this->graph->yaxis->SetTitleMargin(50);
		$this->graph->yaxis->scale->SetGrace(0);

		//�]�wy�b��u�C��
		$this->graph->ygrid->SetColor('gray','lightgray');
	}

	//�]�w����90��
	function set90() {
		$this->graph->Set90AndMargin(90,70,70,70);
		$this->graph->xaxis->SetTitleMargin(60);
		$this->graph->xaxis->SetLabelMargin(5);
		$this->graph->xaxis->title->SetAngle(90);
		$this->graph->xaxis->SetLabelAlign('right','center');
		$this->graph->yaxis->SetPos('max');
		$this->graph->yaxis->SetTitleSide(SIDE_RIGHT);
		$this->graph->yaxis->SetLabelSide(SIDE_RIGHT);
		$this->graph->yaxis->SetTickSide(SIDE_LEFT);
		$this->graph->yaxis->SetLabelMargin(20);
		$this->graph->yaxis->SetTitleMargin(40);
		$this->graph->yaxis->title->SetAngle(0);
		$this->graph->yaxis->scale->SetGrace(6);
	}

	//�]�w���
	function set_y($y=array()) {
		reset($y);
		while(list($i,$v)=each($y)) {
			if (count($v)>0) {
				$this->ybplot[$i]=new BarPlot($v);
			}
		}
	}

	//�]�w�I���C��
	function set_margincolor($c="white") {
		$this->graph->SetMarginColor($c);
		$this->graph->legend->SetFillColor($c);	//�Ϩҩ���
	}

	//�]�w�D���D
	function set_mtitle($t="") {
		$this->graph->title->Set($t);
	}

	//�]�w�D���D�r��
	function set_mfont($f,$s) {
		if ($f) $this->mfont=$f;
		if ($s) $this->mfont_size=$s;
		$this->graph->title->SetFont($this->mfont,FS_NORMAL,$this->mfont_size);
	}

	//�]�w�ϨҦr��
	function set_lfont($f) {
		if ($f) $this->lfont=$f;
		$this->graph->legend->SetFont($this->lfont);
	}

	//�]�w�ϨҬ۹��m
	function set_lpos($x=0.01,$y=0.5,$align="right",$valign="center") {
		$this->graph->legend->SetPos($x,$y,$align,$valign);
	}

	//�]�w�Ϩҳ��v
	function set_lshadow($e=false) {
		$this->graph->legend->SetShadow($e);
	}

	//�]�wx�b���D
	function set_xtitle($t="",$a="center") {
		$this->graph->xaxis->SetTitle($t,$a);
	}

	//�]�wx�b���
	function set_xlabel($d="") {
		if (is_array($d)) {
			$this->graph->xaxis->SetTickLabels($d);
		}
	}

	//�]�wx�b��ƨ���
	function set_xlableangel($d=0) {
		if ($d) {
			$this->graph->xaxis->SetLabelAngle($d);
		}
	}

	//�]�wx�b���D�r��
	function set_xfont($f,$s) {
		if ($f) $this->xfont=$f;
		if ($s) $this->xfont_size=$s;
		$this->graph->xaxis->title->SetFont($this->xfont,FS_NORMAL,$this->xfont_size);
	}

	//�]�wx�b���Ҧr��
	function set_xlfont($f,$s) {
		if ($f) $this->xlfont=$f;
		if ($s) $this->xlfont_size=$s;
		$this->graph->xaxis->SetFont($this->xlfont,FS_NORMAL,$this->xlfont_size);
	}

	//�]�wy�b���D
	function set_ytitle($t="",$a="center") {
		$this->graph->yaxis->SetTitle($t,$a);
	}

	//�]�wy�b���D�r��
	function set_yfont($f,$s) {
		if ($f) $this->yfont=$f;
		if ($s) $this->yfont_size=$s;
		$this->graph->yaxis->title->SetFont($this->yfont,FS_NORMAL,$this->yfont_size);
	}

	//�]�w�����C��
	function set_ybcolor($c) {
		if (is_array($c)) $this->ybcolor=$c;
		while(list($i,$v)=each($this->ybcolor)) {
			if ($v) $this->ybcolor[$i]=$v;
			if (is_object($this->ybplot[$i])) {
				$this->ybplot[$i]->SetColor($v);
				$vv=$v."@0.3";
				$this->ybplot[$i]->SetFillColor($vv);
				$vv=($this->yfcolor[$i])?$this->yfcolor[$i]:$v;
				$this->ybplot[$i]->value->SetColor($vv);
			}
		}
	}

	//�]�w�ϨҼ��D
	function set_ltitle($t) {
		if (is_array($t)) {
			reset($t);
			while(list($i,$v)=each($t)) {
				if ($this->ybplot[$i]) {
					$this->ybplot[$i]->SetLegend($v);
				}
			}
		}
	}

	//�]�w��������ܼƭȮ榡
	function set_shownum($s) {
		if ($s) $this->num_str=$s;
		while(list($i,$v)=each($this->ybplot)) {
			if ($this->ybplot[$i]) {
				$this->ybplot[$i]->value->Show();
				$this->ybplot[$i]->value->SetFormat($this->num_str);
			}
		}
	}

	function draw() {
		$this->ynplot=new GroupBarPlot($this->ybplot);
		$this->ynplot->SetWidth(0.8);
		$this->set_ybcolor();
		$this->set_shownum();
		$this->graph->Add($this->ynplot);
		$this->graph->Stroke();
	}
}

class sfs_pie3d{
	var $data=array();	//���ϸ��
	var $graph="";
	var $mfont=FF_CHINESE;	//�D���D�r��
	var $mfont_size=14;	//�D���D�r�j�p
	var $lfont=FF_CHINESE;	//�ϨҦr��
	var $pie;
	var $pfont=FF_CHINESE;	//���Ϧr��
	var $num_str="%d";	//���榡
	var $num_unit="�H";	//����r

	function sfs_pie3d($gx=640,$gy=480) {
		global $path;

		include_once $path."jpgraph/jpgraph_pie.php";
		include_once $path."jpgraph/jpgraph_pie3d.php";
		$this->graph=new PieGraph($gx,$gy,'auto');
		$this->graph->legend->SetFillColor("white");	//�Ϩҩ���
		$this->set_mfont();
		$this->set_lfont();
		$this->set_lpos();
		$this->set_lshadow();
	}

	//�]�w�D���D
	function set_mtitle($t="") {
		$this->graph->title->Set($t);
	}

	//�]�w�D���D�r��
	function set_mfont($f,$s) {
		if ($f) $this->mfont=$f;
		if ($s) $this->mfont_size=$s;
		$this->graph->title->SetFont($this->mfont,FS_NORMAL,$this->mfont_size);
	}

	//�]�w�ϨҦr��
	function set_lfont($f) {
		if ($f) $this->lfont=$f;
		$this->graph->legend->SetFont($this->lfont);
	}

	//�]�w�ϨҬ۹��m
	function set_lpos($x=0.02,$y=0.86) {
		$this->graph->legend->SetPos($x,$y);
	}

	//�]�w�Ϩҳ��v
	function set_lshadow($e=false) {
		$this->graph->legend->SetShadow($e);
	}

	//�]�w���
	function set_data($d=array()) {
		if (count($d)>0) {
			$this->data=$d;
			$this->pie=new PiePlot3D($this->data);
		}
	}

	//�]�w�ϨҼ��D
	function set_ltitle($t) {
		if ($this->pie) {
			$this->pie->SetLegends($t);
		}
	}

	//�]�w���Ϧr��
	function set_pfont($f) {
		if ($f) $this->pfont=$f;
		if ($this->pie) {
			$this->pie->value->SetFont($this->pfont);
		}
	}

	//�]�w���Ϥ��ߦ�m
	function set_ppos($x=0.5,$y=0.43) {
		if ($this->pie) {
			$this->pie->SetCenter($x,$y);
		}
	}

	//�]�w������ܸ�Ƴ��
	function set_shownum($s,$u) {
		if ($s) $this->num_str=$s;
		if ($u) $this->num_unit=$u;
		if ($this->pie) {
			$this->pie->value->SetFormat($this->num_str." ".$this->num_unit);
		}
	}

	function draw() {
		$this->set_pfont();
		$this->pie->SetLabelType(1);
		$this->set_ppos();
		$this->graph->Add($this->pie);
		$this->graph->Stroke();
//		$this->graph->StrokeCSIM();
	}
}
?>
