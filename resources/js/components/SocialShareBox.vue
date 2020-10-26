<template>
  <div>
    <div class="share-box">
      <div class="sharebtn" @click="visible = !visible">
        <img src="/images/share.png" alt="" />
      </div>
      <div class="share-links" :class="{ 'd-block': visible }">
        <a
          href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdesiworkforce.com%2F&amp;src=sdkpreparse"
          target="_blank"
          class="fb"
          ><i class="fab fa-facebook-square"></i
        ></a>
        <a
          :href="'https://api.whatsapp.com/send?text=' + baseUrl"
          data-action="share/whatsapp/share"
          class="wp"
          target="_blank"
        >
          <i class="fab fa-whatsapp-square"></i>
        </a>
        <!-- <a href="mailto:services@desiworkforce.com">
                    <img src="/images/copy.png" />
                </a> -->
        <a
          :href="'#'"
          v-clipboard:copy="message"
          v-clipboard:success="onCopy"
          v-clipboard:error="onError"
        >
          <img src="/images/copy.png" />
        </a>
      </div>
    </div>

    <b-toast id="example-toast" auto-hide-delay="300" static no-close-button>
      Copied!
    </b-toast>
  </div>
</template>

<script>
export default {
  props: ["base-url"],
  data() {
    return {
      visible: false,
      message: this.baseUrl,
    };
  },
  mounted() {
    // console.log(this.baseUrl);
  },
  methods: {
    onCopy: function (e) {
        this.$bvToast.show('example-toast')
    },
    onError: function (e) {
      alert("Failed to copy texts");
    },
  },
};
</script>

<style>
</style>