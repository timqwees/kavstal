<style>
  #specOverlay {
    position: fixed;
    inset: 0;
    z-index: 199;
    background: rgba(0, 0, 0, 0);
    visibility: hidden;
    pointer-events: none;
    transition: background 0.35s ease, visibility 0.35s;
  }

  #specOverlay.show {
    visibility: visible;
    pointer-events: auto;
    background: rgba(0, 0, 0, 0.55);
  }

  #specModal {
    position: fixed;
    inset: 0;
    z-index: 200;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    visibility: hidden;
    pointer-events: none;
  }

  #specModal.show {
    visibility: visible;
    pointer-events: auto;
  }

  #specModal .modal-box {
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    width: 100%;
    max-width: 480px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    opacity: 0;
    transform: translateY(30px) scale(0.96);
    transition: opacity 0.35s ease, transform 0.35s ease;
  }

  #specModal.show .modal-box {
    opacity: 1;
    transform: translateY(0) scale(1);
  }

  #specModal .modal-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f3f4f6;
    border: none;
    cursor: pointer;
    color: #6b7280;
    font-size: 18px;
    transition: background 0.2s;
  }

  #specModal .modal-close:hover {
    background: #e5e7eb;
  }

  #specModal .modal-box input,
  #specModal .modal-box textarea {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 14px;
    outline: none;
  }

  #specModal .modal-box input:focus,
  #specModal .modal-box textarea:focus {
    border-color: #ef4444;
  }

  #specModal .file-label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border: 1px dashed #d1d5db;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #6b7280;
    transition: border-color 0.2s;
  }

  #specModal .file-label:hover {
    border-color: #ef4444;
  }

  #specModal .file-label input {
    display: none;
  }

  #specSuccess {
    display: none;
    text-align: center;
    padding: 24px 0;
  }

  #specSuccess .check-circle {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #22c55e;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
  }

  #specSuccess .check-circle svg {
    width: 36px;
    height: 36px;
    stroke: #fff;
  }

  #specSuccess p {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
  }
</style>

<div id="specOverlay"></div>
<div id="specModal">
  <div class="modal-box">
    <button class="modal-close" id="specModalClose">&times;</button>

    <form id="specModalForm" enctype="multipart/form-data">
      <h3 style="font-size:20px;font-weight:700;margin-bottom:4px;color:#111">Загрузить спецификацию</h3>
      <p style="font-size:14px;color:#6b7280;margin-bottom:20px">Пришлите файл — мы рассчитаем стоимость и свяжемся с
        вами</p>

      <div style="display:flex;flex-direction:column;gap:12px">
        <input type="text" name="name" placeholder="Ваше имя" required>
        <input type="tel" name="phone" placeholder="Телефон" required>
        <input type="email" name="email" placeholder="Email (необязательно)">
        <textarea name="comment" rows="2" placeholder="Комментарий к заявке"></textarea>

        <label class="file-label">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <polyline points="17 8 12 3 7 8" />
            <line x1="12" y1="3" x2="12" y2="15" />
          </svg>
          <span id="specFileName">Прикрепить файл (xlsx, pdf, doc)</span>
          <input type="file" name="spec_file" accept=".xlsx,.xls,.pdf,.csv,.doc,.docx">
        </label>

        <label id="specAgree" style="display:flex;align-items:start;gap:8px;font-size:12px;color:#9ca3af">
          <input type="checkbox" checked style="margin-top:2px;width:auto" require>
          Соглашаюсь на обработку персональных данных
        </label>

        <button type="submit"
          style="width:100%;background:#ef4444;color:#fff;padding:12px;border:none;border-radius:8px;font-weight:600;font-size:15px;cursor:pointer">
          <i class="fas fa-paper-plane"></i> Отправить заявку
        </button>
      </div>
      <div id="specModalStatus" style="margin-top:12px;font-size:13px;font-weight:500;text-align:center"></div>
    </form>

    <div id="specSuccess">
      <div class="check-circle">
        <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12" />
        </svg>
      </div>
      <p>Заявка отправлена!</p>
      <p style="font-size:14px;color:#6b7280;margin-top:4px">Мы свяжемся с вами в ближайшее время</p>
    </div>
  </div>
</div>

<script>
  (function () {
    var shown = sessionStorage.getItem('specModalShown');
    if (!shown) {
      setTimeout(function () {
        document.getElementById('specOverlay').classList.add('show');
        document.getElementById('specModal').classList.add('show');
        sessionStorage.setItem('specModalShown', '1');
      }, 15000);
    }
    function hide() {
      document.getElementById('specOverlay').classList.remove('show');
      document.getElementById('specModal').classList.remove('show');
    }
    document.getElementById('specModalClose').onclick = hide;
    document.getElementById('specOverlay').onclick = hide;

    document.querySelector('#specModalForm input[type="file"]').onchange = function () {
      document.getElementById('specFileName').textContent = this.files[0] ? this.files[0].name : 'Прикрепить файл (xlsx, pdf, doc)';
    };

    document.getElementById('specModalForm').onsubmit = async function (e) {
      e.preventDefault();
      var btn = this.querySelector('button[type="submit"]');
      btn.disabled = true; btn.innerHTML = 'Отправка...';
      try {
        var res = await fetch('/send/email', { method: 'POST', body: new FormData(this) });
        var data = await res.json();
        if (data.success) {
          this.style.display = 'none';
          document.getElementById('specModalStatus').style.display = 'none';
          document.getElementById('specAgree').style.display = 'none';
          document.getElementById('specSuccess').style.display = 'block';
          setTimeout(hide, 3000);
          this.reset();
        } else {
          document.getElementById('specModalStatus').textContent = 'Ошибка: ' + (data.error || 'повторите попытку');
          document.getElementById('specModalStatus').style.color = '#dc2626';
        }
      } catch (e) {
        document.getElementById('specModalStatus').textContent = 'Ошибка соединения. Попробуйте позже.';
        document.getElementById('specModalStatus').style.color = '#dc2626';
      }
      btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> Отправить заявку';
    };
  })();
</script>