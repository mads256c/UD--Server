<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mads
 * Date: 03/10/2018
 * Time: 16.12
 */

if (!isset($_POST["conversationId"])) {error_log("no conversation id"); die("Invalid Request!");}
if (!isset($_POST["replyId"])) {error_log("no reply id");}
if (!isset($_POST["name"])) {error_log("no name"); die("Invalid Request!");}
if (!isset($_POST["userId"])) {error_log("no user id"); die("Invalid Request!");}
if (!isset($_POST["text"])) {error_log("no text"); die("Invalid Request!");}

$conversationId = $_POST["conversationId"];
if (isset($_POST["replyId"])) {
    $replyId = $_POST["replyId"];
}
$name = $_POST["name"];
$userId = $_POST["userId"];
$text = $_POST["text"];

include "database.php";

//foreach ($_POST as $param_name => $param_val) {
//    error_log("Param: $param_name; Value: $param_val");
//}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["replyId"])) {

    $query = $conn->query("INSERT INTO `comments` (Name, Text, ReplyTo, ConversationId, UserId) VALUES ('$name', '$text', '$replyId', '$conversationId', '$userId')");
}
else
{
    $query = $conn->query("INSERT INTO `comments` (Name, Text, ConversationId, UserId) VALUES ('$name', '$text', '$conversationId', '$userId')");
}

if (!$query)
{
    die("Something went wrong!");
}