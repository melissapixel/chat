<?php
    require'conn.php';
    session_start();
?>
<?php
    if (!isset($_SESSION['user_id']) || !isset($_GET['receiver_id'])) {
        header("Location: login.php");
        exit();
    }

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_GET['receiver_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = $_POST['message'];
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
        $stmt->execute();
        $stmt->close();
    }

    $messages = $conn->query("SELECT pc.*, u.username FROM messages pc JOIN users u ON pc.sender_id = u.id WHERE (pc.sender_id = $sender_id AND pc.receiver_id = $receiver_id) OR (pc.sender_id = $receiver_id AND pc.receiver_id = $sender_id) ORDER BY created_at DESC");

?>
<h2>Chat with <?php
$receiver = $conn->query("SELECT username FROM users WHERE id = $receiver_id")->fetch_assoc();
echo $receiver['username'];
?></h2>

<form method="POST">
    <input type="text" name="message" required>
    <button type="submit">Send</button>
</form>

<h2>Messages:</h2>
<ul>
    <?php while ($row = $messages->fetch_assoc()): ?>
        <li><strong><?php echo $row['username']; ?>:</strong> <?php echo $row['message']; ?> <em><?php echo $row['created_at']; ?></em></li>
    <?php endwhile; ?>
</ul>