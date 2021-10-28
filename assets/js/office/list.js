import '../common/list';

$(function () {
   $('#taula').bootstrapTable({
      cache: false,
      showExport: true,
      exportTypes: ['excel'],
      exportDataType: 'all',
      exportOptions: {
         fileName: "offices",
         ignoreColumn: ['options'],
      },
      showColumns: true,
      pagination: true,
      search: true,
      striped: true,
      sortStable: true,
      pageSize: 10,
      pageList: [10, 25, 50, 100],
      sortable: true,
      locale: $('html').attr('lang') + '-' + $('html').attr('lang').toUpperCase(),
   });
   var $table = $('#taula');
   $(function () {
      $('#toolbar').find('select').change(function () {
         $table.bootstrapTable('destroy').bootstrapTable({
            exportDataType: $(this).val(),
         });
      });
   });
});