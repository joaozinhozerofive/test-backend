<?php
use Mvc\Components\LayoutComponent;
use Mvc\Components\ContactInputComponent;

$layout = new LayoutComponent('Editar Contato - Sistema de Contatos', 'contacts');
$layout->addCustomCSS('<link href="/assets/css/forms.css" rel="stylesheet">');
$layout->addCustomJS(ContactInputComponent::getJavaScript());

$contactId = $contact->getId();
$personId = $contact->getPerson()->getId();
$personName = htmlspecialchars($contact->getPerson()->getName());
$contactType = $contact->getType();
$contactDescription = htmlspecialchars($contact->getDescription());

ob_start();
include __DIR__ . '/forms/edit-contact.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>