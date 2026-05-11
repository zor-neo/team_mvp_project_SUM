document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-toggle-password]').forEach((button) => {
    button.addEventListener('click', () => {
      const input = document.querySelector(button.dataset.togglePassword);
      if (!input) return;
      input.type = input.type === 'password' ? 'text' : 'password';
      button.innerHTML = input.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    });
  });

  document.querySelectorAll('.needs-validation').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

  const search = document.querySelector('[data-content-search]');
  if (search) {
    search.addEventListener('input', () => {
      const query = search.value.toLowerCase();
      document.querySelectorAll('[data-content-card]').forEach((card) => {
        card.classList.toggle('d-none', !card.textContent.toLowerCase().includes(query));
      });
    });
  }

  document.querySelectorAll('[data-bookmark]').forEach((button) => {
    button.addEventListener('click', () => {
      button.classList.toggle('active');
      button.innerHTML = button.classList.contains('active') ? '<i class="bi bi-bookmark-fill"></i>' : '<i class="bi bi-bookmark"></i>';
    });
  });

  document.querySelectorAll('[data-photo-preview]').forEach((input) => {
    input.addEventListener('change', () => {
      const preview = document.querySelector(input.dataset.photoPreview);
      const file = input.files && input.files[0];
      if (!preview || !file) return;
      preview.src = URL.createObjectURL(file);
    });
  });
});
