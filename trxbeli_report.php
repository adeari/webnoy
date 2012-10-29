<?php

//Include Common Files @1-4014F3A4
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "trxbeli_report.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_trxbeli_reportSearch { //m_trxbeli_reportSearch Class @2-7972187D

//Variables @2-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $Errors;
    var $ErrorBlock;
    var $FormEnctype;
    var $IsEmpty;


    var $RelativePath = "";

    var $ds;
    var $DataSource;

    // Class variables
//End Variables

//Class_Initialize Event @2-5CCA453A
    function clsRecordm_trxbeli_reportSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_trxbeli_reportSearch/Error";
        $this->ReadAllowed = true;
		
        if($this->Visible)
        {
			$this->DataSource = new clsm_trxbeli_atas($this);
			$this->ds = & $this->DataSource;
            $this->ComponentName = "m_trxbeli_reportSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;

			 
			$this->tanggalprint = & new clsControl(ccsLabel, "tanggalprint", "tanggalprint", ccsText, "", NULL, $this);
			$this->tanggal = & new clsControl(ccsLabel, "tanggal", "tanggal", ccsText, "", NULL, $this);
			$this->nota = & new clsControl(ccsTextBox, "nota", "nota", ccsText, "", CCGetRequestParam("nota", $Method, NULL), $this);
			$this->kd_sup = & new clsControl(ccsLabel, "kd_sup", "kd_sup", ccsText, "", NULL, $this);
			$this->nama_sup = & new clsControl(ccsLabel, "nama_sup", "nama_sup", ccsText, "", NULL, $this);
			$this->alamat = & new clsControl(ccsLabel, "alamat", "alamat", ccsText, "", NULL, $this);
			$this->tlp = & new clsControl(ccsLabel, "tlp", "tlp", ccsText, "", NULL, $this);

			$this->kd_brg = & new clsControl(ccsLabel, "kd_brg", "kd_brg", ccsText, "", NULL, $this);
			$this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "", NULL, $this);
			$this->stok = & new clsControl(ccsLabel, "stok", "stok", ccsText, "", NULL, $this);
			$this->hrg_beli = & new clsControl(ccsLabel, "hrg_beli", "hrg_beli", ccsText, "", NULL, $this);
			$this->hrg_jual_grosir = & new clsControl(ccsLabel, "hrg_jual_grosir", "hrg_jual_grosir", ccsText, "", NULL, $this);
			$this->hrg_jual_retail = & new clsControl(ccsLabel, "hrg_jual_retail", "hrg_jual_retail", ccsText, "", NULL, $this);
			$this->totalbeli = & new clsControl(ccsLabel, "totalbeli", "totalbeli", ccsText, "", NULL, $this);
			
        }
    }
//End Class_Initialize Event


//Show Method @2-568DDF12
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;

$this->DataSource->Open();
 if ($this->DataSource->has_next_record()) {
	 $this->DataSource->next_record();
	$this->DataSource->SetValues();
	$this->tanggal->SetValue($this->DataSource->tanggal->GetValue());
	$this->tanggal->Show();
	$this->kd_sup->SetValue($this->DataSource->kd_sup->GetValue());
	$this->kd_sup->Show();
	$this->nama_sup->SetValue($this->DataSource->nama_sup->GetValue());
	$this->nama_sup->Show();
	$this->alamat->SetValue($this->DataSource->alamat->GetValue());
	$this->alamat->Show();
	$this->tlp->SetValue($this->DataSource->tlp->GetValue());
	$this->tlp->Show();
	
 }
		$this->nota->Show();
		$this->tanggalprint->SetValue(date('d/m/Y'));
		$this->tanggalprint->Show();



        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
$this->DataSource->close();

    }
//End Show Method

} //End m_trxbeli_reportSearch Class @2-FCB6E20C

