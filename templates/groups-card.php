<?php
$props = wp_json_encode( [
    'user' => $user,
    'groups' => $groups,
    'coach'  => $coach,
    'card'   => $card,
], JSON_HEX_APOS );
?>


<div class="card-header">
    <?php echo esc_html( $card->label ) ?>
    <span class="add-group"> + </span>
</div>

<div class="card-body card-body--scroll"
     x-data='groups_card(<?php echo $props ?>)'>

    <?php include( 'groups.php' ); ?>
    <?php include( 'group.php' ); ?>

</div>
