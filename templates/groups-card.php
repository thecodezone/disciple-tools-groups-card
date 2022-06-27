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

    <div class="pagination">
        <div class="pagination-item-prev"
                x-on:click="store.groups.prev()">
        </div>
        
        <div class="numbers">
            <span class="active">1</span>
            <span>2</span>
            <span>3</span>
        </div>
        
        <div class="pagination-item-next"
                x-on:click="store.groups.next()">
        </div>
    </div>

</div>
