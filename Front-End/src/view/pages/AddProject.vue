<template>
  <div>
    <div>
      <b-nav class="mx-1">
        <b-nav-item class="text-muted" v-on:click="$router.push('projects')">
          <b-icon icon="chevron-left"></b-icon>
          PROJECTS
        </b-nav-item>
        <br /><br /><br />
        <b-item class="font-size-h1 font-weight-weight">New Project</b-item>
      </b-nav>
    </div>

    <div class="card card-custom">
      <div class="card-body p-0">
        <!--begin: Wizard-->
        <div
          class="wizard wizard-2"
          id="kt_wizard_v2"
          data-wizard-state="step-first"
          data-wizard-clickable="true"
        ></div>
      </div>
      <!--end: Wizard Nav -->

      <!--begin: Wizard Body -->
      <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
        <!--begin: Wizard Form-->
        <div class="row">
          <div class="offset-xxl-2 col-xxl-8">
            <form class="form" id="kt_form">
              <!--begin: Wizard Step 1-->
              <div
                class="pb-5"
                data-wizard-type="step-content"
                data-wizard-state="current"
              >
                <h4 class="mb-10 font-weight-bold text-dark">
                  Enter your Project Details
                </h4>
                <!--YYYYYYYYYYYY projects name-->
                <div class="form-group">
                  <label>Project Name*</label>
                  <input
                    type="text"
                    v-model="project.name"
                    class="form-control form-control-solid form-control-lg"
                    name="fname"
                    placeholder="Enter Name"
                  />
                </div>
                <!--YYYYYYYYYYYY projects description-->
                <div class="form-group">
                  <label>Description</label>
                  <b-form-textarea
                    id="textarea-rows"
                    v-model="project.description"
                    class="form-control form-control-solid form-control-lg"
                    placeholder="Describe your Project.."
                    rows="6"
                  >
                  </b-form-textarea>
                </div>
                <div>
                  <!--YYYYYYYYYYYYYYYYYYY Via multiple directive modifiers -->
                  <div>
                    <b-nav class="mx-0 mr-5 pr-5 col-md-6 py-1">
                      <b-nav-item v-b-toggle="'collapse-a collapse-b'"
                        >show more options</b-nav-item
                      >
                    </b-nav>
                  </div>
                  <!-- Elements to collapse -->
                  <div class="mx-0 mr-4">
                    <b-collapse id="collapse-a" class="mt-2">
                      <div class="form-group">
                        <label class="font-weight-bold text-dark"
                          >Select Project Manager</label
                        >
                        <!-- <b-nav class="mx-1 mt-2"> -->
                        <div>
                          <b-form-select
                            v-model="selected"
                            :select="select"
                            class="mb-3"
                            value-field="item"
                            text-field="name"
                          ></b-form-select>
                        </div>
                      </div>
                      <!--YYYYYYYYYYYYYYY start date-->
                      <div class="row">
                        <div class="col-xl-6">
                          <div class="form-group">
                            <label
                              class="font-weight-bold text-dark"
                              for="datepicker-buttons"
                              >Start Date</label
                            >
                            <b-form-datepicker
                              id="datepicker-buttons"
                              v-model="project.startdate"
                              today-button
                              reset-button
                              close-button
                              locale="en"
                              class="mb-2"
                            ></b-form-datepicker>
                          </div>
                        </div>
                        <!--YYYYYYYYYYYYYYY end date-->
                        <div class="col-xl-6">
                          <div class="form-group">
                            <label
                              class="font-weight-bold text-dark"
                              for="datepicker-buttons"
                              >End Date</label
                            >
                            <b-form-datepicker
                              id="datepicker-buttons"
                              v-model="project.startdate"
                              today-button
                              reset-button
                              close-button
                              locale="en"
                              class="mb-2"
                            ></b-form-datepicker>
                          </div>
                        </div>
                      </div>

                      <!--YYYYYYYYYYYYYYY label-->

                      <b-item class="p-5 font-weight-bold ">Label</b-item>
                      <b-nav class="mx-1 mt-2">
                        <b-dropdown
                          split
                          split-variant="outline-primary"
                          variant="primary"
                          text="Choose a label..."
                          class="mr-5 pr-5 col-xl-3"
                        >
                          <b-form-group
                            label=""
                            v-slot="{ ariaDescribedby }"
                            class="m-5"
                          >
                            <b-form-radio
                              v-model="selected"
                              :aria-describedby="ariaDescribedby"
                              name="some-radios"
                              value="A"
                              >No label..</b-form-radio
                            >
                            <b-form-radio
                              v-model="selected"
                              :aria-describedby="ariaDescribedby"
                              name="some-radios"
                              value="B"
                              >Canceled</b-form-radio
                            >
                            <b-form-radio
                              v-model="selected"
                              :aria-describedby="ariaDescribedby"
                              name="some-radios"
                              value="C"
                              >In Progress</b-form-radio
                            >
                            <b-form-radio
                              v-model="selected"
                              :aria-describedby="ariaDescribedby"
                              name="some-radios"
                              value="D"
                              >New</b-form-radio
                            >
                            <b-form-radio
                              v-model="selected"
                              :aria-describedby="ariaDescribedby"
                              name="some-radios"
                              value="E"
                              >Paused</b-form-radio
                            >
                          </b-form-group>
                        </b-dropdown>
                      </b-nav>

                      <br />
                      <br />
                      <!--YYYYYYYYYYYYYYY Category-->
                      <b-item class="p-5 font-weight-bold">Category</b-item>
                      <b-nav class="mx-1 mt-2">
                        <b-dropdown
                          split
                          split-variant="outline-primary"
                          variant="primary"
                          text="Choose a category..."
                          class="mr-5 pr-5 col-xl-4"
                        >
                          <b-form-group
                            class="m-5"
                            v-slot="{ ariaDescribedby }"
                          >
                            <b-form-radio
                              v-model="selected"
                              :aria-describedby="ariaDescribedby"
                              name="some-radios"
                              value="A"
                              >No Category..</b-form-radio
                            >
                          </b-form-group>
                        </b-dropdown>
                      </b-nav>

                      <!-- <b-item class="font-weight-bold">Time Tracking</b-item>
                      <b-form-checkbox switch size="md" class="mt-4"
                        >Enable time tracking</b-form-checkbox
                      >
                      <b-form-checkbox switch size="md"
                        >Allow clients to see time records</b-form-checkbox
                      > -->

                      <!-- <div class="form-group">
                        <label>Job types</label>
                        <select
                          name="country"
                          class="form-control form-control-md"
                        >
                          <option value="">Select</option>
                        </select>
                      </div> -->
                    </b-collapse>
                  </div>
                </div>
              </div>
              <!--end: Wizard Step 1-->

              <!--begin: Wizard Step 6-->

              <!--end: Wizard Step 6-->

              <!--begin: Wizard Actions -->
              <div class="d-flex justify-content-between border-top pt-10">
                <div class="mr-2">
                  <button
                    @click="onSubmit"
                    class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                    data-wizard-type="action-prev"
                  >
                    Create Project
                  </button>
                </div>
                <div>
                  <button
                    v-on:click="$router.push('projects')"
                    class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                    data-wizard-type="action-submit"
                  >
                    Cancel
                  </button>
                </div>
              </div>
              <!--end: Wizard Actions -->
            </form>
          </div>
          <!--end: Wizard-->
        </div>
      </div>
      <!--end: Wizard Body -->
    </div>
  </div>
  <!--end: Wizard-->
  <!--/div>
  </div-->
