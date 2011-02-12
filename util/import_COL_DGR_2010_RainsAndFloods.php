#!/usr/bin/php -d session.save_path='/tmp'
<script language="php">
/*
  DesInventar - http://www.desinventar.org
  (c) 1998-2010 Corporacion OSSO
  
  2010-12-16 Jhon H. Caicedo <jhcaiced@desinventar.org>
  
  Import data from DGR (Direccion de Gestion del Riesgo) 2010
*/

require_once('../web/include/loader.php');
require_once(BASE . '/include/diregion.class.php');
require_once(BASE . '/include/didisaster.class.php');
require_once(BASE . '/include/dieedata.class.php');
require_once(BASE . '/include/digeography.class.php');
require_once(BASE . '/include/dicause.class.php');
require_once(BASE . '/include/dievent.class.php');
require_once(BASE . '/include/dieefield.class.php');
require_once(BASE . '/include/date.class.php');


$RegionId = 'COL-2010';
$us->login('diadmin','di8');
$us->open($RegionId);

//createEEFields();

$r = new DIRegion($us, $RegionId);
//$r->copyEvents('spa');
//$r->copyCauses('spa');

$line = 1;

$a = fgetcsv(STDIN, 0, ',');
$a = fgetcsv(STDIN, 0, ',');
while (! feof(STDIN) ) {
	$a = fgetcsv(STDIN, 0, ',');
	if (count($a) > 1) {
		for($i = 0; $i<count($a); $i++) {
			$a[$i] = trim($a[$i]);
		}
		// 0 - DisasterSerial
		$DisasterSerial = $a[0];
		$p = $us->getDisasterIdFromSerial($DisasterSerial);
		$DisasterId = $p['DisasterId'];		
		$DisasterBeginTime = strToISO8601($a[1]);
		//printf('%-10s %-20s' . "\n", $DisasterSerial, $DisasterBeginTime);
		//$DisasterBeginTime = '';
		if ($DisasterBeginTime != '') {
			$d = new DIDisaster($us, $DisasterId);
			
			$d->set('DisasterSerial', $DisasterSerial);
			
			$d->set('DisasterSource', 'DGR');
			
			// 1 - DisasterBeginTime
			$d->set('DisasterBeginTime', $DisasterBeginTime);
			$DptoFixes = array(
							'ATLANTICO' => 'Atlántico',
							'BOGOTA D.C.' => 'Bogotá D.C.',
							'BOLIVAR'     => 'Bolívar',
							'BOYACA'      => 'Boyacá',
							'CAQUETA'     => 'Caquetá',
							'CHOCO'       => 'Chocó',
							'CORDOBA'     => 'Córdoba',
							'GUAJIRA'     => 'La Guajira',
							'NARIÑO'      => 'Nariño',
							'QUINDIO'     => 'Quindio'
						 );
			$MpioFixes = array(
							'00001' => array( // Antioquia
								'MEDELLIN'         => 'Medellín',
								'MURINDO'          => 'Murindó',
								'YONDO'            => 'Yondó',
								'VIGIA DEL FUERTE' => 'Vigía del Fuerte',
								'TITIRIBI'  => 'Titiribí',
								'MUTATA'    => 'Mutatá',
								'JERICO'    => 'Jericó',
								'RIO NEGRO' => 'Rionegro',
								'NECHI'     => 'Nechí',
								'TAMESIS'   => 'Támesis',
								'LA UNION'  => 'La Unión',
								'CHIGORODO' => 'Chigorodó',
								'VEGACHI'   => 'Vegachí',
								'BEGACHI'   => 'Vegachí',
								'ENTRERIOS' => 'Entrerrios',
								'SANTAFE DE ANTIOQUIA' => 'Santafé de Antioquia',
								'YALI'      => 'Yalí',
								'CIUDAD BOLIVAR' => 'Ciudad Bolívar',
								'BAGRE'     => 'El Bagre',
								'SAN PEDRO DE URABA' => 'San Pedro de Urabá',
								'SANTUARIO' => 'El Santuario',
								'SAN VICENTE DE FERRER' => 'San Vicente',
								'ANORI' => 'Anorí',
								'SANTA BARBARA' => 'Santa Bárbara',
								'NARIÑO' => 'Nariño',
								'AMAGA' => 'Amagá',
								'MACEO' => 'Meceo',
								'SAN ANDRES DE CUERQUIA' => 'San Andrés de Cuerquía',
								'BRICEÑO' => 'Briceño',
								'JARDIN' => 'Jardín',
								'DEPARTAMENTO' => ''
							),
							'00025' => array( // Arauca
								'PUERTO RONDON' => 'Puerto Rondón',
								'DEPARTAMENTO'  => ''
							),
							'00002' => array(
								'USIACURI' => 'Usiacurí',
								'TUBARA'   => 'Tubará',
								'PIOJO'    => 'Piojó',
								'DEPARTAMENTO' => '',
								'MANATI'       => 'Manatí',
								'REPELON'      => 'Repelón',
								'SANTO TOMAS'  => 'Santó Tomás',
								'SANTA LUCIA'  => 'Santa Lucía'
							),
							'00004' => array( // Bolívar
								'CARMEN DE BOLIVAR' => 'El Carmen de Bolívar',
								'ACHI' => 'Achí',
								'RIOVIEJO' => 'Río Viejo',
								'DEPARTAMENTO' => '',
								'TIQUISIO' => 'Tiquiso',
								'CORDOBA' => 'Córdoba',
								'SIMITI' => 'Simití',
								'EL PEÑON' => 'El Peñón',
								'SANTA ROSA SUR' => 'Santa Rosa del Sur',
								'MAGANGUE' => 'Magangué',
								'SAN CRISTOBAL' => 'San Cristóbal',
								'SOPLAVIENTO' => 'Soplavento',
								'MOMPOX' => 'Mompós',
								'MARIA LA BAJA' => 'María la Baja',
								'SAN JUAN NEPOMUCENO' => 'San Juan de Nepomuceno',
								'SAN MARTIN DE LOBA'  => 'San Martín de Loba',
								'SAN ESTANISLAO DE KOSTA' => 'San Estanislao',
								'TURBANA' => 'Turbaná'
							),
							'00005' => array( // Boyacá
								'QUIPAMA' => 'Quípama',
								'GUICAN'  => 'Güican',
								'BELEN'   => 'Belén',
								'JERICO'  => 'Jericó',
								'SOATA'   => 'Soatá',
								'TIBANA'  => 'Tibaná',
								'RAQUIRA' => 'Ráquira',
								'MONIQUIRA' => 'Moniquirá',
								'PUERTO BOYACA' => 'Puerto Boyacá',
								'SOGAMOSO'      => 'Sogamosos',
								'SOGAMOZO'      => 'Sogamosos',
								'DEPARTAMENTO'  => '',
								'SANTA ANA'  => 'Santana',
								'SUSACON'   => 'Susacón',
								'CIENAGA'   => 'Ciénaga',
								'MONGUI'    => 'Monguí',
								'TOPAGA'    => 'Tópaga',
								'TUTASA'    => 'Tutazá',
								'MARIPI'    => 'Maripí',
								'PAZ DE RIO' => 'Paz de Río'								
							),
							'00006' => array(
								'SUPIA' => 'Supía',
								'LA VICTORIA' => 'Victoria',
								'VILLA MARIA' => 'Villamaria'
							),
							'00007' => array(
								'LA MONTAÑITA' => 'La Montañita',
								'MILAN' => 'Milán',
								'DONCELLO' => 'El Doncello',
								'SOLITA' => 'Salita'
							),
							'00026' => array(
								'MANI' => 'Maní',
								'OROCUE' => 'Orocué',
								'NUNCHIA' => 'Nunchía'
							),
							'00025' => array(
								'PUERTO RONDON' => 'Puerto Rondón',
							),
							'00008' => array( // Cauca
								'PURACE' => 'Puracé',
								'INZA' => 'Inzá',
								'POPAYAN' => 'Popayán',
								'CAJIBIO' => 'Cajibío',
								'SUAREZ' => 'Suárez',
								'LOPEZ DE MICAY' => 'López',
								'TIMBA' => 'Buenos Aires',
								'PATIA' => 'Patía',
								'TOTORO' => 'Totoró'
							),
							'00009' => array( // Cesar
								'GONZALEZ' => 'González',
								'CURUMANI' => 'Curumaní',
								'CODAZZI' => 'Agustín Codazzi',
								'AGUSTIN CODAZZI' => 'Agustín Codazzi',
								'DEPARTAMENTO' => '',
								'CHIRIGUANA' => 'Chiriguaná',
								'SAN MARTIN' => 'San Martín',
								'RIO DE ORO' => 'Río de Oro'
							), // Choco
							'00012' => array(
								'QUIBDO' => 'Quibdó',
								'ITSMINA' => 'Istmina',
								'LITORAL DEL SAN JUAN' => 'El Litoral de San Juan',
								'SIPI' => 'Sipí',
								'RIO IRO' => 'Río Iró',
								'CARMEN DEL DARIEN' => 'Carmen del Darién',
								'ALTO BAUDO' => 'Alto Baudó',
								'BOJAYA' => 'Bojayá',
								'NOVITA' => 'Nóvita',
								'JURADO' => 'Juradó',
								'TADO'   => 'Tadó',
								'PIZARRO' => 'Bajo Baudo',
								'UNGUIA'  => 'Unguía',
								'ACANDI' => 'Acandí',
								'BAHIA SOLANO' => 'Bahía Solano',
								'BAGADO' => 'Bagadó',
								'CARMEN DE ATRATO' => 'El Carmen de Atrato',
								'CANTON DE SAN PABLO' => 'El Cantón del San Pablo',
								'SAN JOSE DEL PALMAR' => 'San José del Palmar'
							),
							'00010' => array( // Córdoba
								'SAN JOSE DE URE' => 'San José de Uré',
								'DEPARTAMENTO' => '',
								'SAN MATEO' => 'Chinú',
								'MONTERIA' => 'Montería',
								'MONTELIBANO' => 'Montelíbano',
								'TUCHIN' => 'Tuchín',
								'CHIMA' => 'Chimá',
								'CIENAGA DE ORO' => 'Ciénaga de Oro',
								'CERETE' => 'Cereté',
								'PURISIMA' => 'Purísima',
								'MOÑITOS' => 'Moñitos',
								'SAN ANDRES DE SOTAVENTO' => 'San Andrés de Sotavento'
							),
							'00011' => array( // Cundinamarca
								'ZIPAQUIRA' => 'Zipaquirá',
								'GUTIERREZ' => 'Gutiérrez',
								'CAJICA' => 'Cajicá',
								'CHOACHI' => 'Choachí',
								'GACHETA' => 'Guachetá',
								'SAN FRANCISO' => 'San Francisco',
								'SOPO' => 'Sopó',
								'UBATE' => 'Villa de San Diego de Ubate',
								'QUIPILE' => 'Quiple',
								'FUSAGASUGA' => 'Fusagasugá',
								'SIBATE' => 'Sibaté',
								'CHIA' => 'Chía',
								'CAPARRAPI' => 'Caparrapí',
								'TOCANCIPA' => 'Tocancipá',
								'CHAGUANI' => 'Chaguaní'
							),
							'00031' => array( //Guaviare
								'SAN JOSE DEL GUAVIARE' => 'San José del Guaviare'
							),
							'00013' => array( // Huila
								'YAGUARA' => 'Yaguará',
								'SANTA MARIA' => 'Santa María',
								'TIMANA' => 'Timaná'
							),
							'00015' => array( // Magdalena
								'CIENAGA' => 'Ciénaga',
								'DEPARTAMENTO' => '',
								'ARIGUANI' => 'Ariguaní',
								'SITIO NUEVO' => 'Sitionuevo',
								'ZAPAYAN' => 'Zapayán',
								'EL PIÑON' => 'El Piñon',
								'SANTA BARBARA DE PINTO' => 'Santa Bárbara de Pinto',
								'PIJIÑO DEL CARMEN' => 'Pijiño del Carmen',
								'SAN SEBASTIAN' => 'San Sebastián de Buenavista',
								'CERRO DE SAN ANTONIO' => 'Cerro San Antonio',
								'EL RETEN' => 'El Retén',
								'FUNDACION' => 'Fundación',
								'SAN ZENON' => 'San Zenón'
							),
							'00016' => array( // Meta
								'CALVARIO' => 'El Calvario',
								'LEJANIAS' => 'Lejanías',
								'VISTA HERMOSA' => 'Vistahermosa',
								'PUERTO LOPEZ' => 'Puerto López',
								'SAN MARTIN' => 'San Martín',
								'BARRANCA DE UPIA' => 'Barrana de Upía',
								'CUMARAL' => 'Cumarral',
								'ACACIAS' => 'Acacías'
							),
							'00017' => array( // Nariño
								'LEYVA' => 'Leiva',
								'ANDES' => 'Los Andes',
								'ANCUYA' => 'Ancuyá',
								'GUALMATAN' => 'Gualmatán',
								'TUMACO' => 'San Andrés de Tumaco',
								'MAGUI PAYAN' => 'Magüi',
								'SANDONA' => 'Sandoná',
							),
							'00018' => array( // Norte de Santander
								'CONVENCION' => 'Convención',
								'CHITAGA' => 'Chitagá',
								'CUCUTA' => 'Cúcuta',
								'TIBU' => 'Tibú',
								'OCAÑA' => 'Ocaña',
								'HERRAN' => 'Herrán',
								'CHINACOTA' => 'Chinácota',
								'HACARI' => 'Hacarí',
							),
							'00027' => array( //Putumayo
								'VILLA GARZON' => 'Villagarzón'
							),
							'00019' => array( // Quindio
								'CALARCA' => 'Calarcá',
								'GENOVA' => 'Génova',
								'CIRCACIA' => 'Circasia',
								'CORDOBA' => 'Córdoba'
							),
							'00020' => array( // Risaralda
								'GUATICA' => 'Guática',
								'BELEN DE UMBRIA' => 'Belén de Umbría',
								'QUINCHIA' => 'Quinchía',
								'APIA' => 'Apía',
								'MISTRATO' => 'Mistrató',
								'DEPARTAMENTO' => ''
							),
							'00021' => array( // Santander
								'CONCEPCION' => 'Concepción',
								'GUACAMAYO' => 'El Guacamayo',
								'JESUS MARIA' => 'Jesús María',
								'MALAGA' => 'Málaga',
								'BOLIVAR' => 'Bolívar',
								'VELEZ' => 'Vélez',
								'SURATA' => 'Suratá',
								'SAN VICENTE' => 'San Vicente de Chucurí',
								'SAN VICENTE DE CHUCURI' => 'San Vicente de Chucurí',
								'CONTRATACION' => 'Contratación',
								'SAN JOSE MIRANDA' => 'San José de Miranda',
								'CARCASI' => 'Carcasí',
								'CURITI' => 'Curití',
								'GIRON' => 'Girón',
								'DEPARTAMENTO' => '',
								'CEPITA' => 'Cepitá',
								'EL HATO' => 'Hato',
								'EL PALMAR' => 'Palmar',
								'GALAN' => 'Galán',
								'GUAPOTA' => 'Guapotá',
								'SANTA HELENA DEL OPON' => 'Santa Helena del Opón',
								'VALLE DE SAN JOSE' => 'Valle de San José',
								'EL CARMEN DE CHUCURI' => 'El Carmen de Chucurí',
								'GUABATA' => 'Guavatá'
							),
							'00022' => array( // Sucre
								'SAN BENITO ABAD' => 'San Benito de Abad',
								'DEPARTAMENTO' => '',
								'COVEÑAS' => 'Coveñas',
								'SINCE' => 'Sincelejo',
								'TOLU' => 'Tolú Viejo',
								'LA UNION' => 'La Unión',
							),
							'00023' => array( // Tolima
								'LIBANO' => 'Líbano',
								'IBAGUE' => 'Ibagué',
								'HERBEO' => 'Herveo',
								'VILLARICA' => 'Villarrica',
								'CARMEN DE APICALA' => 'Carmen de Apicalá',
								'PURIFICACION' => 'Purificación',
								'SUAREZ' => 'Suárez',
								'MARIQUITA' => 'San Sebastián de Mariquita'
							),
							'00024' => array( // Valle del Cauca
								'EL AGUILA' => 'El Águila',
								'JAMUNDI' => 'Jamundí',
								'CALIMA DARIEN' => 'Calima',
								'ANDALUCIA' => 'Andalucía',
								'GUACARI' => 'Guacarí',
								'BOLIVAR' => 'Bolívar',
								'LA UNION' => 'La Unión',
								'RIOFRIO' => 'Riofrío',
								'TULUA' => 'Tuluá',
								'ALCALA' => 'Alcalá',
								'DEPARTAMENTO' => ''								
							)
						);
			// 2-3 - GeographyName (Departamento/Municipio)
			$Dpto = $a[2];
			$Mpio = $a[3];
			if (array_key_exists($Dpto, $DptoFixes))
			{
				$Dpto = $DptoFixes[$Dpto];
			}
			$DptoCode = DIGeography::getIdByName($us, $Dpto, '');
			$GeographyId = $DptoCode;

			if ( array_key_exists($DptoCode, $MpioFixes) && array_key_exists($Mpio, $MpioFixes[$DptoCode]) )
			{
				$Mpio = $MpioFixes[$DptoCode][$Mpio];
			}
			if ($GeographyId != '') {
				if ($Mpio != '') {
					$GeographyId = DIGeography::getIdByName($us, $Mpio, $GeographyId);
				}
			}
			$d->set('GeographyId', $GeographyId);
			if ($GeographyId == '')
			{
				printf('GEOGRAPHY ERROR : %-10s %-5s %-20s %-20s' . "\n", $DisasterSerial, $DptoCode, $Dpto, $Mpio);
			}

			// 4 - Cause
			$CauseName = 'Desconocida'; // There is no Cause column in original data...
			$CauseFix = array(
							'No especificado' => 'Otra causa',
						);
			if (array_key_exists($CauseName, $CauseFix))
			{
				$CauseName = $CauseFix[$CauseName];
			}
			$CauseId = DICause::getIdByName($us, $CauseName);
			$d->set('CauseId', $CauseId);
			if ($CauseId == '')
			{
				printf('CAUSE ERROR : %-10s %-20s' . "\n", $DisasterSerial, $CauseName);
			}
			
			// 5 - Event
			$EventName = $a[5];
			$EventFix = array(
							'TORMENTA ELECTRICA' => 'Tormenta eléctrica',
							'AVALANCHA' => 'Alud',
							'EROSION' => 'Erosión'
						);
			if (array_key_exists($EventName, $EventFix))
			{
				$EventName = $EventFix[$EventName];
			}
			$EventId = DIEvent::getIdByName($us, $EventName);
			$d->set('EventId', $EventId);
			if ($EventId == '')
			{
				printf('EVENT ERROR : %-10s %-20s' . "\n", $DisasterSerial, $EventName);
			}
			
			// 6-9 - Effects (Basic) 
			$d->set('EffectPeopleDead'      , valueToDIField($a[6]));
			$d->set('EffectPeopleInjured'   , valueToDIField($a[7]));
			$d->set('EffectPeopleMissing'   , valueToDIField($a[8]));
			$d->set('EffectPeopleAffected'  , valueToDIField($a[9]));
			// 10 Familias (EEF)
			$d->set('EffectHousesDestroyed' , valueToDIField($a[11]));
			$d->set('EffectHousesAffected'  , valueToDIField($a[12]));
			$d->set('EffectRoads'           , valueToDIField($a[13]));
			// 14 Puentes Vehic
			// 15 Puentes Peatonales
			$d->set('SectorWaterSupply'     , valueToDIField($a[16]));
			$d->set('SectorSewerage'        , valueToDIField($a[17]));
			$d->set('EffectMedicalCenters'  , valueToDIField($a[18]));
			$d->set('EffectEducationCenters', valueToDIField($a[19]));
			// 20 Centros Comunitarios
			$d->set('EffectFarmingAndForest', valueToDIField($a[21]));
			$d->set('EffectOtherLosses'     , valueToDIField($a[22]));
			// 23 - 37 ????
			$d->set('EffectNotes'           , valueToDIField($a[38]));

			/*
			// 22 Otros
			$d->set('SectorAgricultural', valueToDIField($a[22]));
			// 22
			$d->set('SectorIndustry', valueToDIField($a[23]));
			// 23
			$d->set('SectorPower', valueToDIField($a[24]));
			// 24
			$d->set('SectorEducation', valueToDIField($a[25]));
			// 26
			$d->set('SectorTransport', valueToDIField($a[27]));
			// 27
			$d->set('SectorCommunications', valueToDIField($a[28]));
			// 30
			$d->set('EffectPeopleEvacuated', valueToDIField($a[31]));
			*/

			$bExist = $d->exist();
			if ($bExist < 0) {
				$i = $d->insert();
			} else {
				$i = $d->update();
			}
			$DisasterId = $d->get('DisasterId');
			$e = new DIEEData($us, $DisasterId);

			$e->set('EEF004', valueToDIField($a[10]));  // 10 - Familias Afectadas
			$e->set('EEF005', valueToDIField($a[14]));  // 14 - Puentes Vehiculares
			$e->set('EEF006', valueToDIField($a[15]));  // 15 - Puentes Peatonales
			$e->set('EEF007', valueToDIField($a[16]));  // 16 - Acueductos Afectados
			$e->set('EEF008', valueToDIField($a[20]));  // 20 - Centros Comunitarios
			$e->set('EEF009',   strToISO8601($a[23]));  // 23 - Fecha Tramite Administrativo
			$e->set('EEF010', valueToDIField($a[24]));  // 24 Menajes
			$e->set('EEF011', valueToDIField($a[25]));  // 25 Ap. Aliment.
			$e->set('EEF012', valueToDIField($a[26]));  // 26 Materiales Construccion
			$e->set('EEF013', valueToDIField($a[27]));  // Sacos
			$e->set('EEF014', valueToDIField($a[28]));  // Otros
			$e->set('EEF015', valueToDIField($a[29]));  // Giro Directo
			//$e->set('EEF016', valueToDIField($a[40]));
			//$e->set('EEF017', valueToDIField($a[41]));
			$e->set('EEF018', valueToDIField($a[31]));  // Apoyos en Tramite
			$e->set('EEF019',   strToISO8601($a[32]));  // Fecha Recibo
			//$e->set('EEF020',   strToISO8601($a[44]));
			$e->set('EEF021', valueToDIField($a[35]));  // Atendido
			$e->set('EEF022', valueToDIField($a[37]));  // Analisis y Evaluacion de la Solicitud
			//$e->set('EEF023', valueToDIField($a[47]));
			//$e->set('EEF024', valueToDIField($a[48]));
			$e->set('EEF025', valueToDIField($a[39]));  // Cepillo Adulto (Cant)
			$e->set('EEF026', valueToDIField($a[40]));  // Cepillo Adulto (Valor)
			$e->set('EEF027', valueToDIField($a[41]));  // Cepillo Niño (Cant)
			$e->set('EEF028', valueToDIField($a[42]));  // Cepillo Niño (Valor)
			$e->set('EEF029', valueToDIField($a[43]));  // Chocolatera (Cant)
			$e->set('EEF030', valueToDIField($a[44]));  // Chocolatera (Valor)
			$e->set('EEF031', valueToDIField($a[45]));  // Cinta Empalmar (Cant)
			$e->set('EEF032', valueToDIField($a[46]));  // Cinta Empalmar (Valor)
			$e->set('EEF033', valueToDIField($a[47]));  // Cobija (Cant)
			$e->set('EEF034', valueToDIField($a[48]));  // Cobija (Valor)
			$e->set('EEF035', valueToDIField($a[49]));  // Cobija Térmica (Cant)
			$e->set('EEF036', valueToDIField($a[50]));  // Cobija Térmica (Valor)
			$e->set('EEF037', valueToDIField($a[51]));  // Colchoneta (Cant)
			$e->set('EEF038', valueToDIField($a[52]));  // Colchoneta (Valor)
			$e->set('EEF039', valueToDIField($a[53]));  // Catre (Cant)
			$e->set('EEF040', valueToDIField($a[54]));  // Catre (Valor)
			$e->set('EEF041', valueToDIField($a[55]));  // Crema Desod. (Cant)
			$e->set('EEF042', valueToDIField($a[56]));  // Crema Desoc. (Valor)
			$e->set('EEF043', valueToDIField($a[57]));  // Cuchara Acero (Cant)
			$e->set('EEF044', valueToDIField($a[58]));  // Cuchara Acero (Valor)
			$e->set('EEF045', valueToDIField($a[59]));  // Cuchara Madera (Cant)
			$e->set('EEF046', valueToDIField($a[60]));  // Cuchara Madera (Valor)
			$e->set('EEF047', valueToDIField($a[61]));  // Estufas (Cant)
			$e->set('EEF048', valueToDIField($a[62]));  // Estufas (Valor)
			$e->set('EEF049', valueToDIField($a[63]));  // Hamacas (Cant)
			$e->set('EEF050', valueToDIField($a[64]));  // Hamacas (Valor)
			$e->set('EEF051', valueToDIField($a[65]));  // Jabon Baño (Cant)
			$e->set('EEF052', valueToDIField($a[66]));  // Jabon Baño (Valor)
			$e->set('EEF053', valueToDIField($a[67]));  // Jabon Barra (Cant)
			$e->set('EEF054', valueToDIField($a[68]));  // Jabon Barra (Valor)
			$e->set('EEF055', valueToDIField($a[69]));  // Juego Cubiertos (Cant)
			$e->set('EEF056', valueToDIField($a[70]));  // Juego Cubiertos (Valor)
			$e->set('EEF057', valueToDIField($a[71]));  // Ollas (Cant)
			$e->set('EEF058', valueToDIField($a[72]));  // Ollas (Valor)
			$e->set('EEF059', valueToDIField($a[73]));  // Papel Higiénico (Cant)
			$e->set('EEF060', valueToDIField($a[74]));  // Papel Higiénico (Valor)
			$e->set('EEF061', valueToDIField($a[75]));  // Peinilla (Cant)
			$e->set('EEF062', valueToDIField($a[76]));  // Peinilla (Valor)
			$e->set('EEF063', valueToDIField($a[77]));  // Plastico Negro (Cant)
			$e->set('EEF064', valueToDIField($a[78]));  // Plastico Negro (Valor)
			$e->set('EEF065', valueToDIField($a[79]));  // Plato Hondo (Cant)
			$e->set('EEF066', valueToDIField($a[80]));  // Plato Hondo (Valor)
			$e->set('EEF067', valueToDIField($a[81]));  // Plato Pando (Cant)
			$e->set('EEF068', valueToDIField($a[82]));  // Plato Pando (Valor)
			$e->set('EEF069', valueToDIField($a[83]));  // Pocillo (Cant)
			$e->set('EEF070', valueToDIField($a[84]));  // Pocillo (Valor)
			$e->set('EEF071', valueToDIField($a[85]));  // Sábanas (Cant)
			$e->set('EEF072', valueToDIField($a[86]));  // Sábanas (Valor)
			$e->set('EEF073', valueToDIField($a[87]));  // Sobrecamas (Cant)
			$e->set('EEF074', valueToDIField($a[88]));  // Sobrecamas (Valor)
			$e->set('EEF075', valueToDIField($a[89]));  // Toallas (Cant)
			$e->set('EEF076', valueToDIField($a[90]));  // Toallas (Valor)
			$e->set('EEF077', valueToDIField($a[91]));  // Toldillos (Cant)
			$e->set('EEF078', valueToDIField($a[92]));  // Toldillos (Valor)
			$e->set('EEF079', valueToDIField($a[93]));  // Kit Aseo (Cant)
			$e->set('EEF080', valueToDIField($a[94]));  // Kit Aseo (Valor)
			$e->set('EEF081', valueToDIField($a[95]));  // Kit Cocina (Cant)
			$e->set('EEF082', valueToDIField($a[96]));  // Kit Cocina (Valor)
			$e->set('EEF083', valueToDIField($a[97]));  // Kit Alcoba (Cant)
			$e->set('EEF084', valueToDIField($a[98]));  // Kit Alcoba (Valor)
			$e->set('EEF085', valueToDIField($a[99]));  // Menajes (Valor Total)
			$e->set('EEF086', valueToDIField($a[100])); // Sacos (Cant)
			$e->set('EEF087', valueToDIField($a[101])); // Sacos (Valor)
			$e->set('EEF088', valueToDIField($a[102])); // Mercados (Cant)
			$e->set('EEF089', valueToDIField($a[103])); // Mercados (Valor)
			$e->set('EEF090', valueToDIField($a[104])); // Cemento (Cant)
			$e->set('EEF091', valueToDIField($a[105])); // Cemento (Valor)
			$e->set('EEF092', valueToDIField($a[106])); // Tejas (Cant)
			$e->set('EEF093', valueToDIField($a[107])); // Tejas (Valor)
			if ($bExist < 0) {
				$j = $e->insert();
			} else {
				$j = $e->update();
			}
			if ( ($i < 0) || ($j < 0) ) {
				//print $line . ' ' . $DisasterSerial . ' ' . $i . ' ' . $j . "\n";
			}			
			if (($line > 0) && (($line % 100) == 0) ) {
				//print $line . "\n";
			}
		} //if
	} //if
	$line++;
} //while

