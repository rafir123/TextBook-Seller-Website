<?php
/*
 *  Take username and password from user via form
 *  Process data
 *  Retreive account from DB
 *  If username and password match, store user info in SESSIONS
 *  Redirect to index page
 */

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$error = "";

if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try {
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);

        // Check if username or password fields are empty
        if (empty(trim($_POST['username']))) {
            $error = "Please enter a username";
        } else {
            $username = trim($_POST['username']);
        }

        if (empty(trim($_POST['password']))) {
            $error = "Please enter a password";
        } else {
            $password = trim($_POST['password']);
        }

        // Search DB for username and password
        $sql = "SELECT * FROM user_info WHERE user_name = :username AND user_password = :password";

        // If no errors have occurred, execute the query
        if (empty($error)) {
            if ($stmt = $connection->prepare($sql)) {
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $password);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        if ($row = $stmt->fetch()) {
                            $user_id = $row["user_id"];
                            $user_type = $row["user_type"];
                            $email = $row["user_email"];
                        }
                        // Store the user information into a session on success
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $user_id;
                        $_SESSION["username"] = $username;
                        $_SESSION["usertype"] = $user_type;
                        $_SESSION["email"] = $email;

                        // Redirect user to welcome page
                        header("location: index.php");
                    }
                }
                $error = "Invalid Username or Password";
            }
            // Close statement
            unset($stmt);
        }

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php require "templates/header.php";?>

 <div align = "center">
         <div style = "width:300px; border: solid 1px #FFD700; " align = "left">
            <div style = "background-color:#FFD700; color:#FFFFFF; padding:3px;"><b>Login</b></div>
            <div style = "margin:30px">
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" name="submit" value="Submit" class="btn btn-primary"/>
                  <a href="register.php" class="btn btn-success"> Register</a>
               </form>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            </div>
         </div>
      </div>

<?php require "templates/footer.php";?>
