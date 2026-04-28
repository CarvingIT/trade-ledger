$(document).ready(function() {
     $("#entities").DataTable(
        {
        stateSave:true,
        //"scrollX": true,
        columnDefs: [
                        { width: '20%', targets: 0 },
                        { width: '15%', targets: 1 },
                        { width: '15%', targets: 2 },
                        { width: '10%', targets: 3 },
                        { width: '15%', targets: 4 },
                        { width: '13%', targets: 5 },
                        { "orderable": false, targets: 5 }
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
    var table = $('#entities').val();
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
    $(".delete_entity").click(function(){
        const entity_id = $(this).data('entity-id');
        //alert(entity_id);
        $('#delete_entity_id').val(entity_id);
        $("#deletedialog").dialog({
            title:'Are you sure?',
            dialogClass: "alert"
        });
    });
    $(".do-not-delete").click(function() {
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/admin/entities';
    });

    $(".admin-dropdown").click(function(){
        $("#admin-dropdown-content").toggle();
    });
});

/*
$(document).on('click', function(e) {
    var container = $("#admin-dropdown-content"); // Replace #myDiv with your div's actual selector

    // Check if the clicked target is not the container and not a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide(); // Hide the div
    }
});
*/
