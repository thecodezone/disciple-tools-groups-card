<?php
$props = wp_json_encode([
    'groups' => $groups,
    'coach' => $coach,
    'card' => $card,
]);
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


    <div class="typeahead__container" x-data="leader_filter">
        <div class="typeahead__field">
            <span class="typeahead__query">
                <input x-ref="filter_field"
                       class="input-height"
                       name="leader_filter"
                       placeholder="<?php echo esc_html_x( "Filter by Group Leader", 'input field placeholder', 'disciple_tools_groups_card' ) ?>"
                       autocomplete="off">
            </span>
        </div>
    </div>


    <div class="coach">
        <span>Coach</span>
        <h2 x-text="store.coach.name"></h2>
    </div>

    <div class="groups">
        <template x-for="group in store.groups.posts" :key="group.ID">
            <div class="group">
                <h3 x-text="group.post_title"></h3>
            </div>
        </template>
    </div>
</div>
