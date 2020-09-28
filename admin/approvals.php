<?php

$page_security = 'SA_SETUPDISPLAY';
$path_to_root="..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/users_db.inc");

page(_($help_context = "Approvals Setup"));

// ------------------------------------------------------------------

start_boostrap_card('Create Approval Workflow', 'bg-light', null);
error_div();
start_bootstrap_form("approval_form");
module_select_list('Select Module', 'module_name');
user_select_list('Select approvers from first to last', 'user_id');
bootstrap_table();
array_form_input('approvers_array');
boostrap_submit_button('Save', 'btn-success');
end_bootstrap_form();
end_bootstrap_card();

$test = "Hello";

?>

<script>
    $( document ).ready(function() {
        
    });  
    $( "#addUser" ).click(function() {
        addApprover();
    });
    $(document).on('click', "#removeRow", function(){ 
        var approver_to_remove =  $(this).parents('tr').find("input:hidden").val();
        approvers = approvers.filter(item => item !== approver_to_remove);
        $(this).parents('tr').remove();
        $('#approvers_array').val(approvers);
    }); 

    var approvers = [];
    function addApprover() {
        $( "#error_div" ).empty();
        if(checkDuplicateonApprovers($("#user_id").val()))
        {
            $( "#error_div" ).addClass( "alert alert-danger" );
            var errName = $("#error_div");
            errName.html("This approver has already been added");
            $("#error_div").show().delay(5000).fadeOut();
        }
        else 
        {
            $('#approver_table > tbody').append(    '<tr>' + 
                                                    '<td>' + ($( "#user_id option:selected" ).text()) + '</td>' + 
                                                    '<td> <button id = "removeRow" type="button" class = "btn btn-sm btn-danger">remove</button> </td>' + 
                                                    '<td> <input type = "hidden" value = "' + $("#user_id").val() + '" </td>' + 
                                                    '</tr>'
                                                );
            approvers.push($("#user_id").val());
            $('#approvers_array').val(approvers);
        }
    };

    function checkIfDuplicateExists(w){
        return new Set(w).size !== w.length 
    }

    function checkDuplicateonApprovers(approver)
    {
        if (approvers.includes(approver))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    $("#approval_form").submit(function(e) {

        e.preventDefault();
        var form = $(this);

        var module_name = $('#module_name').val();
        var approvers_array = approvers;

        // var url = form.attr('action');
        var url = "post_approvals.php";
        $.ajax({
            type: "POST",
            url: url,
            // data: form.serialize(),
            data: {module_name: module_name, approvers_array: approvers_array},
            success: function(data)
            {
                // console.log(data);
                var result = JSON.parse(data);
                if(result.status === "failure")
                {
                    console.log(result);
                    $( "#error_div" ).addClass( "alert alert-danger" );
                    var errName = $("#error_div");
                    errName.html(result.message);
                    $("#error_div").show().delay(5000).fadeOut();
                }
                else 
                {
                    console.log(result);
                }
            }
            });
    });
</script>

