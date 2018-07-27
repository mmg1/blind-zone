<form class="form-horizontal" action="/login" method="POST" id="login">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Login</label>
        <div class="col-sm-10">
            <input type="text" name="login" class="form-control" id="inputEmail3" placeholder="Login">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
        </div>
    </div>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token">

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default right">Sign in</button>
        </div>
    </div>
</form>
