	<div class="center">
	
		<h3>Publish a new note</h3>
		<div class="AddNewNote">
			<form action="mainpage.php" method="post">
			<textarea style="resize:none" name="content" rows="8" cols="60"></textarea></br>
			<label for="isPublic">Make Public</label>
			<input type="checkbox" name="isPublic" value="1"/>
			<input type="submit" value="Publish">
			</form>
		</div>
		</br></br>
		<div id="notes">
			<? echo $NOTES; ?>
		</div>
	</div>