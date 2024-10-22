<?php
require_once "../model/class_model.php";
$conn = new class_model(); // Create an instance of the class

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected documents and their respective data
    $document_names = $_POST['document_name']; // This will be an associative array now
    $copies = $_POST['no_ofcopies']; // Also an associative array
    $student_id = $_POST['student_id']; // Assuming student_id is passed in the form

    // Debugging: Check if form data is being received
    if (empty($document_names)) {
        die("No documents selected!");
    }

    // Initialize an array to store the request data
    foreach ($document_names as $index => $document_name) {
        // Get the corresponding number of copies and request type using the same index
        $num_copies = isset($copies[$index]) ? $copies[$index] : 1;
        $request_type = isset($_POST['request_type'][$index]) ? $_POST['request_type'][$index] : '1st request';

        // Debugging: Print the data before insertion
        echo "Document: $document_name, Copies: $num_copies, Request Type: $request_type<br>";

        // Save each request to the database
        if ($conn->add_test($student_id, $document_name, $num_copies, $request_type)) {
            echo "Request for '$document_name' with $num_copies copies as '$request_type' has been successfully saved.<br>";
        } else {
            echo "Failed to save request for '$document_name'.<br>";
        }
        // sadfsadfasdf
    }
}
