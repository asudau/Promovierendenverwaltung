<?php
class IndexController extends StudipController
{
    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
    }

    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        PageLayout::setTitle(_("Promovierendenverwaltung - Übersicht"));

        PageLayout::addStylesheet($this->plugin->getPluginURL().'/assets/style.css');

        if (Request::get('berichtsjahrSelector')) {
            $_SESSION['Doktorandenverwaltung_vars']['berichtsjahr'] = Request::get('berichtsjahrSelector');
        } else {
            if (!isset($_SESSION['Doktorandenverwaltung_vars']['berichtsjahr'])) {
                $_SESSION['Doktorandenverwaltung_vars']['berichtsjahr'] = date('Y');
            }
        }

        $stmt = DBManager::get()->prepare("SELECT roleid FROM roles WHERE rolename = ?");
        $stmt->execute(array('Doktorandenverwaltung'));
        $this->role_id = $stmt->fetch()[0];

        $sidebar = Sidebar::Get();

        $navcreate = new ActionsWidget();
        $navcreate->addLink(
            _('Neuer Eintrag'),
                              $this->url_for('index/new'),
                              Icon::create('seminar+add', 'clickable')
        )->asDialog('size=big');

        if (RolePersistence::isAssignedRole(
            $GLOBALS['user']->user_id,
            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE
        )) {
            $navcreate->addLink(
                _('Statistikexport'),
                $this->url_for('index/export'),
                Icon::create('seminar+add', 'clickable')
            );
            $navcreate->addLink(
                _('Vollständiger Export'),
                $this->url_for('index/full_export'),
                Icon::create('seminar+add', 'clickable')
            );
        }

        $navcreate->addLink(
            _('Export der aktuellen Einträge'),
            $this->url_for('index/export_user'),
            Icon::create('seminar+add', 'clickable')
        );

        $sidebar->addWidget($navcreate);
    }

    public function index_action()
    {
        Navigation::activateItem('tools/doktorandenverwaltung/index');

        $search_query = array();
        if ($_SESSION['Doktorandenverwaltung_vars']['berichtsjahr'] != '1') {

            $query = DoktorandenHelper::getFilterQuery($_SESSION['Doktorandenverwaltung_vars']['berichtsjahr']);

            /*
                AND `berichtet` IS NULL
                OR `berichtet` = 0 )';
                */
        } else {
            $query = 'true';
        }

        $this->faecher = $this->getFaecherIDsForUser();
        $this->fields = DoktorandenFields::getHeaderFields();

        if ($this->faecher) {
            $this->entries = DoktorandenEntry::findBySQL("(" . $query . ") AND promotionsfach IN ('" . implode($this->faecher, '\' ,\'') . "') ORDER BY nachname ASC");
        } else {
            $this->entries = DoktorandenEntry::findBySQL($query . ' ORDER BY nachname ASC');
        }
        //$this->number_required_fields = sizeof(DoktorandenFields::getRequiredFields());

        $sidebar = Sidebar::get();

        //promotionsende_monat promotionsende_jahr

        $widget = new SelectWidget('Berichtsjahr', PluginEngine::GetURL('doktorandenverwaltung/index/'), 'berichtsjahrSelector');
        $option = new SelectElement('1', _('Alle Einträge'));

        if ('1' ==  $_SESSION['Doktorandenverwaltung_vars']['berichtsjahr']) {
            $option->setActive();
        }

        $widget->addElement($option);

        $option = new SelectElement('-1', _('neu Immatrikulierte'));

        if ('-1' ==  $_SESSION['Doktorandenverwaltung_vars']['berichtsjahr']) {
            $option->setActive();
        }

        $widget->addElement($option);

        // get configured report year
        $year = Config::get()->DOKTORANDEN_REPORT_YEAR;

        //for ($i = (int)date('Y'); $i >= (int)date('Y') -1; $i--) {
        //
        $option = new SelectElement($year, _('Berichtsjahr '). $year);

        if (($year == $_SESSION['Doktorandenverwaltung_vars']['berichtsjahr'])
            || ('0' == $_SESSION['Doktorandenverwaltung_vars']['berichtsjahr'])) {
            $option->setActive();
        }

        $widget->addElement($option);
        //}

        $sidebar->insertWidget($widget, 'pdb_actions');
    }

    public function showactive_action()
    {
        $this->render_nothing();
    }


    public function edit_action($entry_id)
    {
        $this->entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        if (RolePersistence::isAssignedRole(
            $GLOBALS['user']->user_id,
            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE
        )) {
            $this->groupedFields = DoktorandenEntry::getGroupedFieldsForAdmin();
        } else {
            $this->groupedFields = DoktorandenEntry::getGroupedFields();
        }

        $this->lock_fields = [];

        if ($this->entry->hisinone_person_id) {
            $this->lock_fields = \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_LOCKED_FIELDS;
        };
    }

    public function faq_action()
    {
        Navigation::activateItem('tools/doktorandenverwaltung/faq');
    }

    public function config_action()
    {
        if (RolePersistence::isAssignedRole($GLOBALS['user']->user_id,
                \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE)) {

            Navigation::activateItem('tools/doktorandenverwaltung/config');
            if (Request::int('year')) {
                CSRFProtection::verifyUnsafeRequest();
                Config::get()->store('DOKTORANDEN_REPORT_YEAR', Request::int('year'));
            }

            $this->year = Config::get()->DOKTORANDEN_REPORT_YEAR;
        } else {
            $this->redirect('index');
        }
    }

    public function new_action()
    {
        $this->entry = new DoktorandenEntry();
        //$this->entry->store();
        //$this->new = true;
        if (RolePersistence::isAssignedRole(
            $GLOBALS['user']->user_id,
            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE
        )) {
            $this->groupedFields = DoktorandenEntry::getGroupedFieldsForAdmin();
        } else {
            $this->groupedFields = DoktorandenEntry::getGroupedFields();
        }
    }

    public function delete_action($entry_id)
    {
        if (RolePersistence::isAssignedRole(
            $GLOBALS['user']->user_id,
            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE
        )) {
            $entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
            if ($entry) {
                $message = MessageBox::success(_('Eintrag wurde gelöscht: ' . $entry->vorname . ' ' . $entry->nachname));
                $entry->delete();
            } else {
                $message = MessageBox::success(_('Kein Eintrag mit dieser ID vorhanden'));
            }
            PageLayout::postMessage($message);
        }
        $this->redirect('index');
    }

    public function save_action($entry_id)
    {
        if ($entry_id) {
            $entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        } else {
            $entry = new DoktorandenEntry();
        }

        $groupedFields = DoktorandenEntry::getGroupedFields();
        $lockedFields = \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_LOCKED_FIELDS;

        if ($entry) {
            foreach ($groupedFields as $group) {
                foreach ($group['entries'] as $field_entry) {
                    $field = $field_entry->id;

                    // disable editing of locked fields
                    if ($entry->hisinone_person_id && in_array($field, $lockedFields) !== false) {
                        continue;
                    }
                    //if(Request::option($field)){
                    if (strpos($field, 'jahr') !== false) {
                        if (Request::get($field)) {
                            $input = Request::int($field);
                            if ($input>1000 && $input<2100) {
                                $entry->$field = Request::int($field);
                            } else {
                                $message = MessageBox::error(_('Falsches Datumsformat: ' . $field_entry->title . ' wurde nicht übernommen'));
                                PageLayout::postMessage($message);
                            }
                        }
                    }
                    if ($field == 'geburtstag') {
                        if (Request::get($field)) {
                            if ($this->validateDate(Request::get($field))) {
                                $entry->$field = htmlReady(Request::get($field));
                            } else {
                                $message = MessageBox::error(_('Falsches Datumsformat: ' . $field_entry->title . ' wurde nicht übernommen'));
                                PageLayout::postMessage($message);
                            }
                        }
                    } else {
                        $entry->$field = Request::get($field);
                    }
                    //}
                }
            }
            //$entry->store();

            //anzahl required fields aktualisieren
            $filled = 0;
            $req_fields = $entry->requiredFields();
            foreach ($req_fields as $field_id) {
                if ($entry->isValueSet($field_id)) {
                    $filled ++;
                }
            }
            $entry->complete_progress = $filled;
            $entry->number_required_fields = sizeof($req_fields);

            if ($entry->store() !== false) {
                $messagetext = 'Die Änderungen wurden übernommen.';
                if ($entry->complete_progress < $entry->number_required_fields) {
                    $number_missing_fields = $entry->number_required_fields - $entry->complete_progress;
                    $messagetext .= ' Für diesen Eintrag fehlen noch ' . $number_missing_fields . ' Angaben';
                }
                $message = MessageBox::success($messagetext);
                PageLayout::postMessage($message);
            }
        } else {
            $message = MessageBox::success(_('Kein Eintrag mit dieser ID vorhanden'));
            PageLayout::postMessage($message);
        }

        //$this->response->add_header('X-Dialog-Close', '1');
        //$this->render_nothing();
        $this->redirect('index');
    }

    //Bericht für 2018 erstellen
    public function export_action()
    {
        if (RolePersistence::isAssignedRole(
            $GLOBALS['user']->user_id,
            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE
        )) {
            $query = DoktorandenHelper::getFilterQuery($_SESSION['Doktorandenverwaltung_vars']['berichtsjahr']);

            $doktoranden_entries = DoktorandenEntry::findBySQL($query);

            $export_fields = DoktorandenFields::getExportFieldsArray();

            $header = [];
            $export = [];

            $header[] = 'ID';

            foreach ($export_fields as $field) {
                $header[] = $field->export_name;
            }

            ob_end_clean();

            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; ' . encode_header_parameter('filename', 'statistik_promovierendendaten.csv'));
            flush();

            $output = fopen('php://output', 'rw');
            fputs($output, "\xEF\xBB\xBF");

            fputcsv($output, $header, ';', '"');

            $i = 0;
            foreach ($doktoranden_entries as $entry) {
                fputcsv($output, self::handleSingleRow($entry, $export_fields, $i), ';', '"');
                fflush($output);
                flush();
                $i++;
            }

            fclose($output);
            die;
        }
    }

    public function full_export_action()
    {
        if (RolePersistence::isAssignedRole(
            $GLOBALS['user']->user_id,
            \Doktorandenverwaltung\DOKTORANDENVERWALTUNG_ADMIN_ROLE
        )) {
            $doktoranden_entries = DoktorandenEntry::findBySQL('true');

            $export_fields = DoktorandenFields::getFullExportFieldsArray();

            $header = [];
            $export = [];

            $header[] = 'ID';

            foreach ($export_fields as $field) {
                $header[] = $field->id;
                if ($field->export_name) {
                    $header[] = $field->export_name;
                }
            }

            ob_end_clean();

            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; ' . encode_header_parameter('filename', 'bericht_promovierendendaten.csv'));
            flush();

            $output = fopen('php://output', 'rw');
            fputs($output, "\xEF\xBB\xBF");

            fputcsv($output, $header, ';', '"');

            foreach ($doktoranden_entries as $entry) {
                fputcsv($output, self::handleFullSingleRow($entry, $export_fields), ';', '"');
                fflush($output);
                flush();
            }

            fclose($output);
            die;

            $this->render_nothing();
        }
    }


    public function export_user_action()
    {
        $query = DoktorandenHelper::getFilterQuery($_SESSION['Doktorandenverwaltung_vars']['berichtsjahr']);

        $this->faecher = $this->getFaecherIDsForUser();

        if ($this->faecher) {
            $doktoranden_entries = DoktorandenEntry::findBySQL("(" . $query . ") AND promotionsfach IN ('" . implode($this->faecher, '\' ,\'') . "')");
        } else {
            $doktoranden_entries = DoktorandenEntry::findBySQL($query);
        }

        $grouped_fields = DoktorandenEntry::getGroupedFields();

        $header = [];
        $export = [];

        $header[] = 'ID';

        foreach ($grouped_fields as $group) {
            foreach ($group['entries'] as $field) {
                $header[] = $field->title;
            }
        }

        ob_end_clean();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; ' . encode_header_parameter('filename', 'promovierendendaten.csv'));
        flush();

        $output = fopen('php://output', 'rw');
        fputs($output, "\xEF\xBB\xBF");

        fputcsv($output, $header, ';', '"');

        foreach ($doktoranden_entries as $entry) {
            fputcsv($output, self::handleUserSingleRow($entry, $grouped_fields), ';', '"');
            fflush($output);
            flush();
        }

        fclose($output);
        die;

        $this->render_nothing();
    }

    public static function handleSingleRow($entry, $fields, $number)
    {
        $rowData = [];
        $rowData[] = $entry->id;

        foreach ($fields as $field) {
            $field_id = $field->id;
            if ($field_id == 'paginiernummer') {
                $rowData[] = str_pad($number, 6, '0', STR_PAD_LEFT);
            } elseif ($field_id == 'promotionsende_monat') {
                if (($entry->art_reg_prom == '3' || $entry->art_reg_prom == '2') && !$entry->$field_id) {
                    $rowData[] = '12';
                } else {
                    $rowData[] = $entry->$field_id;
                }
            } elseif ($field_id == 'promotionsende_jahr') {
                if (($entry->art_reg_prom == '3' || $entry->art_reg_prom == '2') && !$entry->$field_id) {
                    $rowData[] =  '2018';
                } else {
                    $rowData[] = $entry->$field_id;
                }
            } else {
                $astat = $field->getValueAstatByKey($entry->$field_id);
                //get related astat_bund val of $entry->$field
                if ($astat) {
                    if ($field_id == 'staat_hochschule_erst') {
                        $rowData[] = $astat == '000' ? '' : $astat;
                    } else {
                        $rowData[] = $astat;
                    }
                } elseif ($entry->$field_id != 'NULL') {
                    $rowData[] = $entry->$field_id;
                } else {
                    $rowData[] = '';
                }
            }
        }

        return $rowData;
    }

    public static function handleFullSingleRow($entry, $fields)
    {
        $rowData = [];
        $rowData[] = $entry->id;;

        foreach ($fields as $field) {
            $field_id = $field->id;
            //intern db-value
            $rowData[] = $entry->$field_id;
            //if exportfield: get related astat_bund val of $entry->$field
            if ($field->export_name) {
                if ($field->getValueAstatByKey($entry->$field_id)) {
                    $rowData[] = $field->getValueAstatByKey($entry->$field_id);
                } elseif ($entry->$field_id != 'NULL') {
                    $rowData[] = $entry->$field_id;
                } else {
                    $rowData[] = '';
                }
            }
        }

        return $rowData;
    }

    public static function handleUserSingleRow($entry, $grouped_fields)
    {
        $rowData = [];
        $rowData[] = $entry->id;

        foreach ($grouped_fields as $group) {
            foreach ($group['entries'] as $field) {
                $field_id = $field->id;
                //intern db-value
                if ($field->getValueTextByKey($entry->$field_id)) {
                    $rowData[] = $field->getValueTextByKey($entry->$field_id);
                } elseif ($entry->$field_id != 'NULL') {
                    $rowData[] = $entry->$field_id;
                } else {
                    $rowData[] = '';
                }
            }
        }

        return $rowData;
    }

    private function getFaecherIDsForUser()
    {
        //zugehörige Fächer für aktuellen User

        $this->inst_id = RolePersistence::getAssignedRoleInstitutes($GLOBALS['user']->user_id, $this->role_id);
        if ($this->inst_id[1]) {
            $stmt = DBManager::get()->prepare("SELECT fach_id FROM mvv_fach_inst WHERE Institut_id IN (?)");
            $stmt->execute(array($this->inst_id));
            $faecher = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $faecher_array = array();
            $field = DoktorandenFields::find('promotionsfach');
            foreach ($faecher as $fach) {
                $faecher_array[] = $field->getValueLIDByUniquename($fach['fach_id']);
            }
            if (sizeof($faecher_array) >0) {
                return $faecher_array;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        $earliest_birthday = DateTime::createFromFormat($format, '1910-01-01');
        $latest_birthday = new DateTime(date($format)); //today
        if (!$d || ($d->format($format) != $date) || ($d < $earliest_birthday) || ($d > $latest_birthday)) {
            return false;
        } else {
            return true;
        }
    }


    // customized #url_for for plugins
    public function url_for($to = '')
    {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join('/', $args));
    }
}
