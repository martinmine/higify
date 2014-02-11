<?php
/**
 * This view creates an HTML form to add notes into the database.
 * 
 * @author  Thomas Mellemseter
 * @version 1.0
 */
 class NoteAddFormView
 {
    private $contentAttribute = 'content';      //  @var string $contentAtt of the form's input
    private $isPublicAttribute = 'isPublic';    //  @var string $isPublicAttribute.
    
    public function createNoteFromInput($inputArray, $ownerID, $ownerName)
    { 
      $content = null;
      $isPublic = 0;
      
      if ($inputArray[$this->contentAttribute] != "")
        $content = $inputArray[$this->contentAttribute];
        
      if (isset($inputArray[$this->isPublicAttribute]))
        $isPublic = 1;      
         
      return new Note(-1, $ownerID, $content, $isPublic, date('Y-m-d'), $ownerName);  
    }
    
    public function generateDocument($target, $method)
    {
      $res = "<!DOCTYPE html>\n"
           . "<html>\n"
           . $this->generateHead('Create new Note')
           . $this->generateBody('New Note', $target, $method)
           . '</html>';
      echo $res;
    }
    
    public function generateHead($title)
    {
      $res = "<head>\n"           
           . "<meta charset=utf-8>\n"
           . '<link rel="stylesheet" type="text/css" href="newnote.css">'
           . '<title>' . $title . "</title>\n"
           . "</head>\n";
      return $res;
    }
    
    /**
     * Generates the body with a form for creating a note.
     *
     * @return html body with div id="Container"
     */
    
    public function generateBody($title, $target, $method)
    {
      $res = "<body>\n"
           . "<div id=\"Container\">"
           . '<h1>' . $title . "</h1>\n"
           . "<div id=\"Form\">\n"
           . "<form action='$target' method='$method'>\n"
           . "<textarea style='resize:none' name='content' rows='10' cols='80'></textarea></br>\n"
           . "<label for='isPublic'>Make Public:</label><input type='checkbox' name='{$this->isPublicAttribute}' value='1'/></br>\n"
           . "<input type='submit' value='Publish'>"
           . "</form>\n"
           . "</div>\n"
           . "</body>\n";
            
      return $res;
    }
 }


?>