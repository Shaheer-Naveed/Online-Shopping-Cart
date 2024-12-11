<?php
include('connection.php');
if (isset($_GET['remove_i'])) {
    $cart_id = $_GET['remove_i'];
    echo "Cart ID: " . $cart_id;  // Debugging line
    $sql = "DELETE FROM cart WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();

        // Check if delete was successful
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Item Removed'); window.location.href='view_cart.php';</script>";
            exit();
        } else {
            echo "Error: Item not found or couldn't be deleted.";
        }
    } else {
        echo "Error: Could not prepare the SQL query.";
    }
} else {
    echo "No remove parameter set in URL.";
}
?>
