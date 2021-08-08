<?php
/*
 * Displaying Past Events for The Events Calendar WordPress Plugin by Modern Tribe
 * @author: Sasky
 * @url: https://github.com/saskysamonte/past-events-for-the-events-calendar/
 * @version: 1.0.0
*/


//Past Events Archive Function
function ssky_get_past_events($per_page, $archive = false) {
    
    $events = tribe_get_events( array(
        'posts_per_page' => $per_page,
        'eventDisplay' => 'past',
        'start_date' => '',
        'end_date' => date("Y-m-d"),
    ) );
    
    ?>
    <div class="ssky-custom-events">
        <div class="ssky-custom-events__title-bar">
            <h1>Past Events</h1>
        </div>
    
        <?php foreach ($events as $post) { ?>
            <div class="ssky-custom-events__list">
                <div class="ssky-custom-events__title">
                    <a href="<?= tribe_get_event_link( $post->ID ) ?>" title="<?= $post->post_title ?>" rel="bookmark"><?= $post->post_title ?></a>
                </div>
                
                <div class="ssky-custom-events__datetime">
        			<span><?= tribe_events_event_schedule_details( $post ) ?></span>		
        		</div>
        		
        		 <div class="ssky-custom-events__image">
        		    <a href="<?= tribe_get_event_link( $post->ID ) ?>">
        		        <?= get_the_post_thumbnail( $post, 'large' ) ?>
        		    </a>
        		 </div>
        		 
        		<div class="ssky-custom-events__summary-content">
        		    <?= tribe_events_get_the_excerpt( $post, wp_kses_allowed_html( 'post' ) ); ?>
        		    <a href="<?= tribe_get_event_link( $post->ID ) ?>" class="ssky-custom-events__readmore" rel="bookmark">Find out more »</a>
        		</div>
            </div>
        <?php  }  ?>
        
        <?php if( $archive ) { ?>
            <div class="ssky-custom-events__past-btn">
                <a href="<?= site_url() ?>/past-events">View all</a>
            </div>
        <?php } ?>
    </div>
    
    
    <?php
    
}

//Past events archive page shortcode
add_shortcode( 'ssky_custom_events_past_events_archive', 'ssky_custom_events_past_events_archive' );
function ssky_custom_events_past_events_archive() {
    ob_start();
    ssky_get_past_events(5, false);
    return ob_get_clean();
}

//Display after Tribe events template the Past events
add_action( 'tribe_events_after_template', 'display_past_events_after_template', 10, 3 );
function display_past_events_after_template() {
    ssky_get_past_events(5, true);
}


//Past events Grid layout
function ssky_get_past_events_grid_layout($per_page, $archive = false) {
    $events = tribe_get_events( array(
        'posts_per_page' => $per_page,
        'eventDisplay' => 'past',
        'start_date' => '',
        'end_date' => date("Y-m-d"),
    ) );
    
    ?>
    <div class="ssky-custom-events-grid-layout">
        <div class="event-headings">
            <h2 class="h2-events">Past Events/</h2>
            <p class="view-all-events"><a href="<?= site_url() ?>/past-events/">View all Past Events</a></p>
        </div>
        <div class="event-container">
            <?php foreach ($events as $post) { ?>
            <div class="event-item">
                <div class="event-img">
                    <?= get_the_post_thumbnail( $post, 'large' ) ?>
                </div>
                <div class="event-title">
                    <?= $post->post_title ?>
                </div>
                
                <div>
                    <a href="<?= tribe_get_event_link( $post->ID ) ?>" class="btn-purple" style="padding:10px 20px">Read More</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php
}

//Shortcode for Past events Grid layout
add_shortcode( 'ssky_custom_events_past_events_grid_layout', 'ssky_custom_events_past_events_grid_layout' );
function ssky_custom_events_past_events_grid_layout() {
    ob_start();
    if ( current_user_can( 'manage_options' ) ) {
        ssky_get_past_events_grid_layout(4, false);
    } 
    return ob_get_clean();
}