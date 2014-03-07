            <div class="spacer"></div>
			<div class="pageElement">
				<div class="spacer"></div>
			<?php if (isset($PARENT_ID)) echo $ORIGINAL; ?>
                <form action="create_note.php<?php if (isset($PARENT_ID)) echo '?parent=' . $PARENT_ID; ?>" method = "POST" enctype="multipart/form-data">
                <div class="createNoteWrapper">
                    <div>		
						<div id="wysihtml5-editor-toolbar">
						  <div class="toolbar">
							<ul class="commands">
							  <li data-wysihtml5-command="bold" title="Make text bold (CTRL + B)" class="command"></li>
							  <li data-wysihtml5-command="italic" title="Make text italic (CTRL + I)" class="command"></li>
							  <li data-wysihtml5-command="insertUnorderedList" title="Insert an unordered list" class="command"></li>
							  <li data-wysihtml5-command="insertOrderedList" title="Insert an ordered list" class="command"></li>
							  <li data-wysihtml5-command="createLink" title="Insert a link" class="command"></li>
							  <li data-wysihtml5-command="insertImage" title="Insert an image" class="command"></li>
							  <li data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" title="Insert headline 1" class="command"></li>
							  <li data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" title="Insert headline 2" class="command"></li>
							  <li data-wysihtml5-command-group="foreColor" class="fore-color" title="Color the selected text" class="command">
								<ul>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="silver"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="gray"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="maroon"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="purple"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="olive"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="navy"></li>
								  <li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue"></li>
								</ul>
							  </li>
							  <li data-wysihtml5-command="insertSpeech" title="Insert speech" class="command"></li>
							  <li data-wysihtml5-action="change_view" title="Show HTML" class="action"></li>
							</ul>
						  </div>
						  <div data-wysihtml5-dialog="createLink" style="display: none;">
							<label>
							  Link:
							  <input data-wysihtml5-dialog-field="href" value="http://">
							</label>
							<a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
						  </div>

						  <div data-wysihtml5-dialog="insertImage" style="display: none;">
							<label>
							  Image:
							  <input data-wysihtml5-dialog-field="src" value="http://">
							</label>
							<a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
						  </div>
						</div>
	
						<section>
							<textarea id="wysihtml5-editor" spellcheck="false" wrap="off" name="content" autofocus placeholder="Enter something ...">
							</textarea>
						</section>
                    </div>
                    <div class="createNoteFooter">
                        <div class="privateFlag">		
							Category: <select class="categoryList" name="category">
							<?php
							foreach ($OPTIONS as $desc)
							{
								$selected = ($desc == $SELECTED ? 'selected' : '');
								echo "<option value='" . $desc . "'" . $selected . ">" . $desc . "</option>";
							}
							?>
							</select>
												
                            <input type="checkbox" class="privateNoteCheckbox" name="notePrivate" />This note is private
                        </div>
						
							<input type="file" name="file" id="file"></input>
					
                        <div class="formButtons">
                            <input type="submit" class="submitButton" name="submit" value="Save note">
                        </div>
                    </div>
                </div>
			</form>
			
			
			<script>
			  var editor = new wysihtml5.Editor("wysihtml5-editor", {
				toolbar:     "wysihtml5-editor-toolbar",
				stylesheets: ["static/reset-min.css", "static/editor.css"],
				parserRules: wysihtml5ParserRules
			  });
			  
			  editor.on("load", function() {
				var composer = editor.composer,
					h1 = editor.composer.element.querySelector("h1");
				if (h1) {
				  composer.selection.selectNode(h1);
				}
			  });
			</script>
            </div>