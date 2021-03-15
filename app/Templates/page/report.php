<?php
$title = 'Calls report';
require __DIR__.'/../header.php';
?>
    <div class="row">
        <div class="col-8 mx-auto">
            <table class="table table-hover table-striped table-sm">
                <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Calls total count</th>
                    <th>Calls total duration (s)</th>
                    <th>Calls within continent</th>
                    <th>Duration within continent (s)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($report as $row) {
                    printf(
                        '<tr><td>%d</td><td>%d</td><td>%d</td><td>%d</td><td>%d</td></tr>',
                        $row['customer_id'],
                        $row['total'],
                        $row['duration'],
                        $row['same_continent']['total'],
                        $row['same_continent']['duration'],
                    );
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
require __DIR__.'/../footer.php';
