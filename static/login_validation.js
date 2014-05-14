/*
userExists: Confirming that a user with given username and password exists in database
@param uname: username 
@param pwd: password
@param callback: Callback function on success for "need to know now data" without making async: false
*/
function userExist(uname, pwd, callback)					
{
	$.ajax({
		url: './userexist.php',
		data: { 'username': uname, 'password': pwd },
		type: 'post',
		dataType: 'json',
		success: callback,									
		error: function(console.log("could not connect");}
	});
}

/*
validate: Validates given form 
@param form: login form (templates/loginBody.tpl)
*/
function validate(form)
{
	var username = form.username.value;
	var password = form.password.value;
	var usernameError = "";
	var passwordError = "";

	var approved = username.search(/^[æøåa-z0-9 ]+$/i);	    // Regex check, username can only consist of letters and numbers

	if(approved != 0)
	{
		usernameError = "Username can only contain letters and numbers";
	}
	
	if (username.length < 5)
	{
		usernameError = "Username must be atleast five characters";
	}
	
	if (password.length < 4)
	{
		passwordError = "Invalid password";
	}
	
	if (usernameError != "") {			                                            // Handling unaccepted username
		$( "#usernameError" ).text(usernameError);
		$( "#usernameError" ).effect("highlight", {color: '#DB4D4D'}, 500);
	    usernameError = "";
		return false;
	}
	
	if (passwordError != "") {														// Handling unaccepted password
		$( "#passwordError" ).text(passwordError);
		$( "#passwordError" ).effect("highlight", {color: '#DB4D4D'}, 500);
		passwordError = "";
		return false;
	}
	
	userExist(username,password, function(response){
		if (response.ok)
		{																			// If the login is accepted, send userinfo to login.php witch sets the user to logged in
			$.ajax({
				url: './login.php',
				data: { 'username': username, 'password': password, 'rememberPassword': form.rememberPassword.value },
				type: 'post',																	// Redirect user to mainpage
				success: function(){window.location = './mainpage.php'; return false	},
				error: function(jqXHR, textStatus, errorThrown){$("#usernameError").html(jqXHR.responseText);}
			});
		}
		else if (!response.ok)												// The username / password combination was not found
		{
			$( "#usernameError" ).text(response.msg); 
			$( "#passwordError" ).effect("highlight", {color: '#DB4D4D'}, 500); 
			return false;
		}
	});
	return false;
}