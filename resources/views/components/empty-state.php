<?php
$icon = $icon ?? '📭';
$title = $title ?? 'Nenhum registro encontrado';
$description = $description ?? 'Clique em "Novo" para adicionar.';
?>

<div class="text-center py-8">
    <div class="text-4xl mb-3"><?= $icon ?></div>
    <p class="font-medium text-zinc-900 dark:text-zinc-50"><?= $title ?></p>
    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1"><?= $description ?></p>
    <?php if (isset($action)): ?>
        <div class="mt-4"><?= $action ?></div>
    <?php endif; ?>
</div>