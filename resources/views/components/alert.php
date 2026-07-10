<?php
$message = $message ?? null;
$type = $type ?? 'info';
$dismissible = $dismissible ?? false;
$icon = $icon ?? null;
?>

<?php if ($message): ?>
    <div class="mb-4 rounded-md border px-4 ? py-3 text-sm 
        <?php if ($type === 'success'): ?>
            border-green-200 bg-green-50 text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300
        <?php elseif ($type === 'danger' || $type === 'error'): ?>
            border-red-200 bg-red-50 text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-300
        <?php elseif ($type === 'warning'): ?>
            border-yellow-200 bg-yellow-50 text-yellow-800 dark:border-yellow-900 dark:bg-yellow-950 dark:text-yellow-300
        <?php else: ?>
            border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-900 dark:bg-blue-950 dark:text-blue-300
        <?php endif; ?>
    ">
        <?php if ($dismissible): ?>
            <button class="float-right text-lg leading-none" onclick="this.parentElement.remove()">×</button>
        <?php endif; ?>

        <?php if ($icon): ?>
            <span class="mr-2"><?= $icon ?></span>
        <?php endif; ?>

        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>