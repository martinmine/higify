	<div class="center">
		<div class="mid">
			<h3>Publish a new note</h3>
			<div class="AddNewNote">
				<form action="mainpage.php<?php echo $EDIT; ?>" method="post">
				<textarea style="resize:none" name="content"><?php echo $CONTENT; ?></textarea></br>
				<label for="isPublic">Make Public</label>
				<input type="checkbox" name="isPublic" <?php echo $ISPUBLIC; ?>/>
				<input type="submit" name="submit" value="publish">
				</form></br>
				<div class="cancelEdit">
					<a href="mainpage.php"><div class="button"><?php echo $CANCEL; ?></div></a>
				</div>
			</div>
			</br></br>
			<div id="notes">
				<?php echo $NOTES; ?>
			</div>
		</div>
	</div>