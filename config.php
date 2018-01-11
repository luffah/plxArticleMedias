<?php
if(!defined('PLX_ROOT')) exit;

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST['save'])) {
  $plxPlugin->setParam('root_dir', trim(ltrim($_POST['root_dir'], '/')), 'string');
  $plxPlugin->setParam('sortorder', $_POST['sortorder'], 'cdata');
  $plxPlugin->saveParams();
  header('Location: parametres_plugin.php?p=plxArticleMedias');
  exit;
}
 ?>

	<form action="parametres_plugin.php?p=plxArticleMedias" method="post">
	
	<fieldset class="withlabel">
		<p><?php echo $plxPlugin->getLang('L_CONFIG_ROOT_DIR') ?></p>
		<?php plxUtils::printInput('root_dir', $plxPlugin->getParam('root_dir'), 'text'); ?>
		
		<p><?php echo $plxPlugin->getLang('L_CONFIG_SORT_ORDER');
		$sortorder['natural'] = 'natural';
		$sortorder['mtime'] = 'mtime';
		$sortorder['mtime_r'] = 'mtime_r';
		plxUtils::printSelect('sortorder', $sortorder, $selected=$plxPlugin->getParam('sortorder')); ?>
		</p>
	</fieldset>
	<br />
	<?php echo plxToken::getTokenPostMethod() ?>
	<input type="submit" name="save" value="<?php echo $plxPlugin->getLang('L_SAVE') ?>" />

	</form>
