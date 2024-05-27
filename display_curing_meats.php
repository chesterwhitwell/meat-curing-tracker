<?php
$directory = 'curing_meats/';
$files = glob($directory . '*.xml');
$today = date('Y-m-d');

if (!empty($files)) {
    echo '<div class="accordion" id="curingMeatsAccordion">';
    foreach ($files as $index => $file) {
        $xml = simplexml_load_file($file);
        if ($xml->status == 'curing') {
            $name = $xml->name;
            $meatWeight = $xml->meatWeight;
            $startDate = $xml->startDate;
            $endDate = $xml->endDate;

            $daysLeft = (strtotime($endDate) - strtotime($today)) / (60 * 60 * 24);
            $status = $daysLeft > 0 ? "$daysLeft days left" : "Ready for Drying";

            $headerClass = (strtotime($today) >= strtotime($endDate)) ? 'bg-success text-white' : 'bg-light text-dark';

            echo '<div class="card">';
            echo '<div class="card-header ' . $headerClass . '" id="heading' . $index . '">';
            echo '<h2 class="mb-0">';
            echo '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse' . $index . '" aria-expanded="true" aria-controls="collapse' . $index . '">';
            echo $name . ' (' . $status . ')';
            echo '</button>';
            echo '</h2>';
            echo '</div>';

            echo '<div id="collapse' . $index . '" class="collapse" aria-labelledby="heading' . $index . '" data-parent="#curingMeatsAccordion">';
            echo '<div class="card-body">';
            echo '<p>Start Date: ' . $startDate . '</p>';
            echo '<p>End Date: ' . $endDate . '</p>';
            echo '<p>Starting Weight: ' . $meatWeight . ' grams</p>';
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Ingredient</th><th>Percentage (%)</th><th>Weight (grams)</th></tr></thead>';
            echo '<tbody>';
            foreach ($xml->ingredients->ingredient as $ingredient) {
                echo '<tr>';
                echo '<td>' . $ingredient->name . '</td>';
                echo '<td>' . $ingredient->percentage . '</td>';
                echo '<td>' . $ingredient->weight . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            if (strtotime($today) >= strtotime($endDate)) {
                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dryingModal" data-file="' . basename($file) . '">Start Drying</button>';
            }
            echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-file="' . basename($file) . '">Delete</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    echo '</div>';
} else {
    echo '<p>No curing meats found.</p>';
}
?>
