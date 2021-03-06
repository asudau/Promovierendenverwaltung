<html>

<body>
    <div>
<h1><?= sizeof($entries) ?> Einträge <?= $inst_id[1] ? Institute::find($inst_id[1])->name : ''?> </h1>

<table id='doktoranden-entries' class="sortable-table default">
    <thead>
        <tr>
            <th data-sort="false" style='width:5%'></th>
            <?php foreach($fields as $field): ?>
                <?php if ($field->id == 'geburtstag' || $field->id == 'chdate') : ?>
                    <th data-sort="htmldata"><span><?= $field['title'] ?></span></th>
                <?php else: ?>
                    <th data-sort="text"><span><?= $field['title'] ?></span></th>
                <?php endif ?>
            <?php endforeach ?>
            <th data-sort="text" style='width:10%'>Status</th>
            <th data-sort="false" style='width:5%'></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
    <tr>

        <td>
            <a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>'
                title='Eintrag editieren (hisinone_person_id: <?= $entry['hisinone_person_id'] ?>)'
                data-dialog="size=big"
            >
                <?=Icon::create('edit')?>
            </a>

            <br/>
        </td>

        <?php foreach($fields as $field): ?>
            <?php if ($field->value_key) : ?>
                <td><?= $field->getValueTextByKey($entry[$field->id]) ?></td>
            <?php else: ?>
                <?php if ($field->id == 'geburtstag') : ?>
                    <td data-sort-value=<?= $entry['geburtstag_time']?>><?= htmlReady($entry[$field->id]) ?></td>
                 <?php elseif ($field->id == 'chdate') : ?>
                    <td data-sort-value=<?= $entry[$field->id]?>><?= date('d.m.Y', $entry[$field->id]) ?></td>
                <?php else: ?>
                    <td><?= htmlReady($entry[$field->id]) ?></td>
                <?php endif ?>
            <?php endif ?>

        <?php endforeach ?>

        <td title='Noch <?= $entry->numberRequiredFields()-$entry->completeProgress() ?> fehlende Einträge'>
            <?= round($entry->completeProgress()/$entry->numberRequiredFields(), 2)*100 ?>%
        </td>

         <?php if(RolePersistence::isAssignedRole($GLOBALS['user']->user_id,
                                                            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE)): ?>
             <td>
                 <a onclick="return confirm('Eintrag löschen?')" href='<?=$this->controller->url_for('index/delete/' . $entry['id']) ?>' title='Eintrag löschen' ><?=Icon::create('trash')?></a>
             </td>
         <?php endif ?>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>
</div>


</body>
