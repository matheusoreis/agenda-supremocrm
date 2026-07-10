<div class="empty-state">
    <h4><?= $title ?? 'Nenhum registro encontrado' ?></h4>

    <?php if (isset($description)): ?>
        <p><?= $description ?></p>
    <?php endif; ?>

    <?php if (isset($action)): ?>
        <div style="margin-top: 16px;">
            <?= $action ?>
        </div>
    <?php endif; ?>
</div>