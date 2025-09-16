<?php

namespace Mvc\Components;

class LayoutComponent
{
    private string $title = '';
    private string $content = '';
    private string $currentPage = '';
    private array $customCSS = [];
    private array $customJS = [];

    public function __construct(string $title = '', string $currentPage = '')
    {
        $this->title = $title;
        $this->currentPage = $currentPage;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function addCustomCSS(string $css): self
    {
        $this->customCSS[] = $css;
        return $this;
    }

    public function addCustomJS(string $js): self
    {
        $this->customJS[] = $js;
        return $this;
    }

    public function render(): void
    {
        $title = $this->title;
        $content = $this->content;
        $currentPage = $this->currentPage;
        $customCSS = $this->customCSS;
        $customJS = $this->customJS;
        
        include __DIR__ . '/../Views/layout.php';
    }
}
