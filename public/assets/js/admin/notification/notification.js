$(document).ready(function() {
    getData();
});


function getData()
{
    $('#datatables-reponsive').DataTable({
        processing: true,
        serverSide: true,
        ajax: "notification",
        
        columns: [
            { "data": "type" },
            { "data": "message" },
            { "data": "created_at" },
            { "data": "action" },
        ],
    });
}