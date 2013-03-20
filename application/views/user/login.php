<form method="post">
    <fieldset>
    <legend>Login</legend>
    <?php if(strlen(validation_errors()) > 0){?>
     	<div class ="error-msg"><?php echo validation_errors();?></div>
    <?php }?>
	<?php if((isset($message)) && (strlen($message) > 0)){?>
    	<div class ="error-msg"><?php echo $message; ?></div>
    <?php }?>
    <?php if(strlen($this->session->flashdata('invalidaccess')) > 0){?>
    	<div class ="error-msg"><?php echo $this->session->flashdata('invalidaccess'); ?></div>
    <?php }?>
    
    <p>
	    <label>Username:</label>
	    <input type="text" name="username" id="username" />
	</p>
	<p>
	    <label>Password:</label>
	    <input type="password" name="password" id="password" />
	</p>
	
	
    <button type="submit" class="btn" name="Login" value="Login">Login</button>
    
    </fieldset>
    
    
    
 </form>
