<?php 

$auth = App::getAuth();
$db = App::getDatabase();
$auth->connectFromCookie($db);

if ($auth->user()) {
    App::redirect('index.php?page=compte');
}
if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {

    $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
    $session = Session::getInstance();
    if ($user) {
        $session->setFlash('succes', 'Vous êtes connecté');
        App::redirect('index.php?page=compte');
    } else {
        $session->setFlash('danger', 'Veuillez vérifier votre mot de passe ou votre identifiant');

    }
}
?>

<section>
<h1> Se connecter </h1>

<form action="POST" method='POST'>

    <div class="form-group">
        <label for="">Pseudo / Email</label>
        <input type="text" name="username" class="form-control"  />
    </div>
 
    <div class="form-group">
        <label for="">Mot de passe oublié <a href="forget.php">J'ai oublié mon mot de passe</a></label>
        <input type="password" name="password" class="form-control"  />
    </div>

    <div class="form-group">
        <input type="checkbox" name="remember" id='remember' value='1' />
    <label for="remember">Se souvenir de moi</label>
       
    </div>

    <button type='submit' class="btn btn-success">Se connecter</button>


</form>

</section>