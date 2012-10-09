$(document).ready(function(){ 
			$("*.hidden").parent().append('<span class="expandable"></span>');
			$("span.expandable").click(function(){
			
				$(this).parent().toggleClass("expanded");
				$(this).parent().find("*.hidden").toggle();
				
				$(this).parent().hover(function() {  
				}, function(){ 			
					$('*.expanded').removeClass("expanded");
					$(this).parent().find("*.hidden").hide();
				});
			});
		}); 