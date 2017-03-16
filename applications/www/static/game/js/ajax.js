var isOnline = 1;
var curUrl = window.location.href.toLowerCase();

//游戏结束后记录分数
function recordScore(Score) {
    $.post('/game/game_log',{'game_time':Score}, function(data){
        if(data){
            if(data.code == 0){
                alert(data.msg);
                return false;
            }else{
                if(data.status == 1){
                    $('.djBg.pop').attr('status', 1);
                }
                $('.zhengque.pop').attr('style', 'display: block;');
                $('#score').text(Score+'秒'); 
            }    
        }else{
            alert('网络异常！');
        }
    });
}






