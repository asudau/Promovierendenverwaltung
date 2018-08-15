<?php

/**
 * @author  <asudau@uos.de>
 *
 * @property int        $chdate
 */

class DoktorandenEntry extends \SimpleORMap
{
    private static $groups = array(
        'promotionsdaten' => 'Daten zur Promotion',
        'doktorandendaten'=> 'Doktorandendaten',
        'ersteinschreibung'=> 'Daten zur Ersteinschreibung & HZB',
        'abschlusspruefung'=> 'Daten zur Promotion berechtigenden Abschlussprï¿½fung');
    
    private static $fields_metadata = array('berichtseinheitid' => array('title' => 'BerichtseinheitID', 'fill' => 'auto'),
            'ef001' => array('title' => 'Berichtsland', 'fill' => 'auto'),
            'ef002' => array('title' => 'Berichtsjahr', 'fill' => 'auto'),
            'hisinone_person_id' => array('title' => 'HISinOne Person.ID', 'fill' => 'ext'),
            'ef003' => array('title' => 'Hochschule der Promotion', 'fill' => 'auto'),
            'ef004' => array('title' => 'Paginiernummer', 'fill' => 'auto'),
            'ef005' => array('title' => 'Geschlecht', 'fill' => 'manual_req'),
            'ef006u1' => array('title' => 'Geburtsdatum - Tag', 'fill' => 'manual_req'),
            'ef006u2' => array('title' => 'Geburtsdatum - Monat', 'fill' => 'manual_req'),
            'ef006u3' => array('title' => 'Geburtsdatum - Jahr', 'fill' => 'manual_req'),
            'vorname' => array('title' => 'Vorname', 'fill' => 'manual_req'),
            'nachname' => array('title' => 'Nachname', 'fill' => 'manual_req'),
            'ef007' => array('title' => 'Name', 'fill' => 'manual_req'),
            'ef008' => array('title' => 'Staatsangehï¿½rigkeit', 'fill' => 'manual_req'),
            'ef009' => array('title' => 'weitere Staatsangehï¿½rigkeit', 'fill' => 'manual_opt'),
            'ef010' => array('title' => 'Art der Promotion', 'fill' => 'manual_req'),
            'ef011' => array('title' => 'Promotionsfach', 'fill' => 'manual_req'), 
            'ef012' => array('title' => 'Art der Registrierung als Promovierender', 'fill' => 'manual_req'),
            'ef013u1' => array('title' => 'Promotionsbeginn - Monat', 'fill' => 'manual_req'),
            'ef013u2' => array('title' => 'Promotionsbeginn - Jahr', 'fill' => 'manual_req'),
            'ef014u1' => array('title' => 'Ende der Promotion - Monat', 'fill' => 'manual_req'),
            'ef014u2' => array('title' => 'Ende der Promotion - Jahr', 'fill' => 'manual_req'),
            'matrikelnummer' => array('title' => 'Matrikelnummer'),
            'ef015' => array('title' => 'Immatrikulation', '0' => 'Nein', '1' => 'Ja'),
            'ef016' => array('title' => 'Teilnahme an einem strukturierenden Promotionsprogramm', '0' => 'Nein', '1' => 'Ja'),
            'ef017' => array('title' => 'Beschï¿½ftigungsverhï¿½ltnis an der Hochschule der Promotion', '0' => 'Nein', '1' => 'Ja'),
            'ef018' => array('title' => 'Art der Dissertation', '1' => 'Monografie', '2' => 'publikationsbasierte/kumulative Dissertation'),
            'ef019' => array('title' => 'Hochschule (Ersteinschreibung)'),
            'ef020' => array('title' => 'Bei Ersteinschreibung an einer Hochschule ausserhalb Deutschlands, der Staat der Hochschule'),
            'ef021' => array('title' => 'Semester', '1' => 'Sommersemester', '2' => 'Wintersemester'),
            'ef022' => array('title' => 'Jahr'),
            'ef023' => array('title' => 'Zur Promotion berechtigende Abschlussprï¿½fung', '0' => 'wurde noch nicht abgelegt', '1' => 'wurde abgelegt und bestanden') ,
            'ef024' => array('title' => 'Hochschule'),
            'ef025' => array('title' => 'Wenn Hochschule der zur Promotion berechtigenden, vorangegangenen bestandenen Abschlussprï¿½fung auï¿½erhalb Deutschlands, der Staat der Hochschule'),
            'ef026' => array('title' => 'Art der Prï¿½fung', '11' => 'Diplom', '13' => 'Master of Arts (M.A.)', '17' => 'Master of Science (M.Sc.)', '02' => 'Magister', '18' => 'Diplom-Lehrer', '08' => 'Staatsexamen/1. Staatsprï¿½fung'),
            'ef027' => array('title' => '1. Studienfach'),
            'ef028' => array('title' => 'Monat des Prï¿½fungsabschlusses'),
            'ef029' => array('title' => 'Jahr des Prï¿½fungsabschlusses'),
            'ef030' => array('title' => 'Gesamtnote'),
            'ef031' => array('title' => 'Jahr des Erwerbs einer HZB'),
            'ef032' => array('title' => 'Art der ersten HZB'),
            'ef033u1' => array('title' => 'Art der ersten HZB - Bundesland, bzw.'),
            'ef033u2' => array('title' => 'Art der ersten HZB - Kreis (bei Erwerb in Deutschland) bzw. Staat (bei Erwerb im Ausland)'),
            'ef034' => array('title' => 'frei fï¿½r landesinterne Angaben'),
            'ef035' => array('title' => 'frei fï¿½r landesinterne Angaben'),
            'ef036' => array('title' => 'frei fï¿½r landesinterne Angaben'),
            'ef037' => array('title' => 'frei fï¿½r landesinterne Angaben'),
            'ef038' => array('title' => 'frei fï¿½r landesinterne Angaben')
        );
    
