<?php
$sukses=false;
if (@strlen($_SESSION['yangnakseswebini'])>0) $sukses=true;
if ($sukses) {
//Include Common Files @1-3D998539
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "trxjual_isi.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordm_trxjual { //m_trxjual Class @2-517D2D68

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
	var $PrintAllowed = false;
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
    function clsRecordm_trxjual($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record m_trxjual/Error";
        $this->DataSource = new clsm_trxjualDataSource($this);
		$this->datadetail = new datadetail($this);
		$this->databarang = new databarang($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
		$this->CancelAllowed = true;
		$this->PrintAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "trxjual";
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
			$this->Button_Print = & new clsButton("Button_Print", $Method, $this);
			
			$this->nota = & new clsControl(ccsTextBox, "nota", "nota", ccsText, "",  CCGetRequestParam("nota", $Method, NULL), $this);
			$this->nota->Required = true;
			$this->nama_kos = & new clsControl(ccsTextBox, "nama_kos", "nama_kos", ccsText, "",  CCGetRequestParam("nama_kos", $Method, NULL), $this);
			$this->alamat = & new clsControl(ccsTextBox, "alamat", "alamat", ccsText, "",  CCGetRequestParam("alamat", $Method, NULL), $this);
			$this->tlp = & new clsControl(ccsTextBox, "tlp", "tlp", ccsText, "",  CCGetRequestParam("tlp", $Method, NULL), $this);
			$this->cetaknota = & new clsControl(ccsTextBox, "cetaknota", "cetaknota", ccsText, "", CCGetRequestParam("cetaknota", $Method, NULL), $this);
			
			$this->tanggal = & new clsControl(ccsTextBox, "tanggal", "tanggal", ccsText, "", CCGetRequestParam("tanggal", $Method, NULL), $this);
			$this->tgljatuhtempo = & new clsControl(ccsTextBox, "tgljatuhtempo", "tgljatuhtempo", ccsText, "", CCGetRequestParam("tgljatuhtempo", $Method, NULL), $this);


			$this->DatePicker1 = & new clsDatePicker("DatePicker1", "trxjual", "tanggal", $this);
			$this->DatePicker2 = & new clsDatePicker("DatePicker2", "trxjual", "tgljatuhtempo", $this);

            $this->tanggal->Required = true;
			$this->tgljatuhtempo->Required = true;
			$this->kd_kos = & new clsControl(ccsTextBox, "kd_kos", "kd_kos", ccsText, "",  CCGetRequestParam("kd_kos", $Method, NULL), $this);
			$this->kd_kos->Required = true;

//data detail row
$this->pilih_menu = & new clsControl(ccsLink, "pilih_menu", "pilih_menu", ccsText, "",null, $this);
$this->pilih_menu->Page = "pilih_barangj.php";
$this->pilih_sup = & new clsControl(ccsLink, "pilih_sup", "pilih_sup", ccsText, "",null, $this);
$this->pilih_sup->Page = "pilih_supj.php";
$this->nomor = & new clsControl(ccsLink, "nomor", "nomor", ccsText, "", "1", $this);
$this->model = & new clsControl(ccsLabel, "model", "model", ccsText, "", "", $this); 
//model adalah style="display:none;" biar g keliatan
$this->FormState = & new clsControl(ccsLabel, "FormState", "FormState", ccsText, "","0;1000;", $this);

$this->isi_kd_brg = & new clsControl(ccsLabel, "isi_kd_brg", "isi_kd_brg", ccsText, "",null, $this);
$this->totalitas = & new clsControl(ccsLabel, "totalitas", "totalitas", ccsText, "",null, $this);
$this->isi_qty = & new clsControl(ccsLabel, "isi_qty", "isi_qty", ccsText, "",null, $this);
$this->nama_brg = & new clsControl(ccsLabel, "nama_brg", "nama_brg", ccsText, "",null, $this);
$this->isi_hrg_beli = & new clsControl(ccsLabel, "isi_hrg_beli", "isi_hrg_beli", ccsText, "",null, $this);

$this->isi_discount = & new clsControl(ccsLabel, "isi_discount", "isi_discount", ccsText, "",null, $this);
$this->isi_maxqty = & new clsControl(ccsLabel, "isi_maxqty", "isi_maxqty", ccsText, "",null, $this);
$this->isi_hrg_jual = & new clsControl(ccsLabel, "isi_hrg_jual", "isi_hrg_jual", ccsText, "",null, $this);
$this->isi_hrg_jualx = & new clsControl(ccsLabel, "isi_hrg_jualx", "isi_hrg_jualx", ccsText, "",null, $this);
$this->isi_totaljual = & new clsControl(ccsLabel, "isi_totaljual", "isi_totaljual", ccsText, "",null, $this);
//end detail row

        }
    }
//End Class_Initialize Event

//Initialize Method @2-7EBC7CF7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlnota"] = CCGetFromGet("nota", NULL);
    }
