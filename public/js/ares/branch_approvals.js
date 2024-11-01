/* ------------------------------------------------------------------------------
*
*  # Datatables data sources
*
*  Specific JS code additions for agent users module
*
*  Version: 1.0
*  Latest update: Feb 2, 2020
*
* ---------------------------------------------------------------------------- */


$(function() {
    renderData();
    $('input[name="check_all"]').bind('click', function(){
        var status = $(this).is(':checked');
        $('input[type="checkbox"]').prop('checked', status);
    });
});

// This function would process the ajax call for the datatable
function processDataRender(response)
{
	var content = "";
    var data = response.data;

    for(var i=0; i<data.length; i++) 
    {
        var row = data[i];
        row.actions = "";
        row.chboxes = '';

        row.actions += " <a href='#' data-toggle='tooltip' data-placement='top' title='' ";
        row.actions += "data-original-title='View Agent' onclick='loadData(" + row.id + ")'><i class='fa fa-search'></i></a>  ";
        
        if(can_delete == true && row.branch_status == 0)
        {
            row.actions += " <a href='#' onClick='deleteRecord("+ row.id +")' data-toggle='tooltip' data-original-title='Delete Request'>";
            row.actions += " <i class='fa fa-trash'></i></a>";
        }

        if(row.branch_status == -1 && can_approve == true)
        {
            row.chboxes = '<input type="checkbox" name="record_ids[]" value="'+row.id+'">';
            row.branch_status = "<span class='badge badge-danger'>Pending Approval</span>";
        }
        else if(row.branch_status == -1)
        {
            row.branch_status = "<span class='badge badge-secondary'>Pending Approval</span>";
        }
        else if(row.branch_status == 1)
        {
            row.branch_status = "<span class='badge badge-success'>Active</span>";
        }

        row.createdat = dateToReadableTime(row.createdat);
        row.created_by = row.firstname + " " + row.lastname;
    }
    return data;
}

// this function is responsible for loading all the data into the dataTable
function renderData() 
{
    if ($.fn.dataTable.isDataTable('#records_list')) {
        $('#records_list').DataTable().destroy();
    }
	
    cols = ['chboxes', 'branch_description', 'branch_code', 'branch_address', 'created_by', 'branch_status', 'createdat', 'actions'];
    
    var filters = getFilters();
    filters.branch_status = 'pending';
    var columns = [];

    for(var i in cols) {
        columns.push({"data":cols[i]});
    }
    
    $('#records_list').DataTable( {
        serverSide: true,
        ordering: false,
        columns: columns,
        ajax: {
            url : WEBSITE_URL + "branches/get_all",
            type: "get",
            data: filters,
            dataSrc: function ( response ) {
            	return processDataRender(response);
            }
        },
        stateSave: true,
        "initComplete": function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        },
        "drawCallback": function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        }
    });
}

// Function is called to load edit of data
function loadData(id)
{
    $('#view-branch-approval-modal').modal('show');
    loadingBlockUI('#view-branch-approval-modal');
    $("input[name='approve-id']").val("");
    // Set the expected record id
    var postdata = {};
    $.get(WEBSITE_URL + "branches/get/" + id, postdata, function(response){
        if(response.status == "success")
        {
            var data = response.data
            // Set the approval id
            $("input[name='approve-id']").val(data.id);
            // Process the status text
            branch_status = "<span class='badge badge-secondary'>Unknown</span>";
            if(data.branch_status == 0){
                branch_status = "<span class='badge badge-danger'>Inactive</span>";
            }
            else if(data.branch_status == -1){
                branch_status = "<span class='badge badge-secondary'>Pending Approval</span>";
            }
            else if(data.branch_status == 1){
                branch_status = "<span class='badge badge-success'>Approved</span>";
            }
            // Load the data into the form
            $("#td-branch_description").html(data.branch_description);
            $("#td-branch_code").html(data.branch_code);
            $("#td-branch_address").html(data.branch_address);
            $("#td-state_id").html(data.state_details.statename);
            $("#td_initiated_by").html(data.firstname + ' ' + data.lastname);
            $("#td_approval_status").html(branch_status);
            $("#td_createdat").html(dateToReadableTime(data.createdat));
        }
        else
        {
            $('#view-branch-approval-modal').modal('hide');
            // Call the sweet alert to display the error
            swal({title: "Error!", text: response.message, confirmButtonColor: "#2196F3", type: "error"});
        }
    })
    .done(function(){
        // Call function to release the UI
        finishedLoading();
    })
    .fail(function(xhr, statusText, errorThrown) {
        // Call function to release the UI
        finishedLoading();
        // Now call function that would process the cause of the failure
        ajaxFailureResponse(xhr.status, '#view-branch-approval-modal');
    });
}

