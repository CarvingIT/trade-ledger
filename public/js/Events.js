$(document).ready(function() {
     $("#events").DataTable(
        {
        stateSave:true,
        "scrollX": true,
        columnDefs: [
                        { width: '10%', targets: 0 },
                        { width: '10%', targets: 1 },
                        { width: '30%', targets: 2 },
                        { width: '25%', targets: 3 },
                        { width: '10%', targets: 4 },
                        { width: '20%', targets: 5 },
                        { "orderable": false, targets: 5 }
                ],
                "lengthMenu": [ 100, 500, 1000 ],
                "pageLength": 100,
                fixedColumns: true
        }
    );
// New code to retain search value
// Restore state
    var table = $('#events').val();
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
    $(".delete_event").click(function(){
        const event_id = $(this).data('event-id');
        //alert(event_id);
        $('#delete_event_id').val(event_id);
        $("#deletedialog").dialog({
            title:'Are you sure?',
            dialogClass: "alert"
        });
    });
    $(".do-not-delete").click(function(){
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/admin/events';
    });

    $(".admin-dropdown").click(function(){
        $("#admin-dropdown-content").toggle();
    });

});
