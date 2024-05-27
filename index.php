<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Curing Tracker</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@0.5.7"></script>
    <style>
        .slider-label {
            font-weight: bold;
        }
        .bg-success .btn-link {
            color: #fff !important;
        }
        .bg-light .btn-link {
            color: #000 !important;
        }
    </style>
    <script>
        function setFileName(fileName) {
            document.getElementById('file').value = fileName;
        }

        function setFileForUpdate(fileName) {
            document.getElementById('updateFile').value = fileName;
        }

        function setFileForDelete(fileName) {
            document.getElementById('deleteFile').value = fileName;
        }

        $(document).ready(function() {
            $('#saltSlider').on('input', function() {
                $('#saltValue').text($(this).val());
                $('#saltPercentage').val($(this).val());
                updateWeights();
            });

            $('#sugarSlider').on('input', function() {
                $('#sugarValue').text($(this).val());
                $('#sugarPercentage').val($(this).val());
                updateWeights();
            });

            $('#curingSaltSlider').on('input', function() {
                $('#curingSaltValue').text($(this).val());
                $('#curingSaltPercentage').val($(this).val());
                updateWeights();
            });

            $('#spicesSlider').on('input', function() {
                $('#spicesValue').text($(this).val());
                $('#spicesPercentage').val($(this).val());
                updateWeights();
            });

            $('#meatWeight').on('input', function() {
                updateWeights();
            });

            $('#dryingModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var file = button.data('file'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-body #file').val(file);
            });

            $('#updateWeightModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var file = button.data('file'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-body #updateFile').val(file);
                modal.find('.modal-body #updateDate').val(new Date().toISOString().substr(0, 10));
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var file = button.data('file'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-body #deleteFile').val(file);
            });

            function updateWeights() {
                const meatWeight = parseFloat($('#meatWeight').val()) || 0;
                const saltPercentage = parseFloat($('#saltSlider').val()) || 0;
                const sugarPercentage = parseFloat($('#sugarSlider').val()) || 0;
                const curingSaltPercentage = parseFloat($('#curingSaltSlider').val()) || 0;
                const spicesPercentage = parseFloat($('#spicesSlider').val()) || 0;

                $('#saltWeight').text((meatWeight * saltPercentage / 100).toFixed(2));
                $('#sugarWeight').text((meatWeight * sugarPercentage / 100).toFixed(2));
                $('#curingSaltWeight').text((meatWeight * curingSaltPercentage / 100).toFixed(2));
                $('#spicesWeight').text((meatWeight * spicesPercentage / 100).toFixed(2));
            }
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Meat Curing Tracker</h1>

    <h2 class="mb-4">Curing Meats List</h2>
    <div id="curingMeatsList">
        <?php include 'display_curing_meats.php'; ?>
    </div>

    <h2 class="mb-4">Drying Meats List</h2>
    <div id="dryingMeatsList">
        <?php include 'display_drying_meats.php'; ?>
    </div>
</div>

<div class="container mt-5">
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addMeatModal">Add Meat</button>
</div>

<!-- Add Meat Modal -->
<div class="modal fade" id="addMeatModal" tabindex="-1" aria-labelledby="addMeatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMeatModalLabel">Add New Meat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="save_curing_data.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="meatWeight">Enter Meat Weight (grams):</label>
                        <input type="number" class="form-control" id="meatWeight" name="meatWeight" placeholder="Enter weight in grams" required>
                    </div>
                    <div class="form-group">
                        <label class="slider-label" for="saltSlider">Salt Percentage (%): <span id="saltValue">3.50</span>% <span id="saltWeight">(0.00 grams)</span></label>
                        <input type="range" class="custom-range" id="saltSlider" min="0" max="10" step="0.01" value="3.50">
                        <input type="hidden" id="saltPercentage" name="saltPercentage" value="3.50">
                    </div>
                    <div class="form-group">
                        <label class="slider-label" for="sugarSlider">Sugar Percentage (%): <span id="sugarValue">3.50</span>% <span id="sugarWeight">(0.00 grams)</span></label>
                        <input type="range" class="custom-range" id="sugarSlider" min="0" max="10" step="0.01" value="3.50">
                        <input type="hidden" id="sugarPercentage" name="sugarPercentage" value="3.50">
                    </div>
                    <div class="form-group">
                        <label class="slider-label" for="curingSaltSlider">Curing Salt Percentage (%): <span id="curingSaltValue">0.25</span>% <span id="curingSaltWeight">(0.00 grams)</span></label>
                        <input type="range" class="custom-range" id="curingSaltSlider" min="0" max="4" step="0.01" value="0.25">
                        <input type="hidden" id="curingSaltPercentage" name="curingSaltPercentage" value="0.25">
                    </div>
                    <div class="form-group">
                        <label class="slider-label" for="spicesSlider">Spices Percentage (%): <span id="spicesValue">3.50</span>% <span id="spicesWeight">(0.00 grams)</span></label>
                        <input type="range" class="custom-range" id="spicesSlider" min="0" max="10" step="0.01" value="3.50">
                        <input type="hidden" id="spicesPercentage" name="spicesPercentage" value="3.50">
                    </div>
                    <div class="form-group">
                        <label for="startDate">Start Date:</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="curingTime">Curing Time (days):</label>
                        <select class="form-control" id="curingTime" name="curingTime" required>
                            <?php for ($i = 1; $i <= 20; $i++) { echo "<option value='$i'>$i</option>"; } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Start Curing</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Drying Modal -->
<div class="modal fade" id="dryingModal" tabindex="-1" aria-labelledby="dryingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dryingModalLabel">Start Drying</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="startDryingForm" action="save_drying_data.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="file" name="file">
                    <div class="form-group">
                        <label for="postCuringWeight">Post Curing Weight (grams):</label>
                        <input type="number" class="form-control" id="postCuringWeight" name="postCuringWeight" required>
                    </div>
                    <div class="form-group">
                        <label class="slider-label" for="moistureLossSlider">Target Moisture Loss (%): <span id="moistureLossValue">20</span>%</label>
                        <input type="range" class="custom-range" id="moistureLossSlider" min="0" max="100" step="1" value="20">
                        <input type="hidden" id="moistureLoss" name="moistureLoss" value="20">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Weight Modal -->
<div class="modal fade" id="updateWeightModal" tabindex="-1" aria-labelledby="updateWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateWeightModalLabel">Update Weight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateWeightForm" action="update_weight.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="updateFile" name="updateFile">
                    <div class="form-group">
                        <label for="updateDate">Date:</label>
                        <input type="date" class="form-control" id="updateDate" name="updateDate" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="newWeight">New Weight (grams):</label>
                        <input type="number" class="form-control" id="newWeight" name="newWeight" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" action="delete_file.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="deleteFile" name="deleteFile">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const dryingModal = document.getElementById('dryingModal');
dryingModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const file = button.getAttribute('data-file');
    document.getElementById('file').value = file;
});

const updateWeightModal = document.getElementById('updateWeightModal');
updateWeightModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const file = button.getAttribute('data-file');
    document.getElementById('updateFile').value = file;
    document.getElementById('updateDate').value = new Date().toISOString().substr(0, 10);
});

const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const file = button.getAttribute('data-file');
    document.getElementById('deleteFile').value = file;
});

const moistureLossSlider = document.getElementById('moistureLossSlider');
const moistureLossValue = document.getElementById('moistureLossValue');
const moistureLoss = document.getElementById('moistureLoss');

moistureLossSlider.addEventListener('input', function() {
    moistureLossValue.textContent = this.value;
    moistureLoss.value = this.value;
});
</script>

</body>
</html>