    private static $fields_overview = array(
            'ef005',
            'nachname',
            'vorname',
            'geburtstag',
            'ef011', 
            'matrikelnummer'
        );
    
    private static $values = array('ef011' => array(
        '148' => 'Sozialwissenschaften', 
        '8' => 'Anglistik / Englisch',
        '48' => 'Elektrotechnik',
        '691' => 'Kosmetologie', 
        '67' => 'Germanistik / Deutsch' ,
        '132' => 'Psychologie',
        '86' => 'Katholische Theologie',
        '26' => 'Biologie',
        '150' => 'Spanisch',
        '113' => 'Musikerziehung',
        '59' => 'Franzï¿½sisch',
        '68' => 'Geschichte',
        '50' => 'Geographie / Erdkunde',
        '48' => 'Elektrotechnik',
        '245' => 'Sachunterricht',
        '188' => 'Literaturwissenschaft',
        '127' => 'Philosophie',
        '693' => 'Gesundheitswissenschaften',
        '234' => 'Pflegewissenschaften',
        '135' => 'Rechtswissenschaften',
        '53' => 'Evangelische Theologie',
        '140' => 'Umweltsysteme und Ressourcenmanagement',
        '83' => 'Islamische Theologie',
        '137' => 'Romanistik / 2 Sprachen',
        '79' => 'Informatik',
        '184' => 'Accounting & Economics',
        '32' => 'Chemie',
        '729' => 'Cognitive Science',
        '767' => 'Advanced Materials /Biologie',
        '105' => 'Mathematik',
        '128' => 'Physik',
        '91' => 'Kunst/Kunstpï¿½dagogik',
        '92' =>  'Kunstgeschichte',
        '114' => 'Bachelor-2-Fï¿½cher Musikwissenschaft',
        '116' => 'Textiles Gestalten',
        '129' => 'Politikwissenschaft /Politologie',
        '149' => 'Soziologie',
        '171' => 'Geoinformatik',
        '175' => 'Diplom(U)Volkswirtschaft',
        '21' => 'Kein AbschComputerlinguistik',
        '30' => 'Internationale Migration und Interkulturelle Beziehungen',
        '52' => 'Erziehungswissenschaft /Pï¿½dagogik',
        '809' => 'Politik:Demokratisches Regieren u. Zivilgesellschaft',
        '95' => 'Latein',
        '98' => 'Sport / Sportwissenschaft',
       
        ),
        
        'ef005' => array(
            '1' => 'männlich', '2' => 'weiblich'
        ),
        
        'ef008' => array(
             '000' => 'Deutschland',
        ),
        
        'ef010' => array(
             '01' => 'Promotion an Hochschulen mit Promotionsrecht (einschl. Kooperation mit anderer Universitïät in Deutschland)',
        ),
        
        'ef012' => array(
             '1' => 'Erstregistrierung', '2' => 'Neuregistrierung'
        )
    );
    
