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
            ('geschlecht', '1', NULL, '1', 'männlich', NULL), 
            ('geschlecht', '2', NULL, '2', 'weiblich', NULL),
            ('art_reg_prom', '1', NULL, '1', 'Erstregistrierung', NULL),
            ('art_reg_prom', '2', NULL, '2', 'Neuregistrierung', NULL),
            ('immatrikulation', '1', NULL, '1', 'Ja', NULL),
            ('immatrikulation', '0', NULL, '0', 'Nein', NULL),
            ('art_dissertation', '128', NULL, '1', 'Monografie', NULL),
            ('art_dissertation', '129', NULL, '2', 'publikationsbasierte/kumulative Dissertation', NULL),
            ('art_dissertation', '99', NULL, '0', 'undefiniert (von Migration)', NULL),
            ('semester', '1', NULL, 'SoSe', 'Sommersemester', NULL),
            ('semester', '2', NULL, 'WiSe', 'Wintersemester', NULL),
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
