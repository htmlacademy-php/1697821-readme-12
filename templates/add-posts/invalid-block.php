<div class="form__invalid-block">
    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
    <ul class="form__invalid-list">
        <? foreach ($errors as $key => $value):
            if (!empty($value)):?>
                <li class="form__invalid-item"><?= $key ?>. <?= $value ?>.</li>
            <? endif;
        endforeach; ?>
    </ul>
</div>