<div class="row">
    <style>

    </style>
    <div class="col-md-8">
        <h3>Projects</h3>
        <div class="h1-bottom-border"></div>
        <table class="table table-hover" id="example">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Last update</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects as $project): ?>
                <tr class='clickable-row'
                    data-href='/projects/view/<?php echo $project->id; ?>'
                    data-toggle="tooltip"
                    data-placement="right"
                    title="Links: <?php echo $links_count[$project->id]['count']->total; ?>">

                        <td><?php echo htmlspecialchars($project->name); ?></td>
                        <td><?php echo htmlspecialchars($project->date); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <h3>Add new project</h3>
        <div class="h1-bottom-border"></div>
        <form class="form" action="/projects" method="POST" id="new_project">
            <div class="form-group">
                <label>Name</label> <small class="legth-limit">140 symbols</small>
                <input type="text" name="name" class="form-control" maxlength="140">
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token">
            <button type="submit" class="btn btn-default right">New project</button>
        </form>
    </div>
</div>

<!-- Settings for Datatabe -->
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false
        });
    } );
</script>

<!-- Clickable rows in table -->
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>