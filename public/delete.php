<?php

/**
 *
 * Get the selected textbook ID to delete
 * Display a confirmation form before deletion
 * On submittal, delete the row from bookinfo that contains the unique Textbook ID
 * Display error/success message
 *
 */
session_start();

// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}
$book_id = $_GET['bookid'];

// used to display a different UI after submission
$deleted = false;

require "../config.php";
require "../common.php";

if (isset($_POST["submit"])) {
    try {
        // Try to delete the textbook from bookinfo
        $book_id = $_GET['bookid'];
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);

        $sql = "DELETE FROM bookinfo WHERE book_id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $book_id);
        if ($statement->execute()) {
            $deleted = true;
        }

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

?>
<?php require "templates/header.php";?>

<div class="container">
    <div class="page-header clearfix">
        <h2 class="pull-left">Delete a Textbook</h2>
        <div class="btn-toolbar">
            <a href="logout.php" class="btn btn-danger pull-right">Logout</a>
            <a href="index.php" class="btn btn-success pull-right">Back To Textbooks</a>
        </div>
    </div>

<?php if ($deleted) {?>
  <blockquote>
    <p>You have successfully deleted <strong><?php echo $_GET['bookname']; ?></strong>.</p>
  </blockquote>
<?php } else {?>
    <div class="wrapper">
        <form method="post">
          <div class="row">
            <blockquote>Are you sure you want to delete <strong><?php echo $_GET['bookname']; ?></strong>?</blockquote>
            <div class="btn-toolbar">
              <a href="index.php" class="btn btn-info pull-right">No</a>
              <input type="submit" name="submit" class="btn btn-danger pull-right" value="Yes">
            </div>
          </div>
        </form>
    </div>
<?php }?>
</div>




<?php require "templates/footer.php";?>
