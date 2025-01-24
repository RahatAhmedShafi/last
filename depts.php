<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projmr1";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions for update and delete
if (isset($_POST['update_department'])) {
    $id = $_POST['id'];
    $department_name = $_POST['department_name'];
    $manager_id = $_POST['manager_id'];

    $update_query = "UPDATE departments SET department_name='$department_name', manager_id='$manager_id' WHERE department_id='$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>Department updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating department.</div>";
    }
}

if (isset($_POST['delete_department'])) {
    $id = $_POST['id'];
    $delete_query = "DELETE FROM departments WHERE department_id='$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='alert alert-success'>Department deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting department.</div>";
    }
}

if (isset($_POST['update_employee'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $department_id = $_POST['department_id'];

    $update_query = "UPDATE employees SET full_name='$full_name', email='$email', phone_number='$phone_number', department_id='$department_id' WHERE employee_id='$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>Employee updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating employee.</div>";
    }
}

if (isset($_POST['delete_employee'])) {
    $id = $_POST['id'];
    $delete_query = "DELETE FROM employees WHERE employee_id='$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='alert alert-success'>Employee deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting employee.</div>";
    }
}

if (isset($_POST['update_project'])) {
    $id = $_POST['id'];
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];

    $update_query = "UPDATE projects SET project_name='$project_name', description='$description' WHERE project_id='$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>Project updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating project.</div>";
    }
}

if (isset($_POST['delete_project'])) {
    $id = $_POST['id'];
    $delete_query = "DELETE FROM projects WHERE project_id='$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='alert alert-success'>Project deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting project.</div>";
    }
}

if (isset($_POST['update_task'])) {
    $id = $_POST['id'];
    $task_name = $_POST['task_name'];
    $project_id = $_POST['project_id'];

    $update_query = "UPDATE tasks SET task_name='$task_name', project_id='$project_id' WHERE task_id='$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>Task updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating task.</div>";
    }
}

if (isset($_POST['delete_task'])) {
    $id = $_POST['id'];
    $delete_query = "DELETE FROM tasks WHERE task_id='$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='alert alert-success'>Task deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting task.</div>";
    }
}

if (isset($_POST['update_service'])) {
    $id = $_POST['id'];
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    

    $update_query = "UPDATE services SET service_name='$service_name', description='$description', cost='$cost'WHERE service_id='$id' ";
    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>Service updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating service.</div>";
    }
}

if (isset($_POST['delete_service'])) {
    $id = $_POST['id'];
    $delete_query = "DELETE FROM services WHERE service_id='$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='alert alert-success'>Service deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting service.</div>";
    }
}

// Fetch department, employee, project, task, and service data
$departments_query = "SELECT * FROM departments";
$departments_result = mysqli_query($conn, $departments_query);

$employees_query = "SELECT * FROM employees";
$employees_result = mysqli_query($conn, $employees_query);

$projects_query = "SELECT * FROM projects";
$projects_result = mysqli_query($conn, $projects_query);

$tasks_query = "SELECT * FROM tasks";
$tasks_result = mysqli_query($conn, $tasks_query);

