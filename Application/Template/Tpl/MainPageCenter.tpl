        <div class="pageSideContainer">

            <div class="pageElement">
                <a href="javascript:newNoteToggle()" id="newNoteButton">
					<div class="pageTitle" id="newNoteButton">Create a new note</div>
				</a>
				<div class="pageContent">
					<?php echo $CREATE_NOTE_CATEGORIES; ?>
				</div>
            </div>
			
            <div class="pageElement" id="notes">
                <div class="pageTitle">
                    Recent notes
                </div>
                <?php echo $NOTES; ?>
            </div>
			
			<?php if (isset($REPORTED)) echo $REPORTED; ?>
        </div>
