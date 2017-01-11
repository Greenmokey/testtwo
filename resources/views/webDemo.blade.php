<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes"/>
    <title>测试</title>
    <style>
        .comm-poto {
            width: 100%;
            padding-top: 15px;
            padding-left: 10px;
            padding-bottom: 15px;
        }

        .comm-poto a {
            border: 1px solid #e5e5e5;
            background: #fcfcfc;
            width: 75px;
            height: 75px;
            text-align: center;
            vertical-align: middle;
            display: inline-block;
            margin-right: 2.333%;
            margin-bottom: 5px;
        }

        .comm-poto a:last-child {
            margin-right: 0;
        }

        .comm-poto a img {
            width: 100%;
            height: 100%;
        }

        .comm-poto a span {
            width: 20px;
            height: 20px;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <input type="button" onclick="addImg()" value="选择图片">
    <div id="divAddImg" class="comm-poto">
    <input type="button" onclick="saveImg()" value="保存">
</div>
</body>
<script src="{{asset('resources/org/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('chooseImage', 'previewImage', 'uploadImage', 'onMenuShareAppMessage'), false) ?>);
</script>
<script>
    var images = {
        localId: [],
        serverId: []
    };

    wx.ready(function(){
        wx.onMenuShareAppMessage({
            title: '分享标题', // 分享标题
            desc: '分享描述', // 分享描述
            link: "http://www.baidu.com", // 分享链接
            imgUrl: "http://pic2.ooopic.com/12/32/24/38bOOOPIC6f_1024.jpg", // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        
    });

    function addImg() {
        wx.chooseImage({
            count: 9, // 默认9，大于9也是显示9
            sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有 'original',
            success: function (res) {
                images.localId = res.localIds;
                $.each(images.localId, function (i, v) {
                    $("#divAddImg").prepend("<a onclick=''><img class='comment_img' src='" + v + "'></a>");
                });
                uploadImg();
            }
        });
    }

    function uploadImg() {
        for (var i = 0; i < images.localId.length; i++) {
            wx.uploadImage({
                localId: images.localId[i], // 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    var serverId = res.serverId; // 返回图片的服务器端ID
                    images.serverId.push(serverId);
                },
                fail: function (res) {
                }
            });
        }
    }
    
    function saveImg() {
        var url = "{{url('/saveImg')}}";
        $.ajax({
            url: url,
            type: "POST",
            data: {_token: '{{csrf_token()}}', images: images.serverId},
            dataType: 'json',
            success: function (data) {
                if(data.status == 0){
                    alert(data.msg);
                }else{
                    alert(data.msg);
                }
            },
            error: function () {
                alert('保存失败！');
            }
        });
    }
    
</script>
</html>