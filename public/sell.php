<?php
/*
 *  Get Textbook information from user via form
 *  Store data into bookinfo DB
 *  Provide Success message
 */
session_start();
$check = "";
$statement = "";
// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}
if (isset($_POST['submit'])) {
    $check = "";
    if (empty(trim($_POST['ISBN'])) || empty(trim($_POST['CourseNumber'])) || empty(trim($_POST['Name'])) || empty(trim($_POST['Author'])) || empty(trim($_POST['Price'])) || is_int(trim($_POST['ISBN'])) || is_int(trim($_POST['Price']))) {

        $check = "Empty Line";
    } else if (!is_numeric(trim($_POST['ISBN'])) || !is_numeric(trim($_POST['Price']))) {
        $check = "ISBN and Price should be number";
    }
    if (!empty($check)) {

    } else {
        require "../config.php";
        require "../common.php";
        try {
            $connection = new PDO($dsn, $db_username, $db_password, $db_options);
            $new_textbook = array(
                "ISBN" => $_POST['ISBN'],
                "course_number" => $_POST['CourseNumber'],
                "book_name" => $_POST['Name'],
                "book_author" => $_POST['Author'],
                "book_price" => $_POST['Price'],
                "is_available" => 'Available',
                "book_creator" => $_SESSION["id"],
            );
            $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "bookinfo",
                implode(", ", array_keys($new_textbook)),
                ":" . implode(", :", array_keys($new_textbook))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_textbook);
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

}
?>

<?php require "templates/header.php";?>

<?php if (!empty($check)) {?>
        <blockquote><?php echo $check ?></blockquote>
<?php }?>

<?php if (isset($_POST['submit']) && $statement) {?>
	<blockquote><?php echo $_POST['Name']; ?> successfully added.</blockquote>
<?php }?>
<div class="container">
    <div class="page-header clearfix">
        <h2 class="pull-left">Sell a Textbook</h2>
        <div class="btn-toolbar">
			<a href="logout.php" class="btn btn-danger pull-right">Logout</a>
            <a href="index.php" class="btn btn-success pull-right">Back To Textbooks</a>
		</div>
    </div>

    <div class="wrapper">
        <form method="post">
            <div class="form-group row">
                <label for="ISBN" class="col-sm-2 col-form-label">ISBN</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="ISBN" id="ISBN" placeholder="Enter the ISBN of the Book">
                </div>
            </div>
            <div class="form-group row">
                <label for="CourseNumber" class="col-sm-2 col-form-label">Course Number</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="CourseNumber" id="CourseNumber" placeholder="Enter the Course Number">
                </div>
            </div>
            <div class="form-group row">
                <label for="Name" class="col-sm-2 col-form-label">Book Name</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="Name" id="Name" placeholder="Enter the Name of the Book">
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Author</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="Author" id="Author" placeholder="Enter the Author of the Book">
                </div>
            </div>
            <div class="form-group row">
                <label for="Price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="Price" id="Price" placeholder="Enter the Price of the Book">
                </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary btn-md pull-right" value="Submit">
        </form>
    </div>
</div>

<?php require "templates/footer.php";?>
