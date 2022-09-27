$(function(){
	$('#fabu').click(function(){
		var html = $('#tip').html()
		layer.open({
			type: 1,
			title: false,

			shadeClose: true,
			area: ['500px', '550px'],
			skin: 'yourclass'
			,content: html
		});
	})
    $('#treaty').click(function(){
        var html = $('#fuwu_content').html()
        layer.open({
            type: 1,
            title: false,

            shadeClose: true,
            area: ['700px', '450px'],
            skin: 'yourclass'
            ,content: html
        });
    })
});
function new_href(href){
    // console.log(href)
    window.location.href =href
    $('.layui-layer').hide();
    $('.layui-layer-shade').remove();

}