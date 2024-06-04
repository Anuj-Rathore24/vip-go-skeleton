//Dependent functions
function appendAsyncJSTag(source){var scriptElement=document.createElement("script");scriptElement.src=source;scriptElement.async="async";document.head.appendChild(scriptElement)}
function getUrlParameter(e){e=e.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var r=new RegExp("[\\?&]"+e+"=([^&#]*)").exec(location.search);return null===r?"":decodeURIComponent(r[1].replace(/\+/g," "))}

/*!
 * Promise Polyfill v.8 - 
 * https://github.com/taylorhakes/promise-polyfill
 * Browser Support: IE8+, Chrome, Firefox, IOS 4+, Safari 5+, Opera
 * License: MIT */
!function(e,n){"object"==typeof exports&&"undefined"!=typeof module?n():"function"==typeof define&&define.amd?define(n):n()}(0,function(){"use strict";function e(){}function n(e){if(!(this instanceof n))throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=0,this._handled=!1,this._value=undefined,this._deferreds=[],f(e,this)}function t(e,t){for(;3===e._state;)e=e._value;0!==e._state?(e._handled=!0,n._immediateFn(function(){var n=1===e._state?t.onFulfilled:t.onRejected;if(null!==n){var i;try{i=n(e._value)}catch(f){return void r(t.promise,f)}o(t.promise,i)}else(1===e._state?o:r)(t.promise,e._value)})):e._deferreds.push(t)}function o(e,t){try{if(t===e)throw new TypeError("A promise cannot be resolved with itself.");if(t&&("object"==typeof t||"function"==typeof t)){var o=t.then;if(t instanceof n)return e._state=3,e._value=t,void i(e);if("function"==typeof o)return void f(function(e,n){return function(){e.apply(n,arguments)}}(o,t),e)}e._state=1,e._value=t,i(e)}catch(u){r(e,u)}}function r(e,n){e._state=2,e._value=n,i(e)}function i(e){2===e._state&&0===e._deferreds.length&&n._immediateFn(function(){e._handled||n._unhandledRejectionFn(e._value)});for(var o=0,r=e._deferreds.length;r>o;o++)t(e,e._deferreds[o]);e._deferreds=null}function f(e,n){var t=!1;try{e(function(e){t||(t=!0,o(n,e))},function(e){t||(t=!0,r(n,e))})}catch(i){if(t)return;t=!0,r(n,i)}}var u=function(e){var n=this.constructor;return this.then(function(t){return n.resolve(e()).then(function(){return t})},function(t){return n.resolve(e()).then(function(){return n.reject(t)})})},c=setTimeout;n.prototype["catch"]=function(e){return this.then(null,e)},n.prototype.then=function(n,o){var r=new this.constructor(e);return t(this,new function(e,n,t){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof n?n:null,this.promise=t}(n,o,r)),r},n.prototype["finally"]=u,n.all=function(e){return new n(function(n,t){function o(e,f){try{if(f&&("object"==typeof f||"function"==typeof f)){var u=f.then;if("function"==typeof u)return void u.call(f,function(n){o(e,n)},t)}r[e]=f,0==--i&&n(r)}catch(c){t(c)}}if(!e||"undefined"==typeof e.length)throw new TypeError("Promise.all accepts an array");var r=Array.prototype.slice.call(e);if(0===r.length)return n([]);for(var i=r.length,f=0;r.length>f;f++)o(f,r[f])})},n.resolve=function(e){return e&&"object"==typeof e&&e.constructor===n?e:new n(function(n){n(e)})},n.reject=function(e){return new n(function(n,t){t(e)})},n.race=function(e){return new n(function(n,t){for(var o=0,r=e.length;r>o;o++)e[o].then(n,t)})},n._immediateFn="function"==typeof setImmediate&&function(e){setImmediate(e)}||function(e){c(e,0)},n._unhandledRejectionFn=function(e){void 0!==console&&console&&console.warn("Possible Unhandled Promise Rejection:",e)};var l=function(){if("undefined"!=typeof self)return self;if("undefined"!=typeof window)return window;if("undefined"!=typeof global)return global;throw Error("unable to locate global object")}();l.Promise?l.Promise.prototype["finally"]||(l.Promise.prototype["finally"]=u):l.Promise=n});



// --------------------------------------------------------------------------
// IDG_CONSENT_CHECK
// --------------------------------------------------------------------------


