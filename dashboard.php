<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "test");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM organization WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    
</head>
<body>

<div class="dashboard">
    <h2>Welcome to Your Dashboard</h2>

    <table>
        <tbody>
            <?php
            foreach ($user as $key => $value) {
                echo "<tr>
                        <th>" . ucfirst(str_replace("_", " ", $key)) . "</th>
                        <td>" . htmlspecialchars($value) . "</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <a class="logout" href="logout.php">Logout</a>
</div>

</body>
</html>

