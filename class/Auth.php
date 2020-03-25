<?php

class Auth
{
    private $options = [
        'restriction_msg' => "Non autorisé"
    ];
    private $session;

    /**
     * __construct
     *
     * @param  session $session
     * @param   $options
     *
     * @return void
     */
    public function __construct($session, $options = [])
    {
        $this->option = array_merge($this->options, $options);
        $this->session = $session;
    }

    /**
     * hashPassword
     *
     * @param  mixed $password
     *
     * @return void
     */
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

  
    /**
     * Enregistre un nouvel utilisateur
     *
     * @param  object $db Connexion à la base de donnée
     * @param  string $username
     * @param  string $password
     * @param  string $email
     *
     * @return void
     */
    public function enregistrement(object $db, $username, $password, $email)
    {
        $password = $this->hashPassword($password);
        $token = Str::random(60);
        $db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?", [
            $username,
            $password,
            $email,
            $token
        ]);


        $user_id = $db->lastInsertId(); // Dernier ID entré en BDD
        mail($email, 'Confirmation de votre compte', "Validez votre compte en cliquant sur ce lien\n\nhttp://localhost/dojos_blog_PHP/index.php?page=confirm?id=$user_id&token=$token");
    }
    /** 
     * Permet de confirmer un compte pour la première connexion
     */
    public function confirmation($db, $user_id, $token)
    {
        $user = $db->query('SELECT * FROM users WHERE id_user = ?', [$user_id])->fetch();

        if ($user && $user->confirmation_token == $token) {

            $db->query('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id_user = ?', [$user_id]);
            $this->session->write('auth', $user);
            return true;
        }
        return false;
    }
    public function restrict()
    {

        if (!$this->session->read('auth')) {
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            header('Location: index.php?page=login');
            //exit() pour empêcher la suite de l'éxécution du script
            exit();
        }
    }
    /**
     * Test si user est connecté
     */
    public function user()
    {
        if (!$this->session->read('auth')) {
            return false;
        }
        return $this->session->read('auth');
    }

    /**
     * permet de transférer les variables de l'utilisateur dans la Super GLOBAL $_SESSION['auth]
     */
    public function connect($user)
    {
        $this->session->write('auth', $user);
    }

    public function connectFromCookie($db)
    {

        if (isset($_COOKIE['remember']) && !$this->user()) {

            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user = $db->query('SELECT * FROM users WHERE id_user = ?', [$user_id])->fetch();
            if ($user) {
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ratonlaveurs');

                if ($expected == $remember_token) { // Reconnection automatique si le cookie correspond bien
                    $this->connect($user);
                    $_SESSION['auth'] = $user;
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                } else {
                    setcookie('remember', null, -1);
                }
            } else {
                setcookie('remember', null, -1);
            }
        }
    }

    public function login($db, $username, $password, $remember = false)
    {


        // IS NOT NULL pour empêcher un utilisateur qui n'a pas confirmé son compte de se connecter
        $user = $db->query("SELECT * FROM users WHERE username = :username OR email = :username AND confirmed_at IS NOT NULL", ['username' => $username])->fetch();

        if ($user && password_verify($password, $user->password)) {
            $this->connect($user);

            if ($remember) {
                $this->remember($db, $user->id);
            }
            return $user;
        } else {
            return false;
        }
    }

    public function remember($db, $user_id)
    {

        $remember_token = Str::random(250);
        $db->query("UPDATE users SET remember_token = ? WHERE id_user= ?", [$remember_token, $user_id]);
        setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
    }

    public function logout()
    {
        setcookie('remember', NULL, -1);
        $this->session->delete('auth');
    }

    public function resetPassword($db, $email)
    {

        // IS NOT NULL pour empêcher un utilisateur qui n'a pas confirmé son compte de se connecter
        $user = $db->query("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL", [$_POST['email']])->fetch();
        // var_dump($user);
        if ($user) {
            $reset_token = Str::random(60);

            $db->query("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id_user = ?", [$reset_token, $user->id]);

            mail($email, 'Réinitialisation de votre mot de passe', "Réinitiatilisez votre mot de passe en cliquant sur ce lien\n\nhttp://localhost/dojos_blog_PHP/index.php?page=reset?id={$user->id}&token=$reset_token");
            return $user;
        }
        return false;
    }

    public function checkResetToken($db, $user_id, $token)
    {
        return $db->query('SELECT * FROM users WHERE id_user = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [ $user_id, $token ])->fetch();
    }
}
