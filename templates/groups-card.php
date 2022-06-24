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
    <span class="numberCircle">&nbsp;<span id="active_contacts">-</span>&nbsp;</span>
    <a class="view-all button"
       href="<?php echo esc_url( home_url( '/' ) ) . "contacts/new" ?>">
        <?php esc_html_e( "Add a contact", 'disciple-tools-dashboard' ) ?>
    </a>
</div>
