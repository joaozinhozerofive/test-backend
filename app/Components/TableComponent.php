<?php

namespace Mvc\Components;

class TableComponent
{
    private array $columns = [];
    private array $data = [];
    private array $filters = [];
    private array $actions = [];
    private int $currentPage = 1;
    private int $itemsPerPage = 10;
    private string $title = '';
    private string $subtitle = '';
    private array $formFields = [];
    private string $createUrl = '';

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function setTitle(string $title, string $subtitle = ''): self
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function addColumn(string $key, string $label, array $options = []): self
    {
        $this->columns[$key] = [
            'label' => $label,
            'sortable' => $options['sortable'] ?? false,
            'options' => $options
        ];
        return $this;
    }

    public function addTextFilter(string $key, string $label, string $placeholder = ''): self
    {
        $this->filters[$key] = [
            'label' => $label,
            'type' => 'text',
            'placeholder' => $placeholder
        ];
        return $this;
    }

    public function addSelectFilter(string $key, string $label, array $choices): self
    {
        $this->filters[$key] = [
            'label' => $label,
            'type' => 'select',
            'choices' => $choices
        ];
        return $this;
    }

    public function addAction(string $key, string $label, string $url, array $options = []): self
    {
        $this->actions[$key] = [
            'label' => $label,
            'url' => $url,
            'options' => $options
        ];
        return $this;
    }

    public function setPagination(int $currentPage, int $itemsPerPage = 10): self
    {
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    public function setCreateForm(string $url, array $fields): self
    {
        $this->createUrl = $url;
        $this->formFields = $fields;
        return $this;
    }

    public function render()
    {
        $content = $this->renderContent();
        
        $layout = new LayoutComponent($this->title, $this->getCurrentPageName());
        $layout->setContent($content);
        
        $layout->addCustomCSS('<link href="/assets/css/table.css" rel="stylesheet">');
        
        $layout->render();
    }

    public function renderContent(): string
    {
        ob_start();
        
        $title = $this->title;
        $subtitle = $this->subtitle;
        $formFields = $this->formFields;
        $createUrl = $this->createUrl;
        $filters = $this->filters;
        $columns = $this->columns;
        $actions = $this->actions;
        $data = $this->data;
        $paginatedData = $this->getPaginatedData();
        $totalPages = $this->getTotalPages();
        $currentPage = $this->currentPage;
        $isContactForm = $this->isContactForm();
        
        if ($this->title) {
            include __DIR__ . '/../Views/partials/table/header.php';
        }
        
        include __DIR__ . '/../Views/partials/table/filters.php';
        include __DIR__ . '/../Views/partials/table/table.php';
        include __DIR__ . '/../Views/partials/table/modal.php';
        include __DIR__ . '/../Views/partials/table/javascript.php';
        
        return ob_get_clean();
    }


    private function getCurrentPageName(): string
    {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (strpos($currentPath, '/persons') !== false) {
            return 'persons';
        }
        if (strpos($currentPath, '/contacts') !== false) {
            return 'contacts';
        }
        
        return 'home';
    }



    private function isContactForm(): bool
    {
        $hasType = false;
        $hasDescription = false;
        $hasPersonId = false;
        
        foreach ($this->formFields as $field) {
            if ($field['name'] === 'type') $hasType = true;
            if ($field['name'] === 'description') $hasDescription = true;
            if ($field['name'] === 'person_id') $hasPersonId = true;
        }
        
        return $hasType && $hasDescription && $hasPersonId;
    }


    public function getTotalItems(): int
    {
        return count($this->data);
    }

    public function getTotalPages(): int
    {
        return ceil($this->getTotalItems() / $this->itemsPerPage);
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    private function getPaginatedData(): array
    {
        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        return array_slice($this->data, $offset, $this->itemsPerPage);
    }
}