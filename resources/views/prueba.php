
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usuarios_sesion="sisacademico";
session_name($usuarios_sesion);
session_start();

require("../../login/conectar.php");
require("funciones.php");
require_once("../../login/class.inputfilter.php");

$ifilter = new InputFilter();
$_POST = $ifilter->process($_POST);
$_GET = $ifilter->process($_GET);

$conexion-> SetFetchMode(ADODB_FETCH_ASSOC);
	//$conexion-> debug = true;

function getRealIP() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		return $_SERVER['HTTP_CLIENT_IP'];
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	return $_SERVER['REMOTE_ADDR'];
}
	//variables

$fecsys = date('Y').date('m').date('d');
$horsys = date('H').date('i');
	//$solicitante = $_SESSION['cod_person'];

$sname = $_POST['usuario'];
	$logeado = $_POST['logeado'];    //****
	$epscdg = $_POST['dependencia'];   //****
	$tposlccdg = $_POST['CmbTpo'];    //****
	$slcdsc = utf8_decode($_POST['detalle_sol']);  //****
	$user = $_POST['usr_est'];   //****
	$responsable = $_POST['edtresponsable'];

	$tipoatencion = $_POST['tipoatencion'];
	$tipopersona = $_POST['TpoPer'];
	$prscdg = 0;
	$tpodoc = $_POST['TpoDoc'];
	$documento = $_POST['documento'];
	$nombre = $_POST['nombre'];
	$celular = $_POST['celular'];
	if (($sname <> "") && ($logeado == 1))
		$correo = $sname."@uac.edu.co";
	else
		$correo = $_POST['email'];


	$anonimo = 0;
	/*if (isset($_POST['anonimo'])){
		$anonimo = 1;
		$nombre = "DirecciÃ³n IP: ".getRealIP();

	}else{
		$anonimo = 0;
	}*/

	if($logeado > 0){
		$sql_per = datos_persona($sname);

		$rs_sql_per = &$conexion->Execute($sql_per);
		//var_dump($sql_per);
		$usuario = $rs_sql_per->fields['USRCDG'];
		$eps = $rs_sql_per->fields['EPSCDG'];
		$solicitante = $rs_sql_per->fields['USRCDG'];
		$prscdg = $rs_sql_per->fields['PRSCDG'];
	}else{
		$usuario = 136670;
		$eps = 162;
		$solicitante = 136670; // Autoservicio
	}

			//genero consecutivo de la solicitud

	$sql_consec = MaxCodigo('WFENCSLC','SLCCNS','');
	$rs_sql_consec = &$conexion->Execute($sql_consec);
	if ($rs_sql_consec->recordCount()){
		$cont = $rs_sql_consec->fields['CODIGO'];
	}
	$consec = $cont + 1;



	$logitud = 5;
	$codigo = substr(md5(microtime()), 1, $logitud);


	//inserto el encabezado de la solicitud
	$sql_insert = "INSERT INTO SIAOBJ.WFENCSLC (SLCCNS, TPOSLCCDG, USRCDG, SLCDSC, SLCFCH, PRIOUSRCDG, RAZONCDG, SLCCNSPRIO, USR, FCH, HRA, ESTREG, EPS) ";
	$sql_insert .= "values (".$consec.",".$tposlccdg.",".$solicitante.",'".$slcdsc."',".$fecsys.",NULL, NULL, 0,".$usuario.",".$fecsys.",".$horsys.","."'ACT',".$eps.")";
	//echo $sql_insert;
	if ($conexion->Execute($sql_insert) == false) {
		print 'Error al momento de insertar nivel uno';
		$sw = false;
		die;
	}
	$consec = $conexion->insert_Id();

	$radicado = 'P'.$tipoatencion."-".date('Y')."-".$consec;
	//inserto los datos del solicitante
	$sql_insert = "";
	$sql_insert = "INSERT INTO SIAOBJ.WFSOLICITANTE (SLCCNS, TIPOPERSONA, ANONIMO, PRSCDG, TIPODOCUMENTO, DOCUMENTO, NOMBRE, CORREO, CELULAR, RADICADO, CODIGO, FCH, HRA) ";
	$sql_insert .= "values (".$consec.",".$tipopersona.",".$anonimo.",".$prscdg.",'".$tpodoc."','".$documento."','".$nombre."', '".$correo."', '".$celular."','".$radicado."','".$codigo."',".$fecsys.",".$horsys.")";
	if ($conexion->Execute($sql_insert) == false) {
		print 'Error al momento de insertar datos de la solicitud';
		$sw = false;
	}

	//pregunto si necesita visto bueno del jefe inmediato
	$sql_vistoBueno = requiereVbo($tposlccdg);//devuelve SI o NO
	$rs_sql_vistoBueno = &$conexion->Execute($sql_vistoBueno);
	if ($rs_sql_vistoBueno->recordCount()){
		$vistoBueno= trim($rs_sql_vistoBueno->fields['VBO']);
	}

	if ($vistoBueno == 'SI'){
		//empleado que aprueba
		$sql_emp = EmpleadoAprobador($eps);
		$rs_sql_emp = &$conexion->Execute($sql_emp);
		if ($rs_sql_emp->recordCount()){
			$aprobador = $rs_sql_emp->fields['PRSCDG'];
			$rs_sql_emp->MoveNext();
		}
		if($solicitante != $aprobador){
			//inserto el detalle de la solicitud
			$sql_insert3 = "";
			$sql_insert3 = "INSERT INTO SIAOBJ.WFDTLSLC (SLCCNS, DTLCNS, PRSCDG, FCHRCB, ESTSLCCDG, USR, FCH, HRA, ESTREG, EPS) ";
			$sql_insert3 .= "values (".$consec.", 1, ".$aprobador.",".$fecsys.", 8,".$usuario.",".$fecsys.",".$horsys.","."'ACT',".$eps.")";
			if ($conexion->Execute($sql_insert3) == false) {
				print 'Error al momento de insertar nivel cuatro';
				$sw = false;
			}
			//enviar correo y notifico al responsable
			echo "<script>
			enviar_correo($consec, 1, 1);//slccns, asunto, estadomax
			</script>
			";
		}else{
			//inserto el detalle de la solicitud
			$sql_insert3 = "";
			$sql_insert3 = "INSERT INTO SIAOBJ.WFDTLSLC (SLCCNS, DTLCNS, PRSCDG, FCHRCB, ESTSLCCDG, USR, FCH, HRA, ESTREG, EPS) ";
			$sql_insert3 .= "values (".$consec.", 1, ".$responsable.",".$fecsys.", 1,".$usuario.",".$fecsys.",".$horsys.","."'ACT',".$eps.")";

if ($conexion->Execute($sql_insert3) == false) {
				print 'Error al momento de insertar nivel cuatro';
				$sw = false;
			}
		//enviar correo y notifico al responsable
			echo "<script>
			enviar_correo($consec, 2, 1);//slccns, asunto, estadomax
			</script>
			";
		}
	//NO requiere visto bueno
	}else{
		//inserto el detalle de la solicitud
		$sql_insert3 = "";
		$sql_insert3 = "INSERT INTO SIAOBJ.WFDTLSLC (SLCCNS, DTLCNS, PRSCDG, FCHRCB, ESTSLCCDG, USR, FCH, HRA, ESTREG, EPS) ";
		$sql_insert3 .= "values (".$consec.", 1, ".$responsable.",".$fecsys.", 1,".$usuario.",".$fecsys.",".$horsys.","."'ACT',".$eps.")";
		//echo $sql_insert3;
		if ($conexion->Execute($sql_insert3) == false) {
			print 'Error al momento de insertar nivel seis';
			$sw = false;
		}

	}

	// AGREGAR SEGUIDORES *********************************************
	$sql_seguidores = "SELECT PRSCDG, SEGUIDOR
	FROM SIAOBJ.WFTIPOSEGUIDOR
	WHERE TIPOATENCIONID = ".$tipoatencion."
	AND TPOSLCCDG = ".$tposlccdg."
	AND ESTREG = 'ACT'
	AND PRSCDG > 0";

	$rs_sql_seguidores = &$conexion->Execute($sql_seguidores);
	if ($rs_sql_seguidores->recordCount()){
		while (!$rs_sql_seguidores->EOF){
			unset($user);
			$seguidor = $rs_sql_seguidores->fields['PRSCDG'];
			$user = explode('@', $rs_sql_seguidores->fields['SEGUIDOR']);
			$sql_insert  = " INSERT INTO SIAOBJ.WFSEGUIDOR values (".$consec.", ".$seguidor.", '".$user[0]."',".$fecsys.",".$horsys.",'ACT', 162)";
			if ($conexion->Execute($sql_insert) == false) {
				echo "<div align='center' ><img src='../image/error.png'/> OcurriÃ³ un error al almacenar la informaciÃ³n...</div>";
				exit();
			}

			$rs_sql_seguidores->MoveNext();
		}
	}
	/*if ($tipoatencion == 1){
		switch ($tposlccdg){
			case 162: case 167:
				$seguidor = 38838; //PEDRO SIERRA
			break;
			case 163: case 165:
				$seguidor = 16; //MONICA VARGAS (565), ILSY (16)
			break;
			case 164: case 166:
				$seguidor = 36517; // JESUS PANTOJA
			break;
		}

		//$seguidor = 2;
		$sql_insert  = " INSERT INTO SIAOBJ.WFSEGUIDOR values (".$consec.", ".$seguidor.", 'autoservicio.uac',".$fecsys.",".$horsys.",'ACT', 162)";
		if ($conexion->Execute($sql_insert) == false) {
			echo "<div align='center' ><img src='../image/error.png'/> OcurriÃ³ un error al almacenar la informaciÃ³n...</div>";
			exit();
		}

	}elseif ($tipoatencion == 3){
		switch ($tposlccdg){
			case 211: case 212: case 213: case 214: case 215: case 216: case 217: case 218: case 219:
				$seguidor = 35543;
				$usuario = 'johann.abaunza';

				$sql_insert  = " INSERT INTO SIAOBJ.WFSEGUIDOR values (".$consec.", ".$seguidor.", '".$usuario."',".$fecsys.",".$horsys.",'ACT', 162)";
				if ($conexion->Execute($sql_insert) == false) {
					echo "<div align='center' ><img src='../image/error.png'/> OcurriÃ³ un error al almacenar la informaciÃ³n...</div>";
					exit();
				}

			break;
		}

	}*/
	//*******************************************************************
	$carpeta = '../files_temp';
	$total_ficheros = count(glob($carpeta."/{".$_SESSION['cod_anonimo']."*.*}",GLOB_BRACE));

	if  ($total_ficheros > 0){
		$solicitud = $consec;
		$estmax = 1;

		if(is_dir($carpeta)){
			if($dir = opendir($carpeta)){
				while(($archivo = readdir($dir)) !== false){
					if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
						$partes = explode("=", $archivo);
						if ($partes[0] == $_SESSION['cod_anonimo']) {

							$sql = "SELECT coalesce(MAX(ARCHIVOCDG),0) MAXI FROM SIAOBJ.WFFILES
							WHERE SLCCNS = ".$solicitud;
							$rs = $conexion->Execute($sql);
							if ($rs->fields['MAXI'] >= 1){
								$cons = $rs->fields['MAXI'] + 1;
							}else{
								$cons = 1;
							}

							$fichero = "../files_temp/".$archivo;
							$nuevo_fichero = "../files/".$solicitud."_".$cons."_".$partes[1];
							if (!copy($fichero, $nuevo_fichero)) {
								echo "Error al copiar $fichero...\n";
							}else{
								$size = filesize($fichero);
								unlink($fichero);

								$sql2 = "INSERT INTO SIAOBJ.WFFILES
								(SLCCNS, ARCHIVOCDG, ARCHIVO, SIZE, ARCHIVODSC, USR, FCH, HRA, ESTREG, EPS)
								VALUES
								(".$solicitud.", ".$cons.", '".utf8_decode($partes[1])."', ".$size.", '', 136670,".$fecsys.",".$horsys.","."'ACT',".$eps.")";
								$rs2 = $conexion->Execute($sql2);

							}

						}
					}
				}
				closedir($dir);
			}
		}
	}
	echo "|".$consec."|".$radicado."|".$codigo;
	?>

