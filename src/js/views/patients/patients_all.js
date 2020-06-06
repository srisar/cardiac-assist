import * as addPatient from "./add_patient_view";
import * as editPatient from "./edit_patient.view";
import * as allPatients from "./all_patients_view"


export function all() {
    addPatient.start();
    allPatients.start();
    editPatient.start();
}