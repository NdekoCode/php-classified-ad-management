<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Un site des petites annonces qui permet aux particuliers ou aux professionnels de publier des annonces pour vendre, acheter, louer ou échanger des biens ou des services. Les annonces sont généralement classées par catégories (immobilier, véhicules, emploi, mode, loisirs, etc.) et par localisation géographique. Les utilisateurs peuvent consulter les annonces gratuitement ou payer pour les mettre en avant.">
    <link rel="stylesheet" href="/assets/css/app.css" />
    <title><?= $title ?? "Annonce" ?></title>
</head>

<body class="flex flex-col min-h-screen"></body>
<?php loadFileByPath(ROOT_VIEWS_PARTIALS, 'navbar') ?>