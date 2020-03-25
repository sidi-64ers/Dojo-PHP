<?php

class Renderer
{
    /**
     * render('article/show')
     * Permet d'afficher le chemin du fichier à afficher 
     * 
     */
    public static function render(string $path, array $variables = [])
    {

        extract($variables); // permet d'extraire les variables stockés dans un tableau
        // ['var1' => 3, 'var2' => 5]
        // extract va permettre de les rendre comme ceci:
        // $var1 = 3;
        // $var2 = 5;
        // $variables va permettre de transmettre les variables à show.html.php sinon elles seront Undefined

        ob_start();    // J'ouvre un tampon qui ne va pas réellement affiché de suite
        require('templates/' . $path . '.html.php');   // Contient la boucle des articles 
        $pageContent = ob_get_clean();  // J'afficherai dans la variable $pageContent le require de index.html.php

        require('templates/layout.html.php');   
        // $pagecontent sera affiché dans layout.html.php et contiendra le require du tampon ouvert lors de l'appel de la méthode render dans chaque Controllers 
    }
}
