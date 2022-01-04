<template>
  <div class="iframe-container">
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.9/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.9/css/react-select.css" />

    <meta name="format-detection" content="telephone=no">

  </div>
</template>
<script>
import { ZoomMtg } from '@zoomus/websdk';
import * as base64JS from 'js-base64';
import * as hmacSha256 from 'crypto-js/hmac-sha256';
import * as encBase64 from 'crypto-js/enc-base64';

console.log("checkSystemRequirements");
console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

// CDN version default
ZoomMtg.setZoomJSLib('https://source.zoom.us/1.9.0/lib', '/av');

ZoomMtg.preLoadWasm();

ZoomMtg.prepareJssdk();

var API_KEY = 'XXTDJaFzT7ORPwY7Rr2K0w';
var API_SECRET =  '17P7Yga0uEVCWmwLPJBtsAAJLwW1n2AT';

export default {
  name: "ZoomFrame",
  data: function() {
    return {
      src: "",
      meetConfig: {},
      signature: {},

    };
  },
  props: {
    nickname: String,
    meetingId: String,
    password: String,
    goToLeave: String,
    userRole: String,
    userEmail : String
  },
  methods:{
    addMeetingData(){
     alert("add meeting data")
    }
  },
  created: function() {
    this.meetConfig = {
      apiKey: API_KEY,
      apiSecret: API_SECRET,
      meetingNumber: this.meetingId,
      userName: this.nickname,
      passWord: this.password,
      leaveUrl: this.goToLeave,
      role: this.userRole,
      userEmail : this.userEmail
    };
    console.log('this.meetConfig', this.meetConfig);

  },
  mounted: async function() {

    var url         = new URL(window.location);
    var _this = this;
    // await this.axios.post('/meetings/generate-signature', {
    //     apiKey    : _this.meetConfig.apiKey,
    //     api_secret: _this.meetConfig.apiSecret,
    //     meeting_no: _this.meetConfig.meetingNumber,
    //     role      : _this.meetConfig.role
    // })
    // .then(function (response) {
    //   _this.signature = response.data.signature;
    //   })
    // .catch(function (error) {
    //   console.log(error)
    // });

    // ZoomMtg.generateSignature({
    //   meetingNumber: _this.meetConfig.meetingNumber,
    //   apiKey: _this.meetConfig.apiKey,
    //   apiSecret: _this.meetConfig.apiSecret,
    //   role: _this.meetConfig.role,
    //   success: function (res) {
    //     _this.signature = res.result;
    //   },
    //   error: function(res) {
    //     console.log(res);
    //     console.log("error in last");
    //   }
    // });

    let signature = '';
    // Prevent time sync issue between client signature generation and zoom
    const ts = new Date().getTime() - 30000;
    try {
        const msg = base64JS.Base64.encode(_this.meetConfig.apiKey + _this.meetConfig.meetingNumber + ts + _this.meetConfig.role);
        const hash = hmacSha256.default(msg, _this.meetConfig.apiSecret);
        signature = base64JS.Base64.encodeURI(`${_this.meetConfig.apiKey}.${_this.meetConfig.meetingNumber}.${ts}.${_this.meetConfig.role}.${encBase64.stringify(hash)}`);
    } catch (e) {
         console.log('error')
    }
    _this.signature = signature;

    // join function
    ZoomMtg.init({
      leaveUrl: this.goToLeave,
      isSupportAV: true,
      success: () => {
        ZoomMtg.join({
          meetingNumber: this.meetConfig.meetingNumber,
          userName: this.meetConfig.userName,
          signature: this.signature,
          apiKey: this.meetConfig.apiKey,
          userEmail: this.meetConfig.userEmail,
          passWord: this.meetConfig.passWord,
          success: successfullyJoined(this),
          error: function(res) {
            console.log(res);
          }
        });
      },
      error: function(res) {
        console.log(res);
            console.log("error in last");
      }
    });
  }
};

function successfullyJoined(_this){
        var url         = new URL(window.location);
        var meeting_id  = url.searchParams.get("meeting_id");
        var passcode    = url.searchParams.get("passcode");
        var created_by_id    = url.searchParams.get("created_by_id");
        var internal_meeting_id = url.searchParams.get("internal_meeting_id");
        var origin      = window.location.origin;

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
