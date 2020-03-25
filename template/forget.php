<?php 



if (!empty($_POST) && !empty($_POST['email'])) {
    $db = App::getDatabase();
    $auth = App::getAuth();
    $session = Session::getInstance();

    if ($auth->resetPassword($db, $_POST['email'])) {
        $session->setFlash('success', "vous recevrez les nouveaux code dans votre boîte mail" );
        App::redirect('index.php?page=login');

    } else {
        $session->setFlash('danger', "Veuillez saisir votre adresse mail");
    }
    
}
?>

<h1> Mot de passe oublié </h1>

<form action="" method='POST'>

    <div class="form-group">
        <label for="">email</label>
        <input type="email" name="email" class="form-control"  />
    </div>
 

    <button type='submit' class="btn btn-success">Envoyer un nouveau mot de passe</button>


</form>

