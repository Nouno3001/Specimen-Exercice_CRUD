<?php 
  session_start();
if (isset($_SESSION['login']))
{
    echo 'Bonjour ' . $_SESSION['login'];
}else{
    header('location:login.php');
}
?> 
<?php 
require 'database.php'; 

if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST)){ 
    
    //on initialise nos messages d'erreurs; 
    
    $nameError = '';
    $firstnameError=''; 
    $ageError=''; 
    $telError =''; 
    $emailError =''; 
    $paysError=''; 
    $commentError=''; 
    $metierError=''; 
    $urlError='';
    $imageError='';
    $loginError='';
    $passwordError='';
    
    // on recupère nos valeurs 

    $name = htmlentities(trim($_POST['name'])); 
    $firstname=htmlentities(trim($_POST['firstname'])); 
    $age = htmlentities(trim($_POST['age'])); 
    $tel=htmlentities(trim($_POST['tel'])); 
    $email = htmlentities(trim($_POST['email'])); 
    $pays=htmlentities(trim($_POST['pays'])); 
    $comment=htmlentities(trim($_POST['comment'])); 
    $metier=htmlentities(trim($_POST['metier'])); 
    $url=htmlentities(trim($_POST['url'])); 
    $image=htmlentities(trim($_POST['image'])); 
    $login=htmlentities(trim($_POST['login']));
    $password=htmlentities(trim($_POST['password']));

     // on vérifie nos champs 
    
    $valid = true; 
    
        if (empty($name)) { 
            $nameError = 'Please enter Name'; 
            $valid = false; 
        }
        else if (!preg_match("/^[a-zA-Z ]*$/",$name)) { 
        $nameError = "Only letters and white space allowed"; 
        }


        if(empty($firstname)){ 
            $firstnameError ='Please enter firstname'; 
            $valid= false; 
        }
        else if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) { 
            $firstnameError = "Only letters and white space allowed"; 
        }


        
        if (empty($age)) { 
            $ageError = 'Please enter your age'; 
            $valid = false; 
        } 


        if (empty($tel)) { 
            $telError = 'Please enter phone'; 
            $valid = false; 
        }
        else if(!preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#",$tel)){ 
            $telError = 'Please enter a valid phone'; 
            $valid = false; 
        }


        if (empty($email)) { 
            $emailError = 'Please enter Email Address'; 
            $valid = false; 
        } 
        else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) { 
            $emailError = 'Please enter a valid Email Address'; 
            $valid = false;
        }


        if (!isset($pays)) { 
            $paysError = 'Please select a country'; 
            $valid = false; 
        }


        if(empty($comment)){ 
            $commentError ='Please enter a description'; 
            $valid= false; 
        } 


        if(empty($metier)){ 
            $metierError ='Please select a job'; 
            $valid= false; 
        }


        if(empty($url)){ 
            $urlError ='Please enter website url'; 
            $valid= false; 
        } else if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) { 
            $urlError='Enter a valid url'; 
            $valid=false; 
        }


        if (isset($_FILES['image']) and $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $extention = strlolower(pathinfo($_FILES['image']['name'])['extention']);
            $validExtentions = array('png, jpeg, jpg');

            if (in_array($extention, $validExtentions)) {
                $imageName = date('d-m-y') . $name . '.' . $extention;
                move_upload_file($_FILES['image']['tmp_name'], './img/' . $imageName);
            } else {
                throw new Exeption('invalid file type');
            }
        }  
        
        
        // si les données sont présentes et bonnes on se connecte à la base 
                    
                    if ($valid) { 
                        $pdo = Database::connect(); 
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = "INSERT INTO user (name, firstname, age, tel, email, pays, comment, metier, url, image, login, password) values(? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
                        $q = $pdo->prepare($sql);
                        $q->execute(array($name, $firstname, $age, $tel, $email, $pays, $comment, $metier, $url, $image, $login,$password));
            
                        Database::disconnect();
            
                        header("Location: index.php");
        }
    }

?>


