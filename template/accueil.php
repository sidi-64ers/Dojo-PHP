<section>
    <h1> </h1>
    <?php $requete = new Article;
          $articles = $requete->findAll();

        foreach ($articles as $article) : ?>
             
            <h1> Nom de l'article :  <?= $article['nom'] ?> </h1>
        <?php endforeach ; ?>
    

</section>