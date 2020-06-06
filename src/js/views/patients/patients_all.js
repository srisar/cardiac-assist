import * as addPatient from "./add_patient_view";
import * as allPatients from "./all_patients_view"


export function all() {
    addPatient.start();
    allPatients.start();
}