<template>
  <div class="meeting">
    <div class="container-zoom">
      <ZoomFrame :nickname="nickname" :meetingId="meetingId" :password="password" :goToLeave="goToLeave" :userRole="userRole" :userEmail="userEmail" />
    </div>
  </div>
</template>

<script>
import ZoomFrame from "./ZoomFrame.vue";

export default {
  name: "app",
  data: function () {
      return {
          nickname: '',
          meetingId: '',
          password: '',
          goToLeave: '',
          userRole: '',
          userEmail: ''
      }
  },
  props: [
    'meeting_id',
    'passcode',
    'username',
    'leave',
    'role',

  ],
  components: {
    ZoomFrame,
  },
  created : function (){
      this.nickname = this.username;
      this.meetingId = this.meeting_id;
      this.password = this.passcode;
      this.goToLeave = this.leave;
      this.userRole = this.role;
      // 1 for host; 0 for attendee
  }
};
</script>

