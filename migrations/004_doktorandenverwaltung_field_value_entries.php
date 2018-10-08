<?php

class DoktorandenverwaltungFieldValueEntries extends Migration
{
    public function description()
    {
        return 'Add some entries to field_values-table for Doktorandenverwaltung';
    }

    public function up()
    {
        $db = DBManager::get();

        $query = "INSERT INTO `doktorandenverwaltung_field_values` (`field_id`, `his_id`, `lid`, `uniquename`, `defaulttext`, `astat_bund`) 
            VALUES 
            ('geschlecht', '1', NULL, NULL, 'männlich', NULL), 
            ('geschlecht', '2', NULL, NULL, 'weiblich', NULL),
            ('ja_nein', '1', NULL, NULL, 'Ja', '1'),
            ('ja_nein', '0', NULL, NULL, 'Nein', '0'),
            ('art_dissertation', '128', NULL, NULL, 'Monografie', '1'),
            ('art_dissertation', '129', NULL, NULL, 'publikationsbasierte/kumulative Dissertation', '2'),
            ('art_dissertation', '99', NULL, NULL, 'undefiniert (von Migration)', NULL),
            ('semester', '1', NULL, NULL, 'Sommersemester', NULL),
            ('semester', '2', NULL, NULL, 'Wintersemester', NULL),
            ('status_abschlusspruefung', '0', NULL, NULL, 'wurde noch nicht abgelegt', '0'),
            ('status_abschlusspruefung', '1', NULL, NULL, 'wurde abgelegt und bestanden', '1'),
            ('status_abschlusspruefung', '18', NULL, '18', 'Nicht angeboten / Keine Angabe', NULL)
            ";
        
        $db->exec($query);
        
    }

    public function down()
    {
    }
}
