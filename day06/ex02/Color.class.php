<?php

class Color
{
	public $red;
	public $green;
	public $blue;
	public static $verbose = false;

	function __construct($color)
	{
		if (
			isset($color['red']) &&
			isset($color['green']) &&
			isset($color['blue'])
		) {
			$this->red = intval($color['red']);
			$this->green = intval($color['green']);
			$this->blue = intval($color['blue']);
		}
		else if (isset($color['rgb']))
		{
			$rgb = intval($color['rgb']);
			$this->blue = $rgb % 256;
			$this->green = ($rgb / 256) % 256;
			$this->red = (($rgb / 256) / 256) % 256;
		}
		if (self::$verbose == true)
			printf("Color( red: %d, green: %d, blue: %d ) constructed.\n" , $this->red, $this->green, $this->blue);
	}

	public function __toString()
	{
		return "Color( red: $this->red, green: $this->green, blue: $this->blue )";
	}

	function __destruct()
	{
		if (self::$verbose == true)
			printf("Color( red: %d, green: %d, blue: %d ) destructed.\n", $this->red, $this->green, $this->blue);
	}

	public static function doc()
	{
		echo "\n";
		$file = fopen("Color.doc.txt", "r");
		while ($file && !feof($file))
			echo fgets($file);
		echo "\n";
	}

	public function add($an_inst)
	{
		return (new Color([
			"red" => $an_inst->red + $this->red, 
			"green" => $an_inst->green + $this->green,
			"blue" => $an_inst->blue + $this->blue
		]));
	}

	public function sub($an_inst)
	{
		return (new Color([
			"red" => $an_inst->red - $this->red, 
			"green" => $an_inst->green - $this->green,
			"blue" => $an_inst->blue - $this->blue
		]));
	}

	public function mult($an_inst)
	{
		return (new Color([
			"red" => $an_inst->red * $this->red, 
			"green" => $an_inst->green * $this->green,
			"blue" => $an_inst->blue * $this->blue
		]));
	}

	function __destruct()
	{
		if (self::$verbose == true)
			printf("Color( red: %d, green: %d, blue: %d ) destructed.\n", $this->red, $this->green, $this->blue);
	}
}