// $(document).ready(function() {
//     $('#myTable').DataTable( {
//         columnDefs: [ {
//             targets: [ 0 ],
//             orderData: [ 0, 1 ]
//         }, {
//             targets: [ 1 ],
//             orderData: [ 1, 0 ]
//         }, {
//             targets: [ 4 ],
//             orderData: [ 4, 0 ]
//         } ]

//     } );
// } );

$(document).ready(function () {
    $('#myTable').DataTable({
        "language": {
            "sProcessing": "Provádím...",
            "sLengthMenu": "Zobraz záznamů _MENU_",
            "sZeroRecords": "Žádné záznamy nebyly nalezeny",
            "sInfo": "Zobrazuji _START_ až _END_ z celkem _TOTAL_ záznamů",
            "sInfoEmpty": "Zobrazuji 0 až 0 z 0 záznamů",
            "sInfoFiltered": "(filtrováno z celkem _MAX_ záznamů)",
            "sInfoPostFix": "",
            "sSearch": "Hledat:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "První",
                "sPrevious": "Předchozí",
                "sNext": "Další",
                "sLast": "Poslední"
            }
        }
    });
});