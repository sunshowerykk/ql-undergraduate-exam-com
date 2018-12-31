      	$(function(){
      		$('.userPop').click(function(){
      			$('.adminUser').fadeToggle();
      		})
      		
      		$('.menuDiv').click(function(){
    			 $('.headRight').addClass('ycDing');
      			 
      			  $('.menuBg').show().animate({
      				zIndex:'22',
      				opacity: '1'
      			},'slow')
      			  
      			  $('.heiBg').show().animate({
      				left: '75%',
      			},'slow')
      			  
      			 $('.headRight').animate({
      				position:'fixed',
      				left: '75%'
      			},'slow')
      		})	
      		
      		$('.heiBg').click(function(){
      			 $('.menuBg').animate({
      				zIndex:'-1'
      			},100)
      			 
      			 $('.heiBg').hide().animate({
      				left: '0',
      			},'slow')
      			  
      			 $('.headRight').animate({
      				position:'fixed',
      				left: '0'
      			},'slow',function(){
      				$('.headRight').removeClass('ycDing');
      				$('.menuBg').hide();
      			})
      			 
      			 
      		})
      		
      		
      	})