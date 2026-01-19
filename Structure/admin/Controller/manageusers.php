<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}
include "connect.php";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM customers WHERE id=$id");
    header("Location: manageusers.php");
}

if (isset($_POST['add'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dob = $_POST['dob'];
    
    $stmt = $conn->prepare("INSERT INTO customers (fname, lname, email, password, dob) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $email, $password, $dob);
    $stmt->execute();
    $stmt->close();
    header("Location: manageusers.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("UPDATE customers SET fname=?, lname=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $fname, $lname, $email, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manageusers.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="adDash.css">
</head>
<body>
    <div class="side-bar">
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="adDashboard.php">Dashboard</a></li>
            <li><a href="manageusers.php">Manage Users</a></li>
            <li><a href="managesellers.php">Manage Sellers</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h2>Manage Customers</h2>
            <button onclick="document.getElementById('addModal').style.display='block'" style="float:right; padding:10px 20px; background:#27ae60; color:white; border:none; border-radius:5px; cursor:pointer;">Add New Customer</button>
        </div>
        
        <div class="recent-section">
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <button onclick="editUser(<?php echo $row['id']; ?>, '<?php echo $row['fname']; ?>', '<?php echo $row['lname']; ?>', '<?php echo $row['email']; ?>')" style="padding:5px 10px; background:#3498db; color:white; border:none; border-radius:3px; cursor:pointer; margin-right:5px;">Edit</button>
                                <a href="manageusers.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" style="padding:5px 10px; background:#e74c3c; color:white; text-decoration:none; border-radius:3px;">Delete</a>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='7'>No customers found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    
    <div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
        <div style="background:white; width:400px; margin:100px auto; padding:30px; border-radius:10px;">
            <h3>Add New Customer</h3>
            <form method="POST" action="">
                <input type="text" name="fname" placeholder="First Name" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="text" name="lname" placeholder="Last Name" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="email" name="email" placeholder="Email" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="password" name="password" placeholder="Password" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="date" name="dob" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <button type="submit" name="add" style="padding:10px 20px; background:#27ae60; color:white; border:none; border-radius:5px; cursor:pointer;">Add Customer</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" style="padding:10px 20px; background:#95a5a6; color:white; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>
    
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
        <div style="background:white; width:400px; margin:100px auto; padding:30px; border-radius:10px;">
            <h3>Edit Customer</h3>
            <form method="POST" action="">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="fname" id="edit_fname" placeholder="First Name" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="text" name="lname" id="edit_lname" placeholder="Last Name" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="email" name="email" id="edit_email" placeholder="Email" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <button type="submit" name="update" style="padding:10px 20px; background:#3498db; color:white; border:none; border-radius:5px; cursor:pointer;">Update Customer</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" style="padding:10px 20px; background:#95a5a6; color:white; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>
    
    <script>
    function editUser(id, fname, lname, email) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_fname').value = fname;
        document.getElementById('edit_lname').value = lname;
        document.getElementById('edit_email').value = email;
        document.getElementById('editModal').style.display = 'block';
    }
    </script>
</body>
</html>