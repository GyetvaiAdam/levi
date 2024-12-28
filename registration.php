<?php
    if(isset($_POST["create"]) && $_POST[""] == ""){
        echo"User submitted.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
</head>
<body>

    <div>
        <form action="registration.php">
            <div class="container">
                <h1>registration</h1>
                <p>Fill up the form with correct values</p>
                <label for="firstname"><b>First Name</b></label>
                <input type="text" name="firstname" required>

                <label for="lastname"><b>Last Name</b></label>
                <input type="email" name="lastname" required>

                <label for="email"><b>Email Address</b></label>
                <input type="text" name="email" required>

                <label for="password"><b>Password</b></label>
                <input type="password" name="password" required>

                <input type="submit" name="create" value="Sign Up">
            </div>
        </form>
    </div>
</body>
</html>