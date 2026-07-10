<?php
$title = $title ?? null;
$action = $action ?? null;
$slot = $slot ?? '';
?>

<div class="rounded-lg border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
    <?php if ($title): ?>
        <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-4 dark:border-zinc-800">
            <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-50"><?= $title ?></h3>
            <?php if ($action): ?>
                <div><?= $action ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="p-6">
        <?= $slot ?>
    </div>
</div>