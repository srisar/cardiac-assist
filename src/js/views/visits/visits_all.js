import * as addVisit from "./add_visit_view"
import * as editVisit from "./edit_visit_view"

export function all() {
    addVisit.start();
    editVisit.start();
}