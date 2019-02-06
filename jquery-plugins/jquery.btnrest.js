/**
 *
 * @name btnload
 * @version 0.1
 * @requires jQuery v1.7+
 * @author João Rangel
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 * For usage and examples, buy TopSundue:
 * 
 */
(function($){

 	$.fn.extend({ 
 		
		//pass the options variable to the function
 		btnrest: function(options) {

 			//Set the default values, use comma to separate the settings, example:
			var defaults = {
				debug:false,
				confirm:false,
				confirmText:'Deseja realmente continuar?',
				url:'',
				event:'click',
				success:function(r){},
				failure:function(r){

					if (r.responseJSON) {
						r = r.responseJSON;	
					} else if(r.responseText) {
						try{
							r = $.parseJSON(r.responseText);
						}catch(e){
							r = {success:false, error:e.message};
						}
					}

					alertify.alert(r.error || "Não foi possível executar está ação. Tente novamente mais tarde.").set('title', 'Erro');

				}
			};

			var o =  $.extend(defaults, options);

			if (!o.url) {

				console.error('Informe a URL');

			} else {

				return this.each(function() {
					
	    			var $btn = $(this);

	    			var fn = function(){

	    				$btn.btnload('load');

		    			var success = o.success;
		    			var failure = o.failure;

		    			o.success = function(r){

		    				$btn.btnload('unload');
		    				success(r);

		    			};

		    			o.failure = function(r){

		    				$btn.btnload('unload');
		    				failure(r);

		    			};

		    			rest(o);

	    			};

	    			$btn.on(o.event, function(){

	    				if (o.confirm === true) {

	    					alertify.confirm(o.confirmText, function (closeEvent) {

	    						if (closeEvent.cancel === false) {

	    							fn();

	    						}

	    					}).set('title', 'Confirmação');

	    				} else {

	    					fn();

	    				}

	    			});
				
	    		});

			}
    		
    	}
	});
	
})(jQuery);