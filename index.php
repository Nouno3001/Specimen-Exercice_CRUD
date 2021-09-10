<?php 
  session_start();
if (isset($_SESSION['login']))
{
    echo 'Bonjour ' . $_SESSION['login'];
}else{
    header('location:login.php');
}
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--<link href="./Assets/Css/responsive.css" rel="stylesheet" /> -->

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.css"
      rel="stylesheet"
    />

    <!--<link rel="stylesheet" href="./Assets/Css/bootstrap.css" />-->
    <link rel="stylesheet" href="./Assets/Css/style.css" />

    <img
      src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
      data-wp-preserve="%3Cscript%20src%3D%22js%2Fbootstrap.js%22%3E%3C%2Fscript%3E"
      data-mce-resize="false"
      data-mce-placeholder="1"
      class="mce-object"
      width="20"
      height="20"
      alt="<script>"
      title="<script>"
    />

    <title>Crud en php</title>
  </head>

  <body>
    <div class="container">
      <div class="row">
        <h2>Crud en Php</h2>
      </div>

      <div class="row">
        <p>
          <a href="add.php" class="btn btn-success">Ajouter un user</a>
          <a href="logout.php" class="btn btn-danger">Deconnexion</a>
        </p>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th>id</th>
              <th>Name</th>
              <th>Firstname</th>
              <th>Age</th>
              <th>Tel</th>
              <th>Email</th>
              <th>Pays</th>
              <th>Comment</th>
              <th>metier</th>
              <th>Url</th>
              <th>image</th>
              <th>login</th>
              <th>password</th>
              <th colspan="3">Edition</th><br/><br/><br/><br/>
            </thead>
            <tbody>
            <?php
            include 'database.php'; //on inclut notre fichier de connection 
            
            $pdo = Database::connect(); //on se connecte à la base 

            $sql = 'SELECT * FROM user ORDER BY id DESC'; //on formule notre requete 

            foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                echo '<br /><tr>';
                  echo '<td>' . $row['id'] . '</td><p>';
                  echo '<td>' . $row['name'] . '</td><p>';
                  echo '<td>' . $row['firstname'] . '</td><p>';
                  echo '<td>' . $row['age'] . '</td><p>';
                  echo '<td>' . $row['tel'] . '</td><p>';
                  echo '<td>' . $row['email'] . '</td><p>';
                  echo '<td>' . $row['pays'] . '</td><p>';
                  echo '<td>' . $row['comment'] . '</td><p>';
                  echo '<td>' . $row['metier'] . '</td><p>';
                  echo '<td>' . $row['url'] . '</td><p>';
                  echo '<td>' . $row['image'] . '</td><p>';
                  echo '<td>' . $row['login'] . '</td><p>';
                  echo '<td>' . $row['password'] . '</td><p>';
                  
                  echo '<td>';
                    echo '<a class="btn btn-primary" href="edit.php?id=' . $row['id'] . '">Read</a>'; // un autre td pour le bouton d'edition
                  echo '</td><p>';
                  echo '<td>';
                    echo '<a class="btn btn-success" href="update.php?id=' . $row['id'] . '">Update</a>'; // un autre td pour le bouton d'update
                  echo '</td><p>';
                  echo'<td>';
                    echo '<a class="btn btn-danger" href="delete.php?id=' . $row['id'] . ' ">Delete</a>'; // un autre td pour le bouton de suppression
                  echo '</td><p>';
                echo '</tr><p>';
            }
            Database::disconnect(); //on se deconnecte de la base
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="./Assets/Js/script.Js" type="text/javascript"></script>
  </body>
</html>
