<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_POST['updateFile'];
    $updateDate = $_POST['updateDate'];
    $newWeight = $_POST['newWeight'];

    echo "File variable: " . $file . "<br>"; // Debugging line

    if (!empty($file)) {
        $filePath = 'curing_meats/' . basename($file); // Ensure only the file name is used
        echo "File path: " . $filePath . "<br>"; // Debugging line

        if (is_file($filePath)) {
            $xml = simplexml_load_file($filePath);

            if ($xml) {
                echo "XML loaded successfully.<br>"; // Debugging line
                $update = $xml->drying->addChild('update');
                $update->addChild('date', $updateDate);
                $update->addChild('newWeight', $newWeight);

                if ($xml->asXML($filePath)) {
                    echo "XML saved successfully.<br>"; // Debugging line
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error saving XML file.";
                }
            } else {
                echo "Error loading XML file.";
            }
        } else {
            echo "File not found or not a regular file: " . $filePath;
        }
    } else {
        echo "File variable is empty.";
    }
} else {
    echo "Invalid request method.";
}
?>
