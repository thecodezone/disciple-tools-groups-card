<?php
$props = wp_json_encode( [
    'user'   => $user,
    'groups' => $groups,
    'tile'   => $tile,
], JSON_HEX_APOS );
?>


<div class="tile-header">
    <?php echo esc_html( $tile->label ) ?>
    <a href="/groups/new"
       title="<?php echo esc_attr( __( 'New ', 'disciple_tools_groups_tile' ) . $group_label ) ?>">
        <span class="add-group"> + </span>
    </a>
</div>

<div class="tile-body tile-body--scroll"
     x-data='groups_tile(<?php echo esc_attr( $props ) ?>)'>

    <?php include( 'groups.php' ); ?>
    <?php include( 'group.php' ); ?>
</div>
