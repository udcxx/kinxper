(function() {
    'use strict';
    kintone.events.on('app.record.detail.show', function(event) {
      const header = kintone.app.record.getHeaderMenuSpaceElement();
      const button = new Kuc.Button({
        text: '印刷 by kinxper',
        type: 'submit',
        className: 'options-class',
        id: 'kinxper-print-button',
        visible: true,
        disabled: false
      });
      header.appendChild(button);
      
      const recordId = kintone.app.record.getId();
      const appId = kintone.app.getId();
      const token = event.record['Token'].value ? event.record['Token'].value : '';
      const domain = location.hostname.replace('.cybozu.com', '');
  
      button.addEventListener('click', function(event) {
        window.open(`https://app.udcxx.me/kinxper/?domain=${domain}&appid=${appId}&recordid=${recordId}&token=${token}`, '_blank', 'noreferrer');
      });
      
      return event;
    });
  })();