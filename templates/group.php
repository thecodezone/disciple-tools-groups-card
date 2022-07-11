<!-- THE GROUP VIEW -->
<template x-if="store.group">
    <div id="group" x-data="groups_card_group">
        <?php include( 'search.php' ); ?>

        <div class="group__breadcrumbs breadcrumbs">
            <a x-on:click.prevent="store.goToListing"><?php echo esc_html($groups_label); ?></a> > <a x-text="store.group.post_title"></a>
        </div>

        <hr/>

        <template x-if="store.group.location_grid && store.group.location_grid.length">
            <div class="group__location location"
                 x-text="store.group.location_grid[0].label"></div>
        </template>

        <h2 class="group__title"
            x-text="store.group.post_title"></h2>
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
                <h3 class="help-button-tile"
                    data-title="<?php echo esc_html(__('Members', 'disciple_tools_groups_card')); ?>"

                ><?php _e('Members', 'disciple_tools_groups_card' ) ?></h3>
                <template x-for="member in rosterPaginated"
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

                <template x-if="roster.length">
                    <div class="pagination">
                        <div class="pagination-item pagination-item-prev"
                             x-on:click="prev()">
                        </div>

                        <div class="numbers">
                            <template x-for="i in pages"
                                      :key="i">
                                <template x-if="i > page - 3 && i < page + 3">
                             <span x-text="i"
                                   x-on:click="setPage(i)"
                                   :class="{'pagination-item': true, number: true, active: i === page}"></span>
                                </template>
                            </template>
                        </div>

                        <div class="pagination-item pagination-item-next"
                             x-on:click="next()">
                        </div>
                    </div>
                </template>

            </div>
        </template>

    </div>
</template>
