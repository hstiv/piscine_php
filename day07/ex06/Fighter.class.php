<?php
    class Fighter {
        private $_s;
        function __construct($s) {
            $this->_s = $s;
        }

        function getType() {
            return ($this->_s);
        }
    }