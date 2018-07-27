<div class="row">
    <div class="col-md-8">
        <h3>
            <a href="/projects">
                Projects
            </a> / <a href="/projects/view/<?php echo $project->id; ?>">
                <?php echo htmlspecialchars($project->name);?>
            </a> / <i><?php echo htmlspecialchars($link->name); ?></i>'<span class="secondary-text">s interactions</span>
        </h3>
        <div class="h1-bottom-border"></div>
        <table class="table table-hover" id="example">
            <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Triggered on host</th>
                <th scope="col">IP Address</th>
                <th scope="col" class="no-sort">Headers</th>
                <th scope="col" class="no-sort">HTML</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($request_data)): ?>
                <?php for($i = 0; $i < count($request_data); $i++): ?>
                    <tr>
                        <td><?php echo $request_data[$i]['date']; ?></td>
                        <td><?php echo htmlspecialchars($request_data[$i]['url'], ENT_QUOTES); ?></td>
                        <td><?php echo $request_data[$i]['ip']; ?></td>
                        <td>
                            <a
                               data-toggle="popover"
                               data-placement="left"
                               title="Headers"
                               data-html="true"
                               data-content="<?php foreach($request_data[$i]['headers'] as $header => $value) { echo htmlspecialchars('<b>'.htmlspecialchars($header).'</b>: <i>'.htmlspecialchars($value).'</i>').'<br>'; } ?>">
                                Open
                            </a>
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">Download</a>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><i><?php echo htmlspecialchars($request_data[$i]['url'], ENT_QUOTES); ?></i>'<span class="secondary-text-modal">s content</span></h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>RAW format</p>
                                            <div><pre class="raw-format"><?php echo (!empty($request_data[$i]['html']))?htmlspecialchars($request_data[$i]['html']):'Empty'; ?></pre></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <h3>Link's info</h3>
        <div class="h1-bottom-border"></div>
        <div>
            <div style="margin-bottom: 10px;">
                <strong style="font-size:  16px;">Name: </strong>
                <?php echo htmlspecialchars($link->name); ?>
            </div>
        </div>
        <div>
            <div style="margin-bottom:  10px;">
                <strong style="font-size:  16px;">Description: </strong>
                <?php echo htmlspecialchars($link->description); ?>
            </div>
        </div>
        <div>
            <div style="margin-bottom:  10px;">
                <input type="text" class="form-control" value="//<?php echo $_SERVER['SERVER_NAME']; ?>/j/s/<?php echo htmlspecialchars($link->path); ?>">
            </div>
        </div>
        <?php /*
        <div>
            <div style="margin-bottom:  10px;">
                <strong>Payload: </strong>
                    <div class="form-group" style="margin-top: 10px;">
                        <textarea name="payload" class="form-control" placeholder="Payload" rows="5" cols="100%"></textarea>
                    </div>
            </div>
        </div>
        */ ?>
    </div>
</div>

<!-- Settings for Datatable -->
<script>
    $(document).ready(function() {

        $('#example').DataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "ordering": true,
            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }]
        });
    } );
</script>

<!-- Clickable rows in table -->
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        $('[data-toggle="popover"]').popover();

        $(document).on('click', function (e) {
            $('[data-toggle="popover"],[data-original-title]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
                }

            });
        });
    });
</script>