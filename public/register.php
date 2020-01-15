<?php
/*
 *  Take user account information from user via form
 *  Scrub and validate user input
 *  Check if the username is already taken in DB
 *  Check if two passwords match
 *  Hash password and store information in DB
 *  Redirect to Login Page
 */
$username = $password = $confirm_password = "";
$email = $email_err = "";
$username_err = $password_err = $confirm_password_err = "";
$usertype = $usertype_err = "";
$statement = "";
// Processing form data when form is submitted
if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try {
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);

        // CHECK USERNAME
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } else {
            // Prepare a select statement
            $sql = "SELECT user_id FROM user_info WHERE user_name = :username";

            if ($stmt = $connection->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            unset($stmt);
        }

        // CHECK EMAIL
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter an email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // CHECK PASSWORD
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have atleast 6 characters.";
        } else {
            $password = trim($_POST["password"]);
        }

        // CHECK CONFIRM PASSWORD
        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }

        // CHECK RADIO SELECTION
        if (isset($_POST['radio'])) {
            $usertype = $_POST['radio'];
        } else {
            $usertype_err = "Please Select a User Type";
        }
        // Add new user to database
        // Check input errors before inserting in database
        if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($usertype_err)) {
            $new_user = array(
                "user_name" => $_POST["username"],
                "user_type" => $_POST["radio"],
                "user_password" => $_POST["password"],
                "user_email" => $_POST['email'],
            );

            $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "user_info",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
            );

            $statement = $connection->prepare($sql);
            if ($statement->execute($new_user)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php";?>
<?php if (isset($_POST['submit']) && $statement) {?>
	<blockquote><?php echo $_POST['username']; ?> successfully added.</blockquote>
<?php }?>
<div class="container">
	<div class="page-header clearfix">
		<h2 class="pull-left">Register an Account</h2>
	</div>
        <div class="wrapper">
            <form method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                    <small id="passwordHelpInline" class="text-muted">
                        Must be atleast 6 characters long.
                    </small>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>

                <div class="form-row">
                    <label>User Type</label>
                    <div class="form-group <?php echo (!empty($usertype_err)) ? 'has-error' : ''; ?>">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio" id="radioBuyer" value="Buyer">
                            <label class="form-check-label" for="inlineRadio1">Buyer</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radio" id="radioSeller" value="Seller">
                            <label class="form-check-label" for="inlineRadio2">Seller</label>
                        </div>
                        <span class="help-block"><?php echo $usertype_err; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>
</div>

    <?php require "templates/footer.php";?>
