function triggerStalking(userID)
{
    $.ajax({
        url: 'stalk.php?user=' + userID,
        dataType: 'json',
        success: function(data)
        {
            if (data.status == 'OK')
            {
                var button = $('#stalkActionBtn');

                if (data.stalkstatus == '0')
                {
                    button.attr('class', 'stalkBtn notStalking');
                    button.html('Stalk');
                }
                else
                {
                    button.attr('class', 'stalkBtn stalking');
                    button.html('Unstalk');
                }
            }
        }
    })
}