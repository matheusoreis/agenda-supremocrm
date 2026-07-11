<?php

/** @var array $contact */
/** @var array $states */
/** @var array $cities */
/** @var array $errors */

require_once __DIR__ . '/../../../../src/Helpers/helpers.php';
?>

<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <?= render_component('icon', ['name' => 'pencil', 'class' => 'w-5 h-5']) ?>
            Editar Contato
        </h2>

        <?= render_component('button', [
            'variant' => 'secondary',
            'size' => 'sm',
            'icon' => 'arrow-left',
            'label' => 'Voltar',
            'onclick' => "window.location.href='/contacts'"
        ]) ?>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-300">
            <ul class="list-disc list-inside space-y-0.5">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/contacts/<?= $contact['id'] ?>/update" method="POST" class="card p-6 space-y-4 w-full">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <?= render_component('input', [
                    'id' => 'name',
                    'label' => 'Nome',
                    'name' => 'name',
                    'value' => $contact['name'] ?? '',
                    'required' => true
                ]) ?>
            </div>

            <div class="flex-1">
                <?= render_component('input', [
                    'id' => 'phone',
                    'label' => 'Telefone',
                    'name' => 'phone',
                    'value' => $contact['phone'] ?? '',
                    'placeholder' => '(11) 99999-9999',
                    'required' => true
                ]) ?>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <?php
                $stateOptions = [];
                foreach ($states as $state) {
                    $stateOptions[$state['id']] = $state['name'];
                }
                ?>

                <?= render_component('select', [
                    'id' => 'state_id',
                    'label' => 'Estado',
                    'name' => 'state_id',
                    'options' => $stateOptions,
                    'selected' => $contact['state_id'] ?? null,
                    'placeholder' => 'Selecione',
                    'required' => true
                ]) ?>
            </div>

            <div class="flex-1">
                <?php
                $cityOptions = [];
                foreach ($cities as $city) {
                    $cityOptions[$city['id']] = $city['name'];
                }
                ?>

                <?= render_component('select', [
                    'id' => 'city_id',
                    'label' => 'Cidade',
                    'name' => 'city_id',
                    'options' => $cityOptions,
                    'selected' => $contact['city_id'] ?? null,
                    'placeholder' => 'Selecione',
                    'required' => true
                ]) ?>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <?= render_component('button', [
                'variant' => 'primary',
                'size' => 'md',
                'icon' => 'save',
                'label' => 'Atualizar',
                'type' => 'submit'
            ]) ?>

            <?= render_component('button', [
                'variant' => 'secondary',
                'size' => 'md',
                'icon' => 'x',
                'label' => 'Cancelar',
                'onclick' => "window.location.href='/contacts'"
            ]) ?>
        </div>
    </form>
</div>