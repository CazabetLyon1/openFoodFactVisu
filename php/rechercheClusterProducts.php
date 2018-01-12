<?php

include_once "../config/config.php";

$mysqli = new mysqli(host, user, password, db);

if ($mysqli->connect_errno) {

    echo "Sorry, this website is experiencing problems.";

    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";

    exit;
}

$mysqli->set_charset("utf8");

$sql = "";

for ($i = 0; $i <= 9; $i++) {
    $sql .= "(SELECT ".$i." as indice, p.index, p.product_name
        FROM finals_products fp 
        INNER JOIN products p On fp.`index` = p.`index` WHERE p.`index` = (SELECT pl.0 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.1 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.2 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.3 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.4 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.5 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.6 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.7 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.8 FROM productsneartocentroid pl WHERE pl.`index` = ".$i.")
            OR p.`index` = (SELECT pl.9 FROM productsneartocentroid pl WHERE pl.`index` = ".$i."))";

    if ($i != 9)
        $sql .= " UNION ";
}

if (!$result = $mysqli->query($sql)) {

    echo "Sorry, the website is experiencing problems.";

    echo "Error: Our query failed to execute and here is why: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}

if ($result->num_rows === 0) {

    echo "We could not find a match for ID $aid, sorry about that. Please try again.";
    exit;
}

$resultArray = array();

for ($i = 0; $i <= 9; $i++) {
    $resultArray[$i] = [];
}

$count = 0;

while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
    array_push($resultArray[$count], $row);

    $count++;

    if ($count == 10)
        $count = 0;
}

header('Content-Type: application/json');
echo json_encode($resultArray);

$result->close();
$mysqli->close();