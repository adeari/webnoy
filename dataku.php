<?php
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "dataku.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");


class clsRecorddataku { //dataku Class @2-58926B8F

//Variables @2-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $Visible;
    var $IsEmpty;


    var $RelativePath = "";

  
    var $DataSource;
    function clsRecorddataku($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
       $this->hasil = & new clsControl(ccsLabel, "hasil", "hasil", ccsText, "", CCGetRequestParam("hasil", ccsGet, NULL), $hasil);
	   $this->kol = & new clsControl(ccsLabel, "kol", "kol", ccsText, "", CCGetRequestParam("kol", ccsPost, NULL), $hasil);
	   $this->kulik = & new clsControl(ccsLabel, "kulik", "kulik", ccsText, "", CCGetRequestParam("kulik", ccsPost, NULL), $hasil);
	   $this->DataSource = new datakuDataSource($this);
    }

//Show Method @2-7C2E8FDD
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);

		$this->DataSource->Prepare("namanya = '".$this->kol->GetValue(true)."' and passwordnya ='".$this->kulik->GetValue(true)."' and aktivekah");
		$this->DataSource->Open();
		if ($this->DataSource->next_record()) {
                    $this->DataSource->SetValues();
			$this->hasil->SetValue($this->DataSource->KD_USR->GetValue());
			$_SESSION['yangnakseswebini'] = $this->DataSource->KD_USR->GetValue();
		}
		else 
			$this->hasil->SetValue("kosong");

        $this->hasil->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End dataku Class @2-FCB6E20C

class datakuDataSource extends clsDBMyCon {
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $wp;
    var $AllParametersSet;


	var $KD_USR;

	function datakuDataSource(& $Parent)
    {
		$this->Parent = & $Parent;
        $this->Initialize();
		$this->KD_USR = new clsField("kd_user ", ccsText, "");
	}


	function Prepare($str)
    {
        $this->Where=$str;
    }

	function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT kd_user   FROM  tb_user  {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, "")));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
	function SetValues()
    {
		$this->KD_USR->SetDBValue($this->f("kd_user"));
    }
}



//Initialize Page @1-6D4FC047
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
$TemplateFileName = "dataku.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7161B2B9
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$dataku = & new clsRecorddataku("", $MainPage);
$MainPage->dataku = & $dataku;

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


//Go to destination page @1-20B4A31F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    unset($dataku);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D2344ABA
$dataku->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i",  "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "</html>", $main_block);
} 
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-33A4146F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
unset($dataku);
unset($Tpl);
//End Unload Page
?>
