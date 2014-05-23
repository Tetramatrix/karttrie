<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2010 Chi Hoang (info@chihoang.de)
*  All rights reserved
*
***************************************************************/

require_once("pat.php");

$pat = new PatriciaTrieC();
//~ $pat->Insert ("FISCH");
//~ $pat->Insert ("ANTEE");
//~ $pat->Insert ("TEARE");
//~ $pat->Insert ("Mario Circuit");

$pat->Insert ("Mario Circuit");
$pat->Insert ("Mario Circuit Builder");
$pat->Insert ("Marioc");

$pat->varDump();

$pat->Search("FISCH");
//$pat->Search("Mario");
$pat->Search("Mario Circuit");
//~ $pat->remove("FISCH");
//~ $pat->Search("FISCH");



?>