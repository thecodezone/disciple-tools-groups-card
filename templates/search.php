<div class="search__container"
     x-data="groups_tile_search">
    <form x-on:submit.prevent="search">
        <div class="search__input-group input-group">
          <span class="search__input-label input-group-label">
            <i class="fi-magnifying-glass"></i>
          </span>
            <input class="input-group-field"
                   type="text"
                   placeholder="Search..."
                   x-model="store.text"
                   name="search">
            <button type="submit"><?php esc_html_e( 'Search', 'disciple_tools_groups_tile' ); ?></button>
        </div>
    </form>
</div>
