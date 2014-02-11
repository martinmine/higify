<?php

/**
 * Enumerations on notes privacy status.
 * Used as parameter in generateDocument in 
 * NoteViewTest.class.php for displaying notes.
 *
 * @var const NONE show no notes
 * @var const ALL show all notes (both private and public notes)
 * @var const PUBLIC_ONLY show public notes only
 * @var const PRIVATE_ONLY show private notes only
 */

class NoteType {
  const NONE = 0;
  const ALL = 1;
  const PUBLIC_ONLY = 2;
  const PRIVATE_ONLY = 3;
}

?>