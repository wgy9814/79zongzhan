(function($, global) {
    var debug = false;
    var defaultSetting = {
        url: '/User/Post/uploadOrgImage',
        debug: false,
        browse_button: 'addfile',
        upload_button: 'up-file',
        container: document.getElementById('container'),
        fileNumber:4,
        countFile:4,
        imgCount:0,
        alert:0,
        mime_types: [{
            title: "Image files",
            extensions: "jpg,png,jpeg"
        }],
        max_file_size: '10mb'
    };
    global.jUploader = function(option) {
        option = $.extend(defaultSetting, option);
        debug = option.debug;
        this.init(option);
    };
    global.jUploader.prototype = {
        cache: {},
        uploader: {},
        uploadFiles: function() {
            var result = [];
            for (var p in this.cache) {
                result.push(this.cache[p]);
            }
            return result;
        },
        init: function(option) {
            //var cache = {};
            instance = this;
            //var debug = true;
            this.uploader = new plupload.Uploader({
                runtimes: 'html5,flash,html4',
                browse_button: option.browse_button, // you can pass an id...
                container: option.container, // ... or DOM Element itself
                url: option.url,
                flash_swf_url: 'scripts/plupload/Moxie.swf',

                filters: {
                    max_file_size: option.max_file_size,
                    mime_types: option.mime_types
                },

                init: {
                    PostInit: function() {
                        //document.getElementById('file-list').innerHTML = '';

                        document.getElementById(option.upload_button).onclick = function() {
                        	var on=$("#file-list .on").length;
                        	if(!on){
                        		alert('您未选取图片');
                        		return;
                        	}
                        	instance.uploader.start();
                        	
                            return false;
                        };

                        $('#file-list').on('click', '.cg-del', function() {
                            var uploadMsg = $(".uploadMsg span i");
                            var fileId = $(this).data('val');
                            var src = $('#'+fileId).find('img').attr('src');
                            var style = $('#'+fileId).find('span').attr('style');
                            var $this = $(this);
                            if(undefined == style)
                            {
                            	if (fileId) {
                                    instance.uploader.removeFile($(this).data('val'));
                                    $this.parents('li.pic_list').animate({ width: 0, opacity: 0 ,margin:0}, function() {
                                        delete(instance.cache[fileId]);
                                        $this.parents('li:first').remove();
                                        var fileLength = $(".file-list li").length;
                                        uploadMsg.eq(1).text(uploadMsg.eq(1).text()*1+1);
                                        defaultSetting.countFile=uploadMsg.eq(1).text()*1;
                                        uploadMsg.eq(0).text(fileLength)
                                    });
                                }
                                if($('#file-list li').length<2){
                                    $(".file-list").slideUp();
                                }
                            }else {
	                            // 删除图片
	                            $.ajax({
	                            	type: 'post',
	                            	url	: '/User/Post/deleteOrgImage',
	                            	dataType: 'json',
	                            	data:{img:src},
	                            	success: function(data) {
	                            		if(data.errno == 0)
	                            		{
	                            			if (fileId) {
	                                            instance.uploader.removeFile($this.data('val'));
	                                            $this.parents('li.pic_list').animate({ width: 0, opacity: 0 }, function() {
	                                                delete(instance.cache[fileId]);
	                                                $this.parents('li:first').remove();
	                                                var fileLength = $(".file-list li").length;
	                                                uploadMsg.eq(1).text(uploadMsg.eq(1).text()*1+1);
	                                                defaultSetting.countFile=uploadMsg.eq(1).text()*1;
	                                                uploadMsg.eq(0).text(fileLength)
	                                            });
	                                        }
	                                        if($('#file-list li').length<2){
	                                            $(".file-list").slideUp();
	                                        }
	                            		}
	                            		alert('删除成功！');
	                            		return 
	                            	}
	                            });
                            }
                        });
                    },

                    FilesAdded: function(up, files) {
                        var num = defaultSetting.fileNumber;
                        var uploadMsg = $(".uploadMsg span i");
                        var fileLength = $(".file-list li").length;
                        $(".file-list").slideDown();
                        var addPreview = function(file, imgsrc) {
                            if(fileLength>num-1){
                                uploadMsg.eq(1).text(0);
                                uploadMsg.eq(0).text(num)
                                return ;
                            }
                            $('#file-list').html($('#file-list').html() +
                                '<li class="pic_list on" id="' + file.id + '">' +
                                '    <div class="file-img"><img src="' + (imgsrc ? imgsrc : './images/file-i.png') + '"></div>' +
                                '    <div class="file-text">' +
                                '        <a class="cg-del" href="javascript:void(0);" data-val=' + file.id + '>移除</a>' +
                                '    </div>' +
                                '    <span class="progress"></span>' +
                                '</li>'
                            );
                            fileLength = $(".file-list li").length;
                            uploadMsg.eq(1).text(uploadMsg.eq(1).text()*1-1);
                            uploadMsg.eq(0).text(fileLength)
                            defaultSetting.countFile=uploadMsg.eq(1).text()*1;
                        };
                        plupload.each(files, function(file) {
                            //document.getElementById('file-list').innerHTML += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';

                            previewImage(file, addPreview);
                            
                        });
                    },


                    UploadProgress: function(up, file) {
                        //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                        debug && console.log(file.percent + '%');
                        $('#' + file.id).find('.progress').width(file.percent + '%');
                    },

                    FileUploaded: function(up, file, resp) {
                        //debug && console.log(resp);
                        $("#file-list li").removeClass("on");
                        
                        if (resp && resp.status == 200) {
                            var response = eval('(' + resp.response + ')');
                            // 图片上传成功后将图片src中的内容替换成功上传后生成的url
                            if(response.errno == 0)
                            {
                            	$('#' + file.id).find('img')[0].src = response.img;
                            }
                            
                            if (response) {
                                instance.cache[file.id] = response;
                                debug && console.log(response);
                            }
                        }
                    },

                    Error: function(up, err) {
                        //document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
                        debug && console.log("\nError #" + err.code + ": " + err.message);
                    }
                }
            });
        },
        start: function() {
            this.uploader.init();
        }
    }

    //plupload中为我们提供了mOxie对象
    //有关mOxie的介绍和说明请看：https://github.com/moxiecode/moxie/wiki/API
    //如果你不想了解那么多的话，那就照抄本示例的代码来得到预览的图片吧
    function previewImage(file, callback) { //file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
		
        if (!file || !/image\//.test(file.type)) {
            callback && callback(file);
            return;
        }; //确保文件是图片
        //debug && console.log(file);
        //if (!window.mOxie || !window.mOxie.Image) return;
        //alert(2);
        if (file.type == 'image/gif') { //gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
            var fr = new moxie.file.FileReader();
            debug && console.log(fr);
            fr.onload = function() {
                callback && callback(file, fr.result);
                fr.destroy();
                fr = null;
            }
            fr.readAsDataURL(file.getSource());
        } else {
            var preloader = new moxie.image.Image();
            //debug && console.log(preloader);
            preloader.onload = function() {
                //preloader.downsize(550, 400);//先压缩一下要预览的图片,宽300，高300
                var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                callback && callback(file, imgsrc); //callback传入的参数为预览图片的url
                preloader.destroy();
                preloader = null;
            };
            preloader.bind("embedded error", function(e) {
                debug && console.log(e);
            });
            //window.curfile = file;
            //debug && console.log(file.getSource());
            preloader.load(file.getSource());
        }
    }

})(jQuery, window);