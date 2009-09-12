var width = 500;
rules = {
	'/gifts/view': 550,
};
for (var rule in rules) {
	regexp = new RegExp(rule)
	if (jsonVars.here.match(regexp)) {
		width = rules[rule];
	}
}

tinyMCE_GZ.init({
	plugins : "safari,advlink", /* ,imagemanager,filemanager*/
	themes : 'advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
tinyMCE.init({
	mode : 'textareas',
	theme : 'advanced',
	plugins : "safari,advlink", /* ,imagemanager,filemanager */
	width: width,
	height: 200,
    theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,link,unlink,|,undo,redo,|,bullist,numlist,|,link,insertimage,insertfile',
	theme_advanced_buttons2 : '',
	theme_advanced_buttons3 : '',
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom"
});