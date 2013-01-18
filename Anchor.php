<?php
class Anchor
{


	static private $uri_map = array();

	// TODO headers
	// TODO $closure
	// TODO 404
	static public function add($url_pattern, $callback_pattern)
	{
		self::$uri_map[] = array(
			new Anchor\URI($url_pattern),
			new Anchor\URI($callback_pattern)
		);
	}

	static public function check($url)
	{
		foreach (self::$uri_map as $pair) {
			list($in_uri, $out_uri) = $pair;
			if ($in_uri->matches($url)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	static public function resolve($url)
	{
		foreach (self::$uri_map as $pair) {
			list($in_uri, $out_uri) = $pair;
			if ($in_uri->matches($url)) {
				return $out_uri->toString($url);
			}
		}

		return FALSE;
	}

	static public function linkable($callback)
	{
		foreach (self::$uri_map as $pair) {
			list($in_uri, $out_uri) = $pair;
			if ($out_uri->matches($callback)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	static public function link($callback)
	{
		foreach (self::$uri_map as $pair) {
			list($in_uri, $out_uri) = $pair;
			if ($out_uri->matches($callback)) {
				return $in_uri->toString($callback);
			}
		}

		return FALSE;
	}
}
