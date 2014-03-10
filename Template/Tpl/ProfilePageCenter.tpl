	<div class="pageSideContainer">
		<div class="pageElement">
			<div class="notes">
				<h3 id="adjust"> Notes </h3>
				<?php echo $RESULTS; ?>
			</div>
		</div>
	</div>
	
	<div class="pageWidgetContainer">
		<div class="pageElement">
			<div class="picture">
				<img src="display_profile_picture.php?id=<?php echo $PROFILE_ID; ?>" id="imgsize">
				<div class="about">
					<h3><?php echo 'About ' . $USERNAME . ':'; ?></h3>
				</div>
			</div>
		</div>