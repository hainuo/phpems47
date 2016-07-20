/**
 * @file 播放音乐插件
 */

(function()
{
	var musicDialog = function( editor, dialogType )
	{
		return {
			title : '添加段落标题',
			minWidth : 420,
			minHeight : 80,
			onOk : function()
			{
				var musicTitle = this.getValueOf( 'Link', 'txtTitle');
				var tempvar= '<h1 class="wikititle">'+musicTitle+'</h1>';
				editor.insertHtml(tempvar);
			},
			contents : [
				{
					id : 'Link',
					label : '段落标题',
					padding : 0,
					type : 'vbox',
					elements :
					[
						{
							type : 'vbox',
							padding : 0,
							children :
							[
								{
									id : 'txtTitle',
									type : 'text',
									label : '填写段落标题',
									style : 'width: 60%',
									'default' : ''
								}
							]
						}
					]
				}
			]
		};
	};
	CKEDITOR.dialog.add( 'wikititle', function( editor )
		{
			return musicDialog( editor, 'wikititle' );
		});
})();
