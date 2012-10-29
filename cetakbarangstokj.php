<?php
$jenisReport="stokbarangtabel";
$namabarang="";
$jumlahbarang=$_GET['jekojeko'];
for ($i=0;$i<$jumlahbarang;$i++)
{
	$namabarang.=" ".$_GET["beho".$i];
}
$namaPDFFile="stokBarang".$_SESSION['yangnakseswebini'].date("dmYHis")."o.pdf";
$isi="\"C:\Program Files\Java\jre1.6.0_03\bin\java\" -cp .;libraryuntukreportjava/jasperreports-3.7.6.jar;libraryuntukreportjava/commons-collections-3.2.1.jar;libraryuntukreportjava/commons-logging-1.1.jar;libraryuntukreportjava/commons-digester-1.7.jar;libraryuntukreportjava/groovy-all-1.7.5.jar;libraryuntukreportjava/poi-3.6-20091214.jar;libraryuntukreportjava/mysql-connector-java-5.1.6-bin.jar;libraryuntukreportjava/commons-beanutils-1.8.2.jar;libraryuntukreportjava/iText-2.1.7.jar Main ".$jenisReport." ".$namaPDFFile." ".$jumlahbarang.$namabarang;
$last_line = system($isi, $retval);
header("Content-type: application/pdf");
readfile($namaPDFFile);
?> 