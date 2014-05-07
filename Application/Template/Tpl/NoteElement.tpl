                
				<div class="noteContainer" id="<?php echo $NOTE_ID; ?>">
				    <script>
						incrementNoteCounter();
				    </script>
                    <div class="noteHeader">
                        <div class="noteElementWrapper">
                            <div class="voteBox">
								<div class="upvote">
									<a href="vote.php?noteid=<?php echo $NOTE_ID; ?>&type=1"><img src="static/<?php echo $UPVOTE_IMG; ?>.png" /></a>
								</div>
                                <div class="voteCounter">
									<?php echo $VOTE_BALANCE; ?>
								</div>
								<div class="downvote">
									<a href="vote.php?noteid=<?php echo $NOTE_ID; ?>&type=0"><img src="static/<?php echo $DOWNVOTE_IMG; ?>.png" /></a>
								</div>
                            </div>
                            <div class="noteProfilePictureContainer">
								<img src="display_profile_picture.php?id=<?php echo $USER_ID; ?>" width="50" height="50"/>
							</div>
                        </div>
                        <div class="noteTitle">
                            <a href="profile.php?id=<?php echo $USER_ID; ?>" class="noteLink"><?php echo $USERNAME; ?></a> 
							<?php if (empty($OP)) { ?>posted <?php } 
							      else { ?> <a href="view_note.php?nid=<?php echo $PARENT_ID; ?>" class="noteLink">replied to <?php echo $OP; ?></a><?php } ?>
								  <?php if ($CATEGORY) { ?>in <a href="view_category.php?cat=<?php echo $CATEGORY_LINK; ?>" class="noteLink"><?php echo $CATEGORY; ?></a><?php } ?>
								  <?php if (isset($REPORTER)) { ?>Reported by <a href="profile.php?id=<?php echo $REPORTERID; ?>" class="noteLink"><?php echo $REPORTER; ?></a> <?php } ?>
                        </div>
                        <div class="noteTimeStamp">
                            <a href="view_note.php?Fid=<?php echo $NOTE_ID; ?>" class="noteLink"><?php echo $TIME; ?></a>
                        </div>
                    </div>
                    <div class="noteContent" id="content<?php echo $NOTE_ID; ?>">
                        <?php echo $CONTENT; ?>
                    </div>
					<a href="javascript:readMore(<?php echo $NOTE_ID; ?>)" class="readMore" id="readMore<?php echo $NOTE_ID; ?>">
						<div class="readMore" id="readMore<?php echo $NOTE_ID; ?>">Read more</div>
					</a>
                    <?php echo $NOTE_ATTACHMENT_CONTAINER; ?>
					<div class="noteFooter onDelete" id="onDelete<?php echo $NOTE_ID; ?>">
						<div class="infoOption">Delete note?</div>
						<a href="javascript:onNoteDeleteConfirm(<?php echo $NOTE_ID; ?>)">
							<div class="deleteOption" id="confirmButton">Confirm</div>
						</a>
						<a href="javascript:onNoteDeleteCancel(<?php echo $NOTE_ID; ?>)">
							<div class="deleteOption" id="cancelButton">Cancel</div>
						</a>
					</div>
					<div class="onReport vc hc" id="onReport<?php echo $NOTE_ID; ?>">
						<div class="feedbackArea">
							<p id="feedbackTitle">Message</p>
							<p id="message">Note reported, thank your for helping us trying to keep this site clean</p>
						</div>
						<div class="buttonWrapper">
							<button onclick="onReportContinue(<?php echo $NOTE_ID; ?>)">Continue</button>
						</div>
					</div>
                    <div class="noteFooter standard" id="standard<?php echo $NOTE_ID; ?>">
                        <div class="noteControls">
                            <a href="create_note.php?parent=<?php echo $NOTE_ID; ?>" class="replyIcon noteIcon">Reply</a>
                            <a href="view_note.php?nid=<?php echo $NOTE_ID; ?>" class="viewReplyIcon noteIcon">View replies (<?php echo $REPLY_COUNT; ?>)</a>
                        </div>
			
                        <div class="noteTools">
						    <?php if ($DISPLAY_EDIT) { ?><a href="create_note.php?edit_id=<?php echo $NOTE_ID; ?>" class="editIcon noteIcon">Edit</a><?php } ?>
                            <?php if ($DISPLAY_DELETE) { ?><a href="javascript:onNoteDelete(<?php echo $NOTE_ID; ?>)" class="deleteIcon noteIcon">Delete</a><?php } ?>
                            <?php if ($DISPLAY_REPORT) { ?><a href="javascript:onReport(<?php echo $NOTE_ID; ?>)" class="reportIcon noteIcon" id="report<?php echo $NOTE_ID; ?>">Report</a><?php } ?>
							<?php if ($DISPLAY_IGNORE) { ?><a href="report_note.php?noteID=<?php echo $NOTE_ID; ?>&userID=<?php echo $REPORTERID; ?>" class="ignoreIcon noteIcon">Ignore</a><?php } ?>
                        </div>
                    </div>
                </div>
				<script>
					addReadMoreLess(<?php echo $NOTE_ID; ?>);
				</script>