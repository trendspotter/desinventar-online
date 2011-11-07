#!/usr/bin/php -d session.save_path='/tmp'
<script language="php">
	require_once('../web/include/loader.php');
	require_once(BASE . '/include/dievent.class.php');
	require_once(BASE . '/include/dicause.class.php');
	require_once(BASE . '/include/digeography.class.php');
	require_once(BASE . '/include/didisaster.class.php');
	require_once(BASE . '/include/diimport.class.php');
	require_once(BASE . '/include/diregion.class.php');
	require_once(BASE . '/include/dieefield.class.php');
	require_once(BASE . '/include/diregionrecord.class.php');
	
	$RegionId = 'COL-ANTIOQUIA';
	$us->login('diadmin','di8');
	$us->open($RegionId);
	
	//$r = new DIRegionRecord($us, $RegionId);
	//$r->copyEvents('eng');
	//$r->copyCauses('eng');
	$i = new DIImport($us);
	//$a = $i->importFromCSV('/tmp/AN_event.csv', DI_EVENT, true, 0);
	//$a = $i->importFromCSV('/tmp/AN_cause.csv', DI_CAUSE, true, 0);
	//$a = $i->importFromCSV('/tmp/AN_geolevel.csv', DI_GEOLEVEL, true, 0);
	//$a = $i->importFromCSV('/tmp/AN_geography.csv', DI_GEOGRAPHY, true, 0);
	$a = $i->importFromCSV('/tmp/AN_disaster.csv', DI_DISASTER, true, 0);

	//createEEFields($us, '/tmp/AN_eefield.csv','/tmp/AN_eedata.csv');
	//importEEData($us,'/tmp/AN_eedata.csv');

	$us->close();
	$us->logout();

	exit();

function importEEData($us,$filename) {
	$line = 1;
	$count = 0;
	$fh = fopen($filename,'r');
	$a = fgetcsv($fh, 0, ',');
	$a = fgetcsv($fh, 0, ',');
	while (! feof($fh) ) {
		$a = fgetcsv($fh, 0, ',');
		if (count($a) > 1) {
			for($i = 0; $i<count($a); $i++) {
				$a[$i] = trim($a[$i]);
			}
			// 0 - DisasterId
			$DisasterId = $a[0];
			if ($DisasterId != '') {
				$count++;
				$e = new DIEEData($us, $DisasterId);
				for($i = 1; $i <= count($a) - 2; $i++) {
					$fname = 'EEF' . padNumber($i, 3);
					$e->set($fname, valueToDIField($a[$i+1]));
				}
				$i = 1;
				$j = 1;
				//if ($bExist < 0) {
				//	$j = $e->insert();
				//} else {
				$j = $e->update();
				//}
				if ( ($i < 0) || ($j < 0) ) {
					print $line . ' ' . $DisasterId . ' ' . $i . ' ' . $j . "\n";
				}			
				if (($line > 0) && (($line % 100) == 0) ) {
					printf('%5d %5d' . "\n", $line, $count);
				}
			} //if
		} //if
		$line++;
	} //while
	fclose($fh);
	print 'Lines   : ' . $line . "\n";
	print 'Records : ' . $count . "\n";
}

function createEEFields($us,$fname1,$fname2) {
	$fieldname = array();
	$fielddesc = array();
	$fieldtype = array();
	$fieldsize = array();
	$fh = fopen($fname1, 'r');
	// Header Line
	$a = fgetcsv($fh, 0, ',');
	while (! feof($fh) ) {
		$a = fgetcsv($fh, 0, ',');
		if (count($a) > 1) {
			$a[1] = strtoupper($a[1]);
			//print $a[1] . ' ' . $a[3] . ' ' . $a[2] . "\n";
			$fieldname[$a[1]] = $a[3];
			$fielddesc[$a[1]] = $a[2];
			$fieldtype[$a[1]] = $a[11];
			$fieldsize[$a[1]] = $a[7];
		}
	}
	fclose($fh);

	$fh = fopen($fname2,'r');
	// Version Line
	$a = fgetcsv($fh, 0, ',');
	// Header Line
	$a = fgetcsv($fh, 0, ',');
	foreach($a as $key) {
		$key = strtoupper($key);
		if (array_key_exists($key, $fieldname) ) {
			$ftype = 'INTEGER';
			if ($fieldtype[$key] == 2) { $ftype = 'DOUBLE';   }
			if ($fieldtype[$key] == 0) { $ftype = 'STRING';   }
			if ($fieldtype[$key] == 3) { $ftype = 'CURRENCY'; }
			if ($fieldtype[$key] == 7) { $ftype = 'BOOLEAN';  }
			print "$key  $fieldtype[$key] $ftype \n";
			if ($ftype == 'STRING') {
				$i = createEEField($us, $fieldname[$key], 'STRING', 50);
			} else {
				$i = createEEField($us, $fieldname[$key], $ftype);
			}
		} //if
	} //foreach
	fclose($fh);
	/*
	$i = createEEField($us, 'Comercio'                , 'INTEGER' );      //  1
	$i = createEEField($us, 'Turismo'                 , 'STRING', 200);   //  6
	*/
}

function valueToDIField($prmValue) {
	$Value = 0;
	$prmValue = preg_replace('/\$/', '', $prmValue);
	$prmValue = preg_replace('/\./', '', $prmValue);
	$prmValue = preg_replace('/,/', '.', $prmValue);
	if (is_numeric($prmValue)) {
		$Value = $prmValue;
	} else {
		if ($prmValue == 'hubo') {
			$Value = -1;
		}
		if ($prmValue == 'no hubo') {
			$Value = 0;
		}
	}
	return $Value;
}

function createEEField($prmSession, $EEFieldLabel, $EEFieldType, $EEFieldSize='') {
	$f = new DIEEField($prmSession);
	$f->set('EEGroupId', 'SLV');
	$f->set('EEFieldLabel', $EEFieldLabel);
	$f->set('EEFieldType', $EEFieldType);
	if ($EEFieldSize != '') {
		$f->set('EEFieldSize', $EEFieldSize);
	}
	$i = $f->insert();
	return $i;
}
</script>
