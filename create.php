<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
error_reporting(1); 
ini_set("display_errors" , 1);
require "config.php";
require "common.php";
$komunikaty= array();
$komunikatydobre= array();




if (isset($_POST['submit'])) {     /*Jesli funkcja nie jest pusta to wysyła*/
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die(); /* Jeśli csrf sie nie zgadza to przerywa */

  try  {
    $connection = new PDO($dsn, $username, $password, $options); /*Łączy sie z baza danych */
    
    $new_user = array( /* array pozwla przypisac zmienej wiele wartosci */
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "email"     => $_POST['email'],
      "age"       => $_POST['age'],
      "location"  => $_POST['location'],
      "dateinsert" => date("Y-m-d"),
      "lastupdate" => date("Y-m-d")
    );
    $sprawdz = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';
    if(preg_match($sprawdz, $new_user["email"])){
          $sql = sprintf( 
              "INSERT INTO %s (%s) values (%s)",
              "users",
              implode(", ", array_keys($new_user)),
              ":" . implode(", :", array_keys($new_user))
            );
            
            $statement = $connection->prepare($sql);  
            $statement->execute($new_user);
    }
     else{
      $komunikaty[] = "błedny adres email";

     }
    


  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }

}

?>
<?php require "header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) {                    
array_push($komunikatydobre, escape($_POST['firstname'])." successfully added.");
 }
  if(count($komunikaty)>0){
    echo "<blockquote style=\"background-color:red\">";
    echo implode("<br>" ,$komunikaty);

    echo "</blockquote>";

  }
  
  
  if(count($komunikatydobre)>0){
    echo "<blockquote style=\"background-color:green\">";
    echo implode("<br>" ,$komunikatydobre);

    echo "</blockquote>";

  }
  
  ?>
  <?php require "orders.php"?>

 
  <h2>Add a user</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="firstname">First Name</label><br>
    <input type="text" name="firstname" id="firstname"><br>
    <label for="lastname">Last Name</label><br>
    <input type="text" name="lastname" id="lastname"><br>
    <label for="email">Email Address</label><br>
    <input type="text" name="email" id="email"><br>
    <label for="age">Age</label><br>
    <input type="text" name="age" id="age"><br>
    <label for="location">Location</label><br>
    <input type="text" name="location" id="location"><br>
    <input type="submit" name="submit" value="Submit">  <br>
  
  
  </form>
  <?php require "footer.php"?>
