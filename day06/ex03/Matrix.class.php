<?php
require_once 'Vector.class.php';
/**
 * 
 */
class Matrix
{
	const IDENTITY = "IDENTITY";
	const SCALE = "SCALE";
	const RX = "Ox ROTATION";
	const RY = "Oy ROTATION";
	const RZ = "Oz ROTATION";
	const TRANSLATION = "TRANSLATION";
	const PROJECTION = "PROJECTION";


	public static $verbose = False;
	private $_preset;
	private $_scale;
	private $_angle;
	private $_vtc;
	private $_fov;
	private $_ratio;
	private $_near;
	private $_far;
	protected $_matrix;

	function __construct(array $arr)
	{
		if (isset($arr) && isset($arr['preset']))
		{
			$this->_preset = $arr['preset'];
			$this->_scale = (isset($arr['scale'])) ?? null;
			$this->_angle = (isset($arr['angle'])) ?? null;
			$this->_vtc = (isset($arr['vtc'])) ?? null;
			$this->_fov = (isset($arr['fov'])) ?? null;
			$this->_ratio = (isset($arr['ratio'])) ?? null;
			$this->_near = (isset($arr['near'])) ?? null;
			$this->_far = (isset($arr['far'])) ?? null;
			$this->setMatrix();
		}
	}

	private function setMatrix()
	{
		$this->_matrix = [
			new Ve
		];
	}
}