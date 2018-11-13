<?php
//Environment
session_start();
$rq = $_REQUEST;
$class = '';
$h1 = 'Notas';
include_once("classes/loader.php");
include_once("config.php");
//Recaptcha
function checkRecaptcha($recaptcha) {	
	global $config;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');		
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=".$config["recaptchaPrivateKey"]."&response=".$recaptcha);
	$data = json_decode(curl_exec($ch));						
	curl_close($ch);						
	if ($data && isset($data->success)) { 
		return $data->success;
	} else {
		return false;
	}
}

//Control de Acceso
if (isset($rq['password']) && isset($rq["accion"]) && $rq["accion"] == "login") {
	$_SESSION['pwd'] = $rq['password'];
}
if (!isset($_SESSION['pwd'])) $_SESSION['pwd'] = '';
if (
	!isset($_SESSION) || 
	$_SESSION['pwd'] != $config['pwd'] || 
	(isset($config['recaptchaPublicKey'] && !empty($config['recaptchaPublicKey']) && isset($_REQUEST['g-recaptcha-response']) && checkRecaptcha($_REQUEST['g-recaptcha-response']) == false)
) {	
	if ($_SESSION['pwd'] != '') {
		$flag_pwd = 1;		
	}
	unset($_SESSION['pwd']);	
	$h1 = 'Login';
	$layout = "login.php";
	include_once("views/layout.php");
	die();
}
//SQL
$link = mysqli_connect($config['DBhost'], $config['DBuser'], $config['DBpwd'], $config['DBdb']);
//Set Object
$obj = new Notas($link);
$array_coleccion = $obj->getCollection();
$json_coleccion = json_encode($array_coleccion);
//Max pos.
$max = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(pos) FROM notas"))['max(pos)'];
//Routing
if (!isset($rq) || empty($rq['accion'])) $rq['accion'] = "list";
switch ($rq['accion']) {
	case 'logout':
		// Destruir todas las variables de sesión.
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finalmente, destruir la sesión.
		session_destroy();
		header('Location: index.php');
	break;
	case 'move':		
		$obj->getByID($rq['id']);
		$obj->movePosition($rq['pos']);
		header('Location: index.php');
	break;
	case 'upload':
		die(Upload::upload_imagen()['error']);
	break;
	case 'add':		
		foreach ($rq['form'] as $k => $v) {
			$obj->data[$k] = $v;
		}
		$obj->insert();
		header('Location: index.php');
	break;
	case 'update':		
		$obj->data['id'] = $rq['id'];
		foreach ($rq['form'] as $k => $v) {			
			$obj->data[$k] = $v;
		}
		$obj->update();		
		header('Location: index.php');
	break;
	case 'del':		
		$obj->data['id'] = $rq['id'];
		$obj->delete();
		$obj->resetPositions();
		header('Location: index.php');
	break;	
	default:		
		$layout = "list.php";
	break;	
}
include_once("views/layout.php");
?>
