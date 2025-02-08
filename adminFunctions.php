<?php
include_once("mysql_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shopper_id = $_POST["shopper_id"];
    $action = $_POST["action"];

    if (!empty($shopper_id) && !empty($action)) {
        if ($action == "activate") {
            $qry = "UPDATE Shopper SET ActiveStatus = 1 WHERE ShopperID = ?";
        } elseif ($action == "deactivate") {
            $qry = "UPDATE Shopper SET ActiveStatus = 0 WHERE ShopperID = ?";
        }

        if (isset($qry)) {
            $stmt = $conn->prepare($qry);
            $stmt->bind_param("i", $shopper_id);
            if ($stmt->execute()) {
                echo "User status updated successfully.";
            } else {
                echo "Error updating status.";
            }
            $stmt->close();
        }
    }
}

$conn->close();
header("Location: admin.php");
exit;
?>
