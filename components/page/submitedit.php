<?php
	defined('_SECURITY') or die("Access denied.");
	
	global $db;
	$id = varPOST::get('id');
	$lid = varPOST::get('lid');
	if ($lid == 0) {
		$query = "UPDATE #__page_sources"
		. "\n SET title = %s,"
		. "\n content = %s"
		. "\n WHERE psid = %d";
		$db->query($query, varPOST::get('title'), varPOST::get('content'), $id);
	}
	else {
		$query = "SELECT * FROM #__page_targets"
		. "\n WHERE source = %d";
		$db->query($query, $id);
		if ($db->noRow()) {
			$query = "INSERT INTO #__page_targets"
			. "\n (title, content, source, language)"
			. "\n VALUES (%s, %s, %d, %d)";
			$db->query($query, varPOST::get('title'), varPOST::get('content'), $id, $lid);
		}
		else {
			$query = "UPDATE #__page_targets"
			. "\n SET title = %s,"
			. "\n content = %s"
			. "\n WHERE source = %d";
			$db->query($query, varPOST::get('title'), varPOST::get('content'), $id);
		}
	}
	print "<return result=\"redirect\">Success.</return>";
?>