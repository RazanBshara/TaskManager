<template>
  <div class="card card-custom">
    <div class="card-body p-0">
      <!--begin: Wizard-->
      <div
        class="wizard wizard-2"
        id="kt_wizard_v2"
        data-wizard-state="step-first"
        data-wizard-clickable="true"
      >
        <!--begin: Wizard Nav -->
        <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
          <div class="wizard-steps">
            <div
              class="wizard-step"
              data-wizard-type="step"
              data-wizard-state="current"
            >
              <div class="wizard-wrapper">
                <div class="wizard-icon">
                  <span class="svg-icon svg-icon-2x">
                    <inline-svg src="media/svg/icons/General/User.svg" />
                  </span>
                </div>
                <div class="wizard-label">
                  <h3 class="wizard-title">
                    Account Settings
                  </h3>
                  <div class="wizard-desc">
                    Setup Your Account Details
                  </div>
                </div>
              </div>
            </div>
            <div class="wizard-step" data-wizard-type="step">
              <div class="wizard-wrapper">
                <div class="wizard-icon">
                  <span class="svg-icon svg-icon-2x">
                    <inline-svg src="media/svg/icons/Map/Compass.svg" />
                  </span>
                </div>
                <div class="wizard-label">
                  <h3 class="wizard-title">
                    Company Details
                  </h3>
                  <div class="wizard-desc">
                    Add Your Company Information
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="wizard-step" href="#" data-wizard-type="step">
              <div class="wizard-wrapper">
                <div class="wizard-icon">
                  <span class="svg-icon svg-icon-2x">
                    <inline-svg
                      src="media/svg/icons/General/Thunder-move.svg"
                    />
                  </span>
                </div>
                <div class="wizard-label">
                  <h3 class="wizard-title">
                    Support Channels
                  </h3>
                  <div class="wizard-desc">
                    Add Your Support Agents
                  </div>
                </div>
              </div>
            </div> -->
            <!-- <div class="wizard-step" data-wizard-type="step">
              <div class="wizard-wrapper">
                <div class="wizard-icon">
                  <span class="svg-icon svg-icon-2x">
                    <inline-svg src="media/svg/icons/Map/Position.svg" />
                  </span>
                </div>
                <div class="wizard-label">
                  <h3 class="wizard-title">
                    Set Your Delivery Address
                  </h3>
                  <div class="wizard-desc">
                    Address, Street, City, State
                  </div>
                </div>
              </div>
            </div> -->
            <!-- <div class="wizard-step" data-wizard-type="step">
              <div class="wizard-wrapper">
                <div class="wizard-icon">
                  <span class="svg-icon svg-icon-2x">
                    <inline-svg
                      src="media/svg/icons/Shopping/Credit-card.svg"
                    />
                  </span>
                </div>
                <div class="wizard-label">
                  <h3 class="wizard-title">
                    Make Payment
                  </h3>
                  <div class="wizard-desc">
                    Use Credit or Debit Cards
                  </div>
                </div>
              </div>
            </div> -->
            <!-- <div class="wizard-step" data-wizard-type="step">
              <div class="wizard-wrapper">
                <div class="wizard-icon">
                  <span class="svg-icon svg-icon-2x">
                    <inline-svg src="media/svg/icons/General/Like.svg" />
                  </span>
                </div>
                <div class="wizard-label">
                  <h3 class="wizard-title">
                    Completed!
                  </h3>
                  <div class="wizard-desc">
                    Review and Submit
                  </div>
                </div>
              </div>
            </div> -->
          </div>
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
                    Enter your Account Details
                  </h4>
                  <div class="form-group">
                    <label>First Name*</label>
                    <input
                      type="text"
                      class="form-control form-control-solid form-control-lg"
                      name="fname"
                      placeholder="First Name"
                      value="John"
                    />
                    <span class="form-text text-muted"
                      >Please enter your first name.</span
                    >
                  </div>
                  <div class="form-group">
                    <label>Last Name*</label>
                    <input
                      type="text"
                      class="form-control form-control-solid form-control-lg"
                      name="lname"
                      placeholder="Last Name"
                      value="Wick"
                    />
                    <span class="form-text text-muted"
                      >Please enter your last name.</span
                    >
                  </div>
                  <div class="row">
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Phone*</label>
                        <input
                          type="tel"
                          class="form-control form-control-solid form-control-lg"
                          name="phone"
                          placeholder="phone"
                          value="+61412345678"
                        />
                        <span class="form-text text-muted"
                          >Please enter your phone number.</span
                        >
                      </div>
                    </div>
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Email*</label>
                        <input
                          type="email"
                          class="form-control form-control-solid form-control-lg"
                          name="email"
                          placeholder="Email"
                          value="john.wick@reeves.com"
                        />
                        <span class="form-text text-muted"
                          >Please enter your email address.</span
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <!--end: Wizard Step 1-->

                <!--begin: Wizard Step 2-->
                <div class="pb-5" data-wizard-type="step-content">
                  <h4 class="mb-10 font-weight-bold text-dark">
                    Setup Your Company Information
                  </h4>
                  <div class="row">
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Company Name*</label>
                        <input
                          type="text"
                          class="form-control form-control-solid form-control-lg"
                          name="address1"
                          placeholder=""
                          value=""
                        />
                        <span class="form-text text-muted"
                          >Please enter your Company Name.</span
                        >
                      </div>
                    </div>
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>phone Number*</label>
                        <input
                          type="text"
                          class="form-control form-control-solid form-control-lg"
                          name="address2"
                          placeholder=""
                          value=""
                        />
                        <span class="form-text text-muted"
                          >Please enter your Phone Number.</span
                        >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Company Description*</label>
                        <b-form-textarea
                          id="textarea-rows"
                          type="text"
                          class="form-control form-control-solid form-control-lg"
                          name="postcode"
                          placeholder=""
                          value=""
                        />
                        <span class="form-text text-muted"
                          >Please enter your Company Description.</span
                        >
                      </div>
                    </div>
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label>Members</label>
                        <input
                          type="text"
                          class="form-control form-control-solid form-control-lg"
                          name="members"
                          placeholder=""
                          value=""
                        />
                      </div>
                    </div>
                    <!-- <div class="col-xl-6">
                      <div class="form-group">
                        <label>City</label>
                        <input
                          type="text"
                          class="form-control form-control-solid form-control-lg"
                          name="city"
                          placeholder="City"
                          value="Melbourne"
                        />
                        <span class="form-text text-muted"
                          >Please enter your City.</span
                        >
                      </div>
                    </div> -->
                  </div>
                  <div>
                    <label>Company Type*</label>

                    <b-form-select
                      v-model="selected"
                      :options="options"
                    ></b-form-select>
                  </div>
                </div>
                <!--end: Wizard Step 2-->

                <!--end: Wizard Step 3-->

                <!--begin: Wizard Actions -->
                <div class="d-flex justify-content-between border-top pt-10">
                  <div class="mr-2">
                    <button
                      class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                      data-wizard-type="action-prev"
                    >
                      Previous
                    </button>
                  </div>
                  <div>
                    <button
                      v-on:click="submit"
                      class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                      data-wizard-type="action-submit"
                    >
                      Submit
                    </button>
                    <button
                      class="btn btn-primary font-weight-bold text-uppercase px-9 py-4"
                      data-wizard-type="action-next"
                    >
                      Next Step
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
      <!--end: Wizard-->
    </div>
  </div>
</template>

<style lang="scss">
@import "@/assets/sass/pages/wizard/wizard-2.scss";
</style>

<script>
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import KTUtil from "@/assets/js/components/util";
import KTWizard from "@/assets/js/components/wizard";
import Swal from "sweetalert2";
import FormTextarea from "./vue-bootstrap/FormTextarea.vue";

export default {
  data() {
    return {
      selected: null,
      options: [
        { value: null, text: "Please select an option" },
        { value: "a", text: "This is First option" },
        { value: "b", text: "Selected Option" },
        { value: { C: "3PO" }, text: "This is an option with object value" },
        { value: "d", text: "This one is disabled", disabled: true },
      ],
    };
  },

  name: "Wizard-2",
  mounted() {
    FormTextarea;
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
        text: "The application has been successfully submitted!",
        icon: "success",
        confirmButtonClass: "btn btn-secondary",
      });
    },
  },
};
</script>
