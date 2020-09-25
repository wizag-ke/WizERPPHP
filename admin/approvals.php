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
start_bootstrap_form();
module_select_list('Select Module', 'module_name');
user_select_list('Select User', 'user_id');
bootstrap_table();
boostrap_submit_button('Save', 'btn-success');
end_bootstrap_form();
end_bootstrap_card();

?>

<script>
    $( document ).ready(function() {
        console.log( "ready!" );
    });  

    $( "#addUser" ).click(function() {
        addCompetitor();
    });


    function addCompetitor() {
            // var currentCompetitor = [];
            $('#approver_table > tbody').append(    '<tr>' + 
                                                    '<td>Jacob</td>' + 
                                                    '<td>Thornton</td>' + 
                                                    '</tr>'
                                                );
            // $("#competitor_name").val("");
            // $("#competitor_sow").val("");
        };
</script>

<!-- <script>
        $(document).ready(function() {
            $("#addCompetitor").click(function(){
                addCompetitor();
            }); 
            var services = {!! json_encode($client->services, JSON_HEX_TAG) !!};
            $('.select2').select2({width: '100%', data: services});
            setCompetitor();
        });

        var rowid = 0;
        function setCompetitor()
        {
            var currentCompetitor = {!! json_encode($client->competitorsArray, JSON_HEX_TAG) !!};
            console.log(currentCompetitor);
            currentCompetitor.forEach(element => {
                var name = element.name;
                var sow = element.sow;
                $('#competitor-table > tbody').append(  '<tr id = row' + rowid + '>' + 
                                                            '<td>' + name + '</td>' + 
                                                            '<td>' + sow + '</td>' +
                                                            '<td> <button id = "removeRow" type="button" class = "btn btn-xs btn-danger">delete</button></td>' +
                                                            '<td> <input type="hidden" value = "' + [name, sow] + '" name="competitor[][]"> </td>' + 
                                                        '</tr>'
                                                    );
            });
        }
        function addCompetitor() {
            var currentCompetitor = [];
            var name = $("#competitor_name").val();
            var sow = $("#competitor_sow").val();
            currentCompetitor.name = name;
            currentCompetitor.sow = sow;
            console.log(currentCompetitor);
            $('#competitor-table > tbody').append(  '<tr id = row' + rowid + '>' + 
                                                        '<td>' + name + '</td>' + 
                                                        '<td>' + sow + '</td>' +
                                                        '<td> <button id = "removeRow" type="button" class = "btn btn-xs btn-danger">delete</button></td>' +
                                                        '<td> <input type="hidden" value = "' + [name, sow] + '" name="competitor[][]"> </td>' + 
                                                    '</tr>'
                                                );
            rowid ++;
            $("#competitor_name").val("");
            $("#competitor_sow").val("");
        };

        $(document).on('click', "#removeRow", function(){ 
            $(this).parents('tr').remove();
            
        });  
    </script> -->

