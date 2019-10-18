<?php
	class UnholyFactory {
		private static $_type = array();
		function absorb($s) {
			if (get_parent_class($s) == "Fighter")
			{
				$ss = $s->getType();
				if (!isset($this->_type[$ss]))
				{
					$this->_type[$ss] = $s;
					$t = $s->getType();
					echo "(Factory absorbed a fighter of type $t)\n";
				}
				else
					echo "(Factory already absorbed a fighter of type $t)\n";
			}
			else
				echo "(Factory can't absorb this, it's not a fighter)\n";
		}

		function fabricate($f) {
			if (isset($this->_type[$f]))
			{
				echo "(Factory fabricates a fighter of type $f)\n";
				return ($this->_type[$f]);
			}
			else
			{
				echo "(Factory hasn't absorbed any fighter of type $f)\n";
				return (NULL);
			}
		}
	}