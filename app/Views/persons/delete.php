<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Excluir Pessoa - Sistema de Contatos', 'persons');
$layout->addCustomCSS('<link href="/assets/css/confirmation.css" rel="stylesheet">');

$id = $person->getId();
$name = htmlspecialchars($person->getName());
$contactsCount = $person->getContacts()->count();

ob_start();
include __DIR__ . '/forms/delete-person.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>