<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Editar Pessoa - Sistema de Contatos', 'persons');
$layout->addCustomCSS('<link href="/assets/css/forms.css" rel="stylesheet">');

$name = htmlspecialchars($person->getName());
$cpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $person->getCpf());
$id = $person->getId();

ob_start();
include __DIR__ . '/forms/edit-person.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>