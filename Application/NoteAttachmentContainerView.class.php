<?php
require_once('Template/WebPageElement.class.php');
require_once('Template/Template.class.php');
require_once('Note/NoteController.class.php');
require_once('NoteAttachmentListView.class.php');

class NoteAttachmentContainerView extends WebPageElement
{
    private $attachments;
    
    public function __construct($noteID)
    {
        $this->attachments = NoteController::requestAttachments($noteID);
    }
    
    public function generateHTML()
    {
        if (count($this->attachments) > 0)
        {
            $tpl = new Template();
            $tpl->appendTemplate('NoteAttachmentContainer');
            $tpl->setValue('ATTACHMENTS', new NoteAttachmentListView($this->attachments));
            $tpl->display();
        }
    }
}
?>