<?php
require 'config.php';

$stmt = $pdo->query('SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at ASC');
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    echo '<p><strong>' . htmlspecialchars($message['username']) . ':</strong> ' . htmlspecialchars($message['message']) . '</p>';
}
?> 
