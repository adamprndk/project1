<?php

/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "config.php";
require "common.php";

if (isset($_POST['submit'])) { 



   
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "id"        => $_POST['id'],
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "email"     => $_POST['email'],
      "age"       => $_POST['age'],
      "location"  => $_POST['location'],
      "lastupdate" => date("Y-m-d")
    ];

    $sql = "UPDATE users 
            SET  
              firstname = '".addslashes($user["firstname"])."' ,
              lastname = '".addslashes($user["lastname"])."' , 
              email = '".addslashes($user["email"])."' ,
              age = '".addslashes($user["age"])."' , 
              location = '".addslashes($user["location"])."' ,
              lastupdate = '".addslashes($user["lastupdate"])."'         
              WHERE id = '".addslashes($user["id"])."'  
            ";

  $statement = $connection->prepare($sql);
  $statement->execute();
  
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>


<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['firstname']); ?> successfully updated.</blockquote>
<?php endif; ?>
<?php require "header.php"; ?>




<?php require("orders.php")?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">

          </div>

        </div>
      </div>


<h2>Edit a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      

  <div class="mb-3">
  <label for="<?php echo $key; ?>" class="form-label"><?php echo ucfirst($key); ?></label>   
  <?php  
  if(is_null($value)){
$value="";
    
  }
  
  
  
  ?>

  <input type="text" class="form-control" id="<?php echo $key; ?>"  name="<?php echo $key; ?>"  value="<?php echo escape($value); ?>"
    <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <div id="emailHelp" class="form-text"></div>
  </div>
  
    
    
    
    <?php


endforeach; ?> 
   
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>


