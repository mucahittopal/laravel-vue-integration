<template>
  <div>
    <div class="text-center">
        <img src = "/images/Website_Logo.png" width="250px" />
    </div>
    <div class="row toggle_container">
      <div
        v-bind:class="{
          active: tab === 1,
          'text-center col-6 toggle-btn': true,
        }"
        @click="tab = 1"
      >
        <div>Existing User</div>
        <div class="ticker_container">
          <div class="tick"></div>
          <div>Log In</div>
        </div>
      </div>
      <div
        v-bind:class="{
          active: tab === 2,
          'text-center col-6 toggle-btn': true,
        }"
        @click="tab = 2"
      >
        <div>New User?</div>

        <div class="ticker_container">
          <div class="tick"></div>
          <div>Sign Up</div>
        </div>
      </div>
    </div>
    <div v-show="tab === 1">
      <login-form :csrf-token="csrfToken" :err-login="errLogin"> </login-form>
    </div>
    <div v-show="tab === 2">
      <sign-up :csrf-token="csrfToken"></sign-up>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    "csrf-token": { required: true },
    "err-login": { type: String },
  },
  data() {
    return {
      tab: 1,
    };
  },
  mounted() {},
  methods: {},
};
</script>
<style>
.toggle_container {
  border: 1px solid #1652F0;
  margin-bottom: 5rem;
  cursor: pointer;
}
.ticker_container {
    display: flex;
    align-items: center;
    justify-content: center;
}
.tick {
  border: 2px solid #1652F0;
  width: 1rem;
  height: 1rem;
  border-radius: 1rem;
  margin-right: 0.5rem;
}
.toggle-btn {
  border: 1px solid #1652F0;
}
.toggle-btn:hover {
  background-color: #1652F055;
}
.active .tick {
  background: #1652F0;
}
</style>