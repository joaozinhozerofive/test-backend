<?php if (!empty($formFields) && !empty($createUrl)): ?>
<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>➕ Adicionar Novo Registro</h2>
            <span class="close" onclick="closeCreateModal()">&times;</span>
        </div>
        <form id="createForm" method="POST" action="<?= htmlspecialchars($createUrl) ?>">
            <div class="modal-body">
                <?php foreach ($formFields as $field): ?>
                    <div class="form-group">
                        <label for="<?= htmlspecialchars($field['name']) ?>">
                            <?= htmlspecialchars($field['label']) ?><?= ($field['required'] ?? false) ? ' *' : '' ?>
                        </label>
                        
                        <?php if ($field['name'] === 'type' && $isContactForm): ?>
                            <select id="<?= htmlspecialchars($field['name']) ?>" 
                                    name="<?= htmlspecialchars($field['name']) ?>" 
                                    <?= ($field['required'] ?? false) ? 'required' : '' ?> 
                                    onchange="applyContactMask(this)">
                                <option value="">Selecione...</option>
                                <?php foreach ($field['choices'] as $value => $optionLabel): ?>
                                    <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($optionLabel) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php elseif ($field['name'] === 'description' && $isContactForm): ?>
                            <input type="<?= htmlspecialchars($field['type'] ?? 'text') ?>" 
                                   id="<?= htmlspecialchars($field['name']) ?>" 
                                   name="<?= htmlspecialchars($field['name']) ?>" 
                                   placeholder="<?= htmlspecialchars($field['placeholder'] ?? '') ?>" 
                                   <?= ($field['required'] ?? false) ? 'required' : '' ?>>
                        <?php elseif (($field['type'] ?? 'text') === 'textarea'): ?>
                            <textarea id="<?= htmlspecialchars($field['name']) ?>" 
                                      name="<?= htmlspecialchars($field['name']) ?>" 
                                      placeholder="<?= htmlspecialchars($field['placeholder'] ?? '') ?>" 
                                      <?= ($field['required'] ?? false) ? 'required' : '' ?>></textarea>
                        <?php elseif (($field['type'] ?? 'text') === 'select'): ?>
                            <select id="<?= htmlspecialchars($field['name']) ?>" 
                                    name="<?= htmlspecialchars($field['name']) ?>" 
                                    <?= ($field['required'] ?? false) ? 'required' : '' ?>>
                                <option value="">Selecione...</option>
                                <?php foreach ($field['choices'] as $value => $optionLabel): ?>
                                    <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($optionLabel) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input type="<?= htmlspecialchars($field['type'] ?? 'text') ?>" 
                                   id="<?= htmlspecialchars($field['name']) ?>" 
                                   name="<?= htmlspecialchars($field['name']) ?>" 
                                   placeholder="<?= htmlspecialchars($field['placeholder'] ?? '') ?>" 
                                   <?= ($field['required'] ?? false) ? 'required' : '' ?>>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">
                    ❌ Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    ✅ Salvar Registro
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>⚠️ Confirmar Exclusão</h2>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="warning-icon">⚠️</div>
                <div class="warning-content">
                    <h3>Tem certeza que deseja excluir este item?</h3>
                    <p id="deleteMessage">Esta ação não pode ser desfeita!</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                ❌ Cancelar
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">
                    ✅ Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
</div>
