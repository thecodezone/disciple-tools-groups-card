<?php

/**
 * Your custom card class
 */
class DT_Groups_Dashboard_Card extends DT_Dashboard_Card {
    public function __construct( $handle, $label, $params = [] ) {

        parent::__construct( $handle, $label, $params );

        add_filter( 'script_loader_tag', [ $this, 'defer_alpine' ], 10, 3 );
    }

    /**
     * Register any assets the card needs or do anything else needed on registration.
     * @return mixed
     */
    public function setup() {
        wp_enqueue_script( 'alpine.js', 'https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js', [], '3.10.2', true );
        wp_enqueue_script( 'groups-card', plugin_dir_url( __FILE__ ) . '../src/groups-card.js', [ 'alpine.js' ], filemtime( plugin_dir_path( __FILE__ ) . '../src/groups-card.js' ) );
        wp_enqueue_style( 'groups-card', plugin_dir_url( __FILE__ ) . '../src/groups-card.css', [], filemtime( plugin_dir_path( __FILE__ ) . '../src/groups-card.css' ) );
    }

    public function defer_alpine( $tag, $handle ) {

        if ( $handle !== 'alpine.js' ) {
            return $tag;
        }

        return str_replace( ' src', ' defer src', $tag );
    }

    /**
     * Render the card
     */
    public function render() {
        //We only want to list 6 groups.
        $groups = DT_Posts::list_posts( 'groups', [], true );
        $groups['posts'] = array_slice( $groups['posts'], 0, 6 );

        //Assume the current user's contact is the coach at load
        $coach = DT_Posts::get_post( 'contacts', Disciple_Tools_Users::get_contact_for_user( get_current_user_id() ) );

        //The card data
        $card = $this;

        require( plugin_dir_path( __FILE__ ) . '../templates/groups-card.php' );
    }
}

if ( current_user_can( 'access_groups' ) ) {
    DT_Dashboard_Plugin_Cards::instance()->register(
        new DT_Groups_Dashboard_Card(
            'groups',
            __( 'Groups', 'disciple-tools-groups-card' ),
            [
                'priority' => 1,
                'span'     => 1
            ]
        ) );
}
