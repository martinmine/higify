				 <script type="text/javascript">
					var RecaptchaOptions = {
						theme : 'custom',
						custom_theme_widget: 'recaptcha_widget'
					};
				</script>
				<form action="forgotten.php" method="POST">
				<div class="pageTitle">Forgotten password</div>
				<div class="loginContainer">
					
					<label for="email">Email address</label><br/>
					<div class="fieldDescription">Enter the email address you used to register the account you forgot the password for</div>
					<?php if (isset($ERROR_EMAIL)) echo $ERROR_EMAIL; ?>
					<input class="inputfield" type="text" id="email" name="email"/><br/>

					<label for="recaptcha_response_field">Security code</label><br/>
					<div class="fieldDescription">Enter the security code bellow so we know you are a not a developer</div>
					<div id="recaptcha_widget" style="display:none">
						<div id="recaptcha_image"></div>
						<div class="fieldDescription">
							<a class="captchaController" href="javascript:Recaptcha.reload()">I can't read this, get me a new code!</a>
						</div>
						<?php if (isset($ERROR_CAPTCHA)) echo $ERROR_CAPTCHA; ?>
						<input class="inputfield" type="text" id="recaptcha_response_field" name="recaptcha_response_field"/>
						
						<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $RECAPTCHA_PUBLIC_KEY; ?>"></script>
						<noscript>
							<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $RECAPTCHA_PUBLIC_KEY; ?>"
							 height="300" width="500" style="border:none;"></iframe><br>
							<textarea name="recaptcha_challenge_field" rows="3" cols="40">
							</textarea>
							<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
						</noscript>
					</div>
				</div>
				<div>
					<input class="purplebtn" type="submit" value="Request password"/>
				</div>
			</form>
			<div>
				<form action="index.php">
						<input type="submit" class="greenbtn" value="Cancel"/>
				</form>
			</div>
				