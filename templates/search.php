<div class="search-container"
     x-data="groups_card_search">
    <form x-on:submit.prevent="search">
        <input type="text"
               placeholder="Search..."
               x-model="text"
               name="search">
        <button type="submit">Search</button>
    </form>
</div>
