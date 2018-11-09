<?php

class DoktorandenverwaltungAddFieldsTable extends Migration
{
    public function description()
    {
        return 'Add DB table for Doktorandenverwaltung Fields';
    }

    public function up()
    {
        $db = DBManager::get();

        //add db-table
        $db->exec("CREATE TABLE IF NOT EXISTS `doktorandenverwaltung_fields` (
            `id` varchar(32) NOT NULL,
            `title` varchar(250) NOT NULL,
            `default` varchar(150) NOT NULL,
            `overview_position` int(11) NULL,
            `group` varchar(32) NOT NULL,
            `group_position` int(11) NULL ,
            `fill` varchar(11) NOT NULL,
            `value_id` varchar(32) NULL,
            `value_key` varchar(32) NULL,
            `export_name` varchar(250) NULL,
            PRIMARY KEY (id)
        ) ");
        
        $query = "INSERT INTO `doktorandenverwaltung_fields` (`id`, `title`, `default`, `overview_position`, `group`, `group_position`, `fill`, `value_id`, `value_key`, `export_name`) 
           VALUES 
           ('berichtseinheitid', 'BerichtseinheitID', '5300000', NULL, '', NULL, 'auto', NULL, NULL, 'berichtseinheitid'),
           ('berichtsland', 'Berichtsland', '03', NULL, NULL, NULL, 'auto', 'bundeslaender', 'his_id', 'ef001'),
           ('berichtsjahr', 'Berichtsjahr', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef002'),
           ('hisinone_person_id', 'PersonID', NULL, NULL, NULL, NULL, 'ext', NULL, NULL, '0'),
           ('hochschule_prom', 'Hochschule der Promotion', '0530', NULL, NULL, NULL, 'auto', 'university', 'lid', 'ef003'),
           ('paginiernummer', 'Paginiernummer', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef004'),
           ('id', 'Paginiernummer_int', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'Paginiernummer_int'),
           ('geschlecht', 'Geschlecht', NULL, NULL, 'doktorandendaten', '1', 'manual_req', NULL, 'his_id', 'ef005'),
           ('geburtsdatum_tag', 'Geburtsdatum - Tag', NULL, NULL, NULL, NULL, 'manual_req', NULL, NULL, 'ef006u1'),
           ('geburtsdatum_monat', 'Geburtsdatum - Monat', NULL, NULL, NULL, NULL, 'manual_req', NULL, NULL, 'ef006u2'),
           ('geburtsdatum_jahr', 'Geburtsdatum - Jahr', NULL, NULL, NULL, NULL, 'manual_req', NULL, NULL, 'ef006u3'),
           ('vorname', 'Vorname', NULL, '2', 'doktorandendaten', '6', 'manual_req', NULL, NULL, '0'),
           ('nachname', 'Nachname', NULL, '1', 'doktorandendaten', '5', 'manual_req', NULL, NULL, '0'),
           ('name_short', 'Name', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef007'),
           ('staatsangehoerigkeit', 'Staatsangehörigkeit', NULL, NULL, 'doktorandendaten', '8', 'manual_req', 'country', 'his_id', 'ef008'),
           ('weitere_staatsangehoerigkeit', 'Weitere Staatsangehörigkeit', NULL, NULL, 'doktorandendaten', '9', 'manual_opt', 'country', 'his_id', 'ef009'),
           ('art_promotion', 'Art der Promotion', NULL, NULL, 'promotionsdaten', '2', 'manual_req', NULL, 'his_id', 'ef010'),
           ('promotionsfach', 'Promotionsfach', NULL, '4', 'promotionsdaten', '3', 'manual_req', NULL, 'lid', 'ef011'),
           ('art_reg_prom', 'Art der Registrierung', NULL, NULL, 'promotionsdaten', '4', 'manual_req', 'candidate_status', 'his_id', 'ef012'),
           ('promotionsbeginn_monat', 'Promotionsbeginn - Monat', NULL, NULL, 'promotionsdaten', '5', 'manual_req', 'monat', 'id', 'ef013u1'),
           ('promotionsbeginn_jahr', 'Promotionsbeginn - Jahr', NULL, NULL, 'promotionsdaten', '6', 'manual_req', NULL, NULL, 'ef013u2'),
           ('promotionsende_monat', 'Ende der Promotion - Monat', NULL, NULL, 'promotionsdaten', '7', 'manual_opt', 'monat', 'id', 'ef014u1'),
           ('promotionsende_jahr', 'Ende der Promotion - Jahr', NULL, NULL, 'promotionsdaten', '8', 'manual_opt', NULL, NULL, 'ef014u2'),
           ('matrikelnummer', 'Matrikelnummer', NULL, '5', 'promotionsdaten', '9', 'manual_opt', NULL, NULL, '0'),
           ('immatrikulation', 'Immatrikulation', NULL, NULL, 'promotionsdaten', '10', 'manual_req', 'ja_nein', 'his_id', 'ef015'),
           ('struk_promotionsprogramm', 'Teilnahme an einem strukturierenden Promotionsprogramm', NULL, NULL, 'promotionsdaten', '11', 'manual_req', 'structured_program', 'lid', 'ef016'),
           ('employment', 'Beschäftigungsverhältnis an der Hochschule der Promotion', NULL, NULL, 'promotionsdaten', '12', 'manual_req', 'ja_nein', 'his_id', 'ef017'),
           ('art_dissertation', 'Art der Dissertation', NULL, NULL, 'promotionsdaten', '13', 'manual_req', NULL, 'uniquename', 'ef018'),
           ('hochschule_erst', 'Hochschule', NULL, NULL, 'ersteinschreibung', '1', 'manual_req', 'university', 'lid', 'ef019'),
           ('staat_hochschule_erst', 'Bei einer Hochschule ausserhalb Deutschlands, der Staat der Hochschule', NULL, NULL, 'ersteinschreibung', '2', 'manual_opt', 'country', 'his_id', 'ef020'),
           ('semester', 'Semester', NULL, NULL, 'ersteinschreibung', '3', 'manual_req', 'semester', 'his_id', 'ef021'),
           ('jahr', 'Jahr', NULL, NULL, 'ersteinschreibung', '4', 'manual_req', NULL, NULL, 'ef022'),
           ('status_abschlusspruefung', 'Status der Abschlussprüfung', NULL, NULL, 'abschlusspruefung', '1', 'manual_req', NULL, 'his_id', 'ef023'),
           ('hochschule_abschlusspruefung', 'Hochschule der Abschlussprüfung', NULL, NULL, 'abschlusspruefung', '2', 'manual_req', 'university', 'lid', 'ef024'),
           ('staat_abschlusspruefung', 'Staat', NULL, NULL, 'abschlusspruefung', '3', 'manual_opt', 'country', 'his_id', 'ef025'),
           ('studienform_abschluss', 'Studienform', NULL, NULL, 'abschlusspruefung', '4', 'manual_req', 'studienform', 'his_id', '0'),
           ('abschlusspruefung_abschluss', 'Abschluss', NULL, NULL, 'abschlusspruefung', '5', 'manual_req', 'degree', 'lid', '0'),
           ('ef026', 'Art der Prüfung', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef026'),
           ('studienfach_abschluss', 'Erstes Studienfach', NULL, NULL, 'abschlusspruefung', '6', 'manual_req', 'promotionsfach', 'lid', '0'),
           ('ef027', 'Erstes Studienfach', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef027'),
           ('monat_pruefung', 'Monat des Prüfungsabschlusses', NULL, NULL, 'abschlusspruefung', '7', 'manual_req', 'monat', 'id', 'ef028'),
           ('jahr_pruefung', 'Jahr', NULL, NULL, 'abschlusspruefung', '8', 'manual_req', NULL, NULL, 'ef029'),
           ('note', 'Gesamtnote', NULL, NULL, 'abschlusspruefung', '9', 'manual_req', NULL, NULL, 'ef030'),
           ('hzb_jahr', 'Jahr', NULL, NULL, 'hzb', '1', 'manual_req', NULL, NULL, 'ef031'),
           ('hzb_art', 'Art der HZB', NULL, NULL, 'hzb', '2', 'manual_req', 'entrance', 'his_id', 'ef032'),
           ('hzb_land', 'Bundesland', NULL, NULL, NULL, NULL, 'auto', 'bundeslaender', 'his_id', '0'),
           ('hzb_kreis', 'Kreis (bei Erwerb in Deutschland)', NULL, NULL, 'hzb', '4', 'manual_opt', 'landkreise', 'his_id', '0'),
           ('hzb_staat', 'Staat (bei Erwerb im Ausland)', NULL, NULL, 'hzb', '5', 'manual_opt', 'country', 'his_id', '0'),
           ('ef033u1', 'Bundesland', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef033u1'),
           ('ef033u2', 'Kreis (bei Erwerb in Deutschland) bzw. Staat (bei Erwerb im Ausland)', NULL, NULL, NULL, NULL, 'auto', NULL, NULL, 'ef033u2'),
           ('ef034', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, NULL, '1'),
           ('ef035', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, NULL, '1'),
           ('ef036', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, NULL, '1'),
           ('ef037', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, NULL, '1'),
           ('ef038', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, NULL, '1'),
           ('geburtstag', 'Geburtsdatum', NULL, '3', 'doktorandendaten', '2', 'manual_req', NULL, NULL, '0'),
           ('betreuer', 'Zuständiger Betreuer', NULL, NULL, 'promotionsdaten', '14', 'manual_opt', NULL, NULL, '0'),
           ('email', 'EMail', NULL, '4', 'doktorandendaten', '7', 'manual_opt', NULL, NULL, '0'),
           ('berichtet', 'Als abgeschlossen oder abgebrochen berichtet berichtet (Jahr)', NULL, NULL, 'admin', '1', 'manual_opt', NULL, NULL, '0')
           ";
        
        $db->exec($query);
        
        
        

        SimpleORMap::expireTableScheme();
    }

    public function down()
    {
        $db = DBManager::get();

        $db->exec("DROP TABLE doktorandenverwaltung_fields");

        SimpleORMap::expireTableScheme();
    }
}
