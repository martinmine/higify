var SELECTED = 'selected';
var NOT_SELECTED = 'unselected';

/*
Register a vote and updates the vote according to the response from the server
*/
function registerVote(noteID, type, linkNode)
{
    $.ajax({
        url: 'vote.php?noteid=' + noteID + '&type=' + type,
        dataType: "json",
        success: function(data)
        {
            if (data.status == 'OK')
            {
                var voteAddition = (type == 0 ? -1 : 1);

                /* data.voteresponse values:
                 *  1 - Vote didn't exist, it has been created
                 *  2 - A vote of this type already existed and is now removed
                 *  3 - A down of the opposite type already existed and has been converted*/
                switch (data.voteresponse)
                {
                    case '2':
                        {
                            voteAddition = -1 * voteAddition;
                            break;
                        }

                    case '3':
                        {
                            voteAddition += voteAddition;
                            break;
                        }
                }
                
                // Update the vote counter:
                var voteNode = $('#votes_' + noteID);
                var votes = parseInt(voteNode.text()) + voteAddition;
                voteNode.text(votes);
            }
        }
    });

    // Update the image (arrow) being clicked:
    var imageNode = linkNode.firstChild;
    var imageStatus = imageNode.src.split('_');
    var suffix = (imageStatus[1] == SELECTED + '.png') ? NOT_SELECTED : SELECTED;
    var prefix = imageStatus[0];
    imageNode.src = prefix + '_' + suffix + '.png';

    // Update the other image/arrow
    var otherNode = document.getElementById((type == 0 ? 'upvote' : 'downvote') + '_' + noteID);
    var imageStatus = otherNode.src.split('_');
    otherNode.src = imageStatus[0] + '_' + NOT_SELECTED + '.png';
}
