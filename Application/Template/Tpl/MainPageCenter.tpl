        <div class="pageSideContainer">

            <div class="pageElement">
                <div class="pageTitle">Create a new note</div>
                <?php echo $CREATE_NOTE_CATEGORIES; ?>
            </div>
			
            <div class="pageElement" id="notes">
                <div class="pageTitle">
                    Recent notes
                </div>
                <?php echo $NOTES; ?>
            </div>
			
			<?php if (isset($REPORTED)) echo $REPORTED; ?>
        </div>
