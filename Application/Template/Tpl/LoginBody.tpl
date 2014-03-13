				<form action="login.php" method="POST">
					<div class="pageTitle">Sign in to Higify</div>
					<div class="loginContainer">
						<?php if (isset($ERROR_MSG)) echo $ERROR_MSG; ?>
						<label for="username">Username</label><br/>
						<input class="inputfield" type="text" id="username" name="username"/><br/>
						<label for="password">Password</label><br/>
						<input class="inputfield" type="password" id="password" name="password"/><br/>
						<input type="checkbox" name="rememberPassword" id="rememberPassword" value="true"/> 
						<label for="rememberPassword">Remember password</label><br/>
						<a href="forgotten.php" class="reglink">Forgotten password&raquo;</a><br/>
					</div>
					<div>
						<input class="purplebtn" type="submit" value="Sign in"/>
					</div>
				</form>
				<div>
					<form action="register.php">
						<input type="submit" class="greenbtn" value="Sign up"/>
					</form>
				</div>
			