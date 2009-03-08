<script language="php">
/*
  DesInventar - http://www.desinventar.org
  (c) 1999-2009 Corporacion OSSO
*/

class DIObject {
	var $oSession   = '';
	var $sRegionId  = '';
	// Dynamic Objects Variables
	var $sTableName = 'MyTable';
	var $sPermPrefix = 'OBJECT';
	var $sFieldKeyDef = '';
	var $sFieldDef = '';
	
	var $oFieldType;
	var $q;
	
	public function __construct($prmSession) {
		$this->q = new Query($prmSession->sRegionId);
		$num_args = func_num_args();
		if ($num_args >= 1) {
			$this->oSession = func_get_arg(0);
			if ($num_args >= 3) {
				$this->sFieldKeyDef = func_get_arg(1);
				$this->sFieldDef    = func_get_arg(2);
			}
		}
		$this->createFields($this->sFieldKeyDef, $this->sFieldDef);
	} // constructor
	
	public function createFields($prmKeyDef, $prmFieldDef) {
		$sAllFields = $prmKeyDef . "," . $prmFieldDef;
		$sFields = split(',', $sAllFields);
		foreach ($sFields as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			$this->oFieldType[$sFieldName] = $sFieldType;
			if ($sFieldType == "STRING")   { $this->$sFieldName = "";        }
			if ($sFieldType == "TEXT")     { $this->$sFieldName = "";        }
			if ($sFieldType == "DATETIME") { $this->$sFieldName = date('c'); }
			if ($sFieldType == "INTEGER")  { $this->$sFieldName = -1;        }
			if ($sFieldType == "DOUBLE")   { $this->$sFieldName = 0.0;       }
			if ($sFieldType == "BOOLEAN")  { $this->$sFieldName = true;      }
		}
	} // function
	
	public function set($prmKey, $prmValue) {
		$this->$prmKey = $prmValue;
	}
	
	public function getTableName() {
		return $this->sTableName;
		//return $this->oSession->sRegionId . "_" . $this->sTableName;
	}
	
	public function getWhereSubQuery() {
		$i = 0;
		$sQuery = "(";
		foreach (split(',', $this->sFieldKeyDef) as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			if ($i > 0) { $sQuery .= " AND "; }
			$sQuery .= $sFieldName . "=";
			if (($sFieldType == "STRING"  ) || 
			    ($sFieldType == "TEXT"    ) ||
			    ($sFieldType == "DATETIME") ) {
			    $sQuery .= "'" . $this->$sFieldName . "'";
			}
			if (($sFieldType == "INTEGER") ||
			    ($sFieldType == "DOUBLE" ) ||
			    ($sFieldType == "BOOLEAN" ) ) {
			    $sQuery .= $this->$sFieldName;
			}
			$i++;
		}
		$sQuery .= ")";
		return $sQuery;
	} // function

	public function getSelectQuery() {
		$sQuery = "SELECT * FROM " . $this->getTableName();
		$sQuery .= " WHERE " . $this->getWhereSubQuery();
		return $sQuery;
	} // function

	public function getDeleteQuery() {
		$sQuery = "DELETE FROM " . $this->getTableName();
		$sQuery .= " WHERE " . $this->getWhereSubQuery();
		return $sQuery;
	} // function
	
	public function getInsertQuery() {
		$i = 0;
		$sQueryFields = "";
		$sQueryValues = "";
		foreach (split(',', $this->sFieldKeyDef) as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			if ($i > 0) {
				$sQueryFields .= ",";
				$sQueryValues .= ",";
			}
			$sQueryFields .= $sFieldName;
			if (($sFieldType == "STRING"  ) || 
			    ($sFieldType == "TEXT"    ) ||
			    ($sFieldType == "DATETIME") ) {
			    $sQueryValues .= "'" . $this->$sFieldName . "'";
			}
			if (($sFieldType == "INTEGER") ||
			    ($sFieldType == "DOUBLE" ) ||
			    ($sFieldType == "BOOLEAN" ) ) {
			    $sQueryValues .= $this->$sFieldName;
			}
			$i++;
		}
		$sQuery = "INSERT INTO " . $this->getTableName() . " (" . $sQueryFields . ") VALUES (" . $sQueryValues . ")";
		return $sQuery;
	} // function

	public function getUpdateQuery() {
		$i = 0;
		$sQueryFields = "";
		$sQueryValues = "";
		$sQuery = "UPDATE " . $this->getTableName() . " SET ";
		foreach (split(',', $this->sFieldDef) as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			if ($i > 0) {
				$sQuery .= ",";
			}
			$sQuery .= $sFieldName . "=";
			if (($sFieldType == "STRING"  ) || 
			    ($sFieldType == "TEXT"    ) ||
			    ($sFieldType == "DATETIME") ) {
			    $sQuery .= "'" . $this->$sFieldName . "'";
			}
			if (($sFieldType == "INTEGER") ||
			    ($sFieldType == "DOUBLE" ) ||
			    ($sFieldType == "BOOLEAN" ) ) {
			    $sQuery .= $this->$sFieldName;
			}
			$i++;
		}
		$sQuery .= " WHERE " . $this->getWhereSubQuery();
		return $sQuery;
	} // function
	
	public function exist() {
		$iReturn = 0;
		$sQuery = $this->getSelectQuery();
		if ($result = $this->q->query($sQuery)) {
			if ($result->num_rows() > 0) {
				$bReturn = 1;
			}
		}
		return $iReturn;
	} // function
	
	public function load() {
		$iReturn = 0;
		$sQuery = $this->getSelectQuery();
		if ($result = $this->q->dreg->query($sQuery)) {
			while ($row = $result->fetch(PDO::FETCH_OBJ)) {
				$sAllFields = $this->sFieldKeyDef . "," . $this->sFieldDef;
				$sFields = split(',', $sAllFields);
				foreach ($sFields as $sKey => $sValue) {
					$oItem = split('/', $sValue);
					$sFieldName = $oItem[0];
					$sFieldType = $oItem[1];
					$this->$sFieldName = $row->$sFieldName;
				}
				$iReturn = 1;
			} // while
		} // if
		return $iReturn;
	} // function load
	
	public function insert() {
		$iReturn = 0;
		$sQuery = $this->getInsertQuery();
		if ($result = $this->q->query($sQuery)) {
			$iReturn = 1;		
		}
		return $iReturn;
	} // function

	public function delete() {
		$iReturn = 0;
		$sQuery = $this->getDeleteQuery();
		if ($result = $this->q->query($sQuery)) {
			$iReturn = 1;		
		}
		return $iReturn;
	} // function

	public function update() {
		$iReturn = 0;
		$sQuery = $this->getUpdateQuery();
		if ($result = $this->q->query($sQuery)) {
			$iReturn = 1;		
		}
		return $iReturn;
	} // function
	
	
}

</script>