</template>

<style lang="scss">
@import "@/assets/sass/pages/wizard/wizard-2.scss";
</style>

<script>
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import KTUtil from "@/assets/js/components/util";
import KTWizard from "@/assets/js/components/wizard";
import Swal from "sweetalert2";
import axios from "axios";
import router from "@/router.js";

export default {
  name: "Wizard-2",
  data() {
    return {
      project: {
        name: "",
        description: "",
        startdate: "",
        enddate: "",
      },
      selected: null, // Must be an array reference!
      options: [
        { text: "InProgress", value: "no label" },
        { text: "InProgress", value: "inprogress" },
        { text: "Canceled", value: "canceled" },
        { text: "New", value: "new" },
        { text: "Paused", value: "paused" },
      ],
      show: true,
      parenttask: "",
      select: null,
    };
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      { title: "Wizard", route: "wizard-1" },
      { title: "Wizard-2" },
    ]);

    // Initialize form wizard
    const wizard = new KTWizard("kt_wizard_v2", {
      startStep: 1, // initial active step number
      clickableSteps: true, // allow step clicking
    });

    // Validation before going to next page
    wizard.on("beforeNext", function(/*wizardObj*/) {
      // validate the form and use below function to stop the wizard's step
      // wizardObj.stop();
    });

    // Change event
    wizard.on("change", function(/*wizardObj*/) {
      setTimeout(() => {
        KTUtil.scrollTop();
      }, 500);
    });
  },
  methods: {
    submit: function(e) {
      e.preventDefault();
      Swal.fire({
        title: "",
        text: "Your Project has been successfully Created!",
        icon: "success",
        confirmButtonClass: "btn btn-secondary",
      });
    },
    onSubmit() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/project",
        data: {
          name: this.names,
          description: this.description,
        },
        headers: {
          Accept: "application/json",
        },
      }).then(function(response) {
        console.log(JSON.stringify(response.data)), router.replace("/projects");
      });
    },
  },
};
</script>
