<?php
    class Jaime {
        public function sleepWith($m) {
            $name = get_class($m);
            switch($name) {
                case("Tyrion"):
                    echo "Not even if I'm drunk !\n";
                    break;
                case("Sansa"):
                    echo "Let's do this.\n";
                    break;
                case("Cersei"):
                    echo "With pleasure, but only in a tower in Winterfell, then.\n";
                    break;
            }
        }
    }