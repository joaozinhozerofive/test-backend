<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Sistema de Contatos - Home', 'home');
$layout->addCustomCSS('<link href="/assets/css/home.css" rel="stylesheet">');

ob_start();
include __DIR__ . '/content/home-content.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>
