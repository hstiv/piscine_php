<?php
    class Tyrion {
        public function sleepWith($m) {
            $name = get_class($m);
            switch($name) {
                case("Jaime"):
                    echo "Not even if I'm drunk !\n";
                    break;
                case("Sansa"):
                    echo "Let's do this.\n";
                    break;
                case("Cersei"):
                    echo "Not even if I'm drunk !\n";
                    break;
            }
        }
    }