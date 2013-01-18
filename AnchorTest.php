<?php

class AnchorTest extends PHPUnit_Framework_TestCase
{
	static public function setUpBeforeClass()
	{
		require_once 'Anchor.php';
		require_once 'URI.php';

		Anchor::add('/',                 'Foo/bar');
		Anchor::add('/:section/:method', 'Home/:method');
		Anchor::add('/*everything',      'Home/bucket');
	}

	public function testResolve()
	{
		$this->assertEquals(
			'Foo/bar',
			Anchor::resolve('/')
		);

		$this->assertEquals(
			'Home/bananas',
			Anchor::resolve('/about/bananas')
		);
	}

	public function testLink()
	{
		$this->assertEquals(
			'/',
			Anchor::link('Foo/bar')
		);
	}
}
