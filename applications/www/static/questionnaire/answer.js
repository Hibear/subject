$.fn.answerSheet = function(options) {
    var defaults = {
        mold: 'card',
    };
	 var str = "";
    var opts = $.extend({},
    defaults, options);
	var lock = false;
    return $(this).each(function() {
        var obj = $(this).find('.card_cont');
        var _length = obj.length,
        _b = _length - 1,
        _len = _length - 1,
        _cont = '.card_cont';
        for (var a = 1; a <= _length; a++) {
            obj.eq(_b).css({
                'z-index': a
            });
            _b -= 1;
        }
        $(this).show();
        if (opts.mold == 'card') {
            obj.find('ul li label').click(function() {
                var _idx = $(this).parents(_cont).index(),
                 
                _cards = obj,
				
                _cardcont = $(this).parents(_cont);
				var type      =	$(this).attr("data-type");
			    if (_idx == _len) {
                    return;
                } else {
					 
				   var answer    = $(this).html();
				   var question  = $(this).parents(".select").find(".question").val();
				   var pid       = $(this).parents(".select").find(".pid").val();
				   if(window.tel == ""){
						layer.msg('电话不能为空');
						return ;
				   }
				   
				   if(window.name == ""){
					   layer.msg('姓名不能为空');
						return ;
				   }
				 
					
				   if(type == "1"){
					    str += answer+",";
						
						$('.card_bottom').find('.next').click(function() {
							$.ajax({
									url: "/Questionnaire/add_question",
									dataType:'json',
									type:'post',
									data:{
										pid:pid,
										answer:str,
										question:question,
										tel:tel,
										name:name
									},
									success: function(d){
										str = "";
										question = "";
										pid = "";
										answer = "";
									}
							});
						   
						 setTimeout(function() {
								_cardcont.addClass('cardn');
								setTimeout(function() {
									_cards.eq(_idx + 3).addClass('card3');
									_cards.eq(_idx + 2).removeClass('card3').addClass('card2');
									_cards.eq(_idx + 1).removeClass('card2').addClass('card1');
									_cardcont.removeClass('card1');
									lock = true;
								},
								200);
							},
							100);
					  });
					  
				   
			
				   }else{
					   
					   $.ajax({
							url: "/Questionnaire/add_question",
							dataType:'json',
							type:'post',
							data:{
								pid:pid,
								answer:answer,
								question:question,
								tel:tel,
								name:name
							},
							success: function(d){
								if(d.code == 1){
									layer.msg(d.msg);
									 return ;
								}
								
							}
						 });
					   setTimeout(function() {
								_cardcont.addClass('cardn');
								setTimeout(function() {
									_cards.eq(_idx + 3).addClass('card3');
									_cards.eq(_idx + 2).removeClass('card3').addClass('card2');
									_cards.eq(_idx + 1).removeClass('card2').addClass('card1');
									_cardcont.removeClass('card1');
								},
								200);
							},
							100);
						}
					 
				   }
				   
			});
			
			$(".sub").click(function(){
				var answer = $("#tips").val();
				if(answer == ""){
					layer.msg("信息不能为空");
					return ;
				}
				var question  = $(this).parents(".card").find(".question").val();
				$.ajax({
					url: "/Questionnaire/add_question",
					dataType:'json',
					type:'post',
					data:{
						pid:10,
						answer:answer,
						question:question,
						tel:tel,
						name:name
					},
					success: function(d){
						layer.msg(d.msg);
						$(".success"). fadeIn(800);
					}
				 });
			});
			
			
            $('.card_bottom').find('.prev').click(function() {
                var _idx = $(this).parents(_cont).index(),
                _cardcont = $(this).parents(_cont);
				
				obj.eq(_idx + 2).removeClass('card3').removeClass('cardn');
                obj.eq(_idx + 1).removeClass('card2').removeClass('cardn').addClass('card3');
                obj.eq(_idx).removeClass('card1').removeClass('cardn').addClass('card2');
				
                setTimeout(function() {
                    obj.eq(_idx - 1).addClass('card1').removeClass('cardn').removeClass('card3').removeClass('card2');
                },
                200);
            })
        }
    });
};