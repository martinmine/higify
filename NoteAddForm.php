<?php
require_once('NoteModel.class.php');
require_once('NoteAddFormView.class.php');

$view = new NoteAddFormView();

 /**
  * Demo for creating a note from a web from.
  * Generating a document with input for creating a note.
  *
  * @uses NoteModel
  * @uses NoteAddFormView
  *
  * @author Thomas mellemseter
  * @version 1.0
  */

if (count($_POST) < 1)
{
  echo $view->generateDocument('NoteAddForm.php', 'post');  
}
else
{
  /** 
   *  Controller have to retrieve ownerID and ownerName from user
   *  to send to this function, both to fill database and for displaying 
   *  the username (owner) for the note.
   */
  $note = $view->createNoteFromInput($_POST, 1, 'tomknot');
  $model = new NoteModel($note);
  if ($model->addNote($note) > 0)
  {
    header('Location: Notedrawer.php');     //  Redirecting
  }
  
}

?>