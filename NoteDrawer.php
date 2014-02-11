<?php
require_once('NoteModel.class.php');
require_once('NoteListView.class.php');
/**
 * Demo displaying desired notes.
 *
 * @author  Thomas Mellemseter
 * @version 1.0
 * @uses NoteModel
 */
 
$model = new NoteModel();
$noteList = $model->getNoteList();
$view = new NoteListView();

// For NoteType alternatives see NoteType.class.php
echo $view->generateDocument($noteList, NoteType::ALL, 'NoteWall.css');

?>