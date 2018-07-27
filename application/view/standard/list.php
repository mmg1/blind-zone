<div class="row">
    <div class="col-md-12">
        <h3>All interactions</h3>

        <div class="h1-bottom-border"></div>
        <table class="table table-hover" id="example">
            <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col" class="no-sort">Project name</th>
                <th scope="col">Triggered on host</th>
                <th scope="col">IP Address</th>
                <th scope="col" class="no-sort">Headers</th>
                <th scope="col" class="no-sort">Report</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($requests_data)): ?>
                <?php for($i = 0; $i < count($requests_data); $i++): ?>
                    <tr>
                        <td><?php echo $requests_data[$i]['date']; ?></td>
                        <td><a href="/links/view/<?php echo $requests_data[$i]['project_id']; ?>/<?php echo $requests_data[$i]['link_id']; ?>"><?php echo htmlspecialchars($requests_data[$i]['link_name']); ?></a></td>
                        <td><?php echo htmlspecialchars($requests_data[$i]['url'], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($requests_data[$i]['ip']); ?></td>
                        <td>
                            <a
                                data-toggle="popover"
                                data-placement="left"
                                title="Headers"
                                data-trigger="click"
                                data-html="true"
                                data-content="<?php
                                    if (empty($requests_data[$i]['headers']))
                                        echo 'Empty';
                                    else {
                                        foreach ($requests_data[$i]['headers'] as $header => $value) {
                                            echo htmlspecialchars('<b>' . htmlspecialchars($header) . '</b>: <i>' . htmlspecialchars($value) . '</i>') . '<br>';
                                        }
                                    }
                                ?>">
                                Open
                            </a>
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">View</a>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><i><?php echo htmlspecialchars($requests_data[$i]['url'], ENT_QUOTES); ?></i>'<span class="secondary-text-modal">s content</span></h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>HTML's RAW format</p>
                                            <div><pre class="raw-format"><?php echo (!empty($requests_data[$i]['html']))?htmlspecialchars($requests_data[$i]['html']):'Empty'; ?></pre></div>

                                            <p>Cookie</p>
                                            <div><pre class="raw-format"><?php echo (!empty($requests_data[$i]['cookie']))?htmlspecialchars($requests_data[$i]['cookie']):'Empty'; ?></pre></div>

                                            <p>User-Agent</p>
                                            <div><pre class="raw-format"><?php echo (!empty($requests_data[$i]['user_agent']))?htmlspecialchars($requests_data[$i]['user_agent']):'Empty'; ?></pre></div>

                                            <p>Session storage</p>
                                            <div><pre class="raw-format"><?php echo (!empty($requests_data[$i]['session_storage']))?htmlspecialchars($requests_data[$i]['session_storage']):'Empty'; ?></pre></div>

                                            <p>Local storage</p>
                                            <div><pre class="raw-format"><?php echo (!empty($requests_data[$i]['local_storage']))?htmlspecialchars($requests_data[$i]['local_storage']):'Empty'; ?></pre></div>
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