<?php
// tcpdf file created by shan balakrishnan kerala for esay generation of reports from array generated from 
//data fetched from database during 2012
require_once(PATH_LIBS.'tcpdf/tcpdf.php');

define(PAPERHEIGHT,210);//P:297,L:210

class oTCPDF extends TCPDF
{
	//Page header
  public function Header($strKSEBHeader='')
    {
        // Set font
        $this->SetFont('helvetica', 'B', 20);		
		$this->writeHTMLCell(0, 0, 35, $this->GetY(), $strKSEBHeader,0,1);
		//$this->write(8, $strKSEBHeader);
        $this->SetFont('helvetica', 'B', 10);
    }

    //Page footer
  public function Footer()
    {
    	global $gAPPVERSIONTEXT,$aRAUser;
        $this->SetY(-13);
   		$this->SetFont('helvetica', '', 10);

        
		 // Set font
        $this->SetFont('helvetica', 'I', 8);
		$style['position'] = 'L';
		
	///********orumnet version
	$this->Cell(0, 0, AppManage::getApplcationName(1), 0, 0, 'L');
	
	 ///--*** For orumanet -- time stamp
   	$this->Cell(0, 0, $aRAUser['dmyta_cts'], 0, 0, 'R');	
   	 $this->SetY(-13);		
	// Page number
        $this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');

   		$this->setPrintHeader(false);//header required only for first page  	
  
    }

    //Page break when page end condition reached
public function conditionalHTMLCel($strTableInfo,$strSampleTableHeader='',$intReqTblHeader=0,$strTableCOBF=null)
   {
		$intRequiredLines=$this->getNumLines($strTableInfo);
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+PDF_MARGIN_TOP)<PAPERHEIGHT)
		{
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strTableInfo, 0,1);
		  
		}
		else
		{
		//echo $strTableCOBF;
			
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strTableCOBF, '0',1,0);
			$this->AddPage();
			if($intReqTblHeader==1)$strTableInfo=$strSampleTableHeader.$strTableCOBF.$strTableInfo;
		   	$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strTableInfo,0,1);
		}
   }
function htmlFromArraycolName($aryColHeader,$intWidth='100%')
{
	$strColWidth=$strColHead=$strDataBody="";
	$strTableHead= "<table width=\"".$intWidth."\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\">";	
	$strColHead.="<tr>";

	foreach($aryColHeader as $colN)
	{
		$strColWidth="";		
		if(!empty($colN['colWidth'])){$strColWidth="width=\"".$colN['colWidth']."\"";}
		$strColHead.="<td align=\"center\" ".$strColWidth." >".$colN['name']."</td>";
	}	
		
		$strColHead.="</tr>";
		$strFooter=$strTableFoot= "</table>"; 		
		$strSampleTableHead=$strTableHead.$strColHead.$strFooter;
	
	return $strSampleTableHead;	
}
function htmlFromArraycolNameWkeys($aryColHeader,$arySelKeys)
{
	$strColWidth=$strColHead=$strDataBody="";
	$strTableHead= "<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\">";	
	$strColHead.="<tr>";

	foreach($arySelKeys as $keyN)
	{	
		$strColWidth=$colN="";	
		$colN=$aryColHeader[$keyN];	
		if(!empty($colN['colWidth'])){$strColWidth="width=\"".$colN['colWidth']."\"";}
		$strColHead.="<td align=\"center\" ".$strColWidth." >".$colN['name']."</td>";
	}	
		
		$strColHead.="</tr>";
		$strFooter=$strTableFoot= "</table>"; 		
		$strSampleTableHead=$strTableHead.$strColHead.$strFooter;
	
	return $strSampleTableHead;	
}
public function genRepWGTHTMLCells($strTableInfo,$strMainTableInfo='',$strPayBillTableHeader='',$intReqTblHeader=0,$strPayBillCOBF=null,$aryOldGrantTotal=array())
   {
	$intRequiredLines=$this->getNumLines($strTableInfo);
	$start_y=$this->GetY();

	if(($start_y+$intRequiredLines)<180)
	{
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strTableInfo, '0',1,0);
		$this->oldGrantTotal=$aryOldGrantTotal;
	}
	else
	{
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strPayBillCOBF, '0',1,0);
		$this->AddPage();
		if($intReqTblHeader==1)$strTableInfo=$strPayBillCOBF.$strPayBillTableHeader.$strMainTableInfo;
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strTableInfo, '0',1,0);
	}
   }

public function reportCheckPageEnding($strData,$strHeader='')
	{
	
		$intRequiredLines=nvl($this->getNumLines($strData),2);
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+12)<180)
		{
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strData, 0,1);		  
		}
		else
		{			
			$this->AddPage();	
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, '0',1,0);
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strData, '0',1,0);	
		}

}

