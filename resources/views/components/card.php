<div class="card">
    <?php if (isset($title)): ?>
        <div class="card-header">
            <h3><?= $title ?></h3>
            <?php if (isset($action)): ?>
                <div class="card-action"><?= $action ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="card-body">
        <?= $slot ?? '' ?>
    </div>
</div>