import './bootstrap';


import { initModal } from './modal';
import { initLoadingButton } from './loading-button';
import { initAlert } from './alert';
import { initSidebar } from './sidebar';


document.addEventListener('DOMContentLoaded', () => {

    initModal();
    initLoadingButton();
    initAlert();
    initSidebar();

});