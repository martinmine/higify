            <div class="pageElement">
                <div class="pageTitle">Create a new note</div>
                <form action="create_note.php" method = "POST">
                <div class="createNoteWrapper">
                    <div>Category:</div>
                    <div>
                        <select class="categoryList" name= <?php echo $CATEGORY ?> >
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