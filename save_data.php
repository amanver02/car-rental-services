<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickupLocation = $_POST["pickup_location"];
    $dropLocation = $_POST["drop_location"];
    $pickupDate = $_POST["pickup_date"];
    $returnDate = $_POST["return_date"];

    // Create a new row of data
    $data = array($pickupLocation, $dropLocation, $pickupDate, $returnDate);

    // Append data to the Excel file
    $file = 'customer_data.xlsx';
    if (!file_exists($file)) {
        $header = array("Pickup Location", "Drop Location", "Pickup Date", "Return Date");
        $data = array($header, $data);
    }

    $existingData = [];
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $existingData[] = $row;
        }
        fclose($handle);
    }

    $existingData[] = $data;

    if (($handle = fopen($file, "w")) !== FALSE) {
        foreach ($existingData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

    echo "Booking successful! Data has been saved.";
} else {
    echo "Invalid request method.";
}
?>
