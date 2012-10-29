<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-3D998539
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "brg_isi.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_brg { //m_brg Class @2-517D2D68

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
    function clsRecordm_brg($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_brg/Error";
        $this->DataSource = new clsm_brgDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
		$this->CancelAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "m_brg";
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
            $this->kd_brg = & new clsControl(ccsTextBox, "kd_brg", $CCSLocales->GetText("Text1"), ccsText, "", CCGetRequestParam("kd_brg", $Method, NULL), $this);
            $this->kd_brg->Required = true;
			$this->nama_brg = & new clsControl(ccsTextBox, "nama_brg","nama_brg", ccsText, "", CCGetRequestParam("nama_brg", $Method, NULL), $this);
            $this->nama_brg->Required = true;
			$this->hrg_beli = & new clsControl(ccsTextBox, "hrg_beli", "hrg_beli", ccsFloat, "", str_replace (".","",CCGetRequestParam("hrg_beli", $Method, NULL)), $this);
            $this->hrg_beli->Required = true;
			$this->hrg_jual_grosir = & new clsControl(ccsTextBox, "hrg_jual_grosir", "hrg_jual_grosir", ccsFloat, "", str_replace (".","",CCGetRequestParam("hrg_jual_grosir", $Method, NULL)), $this);
            $this->hrg_jual_grosir->Required = true;
			$this->hrg_jual_retail = & new clsControl(ccsTextBox, "hrg_jual_retail", "hrg_jual_retail", ccsFloat, "", str_replace (".","",CCGetRequestParam("hrg_jual_retail", $Method, NULL)), $this);
            $this->hrg_jual_retail->Required = true;
			$this->stok = & new clsControl(ccsTextBox, "stok", "stok", ccsFloat, "", str_replace (".","",CCGetRequestParam("stok", $Method, NULL)), $this);
            $this->stok->Required = true;
			$this->satuan = & new clsControl(ccsTextBox, "satuan",  "satuan", ccsText, "", CCGetRequestParam("satuan", $Method, NULL), $this);
            $this->satuan->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-7EBC7CF7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlkd_brg"] = CCGetFromGet("kd_brg", NULL);
    }
//End Initialize Method

