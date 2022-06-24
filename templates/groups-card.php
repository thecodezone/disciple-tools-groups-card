<?php
$groups = $groups ?? [
        'total' => 5,
        'posts' =>
            [
                0 =>
                    [
                        'ID'   => '434',
                        'name' => 'A brand new group',
                    ],
                1 =>
                    [
                        'ID'   => '322',
                        'name' => 'This is a group name',
                    ],
                2 =>
                    [
                        'ID'   => '320',
                        'name' => 'This is the group',
                    ],
                3 =>
                    [
                        'ID'   => '6',
                        'name' => 'Craig Wann',
                    ],
                4 =>
                    [
                        'ID'   => '115',
                        'name' => 'Group101',
                    ],
            ],
    ];
$user = $user ?? [
        'ID'    => 5,
        'name'  => 'craig',
        'title' => 'craig',
    ];
$card = $card ?? [
    'handle' => 'groups-card',
    ];
?>



<div class="card-header">
    <?php echo esc_html( $card->label ) ?>
    <span class="add-group"> + </span>
</div>
<div class="card-body"
     x-data="groups_card({
    groups: <?php echo wp_json_encode( $groups ) ?>
    user: <?php echo json_encode( $user ) ?>
    card: <?php echo json_encode( $card ) ?>
})">

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
