<?php
/*
 *  Display all reports in the database.
 *  Provide Links to Purchase Close Report or Add a Comment
 */

session_start();

// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

// Redirect if user is not Admin type
// Page should only be viewable by the Administrators
if ($_SESSION["usertype"] !== "Admin") {
    header("location: index.php");
    exit;
}

try {
    // Try to connect to DB. Select all from reports table.
    require_once "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $db_username, $db_password, $db_options);

    // TODO: make sure this matches table
    $sql = "SELECT * FROM reports";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

// THIS IS CALLED WHEN 'CLOSE REPORT' IS PRESSED
if (isset($_POST['submit'])) {
    try {
        // update reports table by setting status for given report ID to Closed
        $report_id = $_POST['report_id'];
        $connection = new PDO($dsn, $db_username, $db_password, $db_options);
        $sql = "UPDATE reports
            SET  report_status = 'Closed'
            WHERE report_id = :report_id";
        if ($statement = $connection->prepare($sql)) {
            $statement->bindParam(":report_id", $report_id);
            if ($statement->execute()) {
                header("Refresh:0");
            }
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php";?>
<div class="container">
	<div class="page-header clearfix">
        <h2 class="pull-left">View User Reports</h2>
        <div class="btn-toolbar">
			<a href="logout.php" class="btn btn-danger pull-right">Logout</a>
			<a href="index.php" class="btn btn-success pull-right">Back To Textbooks</a>
		</div>
	</div>

	<?php
// Display a table with all results from the query
if ($result && $statement->rowCount() > 0) {?>
			<table class="table table-bordered table-striped table-hover">
				<thead class="thead-dark/">
					<tr>
                        <th>Status</th>
                        <th>Creator</th>
						<th>Title</th>
						<th>Description</th>
                        <th>Comments</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($result as $row) {?>
					<tr>
                        <td><?php echo escape($row["report_status"]); ?></td>
                        <td><?php echo escape($row["report_creator"]); ?></td>
						<td><?php echo escape($row["report_title"]); ?></td>
						<td><?php echo escape($row["description"]); ?></td>
                        <td><?php echo escape($row["comments"]); ?></td>
						<td>
                        <div class="btn-toolbar">
						<?php if ($row["report_status"] === "Open") {?>
							<form method="post">
								<input type="hidden" name="report_id" value="<?php echo htmlspecialchars($row["report_id"]); ?>">
								<input type="submit" name="submit" value="Close Report" class="btn btn-info">
							</form>
						<?php }?>
                        <?php echo "<a href=\"reply.php?reportid=" . urlencode($row['report_id']) . "\" class=\"btn btn-info\">Reply</a>"; ?>
						</div>
                        </td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		<!-- Nothing was retrieved from the query -->
		<?php } else {?>
			<blockquote>No Reports Available.</blockquote>
		<?php }
?>

</div>

<?php require "templates/footer.php";?>
