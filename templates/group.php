<!-- THE GROUP VIEW -->
<template x-if="store.group">
    <div id="group" x-data="groups_card_group">
        <?php include( 'search.php' ); ?>
        <?php include( 'coach.php' ); ?>

        <div class="group__breadcrumbs breadcrumbs">
            <a x-on:click.prevent="store.goToListing"><?php echo esc_html($groups_label); ?></a> > <a x-text="store.group.post_title"></a>
        </div>

        <hr/>

        <template x-if="store.group.location_grid && store.group.location_grid.length">
            <div class="group__location location"
                 x-text="store.group.location_grid[0].label"></div>
        </template>

        <h3 class="group__title"
            x-text="store.group.post_title"></h3>
        <hr/>

        <div class="group-profile-btn">
            <a class="button"
            :href="store.group.permalink">
                <?php echo __( 'View ', 'disciple_tools_groups_card') . esc_html($group_label) . __(' Profile', 'disciple_tools_groups_card' ) ?>
            </a>
        </div>

        <?php include( 'church-health.php' ); ?>

        <template x-if="rosterPaginated && rosterPaginated.length">
            <div class="group__members">
                <h3><?php _e('Members', 'disciple_tools_groups_card' ) ?></h3>
                <template x-for="member in roster"
                          :key="member.ID">
                    <div class="member">
                        <div class="text">
                            <h4 x-text="member.post_title" class="member__name"></h4>
                            <p x-text="member.role" class="member__role"></p>

                        </div>
                        <a class="button"
                            :href="store.member.permalink">
                                <?php _e( 'View Profile', 'disciple_tools_groups_card' ) ?>
                            </a>
                    </div>
                </template>

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
        </template>

    </div>
</template>
