<?php
header('Content-Type: application/json');

// Check if regNo and dob are provided
if (isset($_POST['regNo']) && isset($_POST['dob'])) {
    $regNo = $_POST['regNo'];
    $dob = $_POST['dob'];

    try {
        // Create (connect to) SQLite database in file
        $db = new PDO('sqlite:user_students.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query
        $stmt = $db->prepare('SELECT * FROM students WHERE regNo = :regNo AND dob = :dob');
        $stmt->bindParam(':regNo', $regNo);
        $stmt->bindParam(':dob', $dob);
        $stmt->execute();

        // Fetch the data
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'User not found']);
        }

    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
