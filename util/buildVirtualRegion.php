#!/usr/bin/php -d session.save_path='/tmp'
<script language="php">
	/*
	Use this script to rebuild the Virtual Region Databases
	CAN, GranChaco
	2009-07-30 Jhon H. Caicedo <jhcaiced@desinventar.org>
	*/
	
	$_SERVER["DI8_WEB"] = '../web';
	require_once($_SERVER["DI8_WEB"] . '/include/loader.php');
	require_once(BASE . '/include/diregion.class.php');
	require_once(BASE . '/include/digeography.class.php');
	require_once(BASE . '/include/diregionitem.class.php');
	require_once(BASE . '/include/digeolevel.class.php');
	require_once(BASE . '/include/digeocarto.class.php');
	
	$RegionId = '';
	$bOption = 1;
	if ($bOption) {
		// Gran Chaco
		$RegionItems = array('ARG-1248983690-argentina_gran_chaco',
		                     'BOL-1248983699-bolivia_gran_chaco',
		                     'PAR-1248983701-paraguay_gran_chaco');
		//$RegionItems = array('BOL-1248983699-bolivia_gran_chaco');
		$RegionId = 'DESINV-1249126759-subregion_gran_chaco';
		$RegionLabel = 'Subregion Gran Chaco';
	} else {
		// CAN - SubRegion Andina
		$RegionItems = array('ARG-1248983179-argentina_inventario_historico_de_desastres',
		    	             'BOL-1248983224-bolivia_inventario_historico_de_desastres',
	 	      	             'COL-1248983239-colombia_inventario_historico_de_desastres',
	   	    	             'ECU-1248983677-ecuador_inventario_historico_de_desastres',
	   	    	             'VEN-1248984232-inventario_de_desastres_de_venezuela');
		//$RegionItems = array('BOL-1248983224-bolivia_inventario_historico_de_desastres');
		$RegionId = 'DESINV-1249040429-can_subregion_andina';
		$RegionLabel = 'CAN Subregion Andina';
	}
	// loader.php creates a UserSession when loaded...
	$r = ERR_NO_ERROR;
	$r = $us->login('diadmin','di8');
	if ($r > 0) {
		$o = new DIRegion($us);
		$o->set('RegionLabel', $RegionLabel);
		if ($RegionId == '') {
			$RegionId = $o->buildRegionId();
		}
		$o->set('RegionId'    , $RegionId);
		$o->load();
		$o->set('RegionStatus', CONST_REGIONACTIVE | CONST_REGIONPUBLIC);
		$o->set('IsCRegion'   , TRUE);
		$o->update();
		$iReturn = $o->createRegionDB();
		$us->open($RegionId);
		foreach($RegionItems as $RegionItemId) {
			print $RegionItemId . "\n";
			$o->addRegionItem($RegionItemId);
		}
		$o->updateMapArea();
		$us->close();
	}
	$us->logout();	
</script>
