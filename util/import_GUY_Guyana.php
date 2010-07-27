#!/usr/bin/php -d session.save_path='/tmp'
<script language="php">
	require_once('../web/include/loader.php');
	require_once(BASE . '/include/dievent.class.php');
	require_once(BASE . '/include/dicause.class.php');
	require_once(BASE . '/include/digeography.class.php');
	require_once(BASE . '/include/didisaster.class.php');
	require_once(BASE . '/include/dieedata.class.php');
	require_once(BASE . '/include/diimport.class.php');
	require_once(BASE . '/include/diregion.class.php');
	
	$RegionId = 'GUY-20100727000000';
	$us->login('diadmin','di8');
	$us->open($RegionId);
	$r = new DIRegion($us, $RegionId);
	$r->copyEvents('eng');
	$r->copyCauses('eng');
	$i = new DIImport($us);
	//$a = $i->importFromCSV('/tmp/gy_geography.csv', DI_GEOGRAPHY, true, 0);
	$a = $i->importFromCSV('/tmp/gy_disaster.csv', DI_DISASTER, true, 0);
	$us->close();
	$us->logout();
</script>
