<?php

/**
 * @author  <asudau@uos.de>
 *
 * @property int        $chdate
 */

class DoktorandenEntry extends \SimpleORMap
{
    private static $groups = array(
        'doktorandendaten'=> 'Persönliche Daten',
        'promotionsdaten' => 'Daten zur Promotion',
        'ersteinschreibung'=> 'Daten zur Ersteinschreibung',
        'abschlusspruefung'=> 'Daten zur Promotion berechtigenden Abschlussprüfung',
        'hzb' => 'Daten zur Hochschulzugangsberechtigung (HZB)'
        );
    
    protected static function configure($config = array())
    {
        $config['db_table'] = 'doktorandenverwaltung';
        
        $config['additional_fields']['geburtstag']['get'] = function ($item) {
        if (!$item->geburtsdatum_tag){
            return '';
        } else return date('d.m.Y', mktime(0, 0, 0, $item->geburtsdatum_monat, $item->geburtsdatum_tag, $item->geburtsdatum_jahr));
        };
        $config['additional_fields']['geburtstag']['set'] = function ($item, $field, $data) {
            $time = strtotime ($data);
            $item->geburtsdatum_tag = date("d", $time);
            $item->geburtsdatum_monat = date("m", $time);
            $item->geburtsdatum_jahr = date("Y", $time);
        };
        $config['additional_fields']['geburtstag_time']['get'] = function ($item) {
            return mktime(0, 0, 0, $item->geburtsdatum_monat, $item->geburtsdatum_tag, $item->geburtsdatum_jahr);
        };
        $config['additional_fields']['berichtseinheitid']['get'] = function ($item) {
            return '05300000';
        };
        $config['additional_fields']['berichtsland']['get'] = function ($item) {
            return '03';
        };
         $config['additional_fields']['paginiernummer']['get'] = function ($item) {
            return '1';
        };
        $config['additional_fields']['berichtsjahr']['get'] = function ($item) {
            return date('Y', time());
        };
        $config['additional_fields']['hochschule_prom']['get'] = function ($item) {
            return '0530';
        };
        $config['additional_fields']['name_short']['get'] = function ($item) {
            if (strlen($item->vorname) > 0){
                return self::clear_string($item->vorname);
            } else if (strlen($item->nachname) > 0){
                return self::clear_string($item->nachname);
            }
            return '';
        };
        $config['additional_fields']['ef026']['get'] = function ($item) {
            if($item['studienform_abschluss'] && $item['abschlusspruefung_abschluss']){
                $field = DoktorandenFields::find('studienform_abschluss');
                $studienform = $field->getValueAstatByKey($item['studienform_abschluss']);
                $field = DoktorandenFields::find('abschlusspruefung_abschluss');
                $abschluss = $field->getValueAstatByKey($item['abschlusspruefung_abschluss']);
                return $studienform . $abschluss;
            } else return NULL;
        };
        $config['additional_fields']['ef027']['get'] = function ($item) {
            if($item['studienfach_abschluss']){
                $field = DoktorandenFields::find('studienfach_abschluss');
                $astat = $field->getValueAstatByKey($item['studienfach_abschluss']);
                return substr($astat,1);
            } else return NULL;
        };
        
        $config['additional_fields']['ef033u2']['get'] = function ($item) {
            $field = DoktorandenFields::find('hzb_art');
            $hzb_art_astat = $field->getValueAstatByKey($item['hzb_art']);
            if($item['hzb_kreis']){
                $field = DoktorandenFields::find('hzb_kreis');
                $astat = $field->getValueAstatByKey($item['hzb_kreis']);
                return substr($astat, -3);
            } else if(in_array($hzb_art_astat, array('17', '39', '47', '59', '67', '79')) && $item['hzb_staat']){
                $field = DoktorandenFields::find('hzb_staat');
                $astat = $field->getValueAstatByKey($item['hzb_staat']);
                return $astat;
            } else return NULL;
        };
        
         $config['additional_fields']['hzb_land']['get'] = function ($item) {
             //ef032 = hzb_art
            $field = DoktorandenFields::find('hzb_art');
            $hzb_art_astat = $field->getValueAstatByKey($item['hzb_art']);
            if($item['hzb_kreis']){
                $field = DoktorandenFields::find('hzb_kreis');
                $astat = $field->getValueAstatByKey($item['hzb_kreis']);
                return substr($astat, 0, 2);
            } else if(in_array($hzb_art_astat, array('17', '39', '47', '59', '67', '79')) ){
                return '99'; 
            } else return NULL;
        };

        parent::configure($config);
    }
    
    //für neu erzeugte Einträge müssen einige Werte initialisiert werden
    public function setup(){
        //Paginierung ist ein String-Wert der aus der id erzeugt wird weil fortlaufend
//        $this->ef004 = str_pad($this->id, 6 ,'0', STR_PAD_LEFT);
        $this->store();
    }
    
