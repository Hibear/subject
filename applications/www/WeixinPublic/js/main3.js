 $(function(){


     $("#sub").click(function(){

        var index = 0;
         $(".list ul").empty();
         var find = $("#text").val();
         if(find == ""){
             layer.msg("搜索信息不能为空");
             return ;
         }

         $.ajax({
             type: "post",
             url : "/weixin/search_name",
             dataType:'json',
             data: {'find':find},
             beforeSend:function(){
                 index = layer.load(1);
             },
             success: function(data){


                 html  ="";
                 layer.close(index);
                 if(data != "nodata"){
                     var info = data;

                     var id = parseInt(info['id']);
                     // var url = '/index.php?m=&c=Index&a=user&id='+id+"&vid="+vid+"&token="+token;

                     var url = '/weixin/detail?id='+id;

                     html += '<a href="'+url+'">';

                     html+='<li class="post detail">';
                     html+='<div class="border-item">';
                     html+='<p class="detail"  style="background: url(/uploads/images/'+info['cover_img']+');"></p>';
                     html+='<p class="bh"><i>编号:'+info['id']+'</i><i>姓名:'+info['fullname']+'</i></p>';
                     html+='<p><i style="width:100%;">名称:'+info['title']+'</i></p>';
                     html+='<p style="color:#ebad2a;padding-bottom:10px;"><i class="dps">得票数:'+info['vote_num']+'</i></p>';
                     html+='<div class="ttp"><div class="tp" align="center" alt="'+info['id']+'">投票</div>';
                     html+='</div></li>';
                     html+='</a>';
                 }
                 else{
                     html+='<li style="width:95%; text-align: center;">没有找到你要找的演员</li>';
                 }
                 $("#user-list").append(html);

             }
         });



     });

    // $(document).on('click', '.detail', function(){
        // var id = $(this).attr('data-id');
        // console.log(id);
      //   window.open('/index.php/weixin/detail?id='+id, '_blank');
    // })


     $("#pm").click(function(){



         $(".list,.sousuo").hide();
         $(".page2").show();
         $(".page3").hide();

         var vid = $(this).attr("data-id");

         $.ajax({
             type: "post",
             url : "/index.php/Weixin/ranks",
             dataType:'json',
             data: {'vid':vid},
             success: function(da){
                html = "";
                 if(da.length>0){
                     for(var i=0;i<da.length;i++){

                         var url = '/index.php/weixin/detail?id='+da[i]['id'];
                         html += '<a href="'+url+'">';

                         html += '<li class="detail" data-id="'+da[i]['id']+'">';
                         n = i+1;
                         html +='<div class="rank-number detail">NO'+n+'</div>';
                         html +='<div class="rank-img" style="background: url(/uploads/images/'+da[i]['cover_img']+');"></div>';
                         html +='<div class="rank-info">';
                         html +="<p>姓名："+da[i]['fullname']+"</p>";
                         html +="<p>名称："+da[i]['title']+"</p>";
                         html +="<p>得票数："+da[i]['vote_num']+"</p>";
                         html +="</div>";
                         html += "</li>";

                         html+='</a>';
                     }
                     $(".rank-list").html(html);
                 }


             }
         });
     })



     $("#gzjl").click(function(){
         $(".list,.sousuo,.page2").hide();
         $(".page3").show();

     });

     $("#home").click(function(){
         $(".list,.sousuo").show();
         $(".page2,.page3").hide();
     });




});

	
