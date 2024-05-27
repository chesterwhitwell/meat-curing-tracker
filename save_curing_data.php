<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $meatWeight = $_POST['meatWeight'];
    $saltPercentage = $_POST['saltPercentage'];
    $sugarPercentage = $_POST['sugarPercentage'];
    $curingSaltPercentage = $_POST['curingSaltPercentage'];
    $spicesPercentage = $_POST['spicesPercentage'];
    $startDate = $_POST['startDate'];
    $curingTime = $_POST['curingTime'];

    $saltWeight = $meatWeight * $saltPercentage / 100;
    $sugarWeight = $meatWeight * $sugarPercentage / 100;
    $curingSaltWeight = $meatWeight * $curingSaltPercentage / 100;
    $spicesWeight = $meatWeight * $spicesPercentage / 100;

    $endDate = date('Y-m-d', strtotime($startDate . ' + ' . $curingTime . ' days'));

    $xml = new SimpleXMLElement('<curingData/>');
    $xml->addChild('name', $name);
    $xml->addChild('meatWeight', $meatWeight);
    $xml->addChild('startDate', $startDate);
    $xml->addChild('endDate', $endDate);
    $xml->addChild('curingTime', $curingTime);
    $xml->addChild('status', 'curing');

    $ingredients = $xml->addChild('ingredients');
    $salt = $ingredients->addChild('ingredient');
    $salt->addChild('name', 'Salt');
    $salt->addChild('percentage', $saltPercentage);
    $salt->addChild('weight', $saltWeight);
    $sugar = $ingredients->addChild('ingredient');
    $sugar->addChild('name', 'Sugar');
    $sugar->addChild('percentage', $sugarPercentage);
    $sugar->addChild('weight', $sugarWeight);
    $curingSalt = $ingredients->addChild('ingredient');
    $curingSalt->addChild('name', 'Curing Salt');
    $curingSalt->addChild('percentage', $curingSaltPercentage);
    $curingSalt->addChild('weight', $curingSaltWeight);
    $spices = $ingredients->addChild('ingredient');
    $spices->addChild('name', 'Spices');
    $spices->addChild('percentage', $spicesPercentage);
    $spices->addChild('weight', $spicesWeight);

    if (!file_exists('curing_meats')) {
        mkdir('curing_meats', 0777, true);
    }

    $fileName = 'curing_meats/curing_data_' . time() . '.xml';
    $xml->asXML($fileName);

    header("Location: index.php");
    exit();
}
?>
