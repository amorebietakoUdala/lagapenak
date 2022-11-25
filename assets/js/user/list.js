import '../common/list';

import $ from 'jquery';

import {createConfirmationAlert} from '../common/alert';

$(function(){
	$('#taula').bootstrapTable({
		cache : false,
		showExport: true,
		iconsPrefix: 'fa',
		icons: {
			columns: 'fa-th-list',
			export: 'fa-download',
		},
		exportTypes: ['excel'],
		exportDataType: 'all',
		exportOptions: {
			fileName: "users",
			ignoreColumn: ['options']
		},
		showColumns: false,
		pagination: true,
		search: true,
		striped: true,
		sortStable: true,
		pageSize: 10,
		pageList: [10,25,50,100],
		sortable: true,
		locale: $('html').attr('lang')+'-'+$('html').attr('lang').toUpperCase(),
	});
	var $table = $('#taula');
	$(function () {
		$('#toolbar').find('select').change(function () {
			$table.bootstrapTable('destroy').bootstrapTable({
			exportDataType: $(this).val(),
			});
		});
	});
	$(document).on('click','.js-delete',function(e){
		e.preventDefault();
		var url = e.currentTarget.dataset.url;
		createConfirmationAlert(url);
	});
});