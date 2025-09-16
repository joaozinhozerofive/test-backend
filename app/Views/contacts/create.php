<?php
use Mvc\Components\LayoutComponent;
use Mvc\Components\ContactInputComponent;

$layout = new LayoutComponent('Criar Contato - Sistema de Contatos', 'contacts');
$layout->addCustomCSS('<link href="/assets/css/forms.css" rel="stylesheet">');
$layout->addCustomJS(ContactInputComponent::getJavaScript());

ob_start();
include __DIR__ . '/forms/create-contact.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>
