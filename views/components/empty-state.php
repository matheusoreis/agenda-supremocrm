<?php
$icon = $icon ?? 'inbox';
$title = $title ?? 'Nenhum registro encontrado';
$description = $description ?? 'Clique em "Novo" para adicionar.';
?>

<div class="text-center py-8">
    <div class="flex justify-center mb-3">
        <?php
        $name = $icon;
        $class = 'w-12 h-12 text-zinc-400 dark:text-zinc-600';
        include __DIR__ . '/icon.php';
        ?>
    </div>
    <p class="font-medium text-zinc-900 dark:text-zinc-50"><?= $title ?></p>
    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1"><?= $description ?></p>
</div>