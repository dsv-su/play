import './bootstrap';
import _ from 'lodash';
import { Dropzone } from 'dropzone';
import 'preline';
import '@preline/carousel';

window._ = _;
window.Dropzone = Dropzone;

const initPreline = () => {
    window.HSStaticMethods?.autoInit();
};

document.addEventListener('DOMContentLoaded', async () => {
    await import('@preline/file-upload');
    window.HSFileUpload?.autoInit();
    initPreline();
});
