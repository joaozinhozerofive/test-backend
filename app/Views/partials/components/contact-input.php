<div class="contact-input-group">
    <div class="form-group">
        <label for="<?= $id ?>_type">Tipo *</label>
        <select id="<?= $id ?>_type" name="<?= $name ?>_type" <?= $requiredAttr ?> <?= $disabledAttr ?> onchange="applyContactMask(this)">
            <option value="">Selecione...</option>
            <?php foreach ($typeChoices as $value => $label): ?>
                <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="<?= $id ?>">Contato *</label>
        <input type="text" id="<?= $id ?>" name="<?= $name ?>" placeholder="<?= htmlspecialchars($placeholder) ?>" <?= $requiredAttr ?> <?= $disabledAttr ?> <?= $valueAttr ?>>
    </div>
</div>
