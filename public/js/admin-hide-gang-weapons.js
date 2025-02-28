document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('[id^="Gang_weapons_"]').forEach(element => {
        if (/^Gang_weapons_\d+-contents$/.test(element.id)) {
            let parent = element.querySelector('.form-widget-compound');
            if (parent) {
                parent.classList.add('hide');
            }
        }
    });
});
