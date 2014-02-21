			<div class="note">
				<div class="info">
					<span class="info_left"><?php echo $USERNAME; ?></span>
					<span class="info_right"><?php echo $TIME; ?></span></br>
				</div>
				<div class="content">
					<p><?php echo $CONTENT; ?></p>
				</div>
				<div class="option">
					
					<a href="mainpage.php?noteID=<?php echo $NOTEID . "&changeType=1"; ?>">
						<div class="option_right"> <?php echo $OPTION2; ?> </div>
					</a>
					
					<a href="mainpage.php?noteID=<?php echo $NOTEID . "&changeType=0"; ?>">
						<div class="option_right"> <?php echo $OPTION1; ?> </div>
					</a></br>

				</div>
			</div></br>