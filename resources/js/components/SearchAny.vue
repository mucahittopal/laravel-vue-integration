<template>
  <div class="input-box header-search-box">
    <input
      type="text"
      :placeholder="dataPlaceholder"
      class="header-search-input form-control form-control-sm"
      v-model="keyword"
      @input="input"
      @focus="focus"
      id="search-any-input"
      autocomplete="off"
      @blur="handleBlur"
    />
    <input type="hidden" :name="name" :value="keyword" />
    <div class="input-autocomplete" :class="{ show: show_suggestions }">
      <ul>
        <li
          v-for="(res, index) in results"
          :key="index"
          @click="choose_option(res.name)"
        >
          {{ res[dataAccessor] }}
        </li>
        <!-- <li v-for="n in 100" :key="n" @click="choose_option(n)">{{n}}</li> -->
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    "data-name": { type: String },
    "data-value": { type: String },
    "data-endpoint": { type: String },
    "data-placeholder": { type: String },
    "data-accessor": { type: String },
  },
  data() {
    return {
      keyword: "",

      name: "",
      keyword: "",
      apiurl: "",
      placeholder: "",
      accessor: "",

      show_suggestions: "",
      results: [],
      timer: null,
    };
  },
  mounted() {
    this.name = this.dataName ? this.dataName : "name";
    this.keyword = this.dataValue ? this.dataValue : "";
    this.apiurl = this.dataEndpoint ? this.dataEndpoint : "";
    this.placeholder = this.dataPlaceholder ? this.dataPlaceholder : "";
    this.accessor = this.dataAccessor ? this.dataAccessor : "";
  },
  methods: {
    /**
     *
     */
    delay(fn, s) {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(fn, s);
    },

    /**
     *
     */
    get_results() {
      this.delay(() => {
        if (this.keyword.length >= 3) {
          axios.post(this.apiurl, { keyword: this.keyword }).then((resp) => {
            this.results = resp.data;
            if (resp.data.length > 0) this.show_suggestions = true;
          });
        }
      }, 500);
    },

    /**
     *
     */
    input() {
      this.results = [];
      this.get_results();
    },

    /**
     *
     */
    focus() {
      if (this.results.length > 0) {
        this.show_suggestions = true;
      }
    },
    handleBlur() {
      setTimeout(() => {
        this.show_suggestions = false;
      }, 300);
    },

    /**
     *
     */
    choose_option(name) {
      this.keyword = name;
    },
  },
};
</script>






<style scoped>
</style>