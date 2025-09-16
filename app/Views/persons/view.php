<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Visualizar Pessoa - Sistema de Contatos', 'persons');
$layout->addCustomCSS('<link href="/assets/css/view.css" rel="stylesheet">');

$name = htmlspecialchars($person->getName());
$cpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $person->getCpf());
$contactsCount = $person->getContacts()->count();
$id = $person->getId();
$contacts = $person->getContacts();

ob_start();
include __DIR__ . '/details/view-person.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>