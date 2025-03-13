<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function loadMessages() {
                $.ajax({
                    url: 'get_messages.php',
                    method: 'GET',
                    success: function(data) {
                        $('#chat-box').html(data);
                    }
                });
            }

            setInterval(loadMessages, 1000);

            $('#chat-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        $('#message').val('');
                        loadMessages();
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
    <div id="chat-box"></div>
    <form id="chat-form">
        <input type="text" id="message" name="message" placeholder="Type your message here..." required>
        <button type="submit">Send</button>
    </form>
    <a href="logout.php">Logout</a>
</body>
</html> 