class clsGridm_trxbeli_report { //m_trxbeli_report class @9-8624B687

//Variables @9-0159DF74

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $IsEmpty;
    var $ForceIteration = false;
    var $HasRecord = false;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";
    var $Attributes;

//End Variables

//Class_Initialize Event @9-7CEF8FA3
    function clsGridm_trxbeli_report($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "m_trxbeli_report";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid m_trxbeli_report";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsm_trxbeli_reportDataSource($this);
        $this->ds = & $this->DataSource;

		$this->kd_brg = & new clsControl(ccsLabel, "kd_brg", "kd_brg", ccsText, "", CCGetRequestParam("kd_brg", ccsGet, NULL), $this);
		$this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "", CCGetRequestParam("nama_brg", ccsGet, NULL), $this);
		$this->stok = & new clsControl(ccsLabel, "stok", "stok", ccsText, "", CCGetRequestParam("stok", ccsGet, NULL), $this);
		$this->hrg_beli = & new clsControl(ccsLabel, "hrg_beli", "hrg_beli", ccsText, "", CCGetRequestParam("hrg_beli", ccsGet, NULL), $this);
		$this->hrg_jual_retail = & new clsControl(ccsLabel, "hrg_jual_retail", "hrg_jual_retail", ccsText, "", CCGetRequestParam("hrg_jual_retail", ccsGet, NULL), $this);
		$this->hrg_jual_grosir = & new clsControl(ccsLabel, "hrg_jual_grosir", "hrg_jual_grosir", ccsText, "", CCGetRequestParam("hrg_jual_grosir", ccsGet, NULL), $this);
		$this->totalbeli = & new clsControl(ccsLabel, "totalbeli", "totalbeli", ccsText, "", CCGetRequestParam("totalbeli", ccsGet, NULL), $this);
		$this->totalitas = & new clsControl(ccsLabel, "totalitas", "totalitas", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event



//Show Method @9-3EABC7D3
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["kd_brg"] = $this->kd_brg->Visible;
            $this->ControlsVisible["stok"] = $this->stok->Visible;
            $this->ControlsVisible["hrg_beli"] = $this->hrg_beli->Visible;
            $this->ControlsVisible["hrg_jual_grosir"] = $this->hrg_jual_grosir->Visible;
            $this->ControlsVisible["hrg_jual_retail"] = $this->hrg_jual_retail->Visible;
			$this->ControlsVisible["nama_brg"] = $this->nama_brg->Visible;
			$this->ControlsVisible["totalbeli"] = $this->totalbeli->Visible;
			$this->ControlsVisible["totalitas"] = $this->totalitas->Visible;
			$totalitasnya=0;
            while ($this->DataSource->has_next_record()) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->kd_brg->SetValue($this->DataSource->kd_brg->GetValue());
                $this->stok->SetValue($this->DataSource->stok->GetValue());
                $this->hrg_beli->SetValue($this->DataSource->kd_hrgbeli->GetValue());
                $this->hrg_jual_retail->SetValue($this->DataSource->hrg_jual_retail->GetValue());
                $this->hrg_jual_grosir->SetValue($this->DataSource->hrg_jual_grosir->GetValue());
				$this->nama_brg->SetValue($this->DataSource->nama_brg->GetValue());
				$this->totalbeli->SetValue($this->DataSource->totalbeli->GetValue());
				$totalitasnya+=$this->DataSource->totalbelix->GetValue();
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->kd_brg->Show();
                $this->stok->Show();
				$this->nama_brg->Show();
                $this->hrg_beli->Show();
                $this->hrg_jual_retail->Show();
                $this->hrg_jual_grosir->Show();
				$this->totalbeli->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
			$this->totalitas->SetValue(number_format($totalitasnya, 0, ',', '.'));
$this->totalitas->Show();
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End m_trxbeli_report Class @9-FCB6E20C

class clsm_trxbeli_atas extends clsDBMyCon { 
	 var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;

	var $tanggal;
	var $kd_sup;
	var $nama_sup;
	var $alamat;
	var $tlp;
	function clsm_trxbeli_atas(& $Parent)
    {
		$this->Parent = & $Parent;
        $this->Initialize();

		$this->tanggal = new clsField("tanggal", ccsText, "");
		$this->kd_sup = new clsField("kd_sup", ccsText, "");
		$this->nama_sup = new clsField("nama_sup", ccsText, "");
		$this->alamat = new clsField("alamat", ccsText, "");
		$this->tlp = new clsField("tlp", ccsText, "");
	}

	function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
		$this->Where ="a.nota='".CCGetRequestParam("nota", ccsGet, NULL)."'";
        $this->SQL = "SELECT date_format(a.tanggal,'%d/%m/%Y') as tanggal,a.kd_sup,a.nota,b.nama_sup,b.alamat,b.tlp from tb_trxbeli a join tb_suplier b on a.kd_sup=b.kd_sup  {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where,"")));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
	function SetValues()
    {
		$this->tanggal->SetDBValue($this->f("tanggal"));
        $this->kd_sup->SetDBValue($this->f("kd_sup"));
		$this->nama_sup->SetDBValue($this->f("nama_sup"));
		$this->alamat->SetDBValue($this->f("alamat"));
		$this->tlp->SetDBValue($this->f("tlp"));
    }

}

class clsm_trxbeli_reportDataSource extends clsDBMyCon {  //m_trxbeli_reportDataSource Class @9-9E707F87

//DataSource Variables @9-4D96F272
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $kd_brg; 
	var $stok; 
	var $satuan; 
	var $kd_hrgbeli; 
	var $hrg_jual_retail; 
	var $hrg_jual_grosir; 
	var $totalbeli;var $nama_brg;
	var $totalbelix;
//End DataSource Variables

//DataSourceClass_Initialize Event @9-FFB13F34
    function clsm_trxbeli_reportDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid m_trxbeli_report";
        $this->Initialize();

        $this->kd_brg = new clsField("kd_brg", ccsText, "");
        $this->stok = new clsField("stok", ccsText, "");
        $this->satuan = new clsField("satuan", ccsText, "");
        $this->kd_hrgbeli = new clsField("kd_hrgbeli", ccsText, "");
        $this->hrg_jual_retail = new clsField("hrg_jual_retail", ccsText, "");
		$this->hrg_jual_grosir = new clsField("hrg_jual_grosir", ccsText, "");
		$this->totalbeli = new clsField("totalbeli", ccsText, "");
		$this->totalbelix = new clsField("totalbelix", ccsText, "");
		$this->nama_brg = new clsField("nama_brg", ccsText, "");
		
    }



//Open Method @9-6109A04B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) FROM tb_trxbeli1 a join tb_barang b on a.kd_brg=b.kd_brg";
        $this->SQL = "SELECT a.kd_brg,format(a.stok,0) as stok, a.kd_hrgbeli,b.hrg_beli,format(a.hrg_jual_grosir,0) as hrg_jual_grosir,format(a.hrg_jual_retail,0) as hrg_jual_retail,format(a.totalbeli,0) as totalbeli,b.satuan,b.nama_brg,a.totalbeli as totalbelix  FROM tb_trxbeli1 a join tb_barang b on a.kd_brg=b.kd_brg {SQL_Where} {SQL_OrderBy}";
		$this->Order = "b.nama_brg";
		$this->Where ="a.nota='".CCGetRequestParam("nota", ccsGet, NULL)."'";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @9-74A10F72
function setuang($str) {	
	return str_replace(",",".",$str);
}
function s1kode($kode)
{
	$balik="";
	if (strcmp($kode,"1")==0) $balik="X";
	else if (strcmp($kode,"2")==0) $balik="Z";
	else if (strcmp($kode,"3")==0) $balik="E";
	else if (strcmp($kode,"4")==0) $balik="A";
	else if (strcmp($kode,"5")==0) $balik="S";
	else if (strcmp($kode,"6")==0) $balik="G";
	else if (strcmp($kode,"7")==0) $balik="T";
	else if (strcmp($kode,"8")==0) $balik="B";
	else if (strcmp($kode,"9")==0) $balik="R";
	return $balik;
}

function pengkodean($data)
{
	$balik="";
	$panjang=strlen($data);
	$x=0;
	
	while ($x<$panjang)
	{
		$karakter=substr($data,$x,1);
		if (strcmp($karakter,"0")==0)
		{
			$ada0=true;
			$lanjut=$x+1;
			$itung=1;
			while ($ada0&&$lanjut<$panjang)
			{
				$karakter=substr($data,$lanjut,1);
				if (strcmp($karakter,"0")!=0)  $ada0=false; 
				else {$x=$lanjut; $lanjut++; $itung++;}
			}
			if ($itung==1) $balik.="C";
			else $balik.=$itung;
			
		}
		else $balik.=$this->s1kode($karakter);
		$x++;
	}
	return $balik;
}

    function SetValues()
    {
        $this->kd_brg->SetDBValue($this->f("kd_brg"));
        $this->stok->SetDBValue($this->setuang($this->f("stok"))." ".$this->f("satuan"));
        $this->kd_hrgbeli->SetDBValue($this->pengkodean($this->f("hrg_beli")));
		$this->hrg_jual_grosir->SetDBValue($this->setuang($this->f("hrg_jual_grosir")));
		$this->hrg_jual_retail->SetDBValue($this->setuang($this->f("hrg_jual_retail")));
		$this->totalbeli->SetDBValue($this->setuang($this->f("totalbeli")));
		$this->totalbelix->SetDBValue($this->f("totalbelix"));
		$this->nama_brg->SetDBValue($this->f("nama_brg"));
    }
//End SetValues Method

} //End m_trxbeli_reportDataSource Class @9-FCB6E20C

//Initialize Page @1-78621521
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "trxbeli_report.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-EB9C94FD
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-2E4F3332
$DBMyCon = new clsDBMyCon();
$MainPage->Connections["MyCon"] = & $DBMyCon;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$m_trxbeli_reportSearch = & new clsRecordm_trxbeli_reportSearch("", $MainPage);
$m_trxbeli_report = & new clsGridm_trxbeli_report("", $MainPage);
$MainPage->m_trxbeli_reportSearch = & $m_trxbeli_reportSearch;
$MainPage->m_trxbeli_report = & $m_trxbeli_report;

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-E710DB26
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template


//Go to destination page @1-B05353EC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBMyCon->close();
    header("Location: " . $Redirect);
    unset($m_trxbeli_reportSearch);
    unset($m_trxbeli_report);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-83AFB2D3
$m_trxbeli_reportSearch->Show();
$m_trxbeli_report->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-72672DC4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBMyCon->close();
unset($m_trxbeli_reportSearch);
unset($m_trxbeli_report);
unset($Tpl);
//End Unload Page
?>
