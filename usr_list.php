<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-4014F3A4
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "usr_list.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_sys_userSearch { //m_sys_userSearch Class @2-7972187D

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
    function clsRecordm_sys_userSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_sys_userSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "m_sys_userSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_kd_user = & new clsControl(ccsTextBox, "s_kd_user", "s_kd_user", ccsText, "", CCGetRequestParam("s_kd_user", $Method, NULL), $this);
            $this->s_namanya = & new clsControl(ccsTextBox, "s_namanya", "s_namanya", ccsText, "", CCGetRequestParam("s_namanya", $Method, NULL), $this);
			$this->s_passwordnya = & new clsControl(ccsTextBox, "s_passwordnya", "s_passwordnya", ccsText, "", CCGetRequestParam("s_passwordnya", $Method, NULL), $this);			
			$this->s_aktivekah = & new clsControl(ccsCheckBox, "s_aktivekah", "s_aktivekah", ccsBoolean, "", CCGetRequestParam("s_aktivekah", $Method, NULL), $this);
			$this->s_aktivekah->CheckedValue = true;
			$this->s_aktivekah->UncheckedValue = false;
        }
    }
//End Class_Initialize Event

//Validate Method @2-DBC06141
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_namanya->Validate() && $Validation);
        $Validation = ($this->s_passwordnya->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_namanya->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_passwordnya->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-D1E899CF
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_namanya->Errors->Count());
        $errors = ($errors || $this->s_passwordnya->Errors->Count());
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
        $Redirect = "usr_list.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "usr_list.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_namanya->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_passwordnya->Errors->ToString());
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

        $this->Button_DoSearch->Show();
		$this->s_kd_user->Show();
        $this->s_namanya->Show();
        $this->s_passwordnya->Show();
		$this->s_aktivekah->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End m_sys_userSearch Class @2-FCB6E20C

