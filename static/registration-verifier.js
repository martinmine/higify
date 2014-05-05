$(document).ready(onDocumentReady);

function onDocumentReady()
{
    $("#registerForm").submit(onRegister);
}

function onRegister(e)
{
    var formSubmission = $(this);
    $.ajax({
        type: "POST",
        url: "validate_registration.php",
        dataType: 'json',
        data: {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            passwordConfirm: document.getElementById('passwordConfirm').value,
            email: document.getElementById('email').value,
            recaptcha_response_field: '',
            recaptcha_challenge_field: ''
        },
        success: function (jsonData)
        {
            var errorSet = false;
            $.each(jsonData, function (id, html) {
                //This is not specified by purpose as it has to be verified 
                //with the last form submission
                if (id != 'ERROR_CAPTCHA') 
                {
                    errorSet = true;
                    document.getElementById(id).innerHTML = html;
                }
            });

            if (!errorSet) {
                formSubmission.unbind('submit').submit();
            }
            else
            {
                $("#mainContainer").effect("shake", 500);
            }
        }
    });

    e.preventDefault();
}