//End Initialize Method

//Validate Method @2-869B3DAC
    function Validate()
    {
		
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->nota->Validate() && $Validation);
		$Validation = ($this->tanggal->Validate() && $Validation);
		$Validation = ($this->tgljatuhtempo->Validate() && $Validation);
		$Validation = ($this->kd_kos->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->nota->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tgljatuhtempo->Errors->Count() == 0);
		$Validation =  $Validation && ($this->tanggal->Errors->Count() == 0);
        $Validation =  $Validation && ($this->kd_kos->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-E37BA021
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->kd_kos->Errors->Count());
		$errors = ($errors || $this->nota->Errors->Count());
		$errors = ($errors || $this->tanggal->Errors->Count());
		$errors = ($errors || $this->tgljatuhtempo->Errors->Count());
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
			if ($itung==1) $balik.="X";
			else $balik.=$itung;
			
		}
		else $balik.=$this->s1kode($karakter);
		$x++;
	}
	return $balik;
}

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
        if (strcmp(CCGetFromPost("cetaknota", NULL),"cetak")==0) {
			$Redirect = "trxjual_isi.php?nota=".CCGetFromPost("nota", NULL)."&cetaknota=cetak";
		} else {
		    $hiuhi=CCGetQueryString("QueryString", array("ccsForm"));
		    $hiuhi = str_replace("&cetaknota=cetak", "", $hiuhi);
		    $hiuhi = str_replace("cetaknota=cetak&", "", $hiuhi);
		    $Redirect = "trxjual_list.php" . "?" . $hiuhi;
		}

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
		$this->DataSource->kd_kos->SetValue($this->kd_kos->GetValue(true));
        $this->DataSource->nota->SetValue($this->nota->GetValue(true));
        $this->DataSource->tanggal->SetValue($this->tanggal->GetValue(true));
		$this->DataSource->tgljatuhtempo->SetValue($this->tgljatuhtempo->GetValue(true));
        $this->DataSource->Insert();
		
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);	

