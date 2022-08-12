<div class="typeahead__container"
     x-data="groups_tile_leader_filter">
    <div class="typeahead__field">
                    <span class="typeahead__query">
                        <div class="typeahead__input-group input-group">
                          <span class="typeahead__input-group-label input-group-label">
                            <i class="fi-filter"></i>
                          </span>
                              <input x-ref="filter_field"
                                     class="typeahead__input input-height"
                                     name="leader_filter"
                                     placeholder="<?php echo esc_html_x( "Filter by ", 'input field placeholder', 'disciple_tools_groups_tile' ) . esc_html( $user_label ); ?>"
                                     autocomplete="off">
                        </div>
                     </span>
    </div>
</div>
