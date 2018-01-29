<div class="container">
    <pre>
        <?php
        print_r($data)
        ?>
    </pre>
    <ul class="collapsible" data-collapsible="expandable">
        <?php foreach ($data as $sections): ?>
            <li>
                <div class="collapsible-header">
                    <?= $sections[0]->offering_name ?>
                </div>
                <!--//<?php foreach ($sections as $sub): ?>           LAST-->
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="expandable">
                            <li>
                                <div class="collapsible-header">
                                    *section name*
                                </div>
                                <div class="collapsible-body">
                                    <pre>
                                        <?= print_r($sub); ?>
                                    </pre>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>