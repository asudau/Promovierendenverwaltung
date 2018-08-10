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
            `values` int(11) NULL,
            `export` boolean NULL,
            PRIMARY KEY (id)
        ) ");
        
        $query = "INSERT INTO `doktorandenverwaltung_fields` (`id`, `title`, `default`, `overview_position`, `group`, `group_position`, `fill`, `values`, `export`) 
           VALUES 
           ('berichtseinheitid', 'BerichtseinheitID', '5300000', NULL, '', NULL, 'auto', NULL, '1'),
           ('ef001', 'Berichtsland', '003', NULL, NULL, NULL, 'auto', NULL, '1'),
           ('ef002', 'Berichtsjahr', NULL, NULL, NULL, NULL, 'auto', NULL, '1'),
           ('hisinone_person_id', 'HISinOne Person.ID', NULL, NULL, NULL, NULL, 'ext', NULL, '0'),
           ('ef003', 'Hochschule der Promotion', '0530', NULL, 'promotionsdaten', '1', 'auto', NULL, '1'),
           ('ef004', 'Paginiernummer', NULL, NULL, NULL, NULL, 'auto', NULL, '1'),
           ('id', 'Paginiernummer_int', NULL, NULL, NULL, NULL, 'auto', NULL, '1'),
           ('ef005', 'Geschlecht', NULL, '1', 'doktorandendaten', '1', 'manual_req', NULL, '1'),
           ('ef006u1', 'Geburtsdatum - Tag', NULL, NULL, 'doktorandendaten', '2', 'manual_req', NULL, '1'),
           ('ef006u2', 'Geburtsdatum - Monat', NULL, NULL, 'doktorandendaten', '3', 'manual_req', NULL, '1'),
           ('ef006u3', 'Geburtsdatum - Jahr', NULL, NULL, 'doktorandendaten', '4', 'manual_req', NULL, '1'),
           ('vorname', 'Vorname', NULL, '2', 'doktorandendaten', '5', 'manual_req', NULL, '0'),
           ('nachname', 'Nachname', NULL, '3', 'doktorandendaten', '6', 'manual_req', NULL, '0'),
           ('ef007', 'Name', NULL, NULL, 'doktorandendaten', '7', 'manual_req', NULL, '1'),
           ('ef008', 'Staatsangehörigkeit', NULL, NULL, 'doktorandendaten', '8', 'manual_req', NULL, '1'),
           ('ef009', 'weitere Staatsangehörigkeit', NULL, NULL, 'doktorandendaten', '9', 'manual_opt', NULL, '1'),
           ('art_promotion', 'Art der Promotion HIOID', NULL, NULL, 'promotionsdaten', '2', 'manual_req', NULL, '0'),
           ('ef010', 'Art der Promotion', NULL, NULL, 'promotionsdaten', '2', 'manual_req', NULL, '1'),
           ('promotionsfach', 'Art der Promotion HIOID', NULL, NULL, 'promotionsdaten', '2', 'manual_req', NULL, '0'),
           ('ef011', 'Promotionsfach', NULL, '5', 'promotionsdaten', '3', 'manual_req', NULL, '1'),
           ('ef012', 'Art der Registrierung als Promovierender', NULL, NULL, 'promotionsdaten', '4', 'manual_req', NULL, '1'),
           ('ef013u1', 'Promotionsbeginn - Monat', NULL, NULL, 'promotionsdaten', '5', 'manual_req', NULL, '1'),
           ('ef013u2', 'Promotionsbeginn - Jahr', NULL, NULL, 'promotionsdaten', '6', 'manual_req', NULL, '1'),
           ('ef014u1', 'Ende der Promotion - Monat', NULL, NULL, 'promotionsdaten', '7', 'manual_opt', NULL, '1'),
           ('ef014u2', 'Ende der Promotion - Jahr', NULL, NULL, 'promotionsdaten', '8', 'manual_opt', NULL, '1'),
           ('matrikelnummer', 'Matrikelnummer', NULL, NULL, 'promotionsdaten', '9', 'manual_opt', NULL, '0'),
           ('ef015', 'Immatrikulation', NULL, NULL, 'promotionsdaten', '10', 'manual_req', NULL, '1'),
           ('ef016', 'Teilnahme an einem strukturierenden Promotionsprogramm', NULL, NULL, 'promotionsdaten', '11', 'manual_req', NULL, '1'),
           ('ef017', 'Beschäftigungsverhältnis an der Hochschule der Promotion', NULL, NULL, 'promotionsdaten', '12', 'manual_req', NULL, '1'),
           ('ef018', 'Art der Dissertation', NULL, NULL, 'promotionsdaten', '13', 'manual_req', NULL, '1'),
           ('ef019', 'Hochschule (Ersteinschreibung)', NULL, NULL, 'ersteinschreibung', '1', 'manual_req', NULL, '1'),
           ('ef020', 'Bei Ersteinschreibung an einer Hochschule ausserhalb Deutschlands, der Staat der Hochschule', NULL, NULL, 'ersteinschreibung', '2', 'manual_req', NULL, '1'),
           ('ef021', 'Semester', NULL, NULL, 'ersteinschreibung', '3', 'manual_req', NULL, '1'),
           ('ef022', 'Jahr', NULL, NULL, 'ersteinschreibung', '4', 'manual_req', NULL, '1'),
           ('ef023', 'Zur Promotion berechtigende Abschlussprüfung', NULL, NULL, 'abschlusspruefung', '1', 'manual_req', NULL, '1'),
           ('ef024', 'Hochschule', NULL, NULL, 'abschlusspruefung', '2', 'manual_req', NULL, '1'),
           ('ef025', 'Wenn Hochschule der zur Promotion berechtigenden, vorangegangenen bestandenen Abschlussprüfung außerhalb Deutschlands, der Staat der Hochschule', NULL, NULL, 'abschlusspruefung', '3', 'manual_req', NULL, '1'),
           ('studienform', 'Studienform', NULL, NULL, 'abschlusspruefung', '5', 'manual_req', NULL, '0'),
           ('abschluss', 'Abschlussprüfung', NULL, NULL, 'abschlusspruefung', '6', 'manual_req', NULL, '0'),
           ('abschluss_studienfach', 'Studienfach Abschluss', NULL, NULL, 'abschlusspruefung', '7', 'manual_req', NULL, '0'),
           ('ef026', 'Art der Prüfung', NULL, NULL, 'abschlusspruefung', '8', 'manual_req', NULL, '1'),
           ('ef027', '1. Studienfach', NULL, NULL, 'abschlusspruefung', '9', 'manual_req', NULL, '1'),
           ('ef028', 'Monat des Prüfungsabschlusses', NULL, NULL, 'abschlusspruefung', '10', 'manual_req', NULL, '1'),
           ('ef029', 'Jahr des Prüfungsabschlusses', NULL, NULL, 'abschlusspruefung', '11', 'manual_req', NULL, '1'),
           ('ef030', 'Gesamtnote', NULL, NULL, 'abschlusspruefung', '12', 'manual_req', NULL, '1'),
           ('ef031', 'Jahr des Erwerbs einer HZB', NULL, NULL, 'ersteinschreibung', '5', 'manual_req', NULL, '1'),
           ('ef032', 'Art der ersten HZB', NULL, NULL, 'ersteinschreibung', '6', 'manual_req', NULL, '1'),
           ('ef033u1', 'Art der ersten HZB - Bundesland, bzw.', NULL, NULL, 'ersteinschreibung', '7', 'manual_req', NULL, '1'),
           ('ef033u2', 'Art der ersten HZB - Kreis (bei Erwerb in Deutschland) bzw. Staat (bei Erwerb im Ausland)', NULL, NULL, 'ersteinschreibung', '8', 'manual_req', NULL, '1'),
           ('ef034', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, '1'),
           ('ef035', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, '1'),
           ('ef036', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, '1'),
           ('ef037', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, '1'),
           ('ef038', 'frei für landesinterne Angaben', NULL, NULL, NULL, NULL, 'manual_opt', NULL, '1'),
           ('geburtstag', 'Geburtstag', NULL, '4', NULL, NULL, 'generated', NULL, '0')
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
