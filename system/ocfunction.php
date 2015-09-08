<?php
function h($text) {
	$text = trim ( $text );
	$text = htmlspecialchars ( $text );
	$text = addslashes ( $text );
	return $text;
}

function oc_filter($value){
	$value = trim($value);
	$words = array();
	$words[] = "add ";
	$words[] = "and ";
	$words[] = "count ";
	$words[] = "order ";
	$words[] = "table ";
	$words[] = "by ";
	$words[] = "create ";
	$words[] = "delete ";
	$words[] = "drop ";
	$words[] = "from ";
	$words[] = "grant ";
	$words[] = "insert ";
	$words[] = "select ";
	$words[] = "truncate ";
	$words[] = "update ";
	$words[] = "use ";
	$words[] = "--";
	$words[] = "#";
	$words[] = "group_concat";
	$words[] = "column_name";
	$words[] = "information_schema.columns";
	$words[] = "table_schema";
	$words[] = "union ";
	$words[] = "where ";
	$words[] = "alert";
	$value = strtolower($value);
	foreach($words as $word){
		if(strstr($value,$word)){
			$value = str_replace($word,'',$value);
		}
	}
	return $value;
}

function getRand($proArr) {
	$result = '';
	$proSum = array_sum($proArr);
	foreach ($proArr as $key => $proCur) {
		$randNum = mt_rand(1, $proSum);
		if ($randNum <= $proCur) {
			$result = $key;
			break;
		} else {
			$proSum -= $proCur;
		}
	}
	unset ($proArr);
	return $result;
}

?>