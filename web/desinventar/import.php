<script language="php">
/************************************************
 DesInventar8
 http://www.desinventar.org  
 (c) 1999-2007 Corporacion OSSO
 ***********************************************/

require_once('../include/loader.php');
require_once('../include/user.class.php');
require_once('../include/query.class.php');
require_once('../include/region.class.php');

function loadCSV($csv) {
  $handle = fopen($csv, "r");
  $res = array();
  while (($data = fgetcsv($handle, 100, ",")) !== FALSE)
    $res[] = array($data[0], $data[1], $data[2], $data[3], $data[4]);
  fclose($handle);
  return $res;
}

if (isset($_POST['r']) && !empty($_POST['r']))
  $reg = $_POST['r'];
elseif (isset($_GET['r']) && !empty($_GET['r']))
  $reg = $_GET['r'];
else
  exit();

if (isset($_FILES['desinv']) && isset($_POST['diobj'])) {
  $r = new Region($reg);
  $iserror = true;
  if (isset($_POST['cmd']) && $_POST['cmd'] == "upload") {
    if ($_FILES['desinv']['error'] == UPLOAD_ERR_OK) {
      if ($_FILES['desinv']['type'] == "text/comma-separated-values" ||
          $_FILES['desinv']['type'] == "application/octet-stream" ||
          $_FILES['desinv']['type'] == "text/x-csv" ||
          $_FILES['desinv']['type'] == "text/csv" ||
          $_FILES['desinv']['type'] == "text/plain") {
        $tmp_name = $_FILES['desinv']['tmp_name'];
        $name = $_FILES['desinv']['name'];
        move_uploaded_file($tmp_name, TEMP ."/$name");
        // first validate file to continue with importation
        $valm = $r->validateImportFromCSV(TEMP ."/$name", $_POST['diobj']);
        if (is_array($valm)) {
          $stat = (int) $valm['Status'];
          if (!iserror($stat))
            $valm = $r->importFromCSV(TEMP ."/$name", $_POST['diobj']);
          $t->assign ("msg", $valm);
          $t->assign ("csv", loadCSV($valm['FileName']));
          $iserror = false;
          $t->assign ("ctl_msg", true);
        }
        else
          $error = "SOME HAPPEN WITH THE FILE, TRY AGAIN..";
      }
      else
        $error = "TYPE IS UNKNOWN.. MUST BE TEXT COMMA SEPARATED!";
    }
    else
      $error = "FAIL UPLOAD!";
  }
  else
    $error = "UNKWOWN ERROR ... ";
  // nothing to upload
  if ($iserror) {
    $t->assign ("error", $error);
    $t->assign ("ctl_error", true);
  }
}
// show upload form
else {
  $u = new User('', '', '');
  $urol = $u->getUserRole($reg);
  if ($urol == "OBSERVER")
    $t->assign ("ro", "disabled");
  $t->assign ("ctl_show", true);
}
$t->assign ("reg", $reg);
$t->display ("import.tpl");

</script>
