import './bootstrap';

//* jQuery module loader
//* npm i jquery
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;


//* sweetalert2 loader
//* npm i sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;

import select2 from 'select2';
select2();