$us->close();
$us->logout();
exit();

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

function strToISO8601($prmDate) {
	$v = '';
	if (strlen($prmDate) > 0) {
		$year  = substr($prmDate,0,4);
		$month = substr($prmDate,5,2);
		$day   = substr($prmDate,8,2);
		$v = sprintf('%4d-%2d-%2d', $year, $month, $day);
		$v = str_replace(' ', '0', $v);
	}
	/*
	if (strlen($prmDate) > 0) {
		$month = substr($prmDate,0,2);
		$day   = substr($prmDate,3,2);
		$year  = substr($prmDate,6,4);
		$v = sprintf('%4d-%2d-%2d', $year, $month, $day);
		$v = str_replace(' ', '0', $v);
	}
	*/
	/*
	$a = array();
	preg_match('/([0-9]+) de (.*) de ([0-9]+)/', $prmDate, $a);
	if ( (count($a) > 2) && (is_numeric($a[3])) ) {
		$year = $a[3] + 2000;
		$month = getMonth($a[2]);
		$day = $a[1];
		$v = sprintf('%4d-%2d-%2d', $year, $month, $day);
		$v = str_replace(' ', '0', $v);
	}
	*/
	return $v;
}

function getMonth($prmMonthName) {
	$m = array('ene' =>  1, 'feb' =>  2, 'mar' =>  3, 'apr' =>  4, 'may' =>  5, 'jun' =>  6, 
	           'jul' =>  7, 'aug' =>  8, 'sep' =>  9, 'oct' => 10, 'nov' => 11, 'dec' => 12);
	$v = 0;
	$MonthName = strtolower($prmMonthName);
	if (array_key_exists($MonthName, $m)) {
		$v = $m[$MonthName];
	}
	return $v;
}

