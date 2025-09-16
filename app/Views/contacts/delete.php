<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Excluir Contato - Sistema de Contatos', 'contacts');
$layout->addCustomCSS('<link href="/assets/css/confirmation.css" rel="stylesheet">');

$id = $contact->getId();
$type = htmlspecialchars($contact->getType());
$description = htmlspecialchars($contact->getDescription());
$personName = htmlspecialchars($contact->getPerson()->getName());

ob_start();
include __DIR__ . '/forms/delete-contact.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>