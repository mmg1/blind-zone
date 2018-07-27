<div class="row">
    <div class="col-sm-12">
        <h3>Settings</h3>
        <div class="h1-bottom-border"></div>
        <div class="col-md-6 settings-form">
        <h4 class="h4-title">Change password</h4>
        <form class="form" action="/settings/password" method="POST" id="password_change_form">
            <div class="form-group">
                    <input type="password" name="current" class="form-control" placeholder="Current password">
            </div>
            <div class="form-group">
                    <input type="password" name="new" class="form-control" placeholder="New password">
            </div>

            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token_password_form">
            <input type="submit" class="btn btn-default right">
        </form>
        </div>

        <div class="col-md-6 settings-form">
        <h4 class="h4-title">Set default payload</h4>
        <form class="form" action="/settings/payload" method="POST" id="payload_change_form">
            <div class="form-group">
                <select name="payload" class="form-control">
                    <?php foreach($payloads as $payload): ?>
                        <option value="<?php echo $payload->id; ?>" <?php echo ($payload->id == $default_payload)?'selected="selected"':''; ?>><?php echo htmlspecialchars($payload->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token_payload_form">
            <input type="submit" class="btn btn-default right">
        </form>
        </div>

    </div>
</div>