$services_query = "SELECT * FROM services";
$services_result = mysqli_query($conn, $services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments, Employees, Projects, Tasks, Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url(pexels-jplenio-1103970.jpg);
            padding: 20px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
<header style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background-color: #f4f4f4;">
        <h1 style="margin: 0;">Welcome to the Dashboard</h1>
        <div>
            <a href="index.php" style="padding: 10px 15px; margin-right: 10px; text-decoration: none; color: #fff; background-color:rgb(0, 0, 0); border-radius: 5px;">Home</a>
            <a href="logout.php" style="padding: 10px 15px; text-decoration: none; color: #fff; background-color:rgb(0, 0, 0); border-radius: 5px;">Logout</a>
            <a href="admin_messages.php?customer_id=2" 
   style="display: inline-block; background-color: #007BFF; color: white; text-decoration: none; 
          padding: 10px 20px; border-radius: 5px; font-size: 14px; font-weight: bold; 
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
    Chat with Customer
</a>
<a href="admin_upload_document.php?customer_id=2" 
   style="display: inline-block; background-color: #007BFF; color: white; text-decoration: none; 
          padding: 10px 20px; border-radius: 5px; font-size: 14px; font-weight: bold; 
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
    Project Submit to Customer
</a>
        </div>
    </header>
    <div class="container">
        <h2>Department Management</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                    <th>Manager ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <?php while ($row = mysqli_fetch_assoc($departments_result)) { ?>
                    
                    <tr>
                        <td><?php echo $row['department_id']; ?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <td><?php echo $row['manager_id']; ?></td>
                        <td>
                      
                       
                        
                            <!-- Update Button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateDepartmentModal<?php echo $row['department_id']; ?>">Update</button>

                            <!-- Delete Button -->
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['department_id']; ?>">
                                <button type="submit" name="delete_department" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this department?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Department Modal -->
                    <div class="modal fade" id="updateDepartmentModal<?php echo $row['department_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateDepartmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateDepartmentModalLabel">Update Department</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="department_name">Department Name</label>
                                            <input type="text" class="form-control" name="department_name" value="<?php echo $row['department_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="manager_id">Manager ID</label>
                                            <input type="text" class="form-control" name="manager_id" value="<?php echo $row['manager_id']; ?>" required>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['department_id']; ?>">
                                        <button type="submit" name="update_department" class="btn btn-success">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                   

                <?php } ?>
              

            
                            


                
            </tbody>
        </table>

        <!-- Edit Button Below Table -->
<div class="text-center mt-4">
    <a class="btn btn-primary" href="insert_department.php">Add/Edit Department</a>
</div>

        <h2>Employee Management</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Department ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($employees_result)) { ?>
                    <tr>
                        <td><?php echo $row['employee_id']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone_number']; ?></td>
                        <td><?php echo $row['department_id']; ?></td>
                        <td>
                            <!-- Update Button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateEmployeeModal<?php echo $row['employee_id']; ?>">Update</button>

                            <!-- Delete Button -->
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['employee_id']; ?>">
                                <button type="submit" name="delete_employee" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Employee Modal -->
                    <div class="modal fade" id="updateEmployeeModal<?php echo $row['employee_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateEmployeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateEmployeeModalLabel">Update Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="full_name">Full Name</label>
                                            <input type="text" class="form-control" name="full_name" value="<?php echo $row['full_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number" value="<?php echo $row['phone_number']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="department_id">Department ID</label>
                                            <input type="text" class="form-control" name="department_id" value="<?php echo $row['department_id']; ?>" required>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['employee_id']; ?>">
                                        <button type="submit" name="update_employee" class="btn btn-success">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>

          <!-- Edit Button Below Table -->
<div class="text-center mt-4">
    <a class="btn btn-primary" href="insert_employee.php">Add/Edit Employee</a>
</div>

        <h2>Project Management</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($projects_result)) { ?>
                    <tr>
                        <td><?php echo $row['project_id']; ?></td>
                        <td><?php echo $row['project_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <!-- Update Button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateProjectModal<?php echo $row['project_id']; ?>">Update</button>

                            <!-- Delete Button -->
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['project_id']; ?>">
                                <button type="submit" name="delete_project" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Project Modal -->
                    <div class="modal fade" id="updateProjectModal<?php echo $row['project_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateProjectModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateProjectModalLabel">Update Project</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="project_name">Project Name</label>
                                            <input type="text" class="form-control" name="project_name" value="<?php echo $row['project_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" required><?php echo $row['description']; ?></textarea>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['project_id']; ?>">
                                        <button type="submit" name="update_project" class="btn btn-success">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>

        <!-- Edit Button Below Table -->
<div class="text-center mt-4">
    <a class="btn btn-primary" href="insert_project.php">Add/Edit Project</a>
</div>

        <h2>Task Management</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Project ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($tasks_result)) { ?>
                    <tr>
                        <td><?php echo $row['task_id']; ?></td>
                        <td><?php echo $row['task_name']; ?></td>
                        <td><?php echo $row['project_id']; ?></td>
                        <td>
                            <!-- Update Button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateTaskModal<?php echo $row['task_id']; ?>">Update</button>

                            <!-- Delete Button -->
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['task_id']; ?>">
                                <button type="submit" name="delete_task" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Task Modal -->
                    <div class="modal fade" id="updateTaskModal<?php echo $row['task_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateTaskModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateTaskModalLabel">Update Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="task_name">Task Name</label>
                                            <input type="text" class="form-control" name="task_name" value="<?php echo $row['task_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_id">Project ID</label>
                                            <input type="text" class="form-control" name="project_id" value="<?php echo $row['project_id']; ?>" required>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['task_id']; ?>">
                                        <button type="submit" name="update_task" class="btn btn-success">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
         <!-- Edit Button Below Table -->
<div class="text-center mt-4">
    <a class="btn btn-primary" href="insert_task.php">Add/Edit Task</a>
</div>

        <h2>Service Management</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service ID</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($services_result)) { ?>
                    <tr>
                        <td><?php echo $row['service_id']; ?></td>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['cost']; ?></td>
                        <td>
                            <!-- Update Button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateServiceModal<?php echo $row['service_id']; ?>">Update</button>

                            <!-- Delete Button -->
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['service_id']; ?>">
                                <button type="submit" name="delete_service" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this service?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Service Modal -->
                    <div class="modal fade" id="updateServiceModal<?php echo $row['service_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateServiceModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateServiceModalLabel">Update Service</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="service_name">Service Name</label>
                                            <input type="text" class="form-control" name="service_name" value="<?php echo $row['service_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" required><?php echo $row['description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="cost">Cost</label>
                                            <input type="text" class="form-control" name="cost" value="<?php echo $row['cost']; ?>" required>
                                        </div>
                                        
                                        <input type="hidden" name="id" value="<?php echo $row['service_id']; ?>">
                                        <button type="submit" name="update_service" class="btn btn-success">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>

         <!-- Edit Button Below Table -->
<div class="text-center mt-4">
    <a class="btn btn-primary" href="insert_service.php">Add/Edit Service</a>
</div>

        <h2>Transaction Information</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Customer Name</th>
            <th>Contact Info</th>
            <th>Service ID</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Assuming you have a query to fetch transaction data
        $transaction_query = "SELECT * FROM transactions1"; // Replace with your actual query
        $transactions_result = mysqli_query($conn, $transaction_query);
        
        while ($row = mysqli_fetch_assoc($transactions_result)) { ?>
            <tr>
                <td><?php echo $row['transaction_id']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['contact_info']; ?></td>
                <td><?php echo $row['service_id']; ?></td>
                <td><?php echo $row['amount']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

</body>
</html>

<?php
$conn->close();
?>
