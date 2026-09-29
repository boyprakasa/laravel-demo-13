import Alpine from "alpinejs";
import $ from "jquery";
import * as bootstrap from "bootstrap";

window.$ = window.jQuery = $;
window.bootstrap = bootstrap;

import DataTable from "datatables.net-bs5";
import "datatables.net-buttons-bs5";
import "datatables.net-select-bs5";
import "laravel-datatables-vite";

window.DataTable = DataTable;
window.Alpine = Alpine;
Alpine.start();
