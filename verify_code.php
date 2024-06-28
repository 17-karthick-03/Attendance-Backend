<?php
session_start();

// Function to connect to SQLite database
function connectSQLite() {
    $dsn = 'sqlite:C:\Users\17_karthick_03\OneDrive\Documents\Program\HTML\SEM---5\user_database.db';
    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        return null;
    }
}

// Check if POST request with verification code
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['code'];
    $username = $_POST['username'];

    if (isset($_SESSION['verification_code']) && $entered_code == $_SESSION['verification_code']) {
        // Successful verification
        // Connect to SQLite database
        $pdo = connectSQLite();

        if ($pdo) {
            // Query to fetch user details based on regNo (username_hidden)
            $stmt = $pdo->prepare('SELECT name, total_number, attend FROM users WHERE regNo = :username');
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $name = $user['name'];
                $total_number = $user['total_number'];
                $attend = $user['attend'];
                $percentage = ($attend > 0) ? ($total_number / $attend) * 100 : 0;
                
                // HTML output for the table
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Attendance Information</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
                    <style media="screen">
                        *,
                        *:before,
                        *:after {
                            padding: 0;
                            margin: 0;
                            box-sizing: border-box;
                        }
                        body {
                            background-color: #303030;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            font-family: 'Poppins', sans-serif;
                        }
                        .background {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            z-index: -1;
                        }
                        .container {
                            width: 85%;
                            max-width: 600px;
                            background-color: #555555;
                            border-radius: 20px;
                            backdrop-filter: blur(10px);
                            border: 2px solid rgba(255, 255, 255, 0.1);
                            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
                            padding: 30px;
                        }
                        .container h3 {
                            font-size: 24px;
                            font-weight: 500;
                            text-align: center;
                            margin-bottom: 20px;
                            color: #ffffff;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                            border-radius: 20%;
                        }
                        table, th, td {
                            border-radius: 20px;
                            border: 1px solid #ffffff;
                            color: #ffffff;
                            text-align: center;
                        }
                        th, td {
                            padding: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h3>Hey <?php echo htmlspecialchars($name); ?></h3>
                        <table>
                            <tr>
                                <th>Total Number of Hours</th>
                                <th>Attended Hours</th>
                            </tr>
                            <tr>
                                <td><?php echo htmlspecialchars($total_number); ?></td>
                                <td><?php echo htmlspecialchars($attend); ?></td>
                            </tr>
                            <tr>
                                <th colspan="2">Percentage</th>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo htmlspecialchars(number_format($percentage, 2) . '%'); ?></td>
                            </tr>
                        </table>
                    </div>
                </body>
                </html>
                <?php
                exit(); // Exit after displaying the table
            } else {
                echo 'User not found.';
            }
        } else {
            echo 'Failed to connect to database.';
        }
    } else {
        echo 'Invalid verification code.';
    }
}
?>