//mengisi detail data
$tok = strtok(CCGetRequestParam("FormState", ccsPost, NULL), ";");
$tok =strtok(";");
$jmlinput=(int)$tok;
$kodenoponya=$this->nota->GetValue(true);
for ($i=0;$i<$jmlinput;$i++) {
	if (strcmp(CCGetRequestParam("delnya".$i, ccsPost, NULL),"")==0
	&&	strlen(CCGetRequestParam("kd_brg".$i, ccsPost, NULL))>0
	)
		$this->databarang->open(CCGetRequestParam("kd_brg".$i, ccsPost, NULL));
if ($this->databarang->has_next_record())
{
	$this->databarang->next_record();
	$this->databarang->SetValues();
	$stoka=intval($this->databarang->stok->GetValue());
	$stokaisi=$stoka-intval(CCGetRequestParam("qty".$i, ccsPost, NULL));
		{
		$querynya="insert into tb_trxjual1 (nota,kd_brg,hrg_beli,hrg_jual,selisih,stok,kd_hrgbeli,totaljual,discount) values ('".$kodenoponya."','".CCGetRequestParam("kd_brg".$i, ccsPost, NULL)."',".$this->databarang->hrg_beli->GetValue().",".str_replace (".","",CCGetRequestParam("hrg_jualx".$i, ccsPost, NULL)).",".intval((((intval(str_replace (".","",CCGetRequestParam("hrg_jualx".$i, ccsPost, NULL)))-intval($this->databarang->hrg_beli->GetValue())))*intval(str_replace (".","",CCGetRequestParam("qty".$i, ccsPost, NULL))))).",".str_replace (".","",CCGetRequestParam("qty".$i, ccsPost, NULL)).",'".$this->databarang->kd_hrgbeli->GetValue()."',".str_replace (".","",CCGetRequestParam("totaljual".$i, ccsPost, NULL)).",".CCGetRequestParam("discount".$i, ccsPost, NULL).");";
		$this->DataSource->aturdetail($querynya);
		//untuk mengisi data barang
		
	
	$querynya="update tb_barang set stok=".$stokaisi." where kd_brg='".CCGetRequestParam("kd_brg".$i, ccsPost, NULL)."'";
	$this->DataSource->aturdetail($querynya);

}

		//end untuk mengisi data barang______________________________________________________
		}
}
// end mengsisi detail data
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-6AB30596
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
		$this->DataSource->kd_kos->SetValue($this->kd_kos->GetValue(true));
        $this->DataSource->tanggal->SetValue($this->tanggal->GetValue(true));
		$this->DataSource->tgljatuhtempo->SetValue($this->tgljatuhtempo->GetValue(true));

        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
		//mengisi detail data
		/*
$tok = strtok(CCGetRequestParam("FormState", ccsPost, NULL), ";");
$tok =strtok(";");
$jmlinput=(int)$tok;
$kodenoponya=$this->nota->GetValue(true);
	$querynya="update tb_trxjual1 set nota='".$kodenoponya."' where nota='".CCGetFromGet("nota", NULL)."'";
$this->DataSource->aturdetail($querynya);


$querynya="delete from tb_trxjual1 where nota='".$kodenoponya."'";
$this->DataSource->aturdetail($querynya);
for ($i=0;$i<$jmlinput;$i++) {
	if (strcmp(CCGetRequestParam("delnya".$i, ccsPost, NULL),"")==0
	&&	strlen(CCGetRequestParam("kd_brg".$i, ccsPost, NULL))>0
	)
		{
       $querynya="insert into tb_trxjual1 (nota,kd_brg,hrg_beli,hrg_jual,selisih,stok,kd_hrgbeli,totaljual) values ('".$kodenoponya."','".CCGetRequestParam("kd_brg".$i, ccsPost, NULL)."',".str_replace (".","",CCGetRequestParam("hrg_beli".$i, ccsPost, NULL)).",".str_replace (".","",CCGetRequestParam("hrg_jual".$i, ccsPost, NULL)).",".((intval(str_replace (".","",CCGetRequestParam("hrg_jual".$i, ccsPost, NULL)))-intval(str_replace (".","",CCGetRequestParam("hrg_beli".$i, ccsPost, NULL))))).",".str_replace (".","",CCGetRequestParam("qty".$i, ccsPost, NULL)).",'".$this->pengkodean(str_replace (".","",CCGetRequestParam("hrg_beli".$i, ccsPost, NULL)))."',".str_replace (".","",CCGetRequestParam("totaljual".$i, ccsPost, NULL)).");";
		$this->DataSource->aturdetail($querynya);
		}
}
*/
// end mengsisi detail data
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
		$kodenoponya=$this->nota->GetValue(true);
		/*
		$querynya="delete from tb_trxjual1 where nota='".$kodenoponya."'";
		$this->DataSource->aturdetail($querynya);
		*/
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
                    $this->nota->SetValue($this->DataSource->nota->GetValue());
                    $this->tanggal->SetValue($this->DataSource->tanggal->GetValue());
					$this->tgljatuhtempo->SetValue($this->DataSource->tgljatuhtempo->GetValue());
                    $this->kd_kos->SetValue($this->DataSource->kd_kos->GetValue());
					$this->nama_kos->SetValue($this->DataSource->nama_kos->GetValue());
					$this->alamat->SetValue($this->DataSource->alamat->GetValue());
					$this->tlp->SetValue($this->DataSource->tlp->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->nota->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tanggal->Errors->ToString());
			$Error = ComposeStrings($Error, $this->tgljatuhtempo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->kd_kos->Errors->ToString());
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
		$this->Button_Print->Visible = $this->EditMode && $this->PrintAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }        
