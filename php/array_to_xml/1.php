<?php

function arrayToXml($array, $rootElement = null, $xml = null) {
	$_xml = $xml;

	if ($_xml === null) {
		$_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root><root/>');
	}

	foreach ($array as $k => $v) {
		if (is_array($v)) { //nested array
			arrayToXml($v, $k, $_xml->addChild($k));
		} 
		else {
        		$_xml->addChild($k, $v);
			}
		}
		return $_xml->asXML();
	}

$xml = arrayToXml($array, '<listing></listing>');
    
?>