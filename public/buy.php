<?php
/*
 *  Allow the User to Purchase the selected Textbook.
 *  Retrieve the Textbook info that was selected from DB
 *  Get buyers payment information and confirmation before completing purchase
 *  If Successful, display success message
 *  Else, report error
 */
session_start();

// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

require_once "../config.php";
require "../common.php";

$book_name = $book_price = "";
$book_id = $_GET['bookid'];

// Used to display a different UI after purchase has been completed.
$purchased = false;

try {
    // Try to connect to DB. Select all from bookinfo table.
    $connection = new PDO($dsn, $db_username, $db_password, $db_options);
    $sql = "SELECT * FROM bookinfo WHERE book_id = :id";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bindParam(":id", $book_id);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $book_name = $row['book_name'];
                    $book_price = $row['book_price'];
                }
            }
        }
    }

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
if (isset($_POST['submit'])) {
    // get card type
    $cardtype = $_POST['cardtype'];
    try {
        // Update bookinfo table by setting the is_available column to Shipped for the
        // given textbook ID.
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);
        $sql = "UPDATE bookinfo SET is_available = 'Shipped' WHERE book_id = :id";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bindParam(":id", $book_id);
        }
        if ($stmt->execute()) {
            $purchased = true;
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php";?>
<div class="container">
    <div class="page-header clearfix">
        <h2 class="pull-left">Buy a Textbook</h2>
        <div class="btn-toolbar">
            <a href="logout.php" class="btn btn-danger pull-right">Logout</a>
            <a href="index.php" class="btn btn-success pull-right">Back To Textbooks</a>
        </div>
    </div>
<!-- Display payment form if the submit button has not been pressed -->
<?php if (!$purchased) {?>
    <div class="wrapper">
        <form method="post">
            <blockquote>
            <p>If you would like to purchase <strong><?php echo $book_name; ?></strong> for <strong>$<?php echo $book_price; ?></strong>,</p>
            <p>please fill in your payment information below.</p>
            </blockquote>

            <div class="form-row">
                <div class="form-group col-xs-12 required">
                    <label for="exampleFormControlSelect1">Please Select a Card Type</label>
                    <select class="form-control" id="cardtype" name="cardtype">
                        <option>Mastercard</option>
                        <option>Visa</option>
                        <option>Discover</option>
                    </select>
                </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Name on Card</label>
                <input class='form-control' size='4' type='text'>
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group card required'>
                <label class='control-label'>Card Number</label>
                <input autocomplete='off' class='form-control card-number' size='20' type='text'>
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>CVC</label>
                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'>Expiration</label>
                <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'> </label>
                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
              </div>
            </div>

            <input type="submit" name="submit" class="btn btn-primary btn-md pull-right" value="Purchase Textbook">
        </form>

    </div>
<!-- Display success message after purchase -->
<?php } else {?>
<!-- TODO: Add User Location into Success Message -->
<blockquote>
    <p>You have successfully purchased the textbook with your <strong><?php echo $cardtype ?></strong>. The textbook is being sent to your address.</p>
    <p>A confirmation email is being sent to <strong><?php echo $_SESSION["email"]; ?></strong> Thank you for shopping with us!</p>
</blockquote>
</div>
<?php }?>

<?php require "templates/footer.php";?>
