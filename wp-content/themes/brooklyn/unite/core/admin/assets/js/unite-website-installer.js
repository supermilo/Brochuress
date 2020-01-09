/* <![CDATA[ */
(function($){
	
	"use strict";
		
    $(document).ready(function(){
		
		var confirmed = true;
		var current_xml = "";
		
		$(".ut-choose-demo").on("click", function() {
			
			var $this = $(this);
			
			current_xml = $(this).data("xml");
			
			if( !$this.hasClass('ut-demo-importer-summary-loaded') ) {
			
				$.ajax({

					type: 'POST',
					url: ajaxurl,
					data: { 
						"action" : "ut_load_xml",
						"import_xml_start" : $(this).data("xml")
					},
					success: function( response ) {

					    console.log( response );

						if( typeof response.data === 'undefined' ) {
							
							confirmed = false;
							
							/* modal({
								type: 'error',
								title: 'Could not load XML!',
								size: 'large',
								closable: false,
								text: 'Please make sure to install PHP XML. For further Info please contact Theme Support.',
								buttons: [
									{

										text: 'Contact Support', 
										val: 'ok',
										eKey: true,
										addClass: 'ut-ui-button-health',
										onClick: function(dialog) {
											window.location = 'http://helpdesk.unitedthemes.com/'; 
											return true;
										}

									}                   

								]
							}); */
						   
						} else {
						
							// exchange pages
							$("#ut-demo-importer-summary-pages-"+current_xml).siblings(".ut-demo-summmary-loader").fadeOut( 800, function(){

								$("#ut-demo-importer-summary-pages-"+current_xml).text(response.data.post_count).fadeIn();

							});

							// exchange media
							$("#ut-demo-importer-summary-media-"+current_xml).siblings(".ut-demo-summmary-loader").delay(200).fadeOut( 800, function(){

								$("#ut-demo-importer-summary-media-"+current_xml).text(response.data.media_count).fadeIn();

							});

							// exchange comments
							$("#ut-demo-importer-summary-comments-"+current_xml).siblings(".ut-demo-summmary-loader").delay(400).fadeOut( 800, function(){

								$("#ut-demo-importer-summary-comments-"+current_xml).text(response.data.comment_count).fadeIn();

							});					

							// exchange terms
							$("#ut-demo-importer-summary-terms-"+current_xml).siblings(".ut-demo-summmary-loader").delay(600).fadeOut( 800, function(){

								$("#ut-demo-importer-summary-terms-"+current_xml).text(response.data.term_count).fadeIn();

							});

							// add xml post ID
							$("#ut-demo-importer-xml-post-id-"+current_xml).val(response.id).siblings(".ut-run-importer").delay(1600).queue( function() {

								$(this).removeAttr("disabled").text(importer_notices.xmlready);

							});

							$this.addClass('ut-demo-importer-summary-loaded');
						
						}

					},
					error: function( response ) {

						// could not execute
						modal({
							type: 'error',
							title: 'Ohhh something went wrong!',
							size: 'large',
							closable: false,
							text: 'Please Contact Theme Support.',
							buttons: [
								{

									text: 'Contact Support', 
									val: 'ok',
									eKey: true,
									addClass: 'ut-ui-button-health',
									onClick: function(dialog) {
										window.location = 'http://helpdesk.unitedthemes.com/'; 
										return true;
									}

								}                   

							],
						}); 

					}

				});
			
			}
			
			if( !confirmed && importer_notices.imported === "true" ) {
            
                modal({
                    type: 'warning',
                    title: 'A Demo has already been installed!',
                    size: 'large',
                    text: importer_notices.imported_message,
                    buttons: [
                        {   
                            text: 'Download Plugin', 
                            val: 'ok',
                            eKey: true,
                            addClass: 'ut-ui-button-yellow',
                            onClick: function(dialog) {
                                window.location = "http://wordpress.org/plugins/wordpress-database-reset/"; 
                                return true;
                            }
                        }                   
                                                              
                    ],
                });
            
            }
			
		});
                        
        if( importer_notices.error.length && importer_notices.missing_plugins === "true" ) {
            
            modal({
                type: 'error',
                title: 'Ohhh something is missing!',
                size: 'large',
                closable: false,
                text: importer_notices.error,
                buttons: [
                    {
                        
                        text: 'Install Plugins', 
                        val: 'ok',
                        eKey: true,
                        addClass: 'ut-ui-button-health',
                        onClick: function(dialog) {
                            window.location = importer_notices.dashboard; 
                            return true;
                        }
                        
                    }                   
                                                          
                ],
            }); 
        
        }

        if( importer_notices.error.length && importer_notices.missing_license === "true" ) {

            modal({
                type: 'warning',
                title: 'License Required!',
                size: 'large',
                closable: false,
                text: importer_notices.error,
                template: '<div class="modal-box"><div class="modal-inner"><div class="modal-title"></div><div class="modal-text"></div><div class="modal-buttons"></div></div></div>',
                buttons: [
                    {

                        text: 'Activate Brooklyn now!',
                        val: 'ok',
                        eKey: true,
                        addClass: 'ut-ui-button-yellow',
                        onClick: function(dialog) {
                            window.location = importer_notices.licensing;
                            return true;
                        }

                    }

                ],
            });

        }
        
        if( importer_notices.error.length && importer_notices.missing_plugins === "false" && importer_notices.missing_perm === "true" ) {
        
            modal({
                type: 'error',
                title: 'Ohhh something is missing!',
                size: 'large',
                closable: false,
                text: importer_notices.error,
                buttons: [
                    {
                        
                        text: 'Got it!', 
                        val: 'ok',
                        eKey: true,
                        addClass: 'ut-ui-button-health',
                        onClick: function(dialog) {
                            window.location = "https://codex.wordpress.org/Changing_File_Permissions#Using_an_FTP_Client"; 
                            return true;
                        }
                        
                    }                   
                                                          
                ],
            }); 
        
        }
         
	});

})(jQuery);
 /* ]]> */	