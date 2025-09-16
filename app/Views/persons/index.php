<?php
use Mvc\Components\TableComponent;
use Mvc\Components\LayoutComponent;

foreach ($data as &$row) {
    if (isset($row['cpf'])) {
        $row['cpf'] = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $row['cpf']);
    }
}

$table = new TableComponent($data);
$table->setTitle('Pessoas', 'Sistema de Gerenciamento')
      ->addColumn('name', 'Nome', ['sortable' => true])
      ->addColumn('cpf', 'CPF', ['sortable' => true])
      ->addColumn('contacts_count', 'Contatos')
      ->addTextFilter('name', 'Nome', 'Digite o nome para buscar...')
      ->addAction('view', 'Ver', '/persons/view/{id}', ['class' => 'btn-success', 'icon' => '👁️'])
      ->addAction('edit', 'Editar', '/persons/edit/{id}', ['class' => 'btn-warning', 'icon' => '✏️'])
      ->addAction('add_contact', 'Adicionar Contato', '/contacts/create?person_id={id}&redirect=persons', ['class' => 'btn-info', 'icon' => '📞'])
      ->addAction('delete', 'Excluir', '/persons/delete/{id}', ['class' => 'btn-danger', 'icon' => '🗑️'])
      ->setCreateForm('/persons/create', [
          [
              'name' => 'name',
              'label' => 'Nome Completo',
              'type' => 'text',
              'placeholder' => 'Digite o nome completo da pessoa',
              'required' => true
          ],
          [
              'name' => 'cpf',
              'label' => 'CPF',
              'type' => 'text',
              'placeholder' => '000.000.000-00',
              'required' => true
          ]
      ])
      ->setPagination($_GET['page'] ?? 1, 10);

$table->render();
?>