    protected static function configure($config = array())
    {
        $config['db_table'] = 'doktorandenverwaltung';
        
        $config['additional_fields']['geburtstag']['get'] = function ($item) {
            return date('d.m.Y', mktime(0, 0, 0, $item->ef006u1, $item->ef006u2, $item->ef006u3));
        };
        $config['additional_fields']['geburtstag_time']['get'] = function ($item) {
            return mktime(0, 0, 0, $item->ef006u1, $item->ef006u2, $item->ef006u3);
        };
        $config['additional_fields']['berichtseinheitid']['get'] = function ($item) {
            return '05300000';
        };
        $config['additional_fields']['ef001']['get'] = function ($item) {
            return '03';
        };
        $config['additional_fields']['ef002']['get'] = function ($item) {
            return date('Y', $entry->mkdate);
        };
        $config['additional_fields']['ef003']['get'] = function ($item) {
            return '0530';
        };
        $config['additional_fields']['ef010']['get'] = function ($item) {
            if($item['art_promotion']){
                $field = DoktorandenFields::find('art_promotion');
                return $field->getValueAstatByKey($item['art_promotion']);
            } else return NULL;
        };
        $config['additional_fields']['ef011']['get'] = function ($item) {
            if($item['promotionsfach']){
                $field = DoktorandenFields::find('promotionsfach');
                return $field->getValueAstatByKey($item['promotionsfach']);
            } else return NULL;
        };
        $config['additional_fields']['ef026']['get'] = function ($item) {
            if($item['studienform'] && $item['abschluss']){
                $field = DoktorandenFields::find('studienform');
                $studienform = $field->getValueAstatByKey($item['studienform']);
                $field = DoktorandenFields::find('abschluss');
                $abschluss = $field->getValueAstatByKey($item['abschluss']);
                return $studienform . $abschluss;
            } else return NULL;
        };
        $config['additional_fields']['ef027']['get'] = function ($item) {
            if($item['abschluss_studienfach']){
                $field = DoktorandenFields::find('abschluss_studienfach');
                $astat = $field->getValueAstatByKey($item['abschluss_studienfach']);
                return substr($astat,1);
            } else return NULL;
        };

        parent::configure($config);
    }
    
    public static function getHeaderFields() {
         
        return DoktorandenEntry::$fields_overview;
    }
    
    public static function getFieldsMetadata() {
         
        return DoktorandenEntry::$fields_metadata;
    }
    
    public static function getGroupedFields() {
        $group_array = array();
        foreach(self::$groups as $group => $title){
            $group_array[$group]['entries'] = DoktorandenFields::findBySQL("`group` LIKE :group", array(':group' => $group));
            $group_array[$group]['title'] = $title;
        }
        //return DoktorandenEntry::$groupedFields;
        return $group_array;
    }
    
    public static function getValueMap() {
         
        return DoktorandenEntry::$values;
    }
}