public function reportCheckPageEndingForPortrait($strData,$strHeader='')
	{
	
		$intRequiredLines=nvl($this->getNumLines($strData),2);
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+2)<250)
		{
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strData, 0,1);		  
		}
		else
		{			
			$this->AddPage();	
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, '0',1,0);
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strData, '0',1,0);	
		}

}
public function CheckPageEndingForColHeads($strHeader='')
	{			
		$intRequiredLines=nvl($this->getNumLines($strHeader),2);		
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+12)<180)
		{			
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-10,$strHeader, 0,1);		  
		}
		else
		{		
			$this->AddPage();				
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-10,$strHeader, '0',1,0);	
		}

}
public function CheckPageEndingForColHeadsForPortrait($strHeader='')
	{			
		$intRequiredLines=nvl($this->getNumLines($strHeader),2);		
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+3)<250)
		{			
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-9,$strHeader, 0,1);		  
		}
		else
		{		
			$this->AddPage();				
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-9,$strHeader, '0',1,0);	
		}

}
public function CheckPageEndingForMultiTables($strHeader='',$strTableTitle='')
	{
		$this->Ln(2);				
		$intRequiredLines1=nvl($this->getNumLines($strTableTitle),2);
		$intRequiredLines2=nvl($this->getNumLines($strHeader),2);
		$intRequiredLines=$intRequiredLines1+$intRequiredLines2*2;
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+12)<180)
		{
			$this->SetFont('helvetica', 'B', 14);	
			$this->writeHTMLCell(0, 0, 95, $this->GetY(), $strTableTitle,0,1);	
			$this->SetFont('helvetica', '', 8);	
		   $this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);		  
		}
		else
		{
			
			//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strData, '0',1,0);
			$this->AddPage();	
			$this->SetFont('helvetica', 'B', 14);	
			$this->writeHTMLCell(0, 0, 95, $this->GetY(), $strTableTitle,0,1);	
			$this->SetFont('helvetica', '', 8);	
			$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, '0',1,0);	
		}

}


public function CheckPageEndingForTableTitle($strTableTitle='',$intAdReqLines=null)
	{
	
		$intRequiredLines=nvl($this->getNumLines($strTableTitle),2);
		nvl($intAdReqLines,$intRequiredLines*4);
		$intRequiredLines+=$intAdReqLines;
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+12)<180)
		{
		  $this->writeHTMLCell(0, 0, $this->GetX(), $this->GetY()+2, $strTableTitle,0,1);		  
		}
		else
		{			
			$this->AddPage();				
			$this->writeHTMLCell(0, 0, $this->GetX(), $this->GetY()+2, $strTableTitle,0,1);
		}

}
public function CheckPageEndingForTableTitleForPortrait($strTableTitle='',$intAdReqLines=null)
	{
	
		$intRequiredLines=nvl($this->getNumLines($strTableTitle),2);
		nvl($intAdReqLines,$intRequiredLines*4);
		$intRequiredLines+=$intAdReqLines;
		$start_y=$this->GetY();

		if(($start_y+$intRequiredLines+7)<250)
		{					
		  $this->writeHTMLCell(0, 0, $this->GetX(), $this->GetY()+2, $strTableTitle,0,1);		  
		}
		else
		{				
			$this->AddPage();				
			$this->writeHTMLCell(0, 0, $this->GetX(), $this->GetY()+2, $strTableTitle,0,1);
		}

}
// Colored table
public function ColoredTable($header,$data)
{
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
}

public function multicellArrangedData($header, $data)
{
	
	// create new PDF document
	//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
	// set document information
	$this->SetCreator(PDF_CREATOR);
	$this->SetAuthor('Nicola Asuni');
	$this->SetTitle('TCPDF Example 011');
	$this->SetSubject('TCPDF Tutorial');
	$this->SetKeywords('TCPDF, PDF, example, test, guide');
	
	// set default header data
	$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);
	
	// set header and footer fonts
	$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$this->SetHeaderMargin(PDF_MARGIN_HEADER);
	$this->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	//set auto page breaks
	$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	//set image scale factor
	$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	//set some language-dependent strings
	$this->setLanguageArray($l);
	
	// ---------------------------------------------------------
	
	// set font
	$this->SetFont('helvetica', '', 12);
	
	// add a page
	$this->AddPage();
	
	//Column titles
	//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
	
	//Data loading
	//$data = $this->LoadData('../cache/table_data_demo.txt');
	
	// print colored table
	$this->ColoredTable($header, $data);
	
	// ---------------------------------------------------------
	
	//Close and output PDF document
	$this->Output('example_011.pdf', 'I');
}


	//Page break when page end condition reached ;for reports
public function reportMultiPageHTMLCel($aryColHeader,$aryData,$strRepTitle=' REPORT',$strFooterText='',$strKSEBHeader=ORG_NAME)
 {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(10, 25, 16);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 20);		
		$this->writeHTMLCell(0, 0, 75, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,60,$this->GetY(),$aRAUser['role_office_name'], 0,1);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		//$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		//$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolName($aryColHeader);
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody='';
				$strDataBody.="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($row as $data)
				{
				$strDataBody.="<td align=\"center\" width=\"".$aryColHeader[$i]['colWidth']."\">".$data."</td>";
				
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEnding($strDataBody,$strHeader);
				$i++;
			}

		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+185,$this->GetY()-7,$aRAUser['designation'], 0,1);

		$this->Output($strRepTitle,'D');
   }
