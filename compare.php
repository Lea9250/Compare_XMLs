<?php 
/* 
Comp is failing for the right keys and returning full arrays with check_diff_multi
Returns only DEVICEID with array_diff (but works this time)

TODO (maybe) :
- COMPARE ONE MACHINE TO ANOTHER
- RELEVANCE OF TAGS (what do we want to see)
- OOP
- HTML TABLE DISPLAY
- SELECTION OF COMPUTERS AND XML TRANSFER IN OCS REPORTS
- SELECTION FILTER (cant use the same as ocs reports ??)

*/

// xml files -> unique array
function XmlToArray($xmlFiles) {
	$i = 0;
	foreach ($xmlFiles as $xmlFile) {
		//Load xml file 
		$xml = simplexml_load_file($xmlFile);
		// Encode Xml file into Json
		$json = json_encode($xml);
		// Decode ...
		$array = json_decode($json,TRUE);
		$arrays[$i] = $array;
		$i++;
	}

	return $arrays;
}

/* 
Get all similarities between two arrays
*/
function matchesBtwArrays($array1, $array2) {
	$similar = array();
	foreach($array1 as $key => $value) {
		// mainArray key defined in arrayBis
		if (isset($array2[$key])) {
			// if val is array, reuse function on it 
			if (is_array($value) && (!empty($value))) {
				$similar[$key] = matchesBtwArrays($value, $array2[$key]);
			} elseif ($value == $array2[$key]) {
				$similar[$key] = $value;
			}
		} elseif ($value == $array2[$key]) {
			$similar[$key] = $value;
		}
	}
	return $similar;
}


/*
Values present in main array and missing in second array are considered "differences"
------------------
Changing order of comparison returns different differences
Maybe change it then compare arrays of differences and return comparison ?
------------------
 */

// compare an array to array of matches
function compareToMatches($array, $matches) {
	$difference = array();
	foreach($array as $key => $value) {
		// matches array key defined in arrayBis
		if (isset($matches[$key])) {
			// if val is array, reuse function on it 
			if (is_array($value) && (!empty($value))) {
				$difference[$key] = compareToMatches($value, $matches[$key]);
			// keys values are not equal = its a diff
			} elseif ($value != $matches[$key]) {
				$difference[$key] = $value;
			}
		// key doesnt exists in both arrays = its a diff
		} else {
			$difference[$key] = $value;
		}
	}
	return $difference;
}


// transform xml to array
$arrays = XmlToArray(array("xmls/test.xml", "xmls/test2.xml"));
// sort array to get longer one and use it as comparator
arsort($arrays);
// mainArray is comparator template 
$mainArray = array_shift($arrays);
// print_r($mainArray);
// array to compare with
$array = $arrays[0];
// compareArrays between mainArray and array
$matches = matchesBtwArrays($arrays[0], $arrays[1]);

$diffs = compareToMatches($mainArray, $array);
var_dump($diffs);

echo "size of arrays are :";
var_dump(sizeof($arrays[0], TRUE), sizeof($arrays[1], TRUE));
echo "<br>";
echo "size of matches array is :";
var_dump(sizeof($matches, TRUE));

foreach ($arrays as $array) {
	$diffs = compareToMatches($array, $matches);
	echo "<br><br><br>";
	echo "size of array is :";
	var_dump(sizeof($array, TRUE));
	echo "<br>";
	echo "size of differences array is :";
	var_dump(sizeof($diffs, TRUE));
}

echo "<br><br><br>";
echo "SIMILARITIES ARE : ";
var_dump($matches);
echo "<br><br><br>";
var_dump($diffs);


function Table($array) {
	echo "<style>table, th, td {border: 1px solid black;}</style>";
	echo "<table>";
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			Table($value);
		} else {
			echo "<td> $key</td>"; // Get index
			echo "<td> $value</td>"; // Get value
		}	
	}
	echo "</table>";
}

// Table($matches);

?>