"use strict"


function payementStatusDescription(status) {
    switch (status) {
        case 'paid':
            return `<span class="label label-inline label-light-success font-weight-bold">${status}</span>`;
            break;
        case 'unpaid':
            return `<span class="label label-inline label-light-primary font-weight-bold">${status}</span>`;
            break;
        default:
            return `<span class="label label-inline label-light-danger font-weight-bold">${status}</span>`;
            break;
    }
}

function statusDescription(status) {
    switch (status) {
        case 'paid':
            return `<span class="label label-inline label-light-warning font-weight-bold">${status}</span>`;
            break;
        case 'success':
            return `<span class="label label-inline label-light-success font-weight-bold">${status}</span>`;
            break;
        case 'unpaid':
            return `<span class="label label-inline label-light-primary font-weight-bold">${status}</span>`;
            break;
        case 'cancel':
            return `<span class="label label-inline label-light-danger font-weight-bold">${status}</span>`;
            break;
        case 'cancel_but_unpaid':
            return `<span class="label label-inline label-light-danger font-weight-bold">${status}</span>`;
            break;
        case 'complain':
            return `<span class="label label-inline font-weight-bold" style="color"#2596be">${status}</span>`;
            break;
        default:
            return `<span class="label label-inline label-light-info font-weight-bold">${status}</span>`;
            break;
    }

    // 'unpaid', 'paid', 'awaiting_supplier', 'on_process', 'on_shipping', 'received', 'success', 'complain', 'cancel', 'cancel_but_unpaid'
}