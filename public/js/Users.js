$(document).ready(function() {
     $("#users").DataTable(
        {
        stateSave:true,
        "scrollX": true,
        columnDefs: [
            { width: '15%', targets: 0 },
            { width: '16%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '10%', targets: 3 },
            { "orderable": false, targets: 3 }
                ],
                "lengthMenu": [ 100, 500, 1000 ],
                "pageLength": 100,
                fixedColumns: true,
                initComplete: function () {
                    $('div.dataTables_filter input', this.api().table().container()).attr('id', 'mySearchInput');
                    $('div.dataTables_filter input', this.api().table().container()).attr('name', 'search_field');
                }
        }
    );
// New code to retain search value
// Restore state
    var table = $('#users').val();
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
    $(".delete_user").click(function(){
        const user_id = $(this).data('user-id');
        //alert(user_id);
        $('#delete_user_id').val(user_id);
        $("#deletedialog").dialog({
            title:'Are you sure?',
            dialogClass: "alert"
        });
    });
    $(".do-not-delete").click(function() {
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/admin/users';
    });
});
