<?php
//BindEvents Method @1-FF4B9464
function BindEvents()
{
    global $m_trxbeli;
    $m_trxbeli->Navigator->CCSEvents["BeforeShow"] = "m_trxbeli_Navigator_BeforeShow";
}
//End BindEvents Method

//m_trxbeli_Navigator_BeforeShow @33-46885FBC
function m_trxbeli_Navigator_BeforeShow(& $sender)
{
    $m_trxbeli_Navigator_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $m_trxbeli; //Compatibility
//End m_trxbeli_Navigator_BeforeShow

//Hide-Show Component @34-0DB41530
    $Parameter1 = $Container->DataSource->PageCount();
    $Parameter2 = 2;
    if (((is_array($Parameter1) || strlen($Parameter1)) && (is_array($Parameter2) || strlen($Parameter2))) && 0 >  CCCompareValues($Parameter1, $Parameter2, ccsInteger))
        $Component->Visible = false;
//End Hide-Show Component

//Close m_trxbeli_Navigator_BeforeShow @33-EE4D99E9
    return $m_trxbeli_Navigator_BeforeShow;
}
//End Close m_trxbeli_Navigator_BeforeShow


?>
