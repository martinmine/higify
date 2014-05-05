				 <script type="text/javascript">
					var RecaptchaOptions = {
						theme : 'custom',
						custom_theme_widget: 'recaptcha_widget'
					};
				</script>
				<form action="register.php" method="POST" id="registerForm">
				<div class="pageTitle">Registration</div>
				<div class="loginContainer">
					<div id="errors"></div>
					<label for="username">Username</label><br/>
					<div class="fieldDescription">Enter a desired username for your account</div>
					<div id="ERROR_USR"><?php if (isset($ERROR_USR)) echo $ERROR_USR; ?></div>
					<input class="inputfield" type="text" id="username" name="username" required/><br/>

					<label for="password">Password</label><br/>
					<div class="fieldDescription">Remember: Always use a secure password!</div>
					<div id="ERROR_PSW"><?php if (isset($ERROR_PSW)) echo $ERROR_PSW; ?></div>
					<input class="inputfield" type="password" id="password" name="password" required/><br/>

					<label for="passwordConfirm">Password verification</label><br/>
					<div class="fieldDescription">Then re-enter your password so you know you entered the right password in case you had a typo</div>
					<div id="ERROR_PSWCONFIRM"><?php if (isset($ERROR_PSWCONFIRM)) echo $ERROR_PSWCONFIRM; ?></div>
					<input class="inputfield" type="password" id="passwordConfirm" name="passwordConfirm" required/><br/>

					<label for="email">Email address</label><br/>
					<div class="fieldDescription">Enter the email address you want to use with your account</div>
					<div id="ERROR_EMAIL"><?php if (isset($ERROR_EMAIL)) echo $ERROR_EMAIL; ?></div>
					<input class="inputfield" type="text" id="email" name="email" required/><br/>

					<label for="recaptcha_response_field">Security code</label><br/>
					<div class="fieldDescription">Enter the security code bellow so we know you are a human</div>
					<div id="recaptcha_widget" style="display:none">
						<div id="recaptcha_image"></div>
						<div class="fieldDescription">
							<a class="captchaController" href="javascript:Recaptcha.reload()">I can't read this, get me a new code!</a>
						</div>
						<div id="ERROR_CAPTCHA"><?php if (isset($ERROR_CAPTCHA)) echo $ERROR_CAPTCHA; ?></div>
						<input class="inputfield" type="text" id="recaptcha_response_field" name="recaptcha_response_field" required/>
						
						<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $RECAPTCHA_PUBLIC_KEY; ?>"></script>
						<noscript>
							<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $RECAPTCHA_PUBLIC_KEY; ?>"
							 height="300" width="500" style="border:none;"></iframe><br>
							<textarea name="recaptcha_challenge_field" id="recaptcha_challenge_field" rows="3" cols="40">
							</textarea>
							<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
						</noscript>
					</div>
				</div>
				<div>
					<input class="purplebtn" type="submit" value="Register"/>
				</div>
			</form>
			<div>
				<form action="index.php">
						<input type="submit" class="greenbtn" value="Cancel"/>
				</form>
			</div>
				