<?php
$id = $id ?? '';
$label = $label ?? '';
$type = $type ?? 'text';
$name = $name ?? $id;
$value = $value ?? '';
$placeholder = $placeholder ?? '';
$required = $required ?? false;
$disabled = $disabled ?? false;
$error = $error ?? null;
?>

<div class="space-y-1.5">
    <?php if ($label): ?>
        <label for="<?= $id ?>" class="block text-sm font-medium text-zinc-900 dark:text-zinc-50">
            <?= $label ?>
            <?php if ($required): ?>
                <span class="text-zinc-400 dark:text-zinc-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input
        type="<?= $type ?>"
        id="<?= $id ?>"
        name="<?= $name ?>"
        placeholder="<?= $placeholder ?>"
        value="<?= htmlspecialchars($value) ?>"
        class="flex h-9 w-full rounded-md border border-zinc-200 bg-white px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-1 disabled:opacity-50 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:focus-visible:ring-zinc-300 dark:focus-visible:ring-offset-zinc-950 <?= $error ? 'border-red-500 focus-visible:ring-red-500 dark:border-red-500' : '' ?>"
        <?= $required ? 'required' : '' ?>
        <?= $disabled ? 'disabled' : '' ?>
        <?= isset($maxlength) ? "maxlength='{$maxlength}'" : '' ?>>

    <?php if ($error): ?>
        <p class="text-sm text-red-600 dark:text-red-400"><?= $error ?></p>
    <?php endif; ?>
</div>