<?php
$id = $id ?? '';
$label = $label ?? '';
$type = $type ?? 'text';
$name = $name ?? $id;
?>

<div class="form-group <?= !empty($error) ? 'has-error' : '' ?>">
    <label for="<?= $id ?>">
        <?= $label ?>

        <?php if (!empty($required)): ?>
            <span class="label-hint">*</span>
        <?php endif; ?>
    </label>

    <input type="<?= $type ?>"
        id="<?= $id ?>"
        name="<?= $name ?>"
        placeholder="<?= $placeholder ?? '' ?>"
        value="<?= $value ?? '' ?>"
        <?= !empty($required) ? 'required' : '' ?>
        <?= isset($maxlength) ? "maxlength='{$maxlength}'" : '' ?>
        <?= !empty($disabled) ? 'disabled' : '' ?>>

    <?php if (!empty($error)): ?>
        <span class="error-text"><?= $error ?></span>
    <?php endif; ?>
</div>