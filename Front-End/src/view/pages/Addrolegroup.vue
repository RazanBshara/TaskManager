<template>
  <div class="mt-1">
    <div class="row">
      <div class="col-md-9 ml-30">
        <div class="text-center mb-10 mb-lg-14 mt-14">
          <h3 class="font-size-20 mr-40 pr-20">
            Enter Roles!
          </h3>
        </div>

<!--YYY--begin::Form-->
<div class="col-xl-9">
          <b-form
            class="form"
            @submit.stop.prevent="onSubmit"
            bg-variant="secondary"
          >
<!--YYY--Job Name-->
<b-card bg-variant="secondary">
              <b-form-group
                id="input-group-1"
                label="Role Name"
                label-for="input-1"
              >
                <b-form-input
                  id="input-1"
                  v-model="form.name"
                  placeholder="Enter name"
                  required
                ></b-form-input>
              </b-form-group>

<!--YYY--Job Description-->
<b-form-group
                id="input-group-1"
                label="Adjective"
                label-for="input-1"
              >
                <b-form-textarea
                  id="textarea-rows"
                  placeholder="Describe your Role"
                  rows="6"
                >
                </b-form-textarea>
              </b-form-group>

              

<!--begin::Action-->
<div class="form-group d-flex flex-wrap flex-center">
                <b-button
                  type="submit"
                  v-on:click="$router.push('rolegroup')"
                  pill
                  variant="outline-primary"
                  class="btn btn-primary font-weight-bold px-9 py-4 my-3 font-size-3 mx-4"
                  >Create Rolegroup</b-button
                >
                <b-button
                  type="submit"
                  pill
                  variant="outline-primary"
                  class="btn btn-primary font-weight-bold px-9 py-4 my-3 font-size-3 mx-4"
                  >Cancel</b-button
                >
              </div>
            </b-card>
          </b-form>
        </div>
      </div>

<div class="col-xl-4">
<!--YYYYYYYYYEngageWidget1></EngageWidget1-->
</div>
    </div>

    <div class="row">
      <div class="col-xl-8">
<!--YYYYYYYYYListWidget5></ListWidget5-->
</div>
      <div class="col-xl-4">
<!--YYYYYYYYYYAdvancedTableWidget2></AdvancedTableWidget2-->
</div>
    </div>

    <div class="row">
      <div class="col-xl-8">
<!--YYYYYYYYListWidget3></ListWidget3-->
</div>
      <div class="col-xl-4">
<!--YYYYYYYYListWidget10></ListWidget10-->
</div>
    </div>

    <div class="row">
      <div class="col-xl-4">
<!--YYYYYYYYListWidget11></ListWidget11-->
</div>
      <div class="col-xl-8">
<!--YYYYYYYYListWidget12></ListWidget12-->
</div>
    </div>
    <div class="row">
      <div class="col-lg-8">
<!--YYYYYYYYYListWidget8></ListWidget8-->
</div>
      <div class="col-lg-4">
<!--YYYYYYYYYListWidget2></ListWidget2-->
</div>
    </div>
<!--end::Dashboard-->
</div>
</template>
<script>
export default {
  data() {
    return {
      form: {
        name: "",
        Adjective: "",
      },
      show: true,
    };
  },
};
</script>
