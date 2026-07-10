<?php
$columns = $columns ?? [];
$data = $data ?? [];
$module = $module ?? 'contacts';
?>

<tr class="border-b border-zinc-100 last:border-0 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
    <?php foreach ($columns as $column): ?>
        <td class="px-4 py-3">
            <?php if ($column === 'id'): ?>
                <span class="badge">#<?= htmlspecialchars((string) ($data['id'] ?? '')) ?></span>

            <?php elseif (in_array($column, ['abbreviation', 'state_abbr', 'state'], true)): ?>
                <span class="badge"><?= htmlspecialchars($data[$column] ?? '-') ?></span>

            <?php elseif ($column === 'actions'): ?>
                <div class="flex items-center justify-center gap-1">
                    <a href="/<?= $module ?>/<?= $data['id'] ?? '' ?>/edit"
                        class="btn-secondary btn-icon"
                        title="Editar">✏️</a>
                    <a href="/<?= $module ?>/<?= $data['id'] ?? '' ?>/delete"
                        onclick="return confirm('Tem certeza?')"
                        class="btn-secondary btn-icon hover:!bg-red-50 hover:!text-red-600 dark:hover:!bg-red-950 dark:hover:!text-red-400"
                        title="Excluir">🗑️</a>
                </div>

            <?php elseif ($column === 'name'): ?>
                <strong class="text-zinc-900 dark:text-zinc-50"><?= htmlspecialchars($data['name'] ?? '-') ?></strong>

            <?php elseif ($column === 'phone'): ?>
                <?= htmlspecialchars($data['phone'] ?? '-') ?>

            <?php elseif ($column === 'city_name'): ?>
                <?= htmlspecialchars($data['city_name'] ?? '-') ?>

            <?php else: ?>
                <?= htmlspecialchars($data[$column] ?? '-') ?>
            <?php endif; ?>
        </td>
    <?php endforeach; ?>
</tr>