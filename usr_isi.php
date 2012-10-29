<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-3D998539
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "usr_isi.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_sys_user { //m_sys_user Class @2-517D2D68

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
	var $CancelAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;
    var $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-078993BB
    function clsRecordm_sys_user($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_sys_user/Error";
        $this->DataSource = new clsm_sys_userDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
		$this->CancelAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "m_sys_user";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = & new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = & new clsButton("Button_Delete", $Method, $this);			
			$this->Button_Cancel = & new clsButton("Button_Cancel", $Method, $this);
			$this->aktivekah = & new clsControl(ccsCheckBox, "aktivekah", "aktivekah", ccsBoolean, "", CCGetRequestParam("aktivekah", $Method, NULL), $this);
			$this->aktivekah->CheckedValue = true;
			$this->aktivekah->UncheckedValue = false;
            $this->aktivekah->Required = true;           
            $this->passwordnya = & new clsControl(ccsTextBox, "passwordnya", "passwordnya", ccsText, "", CCGetRequestParam("passwordnya", $Method, NULL), $this);
            $this->passwordnya->Required = true;
            $this->namanya = & new clsControl(ccsTextBox, "namanya", "namanya", ccsText, "", CCGetRequestParam("namanya", $Method, NULL), $this);
            $this->namanya->Required = true;
            $this->kd_user = & new clsControl(ccsTextBox, "kd_user", $CCSLocales->GetText("Text1"), ccsText, "", CCGetRequestParam("kd_user", $Method, NULL), $this);
            $this->kd_user->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-7EBC7CF7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlkd_user"] = CCGetFromGet("kd_user", NULL);
    }
//End Initialize Method

