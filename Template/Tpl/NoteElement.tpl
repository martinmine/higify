			<div class="note">
				<div class="info">
					<div class="info_left"><?php echo $USERNAME . '&nbsp'; ?></div>
					<div class="info_right"><?php echo $TIME; ?></div>
					</br>
				</div>
				<div class="content">
					<?php echo $CONTENT; ?>
				</div>
				<div class="option">
					<a href="mainpage.php?noteID=<?php echo $NOTEID . "&changeType=1"; ?>">
						<div class="option_right"><?php echo $OPTION2; ?></div>
					</a><a href="mainpage.php?noteID=<?php echo $NOTEID . "&changeType=0"; ?>">
						<div class="option_right"><?php echo $OPTION1; ?></div>
					</a>
				</div>
			</div></br>