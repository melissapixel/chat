<?php
    require'conn.php';
    session_start();
?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$users = $conn->query("SELECT id, username FROM users WHERE id != ".$_SESSION['user_id']);
?>

<h2>Choose a user to chat with:</h2>
<ul>
    <?php while ($row = $users->fetch_assoc()): ?>
        <li><a href="private_chat.php?receiver_id=<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a></li>
    <?php endwhile; ?>
</ul>
