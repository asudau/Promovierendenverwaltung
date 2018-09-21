<?php
class IndexController extends StudipController {

    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
        
    }

    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        PageLayout::setTitle(_("Doktorandenverwaltung - Übersicht"));
        
        PageLayout::addStylesheet($this->plugin->getPluginURL().'/assets/style.css');
        //PageLayout::addScript($this->plugin->getPluginURL().'/assets/jquery.tablesorter.js');
        PageLayout::addSqueezePackage('tablesorter');
        
        $sidebar = Sidebar::Get();

        $navcreate = new ActionsWidget();
        $navcreate->addLink("Übersicht", 'index' );
        $navcreate->addLink("FAQ", 'index/faq' );
        $navcreate->addLink(_('Neuer Eintrag'),
                              $this->url_for('index/new'),
                              Icon::create('seminar+add', 'clickable'))->asDialog('size=big');
        $navcreate->addLink(_('Exportieren'),
                              $this->url_for('index/export'),
                              Icon::create('seminar+add', 'clickable'));
         $navcreate->addLink(_('Vollständiger Export'),
                              $this->url_for('index/full_export'),
                              Icon::create('seminar+add', 'clickable'));
        $sidebar->addWidget($navcreate);
    }

    public function index_action()
    {
        Navigation::activateItem('doktorandenverwaltung/index');
        
        if($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] != '0' && isset($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])){
            //$search_query['abschlussjahr'] = ' `ef014u2` = ' . $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'];
        }
        if(Request::option('abschlussjahrSelector')){
            $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = Request::option('abschlussjahrSelector');
            $search_query['abschlussjahr'] = ' `ef014u2` = ' . Request::option('abschlussjahrSelector');
        } else $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = 0;
        
        $query = '';
        if($search_query){ 
            foreach($search_query as $query_part) {
                $query .= $query_part;
            }
        }
        if ($query == '') $query = 'true';
        
        $this->fields = DoktorandenFields::getHeaderFields();
        $this->entries = DoktorandenEntry::findBySQL($query); 
        $this->number_required_fields = sizeof(DoktorandenFields::getRequiredFields());
        
        $sidebar = Sidebar::get();
        
        
        $this->abschlussjahre = array('2016', '2017');
        $widget = new SelectWidget('Ende der Promotion (Jahr)', PluginEngine::GetURL('doktorandenverwaltung/index'), 'abschlussjahrSelector');
        $option = new SelectElement('0', _('Alle Abschlussjahre anzeigen'));
        if (('' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) || ('0' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])) {
            $option->setActive();
        }
        $widget->addElement($option);
        foreach ($this->abschlussjahre as $aj) {
            $option = new SelectElement($aj, $aj);
            if ($aj == $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) {
                $option->setActive();
            }
            $widget->addElement($option);
        }
        $sidebar->insertWidget($widget, 'pdb_actions');
        
                
    }
    
    public function admin_action()
    {
        Navigation::activateItem('doktorandenverwaltung/index_admin');
        if($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] != '0' && isset($_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])){
            //$search_query['abschlussjahr'] = ' `ef014u2` = ' . $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'];
        }
        if(Request::option('abschlussjahrSelector')){
            $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = Request::option('abschlussjahrSelector');
            $search_query['abschlussjahr'] = ' `ef014u2` = ' . Request::option('abschlussjahrSelector');
        } else $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'] = 0;
        
        $query = '';
        foreach($search_query as $query_part) {
            $query .= $query_part;
        }
        if ($query == '') $query = 'true';
        
        $field = DoktorandenEntry::findOneBySQL('true');
        $this->fields = $field->getFields();
        $this->additionalfields = $field->getAdditionalFields();
        $this->entries = DoktorandenEntry::findBySQL($query); 
        
        $sidebar = Sidebar::get();
        
        
        $this->abschlussjahre = array('2016', '2017');
        $widget = new SelectWidget('Ende der Promotion (Jahr)', PluginEngine::GetURL('doktorandenverwaltung/index'), 'abschlussjahrSelector');
        $option = new SelectElement('0', _('Alle Abschlussjahre anzeigen'));
        if (('' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) || ('0' ==  $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr'])) {
            $option->setActive();
        }
        $widget->addElement($option);
        foreach ($this->abschlussjahre as $aj) {
            $option = new SelectElement($aj, $aj);
            if ($aj == $_SESSION['Doktorandenverwaltung_vars']['abschlussjahr']) {
                $option->setActive();
            }
            $widget->addElement($option);
        }
        $sidebar->insertWidget($widget, 'pdb_actions');
                
    }
    
    public function edit_action($entry_id)
    {
        $this->entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        $this->groupedFields = DoktorandenEntry::getGroupedFields();

    }
    
    public function faq_action()
    {

    }

    public function new_action()
    {
        $this->entry = new DoktorandenEntry();
        //$this->entry->store();
        //$this->new = true;
        
        $this->groupedFields = DoktorandenEntry::getGroupedFields();
        $this->render_action('edit');
    }

    public function save_action($entry_id){

        if ($entry_id){
            $entry = DoktorandenEntry::findOneBySQL('id = ' . $entry_id);
        } else {
            $entry = new DoktorandenEntry();
            $entry->id = $entry->getNextId();
        }
        $groupedFields = DoktorandenEntry::getGroupedFields();
        
        if($entry){
            foreach ($groupedFields as $group){
                foreach ($group['entries'] as $field_entry){
                    $field = $field_entry->id;
                    
                    if(Request::get($field)){
                        if (strpos($field, 'jahr') !== false){
                            $input = (int)htmlReady(Request::get($field));
                            if($input>1000 && $input<2100){
                                $entry->$field = htmlReady(Request::get($field));
                            } else {
                                $message = MessageBox::error(_('Falsches Datumsformat: ' . $field_entry->title . ' wurde nicht übernommen'));
                                PageLayout::postMessage($message);
                            }
                        } else {
                            $entry->$field = htmlReady(Request::get($field));
                        }
                    }
                }
            }
            
            //anzahl required fields aktualisieren
            $filled = 0;
            $req_fields = DoktorandenFields::getRequiredFields();
            foreach($req_fields as $field){
                $field_id = $field->id;
                if ($entry->$field_id){
                    $filled ++;
                } 
            }
            $entry->complete_progress = $filled;
            
            if ($entry->store() !== false) {
                $entry->setup();
                $message = MessageBox::success(_('Die Änderungen wurden Übernommen.'));
                PageLayout::postMessage($message);
            } else if ($entry->id != $entry->getNextId()){
                $entry->id = $entry->getNextId();
                $entry->store();
                $entry->setup();
            } 
                
        } else {

            $message = MessageBox::success(_('Kein Eintrag mit dieser ID vorhanden'));
            PageLayout::postMessage($message);
            
        }
        
       
        //$this->response->add_header('X-Dialog-Close', '1');
        //$this->render_nothing();
        $this->redirect('index');
          
    }
    
    public function export_action()
    {
        
        $doktoranden_entries = DoktorandenEntry::findBySQL('true');
        
        $export_fields = DoktorandenFields::getExportFieldsArray();
        
        $header = array();
        $export = array();
        
        foreach ($export_fields as $field){
            $header[] = $field->export_name;
        }
        
        $export[] = $header;
        
        foreach ($doktoranden_entries as $entry){
            $export[] = self::handleSingleRow($entry, $export_fields);
        }
        
        $this->render_csv($export, 'bericht_promovierendendaten.csv');
        
//      old version for excel        
//        if (!empty($doktoranden_entries)) {
//            $xls = new ExcelExport();
//
//            $xls->addRow(DoktorandenFields::getExportHeaderArray());
//
//            foreach ($doktoranden_entries as $entry) {
//                $xls->addRow(self::handleSingleRow($entry));
//            }
//            $xls->download('Export_'
//                    . date("d-m-y") . '.xls');
//        }
//        $this->render_nothing();
    }
    
    public function full_export_action(){
        $doktoranden_entries = DoktorandenEntry::findBySQL('true');
        
        $export_fields = DoktorandenFields::getFullExportFieldsArray();
        
        $header = array();
        $export = array();
        
        foreach ($export_fields as $field){
            $header[] = $field->id;
            if ($field->export_name){
                $header[] = $field->export_name;
            }
        }
        
        $export[] = $header;
        
        foreach ($doktoranden_entries as $entry){
            $export[] = self::handleFullSingleRow($entry, $export_fields);
        }
        
        $this->render_csv($export, 'bericht_promovierendendaten.csv');
    }
    
    static function handleSingleRow($entry, $fields)
    {
        $rowData = array();
        foreach($fields as $field){
            //get related astat_bund val of $entry->$field
            $field_id = $field->id;
            if ($field->getValueAstatByKey($entry->$field_id)){
                $rowData[] = $field->getValueAstatByKey($entry->$field_id);
            } else
            $rowData[] = $entry->$field_id;
        }

        return $rowData;
    }
    
    static function handleFullSingleRow($entry, $fields)
    {
        $rowData = array();
        foreach($fields as $field){
            
            $field_id = $field->id;
            //intern db-value
            $rowData[] = $entry->$field_id;
            //if exportfield: get related astat_bund val of $entry->$field
            if ($field->export_name){
                if ($field->getValueAstatByKey($entry->$field_id)){
                    $rowData[] = $field->getValueAstatByKey($entry->$field_id);
                } else
                $rowData[] = $entry->$field_id;
            }
        }

        return $rowData;
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
