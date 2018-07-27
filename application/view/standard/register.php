<?php if(!isset($registration)): ?>
<form class="form-horizontal" action="/register" method="POST" id="register">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="text" name="email" class="form-control" id="inputEmail3" placeholder="Email" minlength="6" maxlength="1024">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail4" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" name="username" class="form-control" id="inputEmail4" placeholder="Name" minlength="2" maxlength="20">
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
            <button type="submit" class="btn btn-default right">Register</button>
        </div>
    </div>
</form>
<?php else: ?>
<h1><?php echo $registration; ?></h1>
<?php endif; ?>
