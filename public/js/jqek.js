
		$(function () {
			$(window).resize(function () {
				var h = Math.max($(window).height() - 0, 420);
				$('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
			}).resize();

			$('#tree')
				.jstree({
					'core' : {
						'data' : {
							'url' : '/fs/operations?operation=get_node',
							'data' : function (node) {
								return { 'id' : node.id };
							}
						},
						'check_callback' : function(o, n, p, i, m) {
							if(m && m.dnd && m.pos !== 'i') { return false; }
							if(o === "move_node" || o === "copy_node") {
								if(this.get_node(n).parent === this.get_node(p).id) { return false; }
							}
							return true;
						},
						'themes' : {
							'responsive' : true,
							'variant' : 'large',
							'stripes' : true
						}
					},
					'sort' : function(a, b) {
						return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
					},
					'contextmenu' : {
						'items' : function(node) {
							var tmp = $.jstree.defaults.contextmenu.items();
							delete tmp.create.action;
							tmp.create.label = "New";
							tmp.create.submenu = {
								// "create_folder" : {
								// 	"separator_after"	: true,
								// 	"label"				: "Folder",
								// 	"action"			: function (data) {
								// 		var inst = $.jstree.reference(data.reference),
								// 			obj = inst.get_node(data.reference);
								// 		inst.create_node(obj, { type : "default" }, "last", function (new_node) {
								// 			setTimeout(function () { inst.edit(new_node); },0);
								// 		});
								// 	}
								// },
								"createCProject" : {
									"label"				: "C Project",
									"action"			: function (data) {
										var inst = $.jstree.reference(data.reference),
											obj = inst.get_node(data.reference);
										inst.create_node(obj, { type : "cProject" }, "last", function (new_node) {
											setTimeout(function () { inst.edit(new_node); },0);
										});
									}
								},
								"createJavaProject" : {
									"label"				: "Java Project",
									"action"			: function (data) {
										var inst = $.jstree.reference(data.reference),
											obj = inst.get_node(data.reference);
										inst.create_node(obj, { type : "javaProject" }, "last", function (new_node) {
											setTimeout(function () { inst.edit(new_node); },0);
										});
									}
								},
								"createPythonProject" : {
									"label"				: "Python Project",
									"separator_after"   : true,
									"action"			: function (data) {
										var inst = $.jstree.reference(data.reference),
											obj = inst.get_node(data.reference);
										inst.create_node(obj, { type : "pythonProject" }, "last", function (new_node) {
											setTimeout(function () { inst.edit(new_node); },0);
										});
									}
								},
								"create_file" : {
									"label"				: "File",
									"action"			: function (data) {
										var inst = $.jstree.reference(data.reference),
											obj = inst.get_node(data.reference);
										inst.create_node(obj, { type : "file" }, "last", function (new_node) {
											setTimeout(function () { inst.edit(new_node); },0);
										});
									}
								}
							};
							if(this.get_type(node) === "file") {
								delete tmp.create;
							}
							return tmp;
						}
					},
					'types' : {
						'cProject' : {'icon' : 'cproject'},
						'javaProject' : {'icon' : 'javaproject'},
						'pythonProject' : {'icon' : 'pythonproject'},
						// 'default' : { 'icon' : 'folder' },
						'file' : { 'valid_children' : [], 'icon' : 'file' }
					},
					'unique' : {
						'duplicate' : function (name, counter) {
							return name + ' ' + counter;
						}
					},
					'plugins' : ['state','dnd','sort','types','contextmenu','unique']
				})
				.on('delete_node.jstree', function (e, data) {
					$.get('/fs/operations?operation=delete_node', { 'id' : data.node.id })
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('create_node.jstree', function (e, data) {
					console.dir(data);
					$.get('/fs/operations?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
						.done(function (d) {
							data.instance.set_id(data.node, d.id);
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('rename_node.jstree', function (e, data) {
					$.get('/fs/operations?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
						.done(function (d) {
							data.instance.set_id(data.node, d.id);
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('move_node.jstree', function (e, data) {
					$.get('/fs/operations?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
						.done(function (d) {
							//data.instance.load_node(data.parent);
							data.instance.refresh();
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('copy_node.jstree', function (e, data) {
					$.get('/fs/operations?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
						.done(function (d) {
							//data.instance.load_node(data.parent);
							data.instance.refresh();
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('changed.jstree', function (e, data) {
					if(data && data.selected && data.selected.length) {
						currentFile = data.selected.join(':');
						$.get('/fs/operations?operation=get_content&id=' + data.selected.join(':'), function (d) {
							if(d && typeof d.type !== 'undefined') {
								$('#data .content').hide();
								switch(d.type) {
									case 'png':
									case 'jpg':
									case 'jpeg':
									case 'bmp':
									case 'gif':
										$('#image img').one('load').attr('src',d.content);
										$('.CodeMirror').each(function(i, el){
   											$(this).hide();
										});
										$('#image').show();
										break;
									default:
									// case 'text':
									// case 'txt':
									// case 'md':
									// case 'htaccess':
									// case 'log':
									// case 'sql':
									// case 'php':
									// case 'js':
									// case 'json':
									// case 'css':
									// case 'html':
									// 	$('#data .code').show();
									// 	$('#code').val(d.content);
									// 	break;
									
									// default:
										$('#code').val(d.content);
										$('#image').hide();
										$('.CodeMirror').each(function(i, el){
   										el.CodeMirror.getDoc().setValue(d.content);
   										$(this).show();
										});

										break;
								}
							}
						});
					}
					else {
						$('#data .content').hide();
						$('#data .default').html('Select a file from the tree.').show();
					}
				});
		});
		
