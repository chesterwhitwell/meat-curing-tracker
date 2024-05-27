<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_POST['deleteFile'];

    if (!empty($file)) {
        $filePath = 'curing_meats/' . basename($file);

        if (is_file($filePath)) {
            if (unlink($filePath)) {
                echo "File deleted successfully.<br>"; // Debugging line
                header("Location: index.php");
                exit();
            } else {
                echo "Error deleting the file.";
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
