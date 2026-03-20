<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <title>A3 CSV Table</title>
</head>
<body>
    <?php
    // NAME: Timmy Chen
    // STUDENT ID: 261153472

    $fields = ['fname', 'lname', 'email', 'phonenum', 'topic', 'ordernum', 'salon', 'msg'];
    $required = ['fname', 'lname', 'email', 'phonenum', 'topic', 'msg'];

    $missing = false;
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $missing = true;
    } else {
        foreach ($required as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $missing = true;
                break;
            }
        }
    }

    if ($missing) {
        echo "<h1>Error</h1>";
        echo "<p>Missing required fields in request. No record was added.</p>";
        displayCsvTable();
        echo '<br><a href="A3.html" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Go back to form</a>';
        exit;
    }

    $csvFile = 'A3.csv';
    $data = [
        trim($_POST['fname']),
        trim($_POST['lname']),
        trim($_POST['email']),
        trim($_POST['phonenum']),
        trim($_POST['topic']),
        trim($_POST['ordernum'] ?? ''),
        trim($_POST['salon'] ?? ''),
        trim($_POST['msg'])
    ];

    //Append record to csv
    $handle = fopen($csvFile, 'a');
    if ($handle) {
        fputcsv($handle, $data);
        fclose($handle);
    } else {
        die("Error: Unable to open CSV file.");
    }

    echo '<div class="container-fluid m-6">';
    displayCsvTable();
    echo '<br><a href="A3.html" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">New Submission</a>';
    echo '</div>';

    //Create and display table
    function displayCsvTable() {
        $csvFile = 'A3.csv';

        $handle = fopen($csvFile, 'r');
        if (!$handle) return;

        echo '<h1 class="text-center">Content of A3.csv</h1>';
        echo '<table class="table table-striped table-bordered table-hover table-sm">';
        echo '<thead><tr class="text-center">';
        $headers = ['First Name', 'Last Name', 'Email', 'Phone', 'Topic', 'Order Number', 'Salon Name', 'Message'];
        foreach ($headers as $header) {
            echo "<th>$header</th>";
        }
        echo '</tr></thead>';
        echo '<tbody>';

        $rowNum = 0;
        while (($row = fgetcsv($handle)) !== false) {
            //Skip rows that do not have 8 fields to avoid distrupting layout
            if (count($row) != 8){
                continue;
            }
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell ?? '') . "</td>";
            }
            echo "</tr>";
            $rowNum++;
        }
        fclose($handle);
        echo '</tbody></table>';
    }
    ?>

    <script src="bootstrap-5.3.8-dist/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>