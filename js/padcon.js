jQuery(document).ready(function(){
			
			
			setHeight();	
			
			searchBar();
			
			
		});

function setHeight()
{		
	jQuery('#lineLeft').height(jQuery('#footer').position().top - (jQuery('#navigationSidebar').height() + jQuery('#header').height())+50);
	jQuery('#lineRight').height(jQuery('#footer').position().top - (jQuery('#infoSidebar').height() + jQuery('#header').height())-54);
}

function setFlashID()
{			
		swfobject.registerObject("FlashID");		
}

function imageUploadSlide()
{
	jQuery('#imageUpload').css('display','none');
			
	jQuery('input.imgEdit').click(function(){
		jQuery('#imageFix').hide('fast');
		jQuery('#imageFix').empty();
		jQuery('#imageUpload').show('fast');
	});
}

function searchBar()
{
	jQuery('#search').css('display','none');
	var height = jQuery('#lineLeft').height();
	jQuery('#lineLeft').height(height+(jQuery('#search').height()));
			
	jQuery('#searchBar').click(function(){
		
		if( $('#search').is(':hidden') ) {
		    jQuery('#search').show('fast');
		    jQuery('#search').css('display','visible');  
		    jQuery('#lineLeft').height(height);
		}
		else {
		    jQuery('#search').hide('fast');
		    jQuery('#search').css('display','hidden');
		    jQuery('#lineLeft').height(height+(jQuery('#search').height()));
		}
	});
}
