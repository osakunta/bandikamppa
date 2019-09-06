<?php if (!empty($errors)): ?>
<ul class="errors">
    <?php foreach ($errors as $error): ?>
    <li><?=$error?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if (!empty($messages)): ?>
<ul class="messages">
    <?php foreach ($messages as $message): ?>
    <li><?=$message?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
