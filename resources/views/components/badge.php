<?php
$variant = $variant ?? 'default';

$variants = [
    'default' => 'border-zinc-200 text-zinc-700 dark:border-zinc-700 dark:text-zinc-300',
    'primary' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-300',
    'success' => 'border-green-200 bg-green-50 text-green-700 dark:border-green-800 dark:bg-green-950 dark:text-green-300',
    'danger' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-800 dark:bg-red-950 dark:text-red-300',
    'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-700 dark:border-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
];
?>

<span class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-medium <?= $variants[$variant] ?? $variants['default'] ?>">
    <?= $slot ?? '' ?>
</span>