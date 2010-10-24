#!/usr/bin/php
<script language="php">
/*
  DesInventar - http://www.desinventar.org
  (c) 1999-2009 Corporacion OSSO
  
  2009-08-18 Jhon H. Caicedo <jhcaiced@desinventar.org>
 
  Fix Geography table by calculating GeographyFQName again.
*/

require_once('../web/include/loader.php');
require_once(BASE . '/include/digeography.class.php');
$q = new Query();
$RegionList = array();
foreach($q->core->query("SELECT * FROM Region ORDER BY RegionId") as $row) {
	$RegionList[] = $row['RegionId'];
}
$RegionList = array('IND-1250695040-india_orissa_historic_inventory_of_disasters');
foreach ($RegionList as $RegionId) {
	print $RegionId . "\n";
	$us->open($RegionId);
	//$query = "ALTER TABLE Geography ADD COLUMN GeographyFQName VARCHAR(500);";
	//$us->q->dreg->query($query);
	$query = "SELECT * FROM Geography WHERE GeographyLevel=0 ORDER BY GeographyId";
	foreach($us->q->dreg->query($query) as $row) {
		$g = new DIGeography($us, $row['GeographyId']);
		$g->saveGeographyFQName();
	} //foreach
}
$q = null;
</script>
