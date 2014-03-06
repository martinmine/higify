                <div class="noteContainer">
                    <div class="noteHeader">
                        <div class="noteElementWrapper">
                            <div class="voteBox">
                                <a href="vote.php?noteid=<?php echo $NOTE_ID; ?>&type=1"><img src="static/<?php echo $UPVOTE_IMG; ?>.png" /></a>
                                <?php echo $VOTE_BALANCE; ?>
                                <a href="vote.php?noteid=<?php echo $NOTE_ID; ?>&type=0"><img src="static/<?php echo $DOWNVOTE_IMG; ?>.png" /></a>
                            </div>
                            
                            <img src="display_profile_picture.php?id=<?php echo $USER_ID; ?>" width="50" height="50"/>
                        </div>
                        <div class="noteTitle">
                            <a href="profile.php?id=<?php echo $USER_ID; ?>" class="noteLink"><?php echo $USERNAME; ?></a> posted<?php if ($CATEGORY) { ?> in <a href="view_notes?cat=<?php echo $CATEGORY_LINK; ?>" class="noteLink"><?php echo $CATEGORY; ?></a><?php } ?>
                        </div>
                        <div class="noteTimeStamp">
                            <a href="view_note.php?id=<?php echo $NOTE_ID; ?>" class="noteLink"><?php echo $TIME; ?></a>
                        </div>
                    </div>
                    <div class="noteContent">
                        <?php echo $CONTENT; ?>
                    </div>
                    <?php echo $NOTE_ATTACHMENT_CONTAINER; ?>
                    <div class="noteFooter">
                        <div class="noteControls">
                            <a href="create_note.php?parent=<?php echo $NOTE_ID; ?>" class="replyIcon noteIcon">Reply</a>
                            <a href="view_note.php?id=<?php echo $NOTE_ID; ?>" class="viewReplyIcon noteIcon">View replies (<?php echo $REPLY_COUNT; ?>)</a>
                        </div>
                        <div class="noteTools">
						    <?php if ($DISPLAY_EDIT) { ?><a href="create_note.php?noteID=<?php echo $NOTE_ID; ?>" class="editIcon noteIcon">Edit</a><?php } ?>
                            <?php if ($DISPLAY_DELETE) { ?><a href="mainpage.php?noteID=<?php echo $NOTE_ID . "&changeType=1"; ?>" class="deleteIcon noteIcon">Delete</a><?php } ?>
                            <?php if ($DISPLAY_REPORT) { ?><a href="report_note.php?id=<?php echo $NOTE_ID; ?>" class="reportIcon noteIcon"></a>Report<?php } ?>
                        </div>
                    </div>
                </div>