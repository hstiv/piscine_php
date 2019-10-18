<?php
	class Vector {
		private $_x;
		private $_y;
		private $_z;
		private $_w = 0.0;
		public static $verbose = false;
        
		function __construct($arr) {
			if (isset($arr['orig']))
				$orig = new Vertex(array('x' => $arr['orig']->getX(), 'y' => $arr['orig']->getY(), 'z' => $arr['orig']->getZ()));
			else
				$orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
			$this->_x = (float) ($arr['dest']->getX() - $orig->getX());
			$this->_y = (float) ($arr['dest']->getY() - $orig->getY());
			$this->_z = (float) ($arr['dest']->getZ() - $orig->getZ());
			if (self::$verbose)
				echo $this->__toString() . " constructed\n";
		}

		function __destruct() {
			if (self::$verbose)
				echo $this->__toString() . " destructed\n";
		}

		public function __toString() {
			return vsprintf("Vector( x: %0.2f, y: %0.2f, z: %0.2f, w: %0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w));
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

		public function doc() {
			echo "\n";
			$file = fopen("Vector.doc.txt", "r");
			while ($file && !feof($file))
				echo fgets($file);
			echo "\n";
		}

		public function magnitude() {
			return ((float)sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)));
		}

		public function normalize() {
			$l = $this->magnitude();
			if ($l == 1)
				return new Vector(array('dest' => new Vertex(array('x' => $this->_x, 'y' => $this->_y, 'z' => $this->_z))));
			return new Vector(array('dest' => new Vertex(array('x' => $this->_x / $l, 'y' => $this->_y / $l, 'z' => $this->_z / $l))));
		}

		public function add($l) {
			return new Vector(array('dest' => new Vertex(array('x' => $this->_x + $l->getX(), 'y' => $this->_y + $l->getY(), 'z' => $this->_z + $l->getZ()))));
		}

		public function sub($l) {
			return new Vector(array('dest' => new Vertex(array('x' => $this->_x - $l->getX(), 'y' => $this->_y - $l->getY(), 'z' => $this->_z - $l->getZ()))));
		}

		public function opposite() {
			return new Vector(array('dest' => new Vertex(array('x' => $this->_x * -1, 'y' => $this->_z * -1, 'z' => $this->_z * -1))));
		}

		public function scalarProduct($k) {
			return new Vector(array('dest' => new Vertex(array('x' => $this->_x * $k, 'y' => $this->_y * $k, 'z' => $this->_z * $k))));
		}

		public function dotProduct($l) {
			return (float) ($this->_x * $l->getX() + ($this->_y * $l->getY()) + ($this->_z * $l->getZ()));
		}

		public function cos($l) {
			return (float) ($this->_x * $l->getX() + $this->_y * $l->getY() + $this->_z + $l->getZ()) / sqrt((pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)) * (pow($l->getX(), 2) + pow($l->getY(), 2) + pow($l->getZ(), 2)));
		}

		public function crossProduct($l) {
			$x = $this->_y * $l->getZ() - $this->_z * $l->getY();
			$y = $this->_z * $l->getX() - $this->_x* $l->getZ();
			$z = $this->_x * $l->getY() - $this->_y * $l->getX();
			return new Vector(array('dest' => new Vertex(array('x' => $x, 'y' => $y, 'z' => $z))));
		}
	}