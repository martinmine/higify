            <div class="pageElement">
				<div>
					<?php 
						if(isset($ORIGINAL)) 
						{echo $ORIGINAL . "<div class=" . "'" . "pageTitle" . "'" . ">Reply</div>";}
						else {echo "<div class=" . "'" . "pageTitle" . "'" . ">Create a new note</div>";}
					?>
				<script src="/xing-wysihtml5/parser_rules/advanced.js"></script>
				<script src="/xing-wysihtml5/dist/wysihtml5-0.3.0.min.js"></script>
                <form action="create_note.php<?php if (isset($PARENT_ID)) echo '?parent=' . $PARENT_ID; ?>" method = "POST">
                <div class="createNoteWrapper">
                    <div>Category:</div>
                    <div>
                        <select class="categoryList" name="category">
						<?php
						foreach ($OPTIONS as $desc)
						{
							$selected = ($desc == $SELECTED ? 'selected' : '');
							echo "<option value='" . $desc . "'" . $selected . ">" . $desc . "</option>";
						}
						?>
                        </select>
                    </div>

                    <div>Note:</div>
                    <div>
                        <textarea style="resize:none" class="noteContent" name="content"></textarea>
                    </div>
                    <div class="createNoteFooter">
                        <div class="privateFlag">
                            <input type="checkbox" class="privateNoteCheckbox" name="notePrivate" />Private note
                        </div>
                        <div class="formButtons">
                            <input type="submit" class="submitButton" name="submit" value="Save">
                        </div>
                    </div>
                </div>
			</form>
            </div>