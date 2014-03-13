<?php

require_once('Template/Template.class.php');
require_once('Template/WebPageElement.class.php');
require_once('ReportedNoteListView.class.php');

class ReportedNoteView extends WebPageElement
{
    private $listView;
    
    public function __construct()
    {
        $this->listView = new ReportedNoteListView();
    }
    
    public function generateHTML()
    {
        $tpl = new Template();
        $tpl->appendTemplate('ReportedNotes');
        $tpl->setValue('NOTES', $this->listView);
        $tpl->display();
    }
}
?>