<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

$success = null;

if (isset($_GET["id"])) {


  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $id = $_GET["id"];

    $sql = "DELETE FROM users WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    header('Location: lista.php');
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

