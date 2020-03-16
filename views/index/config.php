<form class="default" action="<?= $controller->url_for('index/config') ?>" method="post">
    <?= CSRFProtection::tokenTag() ?>
    <fieldset>
        <legend>Berichtsjahr konfigurieren</legend>
        <label>
            Berichtsjahr
            <select name="year" class="size-s">
                <? for($i = date('Y') - 2; $i <= date('Y') + 2; $i++) : ?>
                <option value="<?= $i ?>" <?= $i == $year ? 'selected="selected"' : '' ?>>
                    <?= $i ?>
                </option>
                <? endfor ?>
            </select>
        </label>
    </fieldset>
    <footer>
        <?= Studip\Button::create(_('Übernehmen')) ?>
    </footer>
</form>