    public function getFields() {
        return $this->db_fields;
    }
    
    public function getAdditionalFields() {
        return $this->additional_fields;
    }
    
    public static function getGroupedFields() {
        $group_array = array();
        foreach(self::$groups as $group => $title){
            $group_array[$group]['entries'] = DoktorandenFields::findBySQL("`group` LIKE :group ORDER BY `group_position` ASC", array(':group' => $group));
            $group_array[$group]['title'] = $title;
        }
        //return DoktorandenEntry::$groupedFields;
        return $group_array;
    }
    
    public function completeProgress(){
        if ($this->complete_progress > 0){
            return $this->complete_progress;
        } else {
            $filled = 0;
            $req_fields = DoktorandenFields::getRequiredFields();
            foreach($req_fields as $field){
                $field_id = $field->id;
                if ($this->$field_id != NULL){
                    $filled ++;
                } 
            }
            $this->complete_progress = $filled;
            $this->store();
        }
        return $this->complete_progress;
    }

    public function req($field_id){
        
        $ef032 = DoktorandenFields::find('hzb_art');
        $hzb_art_astat = $ef032->getValueAstatByKey($this->hzb_art);
       
        //sonderregelung für Ende der Promotion: falls beendet, abschlussjahr/Monat Pflichtfeld
        if ($field_id == 'promotionsende_monat' || $field_id == 'promotionsende_jahr'){
            if($this->art_reg_prom == '3' || $this->art_reg_prom == '2' ){
                return true;
            }
        //Abschluss(HZB) im Ausland: Staat Pflichtfeld
        }else if (in_array($hzb_art_astat, array('17', '39', '47', '59', '67', '79')) &&
                ($field_id == 'hzb_staat' ) ){
            return true;
        //Abschluss(HZB) im Inland: Staat ausgegraut, Bundesland und Kreis Pflichtfeld
        } else if (($field_id == 'hzb_land' || $field_id == 'hzb_kreis') && $hzb_art_astat ){
            return true;
        //Abschlusshochschule Auslandshochschulen, dann Staat Pflichtfeld    
        }else if ($this->hochschule_abschlusspruefung == '2' &&
                ($field_id == 'staat_abschlusspruefung' ) ){
            return true; 
        //Ersteinschreibung Auslandshochschulen, dann Staat Pflichtfeld 
        }else if ($this->hochschule_erst == '2' &&
                ($field_id == 'staat_hochschule_erst' ) ){
            return true; 
        //generelle Pflichtfelder
        }else  if (DoktorandenFields::find($field_id)->fill == 'manual_req'){
            if ($this->$field_id == NULL || strlen($this->$field_id) < 1){
                return true;
            }
        }
        return false;
    }
    
    public function disabled($field_id){
        //Abschluss (HZB) im Ausland: Staat Pflichtfeld, Bundesland und Kreis ausgegraut
        if (($field_id == 'hzb_land' || $field_id =='hzb_kreis') && $this->req('hzb_staat')){
            return true;
        //Abschluss (HZB) im Inland: Staat ausgegraut, Bundesland und Kreis Pflichtfeld
        } else if (($field_id == 'hzb_staat') && $this->req('hzb_land')){
            return true;
        //Abschlusshochschule keine Auslandshochschulen, -> Staat kein Pflichtfeld dann ausgegraut 
        } else if (($field_id == 'staat_abschlusspruefung' ) && !$this->req('staat_abschlusspruefung')){
            return true;
        //Ersteinschreibung keine Auslandshochschulen, -> Staat kein Pflichtfeld dann ausgegraut 
        } else if (($field_id == 'staat_hochschule_erst' ) && !$this->req('staat_hochschule_erst')){
            return true;
        }
        return false;
    }
    
    public function getDefaultOption($field_id){
        if($this->req($field_id)){
            return '-- bitte auswählen --';
        } if ($this->disabled($field_id)){
            return '-- nicht erforderlich --';
        } 
        return '-- ggf. auswählen --';
    }
    
    public function getNextId(){
        $max_id_entry = self::findOneBySQL('true ORDER BY id DESC');
        $next_id = $max_id_entry->id + 1;
        return $next_id;
    }
    
    private static function clear_string($str){
        $search = array("ä", "ö", "ü", "ß", "Ä", "Ö",
                "Ü", "-", "é", "á", "ú", "c", "â", "ê");
        $replace = array("ae", "oe", "ue", "ss", "Ae", "Oe",
                 "Ue", " ", "e", "a", "o", "c", "a", "e");
        $str = str_replace($search, $replace, $str);
        //$str = strtolower(preg_replace("/[^a-zA-Z0-9]+/", trim($how), $str));
        return substr($str, 0, 4);
    }
    
}