// Method to delete a record
function deleteRecord(id)
{
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            // block the UI with a loading icon
            loadingBlockUI('body');
            var postdata = {id: id};
            $.post(WEBSITE_URL + "device_approvals/delete", postdata, function(response){
                if(response.status == "success")
                {
                    // Refresh the list
                    renderData('records_list');
                    // Display a success message to the user
                    swal({title: "Success!", text: response.message, confirmButtonColor: "#66BB6A", type: "success"});
                }
                else
                {
                    // Call the sweet alert to display the error
                    swal({title: "Error!", text: response.message, confirmButtonColor: "#2196F3", type: "error"});
                }
                // Update the page with the new CSRF
                $("input[name='csrf_token']").val(response.csrf_token);
            })
            .done(function(){
                // Call function to release the UI
                finishedLoading();
            })
            .fail(function(xhr, statusText, errorThrown) {
                // Call function to release the UI
                finishedLoading();
                // Now call function that would process the cause of the failure
                ajaxFailureResponse(xhr.status, 'body');
            });
        }
    })
}

// Method to activate an agent
function approveRecords()
{
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this action!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, aprove it!'
    }).then((result) => {
        if (result.value)
        {
            // block the UI with a loading icon
            loadingBlockUI('body');
            var postdata = {};
            // Get the selected readings to approve
            var record_ids = new Array();
            $("input[name='record_ids[]']:checked").each(function() {
                record_ids.push($(this).val());
                postdata.record_ids = record_ids;
            });
            postdata.csrf_token = $("input[name='csrf_token']").val();
            $.post(WEBSITE_URL + "branches/approve", postdata, function(response){
                if(response.status == "success")
                {
                    // Refresh the list
                    renderData();
                    // Display a success message to the meter_type
                    swal({title: "Success!", text: response.message, confirmButtonColor: "#66BB6A", type: "success"});
                }
                else
                {
                    // Call the sweet alert to display the error
                    swal({title: "Error!", text: response.message, confirmButtonColor: "#2196F3", type: "error"});
                }
                // Update the page with the new CSRF
                $("input[name='csrf_token']").val(response.csrf_token);
            })
            .done(function(){
                // Call function to release the UI
                finishedLoading();
            })
            .fail(function(xhr, statusText, errorThrown) {
                // Call function to release the UI
                finishedLoading();
                // Now call function that would process the cause of the failure
                ajaxFailureResponse(xhr.status, 'body');
            });
        }
    })
}

// Method to approve a single branch selection
function approve()
{
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this action!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, aprove it!'
    }).then((result) => {
        if (result.value)
        {
            $('#view-branch-approval-modal').modal('hide');
            // block the UI with a loading icon
            loadingBlockUI('body');
            var postdata = {};
            postdata.record_ids = [$("input[name='approve-id']").val()];
            postdata.csrf_token = $("input[name='csrf_token']").val();
            $.post(WEBSITE_URL + "branches/approve", postdata, function(response){
                if(response.status == "success")
                {
                    // Refresh the list
                    renderData();
                    // Display a success message to the meter_type
                    swal({title: "Success!", text: response.message, confirmButtonColor: "#66BB6A", type: "success"});
                }
                else
                {
                    // Call the sweet alert to display the error
                    swal({title: "Error!", text: response.message, confirmButtonColor: "#2196F3", type: "error"});
                }
                // Update the page with the new CSRF
                $("input[name='csrf_token']").val(response.csrf_token);
            })
            .done(function(){
                // Call function to release the UI
                finishedLoading();
            })
            .fail(function(xhr, statusText, errorThrown) {
                // Call function to release the UI
                finishedLoading();
                // Now call function that would process the cause of the failure
                ajaxFailureResponse(xhr.status, 'body');
            });
        }
    })
}