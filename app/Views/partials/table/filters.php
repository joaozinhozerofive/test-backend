<?php if (!empty($filters)): ?>
<div class="filters-section">
    <form method="GET" class="filters-form">
        <?php foreach ($filters as $key => $filter): ?>
            <div class="form-group">
                <label for="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($filter['label']) ?></label>
                <?php if ($filter['type'] === 'text'): ?>
                    <input type="text" 
                           id="<?= htmlspecialchars($key) ?>" 
                           name="<?= htmlspecialchars($key) ?>" 
                           placeholder="<?= htmlspecialchars($filter['placeholder'] ?? '') ?>" 
                           value="<?= htmlspecialchars($_GET[$key] ?? '') ?>">
                <?php elseif ($filter['type'] === 'select'): ?>
                    <select id="<?= htmlspecialchars($key) ?>" name="<?= htmlspecialchars($key) ?>">
                        <option value="">Todos</option>
                        <?php foreach ($filter['choices'] as $optionValue => $optionLabel): ?>
                            <option value="<?= htmlspecialchars($optionValue) ?>" 
                                    <?= ($_GET[$key] ?? '') === $optionValue ? 'selected' : '' ?>>
                                <?= htmlspecialchars($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="form-group filter-buttons">
            <button type="submit" class="btn btn-sm btn-primary">🔍 Filtrar</button>
            <a href="<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>" class="btn btn-sm btn-secondary">🔄 Limpar</a>
        </div>
    </form>
</div>
<?php endif; ?>
