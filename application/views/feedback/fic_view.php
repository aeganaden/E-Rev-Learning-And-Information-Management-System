<div class="container">
    <pre>
        <?= print_r($data) ?>
    </pre>
    <ul class="collapsible" data-collapsible="expandable">
        <?php foreach ($data as $sections): ?>
            <li>
                <div class="collapsible-header">
                    <?= $sections[0]->offering_name ?>
                </div>
                <div class="collapsible-body">
                    <?php foreach ($sections[1] as $value): ?>
                        <ul class="collapsible" data-collapsible="expandable">
                            <li>
                                <div class="collapsible-header">
                                    <?= $value[0] ?> - <?= $value[1] ?>
                                </div>
                                <div class="collapsible-body">

                                    <table class="striped responsive-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Time/Date</th>
                                                <th>Feedback</th>
                                                <th>Lect id</th>
                                                <th>offer_id</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php for ($i = 2; $i < count($value); $i++): ?>
                                                <tr>
                                                    <td><?= $value[$i]->lecturer_feedback_id ?></td>
                                                    <td><?= $value[$i]->lecturer_feedback_timedate ?></td>
                                                    <td><?= $value[$i]->lecturer_feedback_comment ?></td>
                                                    <td><?= $value[$i]->lecturer_id ?></td>
                                                    <td><?= $value[$i]->offering_id ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>