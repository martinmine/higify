	<div class="center">
		<div class="mid">
			<h3>Publish a new note</h3>
			<div class="AddNewNote">
				<form action="mainpage.php" method="post">
				<textarea style="resize:none" name="content"></textarea></br>
				<label for="isPublic">Make Public</label>
				<input type="checkbox" name="isPublic" value="1"/>
				<input type="submit" name="submit" value="publish">
				</form>
			</div>
			</br></br>
			<div id="notes">
				<?php echo $NOTES; ?>
			</div>
		</div>
	</div>