function createEEField($prmSession, $EEFieldLabel, $EEFieldType, $EEFieldSize='') {
	$f = new DIEEField($prmSession);
	$f->set('EEGroupId', 'DGR');
	$f->set('EEFieldLabel', $EEFieldLabel);
	$f->set('EEFieldType', $EEFieldType);
	if ($EEFieldSize != '') {
		$f->set('EEFieldSize', $EEFieldSize);
	}
	$i = $f->insert();
	return $i;
}

function createEEFields($us) {
	$i = createEEField($us, 'Familias Afectadas'          , 'INTEGER' );      //  4
	$i = createEEField($us, 'Puentes Vehiculares'         , 'INTEGER' );      //  5
	$i = createEEField($us, 'Puentes Peatonales'          , 'INTEGER' );      //  6
	$i = createEEField($us, 'Acueductos Afectados'        , 'INTEGER' );      //  7
	$i = createEEField($us, 'Centros Comunitarios'        , 'INTEGER' );      //  8
	$i = createEEField($us, 'Fecha Trámite Administrativo', 'DATE'    );      //  9 - 32
	$i = createEEField($us, 'Menajes'                     , 'CURRENCY');      // 10 - 33
	$i = createEEField($us, 'Ap. Aliment'                 , 'CURRENCY');      // 11 - 34
	$i = createEEField($us, 'Materiales Construcción'     , 'CURRENCY');      // 12 - 35
	$i = createEEField($us, 'Sacos'                       , 'CURRENCY');      // 13 - 36
	$i = createEEField($us, 'Otros'                       , 'CURRENCY');      // 14 - 37
	$i = createEEField($us, 'Giro Directo'                , 'CURRENCY');      // 15 - 38
	$i = createEEField($us, 'Econom.'                     , 'CURRENCY');      // 16 - 39
	$i = createEEField($us, 'Valor Total'                 , 'CURRENCY');      // 17 - 40
	$i = createEEField($us, 'Apoyos en Trámite'           , 'CURRENCY');      // 18 - 41
	$i = createEEField($us, 'Fecha Recibo'                , 'DATE'    );      // 19 - 42
	$i = createEEField($us, 'Trámite ante DPAD'           , 'DATE'    );      // 20 - 43
	$i = createEEField($us, 'Atendido'                    , 'BOOLEAN' );      // 21 - 44
	$i = createEEField($us, 'Comentarios'                 , 'STRING', 200);   // 22 - 45
	$i = createEEField($us, 'Número de Iglesias'          , 'INTEGER' );      // 23 - 46
	$i = createEEField($us, 'Iglesias Afectadas'          , 'INTEGER' );      // 24 - 47
	$i = createEEField($us, 'Cepillo Adulto (Cant)'       , 'INTEGER' );      // 25 - 48
	$i = createEEField($us, 'Cepillo Adulto (Valor)'      , 'CURRENCY');      // 26 - 49
	$i = createEEField($us, 'Cepillo Niño (Cant)'         , 'INTEGER' );      // 27 - 50
	$i = createEEField($us, 'Cepillo Niño (Valor)'        , 'CURRENCY');      // 28 - 51
	$i = createEEField($us, 'Chocolatera (Cant)'          , 'INTEGER' );      // 29 - 52
	$i = createEEField($us, 'Chocolatera (Valor)'         , 'CURRENCY');      // 30 - 53
	$i = createEEField($us, 'Cinta Empalmar (Cant)'       , 'INTEGER' );      // 31 - 54
	$i = createEEField($us, 'Cinta Empalmar (Valor)'      , 'CURRENCY');      // 32 - 55
	$i = createEEField($us, 'Cobija (Cant)'               , 'INTEGER' );      // 33 - 56
	$i = createEEField($us, 'Cobija (Valor)'              , 'CURRENCY');      // 34 - 57
	$i = createEEField($us, 'Cobija Térmica (Cant)'       , 'INTEGER' );      // 35 - 58
	$i = createEEField($us, 'Cobija Térmica (Valor)'      , 'CURRENCY');      // 36 - 59
	$i = createEEField($us, 'Colchoneta (Cant)'           , 'INTEGER' );      // 37 - 60
	$i = createEEField($us, 'Colchoneta (Valor)'          , 'CURRENCY');      // 38 - 61
	$i = createEEField($us, 'Catre (Cant)'                , 'INTEGER' );      // 39 - 62
	$i = createEEField($us, 'Catre (Valor)'               , 'CURRENCY');      // 40 - 63
	$i = createEEField($us, 'Crema Desodorante (Cant)'    , 'INTEGER' );      // 41 - 64
	$i = createEEField($us, 'Crema Desodorante (Valor)'   , 'CURRENCY');      // 42 - 65
	$i = createEEField($us, 'Cuchara Acero (Cant)'        , 'INTEGER' );      // 43 - 66
	$i = createEEField($us, 'Cuchara Acero (Valor)'       , 'CURRENCY');      // 44 - 67
	$i = createEEField($us, 'Cuchara Madera (Cant)'       , 'INTEGER' );      // 45 - 68
	$i = createEEField($us, 'Cuchara Madera (Valor)'      , 'CURRENCY');      // 46 - 69
	$i = createEEField($us, 'Estufas (Cant)'              , 'INTEGER' );      // 47 - 70
	$i = createEEField($us, 'Estufas (Valor)'             , 'CURRENCY');      // 48 - 71
	$i = createEEField($us, 'Hamacas (Cant)'              , 'INTEGER' );      // 49 - 72
	$i = createEEField($us, 'Hamacas (Valor)'             , 'CURRENCY');      // 50 - 73
	$i = createEEField($us, 'Jabón Baño (Cant)'           , 'INTEGER' );      // 51 - 74
	$i = createEEField($us, 'Jabón Baño (Valor)'          , 'CURRENCY');      // 52 - 75
	$i = createEEField($us, 'Jabón Barra (Cant)'          , 'INTEGER' );      // 53 - 76
	$i = createEEField($us, 'Jabón Barra (Valor)'         , 'CURRENCY');      // 54 - 77
	$i = createEEField($us, 'Juego Cubiertos (Cant)'      , 'INTEGER' );      // 55 - 78
	$i = createEEField($us, 'Juego Cubiertos (Valor)'     , 'CURRENCY');      // 56 - 79
	$i = createEEField($us, 'Ollas (Cant)'                , 'INTEGER' );      // 57 - 80
	$i = createEEField($us, 'Ollas (Valor)'               , 'CURRENCY');      // 58 - 81
	$i = createEEField($us, 'Papel Higiénico (Cant)'      , 'INTEGER' );      // 59 - 82
	$i = createEEField($us, 'Papel Higiénico (Valor)'     , 'CURRENCY');      // 60 - 83
	$i = createEEField($us, 'Peinilla (Cant)'             , 'INTEGER' );      // 61 - 84
	$i = createEEField($us, 'Peinilla (Valor)'            , 'CURRENCY');      // 62 - 85
	$i = createEEField($us, 'Plástico Negro (Cant)'       , 'INTEGER' );      // 63 - 86
	$i = createEEField($us, 'Plástico Negro (Valor)'      , 'CURRENCY');      // 64 - 87
	$i = createEEField($us, 'Plato Hondo (Cant)'          , 'INTEGER' );      // 65 - 88
	$i = createEEField($us, 'Plato Hondo (Valor)'         , 'CURRENCY');      // 66 - 89
	$i = createEEField($us, 'Plato Pando (Cant)'          , 'INTEGER' );      // 67 - 90
	$i = createEEField($us, 'Plato Pando (Valor)'         , 'CURRENCY');      // 68 - 91
	$i = createEEField($us, 'Pocillo (Cant)'              , 'INTEGER' );      // 69 - 92
	$i = createEEField($us, 'Pocillo (Valor)'             , 'CURRENCY');      // 70 - 93
	$i = createEEField($us, 'Sábanas (Cant)'              , 'INTEGER' );      // 71 - 94
	$i = createEEField($us, 'Sábanas (Valor)'             , 'CURRENCY');      // 72 - 95
	$i = createEEField($us, 'Sobrecamas (Cant)'           , 'INTEGER' );      // 73 - 96
	$i = createEEField($us, 'Sobrecamas (Valor)'          , 'CURRENCY');      // 74 - 97
	$i = createEEField($us, 'Toallas (Cant)'              , 'INTEGER' );      // 75 - 98
	$i = createEEField($us, 'Toallas (Valor)'             , 'CURRENCY');      // 76 - 99
	$i = createEEField($us, 'Toldillos (Cant)'            , 'INTEGER' );      // 77 - 100
	$i = createEEField($us, 'Toldillos (Valor)'           , 'CURRENCY');      // 78 - 101
	$i = createEEField($us, 'Kit Aseo (Cant)'             , 'INTEGER' );      // 79 - 102
	$i = createEEField($us, 'Kit Aseo (Valor)'            , 'CURRENCY');      // 80 - 103
	$i = createEEField($us, 'Kit Cocina (Cant)'           , 'INTEGER' );      // 81 - 104
	$i = createEEField($us, 'Kit Cocina (Valor)'          , 'CURRENCY');      // 82 - 105
	$i = createEEField($us, 'Kit Alcoba (Cant)'           , 'INTEGER' );      // 83 - 106
	$i = createEEField($us, 'Kit Alcoba (Valor)'          , 'CURRENCY');      // 84 - 107
	$i = createEEField($us, 'Meanenes (Valor)'            , 'CURRENCY');      // 85 - 108
	$i = createEEField($us, 'Sacos (Cantidad)'            , 'INTEGER' );      // 86 - 109
	$i = createEEField($us, 'Sacos (Valor)'               , 'CURRENCY');      // 87 - 110
	$i = createEEField($us, 'Mercados (Cant)'             , 'INTEGER' );      // 88 - 111
	$i = createEEField($us, 'Mercados (Valor)'            , 'CURRENCY');      // 89 - 112
	$i = createEEField($us, 'Cemento (Cant)'              , 'INTEGER' );      // 90 - 113
	$i = createEEField($us, 'Cemento (Valor)'             , 'CURRENCY');      // 91 - 114
	$i = createEEField($us, 'Tejas (Cant)'                , 'INTEGER' );      // 92 - 115
	$i = createEEField($us, 'Tejas (Valor)'               , 'CURRENCY');      // 93 - 116
}

</script>