//Validate Method @2-869B3DAC
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->nama_brg->Validate() && $Validation);
        $Validation = ($this->satuan->Validate() && $Validation);
		$Validation = ($this->hrg_beli->Validate() && $Validation);
		$Validation = ($this->hrg_jual_grosir->Validate() && $Validation);
		$Validation = ($this->hrg_jual_retail->Validate() && $Validation);
		$Validation = ($this->stok->Validate() && $Validation);
        $Validation = ($this->kd_brg->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->nama_brg->Errors->Count() == 0);
        $Validation =  $Validation && ($this->satuan->Errors->Count() == 0);
		$Validation =  $Validation && ($this->hrg_beli->Errors->Count() == 0);
		$Validation =  $Validation && ($this->hrg_jual_grosir->Errors->Count() == 0);
		$Validation =  $Validation && ($this->hrg_jual_retail->Errors->Count() == 0);
		$Validation =  $Validation && ($this->stok->Errors->Count() == 0);
        $Validation =  $Validation && ($this->kd_brg->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-E37BA021
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->nama_brg->Errors->Count());
        $errors = ($errors || $this->satuan->Errors->Count());
		$errors = ($errors || $this->hrg_beli->Errors->Count());
		$errors = ($errors || $this->hrg_jual_grosir->Errors->Count());
		$errors = ($errors || $this->hrg_jual_retail->Errors->Count());
		$errors = ($errors || $this->stok->Errors->Count());
        $errors = ($errors || $this->kd_brg->Errors->Count());
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
        $Redirect = "brg_list.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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
		$this->DataSource->nama_brg->SetValue($this->nama_brg->GetValue(true));
        $this->DataSource->satuan->SetValue($this->satuan->GetValue(true));
        $this->DataSource->hrg_beli->SetValue($this->hrg_beli->GetValue(true));
		$this->DataSource->hrg_jual_grosir->SetValue($this->hrg_jual_grosir->GetValue(true));
		$this->DataSource->hrg_jual_retail->SetValue($this->hrg_jual_retail->GetValue(true));
		$this->DataSource->stok->SetValue($this->stok->GetValue(true));
        $this->DataSource->kd_brg->SetValue($this->kd_brg->GetValue(true));
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
		$this->DataSource->nama_brg->SetValue($this->nama_brg->GetValue(true));
        $this->DataSource->satuan->SetValue($this->satuan->GetValue(true));
        $this->DataSource->hrg_beli->SetValue($this->hrg_beli->GetValue(true));
		$this->DataSource->hrg_jual_grosir->SetValue($this->hrg_jual_grosir->GetValue(true));
		$this->DataSource->hrg_jual_retail->SetValue($this->hrg_jual_retail->GetValue(true));
		$this->DataSource->stok->SetValue($this->stok->GetValue(true));
        $this->DataSource->kd_brg->SetValue($this->kd_brg->GetValue(true));
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
					$this->nama_brg->SetValue($this->DataSource->nama_brg->GetValue());
                    $this->hrg_beli->SetValue($this->DataSource->hrg_beli->GetValue());
                    $this->hrg_jual_grosir->SetValue($this->DataSource->hrg_jual_grosir->GetValue());
					$this->hrg_jual_retail->SetValue($this->DataSource->hrg_jual_retail->GetValue());
					$this->stok->SetValue($this->DataSource->stok->GetValue());
					$this->satuan->SetValue($this->DataSource->satuan->GetValue());
                    $this->kd_brg->SetValue($this->DataSource->kd_brg->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
			$Error = ComposeStrings($Error, $this->nama_brg->Errors->ToString());
            $Error = ComposeStrings($Error, $this->hrg_beli->Errors->ToString());
            $Error = ComposeStrings($Error, $this->hrg_jual_grosir->Errors->ToString());
			$Error = ComposeStrings($Error, $this->hrg_jual_retail->Errors->ToString());
			$Error = ComposeStrings($Error, $this->stok->Errors->ToString());
			$Error = ComposeStrings($Error, $this->satuan->Errors->ToString());
            $Error = ComposeStrings($Error, $this->kd_brg->Errors->ToString());
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
		$this->nama_brg->Show();
        $this->satuan->Show();
        $this->hrg_beli->Show();
		$this->hrg_jual_grosir->Show();
		$this->hrg_jual_retail->Show();
		$this->stok->Show();
        $this->kd_brg->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End m_brg Class @2-FCB6E20C

class clsm_brgDataSource extends clsDBMyCon {  //m_brgDataSource Class @2-9E707F87

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
    var $golongan;
    var $kd_brg;
//End DataSource Variables

/*
function s1kode($kode)
{
	$balik="";
	if (strcmp($kode,"1")==0) $balik="A";
	else if (strcmp($kode,"2")==0) $balik="B";
	else if (strcmp($kode,"3")==0) $balik="C";
	else if (strcmp($kode,"4")==0) $balik="D";
	else if (strcmp($kode,"5")==0) $balik="F";
	else if (strcmp($kode,"6")==0) $balik="N";
	else if (strcmp($kode,"7")==0) $balik="M";
	else if (strcmp($kode,"8")==0) $balik="L";
	else if (strcmp($kode,"9")==0) $balik="S";
	return $balik;
}
*/

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

//DataSourceClass_Initialize Event @2-4D840E43
    function clsm_brgDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record m_brg/Error";
        $this->Initialize();

		$this->nama_brg = new clsField("nama_brg", ccsText, "");
		$this->satuan = new clsField("satuan", ccsText, "");
		$this->hrg_beli = new clsField("hrg_beli", ccsFloat, "");
		$this->hrg_jual_grosir = new clsField("hrg_jual_grosir", ccsFloat, "");
		$this->hrg_jual_retail = new clsField("hrg_jual_retail", ccsFloat, "");
		$this->stok = new clsField("stok", ccsFloat, "");        
        $this->kd_brg = new clsField("kd_brg", ccsText, "");
		$this->kd_hrgbeli = new clsField("kd_hrgbeli", ccsText, "");

        $this->InsertFields["kd_hrgbeli"] = array("Name" => "kd_hrgbeli", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		 $this->InsertFields["nama_brg"] = array("Name" => "nama_brg", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->InsertFields["satuan"] = array("Name" => "satuan", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->InsertFields["hrg_jual_retail"] = array("Name" => "hrg_jual_retail", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
		$this->InsertFields["hrg_beli"] = array("Name" => "hrg_beli", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
		$this->InsertFields["hrg_jual_grosir"] = array("Name" => "hrg_jual_grosir", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
		$this->InsertFields["stok"] = array("Name" => "stok", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["kd_brg"] = array("Name" => "kd_brg", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["nama_brg"] = array("Name" => "nama_brg", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["kd_hrgbeli"] = array("Name" => "kd_hrgbeli", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["satuan"] = array("Name" => "satuan", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->UpdateFields["hrg_jual_retail"] = array("Name" => "hrg_jual_retail", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
		$this->UpdateFields["hrg_beli"] = array("Name" => "hrg_beli", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
		$this->UpdateFields["hrg_jual_grosir"] = array("Name" => "hrg_jual_grosir", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
		$this->UpdateFields["stok"] = array("Name" => "stok", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["kd_brg"] = array("Name" => "kd_brg", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1EF17CE9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlkd_brg", ccsText, "", "", $this->Parameters["urlkd_brg"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "kd_brg", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-34AAD597
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT kd_brg,nama_brg,satuan,format(hrg_jual_grosir,0) as hrg_jual_grosir ,format(hrg_beli,0) as hrg_beli,format(hrg_jual_retail,0) as hrg_jual_retail,format(stok,0) as stok  FROM tb_barang {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method
	function setuang($str)
	{
		return str_replace(",","",$str);
	}

//SetValues Method @2-87F6E076
    function SetValues()
    {
		$this->nama_brg->SetDBValue($this->f("nama_brg"));
        $this->satuan->SetDBValue($this->f("satuan"));
        $this->hrg_beli->SetDBValue($this->setuang($this->f("hrg_beli")));
		$this->hrg_jual_grosir->SetDBValue($this->setuang($this->f("hrg_jual_grosir")));
		$this->hrg_jual_retail->SetDBValue($this->setuang($this->f("hrg_jual_retail")));
		$this->stok->SetDBValue($this->setuang($this->f("stok")));
        $this->kd_brg->SetDBValue($this->f("kd_brg"));
    }
//End SetValues Method

//Insert Method @2-B90AA189
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["nama_brg"]["Value"] = $this->nama_brg->GetDBValue(true);
        $this->InsertFields["satuan"]["Value"] = $this->satuan->GetDBValue(true);
        $this->InsertFields["kd_brg"]["Value"] = $this->kd_brg->GetDBValue(true);
		$this->InsertFields["hrg_beli"]["Value"] = $this->hrg_beli->GetDBValue(true);
		$this->InsertFields["hrg_jual_grosir"]["Value"] = $this->hrg_jual_grosir->GetDBValue(true);
		$this->InsertFields["hrg_jual_retail"]["Value"] = $this->hrg_jual_retail->GetDBValue(true);
		$this->InsertFields["stok"]["Value"] = $this->stok->GetDBValue(true);
		$this->InsertFields["kd_hrgbeli"]["Value"] = $this->pengkodean($this->hrg_beli->GetDBValue(true));
        $this->SQL = CCBuildInsert("tb_barang", $this->InsertFields, $this);
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
        $this->UpdateFields["nama_brg"]["Value"] = $this->nama_brg->GetDBValue(true);
        $this->UpdateFields["satuan"]["Value"] = $this->satuan->GetDBValue(true);
        $this->UpdateFields["kd_brg"]["Value"] = $this->kd_brg->GetDBValue(true);
		$this->UpdateFields["hrg_beli"]["Value"] = $this->hrg_beli->GetDBValue(true);
		$this->UpdateFields["hrg_jual_grosir"]["Value"] = $this->hrg_jual_grosir->GetDBValue(true);
		$this->UpdateFields["hrg_jual_retail"]["Value"] = $this->hrg_jual_retail->GetDBValue(true);
		$this->UpdateFields["stok"]["Value"] = $this->stok->GetDBValue(true);
		$this->UpdateFields["kd_hrgbeli"]["Value"] = $this->pengkodean($this->hrg_beli->GetDBValue(true));
        $this->SQL = CCBuildUpdate("tb_barang", $this->UpdateFields, $this);
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
        $this->SQL = "DELETE FROM tb_barang";
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

} //End m_brgDataSource Class @2-FCB6E20C


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
$TemplateFileName = "brg_isi.html";
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
$m_brg = & new clsRecordm_brg("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_brg = & $m_brg;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_brg->Initialize();

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
$m_brg->Operation();
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

//Show Page @1-1091E253
$m_brg->Show();
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