/**
 * Get consent settings from idg_consent_check_setting variable declared in <head>
 * Check if settings object is missing, use default values
 **/
window.idg_consent_check_setting = window.idg_consent_check_setting || {
  consent_project: 'csw', 
  consent_domain: '',
  consent_disable_modal:false,
  consent_response_box: 1,
  consent_response_box_message: '',
  version: 'missing',
};


// Set consent settings and load consent plugin
window.IDG_CONFIGURATION = window.IDG_CONFIGURATION || {};
IDG_CONFIGURATION.consent_project = idg_consent_check_setting.consent_project;
IDG_CONFIGURATION.consent_disable_modal = (idg_consent_check_setting.consent_disable_modal === '1') ? true : false;
IDG_CONFIGURATION.consent_response_box = {};
IDG_CONFIGURATION.consent_response_box.enable = (idg_consent_check_setting.consent_response_box === '1') ? true : false;
IDG_CONFIGURATION.consent_response_box.message = idg_consent_check_setting.consent_response_box_message;

// Only set consent domain if site is not a .idg.se-subdomain
IDG_CONFIGURATION.consent_domain = (idg_consent_check_setting.consent_domain === '' && window.location.host.indexOf('idg.se') === -1 ) ? window.location.host : idg_consent_check_setting.consent_domain;



/**
 * IDG_CONSENT_CHECK will listen to the IDG Consent Plugin, 
 * it contains callback functions that will run when consent is fired. 
 *
 * IDG_CONSENT_CHECK.onGranted(callback);
 * IDG_CONSENT_CHECK.onRevoked(callback);
 * IDG_CONSENT_CHECK.onGrantedOrRevoked(callback(isGranted)); (isGranted = true/false)
 *
 * // These functions will insert pixels on consent = granted
 * IDG_CONSENT_CHECK.insertPixel({dc_ui:xxx,dc_seg:yyy})
 * IDG_CONSENT_CHECK.insertIframe({name:xxx,src=yyy})
 * IDG_CONSENT_CHECK.insertPixelFacebook(pixelID)
 * IDG_CONSENT_CHECK.insertPixelLinkedin(pixelID)
 * IDG_CONSENT_CHECK.insertPixelComscore()
 */
