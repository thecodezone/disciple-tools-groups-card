<div class="typeahead__container"
     x-data="groups_card_leader_filter">
    <div class="typeahead__field">
                    <span class="typeahead__query">
                        <input x-ref="filter_field"
                               class="input-height"
                               name="leader_filter"
                               placeholder="<?php echo esc_html_x( "Filter by ", 'input field placeholder', 'disciple_tools_groups_card' ) . esc_html($leaders_label);  ?>"
                               autocomplete="off">
                     </span>
    </div>
</div>
