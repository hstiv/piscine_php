<?php

	class Vertex {
		private $_x;
		private $_y;
		private $_z;
		private $_w = 1.0;
		private $_color;
		public static $verbose = false;

		function __construct($arr) {
			if (isset($arr['x']) && isset($arr['y']) && isset($arr['z']))
			{
				$this->_x = floatval($arr['x']);
				$this->_y = floatval($arr['y']);
				$this->_z = floatval($arr['z']);
			}
			if (isset($arr['color']))
				$this->_color = $arr['color'];
			else
				$this->_color = new Color(array('red'=> 255, 'green' => 255, 'blue' => 255));
			if (isset($arr['w']))
				$this->_w = floatval($arr['w']);
			if (self::$verbose == true)
				printf("Vertex ( x: %d, y: %d, z: %d, w: %d, color: %s ) constructed\n", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->__toString());
		}

		public function __toString() {
			return vsprintf("Vertex( x: %0.2f, y: %0.2f, z: %0.2f, w: %0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w));
		}
		
		function __destruct() {
			if (self::$verbose == true)
				printf("Vertex ( x: %d, y: %d, z: %d, w: %d, color: %s ) destructed\n", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->__toString());
		}

		static function doc() {
			echo "\n";
			$file = fopen("Vertex.doc.txt", "r");
			while ($file && !feof($file))
				echo fgets($file);
			echo "\n";
		}

		public function getX() {
			return (float) $this->_x;
		}

		public function getY() {
			return (float) $this->_y;
		}

		public function getZ() {
			return (float) $this->_z;
		}

		public function getW() {
			return (float) $this->_w;
		}

		public function getColor() {
			return new Color(array($this->_color->red, $this->_color->gree, $this->_color->blue));
		}

		public function setX($d) {
			if (isset($d))
				$this->_x = $d;
		}

		public function setY($d) {
			if (isset($d))
				$this->_y = $d;
		}

		public function setZ($d) {
			if (isset($d))
				$this->_z = $d;
		}

		public function setW($d) {
			if (isset($d))
				$this->_w = $d;
		}

		public function setColor($col) {
			$this->_color = new Color($col);
		}
    }
?>