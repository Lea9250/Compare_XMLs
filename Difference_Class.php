<?php

/* 
Compare two machines arrays
Returns array of differences btw main array and other array
*/
class Difference {
    // public $differences = array();

    function getDifferencesV1($mainDevice, $device) {
        $differences = array();
        foreach($device as $key => $value) {
            // matches array key defined in arrayBis
            if (isset($mainDevice[$key])) {
                // if val is array, reuse function on it 
                if (is_array($value) && (!empty($value))) {
                    $differences[$key] = $this->getDifferencesV1($mainDevice[$key], $value);
                // keys values are not equal = its a diff
                } elseif ($value != $mainDevice[$key]) {
                    $differences[$key] = $value;
                }
            // key doesnt exists in array = its a diff
            } else {
                $differences[$key] = $value;
            }
        }
        return $differences;
    }


    ///////////////////////////////// IGNORE BELOW
    /*
    function isKeyPresent($key, $value, $device) {
        // matches array key defined in arrayBis
        if (isset($device[$key])) {
            echo "$key - $value, <br>";
            // if val is array, reuse function on it 
            if (is_array($value) && (!empty($value))) {
                echo "array and not empty : ";
                var_dump($this->differences);
                $this->differences[$key] = $this->getDifferences($value, $device[$key]);
            // keys values are not equal = its a diff
            } elseif ($value != $device[$key]) {
                $this->differences[$key] = $value;
                echo "value different : ";
                var_dump($this->differences);
            }
        // key doesnt exists in both arrays = its a diff
        } else {
            $this->differences[$key] = $value;
        }
    }

    function getDifferences($mainDevice, $device) {
        foreach($mainDevice as $key => $value) {
            // matches array key defined in arrayBis
            $this->isKeyPresent($key, $value, $device);
        }
    } */



    /* function getDifferencesV2($mainDevice, $device) {
        foreach($mainDevice as $key => $value) {
            if (isset($device[$key])) {
                $this->valueCheck($key, $value, $device);
            } else {
                $this->addDiff($key, $value);
            }
        }
    }

    function valueCheck($key, $value, $device) {
        if (is_array($value) && (!empty($value))) {
            // this line does not work whyyyyyyyyyyyyyyy
            echo " values before fail : $key - $value, <br>";
            $this->differences[$key] = $this->getDifferencesV2($value, $device[$key]);
        } elseif ($value != $device[$key]) {
            echo " works well if not array, values : $key - $value, <br>";
            $this->addDiff($key, $value);
        }
    }

    function addDiff($key, $value) {
        $this->differences[$key] = $value;
    } */
}

?>