<?php
$props = wp_json_encode([
    'groups' => $groups,
    'coach' => $coach,
    'card' => $card,
])
?>



<div class="card-header">
    <?php echo esc_html( $card->label ) ?>
    <span class="add-group"> + </span>
</div>
<div class="card-body"
    x-data='groups_card(<?php echo $props ?>)'>

    <div class="search-container">
        <form action="/action_page.php">
        <input type="text" placeholder="Search.." name="search">
        <button type="submit">Submit</button>
        </form>
    </div>


    <select name="filter" id="filter">
        <option value="GroupLeader1">Group Leader 1</option>
        <option value="GroupLeader2">GroupLeader2</option>
        <option value="GroupLeader3">GroupLeader3</option>
        <option value="GroupLeader4">GroupLeader4</option>
    </select>


    <div class="coach">
        <span>Coach</span>
        <h2>John Smith</h2>
    </div>

    <div class="groups">
        <div class="group">
            <h3>Group Name</h3>
            <span>Group Location</span>
        </div>
    </div>

</div>
