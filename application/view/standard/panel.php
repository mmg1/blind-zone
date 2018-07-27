<div class="row">
    <div class="col-sm-12">
        <h3>Admin panel</h3>

        <div class="h1-bottom-border"></div>

        <form class="form admin-panel-form" action="/panel" method="POST" id="panel_form">
            <div class="form-group">
                    <div class="">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="registration" value="1" <?php echo $registration; ?>>
                                Open registration
                            </label>
                        </div>
                    </div>
                    <div class="">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="access" value="open">
                                Hide site from public (Only internal access)
                            </label>
                        </div>
                    </div>
            </div>

            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token">
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>
