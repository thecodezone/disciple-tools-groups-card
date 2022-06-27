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

    <!-- THE GROUP LISTING VIEW -->
    <template x-data="groups_card_listing"
              x-if="!store.group">
        <div id="listing">
            <?php include( 'search.php' ); ?>
            <?php include( 'leader-filter.php' ); ?>
            <?php include( 'coach.php' ); ?>

            <div class="groups">
                <template x-for="group in store.groups.posts"
                          :key="group.ID">
                    <div class="group"
                         x-on:click="store.setGroup(group)">
                         <div class="text">
                            <h3 x-text="group.post_title"></h3>
                            <!-- TO GET THE LOCATION SHOW UP, YOU NEED TO SET A LOCATION IN THE GROUP SETTINGS -->
                            <template x-if="group?.location_grid && group.location_grid.length">
                                <p class="location"
                                x-text="group.location_grid[0].label"></p>
                            </template>
                         </div>
                        <span class="fi-info"></span>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- THE GROUP VIEW -->
    <template x-if="store.group">
        <div id="group" x-data="groups_card_group">
            <?php include( 'search.php' ); ?>
            <?php include( 'coach.php' ); ?>

            <div class="group__breadcrumbs breadcrumbs">
                <a x-on:click.prevent="store.goToListing">Groups</a> > <a x-text="store.group.post_title"></a>
            </div>

            <hr/>

            <template x-if="store.group.location_grid && store.group.location_grid.length">
                <div class="group__location location"
                     x-text="store.group.location_grid[0].label"></div>
            </template>

            <h3 class="group__title"
                x-text="store.group.post_title"></h3>
            <hr/>

            <a class="button"
               :href="store.group.permalink">
                <?php _e( 'View Group Profile', 'disciple_tools_groups_card' ) ?>
            </a>

            <div class="group__health">
                <?php (new DT_Groups_Base())->dt_details_additional_section('health-metrics', 'groups'); ?>
            </div>

            <template x-if="rosterPaginated && rosterPaginated.length">
                <div class="group__members">
                    <h3><?php _e('Members', 'disciple_tools_groups_card' ) ?></h3>
                    <template x-for="member in roster"
                              :key="member.ID">
                        <div class="member">
                            <h4 x-text="member.post_title" class="member__name"></h4>
                            <p x-text="member.role" class="member__role"></p>
                        </div>
                    </template>
                </div>
            </template>

        </div>
    </template>
</div>
