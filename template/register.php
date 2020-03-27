<?php 


    if(!empty($_POST)) {
        
        $erreur = array();
  
        $db = App::getDatabase();

        $validation = new Validation($_POST);
        $validation->isAlpha('username', "Votre pseudo n'est pas valide");

        if($validation->isValid()) {
            $validation->isUniq('username', $db, 'users', 'Ce pseudo est déjà utilisé');
        }
        $validation->isEmail('email', "Veuillez saisir un format email valide");

        if($validation->isValid()) {
            $validation->isUniq('email', $db, 'users', 'Cet email est déjà utilisé');
        }
        $validation->isConfirmed('password', 'Veuillez saisir un format de mot de passe valide ');

        
        if ($validation->isValid()) {
            App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email']);
            Session::getInstance()->setFlash('success', "Un email de confirmation vous a été envoyé");
            App::redirect('index.php?page=login');
        } else {
            $erreur = $validation->getErreurs();
        }
    }
    ?>


<h1> S'inscrire </h1>

<?php 
if (!empty($erreur)) : ?>

    <div class='alert alert-danger'>
        <p> Le formulaire doit être correctement complété </p>
        <ul>
        <?php foreach($erreurs as $erreur) : ?>
            <li><?= $erreur; ?></li> 
        <?php endforeach ?>
        </ul>
    </div>

<?php endif; ?>

<form action="" method='POST'>

    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control"  />
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control"  />
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control"  />
    </div>
    <div class="form-group">
        <label for="">Confirmation mot de passe</label>
        <input type="password" name="password_confirm" class="form-control"  />
    </div>
    <button type='submit' class="btn btn-success">M'inscrire</button>


</form>

