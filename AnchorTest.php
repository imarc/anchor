<?php

class AnchorTest extends PHPUnit_Framework_TestCase
{
	static public function setUpBeforeClass()
	{
		require_once 'Anchor.php';
		require_once 'Route.php';

		Anchor::add('/',                 'Foo::bar');
		Anchor::add('/:section/:method', 'Home::*method');
	}

	public function testResolve()
	{
		$this->assertEquals(
			'Foo::bar',
			Anchor::resolve('/')
		);

		$this->assertEquals(
			'Home::bananas',
			Anchor::resolve('/about/bananas')
		);
	}
}
