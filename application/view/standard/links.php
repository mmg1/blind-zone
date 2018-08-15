<div class="row">
    <div class="col-md-8">
        <h3><a href="/projects">Projects</a> / <i><?php echo htmlspecialchars($project->name);?></i>'<span class="secondary-text">s links</span></h3>
        <div class="h1-bottom-border"></div>
        <table class="table table-hover" id="project_links">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Last update</th>
                <th scope="col" class="no-sort">Description</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($links as $link): ?>
                <tr class="clickable-row"
                    data-href="/links/view/<?php echo $project->id; ?>/<?php echo $link->id; ?>"
                    data-toggle="tooltip"
                    data-placement="right"
                    title="Interactions: <?php echo $interactions_count[$link->id]['count']->total; ?>"
                >
                    <td><?php echo htmlspecialchars($link->name); ?></td>
                    <td><?php echo htmlspecialchars($link->date); ?></td>
                    <td class="description-link"><?php echo htmlspecialchars($link->description); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <h3>Create link</h3>
        <div class="h1-bottom-border"></div>
        <form class="form" action="/links/create/<?php echo $project->id; ?>" method="POST" id="create_link">
            <div class="form-group">
                <label>Project</label>
                <input type="text" class="form-control" id="disabledInput" placeholder="<?php echo htmlspecialchars($project->name); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Link's example</label>
                <input type="text" class="form-control" id="disabledInput" placeholder="//<?php echo $_SERVER['SERVER_NAME']; ?>/j/s/<?php echo $random_path; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Payload</label> <small class="legth-limit">Only Javascript payloads</small>
                <select name="payload" class="form-control">
                    <?php foreach($payloads as $payload): ?>
                        <option value="<?php echo $payload->id; ?>" <?php echo ($payload->id == $default_payload)?'selected="selected"':''; ?>><?php echo htmlspecialchars($payload->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Name</label> <small class="legth-limit">140 symbols</small>
                <input type="text" name="name" class="form-control" maxlength="140">
            </div>
            <div class="form-group">
                <label>Description</label> <small class="legth-limit">1024 symbols</small>
                <textarea name="description" class="form-control" maxlength="1024" rows="5" cols="100%"></textarea>
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" id="token">
            <button type="submit" class="btn btn-default right">New link</button>
        </form>
    </div>
</div>
