            <div class="pageElement">
				<div>
					<?php 
						if(isset($ORIGINAL)) 
						{echo $ORIGINAL . "<div class=" . "'" . "pageTitle" . "'" . ">Reply</div>";}
						else {echo "<div class=" . "'" . "pageTitle" . "'" . ">Create a new note</div>";}
					?>
					
					<script>
						var editor = new wysihtml5.Editor("wysihtml5-textarea", { // id of textarea element
						  toolbar:      "wysihtml5-toolbar", // id of toolbar element
						  parserRules:  wysihtml5ParserRules // defined in parser rules set 
						});
						alert("test");
					</script>
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
					<div id="wysihtml5-toolbar" style="display: none;">
					  <a data-wysihtml5-command="bold">bold</a>
					  <a data-wysihtml5-command="italic">italic</a>
					  
					  <!-- Some wysihtml5 commands require extra parameters -->
					  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">red</a>
					  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">green</a>
					  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">blue</a>
					  
					  <!-- Some wysihtml5 commands like 'createLink' require extra paramaters specified by the user (eg. href) -->
					  <a data-wysihtml5-command="createLink">insert link</a>
					  <div data-wysihtml5-dialog="createLink" style="display: none;">
						<label>
						  Link:
						  <input data-wysihtml5-dialog-field="href" value="http://" class="text">
						</label>
						<a data-wysihtml5-dialog-action="save">OK</a> <a data-wysihtml5-dialog-action="cancel">Cancel</a>
					  </div>
					</div>
                    <div>						
                        <textarea id="wysihtml5-textarea" placeholder="Enter your text ..." autofocus></textarea>
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