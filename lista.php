<?php
require "config.php";
require "common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM users";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "header.php"; ?>


<?php require "orders.php"?>   


    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">

          </div>

        </div>
      </div>
      <div class="table-responsive small">


        <table class="table table-striped table-sm">

      <tr>
        <th>id</th>
        <th>firstname</th>
        <th>lastname</th>
        <th>email</th>
        <th>age</th>
        <th>location</th>
        <th>date</th>
        <th>Edytuj</th>
        <th>Usun</th>

      </tr>
        <?php foreach ($result as $row) : ?>
        <tr>

            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["firstname"]); ?></td>
            <td><?php echo escape($row["lastname"]); ?></td>
            <td><?php echo escape($row["email"]); ?></td>
            <td><?php echo escape($row["age"]); ?></td>
            <td><?php echo escape($row["location"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>"><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#edit"/></svg></a></td>
            <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>"><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#trash"/></svg>
</td>

        </tr>
    <?php endforeach; ?>

</table>


<?php require "footer.php"?>   

