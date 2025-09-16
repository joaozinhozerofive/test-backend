<?php
use Mvc\Components\TableComponent;

$table = new TableComponent($data);
$table->setTitle('Contatos', 'Sistema de Gerenciamento')
      ->addColumn('person_name', 'Pessoa', ['sortable' => true])
      ->addColumn('type', 'Tipo', ['sortable' => true])
      ->addColumn('description', 'Contato', ['sortable' => true])
      ->addTextFilter('person_name', 'Pessoa', 'Digite o nome da pessoa...')
      ->addSelectFilter('type', 'Tipo', [
          'Telefone' => 'Telefone',
          'Email' => 'Email'
      ])
      ->addAction('view', 'Visualizar', '/contacts/view/{id}', ['class' => 'btn-info', 'icon' => '👁️'])
      ->addAction('edit', 'Editar', '/contacts/edit/{id}', ['class' => 'btn-warning', 'icon' => '✏️'])
      ->addAction('delete', 'Excluir', '/contacts/delete/{id}', ['class' => 'btn-danger', 'icon' => '🗑️'])
      ->setCreateForm('/contacts/create', [
          [
              'name' => 'type',
              'label' => 'Tipo',
              'type' => 'select',
              'choices' => [
                  'Telefone' => 'Telefone',
                  'Email' => 'Email'
              ],
              'required' => true
          ],
          [
              'name' => 'description',
              'label' => 'Contato',
              'type' => 'text',
              'placeholder' => 'Selecione o tipo primeiro',
              'required' => true
          ],
          [
              'name' => 'person_id',
              'label' => 'Pessoa',
              'type' => 'select',
              'choices' => $personsChoices,
              'required' => true
          ]
      ])
      ->setPagination($_GET['page'] ?? 1, 10);

$table->render();
?>
