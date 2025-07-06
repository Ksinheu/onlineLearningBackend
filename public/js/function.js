// -----this is funtion for admin and editor only for alert
function popUpForm(text='This is form popup.',action='pp-error',bntCancel=false,btnOk = false,btnAction = '')
{
    var opject = `
    <div class="pp-box ${action}">
        <div class="pp-head df-s">
            <div class="text left-05 df-l">
                <div class="icon icon-ra icon-sm">
                    <svg class="error" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M14.9 2H9.1c-.68 0-1.64.4-2.12.88l-4.1 4.1C2.4 7.46 2 8.42 2 9.1v5.8c0 .68.4 1.64.88 2.12l4.1 4.1c.48.48 1.44.88 2.12.88h5.8c.68 0 1.64-.4 2.12-.88l4.1-4.1c.48-.48.88-1.44.88-2.12V9.1c0-.68-.4-1.64-.88-2.12l-4.1-4.1C16.54 2.4 15.58 2 14.9 2ZM4.94 19.08 19.08 4.94" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <svg class="success" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10Z" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="m7.75 12 2.83 2.83 5.67-5.66" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <svg class="warning" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 7.75V13M21.08 8.58v6.84c0 1.12-.6 2.16-1.57 2.73l-5.94 3.43c-.97.56-2.17.56-3.15 0l-5.94-3.43a3.15 3.15 0 0 1-1.57-2.73V8.58c0-1.12.6-2.16 1.57-2.73l5.94-3.43c.97-.56 2.17-.56 3.15 0l5.94 3.43c.97.57 1.57 1.6 1.57 2.73Z" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16.2v.1" stroke="#FF8A65" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <svg class="infor" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10ZM12 8v5" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.995 16h.009" stroke="#FF8A65" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </div>
                <p></p>
            </div>
            <div class="icon icon-ra icon-sm right-05" onclick="removeFormPopup(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M12 18V6" stroke="#FF8A65" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </div>
        </div>
        <blockquote>
            <div class="db-c">
                <p>${text}</p>
            </div>
        </blockquote>
        <div class="pp-foot">
            <div class="ppf-box df-s left-05 right-05">
                <p></p>
                <div class="df-l">
                    <a onclick="removeFormPopup(this)" class="btn curs-p ${bntCancel == false ? 'btn-uncancel' : 'btn-accancel'}">
                        Cancel
                    </a>
                    <a href="#" class="btn btn-ok" ${btnOk == false ? 'onclick="removeFormPopup(this)"' : btnAction}>
                        Ok
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="pp-bg"></div>
    `;
    var eBody = document.createElement('div');
    eBody.classList.add('web-popup');

    eBody.innerHTML = opject;
    document.body.append(eBody);

    setTimeout(() => {
        eBody.classList.add('web-popup-active');
    }, 500);
}
function removeFormPopup(el) {
    const popup = el.closest('.web-popup');
    if (popup) {
        popup.classList.remove('web-popup-active');
        setTimeout(() => {
            popup.remove();
        }, 500);
    }
}
// popUpForm(text='',action='pp-error')
// popUpForm(text='',action='pp-success')
// popUpForm(text='',action='pp-warning')
// popUpForm(text='',action='pp-info')

function alert_delete(btn, text = 'Do you want to delete this item?',action = 'pp-warning') {
    event.preventDefault(); // prevent form from submitting
    window._deleteButton = btn; // store the clicked button

    popUpForm(
        text,
        action,
        true,
        true,
        'onclick="confirmDelete(this)"'
    );
}

function confirmDelete(el) {
    if (window._deleteButton instanceof HTMLElement) {
        const form = window._deleteButton.closest('form');
        if (form) {
            form.submit();
        }
    }
    removeFormPopup(el);
}
// -----this for alert popup ---------------------
function showAlert(description = 'សូមបញ្ចូលការជូនដំណឹង!',title = 'ជោគជ័យ',type = 'success') {
  const alert = document.createElement('div');
  alert.className = `alert ${type}`;

  const icons = {
    success: '✔',
    error: '✖',
    warning: '⚠'
  };

  alert.innerHTML = `
    <div class="icon">${icons[type] || ''}</div>
    <div class="text">
      <div class="title">${title}</div>
      <div class="description">${description}</div>
    </div>
    <div class="close-btn" onclick="this.parentElement.remove()">×</div>
  `;

  document.body.appendChild(alert);

  // Auto remove after 5 seconds
  setTimeout(() => {
    alert.remove();
  }, 5000);
}