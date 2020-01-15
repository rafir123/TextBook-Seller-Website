<?php
/*
 *  Display all reports submitted by LOGGED IN USER
 *  Get user ID from sessions
 *  Select all reports for given user ID from reports table
 *  Display them
 */

session_start();

// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

try {
    // Try to connect to DB. Select all from reports table for given user ID.
    require_once "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $db_username, $db_password, $db_options);

    $sql = "SELECT * FROM reports WHERE report_creator = '" . $_SESSION["id"] . "' ";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php";?>
<div class="container">
	<div class="page-header clearfix">
        <h2 class="pull-left">View My Reports</h2>
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
                        <!-- <th>Creator</th> -->
						<th>Title</th>
						<th>Description</th>
						<th>Reply</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($result as $row) {?>
					<tr>
                        <td><?php echo escape($row["report_status"]); ?></td>
						<td><?php echo escape($row["report_title"]); ?></td>
						<td><?php echo escape($row["description"]); ?></td>
						<td><?php echo escape($row["comments"]); ?></td>
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
