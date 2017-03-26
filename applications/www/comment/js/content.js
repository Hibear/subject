/**
 * Created by Administrator on 2017-03-24.
 */
$(function() {

    // $.fn.raty.defaults.path = 'pingfen/lib/img';
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
        // target: '#function-hint_all',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        readOnly: true,
        score: 3,
        click: function(score, evt) {
            alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
    });


});

$(function() {

    // $.fn.raty.defaults.path = 'pingfen/lib/img';
    $('#function-demo_1').raty({
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
        // target: '#function-hint_all',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        readOnly: true,
        score: 5,
        click: function(score, evt) {
            alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
    });


});


$(function() {

    // $.fn.raty.defaults.path = 'pingfen/lib/img';
    $('#function-demo_2').raty({
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
        // target: '#function-hint_all',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        readOnly: true,
        score: 4,
        click: function(score, evt) {
            alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
    });


});


$(function() {

    // $.fn.raty.defaults.path = 'pingfen/lib/img';
    $('#function-demo_3').raty({
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
        // target: '#function-hint_all',
        cancel: false,
        targetKeep: true,
        targetText: '请选择评分',
        readOnly: true,
        score: 5,
        click: function(score, evt) {
            alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
    });


});