var IDG_CONSENT_CHECK = {

  // Version number
  version : idg_consent_check_setting.plugin_version,

  // External plugin src
  plugin_src : 'https://www.idg.se/idg-consent.min.js',

  // The IDG Consent plugin uses these variables for eventListners and localStorage (IDG_CONSENT.event and .storage should be the same)
  plugin : {
    'event' : {
      'action':   'idg-consent',        // fires on save consent action
      'limbo':    'idg-consent-limbo',  // fires by plugin initiation if no consent is saved  
      'stored':   'idg-consent-stored', // fires by plugin initiation if consent is saved
      'open':     'idg-consent-open',    // listener providing the consent modal
      'response': 'idg-consent-respons', // fires when user consent is set, but after modal and animation has finished
    },
    'storage' : {
      'name' : 'consent',
      'value' : {
          'granted':  'granted',
          'revoked':  'revoked',
          'limbo':    'limbo'
      }
    },
  },

  // Store promises here
  onRevokedPromise : null,
  onGrantedPromise : null,

  // Check local storage for if is granted and return boolean 
  isLocalStorageGranted: function () {
    var consentStatus = localStorage.getItem(this.plugin.storage.name);
    var isGranted     = (consentStatus === this.plugin.storage.value.granted) ? true : false;
    return isGranted;
  },

  // Log each event
  firedEventsLog : [],

  logEvent: function(action) {
    var consentStatus = localStorage.getItem(this.plugin.storage.name);
    this.consentStatus = consentStatus;
    this.firedEventsLog.push({
      'userAction':    (typeof action !== 'undefined' && action) ? true : false,
      'consentStatus': localStorage.getItem(this.plugin.storage.name),
      'timeStamp':     (new Date()).toLocaleTimeString(),
      'timeStampMs':   Date.now(),
    });
  },

  init: function () {

    var self = this;

    // Check if no promises is set
    if (self.onGrantedPromise === null && self.onRevokedPromise === null) {

      // On Granted promise
      self.onGrantedPromise = new Promise(function(resolve, reject) {

        // Wait for the 'consent-is-stored' event
        document.addEventListener(self.plugin.event.stored, function(e) {
          var isGranted = self.isLocalStorageGranted();
          if(isGranted) {
            self.logEvent();
            resolve(isGranted);
          }
        });

        // The action event is fired when the user makes a chioice, userAction = true
        document.addEventListener(self.plugin.event.action, function(e) {
          var isGranted = self.isLocalStorageGranted();
          if(isGranted) {
            self.logEvent(true);
            resolve(isGranted);

            // Should we need to reload page if user goes from revoked > granted?
            setTimeout(function() { console.log('userAction: revoked > granted')}, 2500);
          }
        });

      });

      // On Revoked promise
      self.onRevokedPromise = new Promise(function(resolve, reject) {

        // Wait for the 'consent-is-stored' event
        document.addEventListener(self.plugin.event.stored, function(e) {
          var isGranted = self.isLocalStorageGranted();
          if(!isGranted) {
            self.logEvent();
            resolve(isGranted);
          }
        });

        // The action event is fired when the user makes a chioice, userAction = true
        document.addEventListener(self.plugin.event.action, function(e) {
          var isGranted = self.isLocalStorageGranted();
          if(!isGranted) {
            self.logEvent(true);
            resolve(isGranted);
          }
        });

      });

      // Wait for the 'consent limbo event
      document.addEventListener(self.plugin.event.limbo, function(e) {
        self.logEvent();
      });
    }  
  },

  // Shorthand function that will run callback function on granted consent
  onGranted : function (callbackFunction) {

    // If promise is not set, run init()
    if (this.onGrantedPromise === null) this.init();    

    this.onGrantedPromise.then(function(isGranted) {
      if(isGranted) {
        callbackFunction();
      }
    });
  },

  // Shorthand function that will run callback function on revoked consent
  onRevoked : function (callbackFunction) {

    // If promise is not set, run init()
    if (this.onRevokedPromise === null) this.init();

    this.onRevokedPromise.then(function(isGranted) {
      if(!isGranted) {
        callbackFunction();
      }
    });
  },

  // This will run when either the granted or the revoked promises is resolved
  onGrantedOrRevoked : function(callbackFunction) {

    // Run init() if promises are not set
    if (this.onGrantedPromise === null && this.onRevokedPromise === null) this.init();

    Promise.race([this.onGrantedPromise, this.onRevokedPromise]).then(function(isGranted) {
        callbackFunction(isGranted);
    });
  },

  /**
   * Insert a pixel on consent = granted.
   * 
   * @param pixel {object} | string | int. The pixel argument can be an object,string or int, containing at least the segment id. 
   * If an object is supplied as argument, it should contain the props 'dc_seg' and 'dc_ui' {dc_ui: yyy, dc_seg: xxx}
   */
  insertPixel : function(pixel) {

    this.onGranted(function() {

      pixel = (typeof pixel === 'number') ? pixel.toString() : pixel;
      pixel = (typeof pixel === 'string') ? {'dc_seg':pixel} : pixel;  

      // Check if segment ID exists
      if(typeof pixel.dc_seg !== 'undefined' || pixel.dc_seg !== '') {

        // Default DFP network code is 8456
        pixel.dc_ui = (typeof pixel.dc_ui === 'undefined' || pixel.dc_ui === '') ? '8456' : pixel.dc_ui;

        // Remove 'DFPAudiencePixel' and all the '/', '?', ';'  from the string
        pixel.dc_ui = pixel.dc_ui.replace('DFPAudiencePixel', '');
        pixel.dc_ui = pixel.dc_ui.replace(/\//g, '');
        pixel.dc_ui = pixel.dc_ui.replace(/\;/g, '');

        pixel.dc_seg = pixel.dc_seg.replace(/\?/g, '');

        // Insert a pixel in the body (src="http://pubads.g.doubleclick.net/activity;dc_iu=/{dfp-network-code}/DFPAudiencePixel;ord=1;dc_seg={segment_ID}?")
        var a = Math.floor(Math.random()*(9999999));
        var pixelImg = document.createElement('img');
            pixelImg.style = 'display:none;';
            pixelImg.width = 1;
            pixelImg.height = 1;
            pixelImg.src = '//pubads.g.doubleclick.net/activity;dc_iu=/'+pixel.dc_ui+'/DFPAudiencePixel;ord='+a+';dc_seg='+pixel.dc_seg+'?';
            document.body.appendChild(pixelImg);
      }
      else {
        console.log('IDG_CONSENT_CHECK: tracking pixel missing segment ID (dc_seg)');
      }

    });
  },

  /**
   * Insert a iframe on consent = granted.
   * 
   * @param iframe {object} | string | int. The iframe argument can be an object or string, containing at least the iframe scr. 
   * If an object is supplied as argument, it should contain the props 'src' and 'name' {src: yyy, name: xxx}
   */
  insertIframe : function(iframe) {

    this.onGranted(function() {

      if(typeof iframe !== 'undefined' || iframe !== '') {

        // If iframe only contains the scr as a string
        iframe = (typeof iframe === 'string') ? {'src':iframe} : iframe;
        iframe.name = (typeof iframe.name === 'undefined') ? 'tracking iframe' : iframe.name;

        // Prepend //, if src is missing //
        iframe.src = (iframe.src.indexOf('//') === -1) ? '//' + iframe.src : iframe.src;

        var iframeElement = document.createElement('iframe');
            iframeElement.name = iframe.name;
            iframeElement.src  = iframe.src;
            iframeElement.style = 'width:0;height0;display:none;';
            document.body.appendChild(iframeElement);

      } else {
        console.log('IDG_CONSENT_CHECK: tracking iframe is missing src-attribute');
      }

    });
  },



  /**
   * Insert a facebook pixel on consent = granted.
   * 
   * @param pixelID string | int. The pixelID argument can be an string or int. (Example ID: 114844478880251)
   */
  insertPixelFacebook : function(pixelID) {

    // Wait for consent = granted
    this.onGranted(function() {

      // Check if segment ID exists
      if(typeof pixelID !== 'undefined' || pixelID !== '') {

        // If number
        pixelID = (typeof pixelID === 'number') ? pixelID.toString() : pixelID;

        // Load the facebook pixel
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', pixelID);
        fbq('track', 'PageView');
      }
      else {
        console.log('IDG_CONSENT_CHECK: Facebook pixel missing ID');
      }
    });
  },

  /**
   * Insert a Linkedin pixel on consent = granted.
   * 
   * @param partnerID string | int. The partnerID argument can be an string or int. (Example ID: 61326)
   */
  insertPixelLinkedin : function(partnerID) {

    // Wait for consent = granted
    this.onGranted(function() {

      // Check if segment ID exists
      if(typeof partnerID !== 'undefined' || partnerID !== '') {

        // If number
        partnerID = (typeof partnerID === 'number') ? partnerID.toString() : partnerID;

        window._linkedin_data_partner_id = partnerID; 
        (function(){ 
          var s = document.getElementsByTagName("script")[0];
          var b = document.createElement("script");
          b.type = "text/javascript";b.async = true;
          b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
          s.parentNode.insertBefore(b, s);
        })();

      }
      else {
        console.log('IDG_CONSENT_CHECK: Linkedin pixel missing Partner ID');
      }
    });
  },


  /**
   * Insert a comscore pixel on consent = granted.
   * 
   * @param comscoreID string | int. The comscoreID argument can be an string or int. The default ID: 6035308, will be used if undefined or empty.
   */
  insertPixelComscore : function(comscoreID) {
    // Wait for consent = granted
    this.onGranted(function() {
        // Set default ID
        comscoreID = (typeof comscoreID === 'undefined' || comscoreID === '') ? '6035308' : comscoreID;
        comscoreID = (typeof comscoreID === 'number') ? comscoreID.toString() : comscoreID;
        // Load the comscore pixel
        window._comscore=window._comscore||[];
        _comscore.push({c1:"2",c2:comscoreID}),function() {
        var a=document.createElement("script"),b=document.getElementsByTagName("script")[0];
        a.async=!0,a.src=("https:"==document.location.protocol?"https://sb":"http://b")+".scorecardresearch.com/beacon.js",b.parentNode.insertBefore(a,b)
        }();
    });
  },


}


// Run init function before the consent plugin has loaded to add all eventlistners
IDG_CONSENT_CHECK.init();

// Load consent plugin script, append version number
appendAsyncJSTag(IDG_CONSENT_CHECK.plugin_src + '?ver=' + IDG_CONSENT_CHECK.version); 
