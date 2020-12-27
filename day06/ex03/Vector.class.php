<?php
require_once 'Vertex.class.php';
/**
 * 
 */
class Vector
{
	private $_x;
	private $_y;
	private $_z;
	private $_w = 0.0;
	public static $verbose = False;
	
	function __construct(array $arr)
	{
		if (isset($arr['orig']))
			$orig = new Vertex(array('x' => $arr['orig']->getX(), 'y' => $arr['orig']->getY(), 'z' => $arr['orig']->getZ()));
		else
			$orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
		if (isset($arr['dest']))
		{
			$this->_x = (float) ($arr['dest']->getX() - $orig->getX());
			$this->_y = (float) ($arr['dest']->getY() - $orig->getY());
			$this->_z = (float) ($arr['dest']->getZ() - $orig->getZ());
		}
		if (self::$verbose == True)
			echo $this->__toString() . " constructed\n";
	}

	public function __toString()
	{
		return vsprintf("Vector( x: %0.2f, y: %0.2f, z: %0.2f, w: %0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w));
	}

	function __destruct()
	{
		if (self::$verbose == True)
			echo $this->__toString() . " destructed\n";
	}

	public function getX() {
		return (float)$this->_x;
	}

	public function getY() {
		return (float)$this->_y;
	}

	public function getZ() {
		return (float)$this->_z;
	}

	public function getW() {
		return (float)$this->_w;
	}

	public function doc()
	{
		echo "\n";
		$file = fopen("Vector.doc.txt", "r");
		while ($file && !feof($file))
			echo fgets($file);
		echo "\n";
	}

	public function magnitude()
	{
		return ((float)sqrt(
			($this->_x * $this->_x) + 
			($this->_y * $this->_y) + 
			($this->_z * $this->_z)
		));
	}

	public function normalize()
	{
		$magnitude = $this->magnitude;
		if ($magnitude == 1)
		{
			return new Vector([
				'dest' => new Vertex([
					'x' => $this->_x,
					'y' => $this->_y,
					'z' => $this->_z 
				])
			]);
		}
		return new Vector([
			'dest' => new Vertex([
				'x' => $this->_x / $magnitude,
				'y' => $this->_y / $magnitude,
				'z' => $this->_z / $magnitude
			])
		]);
	}

	public function add(Vector $rhs)
	{
		return new Vector([
			'dest' => new Vertex([
				'x' => $this->_x + $rhs->_x,
				'y' => $this->_y + $rhs->_y,
				'z' => $this->_z + $rhs->_z
			])
		]);
	}

	public function sub(Vector $rhs)
	{
		return new Vector([
			'dest' => new Vertex([
				'x' => $this->_x - $rhs->_x,
				'y' => $this->_y - $rhs->_y,
				'z' => $this->_z - $rhs->_z
			])
		]);
	}

	public function opposite(Vector $rhs)
	{
		return new Vector([
			'dest' => new Vertex([
				'x' => $this->_x * (-1.0),
				'y' => $this->_y * (-1.0),
				'z' => $this->_z * (-1.0)
			])
		]);
	}

	public function Vector scalarProduct($k)
	{
		return new Vector([
			'dest' => new Vertex([
				'x' => $this->_x * $k,
				'y' => $this->_y * $k,
				'z' => $this->_z * $k
			])
		]);
	}

	public function float dotProduct(Vector $rhs)
	{
		return (float) (
				$this->_x * $rhs->_x +
				$this->_y * $rhs->_y +
				$this->_z * $rhs->_z
			);
	}

	public function float cos(Vector $rhs)
	{
		$dotProduct = $this->dotProduct($rhs);
		return (float) ($this->dotProduct($rhs) / ($this->magnitude() * $rhs->magnitude()));
	}

	public function Vector crossProduct(Vector $rhs)
	{
		return new Vector([
			'dest' => new Vertex([
				'x' => $this->_y * $rhs->_z - $this->_z * $rhs->_y,
				'y' => $this->_z * $rhs->_x - $this->_x * $rhs->_z,
				'z' => $this->_x * $rhs->_y - $this->_y * $rhs->_x
			])
		]);
	}
}