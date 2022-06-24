<?php
$props = wp_json_encode( [
    'groups' => $groups,
    'coach'  => $coach,
    'card'   => $card,
] );
?>


<div class="card-header">
    <?php echo esc_html( $card->label ) ?>
    <span class="add-group"> + </span>
</div>

<div class="card-body"
     x-data='groups_card(<?php echo $props ?>)'>

    <!-- THE GROUP LISTING VIEW -->
    <template x-data="groups_card_listing"
              x-if="!store.group">
        <div id="listing">
            <?php include('search.php'); ?>
            <?php include('leader-filter.php'); ?>
            <?php include('coach.php'); ?>

            <div class="groups">
                <template x-for="group in store.groups.posts"
                          :key="group.ID">
                    <div class="group"
                         x-on:click="store.setGroup(group)">
                        <h3 x-text="group.post_title"></h3>
                        <p class="location">Group Location</p>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- THE GROUP VIEW -->
    <template x-data="groups_card_group"
              x-if="store.group">
        <div id="group">
            <?php include('search.php'); ?>
            <?php include('coach.php'); ?>

            <h1 x-text="store.group.post_title"></h1>
            <div class="breadcrumbs">
                <a x-on:click.prevent="store.goToListing.bind(store)">Groups</a> > <a x-text="store.group.post_title"></a>
            </div>
        </div>
    </template>
</div>
