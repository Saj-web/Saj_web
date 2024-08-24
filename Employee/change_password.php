<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 300px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color:rgb(255, 213, 0);
            color: black;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: rgb(191, 159, 0);
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>Change Password</h2>
    <form action="update_password.php" method="post">
        Old Password: <input type="password" name="old_password" required><br>
        New Password: <input type="password" name="new_password" required><br>
        Confirm New Password: <input type="password" name="confirm_new_password" required><br>
        <input type="submit" value="Change Password">
    </form>
</body>
</html>
