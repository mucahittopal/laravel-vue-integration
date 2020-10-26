<template>
  <div class="input-box header-search-box">
    <input
      type="text"
      placeholder="City"
      class="header-search-input form-control form-control-sm"
      v-model="keyword"
      @input="input"
      @focus="focus"
      id="header-location-search-input"
      autocomplete="off"
      @blur="handleBlur"
    />
    <input type="hidden" name="location_type" :value="location_type" />
    <input type="hidden" name="location" :value="keyword" />
    <div class="input-autocomplete" :class="{ show: show_suggestions }">
      <ul>
        <li
          v-for="(res, index) in results.cities"
          :key="'city-' + index"
          @click="choose_option('city', res.name)"
        >
          {{ res.name }}
        </li>
        <li
          v-for="(res, index) in results.zipcodes"
          :key="'zipcode-' + index"
          @click="choose_option('zipcode', res.code)"
        >
          {{ res.code }}
        </li>
      </ul>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    "data-ltype": { type: String },
    "data-keyword": { type: String },
    "request-country-id": { type: Number },
  },
  data() {
    return {
      keyword: "",
      show_suggestions: "",
      results: [],
      timer: null,
      location_type: "",
    };
  },
  mounted() {
    this.keyword = this.dataKeyword ? this.dataKeyword : "";
    this.location_type = this.dataLtype ? this.dataLtype : "";
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
          axios
            .post("/api/search/city-or-zipcode", {
              keyword: this.keyword,
              country_id: this.requestCountryId,
            })
            .then((resp) => {
              this.results = resp.data;
              if (resp.data.cities.length > 0 || resp.data.zipcodes.length > 0)
                this.show_suggestions = true;
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
    choose_option(type, name) {
      this.location_type = type;
      this.keyword = name;
      this.show_suggestions = false;
    },
  },
};
</script>






<style scoped>
</style>