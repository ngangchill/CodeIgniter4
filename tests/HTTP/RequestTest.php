<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var CodeIgniter\HTTP\Request
	 */
	protected $request;

	public function setUp()
	{
	    $this->request = new \CodeIgniter\HTTP\Request(new \App\Config\AppConfig());
	}

	//--------------------------------------------------------------------

	public function testIsAJAXRecognizesAJAX()
	{
		$this->assertFalse($this->request->isAJAX());

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';

		$this->assertTrue($this->request->isAJAX());
	}

	//--------------------------------------------------------------------

	public function ipAddressChecks()
	{
	    return [
	        'empty' => [false, ''],
	        'zero'  => [false , 0],
	        'large_ipv4' => [false, '256.256.256.999', 'ipv4'],
	        'good_ipv4'  => [true, '100.100.100.0', 'ipv4'],
	        'good_default'  => [true, '100.100.100.0'],
	        'zeroed_ipv4' => [true, '0.0.0.0'],
	        'large_ipv6' => [false, 'h123:0000:0000:0000:0000:0000:0000:0000', 'ipv6'],
	        'good_ipv6' => [true, '2001:0db8:85a3:0000:0000:8a2e:0370:7334'],
	        'confused_ipv6' => [false, '255.255.255.255', 'ipv6'],
	    ];
	}

	//--------------------------------------------------------------------

	/**
	 * @dataProvider ipAddressChecks
	 */
	public function testValidIPAddress($expected, $address, $type=null)
	{
		$this->assertEquals($expected, $this->request->validIP($address, $type));
	}

	//--------------------------------------------------------------------

	public function testMethodReturnsRightStuff()
	{
	    $this->assertEquals('', $this->request->method());

		$_SERVER['REQUEST_METHOD'] = 'GET';

		$this->assertEquals('get', $this->request->method());
		$this->assertEquals('GET', $this->request->method(true));
	}

	//--------------------------------------------------------------------

}