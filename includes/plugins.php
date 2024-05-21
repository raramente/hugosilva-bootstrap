<?php

// Removes autop from contact form 7.
add_filter( 'wpcf7_autop_or_not', '__return_false' );