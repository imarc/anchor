<?php
namespace Anchor;

class Route
{
	static private $expr_regexes = array(
		'/:(\w+)/'  => '([^\/]+)',
		'/\!(\w+)/' => '(\w+)',
		'/\^(\w+)/' => '([0-9]+)',
		'/@(\w+)/'  => '([a-zA-Z]+)',
		'/\*(\w+)/' => '(.+)'
	);

	static private $identifier_sym_regex = '[:!^@*]';

	static private $identifier_regex = '~[:!^@*](\w+)~';

	static private function urlPatternToRegex($pattern)
	{
		foreach (self::$expr_regexes as $expr => $regex) {
			$pattern = preg_replace($expr, $regex, $pattern);
		}

		return "#^$pattern$#";
	}

	private $url_regex = NULL;
	private $url_keys = array();

	private $param_conditions = array();
	private $header_conditions = array();

	private $callback_pattern = NULL;
	private $callback_params = array();
	private $callback_headers = array();

	public function __construct($url_pattern, $callback_pattern)
	{
		/* Generate and store REGEX for URL. */
		$this->url_regex = self::urlPatternToRegex($url_pattern);

		/* Generate and store parameters used in URL. */
		preg_match_all(self::$identifier_regex, $url_pattern, $parameters);
		$this->url_keys = $parameters[1];


		$this->callback_pattern = $callback_pattern;
	}

	public function score($url)
	{
		return preg_match(
			$this->url_regex,
			$url
		);
	}


	public function toCallback($url)
	{
		$parameters = $this->getParametersForURL($url);

		$callback = $this->callback_pattern;
		foreach ($parameters as $key => $val) {
			$callback = str_replace("*$key", $val, $callback);
		}

		return $callback;
	}

	private function getParametersForURL($url)
	{
		preg_match_all($this->url_regex, $url, $values);
		array_shift($values); //throw away full match

		$map = array();

		for ($i=0; $i < count($this->url_keys); $i++) {
			$map[ $this->url_keys[$i] ] = $values[$i][0];
		}

		return $map;
	}
}
