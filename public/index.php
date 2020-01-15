<?php
/*
 *  Display all textbooks in the database.
 *  Provide Links to Purchase Textbook if Buyer
 *  Else, provide link to Sell textbook if Seller
 *  Allow buyer or seller accounts to create and view their reports
 *  Allow user to search textbooks by name, author, or course number
 */

session_start();

// Prevent the user from accessing the page without being logged in.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

$change = "";

// Set the default sql statement to load everything from bookinfo table
$sql = "SELECT * FROM bookinfo";

// If the sort button is pressed, change the SQL statement
// to only select rows where the search statement is satisfied.
if (isset($_POST['submit'])) {
    if ($_POST['search'] === "") {
        $sql = "SELECT * FROM bookinfo";
    } else {
        $sql = "SELECT * FROM bookinfo WHERE
        (LOCATE('" . $_POST['search'] . "',book_name)>0)
        or (LOCATE('" . $_POST['search'] . "',course_number)>0)
        or (LOCATE('" . $_POST['search'] . "',book_author)>0)
         ";
    }
}

try {
    // Try to connect to DB. Select from bookinfo table given the sql statement
    require_once "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $db_username, $db_password, $db_options);

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
		<h2 class="pull-left">Textbooks For Sale</h2>
		<div class="btn-toolbar">
			<a href="logout.php" class="btn btn-danger pull-right">Logout</a>
			<?php if ($_SESSION["usertype"] == "Seller") {?>
				<a href="sell.php" class="btn btn-success pull-right">Add New Textbook</a>
			 <?php }?>
			 <?php if ($_SESSION["usertype"] !== "Admin") {?>
				<a href="create_report.php" class="btn btn-warning pull-right">Submit a Report</a>
				<a href="user_reports.php" class="btn btn-warning pull-right">View your Reports</a>
			 <?php } else {?>
				<a href="admin_reports.php" class="btn btn-warning pull-right">View User Reports</a>
			 <?php }?>
		</div>
	</div>
	<div>
		<form method="POST" class="form-inline">
			<div class="form-row">
				<input type="text" name="search" value="" class="form-control" placeholder="Name, Author, or Course">
				<input type="submit" name="submit" class="btn btn-primary" value="Search Textbooks">
			</div>
		</form>
	</div>
	<br></br>
	<?php
// Display a table with all results from the query
if ($result && $statement->rowCount() > 0) {?>
			<table class="table table-bordered table-striped table-hover">
				<thead class="thead-dark/">
					<tr>
						<th>ISBN</th>
						<th>Name</th>
						<th>Author</th>
						<th>Course Number</th>
						<th>Price</th>
						<th>Availability</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($result as $row) {?>
					<tr>
						<td><?php echo escape($row["ISBN"]); ?></td>
						<td><?php echo escape($row["book_name"]); ?></td>
						<td><?php echo escape($row["book_author"]); ?></td>
						<td><?php echo escape($row["course_number"]); ?></td>
						<td>$<?php echo escape($row["book_price"]); ?></td>
						<td><?php echo escape($row["is_available"]); ?></td>
						<td>
							<div class="btn-toolbar">
						<?php if (escape($row["is_available"] == "Available" && $_SESSION["usertype"] == "Buyer")) {
    echo "<a href=\"buy.php?bookid=" . urlencode($row['book_id']) . "\" class=\"btn btn-info\">Buy Textbook</a>";
}?>
<?php if (escape(($row["is_available"] == "Available" && $_SESSION["usertype"] == "Seller" && $_SESSION["id"] == $row["book_creator"]) || $_SESSION["usertype"] == "Admin")) {
    echo "<a href=\"edit.php?bookid=" . urlencode($row['book_id']) . "\" class=\"btn btn-info\">Edit Textbook</a>";
    echo "<a href=\"delete.php?bookid=" . urlencode($row['book_id']) . "&bookname=" . urlencode($row['book_name']) . "\" class=\"btn btn-info\">Delete Textbook</a>";
}?>
							</div>
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		<!-- Nothing was retrieved from the query -->
		<?php } else {?>
			<blockquote>No Textbooks currently for Sale.</blockquote>
		<?php }
?>

</div>

<?php require "templates/footer.php";?>
