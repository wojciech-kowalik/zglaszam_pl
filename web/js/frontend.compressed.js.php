<?php 
/*------------------------------------------------------------------------
# author    visualnet.pl
# copyright Copyright © 2012 zglaszam.pl. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.zglaszam.pl
-------------------------------------------------------------------------*/

/* initialize ob_gzhandler to send and compress data */
ob_start ("ob_gzhandler");
/* initialize compress function for whitespace removal */
ob_start("compress");
/* required header info and character set */
header("Content-type: application/x-javascript");
/* cache control to process */
header("Cache-Control: must-revalidate");
/* duration of cached content (1 hour) */
$offset = 60 * 60 ;
/* expiration header format */
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
/* send cache expiration header to browser */
header($ExpStr);

require('jquery-ui-1.8.24.custom.min.js');
require('lightbox.js');
require('modal.js');
require('jquery.lazyload.js');
require('main.js');
require('jquery.tipsy.js');
require('jquery.validationengine.js');
require('../bundles/fosjsrouting/js/router.js');
require('jquery.slider.js');
require('cufon-yui.js');
require('myriad.font.js');
//require('google.js');
require('underscore.js');
require('muscula.js'); 


?>