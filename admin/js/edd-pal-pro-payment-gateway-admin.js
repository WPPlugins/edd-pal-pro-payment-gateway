jQuery( document ).ready(function() {
        	
        	jQuery( "#edd_dialog" ).dialog({
        		modal: true, title: 'Subscribe Now', zIndex: 10000, autoOpen: true,
        		width: '500', resizable: false,
        		position: {my: "center", at:"center", of: window },
        		dialogClass: 'dialogButtons',
        		buttons: {
        			Yes: function () {
        				// $(obj).removeAttr('onclick');
        				// $(obj).parents('.Parent').remove();
        				var email_id = jQuery('#txt_user_sub_edd').val();

        				var data = {
        				'action': 'add_plugin_user_eddpaypal',
        				'email_id': email_id
        				};

        				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        				jQuery.post(ajaxurl, data, function(response) {
        					jQuery('#edd_dialog').html('<h2>You have been successfully subscribed');
        					jQuery(".ui-dialog-buttonpane").remove();
        				});

        				
        			},
        			No: function () {
        					var email_id = jQuery('#txt_user_sub_edd').val();

        				var data = {
        				'action': 'hide_subscribe_eddpaypal',
        				'email_id': email_id
        				};

        				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        				jQuery.post(ajaxurl, data, function(response) {
        					        					
        				});
        				
        				jQuery(this).dialog("close");
        				
        			}
        		},
        		close: function (event, ui) {
        			jQuery(this).remove();
        		}
        	});
        	jQuery("div.dialogButtons .ui-dialog-buttonset button").removeClass('ui-state-default');
        	jQuery("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");
        	jQuery("div.dialogButtons .ui-dialog-buttonpane .ui-button").css("width","80px");
        });