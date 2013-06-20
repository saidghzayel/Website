// JavaScript Document

(function() {
	tinymce.create('tinymce.plugins.YourYouTube', {
		init : function(ed, url) {
			ed.addButton('youryoutube', {
				title : 'youryoutube.youtube',
				image : url+'/youtube.png',
				onclick : function() {
					idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
					var vidId = prompt("YouTube Video", "Enter the id or url for your video");
					var m = idPattern.exec(vidId);
					if (m != null && m != 'undefined')
						ed.execCommand('mceInsertContent', false, '[youtube id="'+m[1]+'"]');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "YouTube Shortcode",
				author : 'Brett Terpstra',
				authorurl : 'http://brettterpstra.com/',
				infourl : 'http://brettterpstra.com/',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('youryoutube', tinymce.plugins.YourYouTube);
})();