<!DOCTYPE html>
    <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.css" rel="stylesheet"/>
         	
        <!-- <link href=".Assets/Css/bootstrap.css" rel="stylesheet"> -->
        
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
        data-wp-preserve="%3Cscript%20src%3D%22js%2Fbootstrap.js%22%3E%3C%2Fscript%3E" 
        data-mce-resize="false" 
        data-mce-placeholder="1" 
        class="mce-object" width="20" height="20" alt="<script>" title="<script>" />
        
        <title>Crud</title>
        </head>
        
        <body>


            <br/>
            <div class="container">

                <br/>
                <div class="row">
                    <br/>
                    <h3>Ajouter un contact</h3>
                    <p>
                </div>
                <p>

                <br/>
                <form method="post" action="add.php">

                    <br/>
                    <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                            <label class="control-label">Name</label>
                        <br/>
                        <div class="controls">
                                <input  type="text" name="name"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                                    <?php if (!empty($nameError)):?>
                                        <span class="help-inline"><?php echo $nameError;?></span>
                                    <?php endif; ?>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br/>
                    <div class="control-group<?php echo !empty($firstnameError)?'error':'';?>">
                            <label class="control-label">firstname</label>
                        <br/>
                        <div class="controls">
                                <input type="text" name="firstname" placeholder="firstname" value="<?php echo !empty($firstname)?$firstname:''; ?>">
                                    <?php if(!empty($firstnameError)):?>
                                        <span class="help-inline"><?php echo $firstnameError;?></span>
                                    <?php endif; ?>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br />
                    <div class="control-group<?php echo !empty($ageError)?'error':'';?>">
                            <label class="control-label">age</label>
                        <br />
                        <div class="controls">
                                <input type="number" name="age" value="<?php echo !empty($age)?$age:''; ?>">
                                    <?php if(!empty($ageError)):?>
                                        <span class="help-inline"><?php echo $ageError;?></span>
                                    <?php endif;?>
                    </div>
                    <p>
                    </div>
                    <p>


                    <br />
                    <div class="control-group <?php echo !empty($telError)?'error':'';?>">
                            <label class="control-label">Telephone</label>
                        <br />
                        <div class="controls">
                                <input name="tel" type="number" placeholder="Telephone" value="<?php echo !empty($tel)?$tel:'';?>">
                                    <?php if (!empty($telError)): ?>
                                        <span class="help-inline"><?php echo $telError;?></span>
                                    <?php endif;?>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br />
                    <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                            <label class="control-label">Email Address</label>
                        <br />
                        <div class="controls">
                                <input  type="text" name="email" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                                    <?php if (!empty($emailError)): ?>
                                        <span class="help-inline"><?php echo $emailError;?></span>
                                    <?php endif;?>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br />
                    <div class="control-group<?php echo !empty($paysError)?'error':'';?>">
                            <select name="pays">
                                <option value="paris">Paris</option>
                                <option value="londres">Londres</option>
                                <option value="amsterdam">Amsterdam</option>
                            </select>
                                <?php if (!empty($paysError)): ?>
                                    <span class="help-inline"><?php echo $paysError;?></span>
                                <?php endif;?>
                    </div>
                    <p>
 
 
                    <br />
                    <div class="control-group <?php echo !empty($commentError)?'error':'';?>">
                            <label class="control-label">Commentaire </label>

                        <br />
                        <div class="controls">
                            <textarea rows="4" cols="30" name="comment" ><?php if(isset($comment)) echo $comment;?></textarea>    
                            <?php if(!empty($commentError)):?>
                                <span class="help-inline"><?php echo $commentError ;?></span>
                            <?php endif;?>
                        </div>
                        <p>

                    </div>
                    <p>


                    <br />
                    <div class="control-group<?php echo !empty($metierError)?'error':'';?>">
                            <label class="checkbox-inline">Metier</label>
                        <br />
                        <div class="controls">
                            Dev&nbsp;&nbsp;&nbsp; : 
                                <input type="checkbox" name="metier" value="dev" <?php 
                                    if (isset($metier) && $metier == "dev") 
                                    echo "checked"; ?>>&nbsp;&nbsp;&nbsp;
                            Integrateur&nbsp;&nbsp;&nbsp; : 
                                <input type="checkbox" name="metier" value="integrateur" <?php 
                                    if (isset($metier) && $metier == "integrateur") 
                                    echo "checked"; ?>>&nbsp;&nbsp;&nbsp;
                            Reseau&nbsp;&nbsp;&nbsp;: 
                                <input type="checkbox" name="metier" value="reseau" <?php 
                                    if (isset($metier) && $metier == "reseau") 
                                    echo "checked"; ?>>
                        </div>
                        <p>
                            <?php if (!empty($metierError)): ?>
                                <span class="help-inline"><?php echo $metierError;?></span>
                            <?php endif;?>
                    </div>
                    <p>


                    <br />
                    <div class="control-group  <?php echo !empty($urlError)?'error':'';?>">
                            <label class="control-label">Siteweb</label>
                        
                        <br />
                        <div class="controls">
                            <input type="text" name="url" value="<?php echo !empty($url)?$url:'' ; ?>">
                            <?php if(!empty($urlError)):?>
                                <span class="help-inline"><?php echo $urlError ;?></span>
                            <?php endif;?>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br>
                    <div class="control-group <?php echo !empty($imageError)?'error':'';?>">
                            <label class="control-label">Image</label>
                        <br/>
                        <div class="control">
                            <input type="file" name="image" value="<?php echo !empty($image)?$image:''; ?>">
                            <?php if(!empty($imageError)):?>
                                <span class="help-inline"><?php echo $imageError ;?>
                            <?php endif;?>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br>
                    <div class="control-group <?php echo !empty($loginError)?'error':'';?>">
                            <label class="control-label">Login</label>
                        <br/>
                        <div class="control">
                            <input type="file" name="image" value="<?php echo !empty($login)?$login:''; ?>">
                            <?php if(!empty($loginError)):?>
                                <span class="help-inline"><?php echo $loginError ;?>
                            <?php endif;?>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br>
                    <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                            <label class="control-label">Password</label>
                        <br/>
                        <div class="control">
                            <input type="file" name="image" value="<?php echo !empty($password)?$password:''; ?>">
                            <?php if(!empty($passwordError)):?>
                                <span class="help-inline"><?php echo $passwordError ;?>
                            <?php endif;?>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br />
                    <div class="form-actions">
                            <input type="submit" class="btn btn-success" name="submit" value="submit">
                                <a class="btn" href="index.php">Retour</a>
                    </div>
                    <p>

                </form>
                <p>
                
                
                
            </div>
            <p>

            
        </body>
    </html>
