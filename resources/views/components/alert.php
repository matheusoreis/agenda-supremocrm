<?php if (isset($message) && $message): ?>
    <div class="alert alert-<?= $type ?? 'info' ?>">
        <?php if (isset($dismissible) && $dismissible): ?>
            <button class="alert-close" onclick="this.parentElement.remove()">×</button>
        <?php endif; ?>
        <?php if (isset($icon)): ?>
            <span class="alert-icon"><?= $icon ?></span>
        <?php endif; ?>
        <?= $message ?>
    </div>
<?php endif; ?>