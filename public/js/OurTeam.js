$(document).ready(function() {
     $("#teammembers").DataTable(
        {
        stateSave:true,
        "scrollX": true,
        columnDefs: [
                        { width: '20%', targets: 0 },
                        { width: '10%', targets: 2 },
                        { width: '15%', targets: 3 },
                        { "orderable": false, targets: 4 }
                ],
                "lengthMenu": [ 100, 500, 1000 ],
                "pageLength": 100,
                fixedColumns: true
        }
    );
// New code to retain search value
// Restore state
    var table = $('#teammembers').val();
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
    $(".delete_teamuser").click(function(){
        const teamuser_id = $(this).data('teamuser-id');
        //alert(teamuser_id);
        $('#delete_teamuser_id').val(teamuser_id);
        $("#deletedialog").dialog({
            title:'Are you sure?',
            dialogClass: "alert"
        });
    });
    $(".do-not-delete").click(function() {
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/admin/ourteam';
    });
});
