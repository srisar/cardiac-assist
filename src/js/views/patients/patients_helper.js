let moment = require('moment');

/**
 * Calculate the age value from the DoB field.
 * @param field_dob
 * @param field_age
 */
export function calculateAge(field_dob, field_age) {
    field_dob.on("apply.daterangepicker", function () {
        const dob = field_dob.val();
        field_age.val(getAge(dob));
    });
}

function getAge(dob) {
    const today = moment();
    const diff = moment.duration(today.diff(moment(dob)));
    return Math.round(diff.asYears());
}