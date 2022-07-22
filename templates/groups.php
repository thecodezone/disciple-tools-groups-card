<!-- THE GROUP LISTING VIEW -->
<template x-data="groups_card_listing"
          x-if="!store.group">
    <div id="listing">

        <?php include( 'search.php' ); ?>
        <?php include( 'user-filter.php' ); ?>

        <div class="filtering-by-contact">
            <span><?php echo esc_html( $groups_label ) . ' for' ?></span>
            <h2 x-text="store.user.name"></h2>
        </div>


        <div class="groups">
            <template x-if="store.hasSearched">
                <div class="result-count">
                    <span x-text="store.numResults"></span> <?php echo esc_html( 'Results Returned', 'disciple_tools_groups_card' ); ?>
                </div>
            </template>

            <template x-for="group in store.groups.posts"
                      :key="group.ID">
                <div class="group"
                     x-on:click="store.setGroup(group)">
                    <div class="text">
                        <h3 x-text="group.post_title"></h3>
                        <!-- TO GET THE LOCATION SHOW UP, YOU NEED TO SET A LOCATION IN THE GROUP SETTINGS -->
                        <template x-if="group?.location_grid && group.location_grid.length">
                            <p class="location"
                               x-text="group.location_grid[0].label"
                            ></p>
                        </template>
                    </div>
                    <span class="fi-info"></span>
                </div>
            </template>

            <template x-if="store.groups.total">
                <div class="pagination">
                    <div class="pagination-item pagination-item-prev"
                         x-on:click="store.prev()">
                    </div>

                    <div class="numbers">
                        <template x-for="i in store.pages"
                                  :key="i">
                            <template x-if="i > store.page - 3 && i < store.page + 3">
                             <span x-text="i"
                                   x-on:click="store.setPage(i)"
                                   :class="{'pagination-item': true, number: true, active: i === store.page}"></span>
                            </template>
                        </template>
                    </div>

                    <div class="pagination-item pagination-item-next"
                         x-on:click="store.next()">
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