//menampilkan data untuk detail barang
$jmldatanya=0;
$totalitasnya=0;
$this->nota->Show();
		$this->datadetail->open("select a.kd_brg,b.nama_brg,b.satuan,format(a.hrg_jual,0) as hrg_jual,format(a.stok,0) as stok,b.stok as stokmax, a.kd_hrgbeli,format(a.totaljual,0) as totaljual,totaljual as totaljualx,discount from tb_trxjual1 a join tb_barang b on a.kd_brg=b.kd_brg where a.nota='".CCGetFromGet("nota", NULL)."'");
		$i=0;
if ($this->datadetail->has_next_record())
{
	while ($this->datadetail->has_next_record())
	{
		$this->datadetail->next_record();
		$this->datadetail->SetValues();
	    $this->model->SetValue("");
		$this->nomor->SetValue($i);
		$this->model->Show();
		$this->nomor->Show();
		$this->pilih_menu->Show();

		$this->isi_kd_brg->SetValue($this->datadetail->kd_brg->GetValue());
		$this->isi_kd_brg->Show();
		$this->nama_brg->SetValue($this->datadetail->nama_brg->GetValue());
		$this->nama_brg->Show();
		$this->isi_qty->SetValue(str_replace (",",".",$this->datadetail->stok->GetValue()));
		$this->isi_qty->Show();
		$this->isi_hrg_beli->SetValue(str_replace (",",".",$this->datadetail->hrg_beli->GetValue()));
		$this->isi_hrg_beli->Show();
		$this->isi_discount->SetValue($this->datadetail->discount->GetValue());
		$this->isi_discount->Show();
		$this->isi_maxqty->SetValue(str_replace (",",".",$this->datadetail->stokmax->GetValue()));
		$this->isi_maxqty->Show();
		$this->isi_hrg_jual->SetValue(str_replace (",",".",$this->datadetail->hrg_jual->GetValue()));
		$this->isi_hrg_jual->Show();
		$this->isi_hrg_jualx->SetValue(str_replace (",",".",$this->datadetail->hrg_jual->GetValue()));
		$this->isi_hrg_jualx->Show();
		$this->isi_totaljual->SetValue(str_replace (",",".",$this->datadetail->totaljual->GetValue()));
		$this->isi_totaljual->Show();
		$totalitasnya+=intval($this->datadetail->totaljualx->GetValue());
		$Tpl->parse("detailnya", true);
		$jmldatanya++;
		$i++;
	}

}
	$this->totalitas->SetValue(number_format($totalitasnya, 0, ',', '.'));
	$this->totalitas->Show();
//end menampilkan data untuk detail barang
		
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
		$this->Button_Insert->Show();
		$this->Button_Cancel->Show();
		$this->Button_Print->Show();
		$this->nota->Show();
		$this->cetaknota->Show();
		$this->nama_kos->Show();
		$this->alamat->Show();
		$this->tlp->Show();
        $this->tanggal->Show();
		$this->tgljatuhtempo->Show();
		$this->DatePicker1->Show();
		$this->DatePicker2->Show();
		$this->kd_kos->Show();
		$this->pilih_sup->Show();

//unutk menampilkan barisnya
$jmlbaris=200;
$awal=0;
$this->FormState->SetValue($awal.";".$jmlbaris.";");
$this->FormState->Show();
$awal=$jmldatanya;
for ($i=$awal;$i<$jmlbaris;$i++)
{
	if ($i>$awal)	$this->model->SetValue("style='display:none;'");
		$this->nomor->SetValue($i);
		$this->model->Show();
		$this->nomor->Show();
		$this->pilih_menu->Show();
		$this->isi_kd_brg->SetValue("");
		$this->isi_kd_brg->Show();
		$this->nama_brg->SetValue("");
		$this->nama_brg->Show();
		$this->isi_qty->SetValue("0");
		$this->isi_qty->Show();
		$this->isi_hrg_beli->SetValue("0");
		$this->isi_hrg_beli->Show();
		$this->isi_discount->SetValue("0");
		$this->isi_discount->Show();
		$this->isi_maxqty->SetValue("0");
		$this->isi_maxqty->Show();
		$this->isi_hrg_jual->SetValue("0");
		$this->isi_hrg_jual->Show();
		$this->isi_hrg_jualx->SetValue("0");
		$this->isi_hrg_jualx->Show();
		$this->isi_totaljual->SetValue("0");
		$this->isi_totaljual->Show();
		$Tpl->parse("detailnya", true);
}

