<?php
include "database.php";

if (!isset($_GET["conversationId"]))
    die("Invalid request!");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->query("SELECT * FROM `comments` WHERE `ConversationId`=" . $conn->escape_string($_GET["conversationId"]));

if (!$query)
{
    die("Something went wrong!");
}

$rows = array();

while($r = $query->fetch_assoc())
{
    $rows[] = $r;
}

print json_encode($rows);