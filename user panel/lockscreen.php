<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Screen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .lock-screen {
            text-align: center;
        }

        input {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="lock-screen">
    <h2>Lock Screen</h2>
    <form id="lockForm">
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="button" onclick="checkPassword()">Unlock</button>
    </form>
</div>

<script>
    function checkPassword() {
        // Replace 'your_password' with the actual password
        const correctPassword = 'your_password';
        const enteredPassword = document.getElementById('password').value;

        if (enteredPassword === correctPassword) {
            alert('Unlock successful!'); // You can replace this with your unlock logic
            // Redirect to the home/dashboard page or unlock the content
            // For example, you can use: window.location.href = 'dashboard.php';
        } else {
            alert('Incorrect password. Please try again.');
            // You might want to implement a mechanism for locking after multiple incorrect attempts
        }
    }
</script>

</body>
</html>
