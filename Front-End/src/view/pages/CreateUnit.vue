<template>
  <div class="col-8-xl">
     <div>
      <b-nav class="mx-1">
        <b-nav-item class="text-muted" v-on:click="$router.push('unit')">
          <b-icon icon="chevron-left"></b-icon>
          UNIT
        </b-nav-item>
        <br /><br /><br />
        <b-item class="font-size-h1 font-weight-weight">New Unit</b-item>
      </b-nav>
    </div>
    <b-card bg-variant="light">
      <b-form-group
        label-cols-lg="3"
        label="Unit Details"
        label-size="lg"
        label-class="font-weight-bold pt-0"
        class="mb-0"
      >
        <b-form-group
          label="Unit Name*:"
          v-model="names"
          label-for="nested-street"
          label-cols-sm="3"
          label-align-sm="right"
        >
          <b-form-input id="nested-street" v-model="names"></b-form-input>
        </b-form-group>

        <b-form-group
          label="Description:"
          v-model="description"
          label-for="nested-city"
          label-cols-sm="3"
          label-align-sm="right"
        >
          <b-form-input id="nested-city" v-model="description"></b-form-input>
        </b-form-group>

        <!-- <b-form-group
          label="Type:"
          v-model="type"
          label-for="nested-state"
          label-cols-sm="3"
          label-align-sm="right"
        >
          <b-form-input id="nested-state"></b-form-input>
        </b-form-group> -->

        <!-- <b-form-group
        label="Country:"
        label-for="nested-country"
        label-cols-sm="3"
        label-align-sm="right"
      >
        <b-form-input id="nested-country"></b-form-input>
      </b-form-group> -->

        <!-- <b-form-group
        label="Ship via:"
        label-cols-sm="3"
        label-align-sm="right"
        class="mb-0"
        v-slot="{ ariaDescribedby }"
      >
        <b-form-radio-group
          class="pt-2"
          :options="['Air', 'Courier', 'Mail']"
          :aria-describedby="ariaDescribedby"
        ></b-form-radio-group> -->
        <!-- </b-form-group> -->
      </b-form-group>
      <div class="d-flex justify-content-between border-top pt-10">
        <div class="mr-2">
          <button
            @click="onSubmit"
            
            class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
            data-wizard-type="action-prev"
          >
            Create Unit
          </button>
        </div>
        <div>
          <button
            v-on:click="$router.push('unit')"
            class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
            data-wizard-type="action-submit"
          >
            Cancel
          </button>
        </div>
      </div>
      <!-- <span>{{ res }}</span> -->
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
import router from "@/router.js";
export default {
  data() {
    return {
      access_token: localStorage.getItem("Token"),
      // res: "",

      names: "",
      description: "",
      // type: "",
    };
  },
  methods: {
    onSubmit() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/unit",
        data: {
          name: this.names,
          hou: "22",
          departmentid: "1",
          description: this.description,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then(function(response) {
        console.log(JSON.stringify(response.data)),
        router.replace("/unit");

      });
    },
    // onSubmit() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/task?name=new task&startdate=2021-08-25 06:13:16&enddate=2021-08-26 06:13:16&priority=1&description=jhgjhgjhgjhg&upperlevel=1&assigneduserid[0]=1", {
    //       // data: {
    //       //   name: "Unit 13", //this.unit.name,
    //       //   description: "srgdssdf", // this.unit.description,
    //       // },
    //       headers: {
    //         Accept: "application/json",
    //         Authorization: `Bearer ${this.access_token}`,
    //       },
    //     })
    //     .then((response) => {
    //       this.res = response.data;
    //     });
    // },
  },
};
</script>
