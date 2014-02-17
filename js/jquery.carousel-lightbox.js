// JavaScript Document
	
'use strict';
(function($) {
 
    $.carouselLightbox = function(element, options) {

        // plugin's default options
        // this is private property and is  accessible only from inside the plugin
        var defaults = {
			OverlayColor:'#fff',
			Opacity:1,
			overlay:null,
 			lightbox:null,
			imageUrl:null,
			image:null,
			/*Id: null,*/
            current: null,
			toItems:null,
			loading:false,
            // if your plugin is event-driven, you may provide
            // callback capabilities for its events.
            // execute these functions before or after events of your
            // plugin, so that users may customize those particular
            // events without changing the plugin's code
            onFacebook: function(data) { 				
				//alert(data);
			}
 
        }
 
        // to avoid confusions, use "plugin" to reference the current
        // instance of the object
        var plugin = this;
 
        // this will hold the merged default, and user-provided options
        // plugin's properties will be available through this object like:
        // plugin.settings.propertyName from inside the plugin or
        // element.data('pluginName').settings.propertyName from outside
        // the plugin, where "element" is the element the plugin is
        // attached to;
        plugin.settings = {}
 
        // reference to the jQuery version of DOM element the plugin is attached to
		
		if(element== null) element = $(document.body)
		
        var $element = $(element),
             element = element;    // reference to the actual DOM element
 
        // the "constructor" method that gets called when the object is created
        plugin.init = function() {
 
            // the plugin's final properties are the merged default
            // and user-provided options (if any)
            plugin.settings = $.extend({}, defaults, options)

            // code goes here			
			DrawWrapperBox();
			/*DrawControlLeft();
			DrawControlRight();
			DrawControlImage();*/
			
 			BindEvents();
			BindEventsKeyboard();
			
			plugin.settings.imageUrl="Image URL";
			plugin.settings.toItems= plugin.settings.Items.length -1;
			
			$.isFunction( options.onSocialMedia ) && options.onSocialMedia.call( defaults );
			$.isFunction( options.onLoad ) && options.onLoad.call( this );
			
			
			BuscarImagen();
			LoadImage();
			//SettingLightbox();
        }
		
		plugin.open=function(options){
			var ovl = plugin.settings.overlay;
			var lgb = plugin.settings.lightbox;
			
			plugin.settings.image = null;
			
			$(ovl).fadeIn('fast');
			$(lgb).fadeIn('fast');
			plugin.settings = $.extend({}, defaults, options);
			plugin.settings.overlay = ovl;
			plugin.settings.lightbox = lgb;
				
			//BindEventsKeyboard();
			
			plugin.settings.toItems= plugin.settings.Items.length -1;
			$.isFunction( options.onSocialMedia ) && options.onSocialMedia.call( this );
			$.isFunction( options.onLoad ) && options.onLoad.call( this );
			//alert($.isFunction( options.onSocialMedia ));
			BuscarImagen();
			LoadImage();
			//SettingLightbox();	
		}
		
		plugin.next = function(){
			//alert(plugin.settings.Items[21].src);
			/*var i = plugin.settings.current;
			var t = plugin.settings.toItems;
			var n;
			
			n = i +1;*/
			plugin.settings.current = plugin.settings.current + 1;
			if(plugin.settings.current > plugin.settings.toItems )  plugin.settings.current = 0;
			
			//plugin.settings.current= n;
			
			if(plugin.settings.toItems>1)
				LoadImage();
			
		}
		
		plugin.previous = function(){
			//alert(plugin.settings.Items[21].src);
			/*var i = plugin.settings.current;
			var t = plugin.settings.toItems;
			var n;
			
			n = i +1;*/
			plugin.settings.current = plugin.settings.current - 1;
			if(plugin.settings.current < 0 )  plugin.settings.current = plugin.settings.toItems;
			
			//plugin.settings.current= n;
			if(plugin.settings.toItems>1)
				LoadImage();
			
		}
 
 		plugin.close=function(){
			//$(document).off('keydown'); // Unbind all key events each time the lightbox is closed
            $(plugin.settings.overlay).fadeOut('fast');
			$(plugin.settings.lightbox).fadeOut('fast');
			$.isFunction( options.onClose ) && options.onClose.call( this );
			
			var container = $("#img-wrapper");
			
			//$("img", container).remove();
			//$("#image-loading").fadeIn('fast');
			//$("img", container).fadeOut('fast');	
			$("img", container).remove();
            //$('body').removeClass('blurred');
			//$('#lightbox-container').remove();
		}
		
        // public methods
        // these methods can be called like:
        // plugin.methodName(arg1, arg2, ... argn) from inside the plugin or
        // element.data('pluginName').publicMethod(arg1, arg2, ... argn)
        // from outside the plugin, where "element"
        // is the element the plugin is attached to;
 
        // a public method. for demonstration purposes only - remove it!
        plugin.foo_public_method = function() {
 
            // code goes here
 
        }
 
        // private methods
        // these methods can be called only from inside the plugin like:
        // methodName(arg1, arg2, ... argn)
 
        var DrawWrapperBox = function() {
			var overlay;
			var container;
			var _body = $('body');
			var html='';			
				
			// - Overlay
			overlay = document.createElement('div');
			$(overlay).attr('id', 'overlay').addClass('overlay');
			$(overlay).css('background-color', plugin.settings.OverlayColor);
			$(overlay).appendTo(element);
			
			if(plugin.settings.Blur){
				//AplicarDesenfoque($(element), 2);
				$(overlay).css('opacity', plugin.settings.Opacity);
			}
				
			plugin.settings.overlay = overlay;
			
			//Contenedor principal
			container = document.createElement('div');
			$(container).attr('id', 'lightbox-wrapper').addClass('lightbox-wrapper');
			$(container).appendTo(element);
			
			plugin.settings.lightbox = container;
			
			html = html  + 
			'<div id="lightbox-row" class="lightbox-row"> ' +
				'<div id="lightbox-left" class="lightbox-left">' +
					'<div id="lgb-nav-previous" class="nav-previous">' +
						'<span id="ctl-prev">&nbsp;</span>     ' +       	
					'</div>' +
				'</div>' +
				'<div id="lightbox-container" class="lightbox-container">' +
					'<div id="img-title" class="img-title">' +
						'<span id="img-caption"></span>' +
					'</div>' +
					'<div id="img-wrapper" class="img-wrapper">' +
						
					'</div>' +
					'<div id="img-footer" class="img-footer">' +
						'<div id="footer-counter" class="footer-counter">' +
							'<span id="count-first">1</span> de <span id="count-last">2</span>' +
						'</div>' +
					'</div>' +
				'</div>' +
				'<div id="lightbox-right" class="lightbox-right">'+
					//'<div id="lightbox-close" class="lightbox-close">'+
						//'<span id="ctl-close">&nbsp;</span>'+
					//'</div>'+
					'<div id="lightbox-share" class="lightbox-share">'+
						'<div id="lgb-fb" class="social-fb">'+
							'<span id="ctl-facebook">&nbsp;</span>'+
						'</div>'+
						'<div id="lgb-mail" class="social-mail">'+
							'<span id="ctl-mail">&nbsp;</span>'+
						 '</div>'+
						'<div id="lgb-twitter" class="social-twitter">'+
							'<span id="ctl-twitter">&nbsp;</span>'+
						'</div>'+
						'<div id="lgb-print" class="social-print">'+
							'<span id="ctl-print">&nbsp;</span>'+                
						 '</div>'+
						'<div id="lgb-gplus" class="social-gplus">'+
							'<span id="ctl-gplus">&nbsp;</span>'+
						'</div>'+
					'</div>'+
					'<div id="lgb-nav-next" class="nav-next">'+
						'<span id="ctl-next">&nbsp;</span>'+
					'</div>'+
				'</div>'+
			'</div>';
			
			$(container).append(html);	
			
					
        }
		
		var SettingLightbox = function(){
			//Ajustar tamaño de los paneles
			var wscreen = $(window).width();
			var hscreen = $(window).height();
			var wwrapper = $("#lightbox-wrapper").width();
			var hnav =  $("#lightbox-share").height();
			var lgb = $("#lightbox-container").height();
			var mlink = $("#lgb-nav-next").height();
			
			//Overlay
			$("#overlay").css('width', wscreen).css('height', hscreen);
			
			//Centrar horizontal lightbox
			//alert( wscreen + ' - ' + wwrapper);
			$("#lightbox-wrapper").css('marginLeft', (wscreen - wwrapper) /2);
			
			/*$("#lightbox-left").css('height', $("#lightbox-wrapper").height());
			$("#lightbox-container").css('height', $("#lightbox-wrapper").height());
			$("#lightbox-right").css('height', $("#lightbox-wrapper").height());*/
			
			$("#lightbox-wrapper").css('marginTop', 50);
			
			
			var temp = (lgb / 2 );
			temp = temp - (mlink/2); 
			
			//alert(lgb + ' - ' +hnav + '-' +mlink + '-' +temp);
			
			if (temp < hnav) temp = hnav +4;
			
			$("#lgb-nav-next").css('marginTop', temp - hnav);
			$("#lgb-nav-previous").css('marginTop', temp);
			
			plugin.settings.loading = false;
			
			return;
			
			var m=0;
			var temp=0;
			var top = 55;
			var lgbSpan = $('#lightbox-span');
			var lgbLeft = $('#lightbox-left');
			var navLeft = $('#lgb-nav-previous');
			var hscreen = $(window).height();
			var wscreen = $(window).width();
			
			//-Ajustando tamaño del overlay
			$(lgbSpan).css('top', top);
			
			/*if(hscreen < $("#lightbox-content").height() )
				$(lgbSpan).css('height', $("#lightbox-content").height()  + (top*2));
			else*/
				$(lgbSpan).css('height', hscreen-(top*2));
			
			
				//alert( $(lgbLeft).width() + ' ' + $(navLeft).width());	
			
			//-Ajustando margen izquierdo del control de navegacion izquierdo
			if( $(lgbLeft).width() > $(navLeft).width() ){//Ccalcular left cuando exista espacio en la barra
				$(navLeft).css('marginLeft', ($(lgbLeft).width()- $(navLeft).width())+15);				
			}else{
				$(navLeft).css('marginLeft',0);
			}
			
			//-Ajustando amargen superior del control de navegacion izquierdo
			temp = 0;
			
			if(plugin.settings.CloseButton){ 
				m= $("#lgb-close").css('margin-bottom').replace('px','');
				
				temp = temp + $("#lgb-close").height(); 
				temp = temp + parseInt(m);
				
			}
				
			if(plugin.settings.SocialMedia){ 
				m= $("#lgb-social-media").css('margin-bottom').replace('px','');
				temp = temp + $("#lgb-social-media").height(); 
				temp = temp + parseInt(m);
			}
			
			if(temp == 0)
				temp = ($(lgbSpan).height()- $(navLeft).height())/2
				
			$(navLeft).css('marginTop',temp);
		}
		
		var ResizeImage = function (){
			var ratio, wHeight, wWidth, iHeight, iWidth;
			wHeight = $(window).height() - $('#img-title').height() - $('#img-footer').height();
			 //$('#lightbox-content').height();// - opts.margin;
			wWidth = $(window).width(); //$('#lightbox-content').width();//true) - opts.margin;
			plugin.settings.image.width('').height('');
			iHeight = plugin.settings.image.height();
			iWidth = plugin.settings.image.width();
			if (iWidth > wWidth) {
				ratio = wWidth / iWidth;
				iWidth = wWidth;
				iHeight = Math.round(iHeight * ratio);
			}
			if (iHeight > wHeight) {
				ratio = wHeight / iHeight;
				iHeight = wHeight;
				iWidth = Math.round(iWidth * ratio);
			}
			
			plugin.settings.image.width(iWidth).height(iHeight);
			$("#img-wrapper").width(iWidth).height(iHeight);
			
			//$("img", container).fadeIn('fast');
			//plugin.settings.image.css('marginLeft', (($('#container-image').width()- plugin.settings.image.width())/2)-6);
			/*plugin.settings.image.width(iWidth).height(iHeight).css({
					'left': ($(window).width() - plugin.settings.image.outerWidth()) / 2 + 'px'
				}).show();*/
				
			/*//image-counter
			$("#image-counter").width(plugin.settings.image.width()+12 );
			//$("#image-counter").css('marginLeft',plugin.settings.image.css('margin-left'));
			$("#image-counter").css('marginLeft', (($('#container-image').width()- plugin.settings.image.width())/2)-21);
			*/
			//$("#ctl-image").fadeOut();
			
			SettingLightbox();
		}
		
		var LoadImage = function(){
			var img;
			var index = plugin.settings.current;//Items.indexOf('359');
			var container = $("#img-wrapper");
			
			//$("img", container).remove();
			//$("#image-loading").fadeIn('fast');
			//$("img", container).fadeOut('fast');	
			
			if(plugin.settings.loading) return;
			
			$("img", container).remove();		
			$("#count-first").html(index+1  );			
			plugin.settings.imageUrl = plugin.settings.Items[index].src;
			
			img = $('<img id="ctl-image" class="ctl-image" src="' +
					plugin.settings.imageUrl + '" title="Tú Foto con el Guero" draggable="false">');
			
			
			plugin.settings.image = img;
			 
			//$("#ctl-image").attr('src', 'img/loading2.gif');
			
			//$("img", container).remove();
			//alert(plugin.settings.imageUrl);
			plugin.settings.loading = true;
			$(img).load(function () {
				$(container).append(img);
				/*
				$("#image-loading").fadeOut('fast', function(){
					$(container).append(img);//('src', plugin.settings.Items[index].src);
			
				
					//-Ajustar imagen
					ResizeImage();
				});*/
				
				ResizeImage();
			});
			
			$(plugin.settings.image).on('click', function () {
				plugin.next();
				return false;
			});	
			
			/*if( plugin.settings.image.width() > $('#lightbox-content').width()){
				ResizeImage();
			}else{
				plugin.settings.image.css('marginLeft', (($(container).width()- plugin.settings.image.width())/2)-6);
			}*/
			//alert('I-'+plugin.settings.image.width()+''+);
			
			
		}
		
		var BuscarImagen = function(){			
			var items = plugin.settings.Items.length ;
			
			plugin.settings.current =0;
			
			for( var i=0; i< items; i++){
				if( plugin.settings.Items[i].id== plugin.settings.ItemId ){
					 plugin.settings.current = i;
					 i=items;
					 break;
				}
			}
			
			$("#count-last").html(items);
		}
		
		
		
		
		
		var BindEventsKeyboard = function (){
			
			if(plugin.settings.KeyControl){
				// Bind Keyboard Shortcuts
				$(document).on('keydown', function (e) {
					// Close lightbox with ESC
					if (e.keyCode === 27) {
						plugin.close();
					}
					// Go to next image pressing the right key
					if (e.keyCode === 39) {
						plugin.next();
					}
					// Go to previous image pressing the left key
					if (e.keyCode === 37) {
						plugin.previous();
					}
				});
			}	
					
		}
		
		var BindEvents = function(){		
			
			//-Evento en facebook
			if(plugin.settings.SocialMedia){
				//-Facebook click
				$('#ctl-facebook').on('click', function () {
					var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";      	
      				var url="http://www.facebook.com/sharer.php?u=" + plugin.settings.imageUrl;
					
					nueva=window.open(url, 'Comparte en Fb', caracteristicas);
					
					e.preventDefault();
				});
				
				//mail click
				$('#ctl-mail').on('click', function () {
					//$.isFunction( options.onFacebook ) && options.onFacebook.call( this );
					
					e.preventDefault();
				});
				
				//-twitter click
				$('#ctl-twitter').on('click', function () {
					var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
			      	//nueva=window.open( "http://twitter.com/share", 'Comparte en twiter', caracteristicas);

					var dir = plugin.settings.imageUrl;//window.document.URL;
					var dir2 = encodeURIComponent(dir);
					var tit = window.document.title;
					var tit2 = encodeURIComponent(tit);
					
					nueva = window.open('http://twitter.com/?status='+tit2+',%20'+dir2+'', 'Comparte en twiter', caracteristicas);

					e.preventDefault();
				});
				
				//-print click
				$('#ctl-print').on('click', function () {
					//$.isFunction( options.onFacebook ) && options.onFacebook.call( this );
					
					e.preventDefault();
				});
				
				//-google+ click
				$('#ctl-gplus').on('click', function () {
					var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      				nueva=window.open("https://plus.google.com/share?url=" + plugin.settings.imageUrl, 'Comparte en g+', caracteristicas);
					
					e.preventDefault();
				});
			}
			
			//-Area fuera del contenedor
			$('#lightbox-row, #ctl-close,#lightbox-left, #lightbox-right, #lightbox-wrapper, #overlay' ).on('click', function (e) {
				if (this === e.target) {
					plugin.close();
					e.preventDefault();
				}
			});
			
			//-Previous click
			$('#ctl-prev').on('click', function () {
				plugin.previous();
				e.preventDefault();
			});
			
			//-Previous click
			$('#ctl-next').on('click', function () {
				plugin.next();
				e.preventDefault();
			});			
			
			//-Redimensionar ventana	
			$(window).resize(function () {
				/*if (!plugin.image) {
					return;
				}
				plugin.resizeImage();*/
				//SettingLightbox();
				ResizeImage();
				
			});

		}
		
		var DrawControlLeft = function(){
			var alink;
			var arrow;
			var left = $('#lightbox-left');
			
			arrow = document.createElement('div');
			$(arrow).attr('id', 'lgb-nav-previous');
			$(arrow).addClass('row nav-previous');//.addClass('left');
			$(arrow).appendTo(left);
			
			$(arrow).append('<a id="ctl-prev" title="Anterior" href="#"></a>');
				
			/*
			alink = document.createElement('a');
			$(alink).attr('href', '#');
			//$(arrow).addClass('nav-previous').addClass('left');
			$(alink).appendTo(arrow);*/
			
		}
		
		var DrawControlImage = function(){
			//lightbox-content
			var content = $('#lightbox-content');
			
			$(content).append(
				'<div id="container-image" class="row container-image">'+
				'<img id="ctl-image" class="ctl-image" src="" title="Tú Foto con el Guero" />'+
				'</div>'+
				'<div id="image-counter" class="row image-counter">'+
				'<img id="image-loading" src="img/loading2.gif" title=""/>'+
				'Imágen <span id="count-first">1</span> de <span id="count-last">4</span> &nbsp;'+
				'</div>');
		}
		
		
		
		var DrawControlRight = function(){
			var alink;
			var arrow;
			var right = $('#lightbox-right');
			
			/*arrow = document.createElement('div');
			$(arrow).attr('id', 'lgb-social');
			$(arrow).addClass('row').addClass('nav-social');
			$(arrow).appendTo(right);*/
			
			if(plugin.settings.CloseButton){
				$(right).append(
					'<div id="lgb-close" class="row lgb-close">'+
					'<a id="ctl-close" title="Cerrar" href="#"></a>'+
					'</div>');
			}
			
			if(plugin.settings.SocialMedia){
				$(right).append(
					'<div id="lgb-social-media" class="row social-media">'+
					'<a id="ctl-facebook" href="#" class="social-fb"></a>'+
					'<a id="ctl-mail" href="#" class="social-mail"></a>'+
					'<a id="ctl-twitter" href="#" class="social-twitter"></a>'+
					'<a id="ctl-print" href="#" class="social-print"></a>'+
					'<a id="ctl-gplus" href="#" class="social-gplus"></a>'+
					'</div>');
			}
			
			
			$(right).append(
				'<div id="lgb-nav-next" class="row nav-next">'+
				'<a id="ctl-next" href="#" title="Siguiente"></a>' +
				'</div>');
			
			
		}
		
		
		
        
 
 		//Aplicar blur al elemento
		var AplicarDesenfoque = function(el, size){
			var filterVal = 'blur('+size+'px)';
			$(el)
			.css('filter',filterVal)
			.css('webkitFilter',filterVal)
			.css('mozFilter',filterVal)
			.css('oFilter',filterVal)
			.css('msFilter',filterVal);
		}
        // fire up the plugin!
        // call the "constructor" method
        plugin.init();
 
    }
 
    // add the plugin to the jQuery.fn object
    $.fn.carouselLightbox = function(options) {
        // iterate through the DOM elements we are attaching the plugin to
        return this.each(function() {
			
            // if plugin has not already been attached to the element
            if (undefined == $(this).data('pluginName') ) {
 
                // create a new instance of the plugin
                // pass the DOM element and the user-provided options as arguments
                var plugin = new $.carouselLightbox(this, options);
                // in the jQuery version of the element
                // store a reference to the plugin object
                // you can later access the plugin and its methods and properties like
                // element.data('pluginName').publicMethod(arg1, arg2, ... argn) or
                // element.data('pluginName').settings.propertyName
                $(this).data('pluginName', plugin);
 
            }else{
				//alert($(p).data('pluginName', plugin));
				$(this).data('pluginName').open(options);
			} 
        }); 
    }
 
})(jQuery);