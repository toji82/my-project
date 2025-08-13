(function () {
  const modal = document.getElementById('modal');
  const content = document.getElementById('modal-content');
  const bodyEl = document.body;

  function urlFromTemplate(template, id) {
    return template.replace('__ID__', String(id));
  }

  // 詳細を開く
  window.openDetail = function (btn) {
    const id = btn?.dataset?.id;
    if (!id) return;

    const url = urlFromTemplate(bodyEl.dataset.showUrlTemplate, id);
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(r => {
        if (!r.ok) throw new Error('Failed to load detail');
        return r.text();
      })
      .then(html => {
        content.innerHTML = html;
        modal.removeAttribute('hidden');
        document.documentElement.style.overflow = 'hidden'; // 背景スクロール抑止
      })
      .catch(err => {
        console.error(err);
        alert('詳細の読み込みに失敗しました。');
      });
  };

  // モーダルを閉じる
  window.closeModal = function () {
    modal.setAttribute('hidden', '');
    content.innerHTML = '';
    document.documentElement.style.overflow = '';
  };

  // ESCで閉じる
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.hasAttribute('hidden')) closeModal();
  });

  // 削除
  window.deleteContact = function (id) {
    if (!confirm('このデータを削除します。よろしいですか？')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = urlFromTemplate(bodyEl.dataset.destroyUrlTemplate, id);

    fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': token,
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(r => r.json())
      .then(json => {
        if (json && json.ok) {
          const row = document.getElementById('row-' + id) || document.querySelector(`button[data-id="${id}"]`)?.closest('tr');
          if (row) row.remove();
          closeModal();
        } else {
          alert('削除に失敗しました。');
        }
      })
      .catch(() => alert('通信に失敗しました。'));
  };
})();
