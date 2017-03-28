/**
 * Created by Administrator on 2017-03-22.
 */
$(function() {

    var star_h = 0;
    var star_f = 0;
    var star_k = 0;

    $('#function-demo_h').raty({
        number: 5, //多少个星星设置
        targetType: 'hint', //类型选择，number是数字值，hint，是设置的数组值
        path: '/comment/pingfen/demo/img',
        hints: ['差', '一般', '好', '非常好', '全五星'],
        cancelOff: 'cancel-off-big.png',
        cancelOn: 'cancel-on-big.png',
        size: 24,
        starHalf: 'star-half-big.png',
        starOff: 'star-off-big.png',
        starOn: 'star-on-big.png',
        target: '#function-hint_h',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        click: function(score, evt) {
            // alert('ID: ' + $(this).attr('id') + "\nscore______: " + score + "\nevent: " + evt.type);
            star_h = score;
            star_click(star_h,star_f,star_k);

        }
    });

    $("#function-demo_h").val();



    $('#function-demo_f').raty({
        number: 5, //多少个星星设置
        targetType: 'hint', //类型选择，number是数字值，hint，是设置的数组值
        path: '/comment/pingfen/demo/img',
        hints: ['差', '一般', '好', '非常好', '全五星'],
        cancelOff: 'cancel-off-big.png',
        cancelOn: 'cancel-on-big.png',
        size: 24,
        starHalf: 'star-half-big.png',
        starOff: 'star-off-big.png',
        starOn: 'star-on-big.png',
        target: '#function-hint_f',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        click: function(score, evt) {
            // alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
            star_f = score;
            star_click(star_h,star_f,star_k);

        }
    });



    $('#function-demo_k').raty({
        number: 5, //多少个星星设置
        targetType: 'hint', //类型选择，number是数字值，hint，是设置的数组值
        path: '/comment/pingfen/demo/img',
        hints: ['差', '一般', '好', '非常好', '全五星'],
        cancelOff: 'cancel-off-big.png',
        cancelOn: 'cancel-on-big.png',
        size: 24,
        starHalf: 'star-half-big.png',
        starOff: 'star-off-big.png',
        starOn: 'star-on-big.png',
        target: '#function-hint_k',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        click: function(score, evt) {
            // alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
            star_k = score;
            star_click(star_h,star_f,star_k);


        }
    });

    $('#function-demo_all').raty({
        number: 5, //多少个星星设置
        targetType: 'hint', //类型选择，number是数字值，hint，是设置的数组值
        path: '/comment/pingfen/demo/img',
        hints: ['差', '一般', '好', '非常好', '全五星'],
        cancelOff: 'cancel-off-big.png',
        cancelOn: 'cancel-on-big.png',
        size: 24,
        starHalf: 'star-half-big.png',
        starOff: 'star-off-big.png',
        starOn: 'star-on-big.png',
        target: '#function-hint_all',
        cancel: false,
        targetKeep: true,
        readOnly: true,
    });

    $("#add_pic").click(function () {
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            		alert(localIds);
		}
        });
    }); 



    $("#btn").click(function () {

        var index = 0;
        var input_1 = $(".ipt_1").val();
        var input_2 = $(".ipt_2").val();
        
        var image_num = $(".img_num").val();
        
        alert(image_num);

        if(input_1 == ""){
            layer.msg("评论不能为空");
            return ;
        }
        if(input_2 == ""){
            layer.msg("价格不能为空");
            return ;
        }
        if(star_h == 0){
            layer.msg("请对环境进行评分");
            return ;
        }
        if(star_f == 0){
            layer.msg("请对服务进行评分");
            return ;
        }
        if(star_k == 0){
            layer.msg("请对口味进行评分");
            return ;
        }

        var score_all = star_h+star_f+star_k;

        $.ajax({
            type:"post",
            url:"/index.php/Comment/add",
            dataType:'json',
            data:{'input_1':input_1,'input_2':input_2,'score_all':score_all},
            // beforeSend:function () {
            //     index = layer.load(1);
            // },
            success:function (data) {
                alert(data['info']);
            }



        })



    })


});


function star_click(star_h,star_f,star_k) {

    var score_s = star_h+star_f+star_k;
    // alert(score_s+"--------------");

    if(score_s<=5){
        scoreall = 1;
    }
    if(score_s >=6 && score_s<=8){
        scoreall = 2;
    }
    if(score_s >=9 && score_s<=11){
        scoreall = 3;
    }
    if(score_s >=12  && score_s<=14){
        scoreall = 4;
    }
    if(score_s ==15){
        scoreall = 5;
    }

    $('#function-demo_all').raty({
        number: 5, //多少个星星设置
        targetType: 'hint', //类型选择，number是数字值，hint，是设置的数组值
        path: '/comment/pingfen/demo/img',
        hints: ['差', '一般', '好', '非常好', '全五星'],
        cancelOff: 'cancel-off-big.png',
        cancelOn: 'cancel-on-big.png',
        size: 24,
        starHalf: 'star-half-big.png',
        starOff: 'star-off-big.png',
        starOn: 'star-on-big.png',
        target: '#function-hint_all',
        cancel: false,
        targetKeep: true,
        // targetText: '请选择评分',
        readOnly: true,
        score: scoreall,
        click: function(score, evt) {
            alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
    });

}


$(function () {













});