/**
column name and and data should be given seperately.order should be same.
	$aryColHeader[0]['name']='Sl.No';column name 
	$aryColHeader[0]['colWidth']='5%';width --if want to specify
	$aryColHeader[1]['name']='Consumer<br />no.';
	
			$aryData[$i][0]=1;
			$aryData[$i][0]['colWidth']='5%';width if specified in column name
			$aryData[$i][1]=$row['consumer_num'];
	$i is each row number		
*/
	//Page break when page end condition reached ;for reports
public function generalReportWArray($aryColHeader,$aryData,$strRepTitle=' REPORT',$arySelGdTotalKeys=null,$strFooterText='',$strKSEBHeader=ORG_NAME)
   {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(10, 25, 16);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 21);		
		$this->writeHTMLCell(0, 0, 75, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,100,$this->GetY(),$aRAUser['role_office_name'], 0,1);

		$this->SetFont('helvetica', 'B', 14);		
		$this->writeHTMLCell(0, 0, 105, $this->GetY()+4, $strRepTitle,0,1);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		//$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		//$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolName($aryColHeader);
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		$intLastRow=sizeof($aryData);
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody='';
				$strDataBodyGT1='';
				$strDataBody.="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($row as $skey => $data)
				{				
				$colWD='';
				if($aryColHeader[$i]['colWidth']!=null){$colWD="width=\"".$aryColHeader[$i]['colWidth']."\"";}	
				$strDataBody.="<td align=\"center\" ".$colWD." >".$data."</td>";
				$i++;
				
					dp('check1');dp($skey);printr($arySelGdTotalKeys);
					if(is_array($arySelGdTotalKeys))
					  {   dp('check12');
							//$Npos = array_search($skey, $arySelGdTotalKeys);dp($Npos);
						  	if(in_array($skey, $arySelGdTotalKeys))
						  		{$aryGT[$skey]+=$row[$skey];}
						  	else
						  		$aryGT[$skey]=null;
						if($i>=2)  		
							{
							$strTT=empty($aryGT[$skey]) ? $aryGT[$skey] : withDecimal($aryGT[$skey]);
							$strDataBodyGT1.="<td align=\"center\" ".$colWD." >".$strTT."</td>";
							}
						else
							{$strDataBodyGT1.="<td align=\"center\" ".$colWD."  >Total</td>";}  		
					 }
				    			
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEnding($strDataBody,$strHeader);
				
			}
		
		$strDataBodyGT='';
		$strDataBodyGTh="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";		
		$strDataBodyGTt="</tr></table>";	
		$strDataBodyGTpr=$strDataBodyGTh.$strDataBodyGT1.$strDataBodyGTt;
		$this->reportCheckPageEnding($strDataBodyGTpr,$strHeader);
		//$strDataBody1="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,$aRAUser['designation'], 0,1);
		//$this->printBarCodeONV();
		$this->Output($strRepTitle.date("d.m.y"),'D');
   }

public function generalReportSelKeysGrandTotal($aryColHeader,$aryData,$arySelKeys,$arySelGdTotalKeys,$strRepTitle=' REPORT',$strFooterText='',$strKSEBHeader=ORG_NAME)
   {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(10, 25, 12);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 21);		
		$this->writeHTMLCell(0, 0, 75, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,100,$this->GetY(),$aRAUser['role_office_name'], 0,1);

		$this->SetFont('helvetica', 'B', 14);		
		$this->writeHTMLCell(0, 0, 105, $this->GetY()+4, $strRepTitle,0,1);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		//$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolNameWkeys($aryColHeader,$arySelKeys);
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		 $aryGT=array();
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody='';
				$strDataBody.="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($arySelKeys as $skey)
				{
				$colWD='';
				if($aryColHeader[$skey]['colWidth']!=null){$colWD="width=\"".$aryColHeader[$skey]['colWidth']."\"";}	
				$strDataBody.="<td align=\"center\" ".$colWD." >".$row[$skey]."</td>";
				$i++;
				
				  $Npos = array_search($skey, $arySelGdTotalKeys);
				  if($Npos){
				 		 $aryGT[$arySelGdTotalKeys[$Npos]]+=$row[$skey];
				  			}
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEnding($strDataBody,$strHeader);				
				
			}

		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,$aRAUser['designation'], 0,1);
		//$this->printBarCodeONV();
		$this->Output($strRepTitle,'D');
   }      
