<?php
$columns = $columns ?? [];
$data = $data ?? [];
$class = $class ?? null;
$module = $module ?? 'contacts';
?>

<tr <?= $class ? "class='{$class}'" : '' ?>>
    <?php foreach ($columns as $column): ?>
        <td <?= isset($column['align']) ? "style='text-align:{$column['align']}'" : '' ?>>
            <?php if ($column === 'id'): ?>
                <span class="badge">#<?= $data['id'] ?? '' ?></span>

            <?php elseif ($column === 'state' || $column === 'state_abbr'): ?>
                <span class="state-badge">
                    <?= htmlspecialchars($data['state_abbr'] ?? '-') ?>
                </span>

            <?php elseif ($column === 'actions'): ?>
                <div class="actions">
                    <a href="/<?= $module ?>/<?= $data['id'] ?? '' ?>/edit"
                        class="btn-edit"
                        title="Editar">editar</a>

                    <a href="/<?= $module ?>/<?= $data['id'] ?? '' ?>/delete"
                        class="btn-delete"
                        onclick="return confirm('Tem certeza que deseja excluir?')"
                        title="Excluir">apagar</a>
                </div>

            <?php elseif ($column === 'name'): ?>
                <strong><?= htmlspecialchars($data['name'] ?? '-') ?></strong>

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