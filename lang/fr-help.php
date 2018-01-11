<h2>Aide</h2>
<p>
  
  Ce plugin ajoute un champs de type Dossier appelé "Medias" permettant d'ajouter un gallerie d'image à un article.
  <br>
  L'intégration de plugin dans le thème requiert des compétences en PHP, HTML et CSS.
</p>
<h3 style="font-size:1.3em;font-weight:bold;padding:10px 0 10px 0">Définir le html de la gallerie</h3>
<p>
Dans un fichier de <strong>gallery.php</strong> de votre thème, ajoutez :
</p>
<pre style="font-size:12px; padding-left:40px">
$dir=PLX_ROOT.$plxMotor-&gt;plxRecord_arts-&gt;f('medias_dir');
// Récupération et affichage de la liste des images sous forme de liste
$glob = plxGlob::getInstance($dir);

if ($files = $glob-&gt;query('/[a-z0-9-_]+.(jpg|jpeg|gif|png)$/i')) { ?&gt;
          &lt;div id="gallery"&gt;
&lt;?php
foreach($files as $filename) {
  $n++;
  $thumbnail = $plxShow-&gt;plxMotor-&gt;racine.$dir.$filename;
  $title = htmlspecialchars($filename);	// sécuriser la chaine de caractères
  $title = substr($title, 0, strrpos($title, '.'));
  $size = getimagesize($dir.$filename);
  $sizeStr = $size[3];
  echo &lt;&lt;&lt; EOT
  &lt;div class="gallery-item gallery-item-$n"&gt;
    &lt;img src="$thumbnail" alt="$title" $sizeStr /&gt;
  &lt;/div&gt;
EOT;
}
</pre>

<h3 style="font-size:1.3em;font-weight:bold;padding:10px 0 10px 0">Dans les articles et dans les pages statiques</h3>
<p>
Dans le fichier <strong>article.php</strong>  ou <strong>static.php</strong> de votre thème, ajoutez la ligne suivante à l'endroit où vous souhaitez afficher les boutons.
</p>
<pre style="font-size:12px; padding-left:40px">
&lt;?php include(dirname(__FILE__).'/gallery.php'); ?&gt;
</pre>



