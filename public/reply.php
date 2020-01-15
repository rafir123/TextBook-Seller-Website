<?php
/**
 * Allow the administrator to comment on a report
 * Get the Selected Report ID
 * Select row for given report ID from reports table
 * Auto fill form with selected information
 * When submit is pressed, update report table with (edited) form information
 * Display error/success message
 */

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

require "../config.php";
require "../common.php";

$report_id = $_GET['reportid'];
$report = [
    "report_id" => "",
    "comments" => "",
];

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);
        $report = [
            "report_id" => $report_id,
            "comments" => $_POST['comments'],
        ];
        $sql = "UPDATE reports
            SET comments = :comments
            WHERE report_id = :report_id";
        $statement = $connection->prepare($sql);
        $statement->execute($report);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET['reportid'])) {
    try {
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);
        $report_id = $_GET['reportid'];
        $sql = "SELECT comments FROM reports WHERE report_id = :report_id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':report_id', $report_id);
        $statement->execute();

        $report = $statement->fetch(PDO::FETCH_ASSOC);
        $comment_value = $report['comments'];
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php";?>

<?php if (isset($_POST['submit']) && $statement): ?>
	<blockquote>Comment successfully updated.</blockquote>
<?php endif;?>

<div class="container">
    <div class="page-header clearfix">
        <h2 class="pull-left">Reply</h2>
        <div class="btn-toolbar">
			<a href="logout.php" class="btn btn-danger pull-right">Logout</a>
            <a href="admin_reports.php" class="btn btn-success pull-right">Back To Reports</a>
		</div>
    </div>

    <div class="wrapper">
        <form method="post">
            <div class="form-group">
                <label for="comments">Enter Your Comment</label>
                <textarea type="text" class="form-control" name="comments" rows="10"id="comments"><?php echo $report['comments']; ?></textarea>
            </div>
                <input type="submit" name="submit" class="btn btn-primary btn-md pull-right" value="Submit">
        </form>
    </div>
</div>

<?php require "templates/footer.php";?>