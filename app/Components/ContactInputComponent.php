<?php

namespace Mvc\Components;

class ContactInputComponent
{
    private array $typeChoices;
    private string $name;
    private string $id;
    private string $value;
    private string $placeholder;
    private bool $required;
    private bool $disabled;

    public function __construct(array $typeChoices = [])
    {
        $this->typeChoices = $typeChoices ?: [
            'Telefone' => 'Telefone',
            'Email' => 'Email'
        ];
        $this->name = 'description';
        $this->id = 'description';
        $this->value = '';
        $this->placeholder = 'Selecione o tipo primeiro';
        $this->required = true;
        $this->disabled = false;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setValue(string $value): self
    {
        $this->value = htmlspecialchars($value);
        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = htmlspecialchars($placeholder);
        return $this;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;
        return $this;
    }

    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function render(): string
    {
        ob_start();
        
        $requiredAttr = $this->required ? 'required' : '';
        $disabledAttr = $this->disabled ? 'disabled' : '';
        $valueAttr = $this->value ? "value=\"{$this->value}\"" : '';
        $typeChoices = $this->typeChoices;
        $id = $this->id;
        $name = $this->name;
        $placeholder = $this->placeholder;
        
        include __DIR__ . '/../Views/partials/components/contact-input.php';
        
        return ob_get_clean();
    }

    public static function getJavaScript(): string
    {
        ob_start();
        include __DIR__ . '/../Views/partials/components/contact-input-js.php';
        return ob_get_clean();
    }
}
