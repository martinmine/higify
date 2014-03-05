                <div class="noteContainer">
                    <div class="noteHeader">
                        <div class="noteElementWrapper">
                            <div class="voteBox">
                                <img src="static/upvote_unselected.png" />
                                <?php echo $VOTE_BALANCE; ?>
                                <img src="static/downvote_unselected.png" />
                            </div>
                            
                            <img src="display_profile_picture.php?id=<?php echo $USER_ID; ?>" width="50" height="50"/>
                        </div>
                        <div class="noteTitle">
                            <a href="#" class="noteLink"><?php echo $USERNAME; ?></a> posted in <a href="view_notes?cat=<?php echo $CATEGORY_LINK; ?>" class="noteLink"><?echo $CATEGORY; ?></a>
                        </div>
                        <div class="noteTimeStamp">
                            <a href="#" class="noteLink"><?php echo $TIME; ?></a>
                        </div>
                    </div>
                    <div class="noteContent">
                        <?php echo $CONTENT; ?>
                    </div>
                    <?php echo $NOTE_ATTACHMENT_CONTAINER; ?>
                    <div class="noteFooter">
                        <div class="noteControls">
                            <a href="#" class="replyIcon noteIcon"><?php echo $REPLY_COUNT; ?></a>
                        </div>
                        <div class="noteTools">
                            <?php if ($DISPLAY_EDIT) { ?><a href="#" class="editIcon noteIcon"></a><?php } ?>
                            <?php if ($DISPLAY_DELETE) { ?><a href="#" class="deleteIcon noteIcon"></a><?php } ?>
                            <?php if ($DISPLAY_REPORT) { ?><a href="#" class="reportIcon noteIcon"></a><?php } ?>
                        </div>
                    </div>
                </div>