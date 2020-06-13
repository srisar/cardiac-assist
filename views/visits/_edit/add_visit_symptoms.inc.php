<!--
|
| modal: show add visit symptoms
|
-->

<div class="modal fade" id="modal_add_visit_symptoms" tabindex="-1" role="dialog" aria-labelledby="modal_add_visit_symptoms" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_add_visit_symptoms_title">Add symptoms to visit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="field_search_symptoms">Search for symptoms</label>
                    <input type="text" id="field_search_symptoms" class="form-control" autocomplete="off">
                </div>

                <div id="area_show_add_symptom_to_db"></div>

                <table class="table table-bordered datatable_basic" id="table_symptoms_results">
                    <thead>
                    <tr>
                        <th>Symptom</th>
                        <th style="width: 30px"></th>
                    </tr>
                    </thead>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
