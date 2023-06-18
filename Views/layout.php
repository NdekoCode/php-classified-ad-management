
<?php $title = $title ?? "Annonces";
loadFileByPath(ROOT_VIEWS_PARTIALS, 'header', compact('title'));
loadFileByPath(ROOT_VIEWS_PARTIALS, 'alerts'); ?>
<?= $content ?>
<?php loadFileByPath(ROOT_VIEWS_PARTIALS, 'footer');
unset($_SESSION['alert']); ?>