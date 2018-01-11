<?php
/**
 * Plugin plxArticleMedias
 *
 *
 **/
class plxArticleMedias extends plxPlugin {

	protected $callable = true;

	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 * @author	luffah
	 **/
	public function __construct($default_lang) {

		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

    # Autorisation d'acces à la configuration du plugins
		$this-> setConfigProfil(PROFIL_ADMIN, PROFIL_MANAGER);

		# Autorisation d'accès à l'administration du plugin
		$this->setAdminProfil(PROFIL_ADMIN, PROFIL_MANAGER);

		# déclaration des hooks controlleur
		$this->addHook('AdminArticlePreview', 'AdminArticlePreview');
		$this->addHook('AdminArticlePostData', 'AdminArticlePostData');
		$this->addHook('AdminArticleParseData', 'AdminArticleParseData');
		$this->addHook('AdminArticleInitData', 'AdminArticleInitData');
    $this->addHook('plxAdminEditArticleXml', 'plxAdminEditArticleXml');
		$this->addHook('plxMotorParseArticle', 'plxMotorParseArticle');

    # déclaration des hooks vue
    $this->addHook('AdminArticleContent', 'AdminArticleContent');//admin main view
  }
	public function AdminArticlePostData () {
    echo "<?php \$medias_dir = \$_POST[\"medias_dir\"]; ?> ";
	}
  public function plxMotorParseArticle	() {
    if (defined('PLX_ADMIN')) {
      $plxMotor = plxAdmin::getInstance();
    } else { 
      $plxMotor = plxMotor::getInstance();
    }
    $artMediaDir=$plxMotor->aConf['medias'].$this->getParam('root_dir').'/';
    echo "<?php \$art['medias_dir'] = '".$artMediaDir."'.\$art['url'].'/'; ?>";
  }
	public function AdminArticleParseData () {
		echo '<?php $medias_dir = $result["medias_dir"]; ?>';
	}
	
	public function AdminArticleInitData () {
		echo '<?php $medias_dir = ""; ?>';
	}

	public function AdminArticlePreview () {
		echo '<?php if(!empty($_POST["medias_dir"])) { $art["medias_dir"] = $_POST["medias_dir"]; } ?>';
	}

	public function plxAdminEditArticleXml(){
    echo "<?php
\$xml .= '\t'.'<medias_dir><![CDATA['.plxUtils::cdataCheck(trim(\$content['medias_dir'])).']]></medias_dir>'.'\n';
if(!is_dir(PLX_ROOT.\$content['medias_dir'])) {
  @mkdir(PLX_ROOT.\$content['medias_dir'],0755,true);
}
?>";
	}


  /**
   * Vue d'édition des articles liés
   *
   * @return	stdio
   * @author	luffah
   **/
  public function AdminArticleContent() {
		if(!$this->callable) return;
    # Nouvel objet de type plxMedias
		if (defined('PLX_ADMIN')) {
			$plxMotor = plxAdmin::getInstance();
		}
		else {
			$plxMotor = plxMotor::getInstance();
		}
  
  
    $string = "
<?php 

\$medias_manager_dir=str_replace('".$plxMotor->aConf['medias']."','',\$medias_dir);

\$galleriescript=\"
mediasManager.openPopup('id_medias_dir',false);
setTimeout(function(){
popup.document.getElementById('folder').value='\".\$medias_manager_dir.\"';
popup.document.getElementsByName('btn_changefolder').item(0).click();
},1000);
\";
?>
<fieldset>
<p>
<label for='id_medias_dir' style='display:inline;'>
Dossier multimédia / galerie d'images&nbsp;:&nbsp;<a class=\"hint\"><span><?php echo L_ARTICLE_URL_FIELD_TITLE ?></span></a>
<a title='<?php echo L_THUMBNAIL_SELECTION ?>' href='javascript:void(0)' onclick=\"<?php echo \$galleriescript;?>\" style='outline:none; text-decoration: none'>+</a>
</label>
<?php plxUtils::printInput('medias_dir',\$medias_dir,'text','255-255',true,'','','style=\"display:none\"'); ?>
<a title='<?php echo L_THUMBNAIL_SELECTION ?>' href='javascript:void(0)' onclick=\"<?php echo \$galleriescript;?>\" ><?php echo \$medias_dir;?></a>
</p>
";
    echo $string;
  }
}
?>
