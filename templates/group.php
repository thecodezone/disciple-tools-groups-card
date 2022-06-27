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

        <?php include( 'church-health.php' ); ?>

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
