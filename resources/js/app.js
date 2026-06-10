import './bootstrap';

import { initModal } from './modal';
import { initLoadingButton } from './loading-button';
import { initAlert } from './alert';

document.addEventListener('DOMContentLoaded', () => {

    initModal();
    initLoadingButton();
    initAlert();

});