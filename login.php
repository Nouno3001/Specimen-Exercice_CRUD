<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
   
require 'database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $loginError = '';//on initialise nos messages d' erreurs
    $passwordError = '';
    $password = htmlentities(trim($_POST['password'])); //on securise les données
    $login = htmlentities(trim($_POST['login']));

    // on vérifie les input
    $valid = true;
    if (empty($login)) {
        $loginError = 'Please enter Login';
        $valid = false;
    }
    if (empty($password)) {
        $passwordError = 'Please enter password';
        $valid = false;
    }


    if ($valid) { //si c'est bon, on connecte à la base
        $pdo = Database :: connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user WHERE login= ? AND password=? ";
        $q = $pdo->prepare($sql);
        $q->execute(array($login, $password));
        $data = $q->fetch(PDO::FETCH_ASSOC);
      if ($data['password'] == $password && $data['login'] == $login ) // Acces OK ! s'il y a des data et qu'elle correspondent
	{
            session_start(); //on ouvre la session
	    $_SESSION['login'] = $data['login'];//on assigne nos valeurs
	    $_SESSION['password'] = $data['password'];
	  
	    echo '<p>Bienvenue '.$data['login'].', 
			vous êtes maintenant connecté!</p>
			<p>Cliquez <a href="./index.php">ici</a> 
			pour revenir à la page d accueil</p>';
            header('location:index.php'); //et on renvoie vers l'index
	}
        
        
	else // Acces refusé on reste sur la page!
	{
	    echo '<p>Une erreur s\'est produite 
	    pendant votre identification.<br /> Le mot de passe ou le pseudo 
            entré n\'est pas correcte.</p><p>Cliquez <a href="./login.php">ici</a>'; 
	   
	    
	}
  
 
    }

    Database::disconnect();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Crud</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.js"></script>

    </head>
    <body>
        <div class="container">
            <form method="POST" action="login.php">
                <div class="control-group <?php echo!empty($loginError) ? 'error' : ''; ?>">
                    <label class="control-label">Login</label>
                    <div class="controls">
                        <input type="text" name="login" value="">
                        <?php if (!empty($loginError)) : ?><!-- affiche erreur-->
                            <span class="help-inline"><?php echo $loginError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group<?php echo!empty($passwordError) ? 'error' : ''; ?>">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input type="password" name="password" value="">
                    <?php if (!empty($passwordError)) : ?> <!-- affiche erreur-->
                            <span class="help-inline"><?php echo $passwordError; ?></span>
                        <?php endif; ?>
                    </div>

                </div>
                <input type="submit" value="submit" name="submit">
            </form>
        </div>
    </body>
</html>