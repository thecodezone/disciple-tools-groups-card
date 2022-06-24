<?php

/**
 * Your custom card class
 */
class DT_Groups_Dashboard_Card extends DT_Dashboard_Card {

    public function __construct( $handle, $label, $params = [] ) {

        parent::__construct( $handle, $label, $params );

        add_filter( 'script_loader_tag', [$this, 'defer_scripts'], 10, 3 );
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

    public function defer_scripts ( $tag, $handle ) {

        if ( $handle !== 'alpine.js' ) {
            return $tag;
        }

        return str_replace( ' src', ' defer src', $tag );
    }

    /**
     * Render the card
     */
    public function render() {
        $groups = DT_Posts::get_viewable_compact( 'groups', '' );
        $user = Disciple_Tools_Users::get_base_user( get_current_user_id() );
        $coach = $user;
        $card = $this;
        require( plugin_dir_path( __FILE__ ) . '../templates/groups-card.php' );
    }
}

/**
 * Next, register our class. This can be done in the after_setup_theme hook.
 */
DT_Dashboard_Plugin_Cards::instance()->register(
    new DT_Groups_Dashboard_Card(
        'groups',
        __( 'Groups', 'disciple-tools-groups-card' ),
        [
            'priority' => 1,
            'span'     => 1
        ]
    ) );
