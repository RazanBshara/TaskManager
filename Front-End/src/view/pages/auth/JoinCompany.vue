<template>
  <div class="col-xl-7 mb-25">
    <div class="text-center mb-10 mb-lg-13 mt-15">
      <h3 class="font-size-h1">
        Do Some <strong> Search </strong> <br />To<strong>
          Join To Your Company!</strong
        >
      </h3>
    </div>

    <!--YYY--JoinCompany Search bar-->
    <!--begin::Form-->
    <form method="get" class="quick-search-form">
      <div class="input-group rounded bg-dark">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <span class="svg-icon svg-icon-lg">
              <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
              <inline-svg src="media/svg/icons/General/Search.svg" />
              <!--end::Svg Icon-->
            </span>
          </span>
        </div>
        <input
          type="text"
          class="form-control h-45px"
          placeholder="Search your company.."
          v-model="company"
        />
        <div class="input-group-append">
          <span class="input-group-text">
            <i class="quick-search-close ki ki-close icon-sm text-muted"></i>
          </span>
        </div>
      </div>
      <b-list-group>
        <b-list-group-item
          button
          v-for="c in comp"
          :key="c.id"
          @click="chooseCompany(c.id)"
          >{{ c.name }}</b-list-group-item
        >
      </b-list-group>
      <!-- <b-dropdown
        text="Companies"
        block
        variant="primary"
        class="m-2"
      >
        <b-dropdown-item v-for="c in comp" :key="c.id">{{c.name}}</b-dropdown-item>
      </b-dropdown> -->
    </form>
    <!--begin::Search Toggle-->
    <div
      id="kt_quick_search_toggle"
      data-toggle="dropdown"
      data-offset="0px,1px"
    ></div>
    <br /><br /><br />
    <!--begin::Action-->
    <div class="form-group d-flex flex-wrap flex-center mb-6 mx-10 px-9">
      <b-button
        type="submit"
        v-on:click="$router.push('company')"
        variant="primary"
        class="px-9 py-3 my-1 font-size-3 mx-4 mb-7"
        >Or Create your own Company!!</b-button
      >
    </div>
    <span>{{ comp }}</span>
  </div>
</template>
<script>
import axios from "axios";
import router from "@/router.js";
export default {
  data() {
    return {
      company: "",
      comp: null,
    };
  },
  methods: {
    chooseCompany(companyid) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/joincompany",
        data: {
          companyid: companyid,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
        if (response.status == 200) {
          console.log(JSON.stringify(response.data)),
            router.replace("/workspace");
        }
      });
    },
  },
  watch: {
    company: function(v) {
      axios({
        method: "get",
        url: "http://127.0.0.1:8000/api/searchcompany",
        data: {
          searchname: v,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
        this.comp = response.data;
      });
    },
  },
};
</script>
