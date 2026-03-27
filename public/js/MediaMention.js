$(document).ready(function() {
     $("#mediamentions").DataTable(
        {
        stateSave:true,
        "scrollX": true,
        columnDefs: [
                        { width: '30%', targets: 0 },
                        { "orderable": false, targets: 5 }
                ],
        order: [[3,'desc']],
        "lengthMenu": [ 100, 500, 1000 ],
        "pageLength": 100,
        fixedColumns: true
        //fixedColumns:{ left:1, right:1}

        }
    );
// New code to retain search value
// Restore state
    var table = $('#mediamentions').val();
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
    $(".delete_mediamention").click(function(){
        const mediamention_id = $(this).data('mediamention-id');
        alert(mediamention_id);
        $('#delete_mediamention_id').val(mediamention_id);
        $("#deletedialog").dialog({
            title:'Are you sure?',
            dialogClass: "alert"
        });
    });
    $(".do-not-delete").click(function() {
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/admin/mediamentions';
    });
});
