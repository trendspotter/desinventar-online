<script language="php">
/*
 DesInventar - http://www.desinventar.org
 (c) 1999-2009 Corporacion OSSO
*/

require_once('include/loader.php');
require_once('include/query.class.php');
require_once('include/maps.class.php');
require_once('include/diobject.class.php');
require_once('include/digeolevel.class.php');
require_once('include/digeocarto.class.php');

$get = $_GET;

if (isset($get['r']) && !empty($get['r'])) {
	$reg = $get['r'];
	$us->open($reg);
} else
	exit();

$cmd = '';

if (isset($get['levcmd'])) {
	$cmd = $get['levcmd'];
}
if (!empty($cmd)) {
	$dat = array();
	$dat['GeoLevelId'] = isset($get['GeoLevelId']) ? $get['GeoLevelId'] : -1;
	$dat['GeoLevelName'] = isset($get['GeoLevelName']) ? $get['GeoLevelName']: '';
	$dat['GeoLevelDesc'] = isset($get['GeoLevelDesc']) ? $get['GeoLevelDesc']: '';
	$dat['GeoLevelLayerFile'] = isset($get['GeoLevelLayerFile']) ? $get['GeoLevelLayerFile']: '';
	$dat['GeoLevelLayerCode'] = isset($get['GeoLevelLayerCode']) ? $get['GeoLevelLayerCode']: '';
	$dat['GeoLevelLayerName'] = isset($get['GeoLevelLayerName']) ? $get['GeoLevelLayerName']: '';
	
	switch ($cmd) {
	case "insert":
		// Create new GeoLevel and GeoCarto Objects
		$o = new DIGeoLevel($us);
		$o->setFromArray($dat);
		$o->set('GeoLevelId', $o->getMaxGeoLevel()+1);
		$c = new DIGeoCarto($us);
		$c->setFromArray($dat);
		$c->set('GeoLevelId', $o->get('GeoLevelId'));
		// Save to database
		$gl = $o->insert();
		$gl = $c->insert();
		if (!iserror($gl)) {
			$t->assign ("ctl_msginslev", true);
			/* Create selection map.. -> disabled method
			if (!empty($dat['GeoLevelLayerFile']) &&
			    !empty($dat['GeoLevelLayerCode']) &&
			    !empty($dat['GeoLevelLayerName'])) {
			    $map = new Maps($us->q, $reg, 0, null, null, null, "", null, "SELECT");
			}*/
		} else {
			$t->assign ("ctl_errinslev", true);
			$t->assign ("insstatlev", $gl);
			if ($gl == ERR_OBJECT_EXISTS) {
				$t->assign ("ctl_chkname", true);
				$t->assign ("chkname", true);
			} //if
		} //else
		break;
	case "update":
		$o = new DIGeoLevel($us);
		$c = new DIGeoCarto($us);
		// Set primary key values
		$o->set('GeoLevelId', $dat['GeoLevelId']);
		$o->load();
		$c->set('GeoLevelId', $dat['GeoLevelId']);
		$c->load();
		// Update with data from FORM
		$o->setFromArray($dat);
		$c->setFromArray($dat);
		// Save to database
		$gl = $o->update();
		$gl = $c->update();
		if (!iserror($gl)) {
			$t->assign ("ctl_msgupdlev", true);
			// Create selection map..
			if (!empty($dat['GeoLevelLayerFile']) &&
			    !empty($dat['GeoLevelLayerCode']) &&
			    !empty($dat['GeoLevelLayerName']))
			    	$map = new Maps($us->q, $reg, 0, null, null, null, "", "SELECT");
		} else {
			$t->assign ("ctl_errupdlev", true);
			$t->assign ("updstatlev", $gl);
			if ($gl == ERR_OBJECT_EXISTS) {
				$t->assign ("ctl_chkname", true);
				$t->assign ("chkname", true);
			}
		}
		break;
	case "chkname":
		$t->assign ("ctl_chkname", true);
		if ($us->q->isvalidObjectName($dat['GeoLevelId'], $dat['GeoLevelName'], DI_GEOLEVEL)) {
			$t->assign ("chkname", true);
		}
		break;
	case "list":
		$t->assign ("ctl_levlist", true);
		$t->assign ("levl", $us->q->loadGeoLevels('', -1, false));
		break;
	default:
		break;
	} //switch
}
else {
	$t->assign ("ctl_admingeo", true);
	$t->assign ("ctl_levlist", true);
	$t->assign ("levl", $us->q->loadGeoLevels('', -1, false));
	$lev = 0;
	$t->assign ("lev", $lev);
	$t->assign ("levmax", $us->q->getMaxGeoLev());
	$t->assign ("levname", $us->q->loadGeoLevById($lev));
	$urol = $us->getUserRole($reg);
	if ($urol == "OBSERVER") {
		$t->assign ("ro", "disabled");
	}
}

$t->assign ("reg", $reg);
$t->assign ("dic", $us->q->queryLabelsFromGroup('DB', $lg));
$t->display ("geolevel.tpl");

</script>
