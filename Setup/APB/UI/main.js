$(document).ready(function(){
	$('body').on('click', 'ul.APBLayouts > li', function(e){
		$('#'+$(this).data('fields')).val($(this).data('layoutval'));
		var APBBuilderParent = $(this).parent().parent().find('.APBLayoutsBuilder');
		$(this).parent().find('li').removeClass('layout-current');
		$(this).addClass('layout-current');
		APBBuilderParent.html('<div class="APBLoader"><svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"> <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path> <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"> <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"></animateTransform> </path> </svg></div>');
		$.ajax({
			url:HomeURL+'/wp-admin/admin-ajax.php',
			data:{"action":'APBLayoutsBuilder', "fields":$(this).data('fields'), "numb":$(this).parent().parent().data('numb'), "layout":$(this).data('layout')},
			type:'POST',
			success: function(msg) {
				$('body, html').animate({"scrollTop":APBBuilderParent.offset().top - ($(window).height() / 2) + 100});
				APBBuilderParent.html(msg);
			},
			error: function() {
				alert(errorAjax);
			}
		});
	});
	$('body').on('click', '.AddMoreGroup', function(e){
		var APBParentObject = $(this).parent().parent();
		var APBParentParent = $(this).parent();
		$.ajax({
			url:HomeURL+'/wp-admin/admin-ajax.php',
			data:{"action":'APBAddGroupFields', "metabox":$(this).data('metabox'), "numb":$(this).data('numb'), "group":$(this).data('group')},
			type:'POST',
			success: function(msg) {
				APBParentObject.after(msg);
				APBParentParent.remove();
				$('.LayoutsBuilderFooter + .LayoutsBuilderFooter').remove();
			},
			error: function() {
				alert(errorAjax);
			}
		});
	});
	$('body').on('click', '.AddMoreLayout', function(e){
		var APBParent = $(this).parent();
		$.ajax({
			url:HomeURL+'/wp-admin/admin-ajax.php',
			data:{"action":'APBAddLayoutBuilder', "numb":$(this).data('numb'), "metabox":$(this).data('metabox')},
			type:'POST',
			success: function(msg) {
				APBParent.parent().after(msg);
				APBParent.remove();
			},
			error: function() {
				alert(errorAjax);
			}
		});
	});
});
function NextItem(el) {
	var $Parent=$(el).parent().parent();
	if( $Parent.prev().hasClass('APBMainLayout') ) {
		$Parent.insertBefore($Parent.prev());
	}
}
function PrevItem(el) {
	var $Parent=$(el).parent().parent();
	if( $Parent.next().hasClass('APBMainLayout') ) {
		$Parent.insertAfter($Parent.next());
	}
}