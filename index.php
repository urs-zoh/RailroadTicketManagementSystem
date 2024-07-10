<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railroad Ticket Office</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h1>Railroad Ticket Office</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="destination">Destination Station:</label>
                <input type="text" id="destination" name="destination" required>
            </div>
            <div class="form-group">
                <label for="date">Date of Travel:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time of Travel:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <button type="submit" name="search_trains">Search Trains</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_trains'])) {
            $destination = $_POST['destination'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            // Sample train data
            $trains = [
                ["number" => "101", "intermediate" => ["Station A", "Station B"], "final" => "Station C", "price" => 50],
                ["number" => "102", "intermediate" => ["Station D", "Station E"], "final" => "Station F", "price" => 75],
                ["number" => "103", "intermediate" => ["Station G", "Station H"], "final" => "Station I", "price" => 100]
            ];

            $matching_trains = array_filter($trains, function ($train) use ($destination) {
                return in_array($destination, $train['intermediate']) || $destination == $train['final'];
            });

            if (!empty($matching_trains)) {
                echo "<h2>Available Trains</h2>";
                echo "<form method='POST' action=''>";
                foreach ($matching_trains as $train) {
                    echo "<div class='train'>";
                    echo "<input type='radio' id='train{$train['number']}' name='train_number' value='{$train['number']}' required>";
                    echo "<label for='train{$train['number']}'>Train {$train['number']} - Final Station: {$train['final']} - Price: \${$train['price']}</label>";
                    echo "</div>";
                }
                echo "<input type='hidden' name='destination' value='$destination'>";
                echo "<input type='hidden' name='date' value='$date'>";
                echo "<input type='hidden' name='time' value='$time'>";
                echo "<button type='submit' name='select_train'>Select Train</button>";
                echo "</form>";
            } else {
                echo "<p>No trains available for the specified destination, date, and time.</p>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['select_train'])) {
            $selected_train = $_POST['train_number'];
            $destination = $_POST['destination'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            echo "<h2>Invoice</h2>";
            echo "<p>Train Number: $selected_train</p>";
            echo "<p>Destination: $destination</p>";
            echo "<p>Date of Travel: $date</p>";
            echo "<p>Time of Travel: $time</p>";

            foreach ($trains as $train) {
                if ($train['number'] == $selected_train) {
                    echo "<p>Price: \${$train['price']}</p>";
                    break;
                }
            }
            echo "<p>Thank you for your purchase!</p>";
        }
        ?>

    </div>
</body>

</html>