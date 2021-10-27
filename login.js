function toggleActive(e) {
    let buttons = document.querySelectorAll('.buttons>button');
    let forms = document.querySelectorAll('form');
    buttons.forEach(btn => {
        btn.classList.toggle('active');
    });
    forms.forEach(form => {
        form.classList.toggle('hidden');
    })
}

document.querySelectorAll('.buttons>button').forEach(btn => {
    btn.addEventListener('click', toggleActive);
});