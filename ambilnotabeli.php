<?php
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "ceknotajual.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");


class clsRecordceknotajual { //ceknotajual Class @2-58926B8F

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
    function clsRecordceknotajual($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
       $this->hasil = & new clsControl(ccsLabel, "hasil", "hasil", ccsText, "", CCGetRequestParam("hasil", ccsGet, NULL), $hasil);
	   $this->kol = & new clsControl(ccsLabel, "kol", "kol", ccsText, "", CCGetRequestParam("kol", ccsPost, NULL), $hasil);	
	   $this->DataSource = new ceknotajualDataSource($this);
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

		$kode=substr($this->kol->GetValue(true),0,2).substr($this->kol->GetValue(true),3,2).
			substr($this->kol->GetValue(true),8,2);
		
		$this->DataSource->Prepare("nota like '".$kode."%'");
		$this->DataSource->Open();
		if ($this->DataSource->next_record()) {
                    $this->DataSource->SetValues();
			$kangka=substr($this->DataSource->nota->GetValue(),6,4);
			$angka=intval($kangka)+1;
			$kangka="".$angka;
			do {
				$kangka="0".$kangka;
			} while (strlen($kangka)<4);
			$this->hasil->SetValue($kode.$kangka);
		}
		else 		
			$this->hasil->SetValue($kode."0001");
			//

        $this->hasil->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End ceknotajual Class @2-FCB6E20C

class ceknotajualDataSource extends clsDBMyCon {
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $wp;
    var $AllParametersSet;


	var $nota;

	function ceknotajualDataSource(& $Parent)
    {
		$this->Parent = & $Parent;
        $this->Initialize();
		$this->nota = new clsField("nota", ccsText, "");
	}


	function Prepare($str)
    {
        $this->Where=$str;
    }

	function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT max(nota) as nota   FROM  tb_trxbeli  {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, "")));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
	function SetValues()
    {
		$this->nota->SetDBValue($this->f("nota"));
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
$TemplateFileName = "ceknotajual.html";
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
$ceknotajual = & new clsRecordceknotajual("", $MainPage);
$MainPage->ceknotajual = & $ceknotajual;

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
    unset($ceknotajual);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D2344ABA
$ceknotajual->Show();
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
unset($ceknotajual);
unset($Tpl);
//End Unload Page
?>
