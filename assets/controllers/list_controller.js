import { Controller } from 'stimulus';
import '../js/common/list';

export default class extends Controller {
    static targets = ['table'];
    static values = {
    }

    connect() {
      if (this.hasTableTarget) {
         $(this.tableTarget).bootstrapTable({
            cache: false,
            showExport: true,
            exportTypes: ['excel'],
            exportDataType: 'all',
            exportOptions: {
               fileName: "list",
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
            locale: global.locale + '-' + global.locale.toUpperCase(),
         });
         var $table = $(this.tableTarget);
         $(function () {
            $('#toolbar').find('select').change(function () {
               $table.bootstrapTable('destroy').bootstrapTable({
                  exportDataType: $(this).val(),
               });
            });
         });
      }
    }
}
