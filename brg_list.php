<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-4014F3A4
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "brg_list.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_brgSearch { //m_brgSearch Class @2-7972187D

//Variables @2-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormEnctype;
    var $Visible;
    var $IsEmpty;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;
    var $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-5CCA453A
    function clsRecordm_brgSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_brgSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "m_brgSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
			$this->s_keyword = & new clsControl(ccsTextBox, "s_keyword", "s_keyword", ccsText, "", CCGetRequestParam("s_keyword", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @2-DBC06141
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
		$Validation = ($this->s_keyword->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
		$Validation =  $Validation && ($this->s_keyword->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-D1E899CF
    function CheckErrors()
    {
        $errors = false;
		$errors = ($errors || $this->s_keyword->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @2-37A5AC5E
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "brg_list.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "brg_list.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @2-568DDF12
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_keyword->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End m_brgSearch Class @2-FCB6E20C

class clsGridm_brg { //m_brg class @9-8624B687

//Variables @9-0159DF74

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $IsEmpty;
    var $ForceIteration = false;
    var $HasRecord = false;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;
    var $RowNumber;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";
    var $Attributes;

    // Grid Controls
    var $StaticControls;
    var $RowControls;
    var $Sorter_kd_brg;
    var $Sorter_nama_brg;
    var $Sorter_kd_hrgbeli;
	var $Sorter_hrg_jual_grosir;
	var $Sorter_hrg_jual_retail;
	var $Sorter_stok;
//End Variables

//Class_Initialize Event @9-7CEF8FA3
    function clsGridm_brg($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "m_brg";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid m_brg";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsm_brgDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("m_brgOrder", "");
        $this->SorterDirection = CCGetParam("m_brgDir", "");

        $this->kd_brg = & new clsControl(ccsLink, "kd_brg", "kd_brg", ccsText, "", CCGetRequestParam("kd_brg", ccsGet, NULL), $this);
        $this->kd_brg->Page = "brg_isi.php";
        $this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "", CCGetRequestParam("nama_brg", ccsGet, NULL), $this);
        $this->kd_hrgbeli = & new clsControl(ccsLabel, "kd_hrgbeli", "kd_hrgbeli", ccsFloat, "", CCGetRequestParam("kd_hrgbeli", ccsGet, NULL), $this);
		$this->hrg_jual_grosir = & new clsControl(ccsLabel, "hrg_jual_grosir", "hrg_jual_grosir", ccsFloat, "", CCGetRequestParam("hrg_jual_grosir", ccsGet, NULL), $this);
		$this->hrg_jual_retail = & new clsControl(ccsLabel, "hrg_jual_retail", "hrg_jual_retail", ccsFloat, "", CCGetRequestParam("hrg_jual_retail", ccsGet, NULL), $this);
		$this->stok = & new clsControl(ccsLabel, "stok", "stok", ccsFloat, "", CCGetRequestParam("stok", ccsFloat, NULL), $this);
        $this->m_brg_Insert = & new clsControl(ccsLink, "m_brg_Insert", "m_brg_Insert", ccsText, "", CCGetRequestParam("m_brg_Insert", ccsGet, NULL), $this);
        $this->m_brg_Insert->Parameters = CCGetQueryString("QueryString", array("kd_brg", "ccsForm"));
        $this->m_brg_Insert->Page = "brg_isi.php";
        $this->Sorter_kd_brg = & new clsSorter($this->ComponentName, "Sorter_kd_brg", $FileName, $this);
		$this->Sorter_nama_brg = & new clsSorter($this->ComponentName, "Sorter_nama_brg", $FileName, $this);
        $this->Sorter_kd_hrgbeli = & new clsSorter($this->ComponentName, "Sorter_kd_hrgbeli", $FileName, $this);
        $this->Sorter_hrg_jual_grosir = & new clsSorter($this->ComponentName, "Sorter_hrg_jual_grosir", $FileName, $this);
		$this->Sorter_hrg_jual_retail = & new clsSorter($this->ComponentName, "Sorter_hrg_jual_retail", $FileName, $this);
		$this->Sorter_stok = & new clsSorter($this->ComponentName, "Sorter_stok", $FileName, $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @9-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @9-3EABC7D3
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_keyword"] = CCGetFromGet("s_keyword", NULL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
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
            $this->ControlsVisible["nama_brg"] = $this->nama_brg->Visible;
            $this->ControlsVisible["kd_hrgbeli"] = $this->kd_hrgbeli->Visible;
			$this->ControlsVisible["hrg_jual_retail"] = $this->hrg_jual_retail->Visible;
			$this->ControlsVisible["hrg_jual_grosir"] = $this->hrg_jual_grosir->Visible;
			$this->ControlsVisible["stok"] = $this->stok->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->kd_brg->SetValue($this->DataSource->kd_brg->GetValue());
                $this->kd_brg->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->kd_brg->Parameters = CCAddParam($this->kd_brg->Parameters, "kd_brg", $this->DataSource->f("kd_brg"));
                $this->nama_brg->SetValue($this->DataSource->nama_brg->GetValue());
                $this->kd_hrgbeli->SetValue($this->DataSource->kd_hrgbeli->GetValue());
				$this->hrg_jual_retail->SetValue($this->DataSource->hrg_jual_retailnya->GetValue());
				$this->hrg_jual_grosir->SetValue($this->DataSource->hrg_jual_grosirnya->GetValue());
				$this->stok->SetValue($this->DataSource->stoknya->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->kd_brg->Show();
                $this->nama_brg->Show();
                $this->kd_hrgbeli->Show();
				$this->hrg_jual_retail->Show();
				$this->hrg_jual_grosir->Show();
				$this->stok->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->m_brg_Insert->Show();
        $this->Sorter_kd_brg->Show();
        $this->Sorter_nama_brg->Show();
        $this->Sorter_kd_hrgbeli->Show();
		$this->Sorter_hrg_jual_grosir->Show();
		$this->Sorter_hrg_jual_retail->Show();
		$this->Sorter_stok->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @9-4E989ECF
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->kd_brg->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nama_brg->Errors->ToString());
        $errors = ComposeStrings($errors, $this->kd_hrgbeli->Errors->ToString());
		$errors = ComposeStrings($errors, $this->hrg_jual_grosir->Errors->ToString());
		$errors = ComposeStrings($errors, $this->hrg_jual_retail->Errors->ToString());
		$errors = ComposeStrings($errors, $this->stok->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End m_brg Class @9-FCB6E20C

class clsm_brgDataSource extends clsDBMyCon {  //m_brgDataSource Class @9-9E707F87

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
    var $nama_brg;
    var $kd_hrgbeli;
	var $hrg_beli;
	var $hrg_jual_grosir;
	var $hrg_jual_retail;
	var $stok;
	var $hrg_jual_grosirnya;
	var $hrg_jual_retailnya;
	var $stoknya;
//End DataSource Variables

//DataSourceClass_Initialize Event @9-FFB13F34
    function clsm_brgDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid m_brg";
        $this->Initialize();
        $this->kd_brg = new clsField("kd_brg", ccsText, "");
        $this->nama_brg = new clsField("nama_brg", ccsText, "");
        $this->kd_hrgbeli = new clsField("kd_hrgbeli", ccsText, "");
		$this->hrg_jual_grosir = new clsField("hrg_jual_grosir", ccsFloat, "");
		$this->hrg_jual_retail = new clsField("hrg_jual_retail", ccsFloat, "");
		$this->stok = new clsField("stok", ccsFloat, "");
		$this->hrg_jual_grosirnya = new clsField("hrg_jual_grosirnya", ccsText, "");
		$this->hrg_jual_retailnya = new clsField("hrg_jual_retailnya", ccsText, "");
		$this->stoknya = new clsField("stoknya", ccsText, "");

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @9-828F292A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_kd_brg" => array("kd_brg", ""), 
            "Sorter_nama_brg" => array("nama_brg", ""), 
            "Sorter_kd_hrgbeli" => array("hrg_beli", ""),
			"Sorter_hrg_jual_grosir" => array("hrg_jual_grosir", ""),
			"Sorter_hrg_jual_retail" => array("hrg_jual_retail", ""),
			"Sorter_stok" => array("stok", "")
			));
    }
//End SetOrder Method

//Prepare Method @9-71314EEE
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
		$this->wp->AddParameter("2", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
		$this->wp->AddParameter("3", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "kd_brg", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "nama_brg", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
		$this->wp->Criterion[3] = $this->wp->Operation(opContains, "satuan", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opOR(
             false, $this->wp->opOR(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]),
			$this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @9-6109A04B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tb_barang";
        $this->SQL = "SELECT kd_brg,nama_brg,kd_hrgbeli,hrg_beli,hrg_jual_grosir,hrg_jual_retail,stok,satuan,format(hrg_jual_grosir,0) as hrg_jual_grosirnya,format(hrg_jual_retail,0) as hrg_jual_retailnya,format(stok,0) as stoknya \n\n" .
        "FROM tb_barang {SQL_Where} {SQL_OrderBy}";
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
function setuang($str)
	{
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
        $this->nama_brg->SetDBValue($this->f("nama_brg"));
        $this->kd_hrgbeli->SetDBValue($this->pengkodean($this->f("hrg_beli")));
		$this->hrg_jual_grosir->SetDBValue($this->f("hrg_jual_grosir"));
		$this->hrg_jual_retail->SetDBValue($this->f("hrg_jual_retail"));
		$this->stok->SetDBValue($this->f("stok")." ".$this->f("satuan"));
		$this->hrg_jual_grosirnya->SetDBValue($this->setuang($this->f("hrg_jual_grosirnya")));
		$this->hrg_jual_retailnya->SetDBValue($this->setuang($this->f("hrg_jual_retailnya")));
		$this->stoknya->SetDBValue($this->setuang($this->f("stoknya")." ".$this->f("satuan")));
    }
//End SetValues Method

} //End m_brgDataSource Class @9-FCB6E20C

//Include Page implementation @35-8EACA429
include_once(RelativePath . "/footer.php");
include_once(RelativePath . "/left.php");
include_once(RelativePath . "/header.php");
//End Include Page implementation

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
$TemplateFileName = "brg_list.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-EB9C94FD
include_once("./brg_list_events.php");
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
$m_brgSearch = & new clsRecordm_brgSearch("", $MainPage);
$m_brg = & new clsGridm_brg("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_brgSearch = & $m_brgSearch;
$MainPage->m_brg = & $m_brg;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_brg->Initialize();

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

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

//Execute Components @1-67A29555
$m_brgSearch->Operation();
$footer->Operations();
$left->Operations();
$header->Operations();
//End Execute Components

//Go to destination page @1-B05353EC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBMyCon->close();
    header("Location: " . $Redirect);
    unset($m_brgSearch);
    unset($m_brg);
	$footer->Class_Terminate();
    unset($footer);
	$left->Class_Terminate();
    unset($left);
    $header->Class_Terminate();
    unset($header);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-83AFB2D3
$m_brgSearch->Show();
$m_brg->Show();
$footer->Show();
$left->Show();
$header->Show();
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
unset($m_brgSearch);
unset($m_brg);
$footer->Class_Terminate();
unset($footer);
$left->Class_Terminate();
unset($left);
$header->Class_Terminate();
unset($header);
unset($Tpl);
//End Unload Page

}
else 
header('Location: loginPg.php');
?>