public function generalReportFArrayWKeys($aryColHeader,$aryData,$arySelKeys,$strRepTitle=' REPORT',$arySelGdTotalKeys=null,$strFooterText='',$strKSEBHeader=ORG_NAME)
   {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(10, 25, 12);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 21);		
		$this->writeHTMLCell(0, 0, 75, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,100,$this->GetY(),$aRAUser['role_office_name'], 0,1);

		$this->SetFont('helvetica', 'B', 14);		
		$this->writeHTMLCell(0, 0, 105, $this->GetY()+4, $strRepTitle,0,1);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		//$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolNameWkeys($aryColHeader,$arySelKeys);
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody='';
				$strDataBody.="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($arySelKeys as $skey)
				{
				$colWD='';
				if($aryColHeader[$skey]['colWidth']!=null){$colWD="width=\"".$aryColHeader[$skey]['colWidth']."\"";}	
				$strDataBody.="<td align=\"center\" ".$colWD." >".$row[$skey]."</td>";
				$i++;
				
					if($arySelGdTotalKeys!=null)
					{
					 $Npos = array_search($skey, $arySelGdTotalKeys);
					  if($Npos){$aryGT[$arySelGdTotalKeys[$Npos]]+=$row[$skey];}
					} 
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEnding($strDataBody,$strHeader);
				
			}
		printr($aryGT,' $aryGT');
		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,$aRAUser['designation'], 0,1);
		//$this->printBarCodeONV();
		$this->Output($strRepTitle,'D');
   }   
 public function generalReportWArrayExO($aryColHeader,$aryData,$strTableTitle,$intWidth)
   {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->Ln(2);		
		$this->SetFont('helvetica', 'B', 14);		
		//$this->writeHTMLCell(0, 0, 95, $this->GetY()+4, $strTableTitle,0,1);
		$this->CheckPageEndingForTableTitle($strTableTitle,5);
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolName($aryColHeader,$intWidth);
		$this->CheckPageEndingForColHeads($strHeader);
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody='';
				$strDataBody.="<table width=\"".$intWidth."\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($row as $data)
				{
				$colWD='';
				if($aryColHeader[$i]['colWidth']!=null){$colWD="width=\"".$aryColHeader[$i]['colWidth']."\"";}	
				$strDataBody.="<td align=\"center\" ".$colWD." >".$data."</td>";
				$i++;
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEnding($strDataBody,$strHeader);
				
			}

		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);		
		
   }  
public function generalReportWArrayExOForPortarit($aryColHeader,$aryData,$strTableTitle,$arySelGdTotalKeys,$intWidth)
   {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->Ln(2);		
		$this->SetFont('helvetica', 'B', 11);		
		//$this->writeHTMLCell(0, 0, 95, $this->GetY()+4, $strTableTitle,0,1);
		$this->CheckPageEndingForTableTitleForPortrait($strTableTitle,5);
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolName($aryColHeader,$intWidth);
		$this->CheckPageEndingForColHeadsForPortrait($strHeader);
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody=$strDataBodyGT1='';
				$strDataBody.="<table width=\"".$intWidth."\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($row as $skey => $data)
				{
				$colWD='';
				if($aryColHeader[$i]['colWidth']!=null){$colWD="width=\"".$aryColHeader[$i]['colWidth']."\"";}	
				$strDataBody.="<td align=\"center\" ".$colWD." >".$data."</td>";
				$i++;
				
					
						if(is_array($arySelGdTotalKeys))
							{					
						  	if(in_array($skey, $arySelGdTotalKeys))
						  		{$aryGT[$skey]+=$row[$skey];$intGtotal+=$aryGT[$skey];}
						  	else
						  		{$aryGT[$skey]=null;$intGtotal+=$aryGT[$skey];}
							if($i>=2)  		
								{
								$strTT=empty($aryGT[$skey]) ? $aryGT[$skey] : withDecimal($aryGT[$skey]);
								$strDataBodyGT1.="<td align=\"center\" ".$colWD." >".$strTT."</td>";
								}
							else
								{$strDataBodyGT1.="<td align=\"center\" ".$colWD."  >Total</td>";}  		
					 }
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEndingForPortrait($strDataBody,$strHeader);
				
			}
		
			if(is_array($arySelGdTotalKeys) and $intGtotal>0)
				{	
					$strDataBodyGT='';
					$strDataBodyGTh="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";		
					$strDataBodyGTt="</tr></table>";	
					$strDataBodyGTpr=$strDataBodyGTh.$strDataBodyGT1.$strDataBodyGTt;
					$this->reportCheckPageEndingForPortrait($strDataBodyGTpr,$strHeader);	
				}
		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);		
		
   }  
  
