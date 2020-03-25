<?php 

if (isset($_GET['id']) && isset($_GET['token'])) {
    
    $auth = App::getAuth();
    $db = App::getDatabase();

    $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);
    if ($user) {
    
        if(!empty($_POST)) {
            $validation = new Validation($_POST);
            $validation->isConfirmed('password');

            if ($validator->isValid()) {

                $password = $auth->hashPassword($_POST['password']);
                $db->query('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id_user = ?', [$password, $_GET['id']]);
    
                $auth->connect($user);
                Session::getInstance()->setFlash('success', "Votre mot de passe a bien été modifié");
                App::redirect('index.php?page=compte');
                exit();
            }
        }
    } else {
        Session::getInstance()->setFlash('danger', "Utilisez un token valide");
        App::redirect('index.php?page=login');
    }
} else {
    App::redirect('index.php?page=login');
}
?>


<h1> Réiniatilisation du mot de passe </h1>

<form action="" method='POST'>

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control"  />
    </div>

    <div class="form-group">
        <label for="">Confirmation du mot de passe</label>
        <input type="password" name="password_confirm" class="form-control"  />
    </div>
    <button type='submit' class="btn btn-success">Réinitialisation de votre mot de passe</button>

</form>

