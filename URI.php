<?php
namespace Anchor;

class URI
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

	static private function patternToRegex($pattern)
	{
		foreach (self::$expr_regexes as $expr => $regex) {
			$pattern = preg_replace($expr, $regex, $pattern);
		}

		return "#^$pattern$#";
	}

	private $pattern;

	public function __construct($pattern)
	{
		$this->pattern = $pattern;
	}

	public function toRegex()
	{
		return self::patternToRegex($this->pattern);
	}

	public function parseParameters($str)
	{
		preg_match_all($this->toRegex(), $str, $values);

		array_shift($values); //throw away full pattern

		preg_match_all(self::$identifier_regex, $this->pattern, $keys);
		$keys = $keys[1];

		$map = array();

		for ($i=0; $i<count($keys); $i++) {
			if (!count($values[$i])) {
				var_dump('busted', $str, $this->toRegex(), $keys, $values);
			}
			$map[ $keys[$i] ] = $values[$i][0];
		}

		return $map;
	}

	public function matches($str)
	{
		return (boolean)preg_match($this->toRegex(), $str);
	}

	public function toString($str)
	{
		$pattern = $this->pattern;
		$params = $this->parseParameters($str);
		foreach ($params as $key => $val) {
			$pattern = preg_replace(
				'#' . self::$identifier_sym_regex . $key . '#',
				$val,
				$pattern
			);
		}

		return $pattern;
	}
}