public function generalHeading($strRepTitle=' REPORT',$strKSEBHeader=ORG_NAME)
{
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
		
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(10, 25, 16);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 18);		
		$this->writeHTMLCell(0, 0, 75, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,100,$this->GetY(),$aRAUser['role_office_name']." - ".$aRAUser['role_office_code'], 0,1);

		$this->SetFont('helvetica', 'B', 15);		
		$this->writeHTMLCell(0, 0, 105, $this->GetY()+4, $strRepTitle,0,1);

		#$this->SetFont('helvetica', 'B',11);
		#$this->Ln();		
		//$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		//$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
}  
public function generalHeadingFormat($strRepTitle=' REPORT',$strKSEBHeader=ORG_NAME)
{
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
		
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(10, 25, 16);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 16);		
		$this->writeHTMLCell(0, 0, 35, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,55,$this->GetY(),$aRAUser['role_office_name']." - ".$aRAUser['role_office_code'], 0,1);

		$this->SetFont('helvetica', 'BU', 13);		
		$this->writeHTMLCell(0, 0, 55, $this->GetY()+4, $strRepTitle,0,1);

		$this->SetFont('helvetica', 'B',11);
	//	$this->Ln();		
		//$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		//$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
}  
public function generalHeadingForPortrait($strRepTitle=' REPORT',$strKSEBHeader=ORG_NAME)
{
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
		
		$this->SetTitle($strRepTitle);
		//set margins
		$this->SetMargins(15, 25, 10);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 18);		
		$this->writeHTMLCell(0, 0, 35, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B',12);
		$this->writeHTMLCell(0,0,60,$this->GetY(),$aRAUser['role_office_name'], 0,1);

		$this->SetFont('helvetica', 'U', 14);		
		$this->writeHTMLCell(0, 0, 50, $this->GetY()+4, $strRepTitle,0,1);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		
		//$this->writeHTMLCell(0,0,$this->GetX()+85,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		//$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
} 
public function generalFooter($strFooterText='')
{
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
		
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,$aRAUser['designation'], 0,1);
		//$this->printBarCodeONV();
}
public function generalFooterForPortrait($strFooterText='')
{
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
		
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		//$this->writeHTMLCell(0,0,$this->GetX()+105,$this->GetY()-7,$aRAUser['designation'], 0,1);
		//$this->printBarCodeONV();
}
/**
$aryDBData --  two dimentional array.outer key 0,1,2 etc 
		(inner)	keys are taken as column name.
				 '_' will be replaced by next line
				 column name shall be repeated on top of each page.
  this function is specially meant to make pdf from selectall function returned array.
  while writing query ,do not use * but specify each data in required order and better use alias.
  arranged array can also be send.
*/
public function reportFromDBDataArray($aryDBData,$strRepTitle,$arySelGdTotalKeys=null,$strFooterText='',$isSerNo=true,$strKSEBHeader=ORG_NAME)
{    
		$aryColHeader=$this->genKeyToColStr($aryDBData,$isSerNo);
		if($isSerNo){$aryDBData=$this->addSerialNo($aryDBData);}
		$this->generalReportWArray($aryColHeader,$aryDBData,$strRepTitle,$arySelGdTotalKeys,$strFooterText,$strKSEBHeader);
		
}
public function reportFromDataArrayWithSelKeys($aryDBData,$strRepTitle,$arySelKeys=null,$strFooterText='',$isSerNo=true,$strKSEBHeader=ORG_NAME)
{		
		if($isSerNo){$aryDBData=$this->addSerialNo($aryDBData);}
		if($arySelKeys==null)
			{
				$aryColHeader=$this->genKeyToColStr($aryDBData,$isSerNo);
			  	$this->generalReportWArray($aryColHeader,$aryDBData,$strRepTitle,$strFooterText,$strKSEBHeader);				
			}
		else 
			{
				$aryColHeader=$this->genKeyToColStrWSelKeys($aryDBData,$arySelKeys,$isSerNo);	
				if($isSerNo){array_unshift($arySelKeys,'slno');}				
				//printr($arySelKeys);
				$this->generalReportFArrayWKeys($aryColHeader,$aryDBData,$arySelKeys,$strRepTitle,$strFooterText,$strKSEBHeader);
			}
}
/**
$aryMultiDBData --  three dimentional array.outer key 0,1,2 etc 
 sample
	$aryMultiDBData['table1']['table_title']='first Table';
	$aryMultiDBData['table1']['data']=$aryData;
	$aryMultiDBData['table1']['width']=100%;
	
	$aryMultiDBData['table2']['table_title']='Second table';
	$aryMultiDBData['table2']['data']=$aryData;
	$aryMultiDBData['table2']['width']=100%;
	
		(inner)	keys are taken as column name.
				 '_' will be replaced by next line
				 column name shall be repeated on top of each page.
  this function is specially meant to make pdf from selectall function returned array.
  while writing query ,do not use * but specify each data in required order and better use alias.
  arranged array can also be send.
*/
public function reportFromDBDataMultiArray($aryMultiDBData,$strRepTitle,$strFooterText='',$isSerNo=true,$strKSEBHeader=ORG_NAME)
{
	$this->generalHeading($strRepTitle,$strKSEBHeader);
	
	foreach($aryMultiDBData as $aryTables)
		{
		$strTableTitle=$aryTables['table_title'];
		$intWidth=nvl($aryTables['width'],'100%');
		$aryData=$aryTables['data'];
		$aryColHeader=$this->genKeyToColStr($aryData,$isSerNo);
		if($isSerNo){$aryData=$this->addSerialNo($aryData);}
		$this->generalReportWArrayExO($aryColHeader,$aryData,$strTableTitle,$intWidth);
		}
		$this->generalFooter($strFooterText);
		$this->Output($strRepTitle,'D');
}
/**
$aryMultiDBData --  three dimentional array.outer key 0,1,2 etc 
 sample
	$aryMultiDBData['table1']['table_title']='first Table';
	$aryMultiDBData['table1']['data']=$aryData;
	$aryMultiDBData['table1']['width']=100%;
	
	$aryMultiDBData['table2']['table_title']='Second table';
	$aryMultiDBData['table2']['data']=$aryData;
	$aryMultiDBData['table2']['width']=100%;
	
		(inner)	keys are taken as column name.
				 '_' will be replaced by next line
				 column name shall be repeated on top of each page.
  this function is specially meant to make pdf from selectall function returned array.
  while writing query ,do not use * but specify each data in required order and better use alias.
  arranged array can also be send.
*/
public function reportFromDBDataMultiArrayInPortrait($aryMultiDBData,$strRepTitle,$arySelGdTotalKeys=array(),$strFooterText='',$isSerNo=true,$strKSEBHeader=ORG_NAME)
{
	$this->generalHeadingForPortrait($strRepTitle,$strKSEBHeader);
	
	foreach($aryMultiDBData as $aryTables)
		{
		$strTableTitle=$aryTables['table_title'];
		$intWidth=nvl($aryTables['width'],'100%');
		$aryData=$aryTables['data'];
		$aryColHeader=$this->genKeyToColStr($aryData,$isSerNo);
		if($isSerNo){$aryData=$this->addSerialNo($aryData);}
		$this->generalReportWArrayExOForPortarit($aryColHeader,$aryData,$strTableTitle,$arySelGdTotalKeys,$intWidth);
		}
		$this->generalFooterForPortrait($strFooterText);
		$this->Output($strRepTitle,'D');
}
/**
		generates pdf from html string.
	$aryMultiHtmlStr[0]=htmlstring;
	$aryMultiHtmlStr[1]
	$aryMultiHtmlStr[2]
	note:no html string checking is done.so its likely that no output occurs if there is any defects is html
	testing defect pass a string or empty array as first parameter second a title then the required first html as third 		parameter.then check the html passed and correct it before passing it as first parameter.
*/
public function htmlStringToPdfFormat($aryMultiHtmlStr,$strRepTitle,$strFooterText='',$isSerNo=true,$strKSEBHeader=ORG_NAME,$strInfo)
{
	global $oDB,$aRAUser;
	$this->generalHeadingFormat($strRepTitle,$strKSEBHeader);
	
	foreach($aryMultiHtmlStr as $aryTables)
		{
			$this->SetFont('helvetica', 'N', 11);		
			//$this->SetFont('helvetica', 'B', 11);		
			$this->writeHTMLCell(0, 0, 40, $this->GetY()+4, $aryTables,0,1);
		}
	//	$this->SetFont('helvetica', 'B', 18);		
	
	//	$this->Ln();
		$this->writeHTMLCell(0, 0, 40, $this->GetY()+8,$strInfo,0,1);

	//	$this->generalFooter($strFooterText);
		$this->Ln(5);		
	//	$this->SetFont('helvetica', '',8);
	//	$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$strFooterText, 0,1);
		$this->Output($strRepTitle,'D');
}
public function htmlStringToPdf($aryMultiHtmlStr,$strRepTitle,$strFooterText='',$isSerNo=true,$strKSEBHeader=ORG_NAME)
{
	$this->generalHeading($strRepTitle,$strKSEBHeader);
	
	foreach($aryMultiHtmlStr as $aryTables)
		{
			$this->SetFont('helvetica', 'N', 10);		
			$this->writeHTMLCell(0, 0, 10, $this->GetY()+4, $aryTables,0,1);
		}
		$this->generalFooter($strFooterText);
		$this->Output($strRepTitle,'D');
}
public function genKeyToColStr($aryDBData,$isSerNo=true)
{
	$strColName='';
	if($isSerNo)
		{
			$aryColHName[0]['name']='Sl<br />No';
			$aryColHName[0]['colWidth']='4%';
		}
	foreach($aryDBData as $data)
	{
		$i=1;
		foreach($data as $key => $row)
		{
			$strKeyName[$i]=explode('_',$key);
			$j=0;
			foreach($strKeyName[$i] as $strNC)
			{
				$strColName[$i][$j]=ucfirst($strNC);
				$j++;
			}
			$aryColHName[$i]['name']=implode("<br />",$strColName[$i]);			
			$i++;
		}
		break;
	}
	 
		return $aryColHName;
}
public function genKeyToColStrWSelKeys($aryDBData,$arySelKeys,$isSerNo=true)
{
	$strColName='';
	if($isSerNo)
		{
			$aryColHName['slno']['name']='Sl<br />No';
			$aryColHName['slno']['colWidth']='4%';
		}
	foreach($aryDBData as $data)
	{
		$i=1;
		foreach($arySelKeys as $skey)
		{
			$strKeyName[$i]=explode('_',$skey);
			$j=0;
			foreach($strKeyName[$i] as $strNC)
			{
				$strColName[$i][$j]=ucfirst($strNC);
				$j++;
			}
			$aryColHName[$skey]['name']=implode("<br />",$strColName[$i]);			
			$i++;
		}
		break;
	}
	 
		return $aryColHName;
}
public function addSerialNo($aryDBData)
{
	$i=1;
	foreach($aryDBData as $key => $data)
		{
			$aryDBDataMD[$key]['slno']=$i;
			$aryDBDataMD[$key]=array_merge_recursive($aryDBDataMD[$key],$data);
			++$i;
		}
	
	return $aryDBDataMD;
}
public function genKeyToGrandToCol($aryDBData,$isSerNo=true)
{
	//printr($aryDBData,'$aryDBData');
	$strColName=$strKeyName='';
	$colspan=0;
	if($isSerNo)
		{
			$colspan=1;
		}
	foreach($aryDBData as $data)
	{
		$aryKeys=array_keys($data);	
		break;
	}
		printr($aryKeys,'$aryKeys');
		$i=1;$p=1;$j=0;$strKeyName=$aryColHName=array();
		
		foreach($aryKeys as $key => $row)
		{
			$strKeyName[$i]=explode('_',$row);	
			
			foreach($strKeyName[$i] as $strNC)
			{
				if($strNC=='code')
					{
						$intColSpan[$row]=$p;
						$p=0;$j++;
						break;
					}
			}				
			$i++;$p++;
		}
	
	 	printr($strKeyName,'$strKeyName');printr($intColSpan,'$strKeyName');		 	
		return $intColSpan;
}
public function printBarCodeONV()
   {
   	global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
   /*	
		// set default monospaced font
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set auto page breaks
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$this->setLanguageArray($l);
		
		$this->SetFont('helvetica', '', 10);
*/
		// define barcode style
		$style = array(
			 'position' => '',
			 'align' => 'C',
			 'stretch' => false,
			 'fitwidth' => true,
			 'cellfitalign' => '',
			 'border' => true,
			 'hpadding' => 'auto',
			 'vpadding' => 'auto',
			 'fgcolor' => array(0,0,0),
			 'bgcolor' => false, //array(255,255,255),
			 'text' => true,
			 'font' => 'helvetica',
			 'fontsize' => 8,
			 'stretchtext' => 4
				);
				
				// CODE 128 C
			//$this->Cell(0, 0, 'CODE 128 C', 0, 1);
			//$this->write1DBarcode('0123456789','C128C');
			// set a barcode on the page footer
			$this->setBarcode($aRAUser['cts']);
			
			
			$this->writeHTMLCell(0, 0, 10, $this->GetY(),$this->getBarcode(),0,1);
	}
	
