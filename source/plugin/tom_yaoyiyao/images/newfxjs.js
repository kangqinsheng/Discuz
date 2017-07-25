wx.config({
    debug: false,
    appId: appIdstr,
    timestamp: timestampstr,
    nonceStr: nonceStrstr,
    signature: signaturestr,
    jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
    ]
  });

function doWeixin() {  
	wx.ready(function () {
 
 	var sharebackurl =document.getElementById('sharebackurl').value;
  // 2. ����ӿ�
  // 2.1 ����"���������"����ť������Զ���������ݼ��������ӿ�
 // document.querySelector('#onMenuShareAppMessage').onclick = function () {
    wx.onMenuShareAppMessage({
      title: document.getElementById('wx-share-title').value,
      desc: document.getElementById('wx-share-desc').value,
      link: document.getElementById("wx-share-link").value,
      imgUrl: document.getElementById('wx-share-img').value,
      trigger: function (res) {
       // alert('�û�������͸�����');
      },
      success: function (res) {
       // alert('�ѷ���');
	   	 var image=new Image();   
		image.src=sharebackurl;        
      },
      cancel: function (res) {
        //alert('��ȡ��');
      },
      fail: function (res) {
        //alert(JSON.stringify(res));
      }
    });
 
 // };

  // 2.2 ����"��������Ȧ"��ť������Զ���������ݼ��������ӿ�
 // document.querySelector('#onMenuShareTimeline').onclick = function () {
    wx.onMenuShareTimeline({
      title: document.getElementById('wx-share-title').value,
      link: document.getElementById("wx-share-link").value,
      imgUrl: document.getElementById('wx-share-img').value,
      trigger: function (res) {
       // alert('�û������������Ȧ');
      },
      success: function (res) {
       	 var image=new Image();   
		image.src=sharebackurl;        
      },
      cancel: function (res) {
      //  alert('��ȡ��');
      },
      fail: function (res) {
        //alert(JSON.stringify(res));
      }
    });
   // alert('��ע���ȡ"��������Ȧ"״̬�¼�');
 // };

  // 2.3 ����"����QQ"��ť������Զ���������ݼ��������ӿ�
  //document.querySelector('#onMenuShareQQ').onclick = function () {
    wx.onMenuShareQQ({
      title: document.getElementById('wx-share-title').value,
      desc: document.getElementById('wx-share-desc').value,
      link: document.getElementById("wx-share-link").value,
      imgUrl: document.getElementById('wx-share-img').value,
      trigger: function (res) {
       // alert('�û��������QQ');
      },
      complete: function (res) {
       //alert(JSON.stringify(res));
      },
      success: function (res) {
       	 var image=new Image();   
		image.src=sharebackurl;        
      },
      cancel: function (res) {
       // alert('��ȡ��');
      },
      fail: function (res) {
        //alert(JSON.stringify(res));
      }
    });
  //  alert('��ע���ȡ"���� QQ"״̬�¼�');
 // };
  
  // 2.4 ����"����΢��"��ť������Զ���������ݼ��������ӿ�
 // document.querySelector('#onMenuShareWeibo').onclick = function () {
    wx.onMenuShareWeibo({
      title: document.getElementById('wx-share-title').value,
      desc: document.getElementById('wx-share-desc').value,
      link: document.getElementById("wx-share-link").value,
      imgUrl: document.getElementById('wx-share-img').value,
      trigger: function (res) {
        //alert('�û��������΢��');
      },
      complete: function (res) {
       // alert(JSON.stringify(res));
      },
      success: function (res) {
       	 var image=new Image();   
		image.src=sharebackurl;        
      },
      cancel: function (res) {
        //alert('��ȡ��');
      },
      fail: function (res) {
       // alert(JSON.stringify(res));
      }
    });
 
});
}

doWeixin();