
	<div class="pageSideContainer">
		<div class="pageElement" id="notes">
				<div class="pageTitle">Notes </div>
				<?php echo $RESULTS; ?>
		</div>
	</div>
	
	<div class="pageWidgetContainer">
		<img src="display_profile_picture.php?id=<?php echo $PROFILE_ID; ?>" id="imgsize">
		<div class="pageElement">
			<div class="pageTitle">Schedule</div>
			<?php echo $SCHEDULE; ?>
		</div>
		
		<div class="pageElement">
			<div class="pageTitle">Stalking</div>
			<?php echo $STALKER_ELEMENTS; ?>
			<?php if ($DISPLAY_STALKBTN) { ?>
			<div><button type="button" id="stalkActionBtn" class="stalkBtn <?php echo ($STALKING ? 'stalking' : 'notStalking'); ?>" onclick="triggerStalking(<?php echo $PROFILE_ID; ?>)"><?php echo ($STALKING ? 'Unstalk' : 'Stalk'); ?></button></div>
			<?php } ?>
		</div>
	</div>