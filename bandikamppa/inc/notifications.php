<?php if (!empty($errors)): ?>
<br />
<div class="ui negative message">
    <?php foreach ($errors as $error): ?>
    <p><?=$error?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($messages)): ?>
<br />
<div class="ui info message">
    <?php foreach ($messages as $message): ?>
    <p><?=$message?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>
