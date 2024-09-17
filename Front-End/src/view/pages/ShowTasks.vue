<template>
  <div class="card card-custom bg-light">
    <div class="card-body p-0">
      <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
        <div class="col-xl-12 col-xxl-7">
          <form class="form" id="kt_form">
            <div class="pb-5" data-wizard-type="step-content">
              <h4 class="mb-18 font-weight-bold text-primary">
                Show Your Task
              </h4>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Task Name :  {{mytask[0].name}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Description*:  {{mytask[0].description}}
                </div>
                <!-- <div class="line-height-md">
                  Package: Complete Workstation (Monitor, Computer, Keyboard &
                  Mouse)
                  <br />
                  Weight: 25kg <br />
                  Dimensions: 110cm (w) x 90cm (h) x 150cm (L)
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Start Date*: {{mytask[0].startdate}}
                </div>
                <!-- <div class="line-height-md">
                  Overnight Delivery with Regular Packaging
                  <br />
                  Preferred Morning (8:00AM - 11:00AM) Delivery
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  End Date*: {{mytask[0].enddate}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                  <br />
                  Address Line 2 <br />
                  Preston 3072, VIC, Australia
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Type Of Project*: {{mytask[0].type}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                  <br />
                  Address Line 2 <br />
                  Preston 3072, VIC, Australia
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Priority*: {{mytask[0].priority}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                  <br />
                  Address Line 2 <br />
                  Preston 3072, VIC, Australia
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Created By*: {{mytask[0].CreatedBy}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                  <br />
                  Address Line 2 <br />
                  Preston 3072, VIC, Australia
                </div> -->
              </div>
              <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Parent Task*: {{mytask[0].ParentTask}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                  <br />
                  Address Line 2 <br />
                  Preston 3072, VIC, Australia
                </div> -->
              </div>
              <div class="mb-5">
                <div class="font-weight-bold mb-3 text-dark">
                  Depend On Task*: {{mytask[0].DependOnTask}}
                </div>
                <!-- <div class="line-height-md">
                  Address Line 1
                  <br />
                  Address Line 2 <br />
                  Preston 3072, VIC, Australia
                </div> -->
              </div>
              <div class="d-flex justify-content-between border-top pt-10">
                <div class="mr-2">
                  <button
                    v-on:click="$router.push('tasks')"
                    class="btn btn-light-primary font-weight-bold text-uppercase px-6 py-2"
                    data-wizard-type="action-prev"
                  >
                    <b-icon
                      v-b-toggle.sidebar-variant
                      icon="chevron-double-left"
                    ></b-icon>
                    Previous
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- <span>{{mytask}}</span> -->
    </div>
  </div>
</template>

<script>
import axios from "axios";
// import router from "@/router.js";
export default {
  data() {
    return {
      mytask:{},
      taskid: localStorage.getItem("taskid"),
      task: {
        name: "",
        description: "",
        parenttask: "",
        dependontask: "",
        type: "",
      },
    };
  },
  created: function(){
      axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/task/${this.taskid}`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.mytask = response.data;
    });
  }
};
</script>
