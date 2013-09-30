/**
 *   Copyright 2013 Barry Oosthuizen http://www.elearningstudio.co.uk
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 */

/*
 *  Based on example code from
 *  https://code.google.com/p/gmaps-samples-v3/source/browse/trunk/geocoder/v3-geocoder-tool.html
 *  Copyright 2010 Google Inc.
 *
 *  Modified to work with YUI in Moodle as part of the GPS Pro course format by Barry Oosthuizen 2013
 * */

YUI.add('moodle-format_gps-popupgeo', function(Y) {
    var POPUPGEONAME = 'gps_popupgeo';
    var popupgeo = function() {
        popupgeo.superclass.constructor.apply(this, arguments);
    };

    var MAPFILES_URL = "http://maps.gstatic.com/intl/en_us/mapfiles/";
    var map = null;
    var shadow = null;
    var clickIcon = null;

    Y.extend(popupgeo, Y.Base, {
        initializer : function () {

            Y.one('#updatepositionclick').removeClass('hide');

            // Try HTML5 geolocation
            if(navigator.geolocation) {

                var mapOptions = {
                    'zoom': (17),
                    'center': (new google.maps.LatLng(50.0,0.0)),
                    'mapTypeId': google.maps.MapTypeId.ROADMAP,
                    'scaleControl': true
                }

                var map = new google.maps.Map(document.getElementById("map"), mapOptions);

                // Resize stuff...
                google.maps.event.addDomListener(window, "resize", function() {
                    var center = map.getCenter();
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(center);
                })

                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude,
                    position.coords.longitude);
                    map.setCenter(pos);
                    geocode({
                        'latLng': pos
                    });

                }, function() {
                    this.handleNoGeolocation(true);
                });

            } else {
                // Browser doesn't support Geolocation
                this.showError(false);
            }

            clickIcon = new google.maps.MarkerImage(
            MAPFILES_URL + 'dd-start.png',
            new google.maps.Size(20, 34),
            new google.maps.Point(0, 0),
            new google.maps.Point(10, 34)
        );

            var geocode = function(request) {

                if (request.latLng) {
                    clickMarker = new google.maps.Marker({
                        'position': request.latLng,
                        'map': map,
                        'title': request.latLng.toString(),
                        'clickable': true,
                        'icon': clickIcon,
                        'shadow': shadow
                    });

                }
                request.bounds = map.getBounds();
            }

            // end of search box code
        },

        handleNoGeolocation : function(errorFlag) {
            if (errorFlag) {
                var content = 'Error: The Geolocation service failed.';
            } else {
                var content = 'Error: Your browser doesn\'t support geolocation.';
            }
            var options = {
                map: map,
                position: new google.maps.LatLng(60, 105),
                content: content
            };
        },

        // Only false is ever passed so other errors will never be displayed?
        showError : function(error){
            switch(error.code){
                case error.PERMISSION_DENIED:
                    x.innerHTML="User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML="Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML="The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML="An unknown error occurred."
                    break;
            }
        }

    }, {
        NAME : POPUPGEONAME,
        ATTRS : {
            maxheight : {
                value : 800
            }
        }
    });
    M.format_gps = M.format_gps || {}; // This line use existing name path if it exists, otherwise create a new one.
    // This is to avoid to overwrite previously loaded module with same name.
    M.format_gps.init_popupgeo = function() { // 'config' contains the parameter values
        return new popupgeo(); // 'config' contains the parameter values
    };
}, '@VERSION@', {
    requires:['event']
});

YUI().use('event', 'transition', 'panel', function(Y) {
    // wait until the user focuses on an input element to start loading assets
    Y.on("click", function(e) {

        panel.show();

        Y.one('#popupgeo').removeClass('popupgeo');
        M.format_gps.init_geo();
        M.format_gps.init_popupgeo();

    }, "#updatepositionclick");

    // Create the main modal form.
    var panel = new Y.Panel({
        srcNode      : '#popupgeo',
        headerContent: 'Your position',
        zIndex       : 5,
        xy           : [50, 50],
        modal        : true,
        lightbox     : true,
        visible      : false,
        render       : true,
        plugins      : [Y.Plugin.Drag]
    });
});
