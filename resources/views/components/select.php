<?php
$id = $id ?? '';
$label = $label ?? '';
$options = $options ?? [];

$name = $name ?? $id;
$required = $required ?? false;
$disabled = $disabled ?? false;
$placeholder = $placeholder ?? null;
$selected = $selected ?? null;
$error = $error ?? null;
?>

<div class="form-group <?= $error ? 'has-error' : '' ?>">
    <label for="<?= $id ?>">
        <?= $label ?>

        <?php if ($required): ?>
            <span class="label-hint">*</span>
        <?php endif; ?>
    </label>

    <select id="<?= $id ?>"
        name="<?= $name ?>"
        <?= $required ? 'required' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>>

        <?php if ($placeholder !== null): ?>
            <option value=""><?= $placeholder ?></option>
        <?php endif; ?>

        <?php foreach ($options as $value => $optionLabel): ?>
            <option value="<?= $value ?>" <?= $selected == $value ? 'selected' : '' ?>>
                <?= $optionLabel ?>
            </option>
        <?php endforeach; ?>

    </select>

    <?php if ($error): ?>
        <span class="error-text"><?= $error ?></span>
    <?php endif; ?>
</div>