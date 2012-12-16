javascript:

function kiosk_closeBox() {
  var b = document.querySelector('#kiosk_box');

  if (b)
  {
    b.style.display = 'none';
    b.parentNode.removeChild(b);
  }
}

function kiosk_saveUrl() {
  try {
    if (!document.body) throw (0);
    var
      i = document.createElement('iframe'),
      u = window.btoa(document.location.href);

    i.setAttribute('id', 'kiosk_box');
    i.setAttribute('style', 'position:fixed;left:10px;top:10px;z-index:999999999999999;overflow:hidden;width:168px;height:100px;border:3px solid #aaa;background:#fff');
    i.setAttribute('src', 'https://path/kiosk/?gateway=bookmarklet&key=4b83c256a7ee37fef090378006304e15&url=' + u);

    document.body.appendChild(i);

    setTimeout('kiosk_closeBox()', 5000);
  } catch (e) {
    alert('Please wait until the page has loaded.');
  }
}

kiosk_saveUrl();

void(0);