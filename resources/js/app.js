require('./bootstrap');

require('./components/Kanban');
require('./components/Users');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
