
    <nav class="navbar navbar-success">
        <div class="container">
            <div class="navbar-header bg-success">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar">fdsf</span>
                    <span class="icon-bar">fsdf</span>
                    <span class="icon-bar">fsdf</span>
                </button>
                <a class="navbar-brand" href="index.php?page=accueil">Accueil</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php $user = App::getAuth()->user();
                    if ($user) : ?>
                        <li><a href="index.php?page=logout">Se déconnecter</a></li>               
                    <?php else : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Catégorie
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="index.php?page=categorie&categorie=bonheur">#</a>
                                <a class="dropdown-item" href="index.php?">#</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">#</a>
                            </div>
                        </li>
                        <li><a href="index.php?page=register">S'inscrire</a></li>
                        <li><a href="index.php?page=login">Se connecter</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
    <!-- S SESSION['flash] contient les messages d'erreur pour les sessions sous forme array -->
        <?php if (Session::getInstance()->hasFlashes()): ?>
            <?php foreach(Session::getInstance()->getFlashes() as $type => $message) : ?>
                <div class="alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
         <?php endif; ?>
        

