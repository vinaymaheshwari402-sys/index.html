<?php
session_start();
require 'db.php'; // Database connection

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// 2. Fetch clients associated with this user
$sql = "SELECT * FROM clients WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$clients = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Garuda Dashboard</title>
    <style>
        body { font-family: sans-serif; background-color: #0f172a; color: white; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .client-card { background: #1e293b; padding: 20px; margin-bottom: 10px; border-radius: 8px; border-left: 4px solid #c5a059; }
        h1 { color: #c5a059; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <p>Your Managed Portfolios:</p>

        <?php if (count($clients) > 0): ?>
            <?php foreach ($clients as $client): ?>
                <div class="client-card">
                    <h3><?php echo htmlspecialchars($client['client_name']); ?></h3>
                    <p>Balance: $<?php echo number_format($client['current_balance'], 2); ?></p>
                    <p>Tier: <?php echo htmlspecialchars($client['initial_tier']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No clients found.</p>
        <?php endif; ?>
        
        <br>
        <a href="logout.php" style="color: #c5a059;">Logout</a>
    </div>
</body>
</html>
