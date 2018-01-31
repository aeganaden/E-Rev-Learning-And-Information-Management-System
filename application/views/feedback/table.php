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
        <tr>
            <td><?= $value[$i]->lecturer_feedback_id ?></td>
            <td><?= $value[$i]->lecturer_feedback_timedate ?></td>
            <td><?= $value[$i]->lecturer_feedback_comment ?></td>
            <td><?= $value[$i]->lecturer_id ?></td>
            <td><?= $value[$i]->offering_id ?></td>
        </tr>
    </tbody>
</table>