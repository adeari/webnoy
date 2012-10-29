<?php
//Include Common Files @1-1D80B609
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "pilih_barangj.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordpilih_nama_brgSearch { //pilih_nama_brgSearch Class @8-EFB2F51A

//Variables @8-D6FF3E86

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

//Class_Initialize Event @8-61F517FD
    function clsRecordpilih_nama_brgSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record pilih_nama_brgSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "pilih_nama_brgSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
			$this->nomor = & new clsControl(ccsTextBox, "nomor", "nomor", ccsText, "", CCGetRequestParam("nomor", $Method, NULL), $this);
            $this->s_katanya = & new clsControl(ccsTextBox, "s_katanya", "s_katanya", ccsText, "", CCGetRequestParam("s_katanya", $Method, NULL), $this);
			$this->s_nama_brg = & new clsControl(ccsTextBox, "s_nama_brg", "s_nama_brg", ccsText, "", CCGetRequestParam("s_nama_brg", $Method, NULL), $this);
            $this->DoSearch = & new clsButton("DoSearch", $Method, $this);			
			
        }
    }
//End Class_Initialize Event

//Validate Method @8-D66FF3C9
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_katanya->Validate() && $Validation);
        $Validation = ($this->s_nama_brg->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_katanya->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_nama_brg->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @8-50309F58
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_katanya->Errors->Count());
        $errors = ($errors || $this->s_nama_brg->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @8-ED598703
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

//Operation Method @8-16919BF1
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
            $this->PressedButton = "DoSearch";
            if($this->DoSearch->Pressed) {
                $this->PressedButton = "DoSearch";
            }
        }
        $Redirect = "pilih_barangj.php";
        if($this->Validate()) {
            if($this->PressedButton == "DoSearch") {
                $Redirect = "pilih_barangj.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("DoSearch", "DoSearch_x", "DoSearch_y")));
                if(!CCGetEvent($this->DoSearch->CCSEvents, "OnClick", $this->DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @8-17E06891
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_katanya->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_nama_brg->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
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

        $this->s_katanya->Show();
        $this->s_nama_brg->Show();
		$this->nomor->Show();
        $this->DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End pilih_nama_brgSearch Class @8-FCB6E20C

class clsGridemployees { //employees class @2-C14505EF

//Variables @2-AC1EDBB9

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
//End Variables

//Class_Initialize Event @2-097D282C
    function clsGridemployees($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "employees";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid employees";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsemployeesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

		$this->kd_brg = & new clsControl(ccsLabel, "kd_brg", "kd_brg", ccsText, "", CCGetRequestParam("kd_brg", ccsGet, NULL), $this);
        $this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "", CCGetRequestParam("nama_brg", ccsGet, NULL), $this);
		$this->stok = & new clsControl(ccsLabel, "stok", "stok", ccsText, "", CCGetRequestParam("stok", ccsGet, NULL), $this);
		$this->stoknya = & new clsControl(ccsLabel, "stoknya", "stoknya", ccsText, "", CCGetRequestParam("stoknya", ccsGet, NULL), $this);
		$this->hrg_beli = & new clsControl(ccsLabel, "hrg_beli", "hrg_beli", ccsText, "", CCGetRequestParam("hrg_beli", ccsGet, NULL), $this);
		$this->hrg_belinya = & new clsControl(ccsLabel, "hrg_belinya", "hrg_belinya", ccsText, "", CCGetRequestParam("hrg_belinya", ccsGet, NULL), $this);


		$this->hrg_jual_retail = & new clsControl(ccsLink, "hrg_jual_retail", "hrg_jual_retail", ccsText, "", CCGetRequestParam("hrg_jual_retail", ccsGet, NULL), $this);
		$this->hrg_jual_retail->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
		$this->hrg_jual_retail->Page = "";

		$this->hrg_jual_grosir = & new clsControl(ccsLink, "hrg_jual_grosir", "hrg_jual_grosir", ccsText, "", CCGetRequestParam("hrg_jual_retail", ccsGet, NULL), $this);
		$this->hrg_jual_grosir->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
		$this->hrg_jual_grosir->Page = "";

		$this->kd_hrgbeli = & new clsControl(ccsLabel, "kd_hrgbeli", "kd_hrgbeli", ccsText, "", CCGetRequestParam("kd_hrgbeli", ccsGet, NULL), $this);	
		

		
        $this->Navigator1 = & new clsNavigator($this->ComponentName, "Navigator1", $FileName, 10, tpSimple, $this);
        $this->Navigator1->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-22CE2510
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_nama_brg"] = CCGetFromGet("s_nama_brg", NULL);

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
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->kd_brg->SetValue($this->DataSource->kd_brg->GetValue());
                $this->nama_brg->SetValue($this->DataSource->nama_brg->GetValue());
				$this->kd_hrgbeli->SetValue($this->DataSource->kd_hrgbeli->GetValue());
				$this->stok->SetValue($this->DataSource->stoknya->GetValue());
				$this->stoknya->SetValue($this->DataSource->stok->GetValue());
				$this->hrg_beli->SetValue($this->DataSource->hrg_belinya->GetValue());
				$this->hrg_belinya->SetValue($this->DataSource->hrg_beli->GetValue());
				$this->hrg_jual_retail->SetValue($this->DataSource->hrg_jual_retailnya->GetValue());
				$this->hrg_jual_grosir->SetValue($this->DataSource->hrg_jual_grosirnya->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->kd_brg->Show();
				$this->kd_hrgbeli->Show();
                $this->nama_brg->Show();
				$this->hrg_beli->Show();
				$this->hrg_belinya->Show();
				$this->hrg_jual_retail->Show();
				$this->hrg_jual_grosir->Show();
				$this->stok->Show();
				$this->stoknya->Show();
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
        $this->Navigator1->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator1->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator1->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator1->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator1->TotalPages <= 1) {
            $this->Navigator1->Visible = false;
        }
        $this->Navigator1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-9FB7B8C7
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->kd_brg->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nama_brg->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End employees Class @2-FCB6E20C

class clsemployeesDataSource extends clsDBIntranetDB {  //employeesDataSource Class @2-F9B4CEE0

//DataSource Variables @2-44DB6D3E
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
	var $satuan;
	var $hrg_beli;
	var $hrg_jual_grosir;
	var $hrg_jual_retail;
	var $stok;
	var $hrg_belinya;
	var $hrg_jual_grosirnya;
	var $hrg_jual_retailnya;
	var $stoknya;
	var $kd_hrgbeli;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-0B44C16D
    function clsemployeesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees";
        $this->Initialize();
        $this->kd_brg = new clsField("kd_brg", ccsText, "");
        
        $this->nama_brg = new clsField("nama_brg", ccsText, ""); 
		$this->hrg_beli = new clsField("hrg_beli", ccsText, ""); 
		$this->hrg_jual_grosir = new clsField("hrg_jual_grosir", ccsText, ""); 
		$this->hrg_jual_retail = new clsField("hrg_jual_retail", ccsText, ""); 
		$this->stok = new clsField("stok", ccsText, ""); 

		$this->hrg_belinya = new clsField("hrg_belinya", ccsText, ""); 
		$this->hrg_jual_grosirnya = new clsField("hrg_jual_grosirnya", ccsText, ""); 
		$this->hrg_jual_retailnya = new clsField("hrg_jual_retailnya", ccsText, ""); 
		$this->stoknya = new clsField("stoknya", ccsText, ""); 

		$this->kd_hrgbeli = new clsField("kd_hrgbeli", ccsText, "");

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-1912387C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "nama_brg";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-A5B27850
    function Prepare()
    {

    }
//End Prepare Method

//Open Method @2-5538DF5A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) FROM tb_barang";
         $this->SQL = "select kd_brg,nama_brg,satuan,hrg_beli,hrg_jual_grosir,hrg_jual_retail,stok,kd_hrgbeli,format(hrg_jual_retail,0) as hrg_jual_retailnya,format(hrg_jual_grosir,0) as hrg_jual_grosirnya,format(hrg_beli,0) as hrg_belinya,format(stok,0) as stoknya  FROM tb_barang {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

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


//SetValues Method @2-F11C59A9
    function SetValues()
    {
        $this->kd_brg->SetDBValue($this->f("kd_brg"));
		
		$this->kd_hrgbeli->SetDBValue($this->pengkodean($this->f("hrg_beli")));
        $this->nama_brg->SetDBValue($this->f("nama_brg"));
		$this->hrg_beli->SetDBValue($this->f("hrg_beli"));
		$this->hrg_jual_grosir->SetDBValue($this->f("hrg_jual_grosir"));
		$this->hrg_jual_retail->SetDBValue($this->f("hrg_jual_retail"));
		$this->stok->SetDBValue($this->f("stok"));

		$this->hrg_belinya->SetDBValue($this->setuang($this->f("kd_hrgbeli")));
		$this->hrg_jual_grosirnya->SetDBValue($this->setuang($this->f("hrg_jual_grosirnya")));
		$this->hrg_jual_retailnya->SetDBValue($this->setuang($this->f("hrg_jual_retailnya")));
		$this->stoknya->SetDBValue($this->setuang($this->f("stoknya"))." ".$this->f("satuan"));
    }
//End SetValues Method

} //End employeesDataSource Class @2-FCB6E20C

//Initialize Page @1-5B8E649E
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
$TemplateFileName = "pilih_barangj.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
//End Initialize Page

//Include events file @1-E9BFA3BA
include_once("./pilih_barangj_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F23EF911
$DBIntranetDB = new clsDBIntranetDB();
$MainPage->Connections["IntranetDB"] = & $DBIntranetDB;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $MainPage);
$Link1->Page = "";
$pilih_nama_brgSearch = & new clsRecordpilih_nama_brgSearch("", $MainPage);
$employees = & new clsGridemployees("", $MainPage);
$MainPage->Link1 = & $Link1;
$MainPage->pilih_nama_brgSearch = & $pilih_nama_brgSearch;
$MainPage->employees = & $employees;
$employees->Initialize();

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-9A11BEC1
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate();
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-F3F9865F
$pilih_nama_brgSearch->Operation();
//End Execute Components

//Go to destination page @1-0C77BF57
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBIntranetDB->close();
    header("Location: " . $Redirect);
    unset($pilih_nama_brgSearch);
    unset($employees);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E87EBA2A
$pilih_nama_brgSearch->Show();
$employees->Show();
$Link1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "" . "</html>", $main_block);
} 
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D1F0033E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBIntranetDB->close();
unset($pilih_nama_brgSearch);
unset($employees);
unset($Tpl);
//End Unload Page


?>
