<?php

use App\Models\AutentificadorJWT;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\Log;


include_once __DIR__ . '/app/modelORM/log.php';
//include_once __DIR__ . '/app/modelPDO/genericDao.php';

return function (App $app) {
  
  	$container = $app->getContainer();

	

	$app->add(function ($req, $res, $next) use ($container) {
		$info=array();
		$info["metodo"]=$req->getMethod();
		$info["URI"]=$req->getUri()->getBaseUrl();
		$info["RUTA"]=$req->getUri()->getPath();
		$info["autoridad"]=$req->getUri()->getAuthority();
		
		$datos=implode(";", $info);
		$datos=http_build_query( $info,'',', ');
		$container->get('logger')->info($datos);
       // $container->get('logger')->addCritical('Hey, a critical log entry!');
	    $response = $next($req, $res);
	    return $response;
	});

	$app->add(function ($req, $res, $next) use ($container) {
				
			$id="no anda";
			  if (isset($_SERVER)) {

			        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			            $id= $_SERVER["HTTP_X_FORWARDED_FOR"];
			        
			        if (isset($_SERVER["HTTP_CLIENT_IP"]))
			            $id= $_SERVER["HTTP_CLIENT_IP"];

			        $id= $_SERVER["REMOTE_ADDR"];
				    }

				    if (getenv('HTTP_X_FORWARDED_FOR'))
				        $id= getenv('HTTP_X_FORWARDED_FOR');

				    if (getenv('HTTP_CLIENT_IP'))
				        $id= getenv('HTTP_CLIENT_IP');

				    $id= getenv('REMOTE_ADDR');
			$container->get('IPlogger')->info("ip =".$id);
			$response = $next($req, $res);
		    return $response;
		});

	$app->add(function ($req, $res, $next) use ($container) {
		
			# devolvemos el array de valores
			$informacion['Datos'] = $_SERVER['HTTP_USER_AGENT'];
			
			$container->get('IPlogger')->info("Datos  =".$informacion['Datos']);
			$response = $next($req, $res);
		    return $response;
		});


function detect()
{
	$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WIN","MAC","LINUX");
 
	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";
 
	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
		$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
		$f = $s + strlen($parent);
		$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
		$version = preg_replace('/[^0-9,.]/','',$version);
		if ($s)
		{
			$info['browser'] = $parent;
			$info['version'] = $version;
		}
	}
 
	# obtenemos el sistema operativo
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info['os'] = $val;
	}
 
	# devolvemos el array de valores
	return $info;
}







	$app->add(function ($req, $res, $next) {
	    $response = $next($req, $res);
	    return $response
	        ->withHeader('Access-Control-Allow-Origin', $this->get('settings')['cors'])
	        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
	        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	});
};


class middle
{
	function logGuardar($req, $res, $next)
	{
		$token = "";
		$usuario = "undefined";
		if (array_key_exists("HTTP_TOKEN", $req->getHeaders())) {
			try {
				$token = $req->getHeader("token")[0];
				AutentificadorJWT::VerificarToken($token);
					$data = AutentificadorJWT::ObtenerData($token);
					$data = $data->email . " - " . $data->legajo;
					$usuario = $data;
				
			} catch (\Exception $e) {
				$newResponse = $res->withJson("sarasa", 200);
				}
		}
		$ruta = $req->getRequestTarget();
		$metodo = $req->getMethod();
		$ip = $req->getServerParam('REMOTE_ADDR');
		$fecha = date('Y-m-d H:i:s', $req->getServerParam('REQUEST_TIME'));
		$log = new Log;
		$log->ruta = $ruta;
		$log->metodo = $metodo;
		$log->usuario = $usuario;
		$log->ip = $ip;
		$log->fecha = $fecha;
		$dao = new genericDao("./info.json");
		$dao->guardar($log);
		$newResponse = $next($req, $res); // Se va a la funcion NEXT
		//$newResponse->getbody()->write("Log Creado" . " USUARIO: ". $usuario);
		return $newResponse;
	}

	function validarToken($req, $res, $next)
	{
		if ($req->getHeader('token') != null) {
			$token = $req->getHeader('token')[0];
			try {
				if (AutentificadorJWT::VerificarToken($token)) {
					$usuario = AutentificadorJWT::ObtenerData($token);
					$req = $req->withAttribute('usuario', $usuario);
					$res = $next($req, $res);
					return $res;
				}
			} catch (Exception $e) {
				return $res->withJson($e->getMessage());
			}
		}else{
			$res->getBody()->write('Acceso denegado - SE NECESITA UN TOKEN');
			return $res;
		}
	}

	function autorizadoAlumno($req, $res ,$next){
		$usuario = $req->getAttribute('usuario');
		if($usuario->tipo == 'admin' || $usuario->usuario == $req->getParsedBody()['usuario']){	
			$res = $next($req,$res);
			return $res;
		}else{
			$res->getBody()->write('Usuario no autorizado');
			return $res;
		}
	}

	function autorizadoAdmin($req, $res ,$next){
		$usuario = $req->getAttribute('usuario');
		if($usuario->tipo == 'admin'){	
			$res = $next($req,$res);
			return $res;
		}else{
			$res->getBody()->write('Usuario no autorizado');
			return $res;
		}
	}
	
	function autorizadoProfesor($req, $res ,$next){
		$usuario = $req->getAttribute('usuario');
		if($usuario->tipo == 'admin' || $usuario->tipo == 'mozo' ){	
			$res = $next($req,$res);
			return $res;
		}else{
			$res->getBody()->write('Usuario no autorizado');
			return $res;
		}
	}
}