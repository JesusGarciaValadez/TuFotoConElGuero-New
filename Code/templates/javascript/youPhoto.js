/**
 *
 *  @function
 *  @description:   Anonimous function autoexecutable
 *  @params jQuery $.- An jQuery object instance
 *  @params window window.- A Window object Instance
 *  @author: @_Chucho_
 *
 */
( function( $, window, undefined ) {

    var _yourPhoto    = window._yourPhoto,

    // Use the correct document accordingly with window argument (sandbox)
    document = window.document,
    location = window.location,
    navigator = window.navigator,

    // Map over yourPhoto in case of overwrite
    _yourPhoto    = window.yourPhoto;

    // Define a local copy of yourPhoto
    yourPhoto = function() {
        if ( !( this instanceof yourPhoto ) ) {

            // The yourPhoto object is actually just the init constructor 'enhanced'
            return new yourPhoto.fn.init();
        }
        return yourPhoto.fn.init();
    };

    //  Object prototyping
    yourPhoto.fn = yourPhoto.prototype = {
        /**
         *
         *  @function:  !constructor
         *  @description:   Constructor method
         *  @author: @_Chucho_
         *
         */
        //  Método constructor
        constructor:    yourPhoto,
        /**
         *
         *  @function:  !init
         *  @description:   Inicializer method
         *  @author: @_Chucho_
         *
         */
        //  !Método inicializador
        init:   function ( ) {
            if ( window.matchMedia( "(min-width: 400px)" ).matches ) {
                /* the view port is at least 400 pixels wide */
                if ( '.header nav ul li a' ) {
                    //  Crea las instancias de jScrollPane para los elementos que simulan
                    //  ser select tags
                    yourPhoto.makeScrollBar( $( '.select_inventories_options .mask' ) );

                    //  Trigger para emular el comportamiento de combo box
                    $( '.selected' ).on( 'click', function ( e ) {

                        e.preventDefault();
                        e.stopPropagation();
                        if ( $( e.currentTarget ).siblings( '.select_inventories_options' ).css( 'opacity' ) == '0' ) {

                            $( e.currentTarget ).siblings( '.select_inventories_options' ).css( {
                                display: 'none',
                                opacity: '1',
                                filter: ''
                            } );
                        }
                        $( e.currentTarget ).siblings( '.select_inventories_options' ).slideToggle( 'fast' );
                    } );

                    $( 'body' ).on( 'click', function ( e ) {

                        e.stopPropagation();
                        $( '.select_inventories_options' ).slideUp( 'fast' );
                    } );

                    //  Almacena la opción escogida y la almacena en un input hidden
                    $( '.jspPane ul li' ).on( 'click', function ( e ) {

                        $( e.currentTarget ).parents( '.select_inventories' ).children( 'input' ).val( '' );

                        var _text   = $( e.currentTarget ).text();
                        var _rel   = $( e.currentTarget ).attr( 'rel' );

                        $( e.currentTarget ).parents( '.select_inventories' ).children( 'input' ).val( _rel );

                        if ( $( e.currentTarget ).parents( '#inventories_date_range_to_wrapper' ).length != 0 ) {

                            yourPhoto.dateTo     = _text;
                        } else if ( $( e.currentTarget ).parents( '#inventories_date_range_from_wrapper' ).length != 0 ) {

                            yourPhoto.dateFrom   = _text;
                        }

                        $( e.currentTarget ).parents( '.select_inventories' ).children( '.selected' ).text( _text );

                        $( e.currentTarget ).parents( '.select_inventories' ).children( '.selected' ).click();
                    } );
                }
            } else {
                /* the view port is less than 400 pixels wide */
            }
        },
        /**
         *
         *  @function:  !makesUniform
         *  @description:   Makes the uniform effect to radius and checkbox
         *  @params jQuery selector.- A jQuery Selector
         *  @see:   http://uniformjs.com/
         *  @author: @_Chucho_
         *
         */
        //  !Crea un efecto para poder dar estilos a los elementos checkbox,
        //  radio, file y select
        makesUniform:   function ( selector ) {

            selector.uniform();
        },
        /**
         *
         *  @function:  !anchorMenu
         *  @description:   Anchor the menu
         *  @params jQuery selectorToApply.- A jQuery Selector
         *  @params Object toFix.- An object with css properties to apply to the
         *                         jQuery selector
         *  @params Object toDeFix.- An object with css properties to apply to
         *                         the jQuery selector
         *  @author: @_Chucho_
         *
         */
        //  !Ancla el menú cuando a una altura determinada mediante css
        anchorMenu: function ( selectorToApply, toFix, toDeFix ) {

            yourPhoto.tool = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

            if ( yourPhoto.tool >= 540 ) {

                selectorToApply.css( toFix );
            } else {

                selectorToApply.css( toDeFix );
            }
        },
        /**
         *
         *  @function:  !smoothScroll
         *  @description:   Do smooth scroll for the anchors in menu
         *  @params jQuery selector.- A jQuery Selector
         *  @params Number durationInSec.- A number to indicate the duration of
         *                                 the animation
         *  @see:   http://flesler.blogspot.com/2007/10/jqueryscrollto.html
         *  @author: @_Chucho_
         *
         */
        //  !Realiza el efecto para dar la impresión de scroll "suavizado"
        smoothScroll:   function ( selector, durationInSec ) {

            var scrollYOffset   = 0;

            scrollYOffset   = $( '#' + selector ).offset();
            scrollYOffset   = Math.ceil ( Number( scrollYOffset.top ) );
            if ( $( '#main_menu' ).height() <= 100 ) {

                scrollYOffset   += - 100;
            } else {

                scrollYOffset   += - 205;
            }
            $.scrollTo( scrollYOffset, {
                duration: durationInSec,
                axis: 'y'
            } );
        },
        /**
         *
         *  @function:  !toggleValue
         *  @description:   Does toggle if the input have a value or if doesn't
         *  @params jQuery selector.- A jQuery Selector
         *  @params String valueChange.- A String with the value to change or preserve
         *  @author: @_Chucho_
         *
         */
        //  !Revisa si el valor de un input es el original o no y lo preserva o
        //  respeta el nuevo valor.
        toggleValue:    function ( selector, valueChange ) {

            if ( selector.val( ) == '' ) {

                selector.val( valueChange ).css( {
                    color: '#aaa'
                } );
            }
            selector.on( {
                focus: function( e ) {

                    if ( selector.val( ) == String( valueChange ) ) {
                        selector.val( '' ).css( { color: '#666' } );
                        return false;
                    }
                },
                blur: function( e ) {
                    if ( selector.val( ) == '' ) {
                        selector.val( valueChange ).css( {
                            color: '#aaa'
                        } );
                        return false;
                    }
                }
            } );

        },
        /**
         *
         *  @function:  makeScrollBar
         *  @description:  Make jScrollPane where is needed
         *  @params jQuery selector.- A jQuery Selector
         *  @params Object options.- A JSON object with the options to make a
         *                           target element a jScrollPane Element
         *  @author: @_Chucho_
         *  @see:   http://www.jscrollpane.kelvinluck.com/
         *
         */
        //  !Crea un elemento jScrollPane.
        makeScrollBar:  function ( selector, options ) {

            var _options    = ( options == undefined ) ? {} : options;

            // the element we want to apply the jScrollPane
            selector.jScrollPane( _options );
        },
        validateRequired: function (element, txt, msg) {
          var elementValidate = $( '#' + element )

          if ( elementValidate.val() == txt || /^\s+$/.test(elementValidate.val()) ) {
            elementValidate.removeClass( 'error' );
            elementValidate.parent().children( '.txtError' ).remove( );
            elementValidate.parent().children( '.errorValidate' ).remove( );

            elementValidate.addClass( 'error' );
            elementValidate.parent().prepend( '<label class="txtError">' + msg + '</label>' );
            elementValidate.parent().prepend( '<div class="errorValidate"></div>' );
            return false;
          }
          else{
            elementValidate.removeClass( 'error' );
            elementValidate.parent().children( '.txtError' ).remove( );
            elementValidate.parent().children( '.errorValidate' ).remove( );
          }
          return true;
        },
        validatePhone: function (element, txt, msg) {

            var elementValidate = $( '#' + element );
            if ( elementValidate.val() == txt || /^\s+$/.test(elementValidate.val()) || !(/^\d{10}$/.test(elementValidate.val())) ) {

                elementValidate.removeClass( 'error' );
                elementValidate.parent().children( '.txtError' ).remove( );
                elementValidate.parent().children( '.errorValidate' ).remove( );
                elementValidate.addClass( 'error' );
                elementValidate.parent().prepend( '<label class="txtError">' + msg + '</label>' );
                elementValidate.parent().prepend( '<div class="errorValidate"></div>' );
                return false;
            }else{

                elementValidate.removeClass( 'error' );
                elementValidate.parent().children( '.txtError' ).remove( );
                elementValidate.parent().children( '.errorValidate' ).remove( );
            }
            return true;
        },
        validateEmail: function (element, txt, msg) {
          var elementValidate = $( '#' + element )

          if( !(/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(elementValidate.val())) ) {
            elementValidate.removeClass( 'error' );
            elementValidate.parent().children( '.txtError' ).remove( );
            elementValidate.parent().children( '.errorValidate' ).remove( );

            elementValidate.addClass( 'error' );
            elementValidate.parent().prepend( '<label class="txtError">' + msg + '</label>' );
            elementValidate.parent().prepend( '<div class="errorValidate"></div>' );
            return false;
          }
          else{
            elementValidate.removeClass( 'error' );
            elementValidate.parent().children( '.txtError' ).remove( );
            elementValidate.parent().children( '.errorValidate' ).remove( );
          }
          return true;
        }
    };

    // Give the init function the yourPhoto prototype for later instantiation
    yourPhoto.fn.init.prototype = yourPhoto.fn;

    yourPhoto = yourPhoto.fn;

    // Expose yourPhoto to the global object

    window.yourPhoto  = yourPhoto;

} )( jQuery, window );