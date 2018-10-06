<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mads
 * Date: 06/10/2018
 * Time: 21.18
 */

if (!isset($_POST["id"])) {error_log("no conversation id"); die("Invalid Request!");}
if (!isset($_POST["userId"])) {error_log("no user id"); die("Invalid Request!");}

$id = $_POST["id"];
$userId = $_POST["userId"];

include "database.php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->query("SELECT Id FROM `comments` WHERE ReplyTo=" . $conn->escape_string($id));

if (!$query)
{
    die("Something went wrong!");
}

if ($query->num_rows > 0)
{
    $query = $conn->query("UPDATE `comments` SET Name='[SLETTET]' WHERE Id=" . $conn->escape_string($id));
    $query = $conn->query("UPDATE `comments` SET Text='[SLETTET]' WHERE Id=" . $conn->escape_string($id));
    $query = $conn->query("UPDATE `comments` SET UserId=0 WHERE Id=" . $conn->escape_string($id));
}
else {
    $query = $conn->query("DELETE FROM `comments` WHERE Id=" . $conn->escape_string($id));

    do{
        $query = $conn->query("DELETE FROM `comments` WHERE UserId=0 AND Id NOT IN (SELECT ReplyTo FROM `comments` WHERE ReplyTo IS NOT NULL)");
    } while($conn->affected_rows > 0);
}

if (!$query)
{
    die("Something went wrong!");
}

