<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
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
        form {
            width: 85%;
            max-width: 400px;
            background-color: #555555;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 30px;
        }
        form h3 {
            font-size: 28px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
        }
        label {
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
            margin-top: 15px;
            display: block;
        }
        a.forgot {
            font-size: 10px;
            font-weight: 500;
            color: rgb(43, 183, 226);
            margin-top: 20px;
            display: block;
            text-decoration: none;
        }
        input {
            width: 100%;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            border-radius: 20px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
            border: none;
            color: #ffffff;
        }
        ::placeholder {
            color: #e5e5e5;
        }
        button {
            margin-top: 30px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            border: none;
        }
    </style>
</head>
<body>
    <form action="verify_code.php" method="post">
        <h3>Verification Code</h3>
        <input type="hidden" id="username_hidden" name="username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>">
        <label for="code">Code</label>
        <input type="number" placeholder="Verification Code" id="code" name="code" required>
        <label style="font-size:xx-small;">Note: Check your email for the OTP. Also, check the Spam folder if it is not available in your primary inbox.</label>
        <button type="submit">Submit</button>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var username = '<?php echo isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : ""; ?>';
            document.getElementById('username_hidden').value = username;
        });
    </script>
</body>
</html>
