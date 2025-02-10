
import domReady from '@wordpress/dom-ready';
export default function backend() {

    domReady(() => {
        acf.addAction('render_block_preview', function (element, block) {

        });
    });
}
