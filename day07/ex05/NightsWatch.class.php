<?php
    class NightsWatch {
        public static $recruits = array();
        
        public function recruit($c) {
            $this->recruits[] = $c;
        }
        public function fight() {
            for ($i = 0; $i < count($this->recruits); $i++)
            {
                $inter = class_implements($this->recruits[$i]);
                if ($inter["IFighter"] == "IFighter")
                    $this->recruits[$i]->fight();
            }
        }
    }