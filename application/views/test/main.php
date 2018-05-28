<!-- LAST! - ayaw gumana ng hover -->
<a class='dropdown-button btn' data-beloworigin="true" href='#' data-activates='dropdown1'>Drop Me!</a>
<!-- Dropdown Structure -->
<ul id='dropdown1' class='dropdown-content'>
    <li><a href="#!">one</a></li>
    <li><a href="#!">two</a></li>
    <li class="divider"></li>
    <li><a href="#!">three</a></li>
    <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
    <li><a href="#!"><i class="material-icons">cloud</i>five</a></li>
</ul>

<script>
    $('.dropdown-button').dropdown({
        hover: true, // Activate on hover
    });
</script>