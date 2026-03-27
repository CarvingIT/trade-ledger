$( function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker1" ).datepicker();
  } );


$(document).ready(function() {
    var start_date = document.getElementById("datepicker").value;
    var end_date = document.getElementById("datepicker1").value;
    var c = document.getElementById('document_category');
        var document_category = c.options[c.selectedIndex].value;
    
     $("#download_log").DataTable(
        {
        //stateSave:true,
        "serverSide":true,
        "processing":true,
        "ajax": '/admin/downloadlog_data?quarter_report_start_date='+start_date+'&quarter_report_end_date='+end_date+'&document_category='+document_category,
        "lengthMenu": [ 100, 500, 1000 ],
        //fixedColumns: true,
        ordering:true,
        }
    );
});

$(document).ready(function(){

    const form = document.getElementById("downloadLog");

    const dropdown = document.getElementById("document_category");
    dropdown.addEventListener("change", function() {
        // Submit the form automatically when the selection changes
        form.submit();
    });

    const start_d = document.getElementById("datepicker");
    start_d.addEventListener("change", function() {
        // Submit the form automatically when the date value changes
        form.submit();
    });

    const end_d = document.getElementById("datepicker1");
    end_d.addEventListener("change", function() {
        // Submit the form automatically when the date value changes
        form.submit();
    });
});
