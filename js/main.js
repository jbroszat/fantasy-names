function initSubmit(cat) {
	$("#cat-"+cat).find("form").submit(function(){
		var params = $(this).serialize();
		$("#namelist-"+cat).load('ajax.php',params,function(){
			$("#cat-"+cat).trigger("create");
		});
		return false;
	});
}

function initCatList(cat) {
	$(document).delegate("#page", "pageinit", "initSubmit("+cat+")");
}

function createList(cat) {
	alert(cat);
	$("#cat-"+cat).trigger("create");
}

var xhr;

$(document).delegate(":jqmData(role=page)", "pageinit", function(){
	$(":jqmData(role=page)").children(":jqmData(role=content)").find("form").submit(function(){
		var params = $(this).serialize();
		var cat = $(this).children("[type='hidden']").val();
		$("#namelist-"+cat).load('ajax.php',params,function(a,b,c){
			$.mobile.activePage.trigger("create");
		});
		return false;
	});
});

