<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\AutentificadorJWT;
use App\Models\PDO\empleado;
use App\Models\PDO\pedido;
use App\Models\PDO\mesa;

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

	class EmpleadoMiddleware{
		///Valida el token.
		public static function ValidarToken($request,$response,$next){
			if ($request->getHeader('Token') != null) {
				$token = $request->getHeader('Token')[0];
				try {
					if (AutentificadorJWT::VerificarToken($token)) {
						$usuario = AutentificadorJWT::ObtenerData($token);
						$request = $request->withAttribute('usuario', $usuario);
						$response = $next($request, $response);
						return $response;
					}
				} catch (Exception $e) {
					return $response->withJson($e->getMessage());
				}
			}else{
				$response->getBody()->write('Acceso denegado - SE NECESITA UN TOKEN');
				return $response;
			}
		}

		/// Sólo puede acceder un empleado de tipo socio a esta característica.
		public static function ValidarSocio($request,$response,$next){
			$token = $request->getHeader('Token')[0];
			// $parametros=$request->getParsedBody();
			// $token = $parametros["token"];
			try{
				$data = AutentificadorJWT::ObtenerTipo($token);
				if($data == "Socio")
				{
					$newResponse = $next($request,$response);
				}
				else{
					$newResponse = $response->withJson("Esta accion solo la puede cumplir un socio",200);
				}
			}
			catch(Exception $e){
				
				$newResponse = $response->withJson("Ha ocurrido un error. Verificar",200);
			}
			//$newResponse->getBody()->write($data);
			return $newResponse;
		}

		/// Sólo puede acceder un empleado de tipo mozo o socio a esta característica.
		public static function ValidarMozo($request,$response,$next){
			try{
				$token = $request->getHeader('Token')[0];
				$data = AutentificadorJWT::ObtenerTipo($token);
				if($data == "Mozo" || $data == "Socio"){
					return $next($request,$response);
				}
				else{
					$respuesta = array("Estado" => "ERROR", "Mensaje" => "No tienes permiso para realizar esta accion (Solo categoria mozo).");
					$newResponse = $response->withJson($respuesta,200);
					//$newResponse->getBody()->write($data);
					return $newResponse;
				}
			}
			catch(Exception $e){
				
				$newResponse = $response->withJson("Ha ocurrido un error. Verificar",200);
			}
			//$newResponse->getBody()->write($data);
			return $newResponse;
		}
	}

	class EncuestaMiddleware{
		///Valida los datos de la encuesta
		public static function ValidarEncuesta($request, $response, $next)
		{
			$parametros = $request->getParsedBody();
			$puntuacionMesa = $parametros["puntuacionMesa"];
			$codigoMesa = $parametros["codigoMesa"];
			$puntuacionRestaurante = $parametros["puntuacionRestaurante"];
			$puntuacionMozo = $parametros["puntuacionMozo"];
			$puntuacionCocinero = $parametros["puntuacionCocinero"];

			$mesa = Mesa::ObtenerPorCodigo($codigoMesa);

			if ($puntuacionMesa < 1 || $puntuacionMesa > 10 || $puntuacionRestaurante < 1 || $puntuacionRestaurante > 10 ||
			$puntuacionMozo < 1 || $puntuacionMozo > 10 || $puntuacionCocinero < 1 || $puntuacionCocinero > 10) {
				$retorno = array("Estado" => "ERROR", "Mensaje" => "La puntuación debe ser entre 1 y 10.");
				$newResponse = $response->withJson($retorno, 200);
			} else if ($mesa == null) {
				$retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo de mesa incorrecto.");
				$newResponse = $response->withJson($retorno, 200);
			}
			else {
				$newResponse = $next($request, $response);
			}
			
			return $newResponse;
		}
	}

	class OperacionMiddleware
	{
		///Suma una operación al empleado.
		public static function SumarOperacionAEmpleado($request, $response, $next)
		{
			//$payload = $request->getAttribute("payload")["Payload"];
			$token = $request->getHeader('Token')[0];
			$data = AutentificadorJWT::ObtenerID($token);

			empleado::SumarOperacion($data);
			// $token = $request->getHeader('Token')[0];
			//echo($data);
			
			return $next($request, $response);
		}
	}

	class PedidoMiddleware
	{
		public static function ValidarTomarPedido($request, $response, $next)
		{
			$parametros = $request->getParsedBody();
			$codigo = $parametros["codigo"];  
			$pedido = Pedido::ObtenerPorCodigo($codigo);
			$token = $request->getHeader('Token')[0];
			$tipo = AutentificadorJWT::ObtenerTipo($token);

			if ($pedido == null) {
				$retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo incorrecto.");
				$newResponse = $response->withJson($retorno, 200);
			} else {
				$newResponse = $next($request, $response);
			}

			return $newResponse;
		}

		public static function ValidarInformarListoParaServir($request, $response, $next)
		{
			$parametros = $request->getParsedBody();
			$codigo = $parametros["codigo"];  
			$pedido = Pedido::ObtenerPorCodigo($codigo);
			$token = $request->getHeader('Token')[0];
			$id = AutentificadorJWT::ObtenerID($token);

			if ($pedido == null) {
				$retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo incorrecto.");
				$newResponse = $response->withJson($retorno, 200);
			} else {
				$newResponse = $next($request, $response);
			}

			return $newResponse;
		}

		public static function ValidarServir($request, $response, $next)
		{
			$parametros = $request->getParsedBody();
			$codigo = $parametros["codigo"];  
			$pedido = Pedido::ObtenerPorCodigo($codigo);

			if ($pedido == null) {
				$retorno = array("Estado" => "ERROR", "Mensaje" => "Codigo incorrecto.");
				$newResponse = $response->withJson($retorno, 200);
			} else {
				$newResponse = $next($request, $response);
			}

			return $newResponse;
		}
	}

	
	$app->add(function ($req, $res, $next) {
	    $response = $next($req, $res);
	    return $response
	        ->withHeader('Access-Control-Allow-Origin', $this->get('settings')['cors'])
	        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
	        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	});
};
