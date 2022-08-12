<?php

class PluginTest extends TestCase
{
    public function test_plugin_installed() {
        activate_plugin( 'disciple-tools-groups-tile/disciple-tools-groups-tile.php' );

        $this->assertContains(
            'disciple-tools-groups-tile/disciple-tools-groups-tile.php',
            get_option( 'active_plugins' )
        );
    }
}
