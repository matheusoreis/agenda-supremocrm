<?php
$headers = $headers ?? [];
$slot = $slot ?? '';
$total = $total ?? 0;
$page = $page ?? 1;
$lastPage = $lastPage ?? 1;
$perPage = $perPage ?? 20;
$search = $search ?? null;
$showPagination = $showPagination ?? ($lastPage > 1);
?>

<div class="overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-800">
    <table class="w-full text-sm">
        <?php if (!empty($headers)): ?>
            <thead>
                <tr class="border-b border-zinc-200 bg-zinc-50/50 text-left text-xs uppercase tracking-wide text-zinc-500 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-zinc-400">
                    <?php foreach ($headers as $header): ?>
                        <th class="px-4 py-3 font-medium <?= isset($header['align']) ? 'text-' . $header['align'] : '' ?>">
                            <?= $header['label'] ?? $header ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        <?php endif; ?>
        <tbody>
            <?= $slot ?>
        </tbody>
    </table>
</div>

<?php if ($showPagination && $lastPage > 1): ?>
    <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-zinc-500 dark:text-zinc-400">
            Mostrando <?= $perPage ?> de <?= number_format($total, 0, ',', '.') ?> registros
        </div>
        <div class="flex gap-1">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
                    class="btn-secondary btn-sm">Anterior</a>
            <?php endif; ?>

            <?php
            $start = max(1, $page - 2);
            $end = min($lastPage, $page + 2);
            ?>

            <?php if ($start > 1): ?>
                <a href="?page=1<?= $search ? '&search=' . urlencode($search) : '' ?>"
                    class="btn-secondary btn-sm">1</a>
                <?php if ($start > 2): ?>
                    <span class="btn-secondary btn-sm disabled opacity-50 cursor-default">…</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
                    class="<?= $i === $page ? 'btn-primary' : 'btn-secondary' ?> btn-sm">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($end < $lastPage): ?>
                <?php if ($end < $lastPage - 1): ?>
                    <span class="btn-secondary btn-sm disabled opacity-50 cursor-default">…</span>
                <?php endif; ?>
                <a href="?page=<?= $lastPage ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
                    class="btn-secondary btn-sm"><?= $lastPage ?></a>
            <?php endif; ?>

            <?php if ($page < $lastPage): ?>
                <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
                    class="btn-secondary btn-sm">Próxima</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>