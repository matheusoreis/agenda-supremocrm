<?php

$variant = $variant ?? 'primary';
$size = $size ?? 'md';
$type = $type ?? 'button';
$id = $id ?? '';
$onclick = $onclick ?? '';
$icon = $icon ?? null;
$iconPosition = $iconPosition ?? 'left';
$label = $label ?? '';

$variants = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    'destructive' => 'btn-destructive',
    'outline' => 'border border-zinc-200 bg-white hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-950 dark:hover:bg-zinc-900',
];

$sizes = [
    'icon' => 'h-9 px-4 py-2 text-sm',
    'sm' => 'h-8 px-3 text-xs',
    'md' => 'h-9 px-4 py-2 text-sm',
    'lg' => 'h-10 px-6 text-base',
];

$classes = 'inline-flex items-center justify-center gap-1.5 whitespace-nowrap rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 dark:focus-visible:ring-zinc-300 dark:focus-visible:ring-offset-zinc-950 disabled:pointer-events-none disabled:opacity-50';
$classes .= ' ' . ($variants[$variant] ?? $variants['primary']);
$classes .= ' ' . ($sizes[$size] ?? $sizes['md']);
?>

<button
    type="<?= $type ?>"
    class="<?= $classes ?>"
    id="<?= $id ?>"
    <?= $onclick ? "onclick=\"{$onclick}\"" : '' ?>
    <?= isset($disabled) && $disabled ? 'disabled' : '' ?>>

    <?php if ($icon && $iconPosition === 'left'): ?>
        <?php
        $name = $icon;
        $class = 'w-4 h-4';
        include __DIR__ . '/icon.php';
        ?>
    <?php endif; ?>

    <?php if ($label): ?>
        <?= $label ?>
    <?php endif; ?>

    <?php if ($icon && $iconPosition === 'right'): ?>
        <?php
        $name = $icon;
        $class = 'w-4 h-4';
        include __DIR__ . '/icon.php';
        ?>
    <?php endif; ?>
</button>

<?php
unset($variant, $size, $type, $id, $onclick, $icon, $iconPosition, $label, $slot, $disabled);
?>