class clsGridm_sys_user { //m_sys_user class @9-8624B687

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
    var $Sorter_namanya;
    var $Sorter_passwordnya;
//End Variables

//Class_Initialize Event @9-7CEF8FA3
    function clsGridm_sys_user($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "m_sys_user";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid m_sys_user";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsm_sys_userDataSource($this);
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
        $this->SorterName = CCGetParam("m_sys_userOrder", "");
        $this->SorterDirection = CCGetParam("m_sys_userDir", "");
		
		$this->namanya = & new clsControl(ccsLink, "namanya", "namanya", ccsText, "", CCGetRequestParam("namanya", ccsGet, NULL), $this);
        $this->kd_user->Page = "usr_isi.php";

        $this->kd_user = & new clsControl(ccsLabel, "kd_user", "kd_user", ccsText, "", CCGetRequestParam("kd_user", ccsGet, NULL), $this);
        
		$this->namanya->Page = "usr_isi.php";
        $this->passwordnya = & new clsControl(ccsLabel, "passwordnya", "passwordnya", ccsText, "", CCGetRequestParam("passwordnya", ccsGet, NULL), $this);
        $this->m_sys_user_Insert = & new clsControl(ccsLink, "m_sys_user_Insert", "m_sys_user_Insert", ccsText, "", CCGetRequestParam("m_sys_user_Insert", ccsGet, NULL), $this);
        $this->m_sys_user_Insert->Parameters = CCGetQueryString("QueryString", array("kd_user", "ccsForm"));
        $this->m_sys_user_Insert->Page = "usr_isi.php";
        $this->Sorter_kd_user = & new clsSorter($this->ComponentName, "Sorter_kd_user", $FileName, $this);
        $this->Sorter_namanya = & new clsSorter($this->ComponentName, "Sorter_namanya", $FileName, $this);
        $this->Sorter_passwordnya = & new clsSorter($this->ComponentName, "Sorter_passwordnya", $FileName, $this);
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

        $this->DataSource->Parameters["urls_kd_user"] = CCGetFromGet("s_kd_user", NULL);
        $this->DataSource->Parameters["urls_namanya"] = CCGetFromGet("s_namanya", NULL);
        $this->DataSource->Parameters["urls_passwordnya"] = CCGetFromGet("s_passwordnya", NULL);
		$this->DataSource->Parameters["urls_aktivekah"] = CCGetFromGet("s_aktivekah", NULL);
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
            $this->ControlsVisible["namanya"] = $this->namanya->Visible;
            $this->ControlsVisible["passwordnya"] = $this->passwordnya->Visible;
			$this->ControlsVisible["kd_user"] = $this->kd_user->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->namanya->SetValue($this->DataSource->namanya->GetValue());
				$this->kd_user->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
				$this->namanya->Parameters = CCAddParam($this->namanya->Parameters, "kd_user", $this->DataSource->f("kd_user"));
                $this->passwordnya->SetValue($this->DataSource->passwordnya->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->namanya->Show();
				$this->kd_user->Show();
                $this->passwordnya->Show();
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
        $this->m_sys_user_Insert->Show();
        $this->Sorter_kd_user->Show();
        $this->Sorter_namanya->Show();
        $this->Sorter_passwordnya->Show();
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
        $errors = ComposeStrings($errors, $this->namanya->Errors->ToString());
        $errors = ComposeStrings($errors, $this->passwordnya->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End m_sys_user Class @9-FCB6E20C

class clsm_sys_userDataSource extends clsDBMyCon {  //m_sys_userDataSource Class @9-9E707F87

//DataSource Variables @9-4D96F272
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $namanya;
    var $passwordnya;
//End DataSource Variables

//DataSourceClass_Initialize Event @9-FFB13F34
    function clsm_sys_userDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid m_sys_user";
        $this->Initialize();

		$this->kd_user = new clsField("kd_user", ccsText, "");
        
        $this->namanya = new clsField("namanya", ccsText, "");
        
        $this->passwordnya = new clsField("passwordnya", ccsText, "");
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @9-828F292A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_namanya" => array("namanya", ""), 
            "Sorter_passwordnya" => array("passwordnya", "")));
    }
//End SetOrder Method

//Prepare Method @9-71314EEE
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_namanya", ccsText, "", "", $this->Parameters["urls_namanya"], "", false);
        $this->wp->AddParameter("2", "urls_passwordnya", ccsText, "", "", $this->Parameters["urls_passwordnya"], "", false);
		$this->wp->AddParameter("3", "urls_aktivekah", ccsBoolean, "", "", $this->Parameters["urls_aktivekah"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "namanya", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "passwordnya", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
		$this->wp->Criterion[3] = $this->wp->Operation(opEqual, "aktivekah", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsCheckBox),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
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
        "FROM tb_user";
        $this->SQL = "SELECT kd_user,namanya,passwordnya \n\n" .
        "FROM tb_user {SQL_Where} {SQL_OrderBy}";
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
        $this->namanya->SetDBValue($this->f("namanya"));
        $this->passwordnya->SetDBValue($this->f("passwordnya"));
		$this->kd_user->SetDBValue($this->f("kd_user"));
    }
//End SetValues Method

} //End m_sys_userDataSource Class @9-FCB6E20C

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
$TemplateFileName = "usr_list.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-EB9C94FD
include_once("./usr_list_events.php");
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
$m_sys_userSearch = & new clsRecordm_sys_userSearch("", $MainPage);
$m_sys_user = & new clsGridm_sys_user("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_sys_userSearch = & $m_sys_userSearch;
$MainPage->m_sys_user = & $m_sys_user;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_sys_user->Initialize();

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
$m_sys_userSearch->Operation();
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
    unset($m_sys_userSearch);
    unset($m_sys_user);
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
$m_sys_userSearch->Show();
$m_sys_user->Show();
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
unset($m_sys_userSearch);
unset($m_sys_user);
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
