<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Criar Pessoa - Sistema de Contatos', 'persons');
$layout->addCustomCSS('<link href="/assets/css/forms.css" rel="stylesheet">');

ob_start();
include __DIR__ . '/forms/create-person.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>