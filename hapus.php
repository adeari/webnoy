<?php
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
		else $balik.=s1kode($karakter);
		$x++;
	}
	return $balik;
}
$data="8000";

?>