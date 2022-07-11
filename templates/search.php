<div class="search-container"
     x-data="groups_card_search">
    <form x-on:submit.prevent="search">
        <input type="text"
               placeholder="Search..."
               x-model="store.text"
               name="search">
        <button type="submit"><?php echo _e('Search', 'disciple_tools_groups_card'); ?></button>
    </form>

    <template x-if="store.numResults !== null">
        <div class="result-count">
            <span x-text="store.numResults"></span> <?php echo _e('Results Returned', 'disciple_tools_groups_card'); ?>
        </div>
    </template>
</div>
