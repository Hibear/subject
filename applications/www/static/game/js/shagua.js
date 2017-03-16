
var ques=[
    {
        ques:"1/5 你认为自己成熟吗？",
        image:"/static/game/images/sb4.jpg",
        right:"",
        options:[
            {val:1,image:"太单纯了"},
            {val:2,image:"还行，懂点事"},
            {val:3,image:"我很成熟"}
        ]
    },
    {
        ques:"2/5 如果你看到一只小绵羊蹲在树梢上哀叫，你会：",
        image:"/static/game/images/s_b_1.jpg",
        right:"",
        options:[
            {val:1,image:"从树上救下小绵羊"},
            {val:2,image:"喊人来看"},
            {val:3,image:"朝小绵羊作个鬼脸，走人"}
        ]
    },
    {
        ques:"3/5 如果我现在告诉你你中奖了，是宇宙最佳弱智提名奖，你将有何感想？",
        image:"/static/game/images/s_b_2.jpg",
        right:"",
        options:[
            {val:1,image:"靠，被骗了"},
            {val:2,image:"骗人！我那有那么幸运？"},
            {val:3,image:"放屁！你才是弱智！"}
        ]
    },
    {
        ques:"4/5 如果我再次声明你真的中奖了，你会",
        image:"/static/game/images/s_b_3.jpg",
        right:"",
        options:[
            {val:1,image:"太无地自容了"},
            {val:2,image:"才个提名奖唠叨什么！"},
            {val:3,image:"放狗屁！想骗我没门！"}
        ]
    },
    {
        ques:"5/5 感觉我是不是问的太多了",
        image:"/static/game/images/sb1.jpg",
        right:"",
        options:[
            {val:1,image:"没有，继续"},
            {val:2,image:"恩，有点多"},
            {val:3,image:"还行，看答案吧"}
        ]
    }
];

$(document).ready(function(){
    $("#btn-begin").click(function(){
        $('#bheader').show();
        $('.container').attr('style', '');
        $("#begin").hide();
        $($(".ques")[0]).show();
    });
    addQues(ques);
});
//遍历所有的问题，并添加到页面
function addQues(list){
    var $quesList = $("#quesList");
    var length = list.length;
    for(var i=0;i<list.length;i++){
        var ques = list[i];
        var html = '<div class="ques" style="display:none;"><img class="img-responsive" src="'+ques.image+'">';
        html+='<dl><dd>'+ques.ques+'</dd></dl><ul class="list-group">';
        var options = ques.options;
        for(var j=0;j<options.length;j++){
            html+='<li class="list-group-item" id="sub" onclick="toggle(this,'+options[j].val+');">'+options[j].image+'</li>';
        }
        html+='</ul></div>';
        $quesList.append(html);
    }
}
//选择选项
function toggle(t,num) {
    //获取总分
    var total = $('.container').attr('data');
    var now;
    switch(num) {
        case 1:
            now = 5;
            break;
        case 2:
            now = 3;
            break;
        case 3:
            now = 1;
            break;
        default:
            now = 0;    
    }
    total = parseInt(total) + parseInt(now);
    $('.container').attr('data', total);
    var $li = $(t);
    $li.addClass("active");
    setTimeout(function() {
        next(t);
    }, 500);
}
//下一题
function next(v) {
    var $view = $(v).parents("div.ques");
    var $next = $view.next();
    $view.hide();
    if ($next.length>0) {
        $next.show();
    } else {
        showResult();
    }
}
function showResult(){
    var total = $('.container').attr('data');
    $.post('/house/getresult', {'total':total}, function(data){
        if(data){
            if(data.code == 1){
                $('#callbacktitle').text('您是：'+data.type);
                $('#callbackmsg').text(data.msg);
                $('#result').show();
                $('#data').attr('title', data.type);
                $('#data').attr('desc', data.msg);
            }else{
                alert('捣乱的请走开');
            }
        }else{
            alert('网络异常');
        }
    });
}
