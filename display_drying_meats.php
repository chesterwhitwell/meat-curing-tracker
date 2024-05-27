<?php
$directory = 'curing_meats/';
$files = glob($directory . '*.xml');
$today = date('Y-m-d');

if (!empty($files)) {
    echo '<div class="accordion" id="dryingMeatsAccordion">';
    foreach ($files as $index => $file) {
        $xml = simplexml_load_file($file);
        if ($xml->status == 'drying') {
            $name = $xml->name;
            $startDate = $xml->startDate;
            $endDate = $xml->endDate;
            $postCuringWeight = (float)$xml->drying->postCuringWeight;
            $targetMoistureLoss = (float)$xml->drying->moistureLoss;
            $updates = $xml->drying->update;
            $latestUpdate = $updates ? $updates[count($updates)-1] : null;
            $currentWeight = $latestUpdate ? (float)$latestUpdate->newWeight : $postCuringWeight;

            $moistureLossPercentage = $postCuringWeight > 0 ? round((($postCuringWeight - $currentWeight) / $postCuringWeight) * 100, 2) : 0;

            // Prepare data for Chart.js
            $updateDates = [];
            $weights = [];
            foreach ($updates as $update) {
                $updateDates[] = (string)$update->date;
                $weights[] = (float)$update->newWeight;
            }

            echo '<div class="card">';
            echo '<div class="card-header bg-info text-white" id="dryingHeading' . $index . '">';
            echo '<h2 class="mb-0">';
            echo '<button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#dryingCollapse' . $index . '" aria-expanded="true" aria-controls="dryingCollapse' . $index . '">';
            echo $name . ' (Current Weight: ' . $currentWeight . ' grams, Moisture Loss: ' . $moistureLossPercentage . '%)';
            echo '</button>';
            echo '</h2>';
            echo '</div>';

            echo '<div id="dryingCollapse' . $index . '" class="collapse" aria-labelledby="dryingHeading' . $index . '" data-parent="#dryingMeatsAccordion">';
            echo '<div class="card-body">';
            echo '<div class="row">';
            echo '<div class="col-md-3">';
            echo '<p>Start Date: ' . $startDate . '</p>';
            echo '<p>End Date: ' . $endDate . '</p>';
            echo '<p>Post Curing Weight: ' . $postCuringWeight . ' grams</p>';
            echo '<p>Current Weight: ' . $currentWeight . ' grams</p>';
            echo '<p>Target Moisture Loss: ' . $targetMoistureLoss . '%</p>';
            echo '<p>Moisture Loss: ' . $moistureLossPercentage . '%</p>';
            echo '<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#updateWeightModal" data-file="' . basename($file) . '">Update Weight</button>';
            echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-file="' . basename($file) . '">Delete</button>';
            echo '</div>';
            echo '<div class="col-md-9">';
            echo '<canvas id="moistureLossChart' . $index . '" width="600" height="200"></canvas>';
            echo '</div>';
            echo '</div>'; // close row
            echo '</div>'; // close card-body
            echo '</div>'; // close collapse
            echo '</div>'; // close card

            // Pass data to JavaScript
            echo '<script>';
            echo 'var ctx = document.getElementById("moistureLossChart' . $index . '").getContext("2d");';
            echo 'var moistureLossChart = new Chart(ctx, {';
            echo '    type: "line",';
            echo '    data: {';
            echo '        labels: ' . json_encode($updateDates) . ',';
            echo '        datasets: [{';
            echo '            label: "Weight (grams)",';
            echo '            data: ' . json_encode($weights) . ',';
            echo '            borderColor: "rgba(75, 192, 192, 1)",';
            echo '            fill: false';
            echo '        }]';
            echo '    },';
            echo '    options: {';
            echo '        scales: {';
            echo '            x: {';
            echo '                title: {';
            echo '                    display: true,';
            echo '                    text: "Date"';
            echo '                }';
            echo '            },';
            echo '            y: {';
            echo '                title: {';
            echo '                    display: true,';
            echo '                    text: "Weight (grams)"';
            echo '                }';
            echo '            }';
            echo '        }';
            echo '    }';
            echo '});';
            echo '</script>';
        }
    }
    echo '</div>';
} else {
    echo '<p>No drying meats found.</p>';
}
?>
