<?php
use Mvc\Components\LayoutComponent;

$layout = new LayoutComponent('Visualizar Contato - Sistema de Contatos', 'contacts');
$layout->addCustomCSS('<link href="/assets/css/view.css" rel="stylesheet">');

$id = $contact->getId();
$type = htmlspecialchars($contact->getType());
$description = htmlspecialchars($contact->getDescription());
$personName = htmlspecialchars($contact->getPerson()->getName());

function formatContact($type, $description) {
    if ($type === 'Telefone') {
		$numbers = preg_replace('/\D/', '', $description);
        
		if (strlen($numbers) === 10) {
            return '(' . substr($numbers, 0, 2) . ') ' . substr($numbers, 2, 4) . '-' . substr($numbers, 6);
        } 
		
		if (strlen($numbers) === 11) {
            return '(' . substr($numbers, 0, 2) . ') ' . substr($numbers, 2, 5) . '-' . substr($numbers, 7);
        }
    }
    return $description;
}

$formattedDescription = formatContact($type, $description);

ob_start();
include __DIR__ . '/details/view-contact.php';
$content = ob_get_clean();

$layout->setContent($content);
$layout->render();
?>
