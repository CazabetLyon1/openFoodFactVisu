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

$number = 0;

if (isset($_GET['index']) && is_numeric($_GET['index']))
{
    $number = (int) mysqli_real_escape_string($mysqli, $_GET['index']);
}

$sql = "SELECT p.index, p.product_name, p.countries_tags, p.image_url, p.image_small_url, fp.`nutrition-score-fr_100g`, ROUND(fp.energy_100g, 1) as energy_100g, ROUND(fp.fat_100g, 1) as fat_100g, ROUND(fp.`saturated-fat_100g`, 1) as `saturated-fat_100g`, ROUND(fp.proteins_100g, 1) as proteins_100g, ROUND(fp.salt_100g, 1) as salt_100g, ROUND(fp.sugars_100g, 1) as sugars_100g 
    FROM finals_products fp 
    INNER JOIN products p On fp.`index` = p.`index` WHERE p.`index` = (SELECT pl.0 FROM products_link pl WHERE pl.`index` = ".$number.")
    OR p.`index` = (SELECT pl.1 FROM products_link pl WHERE pl.`index` = ".$number.")
    OR p.`index` = (SELECT pl.2 FROM products_link pl WHERE pl.`index` = ".$number.")
    OR p.`index` = (SELECT pl.3 FROM products_link pl WHERE pl.`index` = ".$number.")
    OR p.`index` = (SELECT pl.4 FROM products_link pl WHERE pl.`index` = ".$number.")";

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

while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
    $resultArray[$row['index']] = $row;
}

header('Content-Type: application/json');
echo json_encode($resultArray);

$result->close();
$mysqli->close();