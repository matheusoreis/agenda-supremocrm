<?php

/** @var array $contacts */
/** @var int $total */
/** @var int $page */
/** @var int $lastPage */
/** @var int $perPage */
/** @var string|null $search */

require_once __DIR__ . '/../../../src/Helpers/helpers.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-8 sm:mb-10">
    <h2 class="text-xl font-semibold flex items-center gap-2">
        <?= render_component('icon', ['name' => 'users', 'class' => 'w-5 h-5']) ?>
        Contatos
    </h2>

    <?= render_component('button', [
        'variant' => 'primary',
        'size' => 'md',
        'icon' => 'plus',
        'label' => 'Novo',
        'onclick' => "window.location.href='/contacts/create'"
    ]) ?>
</div>

<div class="flex gap-2 mb-4">
    <form method="GET" action="/contacts" class="flex flex-col sm:flex-row gap-2 w-full">
        <div class="flex-1">
            <?= render_component('input', [
                'id' => 'search',
                'name' => 'search',
                'value' => $search ?? '',
                'placeholder' => 'Pesquisar por nome, telefone, cidade ou estado...',
                'class' => 'flex-1'
            ]) ?>
        </div>

        <div class="flex gap-2">
            <div class="flex-1">
                <?= render_component('button', [
                    'variant' => 'primary',
                    'size' => 'md',
                    'icon' => 'search',
                    'label' => 'Buscar',
                    'type' => 'submit',
                    'extraClass' => 'w-full'
                ]) ?>
            </div>

            <?= render_component('button', [
                'variant' => 'destructive',
                'size' => 'md',
                'icon' => 'x',
                'label' => 'Limpar',
                'onclick' => "window.location.href='/contacts'"
            ]) ?>
        </div>
    </form>
</div>

<?php
$headers = ['ID', 'Nome', 'Telefone', 'Cidade', 'Estado', ['label' => 'Ações', 'align' => 'center']];
ob_start();
?>

<?php if (empty($contacts)): ?>
    <tr>
        <td colspan="6" class="px-4 py-14 text-center">
            <?= render_component('empty-state', [
                'icon' => 'users',
                'title' => 'Nenhum contato encontrado',
                'description' => 'Clique em "Novo" para adicionar.'
            ]) ?>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($contacts as $contact): ?>
        <?php
        $data = [
            'id' => $contact['id'],
            'name' => $contact['name'],
            'phone' => $contact['phone'] ?? '-',
            'city_name' => $contact['city_name'] ?? '-',
            'state_abbr' => $contact['state_abbr'] ?? '-',
        ];
        $columns = ['id', 'name', 'phone', 'city_name', 'state_abbr', 'actions'];
        $module = 'contacts';
        ?>
        <?= render_component('table-row', [
            'data' => $data,
            'columns' => $columns,
            'module' => $module
        ]) ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$slot = ob_get_clean();
?>

<?= render_component('table', [
    'headers' => $headers,
    'slot' => $slot,
    'total' => $total ?? 0,
    'page' => $page ?? 1,
    'lastPage' => $lastPage ?? 1,
    'perPage' => $perPage ?? 20,
    'search' => $search ?? null
]) ?>