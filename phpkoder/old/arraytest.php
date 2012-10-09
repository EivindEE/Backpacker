<html>
<head>
<title>Indexed Arrays</title>
</head>

<body>
<h1>Indexed Arrays</h1>
<?php 
function multisort($array, $sort_by) {
    foreach ($array as $key => $value) {
        $evalstring = '';
        foreach ($sort_by as $sort_field) {
            $tmp[$sort_field][$key] = $value[$sort_field];
            $evalstring .= '$tmp[\'' . $sort_field . '\'], ';
        }
    }
    $evalstring .= '$array';
    $evalstring = 'array_multisort(' . $evalstring . ');';
    eval($evalstring);

    return $array;
} 

$test = array(
    array( 'a' => '1', 'b' => '3'),
    array( 'a' => '2', 'b' => '1'),
    array( 'a' => '1', 'b' => '1'));

echo 'Unsorted: ';
print_r($test);

$result = multisort( $test , array('a','b') );

echo 'Sorted: ';
print_r($result);
?>
 

</body>
</html>