//end untuk menampilkan kolom detail

        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
		$this->datadetail->close();
    }
//End Show Method

} //End m_trxjual Class @2-FCB6E20C

class clsm_trxjualDataSource extends clsDBMyCon {  //m_trxjualDataSource Class @2-9E707F87

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

	var $tanggal;
	var $tgljatuhtempo;
	var $nota;
	var $kd_kos;
	var $nama_kos;
	var $alamat;
	var $tlp;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-4D840E43
    function clsm_trxjualDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record m_trxjual/Error";
        $this->Initialize();

		$this->nota = new clsField("nota", ccsText, "");
		$this->tanggal = new clsField("tanggal", ccsText, "");
		$this->tgljatuhtempo = new clsField("tgljatuhtempo", ccsText, "");
		$this->kd_kos = new clsField("kd_kos", ccsText, "");
		$this->nama_kos = new clsField("nama_kos", ccsText, "");
		$this->alamat = new clsField("alamat", ccsText, "");
		$this->tlp = new clsField("tlp", ccsText, "");


        
	
        $this->InsertFields["nota"] = array("Name" => "nota", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
		$this->InsertFields["tanggal"] = array("Name" => "tanggal", "Value" => "", "DataType" => ccsDate1, "OmitIfEmpty" => 1);
		$this->InsertFields["tgljatuhtempo"] = array("Name" => "tgljatuhtempo", "Value" => "", "DataType" => ccsDate1, "OmitIfEmpty" => 1);
		$this->InsertFields["kd_kos"] = array("Name" => "kd_kos", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);


		$this->UpdateFields["tanggal"] = array("Name" => "tanggal", "Value" => "", "DataType" => ccsDate1, "OmitIfEmpty" => 1);
		$this->UpdateFields["tgljatuhtempo"] = array("Name" => "tgljatuhtempo", "Value" => "", "DataType" => ccsDate1, "OmitIfEmpty" => 1);
		$this->UpdateFields["kd_kos"] = array("Name" => "kd_kos", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);

    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1EF17CE9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlnota", ccsText, "", "", $this->Parameters["urlnota"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "nota", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-34AAD597
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT a.nota,a.kd_kos,date_format(a.tanggal,'%d/%m/%Y') as tanggal,date_format(a.tgljatuhtempo,'%d/%m/%Y') as tgljatuhtempo,b.nama_kos,b.alamat,b.tlp FROM tb_trxjual a join tb_kostumer b on a.kd_kos=b.kd_kos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-87F6E076
    function SetValues()
    {
		$this->nota->SetDBValue($this->f("nota"));
        $this->kd_kos->SetDBValue($this->f("kd_kos"));
        $this->tanggal->SetDBValue($this->f("tanggal"));
		$this->nama_kos->SetDBValue($this->f("nama_kos"));
		$this->alamat->SetDBValue($this->f("alamat"));
		$this->tlp->SetDBValue($this->f("tlp"));
		$this->tgljatuhtempo->SetDBValue($this->f("tgljatuhtempo"));
    }
//End SetValues Method

//Insert Method @2-B90AA189
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["kd_kos"]["Value"] = $this->kd_kos->GetDBValue(true);
        $this->InsertFields["nota"]["Value"] = $this->nota->GetDBValue(true);
		$this->InsertFields["tanggal"]["Value"] = $this->tanggal->GetDBValue(true);
		$this->InsertFields["tgljatuhtempo"]["Value"] = $this->tgljatuhtempo->GetDBValue(true);
        $this->SQL = CCBuildInsert("tb_trxjual", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
	function aturdetail($str)
    {
		$this->SQL = $str;
		$this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, "", "")));
	}
	function showdetail($str)
    {
		$this->SQL = $str;
		$this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, "", "")));
		$this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
	}
	//Open Method @2-34AAD597
//End Open Method
//End Insert Method

