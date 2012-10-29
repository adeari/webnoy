<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-3D998539
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "suplier_isi.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_suplier { //m_suplier Class @2-517D2D68

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
    function clsRecordm_suplier($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_suplier/Error";
        $this->DataSource = new clsm_suplierDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
		$this->CancelAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "m_suplier";
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
			$this->active = & new clsControl(ccsCheckBox, "active", "active", ccsBoolean, "", CCGetRequestParam("active", $Method, NULL), $this);
            $this->kd_sup = & new clsControl(ccsTextBox, "kd_sup", $CCSLocales->GetText("Text1"), ccsText, "", CCGetRequestParam("kd_sup", $Method, NULL), $this);
            $this->kd_sup->Required = true;
			$this->nama_sup = & new clsControl(ccsTextBox, "nama_sup", "nama_sup", ccsText, "", CCGetRequestParam("nama_sup", $Method, NULL), $this);
            $this->nama_sup->Required = true;
			$this->alamat = & new clsControl(ccsTextBox, "alamat", "alamat", ccsText, "", CCGetRequestParam("alamat", $Method, NULL), $this);
            $this->alamat->Required = true;
			$this->tlp = & new clsControl(ccsTextBox, "tlp", "tlp", ccsText, "", CCGetRequestParam("tlp", $Method, NULL), $this);
            $this->tlp->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-7EBC7CF7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlkd_sup"] = CCGetFromGet("kd_sup", NULL);
    }
//End Initialize Method

//Validate Method @2-869B3DAC
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
       
        $Validation = ($this->kd_sup->Validate() && $Validation);
		$Validation = ($this->nama_sup->Validate() && $Validation);
		$Validation = ($this->alamat->Validate() && $Validation);
		$Validation = ($this->tlp->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        
        $Validation =  $Validation && ($this->kd_sup->Errors->Count() == 0);
		$Validation =  $Validation && ($this->nama_sup->Errors->Count() == 0);
		$Validation =  $Validation && ($this->alamat->Errors->Count() == 0);
		$Validation =  $Validation && ($this->tlp->Errors->Count() == 0);


        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-E37BA021
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->alamat->Errors->Count());
        $errors = ($errors || $this->nama_sup->Errors->Count());
        $errors = ($errors || $this->kd_sup->Errors->Count());
		$errors = ($errors || $this->tlp->Errors->Count());
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
        $Redirect = "suplier_list.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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
        $this->DataSource->kd_sup->SetValue($this->kd_sup->GetValue(true));
		$this->DataSource->nama_sup->SetValue($this->nama_sup->GetValue(true));
		$this->DataSource->alamat->SetValue($this->alamat->GetValue(true));
		$this->DataSource->tlp->SetValue($this->tlp->GetValue(true));
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
        $this->DataSource->kd_sup->SetValue($this->kd_sup->GetValue(true));
		$this->DataSource->nama_sup->SetValue($this->nama_sup->GetValue(true));
		$this->DataSource->alamat->SetValue($this->alamat->GetValue(true));
		$this->DataSource->tlp->SetValue($this->tlp->GetValue(true));
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
                    $this->kd_sup->SetValue($this->DataSource->kd_sup->GetValue());
					$this->nama_sup->SetValue($this->DataSource->nama_sup->GetValue());
					$this->alamat->SetValue($this->DataSource->alamat->GetValue());
					$this->tlp->SetValue($this->DataSource->tlp->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";			
            $Error = ComposeStrings($Error, $this->kd_sup->Errors->ToString());
			$Error = ComposeStrings($Error, $this->nama_sup->Errors->ToString());
			$Error = ComposeStrings($Error, $this->alamat->Errors->ToString());
			$Error = ComposeStrings($Error, $this->tlp->Errors->ToString());
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
        $this->kd_sup->Show();
		$this->nama_sup->Show();
		$this->alamat->Show();
		$this->tlp->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End m_suplier Class @2-FCB6E20C

class clsm_suplierDataSource extends clsDBMyCon {  //m_suplierDataSource Class @2-9E707F87

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
	var $active;
    var $keterangan;
    var $suplier;
    var $kd_sup;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-4D840E43
    function clsm_suplierDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record m_suplier/Error";
        $this->Initialize();
        $this->kd_sup = new clsField("kd_sup", ccsText, "");
		$this->nama_sup = new clsField("nama_sup", ccsText, "");
		$this->alamat = new clsField("alamat", ccsText, "");
		$this->tlp = new clsField("tlp", ccsText, "");     
		
        
        $this->InsertFields["kd_sup"] = array("Name" => "kd_sup", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->InsertFields["nama_sup"] = array("Name" => "nama_sup", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->InsertFields["alamat"] = array("Name" => "alamat", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->InsertFields["tlp"] = array("Name" => "tlp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["kd_sup"] = array("Name" => "kd_sup", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["nama_sup"] = array("Name" => "nama_sup", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["alamat"] = array("Name" => "alamat", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["tlp"] = array("Name" => "tlp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1EF17CE9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlkd_sup", ccsText, "", "", $this->Parameters["urlkd_sup"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "kd_sup", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-34AAD597
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT kd_sup,nama_sup,alamat,tlp FROM tb_suplier {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-87F6E076
    function SetValues()
    {
		$this->tlp->SetDBValue($this->f("tlp"));
        $this->alamat->SetDBValue($this->f("alamat"));
        $this->nama_sup->SetDBValue($this->f("nama_sup"));
        $this->kd_sup->SetDBValue($this->f("kd_sup"));
    }
//End SetValues Method

//Insert Method @2-B90AA189
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["alamat"]["Value"] = $this->alamat->GetDBValue(true);
        $this->InsertFields["nama_sup"]["Value"] = $this->nama_sup->GetDBValue(true);
        $this->InsertFields["kd_sup"]["Value"] = $this->kd_sup->GetDBValue(true);
		$this->InsertFields["tlp"]["Value"] = $this->tlp->GetDBValue(true);
        $this->SQL = CCBuildInsert("tb_suplier", $this->InsertFields, $this);
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
		$this->UpdateFields["alamat"]["Value"] = $this->alamat->GetDBValue(true);
        $this->UpdateFields["nama_sup"]["Value"] = $this->nama_sup->GetDBValue(true);
        $this->UpdateFields["kd_sup"]["Value"] = $this->kd_sup->GetDBValue(true);
		$this->UpdateFields["tlp"]["Value"] = $this->tlp->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tb_suplier", $this->UpdateFields, $this);
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
        $this->SQL = "DELETE FROM tb_suplier";
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

} //End m_suplierDataSource Class @2-FCB6E20C

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
$TemplateFileName = "suplier_isi.html";
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
$m_suplier = & new clsRecordm_suplier("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_suplier = & $m_suplier;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_suplier->Initialize();

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
$m_suplier->Operation();
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
    unset($m_suplier);
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
$m_suplier->Show();
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
unset($m_suplier);
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
