export default function slider() {
    console.log('test');
    async function getComponent() {
        console.log('loading');

        return await import(/* webpackChunkName: "swiper" */ 'swiper/dist/js/swiper.esm.js');
    }

    getComponent()
        .then(component => {
            console.log(component);
            const Swiper = component;
            component.Swiper.use([component.Navigation, component.Pagination]);
            var swiper = new component.Swiper('.swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        })
        .catch(err => {
            console.log(err);
        });
}