//Validate Method @2-869B3DAC
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->passwordnya->Validate() && $Validation);
        $Validation = ($this->namanya->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->passwordnya->Errors->Count() == 0);
        $Validation =  $Validation && ($this->namanya->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-E37BA021
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->passwordnya->Errors->Count());
        $errors = ($errors || $this->namanya->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
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

//Operation Method @2-805416FA
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "usr_list.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }  
		} else if($this->PressedButton == "Button_Cancel") {
			if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel) )
						$Redirect = "";
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
			} 
        }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @2-BC7EBE1D
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
		$this->DataSource->aktivekah->SetValue($this->aktivekah->GetValue(true));
        $this->DataSource->passwordnya->SetValue($this->passwordnya->GetValue(true));
        $this->DataSource->namanya->SetValue($this->namanya->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-6AB30596
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
		$this->DataSource->aktivekah->SetValue($this->aktivekah->GetValue(true));
        $this->DataSource->passwordnya->SetValue($this->passwordnya->GetValue(true));
        $this->DataSource->namanya->SetValue($this->namanya->GetValue(true));
        $this->DataSource->kd_user->SetValue($this->kd_user->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

	function Cancelaja()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }

//Show Method @2-75630EA0
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
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
					$this->aktivekah->SetValue($this->DataSource->aktivekah->GetValue());
                    $this->passwordnya->SetValue($this->DataSource->passwordnya->GetValue());
                    $this->namanya->SetValue($this->DataSource->namanya->GetValue());
                    $this->kd_user->SetValue($this->DataSource->kd_user->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
			$Error = ComposeStrings($Error, $this->aktivekah->Errors->ToString());
            $Error = ComposeStrings($Error, $this->passwordnya->Errors->ToString());
            $Error = ComposeStrings($Error, $this->namanya->Errors->ToString());
            $Error = ComposeStrings($Error, $this->kd_user->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;		
		$this->Button_Cancel->Visible = $this->CancelAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        
		
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
		$this->Button_Insert->Show();
		$this->Button_Cancel->Show();
		$this->aktivekah->Show();
        $this->passwordnya->Show();
        $this->namanya->Show();
        $this->kd_user->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End m_sys_user Class @2-FCB6E20C

class clsm_sys_userDataSource extends clsDBMyCon {  //m_sys_userDataSource Class @2-9E707F87

//DataSource Variables @2-2E9F0F19
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    var $InsertFields = array();
    var $UpdateFields = array();

    // Datasource fields
	var $aktivekah;
    var $passwordnya;
    var $namanya;
    var $kd_user;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-4D840E43
    function clsm_sys_userDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record m_sys_user/Error";
        $this->Initialize();
		
		$this->kd_user = new clsField("kd_user", ccsText, "");

		$this->aktivekah = new clsField("aktivekah", ccsBoolean, $this->BooleanFormat);
        
        $this->passwordnya = new clsField("passwordnya", ccsText, "");
        
        $this->namanya = new clsField("namanya", ccsText, "");
        
		$this->InsertFields["aktivekah"] = array("Name" => "aktivekah", "Value" => "", "DataType" => ccsBoolean, "OmitIfEmpty" => 1);
        $this->InsertFields["passwordnya"] = array("Name" => "passwordnya", "Value" => "", "DataType" => ccsDatenow, "OmitIfEmpty" => 1);
        $this->InsertFields["namanya"] = array("Name" => "namanya", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);  
		$this->UpdateFields["aktivekah"] = array("Name" => "aktivekah", "Value" => "", "DataType" => ccsBoolean, "OmitIfEmpty" => 1);
        $this->UpdateFields["passwordnya"] = array("Name" => "passwordnya", "Value" => "", "DataType" => ccsDatenow, "OmitIfEmpty" => 1);
        $this->UpdateFields["namanya"] = array("Name" => "namanya", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1EF17CE9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlkd_user", ccsText, "", "", $this->Parameters["urlkd_user"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "kd_user", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-34AAD597
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT kd_user,namanya,passwordnya,aktivekah \n\n" .
        "FROM tb_user {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-87F6E076
    function SetValues()
    {
		$this->aktivekah->SetDBValue($this->f("aktivekah"));
        $this->passwordnya->SetDBValue($this->f("passwordnya"));
        $this->namanya->SetDBValue($this->f("namanya"));
        $this->kd_user->SetDBValue($this->f("kd_user"));
    }
//End SetValues Method

//Insert Method @2-B90AA189
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["passwordnya"]["Value"] = "md5('".$this->passwordnya->GetDBValue(true)."')";
        $this->InsertFields["namanya"]["Value"] = $this->namanya->GetDBValue(true);
		$this->InsertFields["aktivekah"]["Value"] = $this->aktivekah->GetDBValue(true);
        $this->SQL = CCBuildInsert("tb_user", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-F5617834
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["passwordnya"]["Value"] = "md5('".$this->passwordnya->GetDBValue(true)."')";
        $this->UpdateFields["namanya"]["Value"] = $this->namanya->GetDBValue(true);
		$this->UpdateFields["aktivekah"]["Value"] = $this->aktivekah->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tb_user", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @2-6C1BE75C
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM tb_user";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End m_sys_userDataSource Class @2-FCB6E20C

//Include Page implementation @12-8EACA429
include_once(RelativePath . "/footer.php");
include_once(RelativePath . "/left.php");
include_once(RelativePath . "/header.php");
//End Include Page implementation

//Initialize Page @1-C92263A1
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
$TemplateFileName = "usr_isi.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A5502F9C
$DBMyCon = new clsDBMyCon();
$MainPage->Connections["MyCon"] = & $DBMyCon;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$m_sys_user = & new clsRecordm_sys_user("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_sys_user = & $m_sys_user;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_sys_user->Initialize();

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

//Execute Components @1-4CC17685
$m_sys_user->Operation();
$footer->Operations();
$left->Operations();
$header->Operations();
//End Execute Components

//Go to destination page @1-2CBB37FC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBMyCon->close();
    header("Location: " . $Redirect);
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

//Show Page @1-1091E253
$m_sys_user->Show();
$footer->Show();
$left->Show();
$header->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$PBTKNKD10A9N9A4G = ">retnec/<>tnof/<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($PBTKNKD10A9N9A4G) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($PBTKNKD10A9N9A4G) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($PBTKNKD10A9N9A4G);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-1E45F0CD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBMyCon->close();
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