//Update Method @2-F5617834
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["kd_kos"]["Value"] = $this->kd_kos->GetDBValue(true);
		$this->UpdateFields["tanggal"]["Value"] = $this->tanggal->GetDBValue(true);
		$this->UpdateFields["tgljatuhtempo"]["Value"] = $this->tgljatuhtempo->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tb_trxjual", $this->UpdateFields, $this);
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
        $this->SQL = "DELETE FROM tb_trxjual";
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

} //End m_trxjualDataSource Class @2-FCB6E20C
class datadetail extends clsDBMyCon {
	var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;

	var $kd_brg;
	var $nama_brg;
	var $stok;
	var $hrg_beli;
	var $hrg_jual;
	var $totaljual;
	var $totaljualx;
	var $stokmax;
	var $discount;

	function datadetail(& $Parent)
    {
		$this->Parent = & $Parent;
        $this->Initialize();

		$this->kd_brg = new clsField("kd_brg", ccsText, "");
		$this->nama_brg = new clsField("nama_brg", ccsText, "");
		$this->stok = new clsField("stok", ccsText, "");
		$this->hrg_beli = new clsField("hrg_beli", ccsText, "");
		$this->hrg_jual = new clsField("hrg_jual", ccsText, "");
		$this->totaljual = new clsField("totaljual", ccsText, "");
		$this->totaljualx = new clsField("totaljualx", ccsText, "");
		$this->stokmax = new clsField("stokmax", ccsText, "");
		$this->discount = new clsField("discount", ccsText, "");
	}
	function Open($str)
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = $str;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, "", "")));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }

	function SetValues()
    {
		$this->kd_brg->SetDBValue($this->f("kd_brg"));
		$this->nama_brg->SetDBValue($this->f("nama_brg"));
		$this->stok->SetDBValue($this->f("stok"));
		$this->hrg_beli->SetDBValue($this->f("kd_hrgbeli"));
		$this->hrg_jual->SetDBValue($this->f("hrg_jual"));
		$this->totaljual->SetDBValue($this->f("totaljual"));
		$this->totaljualx->SetDBValue($this->f("totaljualx"));
		$this->stokmax->SetDBValue($this->f("stokmax"));
		$this->discount->SetDBValue($this->f("discount"));
	}
}

class databarang extends clsDBMyCon {
	var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;

	var $hrg_beli;
	var $hrg_jual_retail;
	var $hrg_jual_grosir;
	var $stok;
	var $kd_hrgbeli;
	function databarang(& $Parent)
    {
		$this->Parent = & $Parent;
        $this->Initialize();

		$this->kd_brg = new clsField("kd_brg", ccsText, "");
		$this->hrg_beli = new clsField("hrg_beli", ccsText, "");
		$this->hrg_jual_retail = new clsField("hrg_jual_retail", ccsText, "");
		$this->hrg_jual_grosir = new clsField("hrg_jual_grosir", ccsText, "");
		$this->stok = new clsField("stok", ccsText, "");
		$this->kd_hrgbeli = new clsField("kd_hrgbeli", ccsText, "");
	}
	function Open($kd_brg)
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "select hrg_beli,hrg_jual_retail,hrg_jual_grosir,stok,kd_hrgbeli from tb_barang where kd_brg='".$kd_brg."'";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, "", "")));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }

	function SetValues()
    {
		$this->hrg_beli->SetDBValue($this->f("hrg_beli"));
		$this->hrg_jual_retail->SetDBValue($this->f("hrg_jual_retail"));
		$this->hrg_jual_grosir->SetDBValue($this->f("hrg_jual_grosir"));
		$this->stok->SetDBValue($this->f("stok"));
		$this->kd_hrgbeli->SetDBValue($this->f("kd_hrgbeli"));
	}
}


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
$TemplateFileName = "trxjual_isi.html";
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
$m_trxjual = & new clsRecordm_trxjual("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$left = & new clsleft("", "left", $MainPage);
$left->Initialize();
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$MainPage->m_trxjual = & $m_trxjual;
$MainPage->footer = & $footer;
$MainPage->left = & $left;
$MainPage->header = & $header;
$m_trxjual->Initialize();

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
$m_trxjual->Operation();
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
    unset($m_trxjual);
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
$m_trxjual->Show();
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
unset($m_trxjual);
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
