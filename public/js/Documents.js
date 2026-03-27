$(document).ready(function() {
     $("#product-documents").DataTable(
        {
        stateSave:true,
        "scrollX": true,
        columnDefs: [
                        { width: '10%', targets: 0 },
                        { width: '10%', targets: 1 },
                        { width: '10%', targets: 2 },
                        { width: '10%', targets: 3 },
                        { width: '35%', targets: 4 },
                        { width: '10%', targets: 5 },
                        { width: '10%', targets: 6 },
                        { "orderable": false, targets: 6 }
                ],
                "lengthMenu": [ 100, 500, 1000 ],
                "pageLength": 100,
                fixedColumns: true
        }
    );
// New code to retain search value
// Restore state
    var table = $('#product-documents').val();
    if(table){
    var state = table.state.loaded();
    if ( state ) {
      table.columns().eq( 0 ).each( function ( colIdx ) {
        var colSearch = state.columns[colIdx].search;

        if ( colSearch.search ) {
          $( 'input', table.column( colIdx ).footer() ).val( colSearch.search );
        }
      } );

      table.draw();
    }

    // Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
            table
                .column( colIdx )
                .search( this.value )
                .draw();
        } );
    } );
    }

//
});

$(document).ready(function(){
    $(".delete_document").click(function(){
        const document_id = $(this).data('document-id');
        //alert(document_id);
        $('#delete_document_id').val(document_id);
        $("#deletedialog").dialog({
            title:'Are you sure?',
            dialogClass: "alert"
        });
    });
    $("#cancel-delete").click(function() {
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/admin/documents';
    });
    
    $(".admin-dropdown").click(function(){
        $("#admin-dropdown-content").toggle();
    });

});
