<?php

//Include Common Files @1-4014F3A4
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "cetaklabarugi.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_cetaklabarugiSearch { //m_cetaklabarugiSearch Class @2-7972187D

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
    function clsRecordm_cetaklabarugiSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_cetaklabarugiSearch/Error";
        $this->ReadAllowed = true;
		
        if($this->Visible)
        {
			$this->DataSource = new clsm_trxbeli_atas($this);
			$this->ds = & $this->DataSource;
            $this->ComponentName = "m_cetaklabarugiSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;

			 
			$this->tanggalprint = & new clsControl(ccsLabel, "tanggalprint", "tanggalprint", ccsText, "", NULL, $this);
			$this->tanggal1 = & new clsControl(ccsLabel, "tanggal1", "tanggal1", ccsText, "", CCGetRequestParam("s", $Method, NULL), $this);
			$this->tanggal2 = & new clsControl(ccsLabel, "tanggal2", "tanggal2", ccsText, "", CCGetRequestParam("ii", $Method, NULL), $this);
			

			$this->kd_brg = & new clsControl(ccsLabel, "kd_brg", "kd_brg", ccsText, "", NULL, $this);
			$this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "", NULL, $this);
			$this->stok = & new clsControl(ccsLabel, "stok", "stok", ccsText, "", NULL, $this);
			$this->hrg_beli = & new clsControl(ccsLabel, "hrg_beli", "hrg_beli", ccsText, "", NULL, $this);
			$this->hrg_jual = & new clsControl(ccsLabel, "hrg_jual", "hrg_jual", ccsText, "", NULL, $this);
			$this->selisih = & new clsControl(ccsLabel, "selisih", "selisih", ccsText, "", NULL, $this);
			
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

		$this->tanggal1->Show();
		$this->tanggal2->Show();
		$this->tanggalprint->SetValue(date('d/m/Y'));
		$this->tanggalprint->Show();



        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
$this->DataSource->close();

    }
//End Show Method

} //End m_cetaklabarugiSearch Class @2-FCB6E20C

class clsGridm_cetaklabarugi { //m_cetaklabarugi class @9-8624B687

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
    function clsGridm_cetaklabarugi($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "m_cetaklabarugi";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid m_cetaklabarugi";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsm_cetaklabarugiDataSource($this);
        $this->ds = & $this->DataSource;

		$this->kd_brg = & new clsControl(ccsLabel, "kd_brg", "kd_brg", ccsText, "", CCGetRequestParam("kd_brg", ccsGet, NULL), $this);
		$this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "", CCGetRequestParam("nama_brg", ccsGet, NULL), $this);
		$this->stok = & new clsControl(ccsLabel, "stok", "stok", ccsText, "", CCGetRequestParam("stok", ccsGet, NULL), $this);
		$this->hrg_beli = & new clsControl(ccsLabel, "hrg_beli", "hrg_beli", ccsText, "", CCGetRequestParam("hrg_beli", ccsGet, NULL), $this);
		$this->hrg_jual = & new clsControl(ccsLabel, "hrg_jual", "hrg_jual", ccsText, "", CCGetRequestParam("hrg_jual", ccsGet, NULL), $this);
		$this->selisih = & new clsControl(ccsLabel, "selisih", "selisih", ccsText, "", CCGetRequestParam("selisih", ccsGet, NULL), $this);
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
            $this->ControlsVisible["hrg_jual"] = $this->hrg_jual->Visible;
			$this->ControlsVisible["nama_brg"] = $this->nama_brg->Visible;
			$this->ControlsVisible["selisih"] = $this->selisih->Visible;
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
                $this->hrg_jual->SetValue($this->DataSource->hrg_jual->GetValue());
				$this->nama_brg->SetValue($this->DataSource->nama_brg->GetValue());
				$this->selisih->SetValue($this->DataSource->selisih->GetValue());
				$totalitasnya+=$this->DataSource->selisihx->GetValue();
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->kd_brg->Show();
                $this->stok->Show();
				$this->nama_brg->Show();
                $this->hrg_beli->Show();
                $this->hrg_jual->Show();
				$this->selisih->Show();
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

} //End m_cetaklabarugi Class @9-FCB6E20C

class clsm_trxbeli_atas extends clsDBMyCon { 
	 var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;

	var $tanggal;
	var $kd_sup;
	var $nama_sup;
	var $alamat;
	var $tlp;
	var $fax;
	var $ket;
	function clsm_trxbeli_atas(& $Parent)
    {
		$this->Parent = & $Parent;
        $this->Initialize();

		$this->tanggal = new clsField("tanggal", ccsText, "");
		$this->kd_sup = new clsField("kd_sup", ccsText, "");
		$this->nama_sup = new clsField("nama_sup", ccsText, "");
		$this->alamat = new clsField("alamat", ccsText, "");
		$this->tlp = new clsField("tlp", ccsText, "");
		$this->fax = new clsField("fax", ccsText, "");
		$this->ket = new clsField("ket", ccsText, "");
	}

