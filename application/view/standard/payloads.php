<div class="row">

<?php if(isset($payloads) && $payloads): ?>
    <div class="col-sm-8">
        <h3>History</h3>
        <div class="h1-bottom-border"></div>
        <?php foreach($payloads as $payload): ?>
            <div class="payload">
                <div class="">
                    <div class="">
                        <h4><?php echo htmlspecialchars($payload->name); ?></h4>
                    </div>
                    <div class="">
                        <div class="payload-type">
                            <code><?php echo htmlspecialchars($payload->type); ?></code>
                        </div>
                        <div>
                            <pre><?php echo htmlspecialchars($payload->payload); ?></pre>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="col-sm-4">
    <h3>Add new payload</h3>
    <div class="h1-bottom-border"></div>
    <form class="form" action="/payloads" method="POST" id="new_payload">
        <div class="form-group">
            <label>Name</label> <small class="legth-limit">140 symbols</small>
            <input type="text" name="name" class="form-control" maxlength="140">
        </div>
        <div class="form-group">
            <label>Type</label> <small class="legth-limit">140 symbols</small>
            <input type="text" name="type" class="form-control" placeholder="Javascript, XML, SVG, etc." maxlength="140">
        </div>
        <div class="form-group">
            <label>Payload</label>
            <textarea name="payload" class="form-control" rows="5" cols="100%"></textarea>
        </div>
        <?php if($_SESSION['userdata'] === 'administration'): ?>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="public" value="1">
                    Public access
                </label>
            </div>
        </div>
        <?php endif; ?>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token">
        <button type="submit" class="btn btn-default right">New payload</button>
    </form>
</div>

</div>