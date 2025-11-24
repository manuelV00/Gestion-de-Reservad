document.addEventListener('DOMContentLoaded', () => {
  const lazySection = document.querySelector('#reservas-section');
  if (!lazySection) return;

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        fetch('/?route=reserva_lista_parcial')
          .then(r => r.text())
          .then(html => {
            lazySection.innerHTML = html;
          })
          .catch(console.error);
        obs.unobserve(entry.target);
      }
    });
  });

  observer.observe(lazySection);
});
