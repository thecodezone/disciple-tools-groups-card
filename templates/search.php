<div class="search-container"
     x-data="groups_card_search">
    <form x-on:submit.prevent="search">
        <input type="text"
               placeholder="Search..."
               x-model="store.text"
               name="search">
        <button type="submit"><?php echo _e('Search', 'disciple_tools_groups_card'); ?></button>
    </form>
</div>
