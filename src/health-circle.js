/**
 * This is ripped from https://github.com/DiscipleTools/disciple-tools-theme/blob/ced1e98c0de7d022b3ba81dd28dcfd97713a8175/dt-groups/groups.js
 * and modified to allow it to be called as a function instead of on load.
 *
 * It might be nice to extract the theme JS a callable function like the one below in the core theme at some point.
 * Changes to the core JS or template could lead to a breakage.
 *
 * @param post
 */
const initChurchHealthCircle = (post) => {
  let post_id        = post.ID;
  let post_type      = churchHealthSettings.post_settings.post_type;
  let field_settings = churchHealthSettings.post_settings.fields;

  /* Health Metrics */
  let health_keys = Object.keys(field_settings.health_metrics.default);

  function fillOutChurchHealthMetrics() {
    let practiced_items = post.health_metrics || [];

    /* Make church commitment circle green */
    if ( practiced_items.indexOf( 'church_commitment' ) !== -1 ) {
      $('#health-items-container').addClass( 'committed' );
      $('#is-church-switch').prop('checked', true);
    }

    /* Color church circle items that are being practiced */
    let items = $( 'div[id^="icon_"]' );

    items.each( function( k, v ) {
      if ( practiced_items.indexOf( v.id.replace( 'icon_', '' ), practiced_items ) !== -1 ) {
        $( this ).children( 'img' ).attr( 'class','practiced-item' );
      }
    });

    /* Color group progress buttons */
    let icons = $( '.group-progress-button' );
    icons.each( function( k, v ) {
      if ( practiced_items.indexOf( v.id, practiced_items ) !== -1 ) {
        $( this ).addClass( 'practiced-button' );
      }
    });
  }

  fillOutChurchHealthMetrics();
  distributeItems();

  /* Dynamically distribute items in Church Health Circle
     according to amount of health metric elements */
  function distributeItems() {
    let radius = 75;
    let items = $( '.health-item' ),
      container = $( '#health-items-container' ),
      item_count = items.length,
      fade_delay = 45,
      width = container.width(),
      height = container.height() + 66,
      angle = 0,
      step = (2*Math.PI) / items.length,
      y_offset = -35;

    if ( item_count >= 5 && item_count < 7 ) {
      radius = 90;
    }

    if ( item_count >= 7 & item_count < 11 ) {
      radius = 100;
    }

    if ( item_count >= 11 ) {
      radius = 110;
    }

    if ( item_count == 3 ) {
      angle = 22.5;
    }

    items.each(function() {
      let X = Math.round( width / 2 + radius * Math.cos(angle) - $( this ).width() / 2 );
      let y = Math.round( height / 2 + radius * Math.sin(angle) - $( this ).height() / 2 ) + y_offset;

      if ( item_count == 1 ) {
        X = 112.5;
        y = 68;
      }

      $(this).css({
        left: X + 'px',
        top: y + 'px',
      });
      $(this).delay(fade_delay).fadeIn( 1000, 'linear' );
      angle += step;
      fade_delay += 45;
    });
  }
  /* End Health Metrics*/
}
