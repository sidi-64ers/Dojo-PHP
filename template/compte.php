<?php
/**
 * Va permettre de restreindre les utilisateurs en cas de problèmes
 * classe qui permet d'initialiser les autres classes = factory
 */
App::getAuth()->restrict();

$db = App::getDatabase();

if (!empty($_POST)) {
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $_SESSION['flash']['danger'] = "Les mots de passent doivent être identique";
    } else {
        $user_id = $_SESSION['auth']->id;
        $mdp = password_hash($_POST['password'], PASSWORD_BCRYPT);
 
        $user = $db->query("UPDATE users SET password = ? WHERE id_user = ?",[$mdp, $user_id]);
        $_SESSION['flash']['success'] = "Votre mot de passe mis à jour avec succés";
        App::redirect('index.php?page=compte');
        exit();
    }
}
?>


<h1> <?php echo "Bonjour " . ucfirst($_SESSION['auth']->username); ?> </h1>


<h2> Mon compte </h2>

<h3> Administration mot de passe : </h3>

<form action="" method="POST">

    <div class='form-group'>
        <input class='form-control' type='password' name='password' placeholder='changer votre mot de passe' />
    </div>
    <div class='form-group'>
        <input class='form-control' type='password' name='password_confirm' placeholder='confirmer votre mot de passe' />
    </div>
   
    <button class="btn btn-success">Changer de mot de passe</button>
</form>


