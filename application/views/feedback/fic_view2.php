<div class="container">
    <div class="input-field col s12">
        <form method="post" action="">
            <select name="section">
                <option value="" disabled selected>Choose your option</option>
                <option value="1">Option 1</option>
            </select>
            <label>Materialize Select</label>
        </form>
    </div>
    <?php
    if (isset($feedback)) {
        echo "HEY!";
    }
    ?>
</div>