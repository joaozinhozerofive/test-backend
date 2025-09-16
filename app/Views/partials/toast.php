<div class="toast-container" id="toast-container"></div>
<script>
(function(){
  const container = document.getElementById('toast-container');
  if(!container) return;

  function showToast(type, title, message, timeout=4000){
    const el = document.createElement('div');
    el.className = `toast ${type}`;
    el.innerHTML = `
      <div class="icon">${type === 'error' ? '⚠️' : '✅'}</div>
      <div class="content">
        <div class="title">${title}</div>
        ${message ? `<div class=\"message\">${message}</div>` : ''}
      </div>
      <button class="close" aria-label="Fechar">&times;</button>
    `;

    const close = ()=>{ el.classList.remove('show'); setTimeout(()=> el.remove(), 200); };
    el.querySelector('.close').addEventListener('click', close);

    container.appendChild(el);
    requestAnimationFrame(()=> el.classList.add('show'));
    if(timeout>0){ setTimeout(close, timeout); }
  }

  document.addEventListener('toast:error', (e)=>{
    const msg = e.detail || 'Ocorreu um erro.';
    showToast('error', 'Erro', String(msg));
  });
  document.addEventListener('toast:success', (e)=>{
    const msg = e.detail || '';
    showToast('success', 'Sucesso', String(msg));
  });

  window.AppToast = {
    error: (msg)=> document.dispatchEvent(new CustomEvent('toast:error', { detail: msg })),
    success: (msg)=> document.dispatchEvent(new CustomEvent('toast:success', { detail: msg }))
  };
})();
</script>


