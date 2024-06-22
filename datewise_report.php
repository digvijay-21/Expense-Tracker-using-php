<?php
include("session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Range Expense Report</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="user">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
                <h5><?php echo $username ?></h5>
                <p><?php echo $useremail ?></p>
            </div>
            <div class="sidebar-heading">Management</div>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action"><span data-feather="plus-square"></span> Add Expenses</a>
                <a href="manage_expense.php" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Manage Expenses</a>
                <a href="datewise_report.php" class="list-group-item list-group-item-action active"><span data-feather="calendar"></span>  Datewise Report</a>
            </div>
            <div class="sidebar-heading">Settings </div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action"><span data-feather="user"></span> Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action"><span data-feather="power"></span> Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">
                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.php">Your Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h2 class="text-center mb-4">Date Range Expense Report</h2>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="generate_report" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST['generate_report'])) {
                            // Retrieve dates from the form
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];

                            // Query to fetch expenses within the selected date range
                            $query = "SELECT * FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$start_date' AND '$end_date'";
                            $result = mysqli_query($con, $query);

                            // Check if there are any expenses for the selected date range
                            if (mysqli_num_rows($result) > 0) {
                                // Display expenses
                                echo "<div class='card mt-4'>";
                                echo "<div class='card-body'>";
                                echo "<h2 class='text-center mb-4'>Expenses from $start_date to $end_date</h2>";
                                echo "<table class='table table-bordered'>";
                                echo "<thead><tr><th>Date</th><th>Amount</th><th>Expense Category</th></tr></thead>";
                                echo "<tbody>";

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>{$row['expensedate']}</td><td>{$row['expense']}</td><td>{$row['expensecategory']}</td></tr>";
                                }

                                echo "</tbody></table></div></div>";
                            } else {
                                echo "<p class='mt-4 text-center'>No expenses found for the selected date range</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/feather.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script>
        feather.replace()
    </script>
</body>

</html>
