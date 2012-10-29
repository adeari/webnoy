<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-4014F3A4
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "kostumer_list.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_kostumerSearch { //m_kostumerSearch Class @2-7972187D

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
    function clsRecordm_kostumerSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_kostumerSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "m_kostumerSearch";
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
        $Redirect = "kostumer_list.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "kostumer_list.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
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

} //End m_kostumerSearch Class @2-FCB6E20C

class clsGridm_kostumer { //m_kostumer class @9-8624B687

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
    var $Sorter_kd_kos;
    var $Sorter_nama_kos;
	var $Sorter_tel;
//End Variables

//Class_Initialize Event @9-7CEF8FA3
    function clsGridm_kostumer($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "m_kostumer";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid m_kostumer";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsm_kostumerDataSource($this);
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
        $this->SorterName = CCGetParam("m_kostumerOrder", "");
        $this->SorterDirection = CCGetParam("m_kostumerDir", "");

        $this->kd_kos = & new clsControl(ccsLink, "kd_kos", "kd_kos", ccsText, "", CCGetRequestParam("kd_kos", ccsGet, NULL), $this);
        $this->kd_kos->Page = "kostumer_isi.php";
        $this->nama_kos = & new clsControl(ccsLabel, "nama_kos", "nama_kos", ccsText, "", CCGetRequestParam("nama_kos", ccsGet, NULL), $this);
        $this->alamat = & new clsControl(ccsLabel, "alamat", "alamat", ccsText, "", CCGetRequestParam("alamat", ccsGet, NULL), $this);
		$this->tlp = & new clsControl(ccsLabel, "tlp", "tlp", ccsText, "", CCGetRequestParam("tlp", ccsGet, NULL), $this);
        $this->m_kostumer_Insert = & new clsControl(ccsLink, "m_kostumer_Insert", "m_kostumer_Insert", ccsText, "", CCGetRequestParam("m_kostumer_Insert", ccsGet, NULL), $this);
        $this->m_kostumer_Insert->Parameters = CCGetQueryString("QueryString", array("kd_kos", "ccsForm"));
        $this->m_kostumer_Insert->Page = "kostumer_isi.php";
        $this->Sorter_kd_kos = & new clsSorter($this->ComponentName, "Sorter_kd_kos", $FileName, $this);
        $this->Sorter_nama_kos = & new clsSorter($this->ComponentName, "Sorter_nama_kos", $FileName, $this);
        $this->Sorter_alamat = & new clsSorter($this->ComponentName, "Sorter_alamat", $FileName, $this);
		$this->Sorter_tlp = & new clsSorter($this->ComponentName, "Sorter_tlp", $FileName, $this);		
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
            $this->ControlsVisible["kd_kos"] = $this->kd_kos->Visible;
            $this->ControlsVisible["nama_kos"] = $this->nama_kos->Visible;
            $this->ControlsVisible["alamat"] = $this->alamat->Visible;
			$this->ControlsVisible["tlp"] = $this->tlp->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->kd_kos->SetValue($this->DataSource->kd_kos->GetValue());
                $this->kd_kos->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->kd_kos->Parameters = CCAddParam($this->kd_kos->Parameters, "kd_kos", $this->DataSource->f("kd_kos"));
                $this->nama_kos->SetValue($this->DataSource->nama_kos->GetValue());
                $this->alamat->SetValue($this->DataSource->alamat->GetValue());
				$this->tlp->SetValue($this->DataSource->tlp->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->kd_kos->Show();
                $this->nama_kos->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->m_kostumer_Insert->Show();
        $this->Sorter_kd_kos->Show();
        $this->Sorter_nama_kos->Show();
        $this->Sorter_alamat->Show();
		$this->Sorter_tlp->Show();
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
        $errors = ComposeStrings($errors, $this->kd_kos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nama_kos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->alamat->Errors->ToString());
		$errors = ComposeStrings($errors, $this->tlp->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End m_kostumer Class @9-FCB6E20C

class clsm_kostumerDataSource extends clsDBMyCon {  //m_kostumerDataSource Class @9-9E707F87

//DataSource Variables @9-4D96F272
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $kd_kos;
    var $nama_kos;
    var $alamat;
	var $tlp;
//End DataSource Variables

//DataSourceClass_Initialize Event @9-FFB13F34
    function clsm_kostumerDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid m_kostumer";
        $this->Initialize();
        $this->kd_kos = new clsField("kd_kos", ccsText, "");
        $this->nama_kos = new clsField("nama_kos", ccsText, "");
        $this->alamat = new clsField("alamat", ccsText, "");
		$this->tlp = new clsField("tlp", ccsText, "");
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @9-828F292A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_kd_kos" => array("kd_kos", ""), 
            "Sorter_nama_kos" => array("nama_kos", ""), 
            "Sorter_alamat" => array("alamat", ""),
			"Sorter_tlp" => array("tlp", ""),
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
		$this->wp->AddParameter("4", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
		
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "kd_kos", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "nama_kos", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "alamat", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
		$this->wp->Criterion[4] = $this->wp->Operation(opContains, "tlp", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->Where = $this->wp->opOR(
             false, $this->wp->opOR(
             false, $this->wp->opOR(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @9-6109A04B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tb_kostumer";
        $this->SQL = "SELECT kd_kos,nama_kos,alamat,tlp FROM tb_kostumer {SQL_Where} {SQL_OrderBy}";
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
    function SetValues()
    {
		$this->kd_kos->SetDBValue($this->f("kd_kos"));
        $this->nama_kos->SetDBValue($this->f("nama_kos"));
        $this->alamat->SetDBValue($this->f("alamat"));
		$this->tlp->SetDBValue($this->f("tlp"));
    }
//End SetValues Method

} //End m_kostumerDataSource Class @9-FCB6E20C

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
$TemplateFileName = "kostumer_list.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-EB9C94FD
include_once("./kostumer_list_events.php");
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
$m_kostumerSearch = & new clsRecordm_kostumerSearch("", $MainPage);
$m_kostumer = & new clsGridm_kostumer("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_kostumerSearch = & $m_kostumerSearch;
$MainPage->m_kostumer = & $m_kostumer;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_kostumer->Initialize();

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
$m_kostumerSearch->Operation();
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
    unset($m_kostumerSearch);
    unset($m_kostumer);
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
$m_kostumerSearch->Show();
$m_kostumer->Show();
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
unset($m_kostumerSearch);
unset($m_kostumer);
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
