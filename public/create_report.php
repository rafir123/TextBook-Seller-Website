<?php

/*
 *  Allow the user (buyer/seller) to create a report to be viewed by admin
 *  Gather report information via user submitted report
 *  Add report to the reports database
 *  Provide success/error message on submission
 */
session_start();

// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try {
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);

        // Store all form information into report array
        $new_report = array(
            "report_title" => $_POST['Title'],
            "description" => $_POST['Description'],
            "report_creator" => $_SESSION["id"],
            "report_status" => "Open",
            "comments" => "",
        );

        // Insert report array into reports table
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "reports",
            implode(", ", array_keys($new_report)),
            ":" . implode(", :", array_keys($new_report))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_report);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}
?>

<?php require "templates/header.php";?>

<?php if (isset($_POST['submit']) && $statement) {?>
	<blockquote>Your report has been received and will be reviewed by an administrator as soon as possible.</blockquote>
<?php }?>
<div class="container">
    <div class="page-header clearfix">
        <h2 class="pull-left">Submit a Report</h2>
        <div class="btn-toolbar">
			<a href="logout.php" class="btn btn-danger pull-right">Logout</a>
            <a href="index.php" class="btn btn-success pull-right">Back To Textbooks</a>
		</div>
    </div>

    <div class="wrapper">
        <form method="post">
            <div class="form-group row">
                <label for="Genre" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="Title" id="Title" placeholder="Enter a Title that Summarizes your Report">
                </div>
            </div>
            <div class="form-group row">
                <label for="Name" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" type="text" name="Description" id="Description" placeholder="Please describe the issue"></textarea>
                </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary btn-md pull-right" value="Submit">
        </form>
    </div>

</div>

<?php require "templates/footer.php";?>
