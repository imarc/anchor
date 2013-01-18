<?php
class Anchor
{


	static private $routes = array();

	// TODO headers
	// TODO $closure
	// TODO 404
	static public function add($url_pattern, $callback_pattern)
	{
		self::$routes[] = new Anchor\Route($url_pattern, $callback_pattern);
	}

	static public function check($url)
	{
		foreach (self::$routes as $route) {
			if ($route->score($url)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	static public function resolve($url)
	{
		$best_score = 0;
		$best_route = NULL;

		foreach (self::$routes as $route) {
			if ( ($score = $route->score($url)) > $best_score) {
				$best_score = $score;
				$best_route = $route;
			}
		}

		return $best_route->toCallback($url);
	}




	//public static function add($map, $callback, $closure=NULL) {}
	public static function alias($alias, $render_map) {}
	public static function authorize($controller) {}
	//public static function check($url) {}
	public static function clear() {}
	public static function disableTrailingSlashRedirect() {}
	public static function &call($callable, $data=NULL, $exit=FALSE) {}
	public static function format($format, $underscorize=FALSE, $default=NULL) {}
	public static function link($callback_key) {}
	//public static function resolve($url, $headers=array(), &$params=array(), &$data=NULL, &$offset=0, &$linkable=TRUE) {}
	public static function run($exit=TRUE) {}
	public static function setRequestPath($request_path) {}
	public static function setFragmentRouting() {}
	public static function setLegacyNamespacing() {}
	public static function addToken($token, $conditions) {}
	public static function triggerNotFound() {}
	public static function triggerContinue() {}
	public static function setCallbackParamName($type, $name) {}
	public static function setControllerPath($path) {}
	public static function setGlobalFunctions() {}
	public static function setCanonicalRedirect() {}
	public static function setURLParamFormatter($callback, $class='*', $param='*') {}
}
