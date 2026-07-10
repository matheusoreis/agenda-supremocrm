<?php
$variant = $variant ?? 'primary';
$size = $size ?? 'md';
$type = $type ?? 'button';

$variants = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    'destructive' => 'btn-destructive',
    'outline' => 'border border-zinc-200 bg-white hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-950 dark:hover:bg-zinc-900',
];

$sizes = [
    'sm' => 'h-8 px-3 text-xs',
    'md' => 'h-9 px-4 py-2 text-sm',
    'lg' => 'h-10 px-6 text-base',
];

$classes = 'inline-flex items-center justify-center gap-1.5 whitespace-nowrap rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 dark:focus-visible:ring-zinc-300 dark:focus-visible:ring-offset-zinc-950 disabled:pointer-events-none disabled:opacity-50';
$classes .= ' ' . ($variants[$variant] ?? $variants['primary']);
$classes .= ' ' . ($sizes[$size] ?? $sizes['md']);
?>

<button type="<?= $type ?>" class="<?= $classes ?>"
    <?= isset($onclick) ? "onclick='{$onclick}'" : '' ?>
    <?= isset($disabled) && $disabled ? 'disabled' : '' ?>>
    <?= $slot ?? '' ?>
</button>