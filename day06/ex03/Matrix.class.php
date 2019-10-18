<?php
	class Matrix {
		const IDENTITY = "IDENTITY";
		const SCALE = "SCALE";
		const RX = "Ox ROTATION";
		const RY = "Oy ROTATION";
		const RZ = "Oz ROTATION";
		const TRANSLATION = "TRANSLATION";
		const PROJECTION = "PROJECTION";

		protected $m = array();
		private $_preset;
		private $_scale;
		private $_angle;
		private $_vtc;
		private $_fov;
		private $_ratio;
		private $_near;
		private $_far;
		public static $verbose = false;

		function __construct($arr = NULL) {
			if (isset($arr)) {
				if (isset($arr['preset']))
					$this->_preset = $arr['preset'];
				if (isset($arr['scale']))
					$this->_scale = (float) $arr['scale'];
				if (isset($arr['angle']))
					$this->_angle = (float)$arr['angle'];
				if (isset($arr['vtc']))
					$this->_vtc = $arr['vtc'];
				if (isset($arr['fov']))
					$this->_fov = (float)$arr['fov'];
				if (isset($arr['ratio']))
					$this->_ratio = (float)$arr['ratio'];
				if (isset($arr['near']))
					$this->_near = (float)$arr['near'];
				if (isset($arr['far']))
					$this->_far = (float)$arr['far'];
				for ($i = 0; $i < 16; $i++)
					$this->m[$i] = 0;
				$this->finalEval();
				$this->identity();
				if (Self::$verbose == true && $this->_preset == Self::IDENTITY)
					echo "Matrix " .$this->_preset ." instance consrtucted\n";
				else if (Self::$verbose == true)
					echo "Matrix " .$this->_preset ." preset instance constructed\n";
			}
			$this->setVar();
		}

		private function setVar() {
			switch($this->_preset) {
				case (Self::IDENTITY):
					break;
				case (Self::TRANSLATION):
					$this->translation();
					break;
				case (Self::SCALE):
					$this->scale();
					break;
				case (Self::RX):
					$this->xrotate();
					break;
				case (Self::RY):
					$this->yrotate();
					break;
				case (Self::RZ):
					$this->zrotate();
					break;
				case (Self::PROJECTION):
					$this->projection();
					break;
			}
		}

		private function finalEval() {
			if (!isset($this->_preset))
				return "Error";
			if ($this->_preset == self::SCALE && !isset($this->_scale));
				return "Error";
			if (($this->_preset == self::RX || $this->_preset == self::RY || $this->_preset == self::RZ) && !isset($this->_angle));
				return "Error";
			if ($this->_preset == self::TRANSLATION && !isset($this->_vtc));
				return "Error";
			if ($this->_preset == self::PROJECTION && (!isset($this->_fov) || !isset($this->_ratio) || !isset($this->_near) || !isset($this->_far)));
				return "Error";
		}

		private function identity() {
			$this->m[0] = 1.0;
			$this->m[5] = 1.0;
			$this->m[10] = 1.0;
			$this->m[15] = 1.0;
		}

		private function translation() {
			$this->m[3] = $this->_vtc->getX();
			$this->m[7] = $this->_vtc->getY();
			$this->m[11] = $this->_vtc->getZ();
			$this->m[15] = 1.0;
		}

		private function scale() {
			$this->m[0] = $this->_scale;
			$this->m[5] = $this->_scale;
			$this->m[10] = $this->_scale;
		}

		private function xrotate() {
			$this->m[5] = cos($this->_angle);
			$this->m[6] = -sin($this->_angle);
			$this->m[9] = sin($this->_angle);
			$this->m[10] = cos($this->_angle);
		}

		private function yrotate() {
			$this->m[0] = cos($this->_angle);
			$this->m[2] = sin($this->_angle);
			$this->m[8] = -sin($this->_angle);
			$this->m[10] = cos($this->_angle);
		}

		private function zrotate() {
			$this->m[0] = cos($this->_angle);
			$this->m[1] = -sin($this->_angle);
			$this->m[4] = sin($this->_angle);
			$this->m[5] = cos($this->_angle);
		}

		private function projection() {
			$this->m[5] = 1 / tan(0.5 * deg2rad($this->_fov));
			$this->m[0] = $this->m[5] / $this->_ratio;
			$this->m[15] = 0.0;
			$this->m[10] = -1 * (-$this->_near - $this->_far) / ($this->_near - $this->_far);
			$this->m[14] = -1;
			$this->m[11] = (2 * $this->_near * $this->_far) / ($this->_near - $this->_far);
		}

		function __destruct() {
			echo "Matrix instance destructed\n";
		}

		public function __toString() {
			return (vsprintf("M | vtcX | vtcY | vtcZ | vtx0\n-----------------------------\nx | %0.2f | %0.2f | %0.2f | %0.2f\ny | %0.2f | %0.2f | %0.2f | %0.2f\nz | %0.2f | %0.2f | %0.2f | %0.2f\nw | %0.2f | %0.2f | %0.2f | %0.2f",
					array($this->m[0], $this->m[1], $this->m[2], $this->m[3], $this->m[4], $this->m[5], $this->m[6], $this->m[7],
					$this->m[8], $this->m[9], $this->m[10], $this->m[11], $this->m[12], $this->m[13], $this->m[14], $this->m[15])));
		}

		public function mult(Matrix $l) {
			$m = array();
			$m[0] = $this->m[0] * $l->m[0] + $this->m[1] * $l->m[4] + $this->m[2] * $l->m[8] + $this->m[3] * $l->m[12];
			$m[1] = $this->m[0] * $l->m[1] + $this->m[1] * $l->m[5] + $this->m[2] * $l->m[9] + $this->m[3] * $l->m[13];
			$m[2] = $this->m[0] * $l->m[2] + $this->m[1] * $l->m[6] + $this->m[2] * $l->m[10] + $this->m[3] * $l->m[14];
			$m[3] = $this->m[0] * $l->m[3] + $this->m[1] * $l->m[7] + $this->m[2] * $l->m[11] + $this->m[3] * $l->m[15];
			$m[4] = $this->m[4] * $l->m[0] + $this->m[5] * $l->m[4] + $this->m[6] * $l->m[8] + $this->m[7] * $l->m[12];
			$m[5] = $this->m[4] * $l->m[1] + $this->m[5] * $l->m[5] + $this->m[6] * $l->m[9] + $this->m[7] * $l->m[13];
			$m[6] = $this->m[4] * $l->m[2] + $this->m[5] * $l->m[6] + $this->m[6] * $l->m[10] + $this->m[7] * $l->m[14];
			$m[7] = $this->m[4] * $l->m[3] + $this->m[5] * $l->m[7] + $this->m[6] * $l->m[11] + $this->m[7] * $l->m[15];
			$m[0] = $this->m[8] * $l->m[0] + $this->m[9] * $l->m[4] + $this->m[10] * $l->m[8] + $this->m[11] * $l->m[12];
			$m[1] = $this->m[8] * $l->m[1] + $this->m[9] * $l->m[5] + $this->m[10] * $l->m[9] + $this->m[11] * $l->m[13];
			$m[2] = $this->m[8] * $l->m[2] + $this->m[9] * $l->m[6] + $this->m[10] * $l->m[10] + $this->m[11] * $l->m[14];
			$m[3] = $this->m[8] * $l->m[3] + $this->m[9] * $l->m[7] + $this->m[10] * $l->m[11] + $this->m[11] * $l->m[15];
			$m[4] = $this->m[12] * $l->m[0] + $this->m[13] * $l->m[4] + $this->m[14] * $l->m[8] + $this->m[15] * $l->m[12];
			$m[5] = $this->m[12] * $l->m[1] + $this->m[13] * $l->m[5] + $this->m[14] * $l->m[9] + $this->m[15] * $l->m[13];
			$m[6] = $this->m[12] * $l->m[2] + $this->m[13] * $l->m[6] + $this->m[14] * $l->m[10] + $this->m[15] * $l->m[14];
			$m[7] = $this->m[12] * $l->m[3] + $this->m[13] * $l->m[7] + $this->m[14] * $l->m[11] + $this->m[15] * $l->m[15];
			$res = new Matrix();
			$res->m = $m;
			return ($res);
		}

		public function transformVertex(Vertex $l) {
			$v = array();
			$v['x'] = $l->getX() * $this->m[0] + $l->getY() * $this->m[1] + $l->getZ() * $this->m[2] + $l->getW() * $this->m[3];
			$v['y'] = $l->getX() * $this->m[4] + $l->getY() * $this->m[5] + $l->getZ() * $this->m[6] + $l->getW() * $this->m[7];
			$v['z'] = $l->getX() * $this->m[8] + $l->getY() * $this->m[9] + $l->getZ() * $this->m[10] + $l->getW() * $this->m[11];
			$v['w'] = $l->getX() * $this->m[12] + $l->getY() * $this->m[13] + $l->getZ() * $this->m[14] + $l->getW() * $this->m[15];
			$v['color'] = $l->getColor();
			$vertex = new Vertex($v);
			return ($vertex);
		}

		public function doc() {
			echo "\n";
			$file = fopen("Matrix.doc.txt", "r");
			while ($file && !feof($file))
				echo fgets($file);
			echo "\n";
		}
	}