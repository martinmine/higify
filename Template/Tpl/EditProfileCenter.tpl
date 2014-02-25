
	<div class="center">
		<!-- <p>Center</p> -->
		<h3>Edit profile information</h3>
		<div class="">
      <form action="editprofile.php" method="post" enctype="multipart/form-data">
        <div>
          <h4>Select a new profile picture</h4>
          <?php if (isset($ERROR_PROFILEPIC)) echo $ERROR_PROFILEPIC; ?>
          <input type="file" name="file" id="file"></input>
        </div>
        <br />
        <br />
        <div>
          <h4>Change email adress</h4>
          <?php if (isset($ERROR_EMAIL)) echo $ERROR_EMAIL; ?>
          <label for="email">New email adress</label>
          <input type="email" name="email"></input>
         <br />
   
          <label for="emailverification">Justify new email</label>
          <input type="email" name="emailverification"></input>
        </div>
        <br />
        <div>
          <label for="public">I want my timeschedule to be public</label>
          <input type="checkbox" name="public" value ="1" <?php if ($PUBLIC)echo 'checked';?>></input>
        </div>
        <br />
  
        <div>
          <h4>Change password</h4>
          <?php if (isset($ERROR_PASSWORD)) echo $ERROR_PASSWORD; ?>
          <label for ="CurrentPassword">Current password</label>
          <input type="password" name="oldpassword"></input>
          <br />
       
          <label for ="CurrentPassword">New password</label>
          <input type="password" name="newpassword"></input>
        </div>
        <div>
          <input type="submit" value="Submit"></input>
        </div>
      </form>
		</div>
		<br /><br />
	</div>