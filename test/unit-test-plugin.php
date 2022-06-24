<?php

class PluginTest extends TestCase
{
    public function test_plugin_installed() {
        activate_plugin( 'disciple-tools-groups-card/disciple-tools-groups-card.php' );

        $this->assertContains(
            'disciple-tools-groups-card/disciple-tools-groups-card.php',
            get_option( 'active_plugins' )
        );
    }
}
