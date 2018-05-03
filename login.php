<html><center>
<style type="text/css">
    #frmLogin { 
    padding: 20px 60px;
    background: #B6E0FF;
    color: #555;
    display: inline-block;
    border-radius: 4px; 
}
.field-group { 
    margin:15px 0px; 
}
.input-field {
    padding: 8px;width: 200px;
    border: #A3C3E7 1px solid;
    border-radius: 4px; 
}
.form-submit-button {
    background: #65C370;
    border: 0;
    padding: 8px 20px;
    border-radius: 4px;
    color: #FFF;
    text-transform: uppercase; 
}
.member-dashboard {
    padding: 40px;
    background: #D2EDD5;
    color: #555;
    border-radius: 4px;
    display: inline-block;
    text-align:center; 
}
.logout-button {
    color: #09F;
    text-decoration: none;
    background: none;
    border: none;
    padding: 0px;
    cursor: pointer;
}
.error-message {
    text-align:center;
    color:#FF0000;
}
.demo-content label{
    width:auto;
}
</style>
<form action="login1.php" method="post" id="frmLogin">
    <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>    
    <div class="field-group">
        <div><label for="login">Username</label></div>
        <div><input name="user_name" type="text" class="input-field"></div>
    </div>
    <div class="field-group">
        <div><label for="password">Password</label></div>
        <div><input name="password" type="password" class="input-field"> </div>
    </div>
    <div class="field-group">
        <div><input type="submit" name="login" value="Login" class="form-submit-button"></span></div>
    </div>       
</form>
</html>
