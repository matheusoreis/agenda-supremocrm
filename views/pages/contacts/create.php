<?php

/** @var array $states */
/** @var array $errors */
/** @var array $old */

require_once __DIR__ . '/../../../src/Helpers/helpers.php';
?>

<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <?= render_component('icon', ['name' => 'user-plus', 'class' => 'w-5 h-5']) ?>
            Novo Contato
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

    <form action="/contacts/store" method="POST" class="card p-6 space-y-4 w-full">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <?= render_component('input', [
                    'id' => 'name',
                    'label' => 'Nome',
                    'name' => 'name',
                    'value' => $old['name'] ?? '',
                    'required' => true
                ]) ?>
            </div>

            <div class="flex-1">
                <?= render_component('input', [
                    'id' => 'phone',
                    'label' => 'Telefone',
                    'name' => 'phone',
                    'value' => $old['phone'] ?? '',
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
                    'selected' => $old['state_id'] ?? null,
                    'placeholder' => 'Selecione',
                    'required' => true
                ]) ?>
            </div>

            <div class="flex-1">
                <?= render_component('select', [
                    'id' => 'city_id',
                    'label' => 'Cidade',
                    'name' => 'city_id',
                    'options' => [],
                    'selected' => $old['city_id'] ?? null,
                    'placeholder' => 'Selecione um estado',
                    'required' => true
                ]) ?>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <?= render_component('button', [
                'variant' => 'primary',
                'size' => 'md',
                'icon' => 'save',
                'label' => 'Salvar',
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stateSelect = document.getElementById('state_id');
        var citySelect = document.getElementById('city_id');

        if (!stateSelect || !citySelect) return;

        function loadCities(stateId) {
            citySelect.innerHTML = '<option value="">Carregando...</option>';

            fetch('/contacts/cities?state_id=' + encodeURIComponent(stateId))
                .then(function(res) {
                    return res.json();
                })
                .then(function(cities) {
                    var options = '<option value="">Selecione uma cidade</option>';
                    cities.forEach(function(city) {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });
                    citySelect.innerHTML = options;
                })
                .catch(function(err) {
                    console.error('Erro ao carregar cidades:', err);
                    citySelect.innerHTML = '<option value="">Erro ao carregar</option>';
                });
        }

        if (stateSelect.value) {
            loadCities(stateSelect.value);
        }

        stateSelect.addEventListener('change', function() {
            var stateId = this.value;
            if (!stateId) {
                citySelect.innerHTML = '<option value="">Selecione um estado</option>';
                return;
            }
            loadCities(stateId);
        });
    });
</script>