	function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
		$this->Where ="a.nota='".CCGetRequestParam("nota", ccsGet, NULL)."'";
        $this->SQL = "SELECT date_format(a.tanggal,'%d/%m/%Y') as tanggal,a.kd_sup,a.nota,b.nama_sup,b.alamat,b.tlp,b.fax,b.ket from tb_trxjual a join tb_suplier b on a.kd_sup=b.kd_sup  {SQL_Where} {SQL_OrderBy}";
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
		$this->fax->SetDBValue($this->f("fax"));
		$this->ket->SetDBValue($this->f("ket"));
    }

}

class clsm_cetaklabarugiDataSource extends clsDBMyCon {  //m_cetaklabarugiDataSource Class @9-9E707F87

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
	var $hrg_jual; 
	var $selisih;var $nama_brg;
	var $selisihx;
	var $barang;
//End DataSource Variables

//DataSourceClass_Initialize Event @9-FFB13F34
    function clsm_cetaklabarugiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid m_cetaklabarugi";
        $this->Initialize();

        $this->kd_brg = new clsField("kd_brg", ccsText, "");
        $this->stok = new clsField("stok", ccsText, "");
        $this->satuan = new clsField("satuan", ccsText, "");
        $this->kd_hrgbeli = new clsField("kd_hrgbeli", ccsText, "");
        $this->hrg_jual = new clsField("hrg_jual", ccsText, "");
		$this->selisih = new clsField("selisih", ccsText, "");
		$this->selisihx = new clsField("selisihz", ccsText, "");
		$this->nama_brg = new clsField("nama_brg", ccsText, "");
		
    }



//Open Method @9-6109A04B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) FROM tb_trxjual1 a join tb_barang b on a.kd_brg=b.kd_brg";
        $this->SQL = "SELECT c.tanggal,a.kd_brg,format(a.stok,0) as stok, a.kd_hrgbeli,format(a.hrg_jual,0) as hrg_jual,format(a.selisih,0) as selisih,selisih as selisihx,b.satuan,b.nama_brg,b.hrg_beli  FROM tb_trxjual1 a join tb_barang b on a.kd_brg=b.kd_brg join tb_trxjual c on a.nota=c.nota {SQL_Where} {SQL_OrderBy}";
		$this->Order = "b.nama_brg";
		$this->barang="";
		if (strlen(CCGetFromGet("jojo", NULL))>0)
			$this->barang=" a.kd_brg='".CCGetFromGet("jojo", NULL)."' ";
		if (strlen($this->barang)>0&&strlen(CCGetFromGet("joji", NULL))>0)
			$this->barang.=" or b.nama_brg like '%".CCGetFromGet("joji", NULL)."%' ";
		else if (strlen(CCGetFromGet("joji", NULL))>0)
			$this->barang=" b.nama_brg like '%".CCGetFromGet("joji", NULL)."%' ";
		if (strlen($this->barang)>0)
			$this->barang=" and (".$this->barang.") ";		
		$this->Where =" c.tanggal between STR_TO_DATE('".CCGetFromGet("s", NULL)."', '%d/%m/%Y') and STR_TO_DATE('".CCGetFromGet("ii", NULL)."', '%d/%m/%Y') ".$this->barang;
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
		$this->hrg_jual->SetDBValue($this->setuang($this->f("hrg_jual")));
		$this->selisih->SetDBValue($this->setuang($this->f("selisih")));
		$this->selisihx->SetDBValue($this->f("selisihx"));
		$this->nama_brg->SetDBValue($this->f("nama_brg"));
    }
//End SetValues Method

} //End m_cetaklabarugiDataSource Class @9-FCB6E20C

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
$TemplateFileName = "cetaklabarugi.html";
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
$m_cetaklabarugiSearch = & new clsRecordm_cetaklabarugiSearch("", $MainPage);
$m_cetaklabarugi = & new clsGridm_cetaklabarugi("", $MainPage);
$MainPage->m_cetaklabarugiSearch = & $m_cetaklabarugiSearch;
$MainPage->m_cetaklabarugi = & $m_cetaklabarugi;

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
    unset($m_cetaklabarugiSearch);
    unset($m_cetaklabarugi);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-83AFB2D3
$m_cetaklabarugiSearch->Show();
$m_cetaklabarugi->Show();
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
unset($m_cetaklabarugiSearch);
unset($m_cetaklabarugi);
unset($Tpl);
//End Unload Page
?>
