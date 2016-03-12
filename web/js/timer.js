var Visualnet = Visualnet || {};
var jQuery = jQuery || {};
var _ = _ || {};

/**
 * Timer class constructor
 * 
 * @class Visualnet.Timer
 * @constructor 
 * @namespace Visualnet
 * @author w.kowalik 
 * @access public
 * 
 * @copyright visualnet.pl 2012
 */

Visualnet.Timer = function (options, redirect) {
        
    "use strict";

    /**
    * Session timeout value
    * 
    * @property _sessionTimeout
    * @type Integer
    * @default 15
    */
    var _sessionTimeout = 15;

    /**
    * Actual timeout
    * 
    * @property _timeout
    * @type Integer
    */
    var _timeout;
    
    /**
    * Handler for timer id
    * 
    * @property _timerId
    * @type Object
    */
    var _timerId;

    /**
    * Constraint of use new operator
    */
    if (!(this instanceof Visualnet.Timer)) {
        return new Visualnet.Timer(options);
    }
    
    /**
     * Init method after create instance
     * 
     * @method init
     * @return void
     */
    (function init() {
        
        // if options object exists
        if (jQuery.isPlainObject(options)) {

            // override
            if (options.sessionTimeout) {
                _sessionTimeout = options.sessionTimeout;
            }
        }
        
     })();

    /**
    * Singelton
    */
    if (typeof Visualnet.Timer.instance === "undefined") {
        Visualnet.Timer.instance = this;
    } else {
        return Visualnet.Timer.instance;
    }
      

    /**
    * Single time tick method
    * 
    * @method _tick
    * @access private
    * @return void
    */
    var _tick = function () {

        var minutes = Math.floor(_timeout / 60),
            seconds = _timeout % 60;

        if (minutes.toString().length === 1) {
            minutes = '0' + minutes;
        }
            
        if (seconds.toString().length === 1) {
            seconds = '0' + seconds;
        }

        jQuery("#timer").html(minutes + "m:" + seconds + "s");
        _timeout--;

        if (_timeout <= 0) {

            clearInterval(_timerId);
            
            // if redirect exists
            if (redirect !== undefined) {
                location.href = redirect;
            }
            
            return;

        }
    };

    /**
    * Get raw time data
    * 
    * @method getTimeout
    * @access public
    * @return void
    */
    this.getTimeout = function () {
        jQuery("#timer").html(_sessionTimeout + "m:" + seconds + "00s");
    };

    /**
    * Timer init
    * 
    * @method init
    * @access public
    * @return void
    */
    this.make = function () {
    
        if (_timerId !== undefined) {
          clearInterval(_timerId);
        }
        
        _timeout = _sessionTimeout * 60;
        _timerId = setInterval(function () {_tick(); }, 1000);
        
    };
                    
};