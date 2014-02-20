/**
 *
 *  @function
 *  @description:   Anonimous function autoexecutable
 *  @params jQuery $.- An jQuery object instance
 *  @params window window.- A Window object Instance
 *  @author: @_Chucho_
 *
 */
(function ( $, window, document, undefined ) {
    
    var _TFG    = window._TFG,
    // Use the correct document accordingly with window argument (sandbox)
    document = window.document,
    location = window.location,
    navigator = window.navigator,
    // Map over TFG in case of overwrite
    _TFG    = window.TFG;
    var overlay,
    opacidad        = 0,
    verde           = new Array(),
    gris            = new Array(),
    boxes           = new Array('11', '21', '31', '41', '12', '22', '32', '42', '13', '23', '33', '43'),
    crossv          = false,
    crossg          = false,
    imgv            = false,
    imgg            = false,
    ScrollableMenu  = false,
    counter         = 0,
    icounter        = 0;
    
    // Define a local copy of TFG
    TFG = function() {
        if ( !( this instanceof TFG ) ) {
            // The TFG object is actually just the init constructor 'enhanced'
            return new TFG.fn.init();
        }
        return TFG.fn.init();
    };
    //  Object prototyping
    TFG.fn = TFG.prototype = {
        /**
         *
         *  @function:  !constructor
         *  @description:   Constructor method
         *  @author: @_Chucho_
         *
         */
        //  Método constructor
        constructor:    TFG,
        /**
         *
         *  @function:  !init
         *  @description:   Inicializer method
         *  @author: @_Chucho_
         *
         */
        //  !Método inicializador
        init:   function ( ) {
            TFG.obtainActualDocument();
            
            /**
             *  Function to detect the id of document by param and set current element on menu
             *
             */ 
            var Url = String( location.href );
            if ( Url.search( /\.php|\.html/i ) ) {
                
                Url = Url.replace(/.*\?(.*?)/,"$1");
                Variables = Url.split ("&");
                for ( i = 0; i < Variables.length; i++ ) {
                    
                    Separ   = Variables[ i ].split( "=" );
                    if ( Separ[ 1 ] != undefined && Separ[ 1 ] != null ) {
                        
                        eval ('var ' + Separ[ 0 ] + '="' + Separ[ 1 ] + '"' );
                    }
                }
                
                if ( !anio ) {
                    
                    var anio    = '';
                }
                if ( !mes ) {
                    
                    var month   = new Date();
                    month.getMonth() + 1;
                    var mes     = String ( month );
                }
                switch( mes ) {
                    case '0':
                    default:    mes = '';
                        break;
                    case '1':   mes = 'Enero';
                        break;
                    case '2':   mes = 'Febrero';
                        break;
                    case '3':   mes = 'Marzo';
                        break;
                    case '4':   mes = 'Abril';
                        break;
                    case '5':   mes = 'Mayo';
                        break;
                    case '6':   mes = 'Junio';
                        break;
                    case '7':   mes = 'Julio';
                        break;
                    case '8':   mes = 'Agosto';
                        break;
                    case '9':   mes = 'Septiembre';
                        break;
                    case '10':  mes = 'Octubre';
                        break;
                    case '11':  mes = 'Noviembre';
                        break;
                    case '12':  mes = 'Diciembre';
                        break;
                }
                
                if ( anio ) {
                    
                    $.each( $('#nav-evento .has-sub a span'), function ( indexInArray, valueOfElement ) {
                        
                        if ( $( valueOfElement ).text() == anio ) {
                            
                            //$( valueOfElement ).parent().addClass( 'active' );
                        }
                    } );
                }
                if ( mes ) {
                    
                    $.each( $('#nav-evento .has-sub ul li a span'), function ( indexInArray, valueOfElement ) {
                        
                        if ( $( valueOfElement ).text() == mes ) {
                            
                            $( valueOfElement ).parents( '.csssubmenu' ).show();
                            $( valueOfElement ).parents( '.has-sub' ).siblings().children( 'ul' ).hide();
                            $( valueOfElement ).parents( '.has-sub' ).siblings().children( 'a' ).removeClass( 'active' );
                            $( valueOfElement ).parent().parent().removeClass( 'noactive' ).addClass( 'active' );
                            $( valueOfElement ).parent().parent().parent().show();
                        }
                    } );
                }
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
            _selector       = ( typeof( selector ) == "undefined" ) ? "*" : selector;
            _selector       = ( typeof( _selector ) == "object" ) ? _selector : $( _selector );
            _selector.uniform();
        },
        /**
         *
         *  @function:  !validateContact
         *  @description:   Makes the validation of the contact form
         *  @see:   http://bassistance.de/jquery-plugins/jquery-plugin-validation/ ||
         *          http://docs.jquery.com/Plugins/Validation
         *  @author: @_Chucho_
         *
         */
        //  !Validación del formulario de contacto.
        validateFormsAjax:    function ( rule, messages ) {
            
            var _rule       = ( typeof( rule ) == 'object' ) ? rule : {};
            var _message    = ( typeof( messages ) == 'object' ) ? messages : {};
            
            var formActive = $( '.contact_form' ).validate( {
                onfocusout: false,
                onclick: true,
                onkeyup: false,
                onsubmit: true,
                focusCleanup: true,
                focusInvalid: false,
                errorClass: "error",
                validClass: "valid",
                errorElement: "label",
                ignore: '',
                /*showErrors: function( errorMap, errorList ) {
                    $('#message').empty().removeClass();
                    $("#message").html('<p>Error al ingresar la información.</p><p>Verifique que sus datos están correctos o que no falte ningún dato.</p><p>Por favor, vuelvalo a intentar.</p>');
                    $('#message').addClass('wrong').show('fast', function(){
                        $('#message').show('fast');
                    });
                    this.defaultShowErrors();
                },*/
                errorPlacement: function(error, element) {
                    error.appendTo( element.parent() );
                },
                //debug:true,
                rules: _rule,
                messages: _message,
                highlight: function( element, errorClass, validClass ) {
                    $( element ).parent().addClass( 'error_wrapper' );
                },
                unhighlight: function( element, errorClass ) {
                    $( element ).parent().removeClass( 'error_wrapper' );
                },
                submitHandler: function( form ) {
                    // Form submit
                    $( form ).ajaxSubmit( {
                        //    Before submitting the form
                        beforeSubmit: function showRequestLogin( arr, form, options ) {
                            
                            $('.error_indicator').remove();
                        },
                        //  !Function for handle data from server
                        success: function showResponseLogin( responseText, statusText, xhr, form ) {
                            
                            responseText    = ( $.parseJSON( responseText ) == null ) ? responseText : $.parseJSON( responseText );
                            
                            if( responseText && ( responseText.success == 'true' || responseText.success == true ) ) {
                                
                                $( '#contact_message_wrapper' ).append( '<label for="contact_message" class="response sended">Tu comentario se ha enviado</label>' );
                            } else {
                                $( '#contact_message_wrapper' ).append( '<label for="contact_message" class="response wrong">Error</label>' );
                            }
                        },
                        resetForm: true,
                        clearForm: false,
                        //   If something is wrong
                        error: function( jqXHR, textStatus, errorThrown ) {
                            //console.log(textStatus);
                            //console.log(errorThrown);
                            $( '#contact_message_wrapper' ).append( '<label for="contact_message" class="response wrong">Hubo un error</label>' );
                        },
                        cache: false
                    } );
                },
                /*invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                        $("div#summary").html(message);
                        $("div#summary").show();
                    } else {
                        $("div#summary").hide();
                    }
                }*/
            } );
        },
        /**
         *
         *  @function:  !validateContact
         *  @description:   Makes the validation of the contact form
         *  @see:   http://bassistance.de/jquery-plugins/jquery-plugin-validation/ ||
         *          http://docs.jquery.com/Plugins/Validation
         *  @author: @_Chucho_
         *
         */
        //  !Validación del formulario de contacto.
        validateForms:    function ( rule, messages ) {
            
            var _rule       = ( typeof( rule ) == 'object' ) ? rule : {};
            var _message    = ( typeof( messages ) == 'object' ) ? messages : {};
            
            var formActive = $( '#images_search' ).validate( {
                onfocusout: false,
                onclick: true,
                onkeyup: false,
                onsubmit: true,
                focusCleanup: true,
                focusInvalid: false,
                errorClass: "error",
                validClass: "valid",
                errorElement: "label",
                ignore: "",
                /*showErrors: function( errorMap, errorList ) {
                    $('#message').empty().removeClass();
                    $("#message").html('<p>Error al ingresar la información.</p><p>Verifique que sus datos están correctos o que no falte ningún dato.</p><p>Por favor, vuelvalo a intentar.</p>');
                    $('#message').addClass('wrong').show('fast', function(){
                        $('#message').show('fast');
                    });
                    this.defaultShowErrors();
                },*/
                errorPlacement: function(error, element) {
                    error.appendTo( element.parent() );
                },
                //debug:true,
                rules: _rule,
                messages: _message,
                highlight: function( element, errorClass, validClass ) {
                    $( element ).parent().addClass( 'error_wrapper' );
                },
                unhighlight: function( element, errorClass ) {
                    $( element ).parent().removeClass( 'error_wrapper' );
                },
                submitHandler: function( form ) {
                    // Form submit
                    var locationString, dateString;
                    
                    if ( $( '#location_search' ).val() != '' ) {
                        
                        locationString  = $( '#location_search' ).val();
                    }
                    if ( $( '#date_search' ).val() != '' ) {
                        
                        dateString      = $( '#date_search' ).val();
                    }
                    
                    window.location.href    = 'eventos.php?municipio=' + locationString + '&fecha=' + dateString;
                },
                /*invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                        $("div#summary").html(message);
                        $("div#summary").show();
                    } else {
                        $("div#summary").hide();
                    }
                }*/
            } );
        },
        /**
         *
         *  @function:  doOverlay
         *  @description:  Make and overlay effect
         *  @params jQuery selector.- A jQuery Selector
         *  @params Object options.- A JSON object with the options to make a
         *                           target element a jqdock Element
         *  @author: @_Chucho_
         *  @see:   http://jquerytools.org
         *
         */
        //  !Hace un efecto de overlay sobre un elemento determinado
        doOverlay:  function ( selector, options ) {
            var _selector   = ( typeof( selector ) == "string" )? $( selector ) : ( ( typeof( selector ) == "object" )? selector : $( '*' ) );
            var _options    = ( typeof( options )   == "object" )? options : {};
           
            _selector.overlay( _options );
        },
        //  !Abre un cuadro de diálogo con un mensaje
        openAlert:  function ( title, markupMessage ) {
            
            var _title      = ( title == "" || title == undefined ) ? "Error" : title;
            var _message    = ( markupMessage == "" || markupMessage == undefined ) ? "<p>Hubo un error inesperado.</p>" : markupMessage;
            
            if ( $( '.alert_box h2' ).exists() ) {
                
                $( '.alert_box h2' ).text( _title );
            } else {
                
                $( '.alert_box' ).append( '<h2>' + _title + '</h2>' );
            }
            $( '.alert_box' ).append( _message );
            //TFG.overlay.load();
            $( '.alert_trigger' ).click( );
            $( '.alert_box' ).centerHeight( );
            $( '.alert_box' ).centerWidth( );
            $( '.alert_background' ).fadeIn( 50, function (  ) {
               
                $( '.alert_box' ).fadeIn( 100 );
            } );
        },
        /**
         *
         *  @function:  !closeAlert
         *  @description:   Close an alert box with a message
         *  @see:   http://bassistance.de/jquery-plugins/jquery-plugin-validation/ ||
         *          http://docs.jquery.com/Plugins/Validation
         *  @author: @_Chucho_
         *
         */
        //  !Cierra un cuadro de diálogo con un mensaje
        closeAlert:  function ( ) {
           
            TFG.overlay.close();
            /*$( '.alert_box' ).fadeOut( 'fast' );
            $( '.alert_background' ).fadeOut( 'fast' );
            $( '.alert_box h4' ).text( '' );
            $( '.alert_box p' ).remove( );
            $( '.alert_box form' ).remove( );
            $( '.alert_box table' ).remove( );
            $( '.alert_box div' ).remove( );
            $( '.alert_box button' ).remove( );*/
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
           
            _selector       = ( typeof( selector ) == "undefined" ) ? "*" : selector;
            _selector       = ( typeof( _selector ) == "object" ) ? _selector : ( typeof( _selector ) == "number" ) ? _selector : $( _selector );
           
            _durationInSec  = ( durationInSec == "" ) ? 1000 : durationInSec;
            _durationInSec  = ( typeof( _durationInSec ) == "string" ) ? parseInt( _durationInSec ) : _durationInSec;
            _durationInSec  = ( typeof( _durationInSec ) != "number" ) ? parseInt( _durationInSec ) : _durationInSec;
           
            if ( typeof( _selector ) == "object" ) {
               
                _scrollYOffset  = _selector.offset().top;
                _scrollYOffset  = Math.ceil ( Number( _scrollYOffset ) );
            } else if ( typeof( _selector ) == "number" ) {
               
                _scrollYOffset  = _selector;
            }
           
            $.scrollTo( _scrollYOffset, {
                duration: _durationInSec,
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
           
            _selector       = ( typeof( selector ) == "undefined" ) ? "*" : selector;
            _selector       = ( typeof( _selector ) == "object" ) ? _selector : $( _selector );
           
            _valueChange  = ( valueChange == "" ) ? "" : valueChange;
            _valueChange  = ( typeof( _valueChange ) == "string" ) ? _valueChange : ( typeof( _valueChange ) == "number" ) ? parseInt( _valueChange ) : _valueChange;
           
            var _placeholder;
           
            if ( _selector.attr( 'placeholder' ) != undefined ) {
               
                _placeholder = String ( _selector.attr( 'placeholder' ) ).toLowerCase();
            } else {
               
                _placeholder = String ( _selector.val( ) ).toLowerCase();
            }
           
            /*if ( ( _placeholder == "" ) || ( _placeholder == _valueChange ) ) {
               
                _selector.css( {
                    color: '#aaa'
                } );
            }*/
           
            _selector.on( {
                blur: function ( e ) {
                   
                    _comment = String( $( e.currentTarget ).val() ).toLowerCase();
                    if ( ( _comment == _placeholder ) || ( _comment == "" ) ) {
                       
                        $( e.currentTarget ).val( valueChange );
                        return false;
                    }
                },
                focus: function ( e ) {
                   
                    _comment = String( $( e.currentTarget ).val() ).toLowerCase();
                    if ( _comment == _placeholder ) {
                       
                        $( e.currentTarget ).val( '' );
                        return false;
                    }
                }
            } );
        },
        /**
         *
         *  @function:  !toggleClass
         *  @description:   Toggle an HTML class
         *  @params jQuery selector.- A jQuery Selector
         *  @params String className.- A class to toggle to the target
         *  @author: @_Chucho_
         *
         */
        //  !Hace toggle de una clase a un selector específico
        toggleClass: function ( selector, className ) {
           
            _selector       = ( typeof( selector )  == "undefined" ) ? "*" : selector;
            _selector       = ( typeof( _selector ) == "object" )    ? _selector : $( _selector );
            _class          = ( typeof( className ) == "undefined" ) ? ".active" : className;
            _class          = ( typeof( _class )    == "string" )    ? _class : String( _class );
           
            if ( selector.exists() ) {
               
                _selector.toggleClass( _class );
            }
        },
        /**
         *
         *  @function:  !obtainActualDocument
         *  @description:   Obtain name of the section from the url and puts an
         *                  active state in the correspondant link
         *  @author: @_Chucho_
         *
         */
        //  !Obtiene el nombre de la sección de la url y pone una clase al link correspondiente
        obtainActualDocument:   function ( ) {
           
            //  obtain url and determine wich function execute on base at name sectionn.
            var absolutePath        = self.location.href;
            var lastSlashPosition   = absolutePath.lastIndexOf( "/" );
            var relativePath        = absolutePath.substring( lastSlashPosition + "/".length , absolutePath.length );
            var waste               = relativePath.substring( relativePath.lastIndexOf( '.' ), relativePath.length );
            relativePath            = relativePath.replace( waste, '' );
            var _section            = new RegExp( "eventos|index*[^-]", "gi" );
            var _nameSection        = String( relativePath.match( _section ) );
            $( '#nav nav ul li.active' ).removeClass( 'active' );
           
            switch ( _nameSection ) {
                case "index":
                default:
                    $( '#nav nav ul li' ).eq( 0 ).addClass( 'active' );
                    break;
            }
        },
        /************************************************************************************************/
        /************************************* CONTROL DE ANIMACIONES ***********************************/
        /************************************************************************************************/
        ControlGaleria  : function ( ) { 
            var verde   = [ 0, 0, 1 ];
            var gris    = [ 0, 0, 1 ];
            TFG.AnimarCuadro( 0 );
            TFG.AnimarCuadro( 1 );
            setTimeout( function ( ) {
                
                TFG.CambiarImagen()
            }, 3000 ); 
        },
        CambiarImagen   : function ( ) {
            
            var s       = "";
            var a       = Math.floor( Math.random() * 2 );
            //var x     = Math.floor( Math.random() * 4 ) + 1;
            //var y     = Math.floor( Math.random() * 3 ) + 1;
            
            var i       = Math.floor( Math.random() * boxes.length );
            var nombre  = boxes[ i ].toString( );
            
            boxes.splice( i, 1 );
            
            if( boxes.length    == 0 ) {
                boxes   = new Array( '11', '21', '31', '41',
                                  '12', '22', '32', '42', 
                                  '13', '23', '33', '43');
            }
            /*fotos.splice(index, 1);
            items = fotos.length;*/
            
            //var imgPrev = $("#img-" + y + '' + x );
            counter = counter + 1;
            
            if( counter > items ) {
                
                counter = 0;
                
                $.ajax ( 'masimagenes.php', {
                    beforeSend: function ( jqXHR, settings ) {
                        
                    },
                    cache: false,
                    complete: function ( jqXHR, textStatus ) {
                        
                    },
                    contentType: "application/x-www-form-urlencoded",  
                    converters: {
                        "* text":       window.String,
                        "text html":    true,
                        "text json":    $.parseJSON,
                        "text xml":     $.parseXML
                    },
                    data: {
                        
                    },
                    error:  function ( jqXHR, textStatus, errorThrown ) {
                        
                    },
                    success: function ( data, textStatus, jqXHR ) {
                        
                        //var obj = $.parseJSON(data);
                        fotos   = $.parseJSON( data );
                        items   = fotos.length;
                        
                        //alert(items );
                    },
                    type: "POST"
                } );
            }
            
            //$('.pie span').html(nombre );
            crossv  = TFG.Cross( nombre, verde );
            crossg  = TFG.Cross( nombre, gris );
            TFG.AnimarImagen( nombre, a );
        },
        AnimarCuadro    : function ( i ) { 
            
            var s ="";
            if( i == 0 ) {// Animar cuadro verde
                imgv        = true;
                verde[0]    = Math.floor( Math.random() * 4 ) + 1;
                verde[1]    = Math.floor( Math.random() * 3 ) + 1;
                
                TFG.CambiaFoto( $( "#img-" + verde[0] + '' + verde[1] ) );
                
               crossg      = TFG.Cross( verde[0] + '' + verde[1], gris );
                
                if( crossg ) {
                    
                    imgg        = true;
                    gris[0]   = Math.floor( Math.random( ) * 4 ) + 1;
                    gris[1]   = Math.floor( Math.random( ) * 3 ) + 1;
                    TFG.CambiaFoto( $("#img-" + gris[0] + '' + gris[1] ));
                }
            } else {
                imgg        = true;
                gris[0]   = Math.floor( Math.random() * 4 ) + 1;
                gris[1]   = Math.floor( Math.random() * 3 ) + 1;
                TFG.CambiaFoto( $( "#img-" + gris[0] + '' + gris[1] ) );
                crossv      = TFG.Cross( gris[0] +'' + gris[1], verde );
                
                if( crossv ) {
                    
                    imgv        = true;
                    verde[ 0 ]  = Math.floor( Math.random() * 4 ) + 1;
                    verde[ 1 ]  = Math.floor( Math.random() * 3 ) + 1;
                    TFG.CambiaFoto( $( "#img-" + verde[ 0 ] + '' + verde[ 1 ] ) );
                }
            }
        },
        AnimarImagen    : function ( name, animacion ) {
            
            var imgPrev = $( "#img-" + name + '' );//x + '' + y );
            var m       = $( imgPrev ).attr( "mouse" );
            
            opacidad    =0.5;
            
            //if(crossv) AnimarCuadro(0);
            //if(crossg) AnimarCuadro(1);
            
            //Verificar que no tenga el cursor sobre la imagen
            if ( m  =="0" ){
                
                if( crossv ) TFG.AnimarCuadro(0);
                if( crossg ) TFG.AnimarCuadro(1);
                
                switch( animacion ) {
                    case 0:
                        TFG.FlipVertical( imgPrev );
                        break;
                    case 1:
                        TFG.DesvanecerAparecer( imgPrev );
                        break;
                    case 2:
                        TFG.FlipHorizontal( imgPrev );
                        break;
                    case 3:
                        TFG.SlideDerecho( imgPrev );
                        break;
                    case 4:
                        TFG.TogleUp( imgPrev );
                        break;
                } 
            }
            
            //--Tiempo para la siguiente animación
            setTimeout( function( ) {
                
                TFG.CambiarImagen()
            }, 3000 );
        },
        Cross   : function ( idimg, obj ) {
            var result  = false,
            str      = idimg.toString(),
            x       = parseInt(str.substring(0,1)),//11
            y       = parseInt(str.substring(1));
             
            if ( x == obj[ 0 ] ) {
                
                if ( y == obj[ 1 ] ) {
                    
                    result = true;
                }
            }
            //$('.pie a').html(boxes.length+' : ' +idimg +': '+ x +', ' + y + '<br/>');
            
            return result;
        },
        CambiaFoto  : function ( ctl ) {
            
            var index   =  Math.floor( Math.random( ) * items ); //indice de la imagen a mostrar
            var imgNew;
            var refNew  ="#";
            var alink   = $(ctl).parent();
            var fotos;
            
            if ( imgv ) {
                
                imgNew  = "img/dashboard/cuadro-verde.png";
                imgv    = false;
            } else if( imgg ) {
                
                imgNew  = "img/dashboard/cuadro-gris.png";
                imgg    = false;
            } else{
                
                imgNew  = "imagenes/" + fotos[ index ][ 'directorio' ] + "/thumb" + fotos[ index ][ 'archivo' ];
                refNew  = "eventos.php?anio=" + fotos[ index ][ 'anio' ] + "&mes=" + fotos[ index ][ 'mes' ] + "&id=" + fotos[ index ][ 'evento' ] +"&foto=" +fotos[ index ][ 'foto' ];
                
                fotos.splice( index, 1 );
                items   = fotos.length;
            }
            
            //$('.pie a').html(counter + ' ' + items);
            
            $( alink ).attr( "href", refNew );
            $( ctl ).attr( "src", imgNew );
        },
        FlipHorizontal  : function ( imgPrev ) {
            var margin  = $( imgPrev ).width( ) / 2;
            var ancho   = $( imgPrev ).width( );
            var alto    = $( imgPrev ).height( );
            
            $( imgPrev ).animate( {
                width:      '0px',
                height:     '' + alto + 'px',
                marginLeft: '' + margin + 'px',
                opacity:    opacidad
            }, { 
                duration:   200
            } );
            
            setTimeout( function( ) {
                
                TFG.CambiaFoto(imgPrev);
                $( imgPrev ).animate( { 
                    width:      ancho + 'px',
                    height:     alto + 'px',
                    marginLeft: '0px',
                    opacity:    '1'
                }, { 
                    duration:   200
                } );
            }, 200 );
        },
        FlipVertical    : function ( imgPrev ) {
            var margin  = $( imgPrev ).height( ) / 2;
            var ancho   = $( imgPrev ).width( );
            var alto    = $( imgPrev ).height( );
            
            $( imgPrev ).animate( {
                width:      '' + ancho + 'px',
                height:     '0px',
                marginTop:  '' + margin + 'px',
                opacity:    opacidad
            }, {
                duration:200 
            } );
            
            setTimeout( function( ) {
                
                TFG.CambiaFoto( imgPrev );
                $( imgPrev ).animate( {
                    width:      '' + ancho + 'px',
                    height:     '' + alto + 'px',
                    marginTop:  '0px',
                    opacity:    '1'
                }, {
                    duration:200
                } );
            }, 200);
        },
        DesvanecerAparecer  : function ( imgPrev ) {
            
            $( imgPrev ).fadeOut( 300, function( ) {
                
                TFG.CambiaFoto(this);
            } );
            
            $(imgPrev).fadeIn(300).delay(300);
        },
        SlideDerecho    : function ( imgPrev ) {
            
            var ancho   = $( imgPrev ).width();
            var alto    = $( imgPrev ).height();
            
            $( imgPrev ).animate( {
                width:          '0px', 
                height:         alto + 'px',
                marginRight:    ancho +'px',
                opacity:        opacidad
            }, {
                duration:300,
                complete: function( ) { 
                    TFG.CambiaFoto(imgPrev);
                }
            } );
            
            $(imgPrev).animate( {
                width:      ancho + 'px',
                height:     alto + 'px',
                marginRight:'0px',
                opacity:    '1'
            }, {
                duration:   300
            } );
        },
        TogleUp : function ( imgPrev ) {
            var ancho   = $( imgPrev ).width();
            var alto    = $( imgPrev ).height();
            
            $( imgPrev ).animate( {
                width:      '' + ancho + 'px',
                height:     '0px',
                marginTop:  '-' + alto + 'px',
                opacity:    opacidad
            }, {
                duration:   700,
                complete:   function( ) {
                    TFG.CambiaFoto( imgPrev );
                }
            } );
            
            $(imgPrev).animate( {
                width:      '' + ancho + 'px',
                height:     '' + alto + 'px',
                marginTop:  '0px',
                opacity:    '1'
            }, {
                duration:   800
            } );
        },
        onOver  : function ( obj ){
            
            $( obj ).attr( "mouse", "1" );
        },
        onOut   : function ( obj ) {
            
            $( obj ).attr( "mouse", "0" );
        },
        onBefore : function ( ) { return false; },
        onAfter : function ( ) { return false; },
        blurElement : function ( element, size ) {
            
            var filterVal   = 'blur(' + size + 'px)';
            $( element ).css( {
                'filter':       filterVal,
                'webkitFilter': filterVal,
                'mozFilter':    filterVal,
                'oFilter':      filterVal,
                'msFilter':     filterVal
            } );
        },
        ConfigurarPantalla  : function ( ) {
            TFG.ConfigurarPanel();
            TFG.ConfigurarDespliegueMenu();
            //-Verificar el scroll
            TFG.ConfiguraScrollMenu( $( "#submenu-evento" ) );
            
            //-jquery-resize
            //$(".contenedor").smartBackgroundResize({  image: 'img/dashboard/bg_dashboard.png' });//No aplica bien el estilo
            
            //- jquery-backstretch
            $( ".contenedor" ).backstretch( "img/dashboard/bg_dashboard.png" );
        },
        ConfiguraScrollMenu : function ( div ) {
            
            var s               = "";
            var hScroll         = 0;
            var hMenuLateral    = $( ".menu-lateral" ).height();
            var hMenu           = $( "#cssmenu" ).height();
            var hMenuEvento     = $( div ).height();
            
            if( hMenu > hMenuLateral ) {
                
                $( "#cssmenu" ).css( "height", hMenuLateral - 1 );
                hScroll = hMenu - hMenuLateral;
                hScroll = hScroll + ( hMenuEvento - hMenuLateral );
                $( div ).css( {
                    height: hScroll * - 1 + 'px', 
                    overflow: "hidden"
                } );
                $( div ).perfectScrollbar( { suppressScrollX: true } );
            }
            
            //hScroll =  hMenuLateral - hMenu;
            
            //$(div).css("height", hMenuEvento + hScroll);
            
            //$("#nav-evento").css("height", hMenuEvento + hScroll);
            //$("#cssmenu").css("height", $(".menu-lateral").height());
            
            if( hMenu > hMenuLateral ) {
                //-Activar scroll
                //$(div).mCustomScrollbar({horizontalScroll:true, theme:"light"});
                //$(div).scroll();
                //$("#submenu-evento").scroll();
                /*$("#nav-evento").css("overflow", "hidden");
                $("#nav-evento").perfectScrollbar({suppressScrollX: true});*/
                //$('#nav-evento').perfectScrollbar('update');
            }
            
            s   = s + "MenuLateral:" + hMenuLateral + "<br/>";
            s   = s + "hMenu:" + hMenu + "<br/>";
            s   = s + $( div ).attr( 'id' ) + ":" + hMenuEvento +"<br/>";
            s   = s + "hScroll:" + hScroll +"<br/>";
            s   = s + "Scroll:" + ( hMenu > hMenuLateral ) +"<br/>";
            //$(".pie").html(s);
        },
        //- Funcion que se encarga de configurar el alto y ancho del panel de imagenes
        ConfigurarPanel     : function ( ) { 
            var sDatos  = "";
            var top     = 0;
            var left    = 0;
            var temp    = 0;
            var margen  = 0;
            var div     = $( ".contenedor-panel" );
            
            /****************** Variables ancho de elementos ************************/
            var wContent        = 0;
            var wScreen         = $( window ).width();
            var wBarraIzq       = $( ".contenedor-izquierda" ).width();
            var wContentPanel   = $( div ).width();
            var wFondoPanel     = $( ".fondo-panel" ).width();
            
            /****************** Variables alto de elementos ************************/
            var hContent        = 0;
            var hScreen         = $( window ).height();
            //var hBarraIzq = $( ".contenedor-izquierda" ).height(); // Valorar si es necesaro ya que la altura del panel es mayor al menu
            var hContentPanel   = $( div ).height();
            var hFondoPanel     = $( ".fondo-panel" ).height();
            
            /************** Cálcular ancho de elementos ***************************/
            left                = Math.round( ( ( wScreen - wBarraIzq ) - wFondoPanel ) / 2 );
            
            //-Controlar el espaciado horizontal
            if( left < 4 ) {
                
                left    = 4;
                margen  = left * 2;
            } else {
                margen  = wScreen - wBarraIzq - wFondoPanel;
            }
            
            wContent    = wFondoPanel + margen;
            $( ".fondo-panel" ).css( "marginLeft", left );
            $( div ).css( "width", wContent );
            $( ".contenedor" ).css( "width", wContent + wBarraIzq );
            
            /************** Cálcular alto de elementos ***************************/
            top = Math.round( ( hScreen - hFondoPanel ) / 2 );
            
            //-Controlar el espaciado vertical
            if( top < 20 ) {
                top     = 20;
                margen  = top * 2;
            } else {
                margen  = hScreen - hFondoPanel;
            }
            
            hContent    = hFondoPanel + margen;
            $( ".fondo-panel" ).css( "marginTop", top );
            $( div ).css( "height", hContent );
        },
        //- Funcion para configurar la barra lateral de acuerdo a la resolución del navegador
        ConfigurarDespliegueMenu    : function ( ) { 
            //var sDatos ="";
            //var hMenu = 0;
            //var hScreen = $( window ).height(); 
            //var hLogo = $( ".contenedor-logotipo" ).height();
            //var hBuscador = $( ".contenedor-buscador" ).height();
            var hMenuNav = $( "#cssmenu" ).height();
            //var hPie = $( ".pie" ).height();  
            var hElementos = ($( ".contenedor-logotipo" ).height() + $( ".contenedor-buscador" ).height() + $( ".pie" ).height() ); 
            var hDashboard = $( ".contenedor-panel" ).height();
            var div = $(".menu-lateral");   
                
            hMenuNav = hDashboard - hElementos; 
            
            $(div).css("height", hMenuNav);
        },
        OpenContacto    : function ( ) {
            
            //gallery to launch
            var id = "contato.html";
            //get the first item out of the cache
            //var content = Shadowbox.cache[1].content;
            //default options object
            var options = {}; 
            //now we can open it
            Shadowbox.open( {
                content:    "contacto.html",
                title:      "Contactanos",player:"html"
            } );
            
            return false;
        },
    };
    
    // Give the init function the TFG prototype for later instantiation
    TFG.fn.init.prototype = TFG.fn;
    
    TFG = TFG.fn;
    
    // Expose TFG to the global object
    window.TFG  = TFG;
    
    //  When DOM is loaded
    $( function ( ) {
        
        if ( $( ".loader" ).exists() ) {
           
            $( '.alert_background' ).fadeOut( 300 );
            $( ".loader" ).fadeOut( 300 );
        }
    } );
    
    //  When DOM is ready
    $( document ).on( 'ready', function ( e ) {
        
        //  Crea una instancia de jQuery Overlay para el home de descubreone.mx
        //  Calcula la distancia entre el margen izquierdo para posicionar
        //  la capa del video. Si en menor de 0 (ocurre en iPhone) utiliza
        //  el ancho del body en vez del ancho de la ventana para hacer
        //  el cálculo
        if ( $( '#contact_form_wrapper' ).exists() ) {
            
            TFG.doOverlay( $( '.overlay_trigger' ), {
                effect: 'apple',
                close: $( '#contact_form_wrapper a.close' ),
                closeOnClick: true,
                closeOnEsc: true,
                speed: 'normal',
                fixed: false,
                onBeforeLoad: function ( e ) {
                   
                    $( '.alert_background' ).height( '100%' );
                    $( '#contact_form_wrapper' ).centerWidth();
                    $( '#contact_form_wrapper' ).centerHeight();
                },
                onLoad: function() {
                    $( '.alert_background' ).fadeIn( 100 );
                },
                onBeforeClose:  function ( ){
                    
                    $( '.alert_box' ).fadeOut( 10, function ( ) {
                        
                        $( '.alert_background' ).fadeOut( 10 );
                        $( '.response.sended,.response.wrong' ).remove();
                    } );
                },
                onClose: function ( e ) {}
            } );
            
            //TFG.overlay    = $( '.alert_trigger' ).data( 'overlay' );
            TFG.overlay    = $( '.overlay_trigger' ).data( 'overlay' );
            
            $( '#contact_form_wrapper' ).height( $( 'body' ).height() );
            
            $( window ).on( {
                resize: function ( e ) {
                   
                    $( '.alert_box' ).centerWidth();
                },
                touchstart: function ( e ) {
                   
                    $( '.alert_box' ).centerWidth();
                },
                touchend: function ( e ) {
                   
                    $( '.alert_box' ).centerWidth();
                }
            } );
        }
        
        if ( $( '.alert_background' ).exists() ) {
            
            $( '.alert_background' ).on( 'click', function( e ) {
                TFG.closeAlert();
            } );
        }
        
        // Validación de los formularios
        if ( $( '#search_form' ).exists() ) {
            
            if ( $( 'select' ).exists() ) {
                
                TFG.makesUniform( 'select' );
            }
            if ( $( '.datepicker' ).exists() ) {
                
                $( '.datepicker' ).datepicker( {
                    dateFormat: "dd-MM-yy",
                    dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" ],
                    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                    dayNamesShort: [ "Dom", "Lun", "Mar", "Mir", "Jue", "Vie", "Sab" ],
                    firstDay: 1,
                    gotoCurrent: true,
                    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                    monthNamesShort: [ "Enero", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
                    //changeMonth: true,
                    //changeYear: true
                } );
            }
            
            var rules   = {
                    location: {
                        required: true
                    },
                    date: {
                        required: false
                    },
                };
            var messages    = {
                    location: "Por favor, selecciona una opción",
                    date: "Por favor, selecciona una opción",
                    required: "Por favor, selecciona una opción",
                    minlength: "Por favor, haga su respuesta más amplia.",
                    maxlength: "Por favor, acorte su respuesta",
                    email: "Escriba un email válido",
                    number: "Escriba solo números",
                    digits: "Escriba solo números",
                }
           
            TFG.validateForms( rules, messages );
        }
        
        // Validación de los formularios
        if ( $( '.contact_form' ).exists() ) {
            
            var rules   = {
                    contact_name:       {
                        required:   true,
                        minlength:  5,
                        maxlength:  250
                    },
                    contact_mail:       {
                        required:   true,
                        email:      true,
                        minlength:  5,
                        maxlength:  250
                    },
                    contact_message:    {
                        required:   true,
                        minlength:  5,
                        maxlength:  512
                    }
                };
            var messages    = {
                    contact_name:       "Por favor, escribe tu nombre",
                    contact_mail:       "Por favor, escribe tu email",
                    contact_message:    "Por favor, escribenos un mensaje",
                    location:           "Por favor, selecciona una opción",
                    date:               "Por favor, selecciona una opción",
                    required:           "Por favor, selecciona una opción",
                    minlength:          "Por favor, haga su respuesta más amplia.",
                    maxlength:          "Por favor, acorte su respuesta",
                    email:              "Escriba un email válido",
                    number:             "Escriba solo números",
                    digits:             "Escriba solo números",
                }
           
            TFG.validateFormsAjax( rules, messages );
        }
        
        if ( $( 'input[type="reset"]' ).exists() ) {
            
            $( 'input[type="reset"]' ).on( 'click', function ( e ) {
                
                e.stopPropagation();
                $( ".response.sended, .response.wrong" ).remove();
            } );
        }
        
        if ( $( '#home' ).exists() ) {
            
            var opacidad        = 0,
                verde           = new Array(),
                gris            = new Array(),
                boxes           = new Array('11', '21', '31', '41',
                                  '12', '22', '32', '42', 
                                  '13', '23', '33', '43'),
                crossv          = false,
                crossg          = false,
                imgv            = false,
                imgg            = false,
                ScrollableMenu  = false,
                counter         = 0,
                icounter        = 0;
                
            TFG.ConfigurarPantalla();
            
            if ( $('.tabla-col a img').exists() ) {
                
                //- Efectos hover
                //$('tabla-col a img').animate({"opacity" : 1});
                $('.tabla-col a img').on( {
                    mouseenter: function( ) {
                        
                        $( e.currentTarget ).animate( { "opacity" : 0.5 } );
                    },
                    mouseleave: function( ) {
                        $( e.currentTarget ).animate( { "opacity" : 1 } );
                    } 
                } );
            }
            
            if ( $('#cssmenu > ul > li > a').exists() ) {
                
                //-Control menu vertical
                $('#cssmenu > ul > li > a').on( 'click', function( e ){
                    
                    $('#cssmenu li').removeClass('active');
                    $( e.currentTarget ).closest('li').addClass('active');
                    
                    var checkElement = $( e.currentTarget ).next();
                    
                    //-Para un elemento div
                    if( ( checkElement.is( 'div' ) ) && ( checkElement.is( ':visible' ) ) ) {
                        $( e.currentTarget ).closest( 'li' ).removeClass( 'active' );
                        checkElement.slideUp( 'normal' );
                        //Si contiene un div solo debe de cerrar y no perder el foco (mantener estado activo)
                        TFG.ConfiguraScrollMenu( checkElement );
                    }
                    
                    //-Para un elemento div
                    if( ( checkElement.is( 'div' ) ) && ( !checkElement.is( ':visible' ) ) ) {
                        
                        $( '#cssmenu ul ul:visible' ).slideUp( 'normal' );
                        checkElement.slideDown( 'normal', function( ) { TFG.ConfiguraScrollMenu( e.currentTarget ); } );
                    }
                    
                    if( $( e.currentTarget ).closest('li').find('div').children().length == 0) {
                        
                        return true;
                    } else {
                        
                        return false;
                    }
                } );
            }
            
            if ( $( '#nav-evento > li > a' ).exists() ) {
                
                //-Control submenu vertical
                $( '#nav-evento > li > a' ).on( 'click', function ( e ) {
                    
                    if ( $( e.currentTarget ).attr( 'class' ) != 'active' ) {
                        
                        $( '#nav-evento li ul' ).slideUp( );
                        $( e.currentTarget ).next().slideToggle( );
                        $( '#nav-evento li a' ).removeClass( 'active' );
                        $( e.currentTarget ).addClass( 'active' );
                        //-Verificar el scroll
                        TFG.ConfiguraScrollMenu( $( "#submenu-evento" ) );
                    }
                } );
            }
            
            //-Se ejecuta cuando se redimensiona la ventana del navegador
            $( window ).resize( function( ) {
                
                TFG.ConfigurarPantalla();
            } );
        }
        
        TFG.init();
    } );
   
})( jQuery, window, document );