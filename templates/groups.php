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

            <div class="pagination">
                <div class="pagination-item-prev"
                     x-on:click="store.prev()">
                </div>

                <div class="numbers">
                    <span class="active">1</span>
                    <span>2</span>
                    <span>3</span>
                </div>

                <div class="pagination-item-next"
                     x-on:click="store.next()">
                </div>
            </div>

        </div>
    </div>
</template>