function installmentDetailsPdf($aryColHeader)
{
	$strColWidth=$strColHead=$strDataBody="";
	$strTableHead= "<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\">";	
	$strColHead.="<tr>";

	foreach($aryColHeader as $colN)
	{
		$strColWidth="";		
		if(!empty($colN['colWidth'])){$strColWidth="width=\"".$colN['colWidth']."\"";}
		$strColHead.="<td align=\"center\" ".$strColWidth." >".$colN['name']."</td>";
	}	
		
		$strColHead.="</tr>";
		$strFooter=$strTableFoot= "</table>"; 		
		$strSampleTableHead=$strTableHead.$strColHead.$strFooter;
	
	return $strSampleTableHead;	
}
public function instFormat($aryColHeader=null,$aryData=null,$strRepTitle=' REPORT',$strFooterText='',$strKSEBHeader=ORG_NAME)
   {
		global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;

		//$this = new oTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// ---------------------------------------------------------
		$this->SetTitle('Meter PDF Report ');
		//set margins
		$this->SetMargins(10, 25, 16);//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(10);//$this->SetHeaderMargin(PDF_MARGIN_HEADER);

		$this->AddPage();$this->intAvailableLines=35;
		
		$this->SetFont('helvetica', 'B', 21);		
		$this->writeHTMLCell(0, 0, 75, $this->GetY(), $strKSEBHeader,0,1);

		$this->SetFont('helvetica', 'B', 14);		
		$this->writeHTMLCell(0, 0, 105, $this->GetY()+4, $strRepTitle,0,1);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY(),$aRAUser['role_office_name'], 0,1);
		$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,"Report Generated By :   ".$aRAUser['designation'], 0,1);
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		
		$this->SetFont('helvetica', '', 8);
		$this->Ln();
		$strHeader='';
		$strHeader=$this->htmlFromArraycolName($aryColHeader);
		$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strHeader, 0,1);
		//$this->write(5,$strHeader);
		foreach($aryData as $row)
			{
				$i=0;
				$strDataBody='';
				$strDataBody.="<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\"><tr>";
			foreach($row as $data)
				{
				$colWD='';
				if($aryColHeader[$i]['colWidth']!=null){$colWD="width=\"".$aryColHeader[$i]['colWidth']."\"";}	
				$strDataBody.="<td align=\"center\" ".$colWD." >".$data."</td>";
				$i++;
				}
				$strDataBody.="</tr></table>";
				
				//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strDataBody, 0,1);	
				//$this->MultiCell(0,4,$strDataBody);
				//$this->writeHTML($strDataBody1);
				$this->reportCheckPageEnding($strDataBody,$strHeader);
				
			}

		//$strFooter= htmlFromArrayFooter();
		//$this->writeHTMLCell(0,0,$this->GetX(),$this->GetY()-2,$strFooter, 0,1);
		$this->Ln(10);		
		$this->SetFont('helvetica', '',8);
		$this->write(4,$strFooterText);

		$this->SetFont('helvetica', 'B',11);
		$this->Ln();		
		$this->writeHTMLCell(0,0,12,$this->GetY()+26,"Place :  ".$aRAUser['user_office_place'], 0,1);		
		$this->writeHTMLCell(0,0,12,$this->GetY()-2,"Date :  ".$aRAUser['dmy_cts'], 0,1);
		$this->writeHTMLCell(0,0,$this->GetX()+155,$this->GetY()-7,$aRAUser['designation'], 0,1);
		//$this->printBarCodeONV();
		$this->Output($strRepTitle,'D');
   }
