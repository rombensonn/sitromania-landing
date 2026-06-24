const root = document.documentElement;
root.classList.add('js');

document.querySelectorAll('a[href^="#"]').forEach((link) => {
  link.addEventListener('click', (event) => {
    const target = document.querySelector(link.getAttribute('href'));
    if (!target) return;
    event.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
});

document.querySelectorAll('.faq__button').forEach((button) => {
  button.addEventListener('click', () => {
    const item = button.closest('.faq__item');
    const expanded = button.getAttribute('aria-expanded') === 'true';
    button.setAttribute('aria-expanded', String(!expanded));
    item.classList.toggle('is-open', !expanded);
  });
});

const form = document.querySelector('[data-lead-form]');
const statusBox = document.querySelector('[data-form-status]');

function setStatus(message, type) {
  if (!statusBox) return;
  statusBox.textContent = message;
  statusBox.className = `form-status form-status--${type}`;
  statusBox.hidden = false;
}

if (form) {
  form.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!form.reportValidity()) {
      return;
    }

    const submit = form.querySelector('button[type="submit"]');
    submit.disabled = true;
    submit.dataset.originalText = submit.textContent;
    submit.textContent = 'Отправляем заявку';
    setStatus('Отправляем заявку в Telegram...', 'info');

    try {
      if (form.dataset.staticDemo === 'true') {
        await new Promise((resolve) => setTimeout(resolve, 500));
        form.reset();
        setStatus('Заявка принята в демо-режиме. Для реальной записи позвоните по номеру на сайте.', 'success');
        return;
      }

      const response = await fetch(form.action, {
        method: 'POST',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: new FormData(form),
      });
      const data = await response.json();

      if (!response.ok || !data.ok) {
        throw new Error(data.message || 'Не удалось отправить заявку.');
      }

      form.reset();
      setStatus(data.message, 'success');
    } catch (error) {
      setStatus(error.message || 'Не удалось отправить заявку. Позвоните нам.', 'error');
    } finally {
      submit.disabled = false;
      submit.textContent = submit.dataset.originalText || 'Оставить заявку';
    }
  });
}
