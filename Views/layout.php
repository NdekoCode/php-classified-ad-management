
<?php $title = $title ?? "Annonces";
loadFileByPath(ROOT_VIEWS_PARTIALS, 'header', compact('title')) ?>
<?= $content ?>
<?php loadFileByPath(ROOT_VIEWS_PARTIALS, 'footer') ?>