public function consumerHeaderPdf($aryConsInfo)
{
	global $oDB,$aRAUser,$aPostValues,$aFormValues,$aSuperKeys;
	
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Ln();
		$strHeader='';
		
	///---****consumer header	
		$strConsumerHeader.="<tr>
								 	<td align=\"left\" width=\"100%\"><B>Consumer Details</B></td>
								 </tr>
						<table width=\"100%\" cellpadding=\"3\" class=\"t1\" style=\"border:1px solid;\">";
		$strConsumerHeader.="								 
						<tr>
						 	<td align=\"left\" width=\"16%\">Consumer No</td>
						   <td align=\"center\" width=\"20%\">".$aryConsInfo['consumer_num']."</td>
								 
							<td align=\"left\" width=\"12%\">Name</td>	
							<td align=\"center\" width=\"20%\">".$aryConsInfo['customer_name']."</td>		
														 
							<td align=\"left\" width=\"12%\">SD</td>	
							<td align=\"right\" width=\"20%\">".$aryConsInfo['available_sd']."</td>									 
						</tr>
						<tr>
						    <td align=\"left\" width=\"16%\">Status/Tariff/Phase</td>
						    <td align=\"center\" width=\"20%\">".$aryConsInfo['cons_stat_code']."/".$aryConsInfo['tariff_code']."/".$aryConsInfo['cphase']."Ph</td>
						 	 <td align=\"left\" width=\"12%\">Purpose</td>	
						    <td align=\"center\" width=\"20%\">".$aryConsInfo['purpose']."</td>		
						    <td align=\"left\" width=\"12%\">Advance</td>	
				          <td align=\"right\" width=\"20%\">".$aryConsInfo['available_adv']."</td>									 
						</tr>
						<tr>								 
								 <td align=\"left\" width=\"16%\">CLoad/CDemand</td>	
						       <td align=\"center\" width=\"20%\">Normal</td>							
						       <td align=\"left\" width=\"12%\">Address</td>	
						       <td align=\"center\" width=\"20%\">".$aryConsInfo['']."</td>	
						       <td align=\"left\" width=\"12%\">CC Dues</td>	
						       <td align=\"right\" width=\"20%\">".$aryConsInfo['']."</td>									 		 
						 </tr>
						 <tr>								 
								 <td align=\"left\" width=\"16%\">Area/Day</td>	
						       <td align=\"center\" width=\"20%\">Normal</td>							
						       <td align=\"left\" width=\"12%\">Legacy#/DOC</td>	
						       <td align=\"center\" width=\"20%\">".$aryConsInfo['legacy_cons_num']."/".$aryConsInfo['doc']."</td>	
						       <td align=\"left\" width=\"12%\">Other Dues</td>	
						       <td align=\"right\" width=\"20%\">".$aryConsInfo['other_dues']."</td>									 		 
						 </tr>
		";
		$strConsumerHeader.="</table>";
		$pdf->writeHTMLCell(0,0,$pdf->GetX(),$pdf->GetY()+5,$strConsumerHeader, 0,1);
		//$pdf->writeHTML($strConsumerHeader);
		//$pdf->write(4,$strConsumerHeader);
		return;	
		
}      
}//end of class
?>
