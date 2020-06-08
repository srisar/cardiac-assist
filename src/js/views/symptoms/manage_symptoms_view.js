// import {getSiteUrl, trimString} from "../../commom/helper";
// import {showErrorToast, showSuccessToast, showWarningToast} from "../../commom/toasts";
// import {makeInputFieldInvalid, resetInputFields} from "../../commom/forms/forms";
//
// let axios = require("axios").default;
//
// export function start() {
//
//     if (document.getElementById("view_add_symptom") == null) return false;
//
//     addNewSymptom();
//
//     loadAllSymptoms();
//
// }
//
// function addNewSymptom() {
//
//     let fields = {
//         "symptom_name": $("#field_symptom_name"),
//         "description": $("#field_description")
//     };
//
//     $("#btn_add_symptom").on("click", function () {
//
//         resetInputFields($("#form_add_symptom"));
//
//         console.log("adding a new symptom!");
//
//         let validated = true;
//
//         if (trimString(fields.symptom_name) === "") {
//             validated = false;
//             makeInputFieldInvalid(fields.symptom_name);
//         }
//
//
//         if (!validated) return false;
//
//         axios.post(`${getSiteUrl()}/api/symptoms/adding`, {
//             "symptom_name": trimString(fields.symptom_name),
//             "description": trimString(fields.description)
//         })
//             .then(response => {
//                 return response.data
//             })
//             .then(data => {
//
//                 showSuccessToast("Symptom added successfully");
//                 loadAllSymptoms();
//                 fields.symptom_name.val("");
//                 fields.description.val("");
//
//             })
//             .catch(error => {
//                 showErrorToast(error.response.data.message);
//             })
//
//
//     });
//
// }
//
// function loadAllSymptoms() {
//
//     axios.get(`${getSiteUrl()}/api/symptoms/all`)
//         .then(response => {
//             return response.data;
//         })
//         .then(data => {
//
//             const symptoms = data.symptoms;
//             populateSymptomsTable(symptoms);
//
//         })
//         .catch(error => {
//             showWarningToast("Unable to load existing symptoms.");
//         });
//
// }
//
// function populateSymptomsTable(symptoms) {
//
//     let table = $("#table_symptoms").DataTable();
//
//     table.rows().remove().draw();
//
//     for (const symptom of symptoms) {
//         table.row.add([
//             `<a class="btn_symptom" data-id="${symptom.id}" href="#">${symptom.symptom_name}</a>`,
//             `${symptom.description.substring(0, 100)}...`
//         ]);
//     }
//
//     table.draw();
//
//     editSymptom();
//
// }
//
// function editSymptom() {
//
//     $(".btn_symptom").on("click", function () {
//
//         const symptomId = $(this).attr("data-id").toString();
//
//         axios.get(
//             `${getSiteUrl()}/api/symptoms/find?id=${symptomId}`)
//             .then(response => {
//                 return response.data;
//             })
//             .then(data => {
//
//                 const symptom = data.symptom;
//
//                 const editModal = $("#modal_edit_symptom");
//
//                 let fields = {
//                     "id": $("#field_edit_id"),
//                     "symptom_name": $("#field_edit_symptom_name"),
//                     "description": $("#field_edit_description"),
//                 };
//
//
//
//                 fields.id.val(symptom.id);
//                 fields.symptom_name.val(symptom.symptom_name);
//                 fields.description.text(symptom.description);
//
//                 $("#label_edit_symptom_title").text("Edit " + symptom.symptom_name);
//
//                 editModal.modal('show');
//
//
//             })
//             .catch(error => {
//                 showErrorToast(error.response.data.message);
//             });
//
//     });
//
// }