<!--Editer
La page edit.php est sans doute la plus simple, ici pas d’opération complexe, mais juste la lecture d’un élément du tableau.

On inclut notre fichier de connexion.
On initialise une variable $id,
si on a bien un id envoyé dans l’url ($_GET), on le récupère.( le lien crée en index.php « href=« delete.php?id=‘ . $row[‘id’] . ‘  » attend cet id en paramètre)
s’il n’y pas d’id, on redirige vers l’index.
Autrement,  on se connecte à la base et avec une requête Select toute simple sur l’id,  on affiche simplement chaque élément retourné.-->

<?php
/*
require('database.php'); 

//on appelle notre fichier de config 
$id = null;

if (!empty($_GET['id'])) { 
    $id = $_REQUEST['id']; 
} 

if (null == $id) { 
    header("location:index.php"); 
} 
    else { 
        //on lance la connection et la requete 
        $pdo = Database ::connect(); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
        $sql = "SELECT * FROM user where id =?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

    Database::disconnect();
}*/

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
        data-wp-preserve="%3Cscript%20src%3D%22js%2Fbootstrap.min.js%22%3E%3C%2Fscript%3E" 
        data-mce-resize="false" 
        data-mce-placeholder="1" 
        class="mce-object" width="20" height="20" alt="<script>" title="<script>" />
    </head>

    <body>

        <br/>
        <div class="container">
            <br/>
            <div class="span10 offset1">
                <br />
                <div class="row">
                    <br />
                    <h3>Edition</h3>
                    <p>
                </div>
                <p>

                <br/>
                <div class="form-horizontal" >
                    <br/>
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['name']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br/>
                    <div class="control-group">
                        <label class="control-label">Firstname</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['firstname']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br/>
                    <div class="control-group">
                        <label class="control-label">Age</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['age']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>
                    
                    <br/>
                    <div class="control-group">
                        <label class="control-label">Tel</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['tel']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br/>
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['email']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br/>
                    <div class="control-group">
                        <label class="control-label">Pays</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['pays']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br/>
                    <div class="control-group">
                        <label class="control-label">Comment</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['comment']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br/>
                    <div class="control-group">
                        <label class="control-label">Metier</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['metier']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>


                    <br/>
                    <div class="control-group">
                        <label class="control-label">Url</label>
                        <br/>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['url']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>

                    <br />
                    <div class="control-group">
                        <label class="control-label">Image</label>
                        <br />
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['image']; ?>
                            </label>
                        </div>
                        <p>
                    </div>
                    <p>

                </div>
                <p>

                <br/>
                <div class="form-actions">
                    <a class="btn" href="index.php">Back</a>
                </div>
                <p>
                
            </div>
            <p>

        </div>
        <p>

    </body>
</html> -->