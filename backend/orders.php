<?php
// --- ORDERS FUNCTIONS ---

// Submit a new request
function create_order($connection, $user_id, $total) {
    $sql = "INSERT INTO orders (user_id, total) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->execute(["id", $user_id, $total]);
    return $stmt->fetch();
}

// View requests specific to a particular user
function get_user_orders($connection, $user_id) {
    $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// View all requests (for administrator)
function get_all_orders($connection) {
    $sql = "SELECT orders.*, users.full_name 
            FROM orders 
            JOIN users ON orders.user_id = users.user_id 
            ORDER BY created_at DESC";
    $result = $connection->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// View details of a specific order
function get_order_details($connection, $order_id) {
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
