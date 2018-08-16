<html>

<body>
    <div>
<h1></h1>

<table id='doktoranden-entries' class="default sortable">
    <thead>
		<tr>
            <th style='width:10%' >
               Aktionen
        </th>
            <?php foreach($fields as $field): ?>
                <th <? if ($sortby === 'completion') printf('class="sort%s"', strtolower($sortFlag)) ?>>
                        <a href="<?= URLHelper::getLink('', array('sortby' => $field['id'], 'sortFlag' => strtolower($sortFlag))) ?>" title="<?= $field['title'] ?>">
                            <?= $field['title'] ?>
                        </a>
                </th>   
            <?php endforeach ?>
        <!--<th>Courseware besucht?</th>-->
        </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
    <tr>
        <td><a href='<?=$this->controller->url_for('index/edit/' . $entry['id']) ?>' title='Eintrag editieren' data-dialog="size=auto;reload-on-close"><?=Icon::create('edit')?></a><br/></td>

        <?php foreach($fields as $field): ?>
            
            <?php if ($field->value_key) : ?>
                <td><?= $field->getValueTextByKey($entry[$field->id]) ?></td>
            <?php else: ?>
                <td><?= $entry[$field->id] ?></td>
            <?php endif ?>

        <?php endforeach ?>

    </tr>
    <?php endforeach ?>
    </tbody>
</table>
</div>


</body>


<script type="text/javascript">

    
$(function(){
  $('#doktoranden-entries').tablesorter(); 
});


</script>



