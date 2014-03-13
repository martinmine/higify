<?php
require_once('Template/WebPageElement.class.php');
require_once('Template/Template.class.php');

class NoteAttachmentListView extends WebPageElement
{
    private $attachments;
    
    public function __construct($attachments)
    {
        $this->attachments = $attachments;
    }
    
    public function generateHTML()
    {
        foreach ($this->attachments as $id => $name)
        {
            $tpl = new Template();
            $tpl->appendTemplate('NoteAttachmentElement');
            $tpl->setValue('ID', $id);
            $tpl->setValue('FILE_NAME', $name);
            $tpl->display();
        }
    }
}
?>