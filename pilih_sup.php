<?php
//Include Common Files @1-1D80B609
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "pilih_sup.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordpilih_nama_supSearch { //pilih_nama_supSearch Class @8-EFB2F51A

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
    function clsRecordpilih_nama_supSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record pilih_nama_supSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "pilih_nama_supSearch";
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
			$this->s_nama_sup = & new clsControl(ccsTextBox, "s_nama_sup", "s_nama_sup", ccsText, "", CCGetRequestParam("s_nama_sup", $Method, NULL), $this);
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
        $Validation = ($this->s_nama_sup->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_katanya->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_nama_sup->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @8-50309F58
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_katanya->Errors->Count());
        $errors = ($errors || $this->s_nama_sup->Errors->Count());
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
        $Redirect = "pilih_sup.php";
        if($this->Validate()) {
            if($this->PressedButton == "DoSearch") {
                $Redirect = "pilih_sup.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("DoSearch", "DoSearch_x", "DoSearch_y")));
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
            $Error = ComposeStrings($Error, $this->s_nama_sup->Errors->ToString());
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
        $this->s_nama_sup->Show();
		$this->nomor->Show();
        $this->DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End pilih_nama_supSearch Class @8-FCB6E20C

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

        $this->kd_sup = & new clsControl(ccsLink, "kd_sup", "kd_sup", ccsText, "", CCGetRequestParam("kd_sup", ccsGet, NULL), $this);
        $this->kd_sup->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->kd_sup->Page = "";
        $this->nama_sup = & new clsControl(ccsLabel, "nama_sup", "nama_sup", ccsText, "", CCGetRequestParam("nama_sup", ccsGet, NULL), $this);
		$this->alamat = & new clsControl(ccsLabel, "alamat", "alamat", ccsText, "", CCGetRequestParam("alamat", ccsGet, NULL), $this);
		$this->tlp = & new clsControl(ccsLabel, "tlp", "tlp", ccsText, "", CCGetRequestParam("tlp", ccsGet, NULL), $this);
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

        $this->DataSource->Parameters["urls_nama_sup"] = CCGetFromGet("s_nama_sup", NULL);

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
            $this->ControlsVisible["kd_sup"] = $this->kd_sup->Visible;
            $this->ControlsVisible["nama_sup"] = $this->nama_sup->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->kd_sup->SetValue($this->DataSource->kd_sup->GetValue());
                $this->nama_sup->SetValue($this->DataSource->nama_sup->GetValue());
				$this->tlp->SetValue($this->DataSource->tlp->GetValue());
				$this->alamat->SetValue($this->DataSource->alamat->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->kd_sup->Show();
                $this->nama_sup->Show();
				$this->alamat->Show();
				$this->tlp->Show();
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
        $errors = ComposeStrings($errors, $this->kd_sup->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nama_sup->Errors->ToString());
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
    var $kd_sup;
    var $nama_sup;
	var $alamat;
	var $tlp;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-0B44C16D
    function clsemployeesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid employees";
        $this->Initialize();
        $this->kd_sup = new clsField("kd_sup", ccsText, "");
        
        $this->nama_sup = new clsField("nama_sup", ccsText, ""); 
		$this->alamat = new clsField("alamat", ccsText, ""); 
		$this->tlp = new clsField("tlp", ccsText, ""); 

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-1912387C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "nama_sup";
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
        $this->CountSQL = "SELECT COUNT(*) FROM tb_suplier";
         $this->SQL = "select kd_sup,nama_sup,alamat,tlp FROM tb_suplier {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @2-F11C59A9
    function SetValues()
    {
        $this->kd_sup->SetDBValue($this->f("kd_sup"));
        $this->nama_sup->SetDBValue($this->f("nama_sup"));
		$this->alamat->SetDBValue($this->f("alamat"));
		$this->tlp->SetDBValue($this->f("tlp"));
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
$TemplateFileName = "pilih_sup.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
//End Initialize Page

//Include events file @1-E9BFA3BA
include_once("./pilih_sup_events.php");
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
$pilih_nama_supSearch = & new clsRecordpilih_nama_supSearch("", $MainPage);
$employees = & new clsGridemployees("", $MainPage);
$MainPage->Link1 = & $Link1;
$MainPage->pilih_nama_supSearch = & $pilih_nama_supSearch;
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
$pilih_nama_supSearch->Operation();
//End Execute Components

//Go to destination page @1-0C77BF57
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBIntranetDB->close();
    header("Location: " . $Redirect);
    unset($pilih_nama_supSearch);
    unset($employees);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E87EBA2A
$pilih_nama_supSearch->Show();
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
unset($pilih_nama_supSearch);
unset($employees);
unset($Tpl);
//End Unload Page


?>
